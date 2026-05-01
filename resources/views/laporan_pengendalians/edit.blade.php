@extends('layouts.app')

@section('title', 'Edit LPI Tambahan')
@section('page_title', 'Update & Penilaian LPI')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">EDIT & PENILAIAN LPI</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui data laporan atau berikan penilaian evaluasi.</p>
        </div>
        <a href="{{ route('laporan-pengendalian.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
        </a>
    </div>

    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <form action="{{ route('laporan-pengendalian.update', $laporanPengendalian) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Satker / Cabang -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kantor Cabang / Satker</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ $laporanPengendalian->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Laporan -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama / Jenis Laporan</label>
                    <input type="text" name="nama_laporan" value="{{ $laporanPengendalian->nama_laporan }}" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none focus:border-blue-500">
                </div>

                <!-- Periode Bulan -->
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Periode Bulan</label>
                    <select name="periode_bulan" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                            <option value="{{ $b }}" {{ $laporanPengendalian->periode_bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Periode Tahun -->
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Periode Tahun</label>
                    <input type="number" name="periode_tahun" value="{{ $laporanPengendalian->periode_tahun }}" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                </div>

                <!-- File Upload -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1 text-blue-400">Ganti Dokumen Laporan (Opsional)</label>
                    <div class="relative group">
                        <input type="file" name="file" class="hidden" id="file_input">
                        <label for="file_input" class="w-full px-5 py-6 bg-blue-500/5 hover:bg-blue-500/10 border-2 border-dashed border-slate-700 hover:border-blue-500/50 rounded-2xl text-slate-400 hover:text-blue-400 font-bold text-xs transition-all cursor-pointer flex items-center justify-center">
                            <i data-lucide="upload-cloud" class="w-5 h-5 mr-2"></i>
                            <span id="file_label">Klik untuk mengganti file...</span>
                        </label>
                    </div>
                    @if($laporanPengendalian->file_path)
                        <p class="text-[10px] text-emerald-500 mt-2 italic flex items-center">
                            <i data-lucide="check" class="w-3 h-3 mr-1"></i>
                            File saat ini: {{ basename($laporanPengendalian->file_path) }}
                        </p>
                    @endif
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none">{{ $laporanPengendalian->keterangan }}</textarea>
                </div>

                <!-- SECTION: PENILAIAN & EVALUASI -->
                <div class="md:col-span-2 pt-8 border-t border-slate-800/60 mt-4">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                            <i data-lucide="shield-check" class="w-4 h-4 text-amber-400"></i>
                        </div>
                        <h4 class="text-sm font-black text-white uppercase tracking-widest">Penilaian & Evaluasi</h4>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-amber-500/5 p-8 rounded-[2rem] border border-amber-500/10">
                        <div class="space-y-4">
                            <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest ml-1">Status Evaluasi</label>
                            <select name="status_evaluasi" id="status_evaluasi" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none" onchange="updateProsentase()">
                                <option value="belum_dievaluasi" {{ $laporanPengendalian->status_evaluasi == 'belum_dievaluasi' ? 'selected' : '' }}>Belum Dievaluasi</option>
                                <option value="menunggu" {{ $laporanPengendalian->status_evaluasi == 'menunggu' ? 'selected' : '' }}>Menunggu Evaluasi</option>
                                <option value="sesuai" {{ $laporanPengendalian->status_evaluasi == 'sesuai' ? 'selected' : '' }}>Sesuai (Diterima)</option>
                                <option value="tidak_sesuai" {{ $laporanPengendalian->status_evaluasi == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest ml-1">Progres Capaian (%)</label>
                            <div class="relative">
                                <input type="number" name="prosentase" id="prosentase" min="0" max="100" value="{{ $laporanPengendalian->prosentase ?? 0 }}" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none pl-14 font-black">
                                <span class="absolute left-6 top-[1.1rem] text-slate-500 font-black text-sm">%</span>
                            </div>
                        </div>

                        <div class="md:col-span-2 space-y-4">
                            <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest ml-1">Catatan Evaluasi (Opsional)</label>
                            <textarea name="catatan_evaluasi" rows="3" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none" placeholder="Masukkan feedback evaluasi di sini...">{{ $laporanPengendalian->catatan_evaluasi }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase text-xs tracking-widest flex items-center justify-center">
                    <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                    Update Data & Penilaian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file_input')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Klik untuk mengganti file...';
        document.getElementById('file_label').textContent = fileName;
    });

    function updateProsentase() {
        const status = document.getElementById('status_evaluasi').value;
        const prosentaseInput = document.getElementById('prosentase');
        
        const map = {
            'belum_dievaluasi': 0,
            'menunggu': 50,
            'sesuai': 100,
            'tidak_sesuai': 25
        };
        
        if (map.hasOwnProperty(status)) {
            prosentaseInput.value = map[status];
        }
    }
</script>
@endsection
