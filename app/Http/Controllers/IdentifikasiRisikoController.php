<?php

namespace App\Http\Controllers;

use App\Models\IdentifikasiRisiko;
use Illuminate\Http\Request;

class IdentifikasiRisikoController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $identifikasi_risikos = IdentifikasiRisiko::with('cabang')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->where('cabang_id', $userCabangId);
            })
            ->get();
        return view('identifikasi_risiko.index', compact('identifikasi_risikos'));
    }

    public function create()
    {
        $master_risikos = \App\Models\MasterRiskCode::all();
        return view('identifikasi_risiko.create', compact('master_risikos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rows' => 'required|array',
            'rows.*.jenis_konteks' => 'nullable|string',
            'rows.*.nama_konteks' => 'nullable|string',
            'rows.*.indikator' => 'nullable|string',
            'rows.*.kode_risiko' => 'nullable|string',
            'rows.*.pernyataan_risiko' => 'nullable|string',
            'rows.*.kategori_risiko' => 'nullable|string',
            'rows.*.uraian_dampak' => 'nullable|string',
            'rows.*.metode_pencapaian_tujuan_spip' => 'nullable|string',
        ]);

        $userCabangId = auth()->user()->cabang_id;
        if (!$userCabangId) {
            $defaultCabang = \App\Models\Cabang::first();
            $userCabangId = $defaultCabang ? $defaultCabang->id : null;
        }

        $count = 0;
        foreach ($request->rows as $rowData) {
            if (empty($rowData['pernyataan_risiko']) && empty($rowData['kode_risiko'])) continue;
            
            $rowData['cabang_id'] = $userCabangId;
            $rowData['user_id'] = auth()->id();
            IdentifikasiRisiko::create($rowData);
            $count++;
        }

        return redirect()->route('identifikasi-risiko.index')->with('success', $count . ' Data Identifikasi Risiko berhasil ditambahkan.');
    }

    public function show(IdentifikasiRisiko $identifikasi_risiko)
    {
        return view('identifikasi_risiko.show', compact('identifikasi_risiko'));
    }

    public function edit(IdentifikasiRisiko $identifikasi_risiko)
    {
        $master_risikos = \App\Models\MasterRiskCode::all();
        return view('identifikasi_risiko.edit', compact('identifikasi_risiko', 'master_risikos'));
    }

    public function update(Request $request, IdentifikasiRisiko $identifikasi_risiko)
    {
        $validated = $request->validate([
            'jenis_konteks' => 'nullable|string',
            'nama_konteks' => 'nullable|string',
            'indikator' => 'nullable|string',
            'kode_risiko' => 'nullable|string',
            'pernyataan_risiko' => 'nullable|string',
            'kategori_risiko' => 'nullable|string',
            'uraian_dampak' => 'nullable|string',
            'metode_pencapaian_tujuan_spip' => 'nullable|string',
        ]);

        $identifikasi_risiko->update($validated);
        return redirect()->route('identifikasi-risiko.index')->with('success', 'Data Identifikasi Risiko berhasil diperbarui.');
    }

    public function destroy(IdentifikasiRisiko $identifikasi_risiko)
    {
        $identifikasi_risiko->delete();
        return redirect()->route('identifikasi-risiko.index')->with('success', 'Data Identifikasi Risiko berhasil dihapus.');
    }
}
