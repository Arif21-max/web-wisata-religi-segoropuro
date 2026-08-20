<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    public function run(): void
    {
        Kontak::query()->delete();

        Kontak::create([
            'alamat' => 'Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan, Jawa Timur',
            'whatsapp_number' => config('segoropuro.whatsapp_number'),
            'whatsapp_default_message' => config('segoropuro.whatsapp_default_message'),
            'google_maps_embed' => sanitize_maps_embed(config('segoropuro.google_maps_embed')),
        ]);
    }
}
