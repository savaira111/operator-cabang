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
        $request->validate([
            'rows' => 'required|array',
            'rows.*.identifikasi_risiko_id' => 'required|exists:identifikasi_risikos,id',
            'rows.*.frekuensi' => 'nullable|string',
            'rows.*.dampak' => 'nullable|string',
            'rows.*.level_risiko' => 'nullable|string',
            'rows.*.ada_belum_ada' => 'nullable|string',
            'rows.*.uraian_pengendalian' => 'nullable|string',
            'rows.*.memadai_belum_memadai' => 'nullable|string',
            'rows.*.skor_probabilitas_residu' => 'nullable|string',
            'rows.*.skor_dampak_residu' => 'nullable|string',
            'rows.*.level_risiko_residu' => 'nullable|string',
        ]);

        $count = 0;
        foreach ($request->rows as $rowData) {
            AnalisisRisiko::create($rowData);
            $count++;
        }

        return redirect()->route('analisis-risiko.index')->with('success', $count . ' Analisis Risiko berhasil ditambahkan.');
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
