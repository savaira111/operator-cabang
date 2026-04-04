<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResikoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resikos = \App\Models\Resiko::with('cabang')->get();
        return view('resikos.index', compact('resikos'));
    }

    public function create()
    {
        $cabangs = \App\Models\Cabang::all();
        return view('resikos.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'cabang_id' => 'required|exists:cabangs,id',
        ]);
        \App\Models\Resiko::create($validated);
        return redirect()->route('resikos.index')->with('success', 'Risk identified successfully');
    }

    public function edit(\App\Models\Resiko $resiko)
    {
        $cabangs = \App\Models\Cabang::all();
        return view('resikos.edit', compact('resiko', 'cabangs'));
    }

    public function update(Request $request, \App\Models\Resiko $resiko)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:low,medium,high',
            'description' => 'nullable|string',
            'cabang_id' => 'required|exists:cabangs,id',
        ]);
        $resiko->update($validated);
        return redirect()->route('resikos.index')->with('success', 'Risk updated successfully');
    }

    public function destroy(\App\Models\Resiko $resiko)
    {
        $resiko->delete();
        return redirect()->route('resikos.index')->with('success', 'Risk removed successfully');
    }
}
