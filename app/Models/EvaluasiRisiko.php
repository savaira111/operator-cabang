<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'resiko_id',
        'pemilik_risiko',
        'keterangan',
    ];

    public function resiko()
    {
        return $this->belongsTo(Resiko::class, 'resiko_id');
    }
}
