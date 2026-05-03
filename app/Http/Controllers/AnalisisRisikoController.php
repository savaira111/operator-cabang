<?php

namespace App\Http\Controllers;

use App\Models\AnalisisRisiko;
use Illuminate\Http\Request;

class AnalisisRisikoController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $analisis_risikos = AnalisisRisiko::with('identifikasiRisiko.cabang')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('identifikasiRisiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('analisis_risiko.index', compact('analisis_risikos'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $identifikasi_risikos = \App\Models\IdentifikasiRisiko::when($userCabangId, function($q) use ($userCabangId) {
            return $q->where('cabang_id', $userCabangId);
        })->get();
        return view('analisis_risiko.create', compact('identifikasi_risikos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'identifikasi_risiko_id' => 'required|exists:identifikasi_risikos,id',
            'frekuensi' => 'nullable|string',
            'dampak' => 'nullable|string',
            'level_risiko' => 'nullable|string',
            'ada_belum_ada' => 'nullable|string',
            'uraian_pengendalian' => 'nullable|string',
            'memadai_belum_memadai' => 'nullable|string',
            'skor_probabilitas_residu' => 'nullable|string',
            'skor_dampak_residu' => 'nullable|string',
            'level_risiko_residu' => 'nullable|string',
        ]);

        AnalisisRisiko::create($validated);
        return redirect()->route('analisis-risiko.index')->with('success', 'Analisis Risiko berhasil ditambahkan.');
    }

    public function show(AnalisisRisiko $analisis_risiko)
    {
        return view('analisis_risiko.show', compact('analisis_risiko'));
    }

    public function edit(AnalisisRisiko $analisis_risiko)
    {
        $userCabangId = auth()->user()->cabang_id;
        $identifikasi_risikos = \App\Models\IdentifikasiRisiko::when($userCabangId, function($q) use ($userCabangId) {
            return $q->where('cabang_id', $userCabangId);
        })->get();
        return view('analisis_risiko.edit', compact('analisis_risiko', 'identifikasi_risikos'));
    }

    public function update(Request $request, AnalisisRisiko $analisis_risiko)
    {
        $validated = $request->validate([
            'identifikasi_risiko_id' => 'required|exists:identifikasi_risikos,id',
            'frekuensi' => 'nullable|string',
            'dampak' => 'nullable|string',
            'level_risiko' => 'nullable|string',
            'ada_belum_ada' => 'nullable|string',
            'uraian_pengendalian' => 'nullable|string',
            'memadai_belum_memadai' => 'nullable|string',
            'skor_probabilitas_residu' => 'nullable|string',
            'skor_dampak_residu' => 'nullable|string',
            'level_risiko_residu' => 'nullable|string',
        ]);

        $analisis_risiko->update($validated);
        return redirect()->route('analisis-risiko.index')->with('success', 'Analisis Risiko berhasil diperbarui.');
    }

    public function destroy(AnalisisRisiko $analisis_risiko)
    {
        $analisis_risiko->delete();
        return redirect()->route('analisis-risiko.index')->with('success', 'Analisis Risiko berhasil dihapus.');
    }
}
