<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaIntegritas extends Model
{
    protected $table = 'zona_integritas';
    protected $fillable = ['cabang_id', 'predikat', 'tahun', 'bulan', 'keterangan', 'status'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function soals()
    {
        return $this->hasMany(ZiSoal::class)->whereNull('parent_id')->orderBy('urutan');
    }
    
    public function allSoals()
    {
        return $this->hasMany(ZiSoal::class)->orderBy('urutan');
    }
}
