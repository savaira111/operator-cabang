<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanInternalExcel extends Model
{
    protected $fillable = [
        'category_id',
        'no_input',
        'tanggal_input',
        'cabang_id',
        'periode_bulan',
        'periode_tahun',
        'keterangan',
        'file_path',
        'status_evaluasi',
        'prosentase',
        'catatan_evaluasi'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public static function getCategories()
    {
        return [
            1 => 'Identifikasi Risiko',
            2 => 'Analisis Risiko',
            3 => 'Daftar Risiko Prioritas',
            4 => 'Analisis Akar Masalah',
            5 => 'Rencana Tindak Pengendalian',
            6 => 'Pemantauan Kegiatan',
            7 => 'Pemantauan Peristiwa',
            8 => 'Pemantauan Level Risiko',
            9 => 'Reviu Usulan Risiko',
            10 => 'Kegiatan Belum Realisasi',
            11 => 'Hasil Evaluasi / Komentar',
        ];
    }

    public function getCategoryNameAttribute()
    {
        return self::getCategories()[$this->category_id] ?? 'Unknown';
    }
}
