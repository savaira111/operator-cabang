@extends('layouts.app')

@section('title', 'Ubah Laporan Tahanan')
@section('page_title', 'Perbarui Laporan Tahanan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Ubah Metadata Laporan</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui periode atau lampiran data excel laporan.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-3 bg-slate-800/80 rounded-2xl border border-slate-700/50">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">NO INPUT</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ $tahanan->no_input }}</span>
            </div>
            <a href="{{ route('tahanans.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('tahanans.update', $tahanan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-8">
                <!-- ID Cabang (Lokasi) -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ID Cabang (Lokasi)</label>
                    <div class="relative group">
                        <select name="cabang_id" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}" {{ $tahanan->cabang_id == $cabang->id ? 'selected' : '' }}>{{ $cabang->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Periode Input (Bulan) -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Input (Bulan)</label>
                    <div class="relative group">
                        <select name="periode_bulan" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                            @php
                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @foreach($months as $month)
                                <option value="{{ $month }}" {{ $tahanan->periode_bulan == $month ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Periode Tahun -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Tahun</label>
                    <input type="number" name="periode_tahun" value="{{ $tahanan->periode_tahun }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="2026">
                </div>

                <!-- Replace Data Excel -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Ganti Data Excel (Opsional)</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                        <label for="excel_file" class="w-full px-5 py-[1.1rem] bg-indigo-500/5 hover:bg-indigo-500/10 border-2 border-dashed border-slate-700 hover:border-indigo-500/50 rounded-2xl text-slate-400 hover:text-indigo-400 font-bold text-xs transition-all cursor-pointer flex items-center justify-center group-hover:scale-[1.01]">
                            <i data-lucide="file-up" class="w-4 h-4 mr-2"></i>
                            <span id="file-label">Pilih File Baru untuk Ganti</span>
                        </label>
                    </div>
                </div>
            </div>

            @if($tahanan->file_path)
            <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 mr-4">
                        <i data-lucide="file-text" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">File Saat Ini</p>
                        <p class="text-xs font-bold text-emerald-300">{{ basename($tahanan->file_path) }}</p>
                    </div>
                </div>
                <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="px-4 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                    Lihat File
                </a>
            </div>
            @endif

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Catatan khusus mengenai laporan ini...">{{ $tahanan->keterangan }}</textarea>
            </div>
            
            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase tracking-widest text-sm">
                    Simpan Perubahan Laporan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('excel_file')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Pilih File Baru untuk Ganti';
    document.getElementById('file-label').textContent = fileName;
});
</script>
@endsection
