<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spot_wisata', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spot');
            $table->string('deskripsi_singkat');
            $table->text('deskripsi_lengkap');
            $table->string('warna_bg')->default('#2c3e50');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spot_wisata');
    }
};
