<?php

namespace App\Console\Commands;

use App\Models\Artikel;
use App\Models\BarangHilang;
use App\Models\Berita;
use App\Models\BukuTamu;
use App\Models\SpotWisata;
use App\Models\StatistikPengunjung;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDO;
use Throwable;

class ImportLegacyData extends Command
{
    protected $signature = 'app:import-legacy {--sqlite= : Path ke file SQLite aplikasi lama} {--fresh : Kosongkan tabel dulu sebelum import}';

    protected $description = 'Impor data aplikasi lama (SQLite Segoropuro) ke database MySQL';

    private array $tables = ['users', 'artikel', 'spot_wisata', 'berita', 'buku_tamu', 'barang_hilang', 'statistik_pengunjung'];

    public function handle(): int
    {
        $sqlitePath = $this->option('sqlite')
            ?? 'C:/Users/ASUS/Documents/Arif/websegoropuro/segoropuro_agent/database/db_segoropuro.sqlite';

        if (! file_exists($sqlitePath)) {
            $this->error("File SQLite tidak ditemukan: {$sqlitePath}");

            return self::FAILURE;
        }

        if ($this->option('fresh')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            foreach ($this->tables as $table) {
                DB::table($table)->truncate();
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $pdo = new PDO('sqlite:' . $sqlitePath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $legacyAssets = dirname(dirname($sqlitePath)) . '/assets/img';
        $imported = [];

        $this->importUsers($pdo, $imported);
        $this->importArtikel($pdo, $imported);
        $this->importSpotWisata($pdo, $imported, $legacyAssets);
        $this->importBerita($pdo, $imported);
        $this->importBukuTamu($pdo, $imported);
        $this->importBarangHilang($pdo, $imported, $legacyAssets);
        $this->importStatistik($pdo, $imported);

        $this->info('Import selesai:');
        foreach ($imported as $nama => $jumlah) {
            $this->line("  - {$nama}: {$jumlah} baris");
        }

        return self::SUCCESS;
    }

    private function tableHasData(string $table): bool
    {
        return DB::table($table)->exists();
    }

    private function importUsers(PDO $pdo, array &$imported): void
    {
        if ($this->tableHasData('users')) {
            $imported['users'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM admin_users')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            User::create([
                'name' => $row['nama_lengkap'],
                'username' => $row['username'],
                'email' => $row['username'] . '@segoropuro.local',
                'password' => $row['password'],
            ]);
        }
        $imported['users'] = count($rows);
    }

    private function importArtikel(PDO $pdo, array &$imported): void
    {
        if ($this->tableHasData('artikel')) {
            $imported['artikel'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM artikel')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            Artikel::create([
                'judul' => $row['judul'],
                'slug' => $row['slug'],
                'kategori' => $row['kategori'],
                'penulis' => $row['penulis'],
                'konten' => $row['konten'],
                'kutipan' => $row['kutipan'],
                'gambar' => $this->rewritePath($row['gambar']),
            ]);
        }
        $imported['artikel'] = count($rows);
    }

    private function importSpotWisata(PDO $pdo, array &$imported, string $legacyAssets): void
    {
        if ($this->tableHasData('spot_wisata')) {
            $imported['spot_wisata'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM spot_wisata')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $paths = array_filter(array_map('trim', explode(',', (string) $row['foto'])));
            $foto = implode(',', array_map(fn ($p) => $this->rewritePath($p), $paths));

            SpotWisata::create([
                'nama_spot' => $row['nama_spot'],
                'deskripsi_singkat' => $row['deskripsi_singkat'],
                'deskripsi_lengkap' => $row['deskripsi_lengkap'],
                'warna_bg' => $row['warna_bg'],
                'foto' => $foto,
            ]);
        }
        $this->copyReferencedImages($rows, $legacyAssets);
        $imported['spot_wisata'] = count($rows);
    }

    private function importBerita(PDO $pdo, array &$imported): void
    {
        if ($this->tableHasData('berita')) {
            $imported['berita'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM berita')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            Berita::create([
                'judul' => $row['judul'],
                'slug' => $row['slug'],
                'kategori' => $row['kategori'],
                'tanggal_kegiatan' => $row['tanggal_kegiatan'],
                'penulis' => $row['penulis'],
                'ringkasan' => $row['ringkasan'],
                'konten' => $row['konten'],
                'gambar' => $this->rewritePath($row['gambar']),
            ]);
        }
        $imported['berita'] = count($rows);
    }

    private function importBukuTamu(PDO $pdo, array &$imported): void
    {
        if ($this->tableHasData('buku_tamu')) {
            $imported['buku_tamu'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM buku_tamu')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            BukuTamu::create([
                'nama' => $row['nama'],
                'asal_kota' => $row['asal_kota'],
                'pesan_doa' => $row['pesan_doa'],
            ]);
        }
        $imported['buku_tamu'] = count($rows);
    }

    private function importBarangHilang(PDO $pdo, array &$imported, string $legacyAssets): void
    {
        if ($this->tableHasData('barang_hilang')) {
            $imported['barang_hilang'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM barang_hilang')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            BarangHilang::create([
                'nama_barang' => $row['nama_barang'],
                'deskripsi' => $row['deskripsi'],
                'lokasi_ditemukan' => $row['lokasi_ditemukan'],
                'tanggal_ditemukan' => $row['tanggal_ditemukan'],
                'status' => $row['status'],
                'konten_kontak' => $row['konten_kontak'],
                'foto' => $this->rewritePath($row['foto']),
            ]);
        }
        $this->copyReferencedImages($rows, $legacyAssets);
        $imported['barang_hilang'] = count($rows);
    }

    private function importStatistik(PDO $pdo, array &$imported): void
    {
        if ($this->tableHasData('statistik_pengunjung')) {
            $imported['statistik_pengunjung'] = 'dilewati (sudah ada data)';

            return;
        }

        $rows = $pdo->query('SELECT * FROM statistik_pengunjung')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            StatistikPengunjung::create([
                'ip_address' => hash_hmac('sha256', (string) $row['ip_address'], (string) config('app.key')),
                'tanggal' => $row['tanggal'],
                'hits' => $row['hits'],
            ]);
        }
        $imported['statistik_pengunjung'] = count($rows);
    }

    private function rewritePath(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'assets/img/')) {
            return 'uploads/' . basename($path);
        }

        return $path;
    }

    private function copyReferencedImages(array $rows, string $legacyAssets): void
    {
        foreach ($rows as $row) {
            $foto = (string) ($row['foto'] ?? '');
            foreach (array_filter(array_map('trim', explode(',', $foto))) as $path) {
                $this->copyImage($path, $legacyAssets);
            }
        }
    }

    private function copyImage(string $path, string $legacyAssets): void
    {
        if (! str_starts_with($path, 'assets/img/')) {
            return;
        }

        $nama = basename($path);
        $source = $legacyAssets . DIRECTORY_SEPARATOR . $nama;

        if (! file_exists($source)) {
            $this->warn("  foto tidak ditemukan: {$path}");

            return;
        }

        Storage::disk('public')->putFileAs('uploads', $source, $nama);
        $this->line("  disalin: {$nama}");
    }
}
