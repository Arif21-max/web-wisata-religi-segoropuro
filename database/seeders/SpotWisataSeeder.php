<?php

namespace Database\Seeders;

use App\Models\SpotWisata;
use Illuminate\Database\Seeder;

class SpotWisataSeeder extends Seeder
{
    public function run(): void
    {
        if (SpotWisata::exists()) {
            return;
        }

        SpotWisata::create([
            'nama_spot' => 'Area Makam Utama',
            'deskripsi_singkat' => 'Tempat peziarah memanjatkan doa khusyuk.',
            'deskripsi_lengkap' => 'Area makam utama merupakan pusat peziarahan tempat pengunjung memanjatkan doa. Dikelilingi arsitektur bernuansa klasik, tempat ini menyediakan area kekhusyukan dan kenyamanan bagi peziarah individual maupun rombongan.',
            'warna_bg' => '#2c3e50',
            'foto' => 'uploads/makam.jpg,uploads/pendopo.jpg,uploads/sejarah.jpg',
        ]);

        SpotWisata::create([
            'nama_spot' => 'Masjid Segoropuro',
            'deskripsi_singkat' => 'Pusat ibadah dan kajian keagamaan.',
            'deskripsi_lengkap' => 'Pusat ibadah dan kajian keagamaan warga sekitar dan peziarah. Masjid ini memiliki fasilitas shalat yang luas, area wudhu yang bersih, serta suasana maghrib/isya yang khidmat.',
            'warna_bg' => '#34495e',
            'foto' => 'uploads/masjid.jpg,uploads/hero.jpg',
        ]);

        SpotWisata::create([
            'nama_spot' => 'Area Souvenir & UMKM',
            'deskripsi_singkat' => 'Pusat oleh-oleh khas dan produk lokal.',
            'deskripsi_lengkap' => 'Area perbelanjaan UMKM warga lokal Segoropuro yang menyediakan aneka cenderamata, perlengkapan ibadah, makanan khas, dan oleh-oleh ziarah.',
            'warna_bg' => '#27ae60',
            'foto' => 'uploads/souvenir.jpg',
        ]);
    }
}
