<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;

class PenilaianTahananController extends Controller
{
    public function index()
    {
        $tahanans = Tahanan::with('cabang')->latest()->get();
        return view('penilaian_tahanans.index', compact('tahanans'));
    }

    public function edit(Tahanan $penilaian_tahanan)
    {
        return view('penilaian_tahanans.edit', ['tahanan' => $penilaian_tahanan]);
    }

    public function update(Request $request, Tahanan $penilaian_tahanan)
    {
        $validated = $request->validate([
            'status_evaluasi' => 'required|string',
            'prosentase' => 'required|integer|min:0|max:100',
            'catatan_evaluasi' => 'nullable|string',
        ]);

        $penilaian_tahanan->update($validated);

        return redirect()->route('penilaian-tahanan.index')->with('success', 'Penilaian tahanan berhasil diperbarui');
    }
}
