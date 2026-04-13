<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabangs = \App\Models\Cabang::all();
        return view('cabangs.index', compact('cabangs'));
    }

    public function create()
    {
        $lastCabang = \App\Models\Cabang::whereNotNull('kode_cabang')->orderBy('id', 'desc')->first();
        
        $nextCode = 'UPT-01';
        if ($lastCabang) {
            $numberPart = preg_replace('/[^0-9]/', '', $lastCabang->kode_cabang);
            $nextNumber = intval($numberPart) + 1;
            $nextCode = 'UPT-' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        return view('cabangs.create', compact('nextCode'));
    }

    public function show(\App\Models\Cabang $cabang)
    {
        return view('cabangs.show', compact('cabang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_cabang' => 'required|string|max:255|unique:cabangs,kode_cabang',
            'name' => 'required|string|max:255',
            'kepala_cabang' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $validated['location'] = 'Jawa Barat';
        \App\Models\Cabang::create($validated);
        return redirect()->route('cabangs.index')->with('success', 'Data kantor cabang berhasil ditambahkan');
    }

    public function edit(\App\Models\Cabang $cabang)
    {
        return view('cabangs.edit', compact('cabang'));
    }

    public function update(Request $request, \App\Models\Cabang $cabang)
    {
        $validated = $request->validate([
            'kode_cabang' => 'required|string|max:255|unique:cabangs,kode_cabang,' . $cabang->id,
            'name' => 'required|string|max:255',
            'kepala_cabang' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $validated['location'] = 'Jawa Barat';
        $cabang->update($validated);
        return redirect()->route('cabangs.index')->with('success', 'Data kantor cabang berhasil diperbarui');
    }

    public function destroy(\App\Models\Cabang $cabang)
    {
        $cabang->delete();
        return redirect()->route('cabangs.index')->with('success', 'Data kantor cabang berhasil dihapus');
    }
}
