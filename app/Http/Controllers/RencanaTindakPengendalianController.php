<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RencanaTindakPengendalianController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $rencanas = \App\Models\RencanaTindakPengendalian::with('resiko.cabang')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('rencana_tindak.index', compact('rencanas'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $resikos = \App\Models\Resiko::when($userCabangId, function($q) use ($userCabangId) {
            return $q->where('cabang_id', $userCabangId);
        })->get();
        return view('rencana_tindak.create', compact('resikos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rows' => 'required|array',
            'rows.*.resiko_id' => 'required|exists:resikos,id',
            'rows.*.rencana_tindak' => 'required|string',
            'rows.*.waktu_pelaksanaan' => 'required|string',
            'rows.*.penanggung_jawab' => 'required|string',
            'rows.*.respons_risiko' => 'nullable|string',
            'rows.*.klasifikasi_sub_unsur_spip' => 'nullable|string',
            'rows.*.indikator_keluaran' => 'nullable|string',
            'rows.*.frekuensi' => 'nullable|string',
            'rows.*.dampak' => 'nullable|string',
            'rows.*.level_risiko' => 'nullable|string',
        ]);

        $count = 0;
        foreach ($request->rows as $rowData) {
            \App\Models\RencanaTindakPengendalian::create($rowData);
            $count++;
        }

        return redirect()->route('rencana-tindak.index')->with('success', $count . ' Rencana tindak pengendalian berhasil ditambahkan.');
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
