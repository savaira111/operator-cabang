<?php

namespace App\Http\Controllers;

use App\Models\LaporanInternalExcel;
use App\Models\Cabang;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LaporanInternalExcelController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->get('category_id', 1);
        $userCabangId = auth()->user()->cabang_id ?: Cabang::where('name', 'like', '%' . auth()->user()->username . '%')->first()?->id
            ?: Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $query = LaporanInternalExcel::with('cabang')->where('category_id', $categoryId);
        
        if ($userCabangId) {
            $query->where('cabang_id', $userCabangId);
        }

        $reports = $query->get();
        $cabangs = Cabang::all();
        $categories = LaporanInternalExcel::getCategories();

        return view('laporan_internal_excel.index', compact('reports', 'cabangs', 'categories', 'categoryId'));
    }

    public function store(Request $request)
    {
        $userCabangId = auth()->user()->cabang_id ?: Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $rules = [
            'category_id' => 'required|integer|min:1|max:11',
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
            'keterangan' => 'nullable|string',
        ];

        if (!$userCabangId) {
            $rules['cabang_id'] = 'required|exists:cabangs,id';
        }

        $validated = $request->validate($rules);
        $validated['cabang_id'] = $userCabangId ?? $request->cabang_id;

        // Auto generation logic for No Input
        $month = date('m');
        $year = date('Y');
        $cabangId = str_pad($validated['cabang_id'], 2, '0', STR_PAD_LEFT);
        
        $lastRecord = LaporanInternalExcel::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->orderBy('id', 'desc')
                        ->first();
        
        $count = $lastRecord ? (int)explode('/', $lastRecord->no_input)[0] + 1 : 1;
        $noUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
        
        $validated['no_input'] = "{$noUrut}/EXC-LPI/{$month}-{$year}/{$cabangId}";
        $validated['tanggal_input'] = now();

        // Handle File Upload
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $fileName = time() . '_cat' . $validated['category_id'] . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lpi_excel'), $fileName);
            $validated['file_path'] = 'uploads/lpi_excel/' . $fileName;
        }

        LaporanInternalExcel::create($validated);
        return redirect()->route('laporan-internal-excel.index', ['category_id' => $validated['category_id']])
            ->with('success', 'Laporan Excel berhasil diimpor');
    }

    public function show(LaporanInternalExcel $laporanInternalExcel)
    {
        $laporanInternalExcel->load('cabang');
        
        $excelData = [];
        if ($laporanInternalExcel->file_path && file_exists(public_path($laporanInternalExcel->file_path))) {
            try {
                $spreadsheet = IOFactory::load(public_path($laporanInternalExcel->file_path));
                $sheet = $spreadsheet->getActiveSheet();
                $allData = $sheet->toArray(null, true, true, true);
                
                // Find the first row that actually looks like a header (contains non-empty values)
                $headerRowIndex = null;
                foreach ($allData as $index => $row) {
                    $filledCells = array_filter($row);
                    if (count($filledCells) >= 3) { // Assume a header has at least 3 columns
                        $headerRowIndex = $index;
                        break;
                    }
                }

                if ($headerRowIndex !== null) {
                    // Skip rows before the header
                    $excelData = array_slice($allData, array_search($headerRowIndex, array_keys($allData)));
                } else {
                    $excelData = $allData;
                }
            } catch (\Exception $e) {
                \Log::error('Error parsing excel: ' . $e->getMessage());
            }
        }

        return view('laporan_internal_excel.show', [
            'report' => $laporanInternalExcel,
            'excelData' => $excelData
        ]);
    }

    public function edit(LaporanInternalExcel $laporanInternalExcel)
    {
        $cabangs = Cabang::all();
        $categories = LaporanInternalExcel::getCategories();
        return view('laporan_internal_excel.edit', [
            'report' => $laporanInternalExcel,
            'cabangs' => $cabangs,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, LaporanInternalExcel $laporanInternalExcel)
    {
        $userCabangId = auth()->user()->cabang_id 
            ?: Cabang::where('name', 'like', '%' . auth()->user()->username . '%')->first()?->id
            ?: Cabang::where('name', 'like', '%' . auth()->user()->name . '%')->first()?->id;

        $rules = [
            'periode_bulan' => 'required|string',
            'periode_tahun' => 'required|integer',
            'excel_file' => 'nullable|file|mimes:xlsx,xls,csv|max:5120',
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

        // Handle File Update
        if ($request->hasFile('excel_file')) {
            if ($laporanInternalExcel->file_path && file_exists(public_path($laporanInternalExcel->file_path))) {
                @unlink(public_path($laporanInternalExcel->file_path));
            }

            $file = $request->file('excel_file');
            $fileName = time() . '_cat' . $laporanInternalExcel->category_id . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/lpi_excel'), $fileName);
            $validated['file_path'] = 'uploads/lpi_excel/' . $fileName;
        }

        $laporanInternalExcel->update($validated);
        return redirect()->route('laporan-internal-excel.index', ['category_id' => $laporanInternalExcel->category_id])
            ->with('success', 'Laporan Excel berhasil diperbarui');
    }

    public function destroy(LaporanInternalExcel $laporanInternalExcel)
    {
        $catId = $laporanInternalExcel->category_id;
        if ($laporanInternalExcel->file_path && file_exists(public_path($laporanInternalExcel->file_path))) {
            @unlink(public_path($laporanInternalExcel->file_path));
        }
        $laporanInternalExcel->delete();
        return redirect()->route('laporan-internal-excel.index', ['category_id' => $catId])
            ->with('success', 'Laporan Excel berhasil dihapus');
    }
}
