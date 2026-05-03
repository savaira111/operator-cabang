<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResikoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $resikos = \App\Models\Resiko::with('cabang')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->where('cabang_id', $userCabangId);
            })
            ->get();
        return view('resikos.index', compact('resikos'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $cabangs = \App\Models\Cabang::all();
        $analisis_risikos = \App\Models\AnalisisRisiko::with('identifikasiRisiko')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('identifikasiRisiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('resikos.create', compact('cabangs', 'analisis_risikos'));
    }

    public function show(\App\Models\Resiko $resiko)
    {
        $resiko->load('cabang');
        return view('resikos.show', compact('resiko'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pernyataan_risiko' => 'required|string',
            'why_1' => 'nullable|string',
            'why_2' => 'nullable|string',
            'why_3' => 'nullable|string',
            'why_4' => 'nullable|string',
            'why_5' => 'nullable|string',
            'akar_penyebab' => 'required|string',
            'kode_penyebab_jenis' => 'required|string|in:MN,MY,MD,MR,MC,EX',
            'kode_penyebab_nomor' => 'required|integer',
            'kegiatan_pengendalian' => 'required|string',
        ]);
        
        // Use authenticated user's cabang_id or fallback
        $userCabangId = auth()->user()->cabang_id;
        if (!$userCabangId) {
            $defaultCabang = \App\Models\Cabang::first();
            $userCabangId = $defaultCabang ? $defaultCabang->id : null;
        }
        $validated['cabang_id'] = $userCabangId;
        $validated['tahun'] = date('Y');

        $count = \App\Models\Resiko::count() + 1;
        $validated['kode'] = 'WP. ' . $count;

        // Optionally store legacy fields if necessary
        // $validated['name'] = $validated['pernyataan_risiko'];
        // $validated['status'] = 'medium';

        \App\Models\Resiko::create($validated);
        return redirect()->route('resikos.index')->with('success', 'Data laporan pengendalian internal berhasil disimpan');
    }

    public function edit(\App\Models\Resiko $resiko)
    {
        $userCabangId = auth()->user()->cabang_id;
        $cabangs = \App\Models\Cabang::all();
        $analisis_risikos = \App\Models\AnalisisRisiko::with('identifikasiRisiko')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('identifikasiRisiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('resikos.edit', compact('resiko', 'cabangs', 'analisis_risikos'));
    }

    public function update(Request $request, \App\Models\Resiko $resiko)
    {
        $validated = $request->validate([
            'pernyataan_risiko' => 'required|string',
            'why_1' => 'nullable|string',
            'why_2' => 'nullable|string',
            'why_3' => 'nullable|string',
            'why_4' => 'nullable|string',
            'why_5' => 'nullable|string',
            'akar_penyebab' => 'required|string',
            'kode_penyebab_jenis' => 'required|string|in:MN,MY,MD,MR,MC,EX',
            'kode_penyebab_nomor' => 'required|integer',
            'kegiatan_pengendalian' => 'required|string',
        ]);

        $resiko->update($validated);
        return redirect()->route('resikos.index')->with('success', 'Data laporan pengendalian internal berhasil diperbarui');
    }

    public function destroy(\App\Models\Resiko $resiko)
    {
        $resiko->delete();
        return redirect()->route('resikos.index')->with('success', 'Data laporan pengendalian internal berhasil dihapus');
    }
}
