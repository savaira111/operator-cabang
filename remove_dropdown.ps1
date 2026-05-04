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
    "evaluasi_risiko/edit.blade.php",
    "resikos/create.blade.php",
    "resikos/edit.blade.php",
    "analisis_risiko/create.blade.php",
    "analisis_risiko/edit.blade.php"
)

foreach ($file in $files) {
    $path = "c:\laragon\www\operator-cabang\resources\views\$file"
    if (Test-Path $path) {
        $content = Get-Content $path -Raw
        $content = $content -replace '(?s)\s*<!-- Dropdown Referensi Kode Risiko -->.*?</div>\s*</div>\s*', ''
        Set-Content $path $content
        Write-Host "Removed reference dropdown from $file"
    }
}
