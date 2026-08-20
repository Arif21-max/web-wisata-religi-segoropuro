<?php

declare(strict_types=1);

/**
 * Deploy hook untuk strategi deploy FTP + zip.
 * Dipanggil via HTTP: https://sayyidarifsegoropuro.com/deploy-hook.php?token=...
 *
 * Alur:
 *  1. Validasi token dari .env (DEPLOY_HOOK_TOKEN).
 *  2. Ekstrak deploy.zip (ZipArchive -> PharData -> unzip) menimpa kode lama.
 *  3. Pastikan ada slim index.php di docroot (fallback bila .htaccess tidak dieksekusi).
 *  4. Pastikan struktur storage/ tersedia.
 *  5. Reset opcache.
 *  6. Jalankan artisan: migrate, storage:link, seed (hanya saat tabel kosong),
 *     optimize:clear + config/route/view cache, queue:restart.
 *  7. Catat semua langkah ke storage/logs/deploy.log.
 *  8. Respon 200 = sukses, 500 = error.
 */

header('Content-Type: application/json; charset=utf-8');

$root = __DIR__;

function deployLog(string $message): void
{
    $logDir = __DIR__ . '/storage/logs';
    if (!is_dir($logDir)) {
        @mkdir($logDir, 0775, true);
    }

    $line = date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL;
    @file_put_contents(__DIR__ . '/storage/logs/deploy.log', $line, FILE_APPEND);
}

function hookFail(string $message): void
{
    deployLog('ERROR: ' . $message);
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $message], JSON_UNESCAPED_SLASHES);
    exit(1);
}

function loadEnvValue(string $path, string $key): ?string
{
    if (!is_file($path)) {
        return null;
    }

    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$k, $v] = explode('=', $line, 2);

        if (trim($k) === $key) {
            return trim(trim($v), '"\'');
        }
    }

    return null;
}

$token = loadEnvValue($root . '/.env', 'DEPLOY_HOOK_TOKEN');

if ($token === null) {
    hookFail('DEPLOY_HOOK_TOKEN belum di-set di ' . $root . '/.env. Tambahkan: DEPLOY_HOOK_TOKEN=<nilai yang sama persis dengan secret DEPLOY_TOKEN di GitHub>.');
}

if (! hash_equals($token, (string) ($_GET['token'] ?? ''))) {
    deployLog('Token ditolak: DEPLOY_HOOK_TOKEN di .env tidak cocok dengan DEPLOY_TOKEN di GitHub.');
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'invalid token'], JSON_UNESCAPED_SLASHES);
    exit(1);
}

deployLog('Mulai deploy (token valid).');

set_time_limit(300);
ignore_user_abort(true);

$zipPath = $root . '/deploy.zip';

// 1) Ekstrak deploy.zip menimpa kode lama.
if (is_file($zipPath)) {
    $extracted = false;
    $method = '';

    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();

        if ($zip->open($zipPath) === true) {
            $extracted = $zip->extractTo($root);
            $zip->close();
            $method = 'ZipArchive';
        }
    }

    if (! $extracted && class_exists('PharData')) {
        try {
            $phar = new PharData($zipPath);
            $phar->extractTo($root, null, true);
            $extracted = true;
            $method = 'PharData';
        } catch (Throwable) {
            $extracted = false;
        }
    }

    if (! $extracted && function_exists('exec')) {
        exec('unzip -o -q ' . escapeshellarg($zipPath) . ' -d ' . escapeshellarg($root) . ' 2>&1', $output, $code);
        $extracted = $code === 0;
        $method = 'unzip';
    }

    if (! $extracted) {
        hookFail('Gagal mengekstrak deploy.zip (ZipArchive/PharData/unzip tidak tersedia atau arsip rusak). Lihat storage/logs/deploy.log untuk detail.');
    }

    @unlink($zipPath);
    deployLog('Ekstrak sukses via ' . $method . ', deploy.zip dihapus.');
} else {
    deployLog('deploy.zip tidak ditemukan - lanjut tanpa ekstrak.');
}

// 2) Pastikan slim index.php ada di docroot (fallback bila .htaccess tidak dieksekusi).
$slimIndex = $root . '/index.php';
$slimContent = "<?php\n\n// Slim index (dijaga otomatis oleh deploy-hook).\nrequire __DIR__ . '/public/index.php';\n";
if (! is_file($slimIndex)) {
    @file_put_contents($slimIndex, $slimContent);
    deployLog('Slim index.php dibuat di docroot.');
}

// 3) Pastikan direktori storage tersedia (tidak ikut dalam zip).
$storageDirs = [
    'storage/app/public/uploads',
    'storage/app/private',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/framework/testing',
    'storage/logs',
];

foreach ($storageDirs as $dir) {
    $path = $root . '/' . $dir;

    if (!is_dir($path)) {
        @mkdir($path, 0775, true);
    }
}

// 4) Reset opcache agar kode baru langsung berlaku.
if (function_exists('opcache_reset')) {
    @opcache_reset();
}

// 5) Boot kernel console Laravel dan jalankan perintah artisan.
// Semua error (termasuk saat boot kernel) ditangkap dan dikembalikan sebagai JSON.
register_shutdown_function(function () use ($root): void {
    $error = error_get_last();

    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        $msg = 'PHP fatal: ' . $error['message'] . ' @ ' . $error['file'] . ':' . $error['line'];
        deployLog('ERROR: ' . $msg);
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => $msg], JSON_UNESCAPED_SLASHES);
    }
});

set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

try {
    require $root . '/vendor/autoload.php';

    $app = require $root . '/bootstrap/app.php';

    /** @var \Illuminate\Contracts\Console\Kernel $kernel */
    $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $steps = [];

    $kernel->call('migrate', ['--force' => true]);
    $steps['migrate'] = 'ok';

    if (!file_exists($root . '/public/storage')) {
        $kernel->call('storage:link');
    }
    $steps['storage:link'] = 'ok';

    if ($app->make('db')->table('users')->count() === 0) {
        $kernel->call('db:seed', ['--class' => 'Database\Seeders\UserSeeder', '--force' => true]);
        $steps['seed'] = 'admin default dibuat';
    } else {
        $steps['seed'] = 'skip (users sudah ada)';
    }

    $kernel->call('optimize:clear');
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    $kernel->call('view:cache');
    $kernel->call('queue:restart');
    $steps['optimize'] = 'ok';
} catch (\Throwable $e) {
    try {
        $kernel->terminate();
    } catch (\Throwable) {
    }
    hookFail('Artisan error: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
}

$kernel->terminate();
$app->terminate();

deployLog('Deploy selesai: ' . json_encode($steps, JSON_UNESCAPED_SLASHES));

echo json_encode([
    'ok' => true,
    'steps' => $steps,
    'db' => [
        'driver' => config('database.default'),
        'name' => $app->make('db')->connection()->getDatabaseName(),
    ],
], JSON_UNESCAPED_SLASHES);