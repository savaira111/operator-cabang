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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kepala_cabang' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        \App\Models\Cabang::create($validated);
        return redirect()->route('cabangs.index')->with('success', 'Cabang created successfully');
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
            'location' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        $cabang->update($validated);
        return redirect()->route('cabangs.index')->with('success', 'Cabang updated successfully');
    }

    public function destroy(\App\Models\Cabang $cabang)
    {
        $cabang->delete();
        return redirect()->route('cabangs.index')->with('success', 'Cabang deleted successfully');
    }
}
