<?php

namespace App\Http\Controllers;

use App\Models\PemantauanKegiatan;
use App\Models\RencanaTindakPengendalian;
use Illuminate\Http\Request;

class PemantauanKegiatanController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $pemantauans = PemantauanKegiatan::with(['rencanaTindak.resiko'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('rencanaTindak.resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('pemantauan_kegiatan.index', compact('pemantauans'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $rencanas = RencanaTindakPengendalian::with(['resiko'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('pemantauan_kegiatan.create', compact('rencanas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rencana_tindak_pengendalian_id' => 'required|exists:rencana_tindak_pengendalians,id',
            'realisasi_waktu' => 'required|string',
            'hambatan_kendala' => 'required|string',
        ]);

        PemantauanKegiatan::create($validated);

        return redirect()->route('pemantauan-kegiatan.index')->with('success', 'Data Pemantauan Kegiatan Pengendalian berhasil ditambahkan.');
    }

    public function show(PemantauanKegiatan $pemantauanKegiatan)
    {
        $pemantauanKegiatan->load(['rencanaTindak.resiko']);
        return view('pemantauan_kegiatan.show', compact('pemantauanKegiatan'));
    }

    public function edit(PemantauanKegiatan $pemantauanKegiatan)
    {
        $userCabangId = auth()->user()->cabang_id;
        $rencanas = RencanaTindakPengendalian::with(['resiko'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('pemantauan_kegiatan.edit', compact('pemantauanKegiatan', 'rencanas'));
    }

    public function update(Request $request, PemantauanKegiatan $pemantauanKegiatan)
    {
        $validated = $request->validate([
            'rencana_tindak_pengendalian_id' => 'required|exists:rencana_tindak_pengendalians,id',
            'realisasi_waktu' => 'required|string',
            'hambatan_kendala' => 'required|string',
        ]);

        $pemantauanKegiatan->update($validated);

        return redirect()->route('pemantauan-kegiatan.index')->with('success', 'Data Pemantauan Kegiatan Pengendalian berhasil diperbarui.');
    }

    public function destroy(PemantauanKegiatan $pemantauanKegiatan)
    {
        $pemantauanKegiatan->delete();
        return redirect()->route('pemantauan-kegiatan.index')->with('success', 'Data Pemantauan Kegiatan Pengendalian berhasil dihapus.');
    }
}
