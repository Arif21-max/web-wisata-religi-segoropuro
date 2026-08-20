<?php

namespace Database\Seeders;

use App\Models\Berita;
use Illuminate\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        if (Berita::exists()) {
            return;
        }

        Berita::create([
            'judul' => 'Peringatan Haul Agung Sayyid Arif Segoropuro Tahun 2026 Segera Diberlangsungkan',
            'slug' => 'peringatan-haul-agung-sayyid-arif-2026',
            'kategori' => 'Acara Religi',
            'tanggal_kegiatan' => '2026-08-20',
            'penulis' => 'Panitia Pengelola Makam',
            'ringkasan' => 'Panitia pengelola kawasan wisata religi Makam Sayyid Arif Segoropuro resmi mengumumkan rangkaian acara Haul Agung yang akan dihadiri para habaib dan ribuan peziarah.',
            'konten' => "Persiapan Peringatan Haul Agung Sayyid Arif Segoropuro tahun 2026 kini telah memasuki tahap akhir. Panitia pengelola kawasan wisata religi berkoordinasi dengan aparatur Desa Segoropuro dan Kepolisian Rejoso untuk memastikan kelancaran arus lalu lintas serta keamanan peziarah.\n\nRangkaian Acara:\n1. Pembacaan Al-Qur'an 30 Juz Bil Ghoib di Masjid Segoropuro.\n2. Tahlil dan Doa Bersama di Pendopo Utama Makam.\n3. Pengajian Umum dan Mauidhoh Hasanah oleh para Habaib & Ulama Jawa Timur.\n\nPanitia mengimbau rombongan bus dan peziarah untuk mematuhi arahan petugas di area parkir utama.",
            'gambar' => 'uploads/hero.jpg',
        ]);

        Berita::create([
            'judul' => 'Pengajian Rutin Malam Jumat Legi & Istighosah Kubro Peziarah',
            'slug' => 'pengajian-rutin-malam-jumat-legi',
            'kategori' => 'Acara Religi',
            'tanggal_kegiatan' => '2026-08-15',
            'penulis' => 'Tim Majlis Segoropuro',
            'ringkasan' => 'Pengajian rutin bulanan dan Istighosah Kubro kembali diselenggarakan secara terbuka di pendopo Makam Sayyid Arif Segoropuro.',
            'konten' => "Dalam rangka mempererat ukhuwah islamiyah dan meningkatkan ketakwaan, pengelola kawasan wisata religi Segoropuro rutin menyelenggarakan Pengajian Malam Jumat Legi.\n\nAcara dimulai tepat setelah shalat Isya berjamaah di Masjid Segoropuro, dilanjutkan pembacaan Ratib dan Tahlil. Seluruh masyarakat dan peziarah dari berbagai daerah diundang untuk hadir meraih keberkahan bersama.",
            'gambar' => 'uploads/masjid.jpg',
        ]);

        Berita::create([
            'judul' => 'Penyemprotan Sterilisasi & Kerja Bakti Kebersihan Kawasan Wisata Religi',
            'slug' => 'kerja-bakti-kebersihan-kawasan-wisata',
            'kategori' => 'Kegiatan Desa',
            'tanggal_kegiatan' => '2026-08-08',
            'penulis' => 'Pengelola Desa Segoropuro',
            'ringkasan' => 'Guna menyambut lonjakan peziarah rombongan, pengelola desa bersama warga menggelar aksi kerja bakti kebersihan dan peremajaan fasilitas umum.',
            'konten' => "Aksi gotong royong kerja bakti kebersihan dilaksanakan serentak oleh warga Desa Segoropuro di sepanjang jalan akses utama, area parkir kendaraan, tempat wudhu, serta pendopo peziarahan.\n\nDengan adanya pembersihan berkala ini, diharapkan seluruh pengunjung dan rombongan peziarah dapat menjalankan ibadah dengan aman, nyaman, dan khusyuk.",
            'gambar' => 'uploads/makam.jpg',
        ]);
    }
}
