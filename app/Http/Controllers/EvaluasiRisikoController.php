<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiRisiko;
use App\Models\Resiko;
use App\Models\RencanaTindakPengendalian;
use App\Models\AnalisisRisiko;
use Illuminate\Http\Request;

class EvaluasiRisikoController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id;
        $evaluasis = EvaluasiRisiko::with(['resiko.rencanaTindak.pemantauanKegiatan'])
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->whereHas('resiko', function($sq) use ($userCabangId) {
                    $sq->where('cabang_id', $userCabangId);
                });
            })
            ->get();
        
        // Enhance with related data
        foreach($evaluasis as $e) {
            $e->rtp = RencanaTindakPengendalian::where('resiko_id', $e->resiko_id)->first();
            $e->analisis = AnalisisRisiko::whereHas('identifikasiRisiko', function($q) use ($e) {
                $q->where('pernyataan_risiko', $e->resiko->pernyataan_risiko);
            })->first();
        }

        return view('evaluasi_risiko.index', compact('evaluasis'));
    }

    public function create()
    {
        $userCabangId = auth()->user()->cabang_id;
        $resikos = Resiko::with('rencanaTindak')
            ->when($userCabangId, function($q) use ($userCabangId) {
                return $q->where('cabang_id', $userCabangId);
            })
            ->get();
        
        // Prepare data for auto-fill
        foreach($resikos as $r) {
            $rtp = RencanaTindakPengendalian::where('resiko_id', $r->id)->first();
            $analisis = AnalisisRisiko::whereHas('identifikasiRisiko', function($q) use ($r) {
                $q->where('pernyataan_risiko', $r->pernyataan_risiko);
            })->first();
            
            $r->risiko_direspons = $rtp ? $rtp->level_risiko : '-';
            $r->risiko_aktual = $analisis ? $analisis->level_risiko_residu : '-';
            $r->kode_penyebab = $r->kode_penyebab_jenis . $r->kode_penyebab_nomor;
        }

        return view('evaluasi_risiko.create', compact('resikos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'pemilik_risiko' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        EvaluasiRisiko::create($validated);

        return redirect()->route('evaluasi-risiko.index')->with('success', 'Data Evaluasi Risiko berhasil ditambahkan.');
    }

    public function show(EvaluasiRisiko $evaluasiRisiko)
    {
        $evaluasiRisiko->rtp = RencanaTindakPengendalian::where('resiko_id', $evaluasiRisiko->resiko_id)->first();
        $evaluasiRisiko->analisis = AnalisisRisiko::whereHas('identifikasiRisiko', function($q) use ($evaluasiRisiko) {
            $q->where('pernyataan_risiko', $evaluasiRisiko->resiko->pernyataan_risiko);
        })->first();

        return view('evaluasi_risiko.show', compact('evaluasiRisiko'));
    }

    public function edit(EvaluasiRisiko $evaluasiRisiko)
    {
        $userCabangId = auth()->user()->cabang_id;
        $resikos = Resiko::when($userCabangId, function($q) use ($userCabangId) {
            return $q->where('cabang_id', $userCabangId);
        })->get();
        foreach($resikos as $r) {
            $rtp = RencanaTindakPengendalian::where('resiko_id', $r->id)->first();
            $analisis = AnalisisRisiko::whereHas('identifikasiRisiko', function($q) use ($r) {
                $q->where('pernyataan_risiko', $r->pernyataan_risiko);
            })->first();
            
            $r->risiko_direspons = $rtp ? $rtp->level_risiko : '-';
            $r->risiko_aktual = $analisis ? $analisis->level_risiko_residu : '-';
            $r->kode_penyebab = $r->kode_penyebab_jenis . $r->kode_penyebab_nomor;
        }
        return view('evaluasi_risiko.edit', compact('evaluasiRisiko', 'resikos'));
    }

    public function update(Request $request, EvaluasiRisiko $evaluasiRisiko)
    {
        $validated = $request->validate([
            'resiko_id' => 'required|exists:resikos,id',
            'pemilik_risiko' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        $evaluasiRisiko->update($validated);

        return redirect()->route('evaluasi-risiko.index')->with('success', 'Data Evaluasi Risiko berhasil diperbarui.');
    }

    public function destroy(EvaluasiRisiko $evaluasiRisiko)
    {
        $evaluasiRisiko->delete();
        return redirect()->route('evaluasi-risiko.index')->with('success', 'Data Evaluasi Risiko berhasil dihapus.');
    }
}
