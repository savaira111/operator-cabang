<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalisisRisiko extends Model
{
    protected $fillable = [
        'identifikasi_risiko_id',
        'frekuensi',
        'dampak',
        'level_risiko',
        'ada_belum_ada',
        'uraian_pengendalian',
        'memadai_belum_memadai',
        'skor_probabilitas_residu',
        'skor_dampak_residu',
        'level_risiko_residu',
    ];

    public function identifikasiRisiko()
    {
        return $this->belongsTo(IdentifikasiRisiko::class, 'identifikasi_risiko_id');
    }

    public function getLevelBadgeClass($levelString)
    {
        if (!$levelString) return 'bg-slate-500/10 text-slate-400 border-slate-800/60';
        
        $score = (int) explode(' ', $levelString)[0];
        
        if ($score >= 20) return 'bg-red-500/20 text-red-400 border-red-500/50';
        if ($score >= 16) return 'bg-orange-500/20 text-orange-400 border-orange-500/50';
        if ($score >= 12) return 'bg-yellow-500/20 text-yellow-400 border-yellow-500/50';
        if ($score >= 6) return 'bg-green-500/20 text-green-400 border-green-500/50';
        return 'bg-blue-500/20 text-blue-400 border-blue-500/50';
    }
}
