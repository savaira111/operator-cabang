<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengendalian extends Model
{
    protected $fillable = [
        'cabang_id',
        'nama_laporan',
        'periode_bulan',
        'periode_tahun',
        'file_path',
        'keterangan',
        'status_evaluasi',
        'prosentase',
        'catatan_evaluasi'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
