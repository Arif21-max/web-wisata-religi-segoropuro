<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KontakSeeder::class,
            ArtikelSeeder::class,
            SpotWisataSeeder::class,
            BeritaSeeder::class,
            BukuTamuSeeder::class,
            BarangHilangSeeder::class,
        ]);
    }
}
