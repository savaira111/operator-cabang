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

        $ar1 = AnalisisRisiko::create([
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

        PemantauanLevelRisiko::create([
            'analisis_risiko_id' => $ar1->id,
            'deviasi' => 'Masih ditemukan celah keamanan pada sistem login meskipun server sudah di-patch.',
            'rekomendasi' => 'Implementasi Multi-Factor Authentication (MFA) segera.',
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
            'kegiatan_pengendalian' => 'Pembaruan server and pelatihan staf IT',
            'tahun' => date('Y')
        ]);

        ReviuUsulanRisiko::create([
            'resiko_id' => $resiko1->id,
            'usulan_pernyataan_risiko' => 'Penambahan protokol Zero Trust Architecture pada jaringan internal',
            'unit_pemilik_pengusul' => 'Andi Wijaya (Staf IT)',
            'status' => 'Diterima',
            'alasan_diterima' => 'Sesuai dengan rencana pengembangan keamanan siber tahun depan.',
            'alasan_ditolak' => '-',
        ]);

        $rencana1 = RencanaTindakPengendalian::create([
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

        $pk1 = PemantauanKegiatan::create([
            'rencana_tindak_pengendalian_id' => $rencana1->id,
            'realisasi_waktu' => 'Bulan September 2026',
            'hambatan_kendala' => 'Terdapat kendala teknis kecil saat sinkronisasi data awal.',
        ]);

        RencanaBelumTerealisasi::create([
            'rencana_tindak_pengendalian_id' => $rencana1->id,
            'keterangan' => 'Belum terealisasi penuh karena keterbatasan akses ke data center pada minggu ke-4.',
        ]);

        EvaluasiRisiko::create([
            'resiko_id' => $resiko1->id,
            'pemilik_risiko' => 'Kepala Bagian IT',
            'keterangan' => 'Pengendalian sudah cukup efektif, namun perlu percepatan implementasi MFA untuk menutup celah siber.',
        ]);

        PemantauanPeristiwa::create([
            'pemantauan_kegiatan_id' => $pk1->id,
            'uraian_peristiwa' => 'Percobaan serangan brute force pada server database utama',
            'waktu_kejadian' => '12 September 2026',
            'tempat_kejadian' => 'Data Center Lantai 2',
            'skor_dampak' => 4,
            'pemicu_peristiwa' => 'Port SSH terbuka secara publik selama migrasi sementara',
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

        $ar2 = AnalisisRisiko::create([
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

        PemantauanLevelRisiko::create([
            'analisis_risiko_id' => $ar2->id,
            'deviasi' => 'Vendor baru masih dalam tahap penyesuaian jadwal pengiriman.',
            'rekomendasi' => 'Pemberian SP-1 kepada vendor utama dan percepatan kontrak vendor cadangan.',
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

        ReviuUsulanRisiko::create([
            'resiko_id' => $resiko2->id,
            'usulan_pernyataan_risiko' => 'Pengadaan armada logistik mandiri milik satker',
            'unit_pemilik_pengusul' => 'Siti Aminah (Kaur Umum)',
            'status' => 'Ditolak',
            'alasan_diterima' => '-',
            'alasan_ditolak' => 'Anggaran tidak mencukupi untuk pembelian aset kendaraan tahun ini.',
        ]);

        $rencana2 = RencanaTindakPengendalian::create([
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

        $pk2 = PemantauanKegiatan::create([
            'rencana_tindak_pengendalian_id' => $rencana2->id,
            'realisasi_waktu' => 'Bulan Juli 2026',
            'hambatan_kendala' => 'Proses tender vendor cadangan mengalami sedikit penundaan.',
        ]);

        PemantauanPeristiwa::create([
            'pemantauan_kegiatan_id' => $pk2->id,
            'uraian_peristiwa' => 'Keterlambatan pengiriman bahan makanan selama 4 jam',
            'waktu_kejadian' => '05 Juli 2026',
            'tempat_kejadian' => 'Gerbang Logistik Cabang',
            'skor_dampak' => 3,
            'pemicu_peristiwa' => 'Armada vendor utama mengalami pecah ban di jalan tol',
        ]);

        EvaluasiRisiko::create([
            'resiko_id' => $resiko2->id,
            'pemilik_risiko' => 'Kepala Bagian Umum',
            'keterangan' => 'Pengendalian cukup efektif menurunkan dampak, namun frekuensi keterlambatan masih perlu diawasi ketat.',
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

        $ar3 = AnalisisRisiko::create([
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

        PemantauanLevelRisiko::create([
            'analisis_risiko_id' => $ar3->id,
            'deviasi' => 'Aplikasi akuntansi baru sering mengalami downtime saat jam sibuk.',
            'rekomendasi' => 'Upgrade spesifikasi server hosting aplikasi akuntansi.',
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

        ReviuUsulanRisiko::create([
            'resiko_id' => $resiko3->id,
            'usulan_pernyataan_risiko' => 'Integrasi sistem pelaporan dengan API pusat untuk otomasi data',
            'unit_pemilik_pengusul' => 'Bambang (Bendahara)',
            'status' => 'Diterima',
            'alasan_diterima' => 'Akan dikoordinasikan dengan tim IT pusat bulan depan.',
            'alasan_ditolak' => '-',
        ]);

        $rencana3 = RencanaTindakPengendalian::create([
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

        $pk3 = PemantauanKegiatan::create([
            'rencana_tindak_pengendalian_id' => $rencana3->id,
            'realisasi_waktu' => 'Terlaksana pada minggu ke-2 bulan Oktober',
            'hambatan_kendala' => 'Proses adaptasi staf membutuhkan waktu sedikit lebih lama dari perkiraan.',
        ]);

        PemantauanPeristiwa::create([
            'pemantauan_kegiatan_id' => $pk3->id,
            'uraian_peristiwa' => 'Selisih saldo kas kecil sebesar Rp 500.000 pada laporan mingguan',
            'waktu_kejadian' => '15 Oktober 2026',
            'tempat_kejadian' => 'Ruang Administrasi Keuangan',
            'skor_dampak' => 2,
            'pemicu_peristiwa' => 'Human error saat input manual nota yang menumpuk',
        ]);

        EvaluasiRisiko::create([
            'resiko_id' => $resiko3->id,
            'pemilik_risiko' => 'Bendahara Cabang',
            'keterangan' => 'Digitalisasi laporan sangat membantu akurasi, perlu pelatihan lanjutan bagi staf baru.',
        ]);
    }
}
