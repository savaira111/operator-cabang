<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahanan extends Model
{
    protected $fillable = ['no_input', 'tanggal_input', 'cabang_id', 'periode_bulan', 'periode_tahun', 'keterangan', 'file_path', 'status_evaluasi', 'prosentase', 'catatan_evaluasi'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
