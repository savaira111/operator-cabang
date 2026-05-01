<?php

namespace App\Http\Controllers;

use App\Models\BelanjaSatker;
use Illuminate\Http\Request;

class PenilaianBelanjaController extends Controller
{
    public function index()
    {
        $belanjas = BelanjaSatker::with('cabang')->latest()->get();
        return view('penilaian_belanjas.index', compact('belanjas'));
    }

    public function edit(BelanjaSatker $penilaian_belanja)
    {
        return view('penilaian_belanjas.edit', ['belanjaSatker' => $penilaian_belanja]);
    }

    public function update(Request $request, BelanjaSatker $penilaian_belanja)
    {
        $validated = $request->validate([
            'status_evaluasi' => 'required|string',
            'prosentase' => 'required|integer|min:0|max:100',
            'catatan_evaluasi' => 'nullable|string',
        ]);

        $penilaian_belanja->update($validated);

        return redirect()->route('penilaian-belanja.index')->with('success', 'Penilaian anggaran berhasil diperbarui');
    }
}
