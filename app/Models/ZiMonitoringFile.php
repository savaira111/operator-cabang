<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZiMonitoringFile extends Model
{
    protected $fillable = [
        'zi_monitoring_id',
        'period',
        'file_path',
        'status',
        'catatan',
    ];

    public function monitoring()
    {
        return $this->belongsTo(ZiMonitoring::class, 'zi_monitoring_id');
    }
}
