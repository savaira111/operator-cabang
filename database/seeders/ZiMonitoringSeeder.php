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
            'cabang_id' => $cabang->id,
            'parent_id' => null,
            'tipe' => 'SS2',
            'nomor' => 'SS.1.1',
            'sasaran_kegiatan' => 'Terwujudnya pemerintahan digital untuk mendukung digital governance yang berkualitas menuju humanbased governance',
        ]);

        // K.2
        $k2 = ZiMonitoring::create([
            'cabang_id' => $cabang->id,
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
            'cabang_id' => $cabang->id,
            'parent_id' => $k2->id,
            'tipe' => 'IO',
            'nomor' => 'IO.2.2',
            'rincian_kegiatan' => 'Penggunaan Aplikasi Srikandi untuk persuratan masuk, keluar, pemberkasan dan penyusutan arsip',
            'indikator_output' => 'Jumlah Laporan Penggunaan Aplikasi Srikandi untuk persuratan masuk, keluar, pemberkasan dan penyusutan arsip',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03,B06,B09,B12',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO UMUM',
            'status_data_dukung' => 'sesuai',
            'prosentase' => 100,
            'catatan' => 'Laporan sudah diverifikasi pusat.',
        ]);

        // RK.2.10
        ZiMonitoring::create([
            'cabang_id' => $cabang->id,
            'parent_id' => $k2->id,
            'tipe' => 'IO',
            'nomor' => 'IO.2.10',
            'rincian_kegiatan' => 'Pembentukan Tim Pengawasan Kearsipan',
            'indikator_output' => 'Jumlah dokumen SK Tim Pengawasan Kearsipan',
            'target_output' => '1',
            'waktu_pelaksanaan' => 'B03',
            'pelaksana' => 'Kanwil Ditjen Pemasyarakatan',
            'koordinator' => 'BIRO UMUM',
            'status_data_dukung' => 'menunggu',
            'prosentase' => 75,
            'catatan' => 'Menunggu tandatangan pimpinan.',
        ]);
    }
}
