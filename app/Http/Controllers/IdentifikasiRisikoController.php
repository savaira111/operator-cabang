<?php

namespace App\Http\Controllers;

use App\Models\IdentifikasiRisiko;
use Illuminate\Http\Request;

class IdentifikasiRisikoController extends Controller
{
    public function index()
    {
        $identifikasi_risikos = IdentifikasiRisiko::with('cabang')->get();
        return view('identifikasi_risiko.index', compact('identifikasi_risikos'));
    }

    public function create()
    {
        return view('identifikasi_risiko.create');
    }

    public function store(Request $request)
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

        $defaultCabang = \App\Models\Cabang::first();
        $validated['cabang_id'] = auth()->user()->cabang_id ?? ($defaultCabang ? $defaultCabang->id : null);

        IdentifikasiRisiko::create($validated);
        return redirect()->route('identifikasi-risiko.index')->with('success', 'Data Identifikasi Risiko berhasil ditambahkan.');
    }

    public function show(IdentifikasiRisiko $identifikasi_risiko)
    {
        return view('identifikasi_risiko.show', compact('identifikasi_risiko'));
    }

    public function edit(IdentifikasiRisiko $identifikasi_risiko)
    {
        return view('identifikasi_risiko.edit', compact('identifikasi_risiko'));
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
