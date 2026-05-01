<?php

namespace App\Http\Controllers;

use App\Models\BelanjaSatker;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BelanjaSatkerController extends Controller
{
    public function index()
    {
        $belanjas = BelanjaSatker::with('cabang')->latest()->get();
        return view('belanja_satkers.index', compact('belanjas'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view('belanja_satkers.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'keterangan' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen_path'] = $request->file('dokumen')->store('belanja_dokumen', 'public');
        }

        BelanjaSatker::create($validated);

        return redirect()->route('belanja-satker.index')->with('success', 'Data Belanja Satker berhasil ditambahkan.');
    }

    public function edit(BelanjaSatker $belanjaSatker)
    {
        $cabangs = Cabang::all();
        return view('belanja_satkers.edit', compact('belanjaSatker', 'cabangs'));
    }

    public function update(Request $request, BelanjaSatker $belanjaSatker)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'keterangan' => 'nullable|string',
            'total' => 'required|numeric|min:0',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'status_evaluasi' => 'nullable|string',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan_evaluasi' => 'nullable|string',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($belanjaSatker->dokumen_path) {
                Storage::disk('public')->delete($belanjaSatker->dokumen_path);
            }
            $validated['dokumen_path'] = $request->file('dokumen')->store('belanja_dokumen', 'public');
        }

        $belanjaSatker->update($validated);

        return redirect()->route('belanja-satker.index')->with('success', 'Data Belanja Satker berhasil diperbarui.');
    }

    public function destroy(BelanjaSatker $belanjaSatker)
    {
        if ($belanjaSatker->dokumen_path) {
            Storage::disk('public')->delete($belanjaSatker->dokumen_path);
        }
        $belanjaSatker->delete();
        return redirect()->route('belanja-satker.index')->with('success', 'Data Belanja Satker berhasil dihapus.');
    }
}
