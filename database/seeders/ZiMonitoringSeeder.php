<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ZiMonitoring;
use App\Models\Cabang;

class ZiMonitoringSeeder extends Seeder
{
    public function run(): void
    {
        $cabang = Cabang::first();
        if (!$cabang) return;

        // SS.1.1 - WARNA BIRU (Root Sasaran Indikatif)
        $ss1_1 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => null,
            'tipe' => 'SS2',
            'nomor' => 'SS.1.1',
            'sasaran_kegiatan' => 'Terwujudnya pemerintahan digital untuk mendukung digital governance yang berkualitas menuju humanbased governance',
        ]);

        // K.2
        $k2 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_1->id,
            'tipe' => 'K',
            'nomor' => 'K.2',
            'sasaran_kegiatan' => 'Pelaksanaan Arsip Digital',
            'indikator' => 'Tingkat Digitalisasi Arsip',
            'target' => '1',
            'outcome' => 'Terwujudnya peningkatan kualitas penyelenggaraan kearsipan pada Kementerian Imigrasi dan Pemasyarakatan dalam rangka transformasi digital kearsipan',
        ]);

        // RK.2.2
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k2->id,
            'tipe' => 'IO',
            'nomor' => 'IO.2.2',
            'rincian_kegiatan' => 'Penggunaan Aplikasi Srikandi untuk persuratan masuk, keluar, pemberkasan dan penyusutan arsip',
            'indikator_output' => 'Jumlah Laporan Penggunaan Aplikasi Srikandi untuk persuratan masuk, keluar, pemberkasan dan penyusutan arsip',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO UMUM',
            'data_dukung' => 'Laporan Penggunaan Aplikasi Srikandi (Surat Masuk/Keluar)',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // RK.2.10
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k2->id,
            'tipe' => 'IO',
            'nomor' => 'IO.2.10',
            'rincian_kegiatan' => 'Pembentukan Tim Pengawasan Kearsipan',
            'indikator_output' => 'Jumlah dokumen SK Tim Pengawasan Kearsipan',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO UMUM',
            'data_dukung' => 'Dokumen SK Tim Pengawasan Kearsipan (PDF)',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // SS.1.2 - WARNA BIRU
        $ss1_2 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => null,
            'tipe' => 'SS2',
            'nomor' => 'SS.1.2',
            'sasaran_kegiatan' => 'Terbangunnya perilaku birokrasi yang beretika dan inovatif untuk mendukung digital governance yang berkualitas menuju humanbased governance',
        ]);

        // K.3
        $k3 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_2->id,
            'tipe' => 'K',
            'nomor' => 'K.3',
            'sasaran_kegiatan' => 'Pembangunan Zona Integritas di Unit Kerja',
            'indikator' => 'Tingkat Keberhasilan Pembangunan Zona Integritas',
            'target' => '1',
            'outcome' => 'Terwujudnya satuan kerja berpredikat WBK/WBBM di lingkungan Kementerian Imigrasi dan Pemasyarakatan sejumlah lebih dari 30% dari total jumlah seluruh satuan kerja yang ada.',
        ]);

        // IO.3.5
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k3->id,
            'tipe' => 'IO',
            'nomor' => 'IO.3.5',
            'rincian_kegiatan' => 'Melakukan monev pembangunan Zona Integritas menuju WBK/WBBM atau upaya mempertahankan WBBM pada UPT; Kanwil berkonsultasi dengan Unit Eselon I Pembina untuk arahan/solusi.',
            'indikator_output' => 'Teridentifikasinya capaian dan kendala serta tersusunnya rekomendasi optimalisasi pembangunan zona integritas WBK/WBBM atau upaya mempertahankan predikat menuju WBBM pada UPT masing-masing.',
            'target_output' => '2',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Laporan Kegiatan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.3.8 (Identical text but different number in some versions)
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k3->id,
            'tipe' => 'IO',
            'nomor' => 'IO.3.8',
            'rincian_kegiatan' => 'Melakukan monev pembangunan Zona Integritas menuju WBK/WBBM atau upaya mempertahankan WBBM pada UPT; Kanwil berkonsultasi dengan Unit Eselon I Pembina untuk arahan/solusi.',
            'indikator_output' => 'Teridentifikasinya capaian dan kendala serta tersusunnya rekomendasi optimalisasi pembangunan zona integritas WBK/WBBM atau upaya mempertahankan predikat menuju WBBM pada UPT masing-masing.',
            'target_output' => '2',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Laporan Kegiatan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // SS.1.3 - WARNA BIRU
        $ss1_3 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => null,
            'tipe' => 'SS2',
            'nomor' => 'SS.1.3',
            'sasaran_kegiatan' => 'Terbangunnya kapabilitas kelembagaan yang berkinerja tinggi, berbasis jejaring dan lincah, guna mendukung digital governance yang berkualitas menuju humanbased governance',
        ]);

        // K.7
        $k7 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_3->id,
            'tipe' => 'K',
            'nomor' => 'K.7',
            'sasaran_kegiatan' => 'Penguatan Implementasi Rencana Aksi Pembangunan RB General',
            'indikator' => 'Tingkat Implementasi Rencana Aksi Pembangunan RB General',
            'target' => '1',
            'outcome' => 'Terwujudnya peningkatan kualitas implementasi rencana aksi Pembangunan RB General yang telah disusun',
        ]);

        // IO.7.5
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k7->id,
            'tipe' => 'IO',
            'nomor' => 'IO.7.5',
            'rincian_kegiatan' => 'Menerbitkan surat perintah pelaksanaan rencana aksi tahunan reformasi birokrasi setiap triwulan yang memuat daftar kegiatan, pelaksana (Bagian/Seksi/Subseksi/Subbagian/Pegawai), dan tanggal pelaksanaan.',
            'indikator_output' => 'Tersusunnya rencana pelaksanaan rencana aksi tahunan reformasi birokrasi secara terjadwal dan menjadi salah satu bentuk pengawasan pelaksanaan oleh pimpinan unit/satker masing-masing.',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Surat Perintah',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.7.6
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k7->id,
            'tipe' => 'IO',
            'nomor' => 'IO.7.6',
            'rincian_kegiatan' => 'Melaksanakan rencana aksi RB General dan/atau RB Tematik',
            'indikator_output' => 'Terealisasinya pelaksanaan rencana aksi RB General and RB Tematik yang menjadi tanggung jawab masing-masing pelaksana',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Laporan Kegiatan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // K.10
        $k10 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_3->id,
            'tipe' => 'K',
            'nomor' => 'K.10',
            'sasaran_kegiatan' => 'Pelaksanaan Sistem Akuntabilitas Kinerja Instansi Pemerintah yang Terintegrasi',
            'indikator' => 'Indeks Perencanaan Pembangunan',
            'target' => '1',
            'outcome' => 'Terwujudnya perencanaan pembangunan yang meliputi integrasi, sinkronisasi, serta keterhubungan perencanaan pembangunan nasional dengan perencanaan kinerja di lingkungan Kementerian Imigrasi dan Pemasyarakatan',
        ]);

        // IO.10.4
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k10->id,
            'tipe' => 'IO',
            'nomor' => 'IO.10.4',
            'rincian_kegiatan' => 'Mekanisme Penyusunan LKjIP di lingkungan Kementerian Imigrasi dan Pemasyarakatan',
            'indikator_output' => 'Jumlah Dokumen SK Tim Kerja Penyusunan LKjIP, Jumlah Dokumen SOP Pengumpulan Data Kinerja',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Dokumen SK Tim Kerja Penyusunan LKjIP, Dokumen SOP Pengumpulan Data Kinerja',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // K.11
        $k11 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_3->id,
            'tipe' => 'K',
            'nomor' => 'K.11',
            'sasaran_kegiatan' => 'Penguatan implementasi sistem pengendalian intern pemerintah (SPIP)',
            'indikator' => 'Tingkat Maturitas SPIP',
            'target' => '1',
            'outcome' => 'Terwujudnya budaya akuntabilitas kinerja yang baik dan mampu mendorong peningkatan efektivitas dan efisiensi penggunaan APBN',
        ]);

        // IO.11.7
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k11->id,
            'tipe' => 'IO',
            'nomor' => 'IO.11.7',
            'rincian_kegiatan' => 'Telah dilakukan penilaian risiko atas pelaksanaan kebijakan',
            'indikator_output' => 'Jumlah dokumen manajemen risiko di lingkungan Kementerian Imigrasi dan Pemasyarakatan tingkat unit pemilik risiko Unit Eselon I, Kanwil, dan UPT',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Dokumen MR sesuai pedoman menteri imigrasi dan pemasyarakatan M.POT.02.02-67 Tahun 2025; piagam MR; dokumen penanganan risiko pelayanan publik dan integritas',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.11.8
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k11->id,
            'tipe' => 'IO',
            'nomor' => 'IO.11.8',
            'rincian_kegiatan' => 'Pelaksanaan manajemen risiko di lingkungan Kementerian Imigrasi dan Pemasyarakatan',
            'indikator_output' => 'Jumlah kegiatan Pemantauan penanganan risiko di lingkungan Kementerian Imigrasi dan Pemasyarakatan',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO PERENCANAAN DAN KEUANGAN',
            'data_dukung' => 'Laporan pelaksanaan kegiatan pemantauan penanganan risiko',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // K.13
        $k13 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss1_3->id,
            'tipe' => 'K',
            'nomor' => 'K.13',
            'sasaran_kegiatan' => 'Penguatan Pengelolaan Keuangan dan Aset',
            'indikator' => 'Indikator Kinerja Pelaksanaan Anggaran',
            'target' => '1',
            'outcome' => 'Terwujudnya peningkatan kualitas kinerja di bidang pengelolaan barang milik negara (BMN) meliputi pengelolaan, kepatuhan, pengawasan, dan pengendalian, serta keandalan administrasi pada Kementerian Imigrasi dan Pemasyarakatan selaku pengguna barang',
        ]);

        // IO.13.4
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k13->id,
            'tipe' => 'IO',
            'nomor' => 'IO.13.4',
            'rincian_kegiatan' => 'Melakukan pengawasan dan pengendalian (wasdal) terhadap pengelolaan BMN dan menyampaikan laporan hasil wasdal secara tepat waktu',
            'indikator_output' => 'Jumlah laporan hasil pengawasan dan pengendalian (wasdal) terhadap pengelolaan BMN',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B09',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO BARANG MILIK NEGARA',
            'data_dukung' => 'Laporan Wasdal Semester I, Laporan Wasdal Semester II dan Tahunan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.13.6
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k13->id,
            'tipe' => 'IO',
            'nomor' => 'IO.13.6',
            'rincian_kegiatan' => 'Melakukan pendataan realisasi PNBP dari Pemanfaatan',
            'indikator_output' => 'Jumlah kompilasi realisasi PNBP Pemanfaatan berdasarkan persetujuan Pengelola Barang',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B09',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO BARANG MILIK NEGARA',
            'data_dukung' => 'Rekapitulasi Realisasi PNBP dari Pemanfaatan BMN',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.13.7
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k13->id,
            'tipe' => 'IO',
            'nomor' => 'IO.13.7',
            'rincian_kegiatan' => 'Melakukan penyusunan Laporan Barang Pengguna Kementerian Imigrasi dan Pemasyarakatan',
            'indikator_output' => 'Jumlah Laporan Barang Pengguna Kementerian Imigrasi dan Pemasyarakatan',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B09',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO BARANG MILIK NEGARA',
            'data_dukung' => 'Laporan Barang Pengguna semester I, semester II/Tahunan, Akrual/Audit',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.13.8
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k13->id,
            'tipe' => 'IO',
            'nomor' => 'IO.13.8',
            'rincian_kegiatan' => 'Menindaklanjuti persetujuan Kementerian Keuangan untuk menerbitkan SK pelaksanaan',
            'indikator_output' => 'Rekapitulasi SK penetapan pelaksanaan',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO BARANG MILIK NEGARA',
            'data_dukung' => 'Rekapitulasi SK penetapan pelaksanaan sewa, kontrak dan bukti setor',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // SS.2 - WARNA BIRU
        $ss2 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => null,
            'tipe' => 'SS2',
            'nomor' => 'SS.2',
            'sasaran_kegiatan' => 'Terwujudnya kualitas pelayanan publik yang prima dan berintegritas pada Kementerian Imigrasi dan Pemasyarakatan',
        ]);

        // K.20
        $k20 = ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $ss2->id,
            'tipe' => 'K',
            'nomor' => 'K.20',
            'sasaran_kegiatan' => 'Indeks persepsi masyarakat penerima layanan terhadap kualitas pelayanan pada Kementerian Imigrasi dan Pemasyarakatan',
            'indikator' => 'Indeks Kualitas Pelayanan Publik (IKP)',
            'target' => '1',
            'outcome' => 'Terwujudnya peningkatan kualitas pelayanan publik pada Kementerian Imigrasi dan Pemasyarakatan',
        ]);

        // IO.20.1
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k20->id,
            'tipe' => 'IO',
            'nomor' => 'IO.20.1',
            'rincian_kegiatan' => 'Internalisasi penyesuaian pelaksanaan SPAK-SPKP/SKM',
            'indikator_output' => 'Terselenggaranya pendampingan terkait penyusunan pelaksanaan SPAK-SPKP/SKM',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'PUSAT STRATEGI KEBIJAKAN',
            'data_dukung' => 'Laporan pendampingan (Undangan, Daftar Hadir, Notulensi, Dokumentasi Foto, Laporan Kegiatan)',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.20.2
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k20->id,
            'tipe' => 'IO',
            'nomor' => 'IO.20.2',
            'rincian_kegiatan' => 'Publikasi Hasil SPAK-SPKP/SKM secara offline dan online (melalui website, media sosial, dll)',
            'indikator_output' => 'Jumlah Dokumen foto atau capture publikasi hasil SPAK-SPKP/SKM secara offline atau pada website, media sosial, dll',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'PUSAT STRATEGI KEBIJAKAN',
            'data_dukung' => 'Dokumen foto atau capture publikasi hasil SPAK-SPKP/SKM secara offline atau pada website, media sosial, dll',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.20.3
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k20->id,
            'tipe' => 'IO',
            'nomor' => 'IO.20.3',
            'rincian_kegiatan' => 'Melakukan pengolahan data hasil SPAK-SPKP/SKM masing-masing satuan kerja',
            'indikator_output' => 'Jumlah Laporan Hasil Pengolahan Data SPAK-SPKP/SKM',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'PUSAT STRATEGI KEBIJAKAN',
            'data_dukung' => 'Laporan hasil pengolahan data SPAK dan SPKP per Triwulan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.20.4
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k20->id,
            'tipe' => 'IO',
            'nomor' => 'IO.20.4',
            'rincian_kegiatan' => 'Menindaklanjuti hasil SPAK-SPKP/SKM masing-masing satuan kerja',
            'indikator_output' => 'Jumlah Dokumen Tindak Lanjut Hasil SPAK-SPKP/SKM',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'PUSAT STRATEGI KEBIJAKAN',
            'data_dukung' => 'Laporan tindak lanjut hasil SPAK dan SPKP per Triwulan',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);

        // IO.20.5
        ZiMonitoring::create([
            'cabang_id' => null,
            'parent_id' => $k20->id,
            'tipe' => 'IO',
            'nomor' => 'IO.20.5',
            'rincian_kegiatan' => 'Evaluasi hasil pelaksanaan SPAK-SPKP/SKM tahun 2025',
            'indikator_output' => 'Jumlah Laporan Hasil Pelaksanaan SPAK-SPKP/SKM satuan kerja',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'PUSAT STRATEGI KEBIJAKAN',
            'data_dukung' => 'Laporan hasil pelaksanaan SPAK-SPKP/SKM satuan kerja setiap triwulan dengan disertai analisa grafik QR Code',
            'status_data_dukung' => 'belum_ada',
            'prosentase' => 0,
        ]);
    }
}
