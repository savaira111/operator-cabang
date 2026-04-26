<?php

namespace App\Http\Controllers;

use App\Models\PemantauanLevelRisiko;
use App\Models\AnalisisRisiko;
use App\Models\PemantauanPeristiwa;
use Illuminate\Http\Request;

class PemantauanLevelRisikoController extends Controller
{
    public function index()
    {
        $pemantauans = PemantauanLevelRisiko::with(['analisisRisiko.identifikasiRisiko'])->get();
        
        // Add event count for each
        foreach($pemantauans as $p) {
            $p->kejadian_count = $this->getEventCount($p->analisisRisiko);
        }

        return view('pemantauan_level.index', compact('pemantauans'));
    }

    public function create()
    {
        $analisisRisikos = AnalisisRisiko::with('identifikasiRisiko')->get();
        return view('pemantauan_level.create', compact('analisisRisikos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'analisis_risiko_id' => 'required|exists:analisis_risikos,id',
            'deviasi' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        PemantauanLevelRisiko::create($validated);

        return redirect()->route('pemantauan-level.index')->with('success', 'Data Pemantauan Level Risiko berhasil ditambahkan.');
    }

    public function show(PemantauanLevelRisiko $pemantauanLevel)
    {
        $pemantauanLevel->load(['analisisRisiko.identifikasiRisiko']);
        $pemantauanLevel->kejadian_count = $this->getEventCount($pemantauanLevel->analisisRisiko);
        return view('pemantauan_level.show', compact('pemantauanLevel'));
    }

    public function edit(PemantauanLevelRisiko $pemantauanLevel)
    {
        $analisisRisikos = AnalisisRisiko::with('identifikasiRisiko')->get();
        return view('pemantauan_level.edit', compact('pemantauanLevel', 'analisisRisikos'));
    }

    public function update(Request $request, PemantauanLevelRisiko $pemantauanLevel)
    {
        $validated = $request->validate([
            'analisis_risiko_id' => 'required|exists:analisis_risikos,id',
            'deviasi' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        $pemantauanLevel->update($validated);

        return redirect()->route('pemantauan-level.index')->with('success', 'Data Pemantauan Level Risiko berhasil diperbarui.');
    }

    public function destroy(PemantauanLevelRisiko $pemantauanLevel)
    {
        $pemantauanLevel->delete();
        return redirect()->route('pemantauan-level.index')->with('success', 'Data Pemantauan Level Risiko berhasil dihapus.');
    }

    private function getEventCount($analisisRisiko)
    {
        if (!$analisisRisiko || !$analisisRisiko->identifikasiRisiko) return 0;
        
        $pernyataan = $analisisRisiko->identifikasiRisiko->pernyataan_risiko;
        
        // Match Filter 7 events where the related risk has the same statement
        return PemantauanPeristiwa::whereHas('pemantauanKegiatan.rencanaTindak.resiko', function($q) use ($pernyataan) {
            $q->where('pernyataan_risiko', $pernyataan);
        })->count();
    }
}
