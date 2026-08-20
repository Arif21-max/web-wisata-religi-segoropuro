<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['judul', 'slug', 'kategori', 'penulis', 'konten', 'kutipan', 'gambar'])]
class Artikel extends Model
{
    protected $table = 'artikel';

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getReadingTime(): int
    {
        $words = str_word_count(strip_tags($this->konten));

        return max(1, (int) ceil($words / 200));
    }
}
