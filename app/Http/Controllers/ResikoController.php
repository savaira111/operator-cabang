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
        $master_penyebabs = \App\Models\MasterCauseCode::all();
        $analisis_risikos = \App\Models\AnalisisRisiko::with('identifikasiRisiko')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('identifikasiRisiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('resikos.create', compact('cabangs', 'analisis_risikos', 'master_penyebabs'));
    }

    public function show(\App\Models\Resiko $resiko)
    {
        $resiko->load('cabang');
        return view('resikos.show', compact('resiko'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rows' => 'required|array',
            'rows.*.pernyataan_risiko' => 'required|string',
            'rows.*.why_1' => 'nullable|string',
            'rows.*.why_2' => 'nullable|string',
            'rows.*.why_3' => 'nullable|string',
            'rows.*.why_4' => 'nullable|string',
            'rows.*.why_5' => 'nullable|string',
            'rows.*.akar_penyebab' => 'required|string',
            'rows.*.kode_penyebab_jenis' => 'required|string|exists:master_cause_codes,kode',
            'rows.*.kode_penyebab_nomor' => 'required|integer',
            'rows.*.kegiatan_pengendalian' => 'required|string',
        ]);
        
        $userCabangId = auth()->user()->cabang_id;
        if (!$userCabangId) {
            $defaultCabang = \App\Models\Cabang::first();
            $userCabangId = $defaultCabang ? $defaultCabang->id : null;
        }

        $count = 0;
        foreach ($request->rows as $rowData) {
            $rowData['cabang_id'] = $userCabangId;
            $rowData['tahun'] = date('Y');
            $rowData['kode'] = $rowData['kode_penyebab_jenis'] . '.' . $rowData['kode_penyebab_nomor'];
            \App\Models\Resiko::create($rowData);
            $count++;
        }

        return redirect()->route('resikos.index')->with('success', $count . ' Data laporan pengendalian internal berhasil disimpan');
    }

    public function edit(\App\Models\Resiko $resiko)
    {
        $userCabangId = auth()->user()->cabang_id;
        $cabangs = \App\Models\Cabang::all();
        $master_penyebabs = \App\Models\MasterCauseCode::all();
        $analisis_risikos = \App\Models\AnalisisRisiko::with('identifikasiRisiko')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('identifikasiRisiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('resikos.edit', compact('resiko', 'cabangs', 'analisis_risikos', 'master_penyebabs'));
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
            'kode_penyebab_jenis' => 'required|string|exists:master_cause_codes,kode',
            'kode_penyebab_nomor' => 'required|integer',
            'kegiatan_pengendalian' => 'required|string',
        ]);

        $validated['kode'] = $validated['kode_penyebab_jenis'] . '.' . $validated['kode_penyebab_nomor'];

        $resiko->update($validated);
        return redirect()->route('resikos.index')->with('success', 'Data laporan pengendalian internal berhasil diperbarui');
    }

    public function destroy(\App\Models\Resiko $resiko)
    {
        $resiko->delete();
        return redirect()->route('resikos.index')->with('success', 'Data laporan pengendalian internal berhasil dihapus');
    }
}
