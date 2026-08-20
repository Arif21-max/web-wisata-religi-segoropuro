# Portal Wisata Religi Makam Sayyid Arif Segoropuro (Laravel 13)

Website portal informasi wisata religi desa & Sistem Manajemen Konten (CMS) — **hasil migrasi dari PHP prosedural ke Laravel 13**.

## Teknologi

- **Laravel 13** (PHP 8.3+, Eloquent ORM, Blade, Vite)
- **MySQL** 8 (database utama)
- **Tailwind CSS v4 + Alpine.js** (tampilan baru yang responsif)
- Font Awesome (ikon)

## Kebutuhan Environment

- PHP 8.3+ (disarankan **Laragon** yang sudah memuat PHP 8.3 & MySQL)
- Composer 2
- Node.js 20+ (untuk build aset frontend)
- MySQL 8 (database `db_segoropuro`)

## Cara Menjalankan (Laragon / CLI)

```bash
# 1. Install dependensi
composer install
npm install

# 2. Konfigurasi
copy .env.example .env        # Windows
php artisan key:generate

# 3. Atur .env lalu buat database MySQL
#    DB_CONNECTION=mysql, DB_DATABASE=db_segoropuro, DB_USERNAME=root, DB_PASSWORD=

# 4. Migrasi + seed data contoh
php artisan migrate --seed

# 5. Tautkan storage untuk upload gambar
php artisan storage:link

# 6. Jalankan server
php artisan serve
# lalu buka http://127.0.0.1:8000

# (opsional) saat pengembangan tampilan, jalankan di terminal lain:
npm run dev
```

## Akses

- **Halaman Publik**: `http://127.0.0.1:8000/`
- **Login Admin**: `http://127.0.0.1:8000/admin/login`
- **Health Check**: `http://127.0.0.1:8000/up`

### Membuat Akun Admin Pertama

```bash
php artisan tinker --execute="App\Models\User::create(['name' => 'Nama Anda', 'username' => 'admin', 'email' => 'admin@segoropuro.local', 'password' => 'PASSWORD-KUAT-UNIK']);"
```

> **Penting:** gunakan password kuat yang unik, jangan pernah memakai `admin123` atau kata sandi sederhana. Kolom password otomatis di-hash bcrypt (12 rounds).

## Struktur Utama

```
app/
├── Console/Commands/ImportLegacyData.php   # impor data dari aplikasi lama (SQLite)
├── Http/Controllers/                       # kontroller publik + admin
│   ├── Admin/                              # dashboard, artikel, berita, spot, buku tamu, barang hilang
│   └── ...Controller.php                   # home, sejarah, spot-wisata, berita, buku-tamu, barang-hilang
├── Http/Middleware/CatatPengunjung.php     # pencatat statistik pengunjung
├── Models/                                 # Artikel, Berita, SpotWisata, BukuTamu, BarangHilang, StatistikPengunjung
├── Support/UploadHelper.php                # helper upload & hapus file
└── helpers.php                             # media_url, wa_url, unique_slug
database/migrations/                        # skema tabel (semua via migration)
database/seeders/                           # data contoh (artikel, berita, spot, buku tamu, barang hilang)
resources/views/
├── layouts/                                # layout publik & admin
├── components/                             # kartu spot, ulasan, pagination, dll.
├── pages/                                  # halaman publik
└── admin/                                  # halaman admin
routes/web.php                              # semua rute
config/segoropuro.php                       # nomor WhatsApp, tautan Google Maps
```

## Pengaturan

- **Nomor WhatsApp** & pesan default: ubah di `.env` (`WHATSAPP_NUMBER`, `WHATSAPP_DEFAULT_MESSAGE`).
- **Tautan Google Maps**: `config/segoropuro.php` → `google_maps_embed`.
- Foto upload tersimpan di `storage/app/public/uploads/` (via `storage:link`).

## Keamanan

- **Saat produksi (HTTPS)**: pastikan di `.env` bernilai `APP_ENV=production`, `APP_DEBUG=false`, dan `SESSION_SECURE_COOKIE=true`. Saat menguji lewat `http://localhost`, set `SESSION_SECURE_COOKIE=false` agar cookie session tetap tersimpan.
- **Login admin**: rate limit 5 percobaan per username+IP (lockout 60 detik). Selalu gunakan password kuat.
- **IP pengunjung**: disimpan sebagai hash HMAC (`APP_KEY` sebagai kunci), bukan IP mentah — data statistik tetap terhitung unik tanpa menyimpan data pribadi. Jika `APP_KEY` diubah, penghitungan pengunjung lama tidak lagi terkait dengan pengunjung baru.
- **Upload file**: ekstensi disimpan berdasarkan MIME asli di server (whitelist gambar), nama file acak.
- **Embed Google Maps**: hanya iframe/URL dari `google.com/maps` (HTTPS) yang disimpan, atribut lain di-strip.
- **Security headers** aktif otomatis: `Content-Security-Policy`, `X-Content-Type-Options`, `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`.
- **Trusted proxies**: range private (localhost, RFC1918) dipercaya untuk `X-Forwarded-For`/`X-Forwarded-Proto`. Jika memakai CDN/load balancer dengan IP publik, tambahkan IP-nya di `bootstrap/app.php`.

## Catatan Migrasi

- Data dari aplikasi lama dapat diimpor dengan: `php artisan app:import-legacy`
  (membaca `db_segoropuro.sqlite` lama, menyalin foto, dan memetakan path gambar).
- Bug lama sudah diperbaiki: pencarian literasi sejarah, slug unik, proteksi CSRF + rate limiting login, penghapusan file yatim, nomor WhatsApp terpusat, validasi form ramah pengguna, dan pagination.
- Tabel `galeri` (tidak terpakai) tidak dipertahankan.

&copy; 2026 Desa Segoropuro. All Rights Reserved.

# web-wisata-religi-segoropuro
