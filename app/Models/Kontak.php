<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['alamat', 'whatsapp_number', 'whatsapp_default_message', 'google_maps_embed'])]
class Kontak extends Model
{
    protected $table = 'kontak';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
