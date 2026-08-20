<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_barang', 'deskripsi', 'lokasi_ditemukan', 'tanggal_ditemukan', 'status', 'konten_kontak', 'foto'])]
class BarangHilang extends Model
{
    protected $table = 'barang_hilang';

    public const STATUS_BELUM = 'Belum Diambil';

    public const STATUS_SUDAH = 'Sudah Diambil';

    public const STATUSES = [self::STATUS_BELUM, self::STATUS_SUDAH];

    protected function casts(): array
    {
        return [
            'tanggal_ditemukan' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function isSudahDiambil(): bool
    {
        return $this->status === self::STATUS_SUDAH;
    }

    public function toggleStatus(): void
    {
        $this->status = $this->isSudahDiambil() ? self::STATUS_BELUM : self::STATUS_SUDAH;
        $this->save();
    }
}
