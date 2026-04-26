<?php

namespace App\Http\Controllers;

use App\Models\ReviuUsulanRisiko;
use App\Models\Resiko;
use Illuminate\Http\Request;

class ReviuUsulanRisikoController extends Controller
{
    public function index()
    {
        $revius = ReviuUsulanRisiko::with('resiko')->get();
        return view('reviu_usulan.index', compact('revius'));
    }

    public function create()
    {
        $resikos = Resiko::all();
        return view('reviu_usulan.create', compact('resikos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'usulan_pernyataan_risiko' => 'required|string',
            'unit_pemilik_pengusul' => 'required|string',
            'status' => 'required|in:Diterima,Ditolak',
            'alasan_diterima' => 'nullable|string',
            'alasan_ditolak' => 'nullable|string',
        ]);

        // Logic for auto-filling strip (-)
        if ($validated['status'] === 'Diterima') {
            $validated['alasan_ditolak'] = '-';
        } else {
            $validated['alasan_diterima'] = '-';
        }

        ReviuUsulanRisiko::create($validated);

        return redirect()->route('reviu-usulan.index')->with('success', 'Data Reviu Usulan Risiko berhasil ditambahkan.');
    }

    public function show(ReviuUsulanRisiko $reviuUsulan)
    {
        return view('reviu_usulan.show', compact('reviuUsulan'));
    }

    public function edit(ReviuUsulanRisiko $reviuUsulan)
    {
        $resikos = Resiko::all();
        return view('reviu_usulan.edit', compact('reviuUsulan', 'resikos'));
    }

    public function update(Request $request, ReviuUsulanRisiko $reviuUsulan)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'usulan_pernyataan_risiko' => 'required|string',
            'unit_pemilik_pengusul' => 'required|string',
            'status' => 'required|in:Diterima,Ditolak',
            'alasan_diterima' => 'nullable|string',
            'alasan_ditolak' => 'nullable|string',
        ]);

        if ($validated['status'] === 'Diterima') {
            $validated['alasan_ditolak'] = '-';
        } else {
            $validated['alasan_diterima'] = '-';
        }

        $reviuUsulan->update($validated);

        return redirect()->route('reviu-usulan.index')->with('success', 'Data Reviu Usulan Risiko berhasil diperbarui.');
    }

    public function destroy(ReviuUsulanRisiko $reviuUsulan)
    {
        $reviuUsulan->delete();
        return redirect()->route('reviu-usulan.index')->with('success', 'Data Reviu Usulan Risiko berhasil dihapus.');
    }
}
