<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZonaIntegritas extends Model
{
    protected $table = 'zona_integritas';
    protected $fillable = ['cabang_id', 'predikat', 'tahun', 'keterangan', 'status'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
