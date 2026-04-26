<?php

namespace App\Http\Controllers;

use App\Models\RencanaBelumTerealisasi;
use App\Models\RencanaTindakPengendalian;
use Illuminate\Http\Request;

class RencanaBelumTerealisasiController extends Controller
{
    public function index()
    {
        $rencanas = RencanaBelumTerealisasi::with(['rencanaTindakPengendalian.resiko'])->get();
        return view('rencana_belum_terealisasi.index', compact('rencanas'));
    }

    public function create()
    {
        $rencanaTindaks = RencanaTindakPengendalian::with('resiko')->get();
        return view('rencana_belum_terealisasi.create', compact('rencanaTindaks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rencana_tindak_pengendalian_id' => 'required|exists:rencana_tindak_pengendalians,id',
            'keterangan' => 'required|string',
        ]);

        RencanaBelumTerealisasi::create($validated);

        return redirect()->route('rencana-belum-terealisasi.index')->with('success', 'Data Rencana Kegiatan Belum Terealisasi berhasil ditambahkan.');
    }

    public function show(RencanaBelumTerealisasi $rencanaBelumTerealisasi)
    {
        return view('rencana_belum_terealisasi.show', compact('rencanaBelumTerealisasi'));
    }

    public function edit(RencanaBelumTerealisasi $rencanaBelumTerealisasi)
    {
        $rencanaTindaks = RencanaTindakPengendalian::with('resiko')->get();
        return view('rencana_belum_terealisasi.edit', compact('rencanaBelumTerealisasi', 'rencanaTindaks'));
    }

    public function update(Request $request, RencanaBelumTerealisasi $rencanaBelumTerealisasi)
    {
        $validated = $request->validate([
            'rencana_tindak_pengendalian_id' => 'required|exists:rencana_tindak_pengendalians,id',
            'keterangan' => 'required|string',
        ]);

        $rencanaBelumTerealisasi->update($validated);

        return redirect()->route('rencana-belum-terealisasi.index')->with('success', 'Data Rencana Kegiatan Belum Terealisasi berhasil diperbarui.');
    }

    public function destroy(RencanaBelumTerealisasi $rencanaBelumTerealisasi)
    {
        $rencanaBelumTerealisasi->delete();
        return redirect()->route('rencana-belum-terealisasi.index')->with('success', 'Data Rencana Kegiatan Belum Terealisasi berhasil dihapus.');
    }
}
