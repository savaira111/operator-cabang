<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cabang;
use App\Models\IdentifikasiRisiko;
use App\Models\AnalisisRisiko;
use App\Models\Resiko;
use App\Models\RencanaTindakPengendalian;
use App\Models\PemantauanKegiatan;
use App\Models\PemantauanPeristiwa;
use App\Models\PemantauanLevelRisiko;
use App\Models\ReviuUsulanRisiko;
use App\Models\RencanaBelumTerealisasi;
use App\Models\EvaluasiRisiko;

class RisikoDummySeeder extends Seeder
{
    public function run(): void
    {
        $cabang = Cabang::first();
        if (!$cabang) {
            $cabang = Cabang::create([
                'nama_cabang' => 'Kantor Pusat Dummy',
                'kode_cabang' => 'KP001',
                'kepala_cabang' => 'Budi Santoso'
            ]);
        }

        // Truncate to ensure clean data for the new format
        IdentifikasiRisiko::truncate();
        AnalisisRisiko::truncate();
        Resiko::truncate();
        RencanaTindakPengendalian::truncate();
        PemantauanKegiatan::truncate();
        PemantauanPeristiwa::truncate();
        PemantauanLevelRisiko::truncate();
        ReviuUsulanRisiko::truncate();
        RencanaBelumTerealisasi::truncate();
        EvaluasiRisiko::truncate();
        \App\Models\LaporanPengendalian::truncate();

        $categories = [
            1 => 'Risiko Bencana',
            2 => 'Risiko Kebijakan',
            3 => 'Risiko Kecurangan',
            4 => 'Risiko Kepatuhan',
            5 => 'Risiko Operasional',
            6 => 'Risiko Pemangku Kepentingan'
        ];

        // Create 11 records to satisfy the "11 filter" requirement in the report
        for ($i = 1; $i <= 11; $i++) {
            $catIndex = (($i - 1) % 6) + 1;
            $catName = $categories[$catIndex];
            
            // 1. Identifikasi Risiko
            $id = IdentifikasiRisiko::create([
                'cabang_id' => $cabang->id,
                'jenis_konteks' => 'Program Kerja',
                'nama_konteks' => 'Konteks Strategis ' . $i,
                'indikator' => 'Indikator Keberhasilan ' . $i,
                'kode_risiko' => "WP11.$catIndex.$i",
                'pernyataan_risiko' => "Pernyataan Risiko $i: Potensi kendala " . $catName,
                'kategori_risiko' => $catName,
                'uraian_dampak' => "Dampak operasional pada modul " . $i,
                'metode_pencapaian_tujuan_spip' => 'Penerapan SOP Keamanan Baru'
            ]);

            // 2. Analisis Risiko
            $ar = AnalisisRisiko::create([
                'identifikasi_risiko_id' => $id->id,
                'frekuensi' => '4',
                'dampak' => '4',
                'level_risiko' => '16 - Tinggi (4)',
                'ada_belum_ada' => 'Ada',
                'uraian_pengendalian' => 'Monitoring sistem 24/7',
                'memadai_belum_memadai' => 'Memadai',
                'skor_probabilitas_residu' => '2',
                'skor_dampak_residu' => '3',
                'level_risiko_residu' => '6 - Rendah (2)'
            ]);

            // 3. Resiko (Akar Masalah / Why 5)
            $resiko = Resiko::create([
                'cabang_id' => $cabang->id,
                'kode' => "WP11.$catIndex.$i",
                'pernyataan_risiko' => $id->pernyataan_risiko,
                'why_1' => 'Server belum dipatch',
                'why_2' => 'Belum ada jadwal pemeliharaan rutin',
                'why_3' => 'Kurangnya personil IT',
                'why_4' => 'Anggaran pemeliharaan terbatas',
                'why_5' => 'Prioritas anggaran dialokasikan ke pembangunan fisik',
                'akar_penyebab' => 'Ketidakseimbangan alokasi anggaran antara infrastruktur fisik dan IT',
                'kode_penyebab_jenis' => 'MN',
                'kode_penyebab_nomor' => $i,
                'kegiatan_pengendalian' => 'Revisi anggaran tahunan untuk peningkatan porsi biaya pemeliharaan IT',
                'tahun' => date('Y')
            ]);

            // 4. Rencana Tindak Pengendalian
            $rtp = RencanaTindakPengendalian::create([
                'resiko_id' => $resiko->id,
                'rencana_tindak' => 'Pembaruan perangkat lunak keamanan berkala',
                'waktu_pelaksanaan' => 'Triwulan I',
                'penanggung_jawab' => 'Bagian IT',
                'respons_risiko' => 'Mitigasi',
                'klasifikasi_sub_unsur_spip' => 'Kegiatan Pengendalian',
                'indikator_keluaran' => 'Laporan Patching',
                'frekuensi' => '2',
                'dampak' => '3',
                'level_risiko' => '6 - Rendah'
            ]);

            // 5. Pemantauan Kegiatan
            $pk = PemantauanKegiatan::create([
                'rencana_tindak_pengendalian_id' => $rtp->id,
                'realisasi_waktu' => 'Bulan ke-' . (($i % 12) + 1),
                'hambatan_kendala' => 'Tidak ada hambatan berarti'
            ]);

            // 6. Pemantauan Peristiwa
            PemantauanPeristiwa::create([
                'pemantauan_kegiatan_id' => $pk->id,
                'uraian_peristiwa' => "Percobaan akses ilegal pada modul $i",
                'waktu_kejadian' => now()->subDays($i)->format('Y-m-d'),
                'tempat_kejadian' => 'Server Room',
                'skor_dampak' => 2,
                'pemicu_peristiwa' => 'Brute force attack'
            ]);

            // 7. Pemantauan Level Risiko
            PemantauanLevelRisiko::create([
                'analisis_risiko_id' => $ar->id,
                'deviasi' => 'Sesuai target mitigasi',
                'rekomendasi' => 'Lanjutkan monitoring berkala'
            ]);

            // 8. Reviu Usulan Risiko
            ReviuUsulanRisiko::create([
                'resiko_id' => $resiko->id,
                'usulan_pernyataan_risiko' => "Update Protokol Keamanan v.$i",
                'unit_pemilik_pengusul' => 'Bagian IT',
                'status' => 'Diterima',
                'alasan_diterima' => 'Meningkatkan resiliensi sistem',
                'alasan_ditolak' => '-'
            ]);

            // 9. Rencana Belum Terealisasi
            RencanaBelumTerealisasi::create([
                'rencana_tindak_pengendalian_id' => $rtp->id,
                'keterangan' => 'Pelatihan lanjutan personil IT tertunda karena jadwal pelatih'
            ]);

            // 10. Evaluasi Risiko
            EvaluasiRisiko::create([
                'resiko_id' => $resiko->id,
                'pemilik_risiko' => 'Bagian Umum',
                'keterangan' => 'Risiko telah dikelola sesuai standar'
            ]);

            // 11. LPI Tambahan
            \App\Models\LaporanPengendalian::create([
                'cabang_id' => $cabang->id,
                'nama_laporan' => "Laporan Pengendalian Tambahan $i",
                'periode_bulan' => date('m'),
                'periode_tahun' => date('Y'),
                'file_path' => 'dummy.pdf',
                'status_evaluasi' => 'sudah_dievaluasi',
                'prosentase' => 100,
                'catatan_evaluasi' => 'Sesuai standar'
            ]);
    }
}
}
