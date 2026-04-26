<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaBelumTerealisasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'rencana_tindak_pengendalian_id',
        'keterangan',
    ];

    public function rencanaTindakPengendalian()
    {
        return $this->belongsTo(RencanaTindakPengendalian::class, 'rencana_tindak_pengendalian_id');
    }
}
