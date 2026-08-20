<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['nama_spot', 'deskripsi_singkat', 'deskripsi_lengkap', 'warna_bg', 'foto'])]
class SpotWisata extends Model
{
    protected $table = 'spot_wisata';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function getFotoList(): Collection
    {
        $foto = (string) $this->foto;

        if (trim($foto) === '') {
            return collect(['assets/img/makam.jpg']);
        }

        return collect(explode(',', $foto))
            ->map(fn ($path) => trim($path))
            ->filter();
    }

    public function getFotoPertama(): string
    {
        return $this->getFotoList()->first() ?? 'assets/img/makam.jpg';
    }
}
