<?php

namespace App\Http\Controllers;

use App\Models\IdentifikasiRisiko;
use Illuminate\Http\Request;

class PenilaianLpiController extends Controller
{
    public function index()
    {
        // Penilaian LPI sekarang menilai data Identifikasi Risiko (Laporan Internal)
        $identifikasi_risikos = IdentifikasiRisiko::with('cabang')->latest()->get();
        return view('penilaian_lpis.index', compact('identifikasi_risikos'));
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
