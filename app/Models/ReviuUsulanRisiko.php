<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviuUsulanRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'resiko_id',
        'usulan_pernyataan_risiko',
        'unit_pemilik_pengusul',
        'status',
        'alasan_diterima',
        'alasan_ditolak',
    ];

    public function resiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id');
    }
}
