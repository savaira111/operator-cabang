<?php

namespace App\Http\Controllers;

use App\Models\ZiMonitoring;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ZiMonitoringController extends Controller
{
    public function index()
    {
        $monitorings = ZiMonitoring::with(['cabang', 'children'])
            ->whereNull('parent_id')
            ->orderBy('nomor')
            ->get();

        return view('zi_monitoring.index', compact('monitorings'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        $parents = ZiMonitoring::whereIn('tipe', ['SS1', 'SS2', 'K'])->get();
        return view('zi_monitoring.create', compact('cabangs', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'parent_id' => 'nullable|exists:zi_monitorings,id',
            'tipe' => 'required|in:SS1,SS2,K,RK',
            'nomor' => 'required|string',
            'sasaran_kegiatan' => 'nullable|string',
            'indikator' => 'nullable|string',
            'target' => 'nullable|string',
            'outcome' => 'nullable|string',
            'rincian_kegiatan' => 'nullable|string',
            'indikator_output' => 'nullable|string',
            'target_output' => 'nullable|string',
            'waktu_pelaksanaan' => 'nullable|array',
            'anggaran' => 'nullable|string',
            'pelaksana' => 'nullable|string',
            'koordinator' => 'nullable|string',
            'status_data_dukung' => 'required|in:sesuai,menunggu,tidak_sesuai,belum_ada',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'data_dukung' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        if ($request->hasFile('data_dukung')) {
            $path = $request->file('data_dukung')->store('zi_monitoring', 'public');
            $validated['data_dukung'] = $path;
        }

        if (isset($validated['waktu_pelaksanaan'])) {
            $validated['waktu_pelaksanaan'] = implode(',', $validated['waktu_pelaksanaan']);
        }

        ZiMonitoring::create($validated);

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil ditambahkan.');
    }

    public function show(ZiMonitoring $ziMonitoring)
    {
        return view('zi_monitoring.show', compact('ziMonitoring'));
    }

    public function edit(ZiMonitoring $ziMonitoring)
    {
        $cabangs = Cabang::all();
        $parents = ZiMonitoring::where('id', '!=', $ziMonitoring->id)
            ->whereIn('tipe', ['SS1', 'SS2', 'K'])
            ->get();
        $selectedWaktu = explode(',', $ziMonitoring->waktu_pelaksanaan);
        
        return view('zi_monitoring.edit', compact('ziMonitoring', 'cabangs', 'parents', 'selectedWaktu'));
    }

    public function update(Request $request, ZiMonitoring $ziMonitoring)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'parent_id' => 'nullable|exists:zi_monitorings,id',
            'tipe' => 'required|in:SS1,SS2,K,RK',
            'nomor' => 'required|string',
            'sasaran_kegiatan' => 'nullable|string',
            'indikator' => 'nullable|string',
            'target' => 'nullable|string',
            'outcome' => 'nullable|string',
            'rincian_kegiatan' => 'nullable|string',
            'indikator_output' => 'nullable|string',
            'target_output' => 'nullable|string',
            'waktu_pelaksanaan' => 'nullable|array',
            'anggaran' => 'nullable|string',
            'pelaksana' => 'nullable|string',
            'koordinator' => 'nullable|string',
            'status_data_dukung' => 'required|in:sesuai,menunggu,tidak_sesuai,belum_ada',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'data_dukung' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        if ($request->hasFile('data_dukung')) {
            if ($ziMonitoring->data_dukung) {
                Storage::disk('public')->delete($ziMonitoring->data_dukung);
            }
            $path = $request->file('data_dukung')->store('zi_monitoring', 'public');
            $validated['data_dukung'] = $path;
        }

        if (isset($validated['waktu_pelaksanaan'])) {
            $validated['waktu_pelaksanaan'] = implode(',', $validated['waktu_pelaksanaan']);
        } else {
            $validated['waktu_pelaksanaan'] = null;
        }

        $ziMonitoring->update($validated);

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil diperbarui.');
    }

    public function destroy(ZiMonitoring $ziMonitoring)
    {
        if ($ziMonitoring->data_dukung) {
            Storage::disk('public')->delete($ziMonitoring->data_dukung);
        }
        $ziMonitoring->delete();

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil dihapus.');
    }
}
