@extends('layouts.app')

@section('title', 'Tambah LPI Tambahan')
@section('page_title', 'Input Laporan LPI Tambahan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">TAMBAH LAPORAN LPI</h3>
            <p class="text-slate-500 text-sm mt-1">Input data laporan pengendalian internal tambahan baru.</p>
        </div>
        <a href="{{ route('laporan-pengendalian.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
        </a>
    </div>

    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <form action="{{ route('laporan-pengendalian.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Satker / Cabang -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kantor Cabang / Satker</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Laporan -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama / Jenis Laporan</label>
                    <input type="text" name="nama_laporan" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none focus:border-blue-500" placeholder="Contoh: Laporan Pengawasan Semester I">
                </div>

                <!-- Periode Bulan -->
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Periode Bulan</label>
                    <select name="periode_bulan" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                            <option value="{{ $b }}">{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Periode Tahun -->
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Periode Tahun</label>
                    <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                </div>

                <!-- File Upload -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1 text-blue-400">Upload Dokumen Laporan (PDF/Doc/Excel/JPG)</label>
                    <div class="relative group">
                        <input type="file" name="file" class="hidden" id="file_input">
                        <label for="file_input" class="w-full px-5 py-6 bg-blue-500/5 hover:bg-blue-500/10 border-2 border-dashed border-slate-700 hover:border-blue-500/50 rounded-2xl text-slate-400 hover:text-blue-400 font-bold text-xs transition-all cursor-pointer flex items-center justify-center">
                            <i data-lucide="upload-cloud" class="w-5 h-5 mr-2"></i>
                            <span id="file_label">Klik untuk memilih file laporana...</span>
                        </label>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                    <textarea name="keterangan" rows="4" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none" placeholder="Tambahkan catatan khusus jika diperlukan..."></textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-blue-500 hover:bg-blue-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95 uppercase text-xs tracking-widest flex items-center justify-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Laporan LPI
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file_input')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Klik untuk memilih file laporan...';
        document.getElementById('file_label').textContent = fileName;
    });
</script>
@endsection
