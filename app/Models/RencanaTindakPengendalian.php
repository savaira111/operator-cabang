<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaTindakPengendalian extends Model
{
    use HasFactory;

    protected $fillable = [
        'resiko_id',
        'rencana_tindak',
        'waktu_pelaksanaan',
        'penanggung_jawab',
        'respons_risiko',
        'klasifikasi_sub_unsur_spip',
        'indikator_keluaran',
        'frekuensi',
        'dampak',
        'level_risiko',
    ];

    public function resiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id');
    }

    public function pemantauanKegiatan()
    {
        return $this->hasMany(PemantauanKegiatan::class, 'rencana_tindak_pengendalian_id');
    }

    public function rencanaBelumTerealisasi()
    {
        return $this->hasMany(RencanaBelumTerealisasi::class, 'rencana_tindak_pengendalian_id');
    }
}
