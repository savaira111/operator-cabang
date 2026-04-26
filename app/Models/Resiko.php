<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resiko extends Model
{
    protected $fillable = [
        'name', 'status', 'description', 'cabang_id', 
        'kode', 'pernyataan_risiko', 'why_1', 'why_2', 'why_3', 
        'why_4', 'why_5', 'akar_penyebab', 'kode_penyebab_jenis', 
        'kode_penyebab_nomor', 'kegiatan_pengendalian', 'tahun'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
