<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentifikasiRisiko extends Model
{
    protected $fillable = [
        'cabang_id',
        'jenis_konteks',
        'nama_konteks',
        'indikator',
        'kode_risiko',
        'pernyataan_risiko',
        'kategori_risiko',
        'uraian_dampak',
        'metode_pencapaian_tujuan_spip',
        'status_evaluasi',
        'prosentase',
        'catatan_evaluasi',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
