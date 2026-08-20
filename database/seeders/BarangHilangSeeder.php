<?php

namespace Database\Seeders;

use App\Models\BarangHilang;
use Illuminate\Database\Seeder;

class BarangHilangSeeder extends Seeder
{
    public function run(): void
    {
        if (BarangHilang::exists()) {
            return;
        }

        BarangHilang::create([
            'nama_barang' => 'Dompet Cokelat & Kartu Identitas',
            'deskripsi' => 'Dompet berisi KTP & STNK atas nama peziarah asal Surabaya. Ditemukan di area parkir bus rombongan.',
            'lokasi_ditemukan' => 'Area Parkir Bus Ziarah',
            'tanggal_ditemukan' => '2026-08-10',
            'status' => BarangHilang::STATUS_BELUM,
            'konten_kontak' => 'Pos Pengamanan Parkir / Satpam Makam',
            'foto' => 'uploads/dompet.jpg',
        ]);

        BarangHilang::create([
            'nama_barang' => 'Kacamata Hitam Frame Hitam',
            'deskripsi' => 'Kacamata gaya dengan wadah kain hitam. Ditemukan di serambi Masjid Segoropuro setelah shalat Dhuhur.',
            'lokasi_ditemukan' => 'Serambi Utama Masjid',
            'tanggal_ditemukan' => '2026-08-11',
            'status' => BarangHilang::STATUS_BELUM,
            'konten_kontak' => 'Pengelola Masjid / Marbot',
            'foto' => 'uploads/kacamata.jpg',
        ]);

        BarangHilang::create([
            'nama_barang' => 'Payung Lipat Biru Tua',
            'deskripsi' => 'Payung lipat otomatis warna biru tua. Ditemukan di sekitar stan souvenir UMKM desa.',
            'lokasi_ditemukan' => 'Area Souvenir UMKM',
            'tanggal_ditemukan' => '2026-08-09',
            'status' => BarangHilang::STATUS_BELUM,
            'konten_kontak' => 'Kantor Pengelola Desa',
            'foto' => 'uploads/payung.jpg',
        ]);
    }
}
