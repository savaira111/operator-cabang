<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resiko extends Model
{
    protected $fillable = ['name', 'status', 'description', 'cabang_id'];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }
}
