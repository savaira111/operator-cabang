<?php

namespace App\Http\Controllers;

use App\Models\MasterRiskCode;
use App\Models\MasterCauseCode;
use Illuminate\Http\Request;

class MasterResikoController extends Controller
{
    public function index()
    {
        $riskCodes = MasterRiskCode::orderBy('kode')->get();
        $causeCodes = MasterCauseCode::orderBy('kode')->get();
        return view('master_resiko.index', compact('riskCodes', 'causeCodes'));
    }

    public function storeRisk(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:master_risk_codes,kode',
            'nama_risiko' => 'required',
        ]);

        MasterRiskCode::create($validated);
        return back()->with('success', 'Kode Risiko berhasil ditambahkan');
    }

    public function updateRisk(Request $request, MasterRiskCode $risk)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:master_risk_codes,kode,' . $risk->id,
            'nama_risiko' => 'required',
        ]);

        $risk->update($validated);
        return back()->with('success', 'Kode Risiko berhasil diperbarui');
    }

    public function destroyRisk(MasterRiskCode $risk)
    {
        $risk->delete();
        return back()->with('success', 'Kode Risiko berhasil dihapus');
    }

    public function storeCause(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:master_cause_codes,kode',
            'nama_penyebab' => 'required',
        ]);

        MasterCauseCode::create($validated);
        return back()->with('success', 'Kode Penyebab berhasil ditambahkan');
    }

    public function updateCause(Request $request, MasterCauseCode $cause)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:master_cause_codes,kode,' . $cause->id,
            'nama_penyebab' => 'required',
        ]);

        $cause->update($validated);
        return back()->with('success', 'Kode Penyebab berhasil diperbarui');
    }

    public function destroyCause(MasterCauseCode $cause)
    {
        $cause->delete();
        return back()->with('success', 'Kode Penyebab berhasil dihapus');
    }
}
