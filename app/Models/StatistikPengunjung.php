<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['ip_address', 'tanggal', 'hits'])]
class StatistikPengunjung extends Model
{
    protected $table = 'statistik_pengunjung';

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'hits' => 'integer',
        ];
    }
}
