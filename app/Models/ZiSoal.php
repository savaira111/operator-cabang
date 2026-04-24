<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiSoal extends Model
{
    protected $fillable = [
        'zona_integritas_id',
        'parent_id',
        'tipe',
        'nomor',
        'judul',
        'bobot',
        'nilai_standar',
        'kriteria_nilai',
        'tipe_jawaban',
        'penjelasan_a',
        'penjelasan_b',
        'penjelasan_c',
        'penjelasan_d',
        'kebutuhan_bukti_dukung',
        'keterangan_bukti_dukung',
        'urutan'
    ];

    public function zonaIntegritas()
    {
        return $this->belongsTo(ZonaIntegritas::class);
    }

    public function parent()
    {
        return $this->belongsTo(ZiSoal::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ZiSoal::class, 'parent_id')->orderBy('urutan');
    }
}
