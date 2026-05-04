$files = @(
    "rencana_tindak/create.blade.php",
    "rencana_tindak/edit.blade.php",
    "pemantauan_kegiatan/create.blade.php",
    "pemantauan_kegiatan/edit.blade.php",
    "pemantauan_peristiwa/create.blade.php",
    "pemantauan_peristiwa/edit.blade.php",
    "pemantauan_level/create.blade.php",
    "pemantauan_level/edit.blade.php",
    "reviu_usulan/create.blade.php",
    "reviu_usulan/edit.blade.php",
    "rencana_belum_terealisasi/create.blade.php",
    "rencana_belum_terealisasi/edit.blade.php",
    "evaluasi_risiko/create.blade.php",
    "evaluasi_risiko/edit.blade.php"
)

$dropdownHtml = @"
            <!-- Dropdown Referensi Kode Risiko -->
            <div class="bg-slate-800/30 border border-slate-700/50 rounded-[2rem] p-8 mb-6">
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i data-lucide="info" class="w-5 h-5 mr-3 text-blue-400"></i>
                    Referensi Kode Risiko
                </h4>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih / Lihat Kode Risiko</label>
                    <select id="referensi_kode_risiko" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer">
                        <option value="" selected disabled hidden>-- Daftar Kode Risiko (Gabungan) --</option>
                        @php
                            `$semua_risiko = \App\Models\IdentifikasiRisiko::all();
                        @endphp
                        @foreach(`$semua_risiko as `$r)
                            <option value="{{ `$r->id }}">{{ `$r->kode_risiko ?? '-' }} - {{ Str::limit(`$r->pernyataan_risiko, 50) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
"@

foreach ($file in $files) {
    $path = "c:\laragon\www\operator-cabang\resources\views\$file"
    if (Test-Path $path) {
        $content = Get-Content $path -Raw
        if ($content -notmatch "Referensi Kode Risiko") {
            $content = $content -replace '(<div class="space-y-[0-9a-z-]+">)', "`$1`n$dropdownHtml"
            Set-Content $path $content
            Write-Host "Patched $file"
        }
    }
}
