<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $fillable = ['kode_cabang', 'name', 'kepala_cabang', 'location', 'alamat', 'description'];

    public function resikos()
    {
        return $this->hasMany(Resiko::class);
    }
}
