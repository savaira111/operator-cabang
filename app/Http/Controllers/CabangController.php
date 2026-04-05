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
        return view('cabangs.create');
    }

    public function show(\App\Models\Cabang $cabang)
    {
        return view('cabangs.show', compact('cabang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
