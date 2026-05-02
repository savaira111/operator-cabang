@extends('layouts.app')

@section('title', 'Ubah Laporan Tahanan')
@section('page_title', 'Perbarui Laporan Tahanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="w-full bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl overflow-hidden relative group">
        <!-- Decorative Background Gradient -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 blur-[100px] rounded-full group-hover:bg-blue-500/20 transition-all duration-700 hidden sm:block"></div>

        <div class="mb-10 flex flex-col md:flex-row md:items-center gap-6 relative z-10">
            <a href="{{ route('tahanans.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800/40 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-full border border-slate-700/50 transition-all active:scale-95 group order-2 md:order-1">
                <i data-lucide="x" class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90"></i>
                <span class="text-[10px] uppercase tracking-[0.2em]">Batal</span>
            </a>

            <div class="flex items-center gap-4 order-1 md:order-2 flex-1">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center shadow-lg shadow-[#D2A039]/20 shrink-0">
                    <i data-lucide="edit-3" class="w-6 h-6 md:w-7 md:h-7 text-[#061B30]"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Ubah Metadata</h3>
                    <div class="mt-1 md:mt-2 flex items-center gap-3">
                        <span class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest">ID INPUT:</span>
                        <span class="px-1.5 py-0.5 md:px-2 md:py-1 rounded bg-blue-500/10 border border-blue-500/20 text-[10px] md:text-xs font-mono font-bold text-blue-400">{{ $tahanan->no_input }}</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('tahanans.update', $tahanan) }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <!-- ID Cabang (Lokasi) -->
                <div class="space-y-1.5 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Kantor Cabang / Satker</label>
                    <div class="relative group/select">
                        <select name="cabang_id" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none appearance-none cursor-pointer text-xs md:text-sm">
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}" {{ $tahanan->cabang_id == $cabang->id ? 'selected' : '' }}>{{ $cabang->name }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                            <i data-lucide="building-2" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Periode Input (Bulan) -->
                <div class="space-y-1.5 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Bulan</label>
                    <div class="relative group/select">
                        <select name="periode_bulan" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none appearance-none cursor-pointer text-xs md:text-sm">
                            @php
                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            @foreach($months as $month)
                                <option value="{{ $month }}" {{ $tahanan->periode_bulan == $month ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Periode Tahun -->
                <div class="space-y-1.5 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Tahun</label>
                    <input type="number" name="periode_tahun" value="{{ $tahanan->periode_tahun }}" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none text-xs md:text-sm">
                </div>

                <!-- Replace Data Excel -->
                <div class="space-y-1.5 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Ganti Data Excel (Opsional)</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                        <label for="excel_file" class="w-full px-4 py-3 md:px-5 md:py-4 bg-[#D2A039]/5 hover:bg-[#D2A039]/10 border-2 border-dashed border-slate-800 hover:border-[#D2A039]/40 rounded-xl md:rounded-2xl text-slate-400 hover:text-white transition-all cursor-pointer flex items-center justify-center gap-2 group-hover:scale-[1.01]">
                            <i data-lucide="file-up" class="w-4 h-4 text-[#D2A039]"></i>
                            <span id="file-label" class="font-bold text-[9px] md:text-[10px] uppercase tracking-widest">Pilih File Baru</span>
                        </label>
                    </div>
                </div>
            </div>

            @if($tahanan->file_path)
            <div class="p-5 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl flex items-center justify-between">
                <div class="flex items-center min-w-0">
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 mr-4 shrink-0">
                        <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">File Saat Ini</p>
                        <p class="text-xs font-bold text-emerald-300 truncate">{{ basename($tahanan->file_path) }}</p>
                    </div>
                </div>
                <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="px-4 py-2 bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all ml-4 shrink-0">
                    Lihat
                </a>
            </div>
            @endif

            <div class="space-y-1.5 md:space-y-3">
                <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none resize-none leading-relaxed text-xs md:text-sm" placeholder="Catatan khusus mengenai laporan ini...">{{ $tahanan->keterangan }}</textarea>
            </div>
            
            <div class="pt-6 border-t border-[#D2A039]/10">
                <button type="submit" class="w-full py-5 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 active:scale-95 flex items-center justify-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <span class="uppercase tracking-widest text-xs">Update & Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        document.getElementById('excel_file')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Pilih File Baru';
            const label = document.getElementById('file-label');
            label.textContent = fileName;
            label.classList.add('text-[#D2A039]');
        });
    });
</script>
@endsection
