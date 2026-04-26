<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanPeristiwa extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemantauan_kegiatan_id',
        'uraian_peristiwa',
        'waktu_kejadian',
        'tempat_kejadian',
        'skor_dampak',
        'pemicu_peristiwa',
    ];

    public function pemantauanKegiatan()
    {
        return $this->belongsTo(PemantauanKegiatan::class, 'pemantauan_kegiatan_id');
    }
}
