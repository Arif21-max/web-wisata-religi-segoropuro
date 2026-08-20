<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        if (Artikel::exists()) {
            return;
        }

        Artikel::create([
            'judul' => 'Sejarah Sayyid Arif Segoropuro',
            'slug' => 'sejarah-sayyid-arif-segoropuro',
            'kategori' => 'Sejarah Islam',
            'penulis' => 'Admin Desa',
            'konten' => "Sayyid Arif adalah salah satu tokoh penyebar agama Islam yang memiliki jejak perjuangan yang mendalam di wilayah Segoropuro. Beliau mengabdikan hidupnya untuk membimbing masyarakat dalam ajaran kebaikan dan keagamaan.\n\nSilsilah dan Nasab: Beliau dikenal memiliki garis keturunan yang bersambung kepada para tokoh besar penyebar Islam di Nusantara. Jejak peninggalan dan nilai-nilai luhur beliau tetap dijaga oleh generasi penerus hingga saat ini.",
            'kutipan' => 'Menjaga sejarah adalah menjaga identitas dan spiritualitas generasi masa depan.',
            'gambar' => 'uploads/sejarah.jpg',
        ]);

        Artikel::create([
            'judul' => 'Tradisi Haul & Ziarah Segoropuro',
            'slug' => 'tradisi-haul-ziarah-segoropuro',
            'kategori' => 'Kearifan Lokal',
            'penulis' => 'Tim Literasi',
            'konten' => "Setiap tahunnya, kawasan wisata religi Makam Sayyid Arif Segoropuro menyelenggarakan peringatan Haul yang dihadiri oleh ribuan peziarah dari berbagai daerah di Jawa Timur dan Nusantara.\n\nAcara dipenuhi dengan pembacaan ayat suci Al-Qur'an, tahlil bersama, serta pengajian umum yang mempererat tali silaturahmi antar umat.",
            'kutipan' => 'Keberkahan dan kebersamaan dalam tradisi ziarah leluhur.',
            'gambar' => 'uploads/hero.jpg',
        ]);
    }
}
