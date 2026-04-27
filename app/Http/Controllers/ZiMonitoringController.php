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
        $ss_parents = ZiMonitoring::where('tipe', 'SS2')->orderBy('nomor')->get();
        $k_parents = ZiMonitoring::where('tipe', 'K')->orderBy('nomor')->get();
        
        return view('zi_monitoring.create', compact('cabangs', 'ss_parents', 'k_parents'));
    }

    public function store(Request $request)
    {
        // Handle potential bulk IO submission
        if ($request->has('io_entries')) {
            return $this->storeBulk($request);
        }

        $validated = $request->validate([
            'cabang_id' => 'nullable|exists:cabangs,id',
            'tipe' => 'required|in:SS2,K,IO',
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
            'status_data_dukung' => 'nullable|in:sesuai,menunggu,tidak_sesuai,belum_ada',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'data_dukung' => 'nullable|string',
        ]);

        $validated['status_data_dukung'] = $validated['status_data_dukung'] ?? 'belum_ada';

        // Determine Parent ID from hierarchy selection if provided
        $parent_id = null;

        // 1. If SS is selected/created
        if ($request->ss_selection_mode) {
            if ($request->ss_selection_mode === 'new' && $request->new_ss_name) {
                $ss = ZiMonitoring::create([
                    'cabang_id' => $validated['cabang_id'],
                    'tipe' => 'SS2',
                    'nomor' => $request->new_ss_nomor ?? 'SS.NEW',
                    'sasaran_kegiatan' => $request->new_ss_name,
                    'status_data_dukung' => 'belum_ada'
                ]);
                $parent_id = $ss->id;
            } else {
                $parent_id = $request->ss_selection;
            }
        }

        // 2. If K is selected/created (only if creating IO)
        if ($validated['tipe'] === 'IO' && $request->k_selection_mode) {
            if ($request->k_selection_mode === 'new' && $request->new_k_name) {
                $k = ZiMonitoring::create([
                    'cabang_id' => $validated['cabang_id'],
                    'parent_id' => $parent_id,
                    'tipe' => 'K',
                    'nomor' => $request->new_k_nomor ?? 'K.NEW',
                    'sasaran_kegiatan' => $request->new_k_name,
                    'status_data_dukung' => 'belum_ada'
                ]);
                $parent_id = $k->id;
            } else {
                $parent_id = $request->k_selection;
            }
        }

        $validated['parent_id'] = $parent_id;

        if (isset($validated['waktu_pelaksanaan'])) {
            $validated['waktu_pelaksanaan'] = implode(',', $validated['waktu_pelaksanaan']);
        }

        ZiMonitoring::create($validated);

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil ditambahkan.');
    }

    protected function storeBulk(Request $request)
    {
        $cabang_id = $request->cabang_id;
        $tipe = $request->tipe;
        $parent_id = null;

        // 1. Handle SS creation/selection
        if ($request->ss_selection_mode === 'new' && $request->new_ss_name) {
            $ss = ZiMonitoring::create([
                'cabang_id' => $cabang_id,
                'tipe' => 'SS2',
                'nomor' => $request->new_ss_nomor ?? 'SS.NEW',
                'sasaran_kegiatan' => $request->new_ss_name,
                'status_data_dukung' => 'belum_ada'
            ]);
            $parent_id = $ss->id;
        } elseif ($request->ss_selection) {
            $parent_id = $request->ss_selection;
        }

        // 2. Handle K creation/selection if tipe is IO
        if ($tipe === 'IO') {
            if ($request->k_selection_mode === 'new' && $request->new_k_name) {
                $k = ZiMonitoring::create([
                    'cabang_id' => $cabang_id,
                    'parent_id' => $parent_id,
                    'tipe' => 'K',
                    'nomor' => $request->new_k_nomor ?? 'K.NEW',
                    'sasaran_kegiatan' => $request->new_k_name,
                    'indikator' => $request->new_k_indikator,
                    'target' => $request->new_k_target,
                    'outcome' => $request->new_k_outcome,
                    'status_data_dukung' => 'belum_ada'
                ]);
                $parent_id = $k->id;
            } elseif ($request->k_selection) {
                $parent_id = $request->k_selection;
            }
        }

        // 3. Create IO entries
        if ($request->has('io_entries')) {
            foreach ($request->io_entries as $entry) {
                $data = array_merge($entry, [
                    'cabang_id' => $cabang_id,
                    'parent_id' => $parent_id,
                    'tipe' => 'IO',
                    'status_data_dukung' => $entry['status_data_dukung'] ?? 'belum_ada',
                ]);

                if (isset($data['waktu_pelaksanaan'])) {
                    $data['waktu_pelaksanaan'] = implode(',', $data['waktu_pelaksanaan']);
                }

                ZiMonitoring::create([
                    'cabang_id' => $cabang_id,
                    'parent_id' => $parent_id,
                    'tipe' => 'IO',
                    'nomor' => $entry['nomor'],
                    'rincian_kegiatan' => $entry['rincian_kegiatan'],
                    'status_data_dukung' => $entry['status_data_dukung'] ?? 'belum_ada',
                    'data_dukung' => $entry['data_dukung'] ?? null,
                    'prosentase' => 0,
                ]);
            }
        }

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil ditambahkan secara kolektif.');
    }

    public function show(ZiMonitoring $ziMonitoring)
    {
        return view('zi_monitoring.show', compact('ziMonitoring'));
    }

    public function edit(ZiMonitoring $ziMonitoring)
    {
        $cabangs = Cabang::all();
        $ss_parents = ZiMonitoring::where('tipe', 'SS2')->orderBy('nomor')->get();
        $k_parents = ZiMonitoring::where('tipe', 'K')->orderBy('nomor')->get();
        
        // Handle selected parent for time calculation etc if needed
        $selectedWaktu = $ziMonitoring->waktu_pelaksanaan ? explode(',', $ziMonitoring->waktu_pelaksanaan) : [];

        return view('zi_monitoring.edit', compact('ziMonitoring', 'cabangs', 'ss_parents', 'k_parents', 'selectedWaktu'));
    }

    public function update(Request $request, ZiMonitoring $ziMonitoring)
    {
        $validated = $request->validate([
            'cabang_id' => 'nullable|exists:cabangs,id',
            'tipe' => 'required|in:SS2,K,IO',
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
            'status_data_dukung' => 'nullable|in:sesuai,menunggu,tidak_sesuai,belum_ada',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'data_dukung' => 'nullable|string',
        ]);

        $validated['status_data_dukung'] = $validated['status_data_dukung'] ?? $ziMonitoring->status_data_dukung;

        // Handle Parent ID from hierarchical selects
        $parent_id = $request->parent_id;
        if ($validated['tipe'] === 'IO' && $request->k_selection) {
            $parent_id = $request->k_selection;
        } elseif ($request->ss_selection) {
            $parent_id = $request->ss_selection;
        }
        $validated['parent_id'] = $parent_id;

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
        $ziMonitoring->delete();

        return redirect()->route('zi-monitoring.index')->with('success', 'Data Monitoring Zi berhasil dihapus.');
    }
}
