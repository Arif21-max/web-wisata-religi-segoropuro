<?php

namespace Database\Seeders;

use App\Models\BukuTamu;
use Illuminate\Database\Seeder;

class BukuTamuSeeder extends Seeder
{
    public function run(): void
    {
        if (BukuTamu::exists()) {
            return;
        }

        $ulasan = [
            ['H. Ahmad Ridwan', 'Surabaya', 'Alhamdulillah tempatnya sangat bersih, tenang, dan khusyuk untuk berziarah bersama rombongan keluarga.'],
            ['Siti Aminah', 'Pasuruan', 'Fasilitas tempat wudhu dan masjid sangat nyaman. Semoga tempat ini selalu mendatangkan keberkahan.'],
            ['K.H. Mustofa Bisri', 'Rembang', 'Makam Sayyid Arif tempat yang sangat tenang dan adem untuk bermunajat dan mengenang sejarah perjuangan dakwah Islam.'],
            ['Ustadz Farhan', 'Malang', 'Subhanallah, fasilitas tempat ibadah dan area parkir rombongan bus sangat rapi dan tertata dengan sangat baik.'],
            ['Hj. Nurul Hidayah', 'Sidoarjo', 'Pelayanan warga lokal dan pengelola makam sangat ramah. Oleh-oleh UMKM desa juga sangat khas dan murah.'],
            ['Rombongan Ziarah Annur', 'Kediri', 'Alhamdulillah rombongan 2 bus kami bisa melaksanakan tahlil bersama dengan khusyuk di pendopo makam utama.'],
            ['Bapak Supriyadi', 'Jombang', 'Akses jalan menuju kompleks makam sangat mudah dilalui. Tempat wudhu selalu bersih dan terawat.'],
            ['Ibu Ratna Dewi', 'Probolinggo', 'Suasana malam hari di area masjid Segoropuro sangat syahdu. Terima kasih kepada seluruh panitia pengelola.'],
            ['Gus Mahrus', 'Gresik', 'Penataan literasi sejarah dan silsilah Sayyid Arif di lokasi wisata sangat informatif bagi peziarah generasi muda.'],
            ['H. M. Syukron', 'Madura', 'Semoga keberkahan dan ketenangan selalu menyelimuti Desa Segoropuro dan seluruh peziarah yang datang.'],
        ];

        foreach ($ulasan as [$nama, $asal, $pesan]) {
            BukuTamu::create([
                'nama' => $nama,
                'asal_kota' => $asal,
                'pesan_doa' => $pesan,
            ]);
        }
    }
}
