<?php

declare(strict_types=1);

/**
 * Deploy hook untuk strategi deploy FTP + zip.
 * Dipanggil via HTTP: https://sayyidarifsegoropuro.com/deploy-hook.php?token=...
 *
 * Alur:
 *  1. Validasi token dari .env (DEPLOY_HOOK_TOKEN).
 *  2. Ekstrak deploy.zip (ZipArchive -> PharData -> unzip) menimpa kode lama.
 *  3. Hapus file peninggalan sistem deploy lama (index slim di docroot).
 *  4. Pastikan struktur storage/ tersedia.
 *  5. Reset opcache.
 *  6. Jalankan artisan: migrate, storage:link, seed (hanya saat tabel kosong),
 *     optimize:clear + config/route/view cache, queue:restart.
 *  7. Respon 200 = sukses, 500 = error.
 */

header('Content-Type: application/json; charset=utf-8');

$root = __DIR__;

function hookFail(string $message): void
{
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

if ($token === null || !hash_equals($token, (string) ($_GET['token'] ?? ''))) {
    http_response_code(403);
    echo json_encode(['ok' => false, 'error' => 'invalid token'], JSON_UNESCAPED_SLASHES);
    exit(1);
}

set_time_limit(300);
ignore_user_abort(true);

$zipPath = $root . '/deploy.zip';

// 1) Ekstrak deploy.zip menimpa kode lama.
if (is_file($zipPath)) {
    $extracted = false;

    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();

        if ($zip->open($zipPath) === true) {
            $extracted = $zip->extractTo($root);
            $zip->close();
        }
    }

    if (!$extracted && class_exists('PharData')) {
        try {
            $phar = new PharData($zipPath);
            $phar->extractTo($root, null, true);
            $extracted = true;
        } catch (Throwable) {
            $extracted = false;
        }
    }

    if (!$extracted && function_exists('exec')) {
        exec('unzip -o -q ' . escapeshellarg($zipPath) . ' -d ' . escapeshellarg($root) . ' 2>&1', $output, $code);
        $extracted = $code === 0;
    }

    if (!$extracted) {
        hookFail('Gagal mengekstrak deploy.zip (ZipArchive/PharData/unzip tidak tersedia atau arsip rusak)');
    }

    @unlink($zipPath);
}

// 2) Hapus index.php peninggalan sistem deploy lama (index slim di docroot).
if (is_file($root . '/index.php')) {
    @unlink($root . '/index.php');
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
require $root . '/vendor/autoload.php';

$app = require $root . '/bootstrap/app.php';

/** @var \Illuminate\Contracts\Console\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$steps = [];

try {
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
    $kernel->terminate();
    hookFail('Artisan error: ' . $e->getMessage());
}

$kernel->terminate();
$app->terminate();

echo json_encode(['ok' => true, 'steps' => $steps], JSON_UNESCAPED_SLASHES);