<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rencana_tindak_pengendalian_id',
        'realisasi_waktu',
        'hambatan_kendala',
    ];

    public function rencanaTindak()
    {
        return $this->belongsTo(RencanaTindakPengendalian::class, 'rencana_tindak_pengendalian_id');
    }
}
