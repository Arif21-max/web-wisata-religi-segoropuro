<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $key = (string) config('app.key');

        Schema::table('statistik_pengunjung', function (Blueprint $table) {
            $table->string('ip_address', 64)->change();
        });

        DB::table('statistik_pengunjung')->chunkById(500, function ($rows) use ($key) {
            foreach ($rows as $row) {
                DB::table('statistik_pengunjung')
                    ->where('id', $row->id)
                    ->update(['ip_address' => hash_hmac('sha256', (string) $row->ip_address, $key)]);
            }
        });
    }

    public function down(): void
    {
        // IP asli tidak dapat dipulihkan (anonimisasi irreversible).
    }
};
