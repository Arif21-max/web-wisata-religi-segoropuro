<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'asal_kota', 'pesan_doa'])]
class BukuTamu extends Model
{
    protected $table = 'buku_tamu';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getInisial(): string
    {
        $kata = preg_split('/\s+/', trim($this->nama));

        $inisial = collect($kata)
            ->take(2)
            ->map(fn ($bagian) => mb_strtoupper(mb_substr($bagian, 0, 1)))
            ->implode('');

        return $inisial !== '' ? $inisial : '?';
    }
}
