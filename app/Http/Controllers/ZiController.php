<?php

namespace App\Http\Controllers;

use App\Models\ZonaIntegritas;
use App\Models\Cabang;
use Illuminate\Http\Request;

class ZiController extends Controller
{
    public function index()
    {
        $zis = ZonaIntegritas::with('cabang')->latest()->get();
        return view('zis.index', compact('zis'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view('zis.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'predikat' => 'required|string|max:255',
            'tahun' => 'required|numeric|digits:4',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        ZonaIntegritas::create($validated);
        return redirect()->route('zis.index')->with('success', 'Data Zona Integritas berhasil ditambahkan');
    }

    public function show(ZonaIntegritas $zi)
    {
        return view('zis.show', compact('zi'));
    }

    public function edit(ZonaIntegritas $zi)
    {
        $cabangs = Cabang::all();
        return view('zis.edit', compact('zi', 'cabangs'));
    }

    public function update(Request $request, ZonaIntegritas $zi)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'predikat' => 'required|string|max:255',
            'tahun' => 'required|numeric|digits:4',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $zi->update($validated);
        return redirect()->route('zis.index')->with('success', 'Data Zona Integritas berhasil diperbarui');
    }

    public function destroy(ZonaIntegritas $zi)
    {
        $zi->delete();
        return redirect()->route('zis.index')->with('success', 'Data Zona Integritas berhasil dihapus');
    }
}
