<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_hilang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('lokasi_ditemukan');
            $table->date('tanggal_ditemukan');
            $table->string('status')->default('Belum Diambil');
            $table->string('konten_kontak')->default('Pengelola Makam / Satpam');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_hilang');
    }
};
