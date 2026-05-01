<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelanjaSatker extends Model
{
    protected $fillable = [
        'cabang_id',
        'bulan',
        'tahun',
        'keterangan',
        'dokumen_path',
        'total',
        'status_evaluasi',
        'prosentase',
        'catatan_evaluasi'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
