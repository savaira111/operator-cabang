<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cabang;
use App\Models\IdentifikasiRisiko;
use App\Models\AnalisisRisiko;
use App\Models\Resiko;
use App\Models\RencanaTindakPengendalian;

class RisikoDummySeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada Cabang
        $cabang = Cabang::first();
        if (!$cabang) {
            $cabang = Cabang::create([
                'nama_cabang' => 'Kantor Pusat Dummy',
                'kode_cabang' => 'KP001',
                'kepala_cabang' => 'Budi Santoso'
            ]);
        }

        // Data 1: Risiko Keamanan Data
        $id1 = IdentifikasiRisiko::create([
            'cabang_id' => $cabang->id,
            'jenis_konteks' => 'Strategis',
            'nama_konteks' => 'Teknologi Informasi',
            'indikator' => 'Ketersediaan layanan sistem informasi',
            'kode_risiko' => 'R001',
            'pernyataan_risiko' => 'Potensi kebocoran data sensitif tahanan akibat sistem keamanan IT yang belum diperbarui',
            'kategori_risiko' => 'Operasional',
            'uraian_dampak' => 'Kehilangan kepercayaan publik dan potensi penyalahgunaan data',
            'metode_pencapaian_tujuan_spip' => 'Peningkatan keamanan siber'
        ]);

        AnalisisRisiko::create([
            'identifikasi_risiko_id' => $id1->id,
            'frekuensi' => '4',
            'dampak' => '4',
            'level_risiko' => '19 - Tinggi (4)',
            'ada_belum_ada' => 'Ada',
            'uraian_pengendalian' => 'Backup data dilakukan secara mingguan secara manual',
            'memadai_belum_memadai' => 'Belum Memadai',
            'skor_probabilitas_residu' => '3',
            'skor_dampak_residu' => '4',
            'level_risiko_residu' => '15 - Sedang (3)'
        ]);

        $resiko1 = Resiko::create([
            'cabang_id' => $cabang->id,
            'kode' => 'WP. 1',
            'pernyataan_risiko' => 'Potensi kebocoran data sensitif tahanan akibat sistem keamanan IT yang belum diperbarui',
            'why_1' => 'Server belum dipatch',
            'why_2' => 'Belum ada jadwal pemeliharaan rutin',
            'why_3' => 'Kurangnya staf IT ahli',
            'why_4' => 'Anggaran pelatihan terbatas',
            'why_5' => 'Prioritas manajemen pada operasional fisik',
            'akar_penyebab' => 'Kurangnya kesadaran manajemen terhadap risiko siber',
            'kode_penyebab_jenis' => 'MN',
            'kode_penyebab_nomor' => 1,
            'kegiatan_pengendalian' => 'Pembaruan server dan pelatihan staf IT',
            'tahun' => date('Y')
        ]);

        RencanaTindakPengendalian::create([
            'resiko_id' => $resiko1->id,
            'rencana_tindak' => 'Migrasi ke server berbasis cloud dengan enkripsi standar industri',
            'waktu_pelaksanaan' => 'Triwulan III 2026',
            'penanggung_jawab' => 'Kepala Bagian IT',
            'respons_risiko' => 'Mitigasi',
            'klasifikasi_sub_unsur_spip' => 'Lingkungan Pengendalian',
            'indikator_keluaran' => 'Laporan audit keamanan siber',
            'frekuensi' => '2',
            'dampak' => '4',
            'level_risiko' => '9 - Rendah (2)'
        ]);

        // Data 2: Risiko Pasokan Makanan
        $id2 = IdentifikasiRisiko::create([
            'cabang_id' => $cabang->id,
            'jenis_konteks' => 'Operasional',
            'nama_konteks' => 'Logistik Bahan Makanan',
            'indikator' => 'Ketepatan waktu distribusi makanan',
            'kode_risiko' => 'R002',
            'pernyataan_risiko' => 'Keterlambatan pengiriman bahan makanan oleh vendor akibat kendala armada',
            'kategori_risiko' => 'Finansial',
            'uraian_dampak' => 'Gangguan ketertiban di dalam lapas akibat ketidakpuasan tahanan',
            'metode_pencapaian_tujuan_spip' => 'Manajemen Vendor'
        ]);

        AnalisisRisiko::create([
            'identifikasi_risiko_id' => $id2->id,
            'frekuensi' => '3',
            'dampak' => '5',
            'level_risiko' => '17 - Tinggi (4)',
            'ada_belum_ada' => 'Ada',
            'uraian_pengendalian' => 'Kontrak kerja sama dengan vendor tunggal',
            'memadai_belum_memadai' => 'Belum Memadai',
            'skor_probabilitas_residu' => '3',
            'skor_dampak_residu' => '5',
            'level_risiko_residu' => '17 - Tinggi (4)'
        ]);

        $resiko2 = Resiko::create([
            'cabang_id' => $cabang->id,
            'kode' => 'WP. 2',
            'pernyataan_risiko' => 'Keterlambatan pengiriman bahan makanan oleh vendor akibat kendala armada',
            'why_1' => 'Vendor mengalami kerusakan armada',
            'why_2' => 'Vendor tidak memiliki armada cadangan',
            'why_3' => 'Seleksi vendor hanya berdasarkan harga terendah',
            'why_4' => 'Kriteria keandalan armada tidak masuk dalam syarat lelang',
            'why_5' => 'Belum ada standar operasional prosedur pengadaan yang ketat',
            'akar_penyebab' => 'Sistem pengadaan vendor yang belum komprehensif',
            'kode_penyebab_jenis' => 'MY',
            'kode_penyebab_nomor' => 2,
            'kegiatan_pengendalian' => 'Evaluasi vendor berkala',
            'tahun' => date('Y')
        ]);

        RencanaTindakPengendalian::create([
            'resiko_id' => $resiko2->id,
            'rencana_tindak' => 'Menambah vendor cadangan dan merevisi syarat kontrak logistik',
            'waktu_pelaksanaan' => 'Semester II 2026',
            'penanggung_jawab' => 'Kepala Bagian Umum',
            'respons_risiko' => 'Transfer',
            'klasifikasi_sub_unsur_spip' => 'Kegiatan Pengendalian',
            'indikator_keluaran' => 'Addendum kontrak logistik',
            'frekuensi' => '1',
            'dampak' => '5',
            'level_risiko' => '5 - Sangat Rendah (1)'
        ]);

        // Data 3: Risiko Kepatuhan Laporan
        $id3 = IdentifikasiRisiko::create([
            'cabang_id' => $cabang->id,
            'jenis_konteks' => 'Kepatuhan',
            'nama_konteks' => 'Pelaporan Keuangan',
            'indikator' => 'Ketepatan waktu penyampaian laporan bulanan',
            'kode_risiko' => 'R003',
            'pernyataan_risiko' => 'Kesalahan pencatatan transaksi manual yang menyebabkan keterlambatan laporan ke pusat',
            'kategori_risiko' => 'Reputasi',
            'uraian_dampak' => 'Teguran administratif dari instansi pusat',
            'metode_pencapaian_tujuan_spip' => 'Digitalisasi Pelaporan'
        ]);

        AnalisisRisiko::create([
            'identifikasi_risiko_id' => $id3->id,
            'frekuensi' => '5',
            'dampak' => '3',
            'level_risiko' => '17 - Tinggi (4)',
            'ada_belum_ada' => 'Belum Ada',
            'uraian_pengendalian' => '-',
            'memadai_belum_memadai' => 'Belum Memadai',
            'skor_probabilitas_residu' => '5',
            'skor_dampak_residu' => '3',
            'level_risiko_residu' => '17 - Tinggi (4)'
        ]);

        $resiko3 = Resiko::create([
            'cabang_id' => $cabang->id,
            'kode' => 'WP. 3',
            'pernyataan_risiko' => 'Kesalahan pencatatan transaksi manual yang menyebabkan keterlambatan laporan ke pusat',
            'why_1' => 'Pencatatan masih menggunakan spreadsheet manual',
            'why_2' => 'Volume transaksi harian sangat tinggi',
            'why_3' => 'Hanya satu petugas yang mengelola data',
            'why_4' => 'Petugas sering lembur dan kelelahan',
            'why_5' => 'Belum ada implementasi aplikasi akuntansi terintegrasi',
            'akar_penyebab' => 'Belum adanya digitalisasi proses pelaporan',
            'kode_penyebab_jenis' => 'MD',
            'kode_penyebab_nomor' => 3,
            'kegiatan_pengendalian' => 'Implementasi aplikasi akuntansi',
            'tahun' => date('Y')
        ]);

        RencanaTindakPengendalian::create([
            'resiko_id' => $resiko3->id,
            'rencana_tindak' => 'Implementasi sistem ERP sederhana untuk pencatatan transaksi real-time',
            'waktu_pelaksanaan' => 'Triwulan IV 2026',
            'penanggung_jawab' => 'Bendahara Cabang',
            'respons_risiko' => 'Mitigasi',
            'klasifikasi_sub_unsur_spip' => 'Informasi dan Komunikasi',
            'indikator_keluaran' => 'Dashboard pelaporan digital',
            'frekuensi' => '2',
            'dampak' => '3',
            'level_risiko' => '7 - Rendah (2)'
        ]);
    }
}
