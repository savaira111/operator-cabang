<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ZiSoal;
use App\Models\ZonaIntegritas;

class ZiSoalController extends Controller
{
    public function store(Request $request, ZonaIntegritas $zi)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:zi_soals,id',
            'tipe' => 'required|in:kategori,soal',
            'nomor' => 'nullable|string',
            'judul' => 'nullable|string',
            'bobot' => 'nullable|numeric',
            'nilai_standar' => 'nullable|numeric',
            'kriteria_nilai' => 'nullable|string',
            'tipe_jawaban' => 'nullable|string',
            'penjelasan_a' => 'nullable|string',
            'penjelasan_b' => 'nullable|string',
            'penjelasan_c' => 'nullable|string',
            'penjelasan_d' => 'nullable|string',
            'kebutuhan_bukti_dukung' => 'nullable|integer',
            'keterangan_bukti_dukung' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $validated['zona_integritas_id'] = $zi->id;
        ZiSoal::create($validated);

        return back()->with('success', 'Soal/Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, ZiSoal $soal)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:kategori,soal',
            'nomor' => 'nullable|string',
            'judul' => 'nullable|string',
            'bobot' => 'nullable|numeric',
            'nilai_standar' => 'nullable|numeric',
            'kriteria_nilai' => 'nullable|string',
            'tipe_jawaban' => 'nullable|string',
            'penjelasan_a' => 'nullable|string',
            'penjelasan_b' => 'nullable|string',
            'penjelasan_c' => 'nullable|string',
            'penjelasan_d' => 'nullable|string',
            'kebutuhan_bukti_dukung' => 'nullable|integer',
            'keterangan_bukti_dukung' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $soal->update($validated);

        return back()->with('success', 'Soal/Kategori berhasil diperbarui.');
    }

    public function destroy(ZiSoal $soal)
    {
        $soal->delete();
        return back()->with('success', 'Soal/Kategori berhasil dihapus.');
    }
}
