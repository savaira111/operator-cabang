<?php

namespace App\Http\Controllers;

use App\Models\AnalisisRisiko;
use Illuminate\Http\Request;

class DaftarPrioritasController extends Controller
{
    public function index()
    {
        $analisis_risikos = AnalisisRisiko::with('identifikasiRisiko')->get();
        return view('daftar_prioritas.index', compact('analisis_risikos'));
    }
}
