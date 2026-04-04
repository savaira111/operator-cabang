<?php

namespace App\Http\Controllers;

use App\Models\Tahanan;
use Illuminate\Http\Request;

class TahananController extends Controller
{
    public function index()
    {
        $tahanans = \App\Models\Tahanan::with('cabang')->get();
        $cabangs = \App\Models\Cabang::all();
        return view('tahanans.index', compact('tahanans', 'cabangs'));
    }

    public function create()
    {
        $cabangs = \App\Models\Cabang::all();
        return view('tahanans.create', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'excel_file' => 'nullable|file|mimes:xlsx,xls,csv|max:5120',
            'keterangan' => 'nullable|string',
        ]);

        // Auto generation logic for No Input
        $month = date('m');
        $year = date('Y');
        $cabangId = str_pad($request->cabang_id, 2, '0', STR_PAD_LEFT);
        
        $lastRecord = \App\Models\Tahanan::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->orderBy('id', 'desc')
                        ->first();
        
        $count = $lastRecord ? (int)explode('/', $lastRecord->no_input)[0] + 1 : 1;
        $noUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
        
        $validated['no_input'] = "{$noUrut}/{$month}-{$year}/{$cabangId}";
        $validated['tanggal_input'] = now();

        // Handle File Upload
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/tahanans'), $fileName);
            $validated['file_path'] = 'uploads/tahanans/' . $fileName;
        }

        \App\Models\Tahanan::create($validated);
        return redirect()->route('tahanans.index')->with('success', 'Data laporan tahanan berhasil dicatat dan muncul di riwayat');
    }

    public function show(Tahanan $tahanan)
    {
        //
    }

    public function edit(Tahanan $tahanan)
    {
        $cabangs = \App\Models\Cabang::all();
        return view('tahanans.edit', compact('tahanan', 'cabangs'));
    }

    public function update(Request $request, Tahanan $tahanan)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabangs,id',
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $tahanan->update($validated);
        return redirect()->route('tahanans.index')->with('success', 'Data laporan tahanan berhasil diperbarui');
    }

    public function destroy(Tahanan $tahanan)
    {
        $tahanan->delete();
        return redirect()->route('tahanans.index')->with('success', 'Data tahanan berhasil dihapus');
    }
}
