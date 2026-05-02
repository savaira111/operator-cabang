<?php

namespace App\Http\Controllers;

use App\Models\IdentifikasiRisiko;
use Illuminate\Http\Request;

class PenilaianLpiController extends Controller
{
    public function index(Request $request)
    {
        $step = $request->get('step', 11);
        $query = IdentifikasiRisiko::with([
            'cabang', 
            'analisisRisiko', 
            'resiko.rencanaTindak.pemantauanKegiatan',
            'resiko.rencanaTindak.rencanaBelumTerealisasi',
            'resiko.reviuUsulan',
        ]);

        if ($request->filled('search')) {
            $query->where('pernyataan_risiko', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('cabang_id')) {
            $query->where('cabang_id', $request->cabang_id);
        }
        if ($request->filled('status_evaluasi')) {
            $query->where('status_evaluasi', $request->status_evaluasi);
        }

        $identifikasi_risikos = $query->latest()->get();
        $cabangs = \App\Models\Cabang::all();

        return view('penilaian_lpis.index', compact('identifikasi_risikos', 'cabangs', 'step'));
    }

    public function edit(IdentifikasiRisiko $penilaian_lpi)
    {
        return view('penilaian_lpis.edit', ['identifikasi_risiko' => $penilaian_lpi]);
    }

    public function update(Request $request, IdentifikasiRisiko $penilaian_lpi)
    {
        $validated = $request->validate([
            'status_evaluasi' => 'required|string',
            'prosentase' => 'required|integer|min:0|max:100',
            'catatan_evaluasi' => 'nullable|string',
        ]);

        $penilaian_lpi->update($validated);

        return redirect()->route('penilaian-lpi.index')->with('success', 'Penilaian LPI berhasil diperbarui');
    }
}
