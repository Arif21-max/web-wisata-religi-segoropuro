<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistik_pengunjung', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->date('tanggal');
            $table->unsignedInteger('hits')->default(1);
            $table->timestamps();
            $table->unique(['ip_address', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistik_pengunjung');
    }
};
