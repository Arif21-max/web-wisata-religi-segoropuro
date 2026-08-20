<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['judul', 'slug', 'kategori', 'tanggal_kegiatan', 'penulis', 'ringkasan', 'konten', 'gambar'])]
class Berita extends Model
{
    protected $table = 'berita';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
