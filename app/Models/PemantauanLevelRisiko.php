<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemantauanLevelRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'analisis_risiko_id',
        'deviasi',
        'rekomendasi',
    ];

    public function analisisRisiko()
    {
        return $this->belongsTo(AnalisisRisiko::class, 'analisis_risiko_id');
    }
}
