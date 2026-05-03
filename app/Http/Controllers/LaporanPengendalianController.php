<?php

namespace App\Http\Controllers;

use App\Models\LaporanPengendalian;
use App\Models\Cabang;
use Illuminate\Http\Request;

class LaporanPengendalianController extends Controller
{
    public function index()
    {
        $userCabangId = auth()->user()->cabang_id 
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->username . '%')->first()?->id
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $query = LaporanPengendalian::with('cabang');
        
        if ($userCabangId) {
            $query->where('cabang_id', $userCabangId);
        }

        $laporans = $query->latest()->get();
        return view('laporan_pengendalians.index', compact('laporans'));
    }

    public function create()
    {
        $cabangs = Cabang::all();
        return view('laporan_pengendalians.create', compact('cabangs'));
    }

        $userCabangId = auth()->user()->cabang_id 
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->username . '%')->first()?->id
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $rules = [
            'nama_laporan' => 'required|string',
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,jpg,png|max:10240',
            'keterangan' => 'nullable|string',
        ];

        if (!$userCabangId) {
            $rules['cabang_id'] = 'required|exists:cabangs,id';
        }

        $validated = $request->validate($rules);
        $validated['cabang_id'] = $userCabangId ?? $request->cabang_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lpi'), $fileName);
            $validated['file_path'] = 'uploads/lpi/' . $fileName;
        }

        LaporanPengendalian::create($validated);

        return redirect()->route('laporan-pengendalian.index')->with('success', 'Laporan LPI Tambahan berhasil ditambahkan.');
    }

    public function edit(LaporanPengendalian $laporanPengendalian)
    {
        $cabangs = Cabang::all();
        return view('laporan_pengendalians.edit', compact('laporanPengendalian', 'cabangs'));
    }

    public function update(Request $request, LaporanPengendalian $laporanPengendalian)
    {
        $userCabangId = auth()->user()->cabang_id 
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->username . '%')->first()?->id
            ?: \App\Models\Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $rules = [
            'nama_laporan' => 'required|string',
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls,jpg,png|max:10240',
            'keterangan' => 'nullable|string',
            'status_evaluasi' => 'nullable|string',
            'prosentase' => 'nullable|integer|min:0|max:100',
            'catatan_evaluasi' => 'nullable|string',
        ];

        if (!$userCabangId) {
            $rules['cabang_id'] = 'required|exists:cabangs,id';
        }

        $validated = $request->validate($rules);
        $validated['cabang_id'] = $userCabangId ?? $request->cabang_id;

        if ($request->hasFile('file')) {
            if ($laporanPengendalian->file_path && file_exists(public_path($laporanPengendalian->file_path))) {
                @unlink(public_path($laporanPengendalian->file_path));
            }
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lpi'), $fileName);
            $validated['file_path'] = 'uploads/lpi/' . $fileName;
        }

        $laporanPengendalian->update($validated);

        return redirect()->route('laporan-pengendalian.index')->with('success', 'Laporan LPI Tambahan berhasil diperbarui.');
    }

    public function destroy(LaporanPengendalian $laporanPengendalian)
    {
        if ($laporanPengendalian->file_path && file_exists(public_path($laporanPengendalian->file_path))) {
            @unlink(public_path($laporanPengendalian->file_path));
        }
        $laporanPengendalian->delete();
        return redirect()->route('laporan-pengendalian.index')->with('success', 'Laporan LPI Tambahan berhasil dihapus.');
    }
}
