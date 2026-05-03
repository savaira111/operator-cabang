@extends('layouts.app')

@section('title', 'Tambah Laporan Tahanan')
@section('page_title', 'Registrasi Laporan Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                <i data-lucide="file-text" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Input Laporan Baru</h3>
                <p class="text-slate-500 text-sm mt-1">Impor data excel tahanan dan tentukan periode laporan terkait.</p>
            </div>
        </div>
        
        <a href="{{ route('tahanans.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
    </div>

    <form action="{{ route('tahanans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-8">
                <!-- Impor Data Excel -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Impor Data Excel</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" required class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                        <label for="excel_file" class="w-full px-5 py-[1.1rem] bg-indigo-500/5 hover:bg-indigo-500/10 border-2 border-dashed border-slate-700 hover:border-indigo-500/50 rounded-2xl text-slate-400 hover:text-indigo-400 font-bold text-xs transition-all cursor-pointer flex items-center justify-center group-hover:scale-[1.01]">
                            <i data-lucide="file-up" class="w-4 h-4 mr-2"></i>
                            <span id="file-label">Pilih File Excel (.xlsx, .xls)</span>
                        </label>
                    </div>
                    <p class="text-[10px] text-slate-600 ml-1 italic">* Pastikan format kolom sesuai dengan template standar.</p>
                </div>

                <!-- Id_Cabang (Hidden if user has branch) -->
                @if(!auth()->user()->cabang_id)
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ID Cabang (Lokasi)</label>
                    <div class="relative group">
                        <select name="cabang_id" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Lokasi Cabang --</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Periode Input (Bulan) -->
                <div class="space-y-3">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Input (Bulan)</label>
                    <div class="relative group">
                        <select name="periode_bulan" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                            @php
                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            <option value="" selected disabled hidden>-- Pilih Bulan --</option>
                            @foreach($months as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
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
                    <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="2026">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Catatan khusus mengenai laporan ini..."></textarea>
            </div>
            
            <div class="pt-6">
                <button type="submit" class="px-10 py-5 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase tracking-widest text-xs flex items-center">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Simpan Laporan Baru
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('excel_file')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Pilih File Excel (.xlsx, .xls)';
    document.getElementById('file-label').textContent = fileName;
});
</script>
@endsection
