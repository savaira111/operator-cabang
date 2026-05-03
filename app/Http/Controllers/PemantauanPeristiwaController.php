<?php

namespace App\Http\Controllers;

use App\Models\PemantauanPeristiwa;
use App\Models\PemantauanKegiatan;
use Illuminate\Http\Request;

class PemantauanPeristiwaController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $peristiwas = PemantauanPeristiwa::with(['pemantauanKegiatan.rencanaTindak.resiko'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('pemantauanKegiatan.rencanaTindak.resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('pemantauan_peristiwa.index', compact('peristiwas'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $pemantauanKegiatans = PemantauanKegiatan::with(['rencanaTindak.resiko'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('rencanaTindak.resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        return view('pemantauan_peristiwa.create', compact('pemantauanKegiatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pemantauan_kegiatan_id' => 'required|exists:pemantauan_kegiatans,id',
            'uraian_peristiwa' => 'required|string',
            'waktu_kejadian' => 'required|string',
            'tempat_kejadian' => 'required|string',
            'skor_dampak' => 'required|integer|min:1|max:5',
            'pemicu_peristiwa' => 'required|string',
        ]);

        PemantauanPeristiwa::create($validated);

        return redirect()->route('pemantauan-peristiwa.index')->with('success', 'Data Pemantauan Peristiwa berhasil ditambahkan.');
    }

    public function show(PemantauanPeristiwa $pemantauanPeristiwa)
    {
        $pemantauanPeristiwa->load(['pemantauanKegiatan.rencanaTindak.resiko']);
        return view('pemantauan_peristiwa.show', compact('pemantauanPeristiwa'));
    }

    public function edit(PemantauanPeristiwa $pemantauanPeristiwa)
    {
        $pemantauanKegiatans = PemantauanKegiatan::with(['rencanaTindak.resiko'])->get();
        return view('pemantauan_peristiwa.edit', compact('pemantauanPeristiwa', 'pemantauanKegiatans'));
    }

    public function update(Request $request, PemantauanPeristiwa $pemantauanPeristiwa)
    {
        $validated = $request->validate([
            'pemantauan_kegiatan_id' => 'required|exists:pemantauan_kegiatans,id',
            'uraian_peristiwa' => 'required|string',
            'waktu_kejadian' => 'required|string',
            'tempat_kejadian' => 'required|string',
            'skor_dampak' => 'required|integer|min:1|max:5',
            'pemicu_peristiwa' => 'required|string',
        ]);

        $pemantauanPeristiwa->update($validated);

        return redirect()->route('pemantauan-peristiwa.index')->with('success', 'Data Pemantauan Peristiwa berhasil diperbarui.');
    }

    public function destroy(PemantauanPeristiwa $pemantauanPeristiwa)
    {
        $pemantauanPeristiwa->delete();
        return redirect()->route('pemantauan-peristiwa.index')->with('success', 'Data Pemantauan Peristiwa berhasil dihapus.');
    }
}
