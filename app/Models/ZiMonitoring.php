<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZiMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabang_id',
        'parent_id',
        'tipe',
        'nomor',
        'sasaran_kegiatan',
        'indikator',
        'target',
        'outcome',
        'rincian_kegiatan',
        'indikator_output',
        'target_output',
        'waktu_pelaksanaan',
        'anggaran',
        'pelaksana',
        'koordinator',
        'data_dukung',
        'status_data_dukung',
        'prosentase',
        'catatan',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function parent()
    {
        return $this->belongsTo(ZiMonitoring::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ZiMonitoring::class, 'parent_id')->orderBy('nomor');
    }

    public function getStatusBadgeClass()
    {
        return match($this->status_data_dukung) {
            'sesuai' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
            'menunggu' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
            'tidak_sesuai' => 'bg-rose-500/20 text-rose-400 border-rose-500/30',
            default => 'bg-slate-800 text-slate-500 border-slate-700',
        };
    }

    public function getStatusLabel()
    {
        return match($this->status_data_dukung) {
            'sesuai' => 'Sesuai (Unit Eselon I + Itjen)',
            'menunggu' => 'Menunggu Evaluasi',
            'tidak_sesuai' => 'Tidak Sesuai',
            default => 'Belum Ada Data Dukung',
        };
    }
}
