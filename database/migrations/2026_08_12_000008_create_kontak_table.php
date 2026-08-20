<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->string('alamat')->default('Desa Segoropuro, Kecamatan Rejoso, Kabupaten Pasuruan, Jawa Timur');
            $table->string('whatsapp_number')->default('628123456789');
            $table->text('whatsapp_default_message')->nullable();
            $table->text('google_maps_embed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontak');
    }
};
