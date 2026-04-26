<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RencanaTindakPengendalianController extends Controller
{
    public function index()
    {
        $rencanas = \App\Models\RencanaTindakPengendalian::with('resiko.cabang')->get();
        return view('rencana_tindak.index', compact('rencanas'));
    }

    public function create()
    {
        $resikos = \App\Models\Resiko::all();
        return view('rencana_tindak.create', compact('resikos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'rencana_tindak' => 'required|string',
            'waktu_pelaksanaan' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'respons_risiko' => 'nullable|string',
            'klasifikasi_sub_unsur_spip' => 'nullable|string',
            'indikator_keluaran' => 'nullable|string',
            'frekuensi' => 'nullable|string',
            'dampak' => 'nullable|string',
            'level_risiko' => 'nullable|string',
        ]);

        \App\Models\RencanaTindakPengendalian::create($validated);
        return redirect()->route('rencana-tindak.index')->with('success', 'Rencana tindak pengendalian berhasil ditambahkan.');
    }

    public function show(\App\Models\RencanaTindakPengendalian $rencana_tindak)
    {
        $rencana_tindak->load('resiko');
        return view('rencana_tindak.show', compact('rencana_tindak'));
    }

    public function edit(\App\Models\RencanaTindakPengendalian $rencana_tindak)
    {
        $resikos = \App\Models\Resiko::all();
        return view('rencana_tindak.edit', compact('rencana_tindak', 'resikos'));
    }

    public function update(Request $request, \App\Models\RencanaTindakPengendalian $rencana_tindak)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'rencana_tindak' => 'required|string',
            'waktu_pelaksanaan' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'respons_risiko' => 'nullable|string',
            'klasifikasi_sub_unsur_spip' => 'nullable|string',
            'indikator_keluaran' => 'nullable|string',
            'frekuensi' => 'nullable|string',
            'dampak' => 'nullable|string',
            'level_risiko' => 'nullable|string',
        ]);

        $rencana_tindak->update($validated);
        return redirect()->route('rencana-tindak.index')->with('success', 'Rencana tindak pengendalian berhasil diperbarui.');
    }

    public function destroy(\App\Models\RencanaTindakPengendalian $rencana_tindak)
    {
        $rencana_tindak->delete();
        return redirect()->route('rencana-tindak.index')->with('success', 'Rencana tindak pengendalian berhasil dihapus.');
    }
}
