@extends('layouts.app')

@section('title', 'Data Tahanan')
@section('page_title', 'Database Laporan Tahanan')

@section('content')
<!-- Header Section -->
<div class="max-w-6xl mx-auto space-y-10">
    <!-- Form Section -->
    <div class="w-full bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl overflow-hidden relative group">
        <!-- Decorative Background Gradient -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 blur-[100px] rounded-full group-hover:bg-blue-500/20 transition-all duration-700 hidden sm:block"></div>

        <div class="mb-6 md:mb-10 flex flex-col md:flex-row md:items-start justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center shadow-lg shadow-[#D2A039]/20 shrink-0">
                    <i data-lucide="user-minus" class="w-6 h-6 md:w-7 md:h-7 text-[#061B30]"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Input Laporan Baru</h3>
                    <p class="text-slate-400 text-[10px] md:text-sm mt-0.5 uppercase tracking-[0.2em] font-bold">Basis Data Penahanan Terpusat</p>
                </div>
            </div>
        </div>

        <form action="{{ route('tahanans.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <!-- Impor Data Excel -->
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Impor Data Excel</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                        <label for="excel_file" class="w-full px-4 py-4 md:px-5 md:py-6 bg-[#D2A039]/5 hover:bg-[#D2A039]/10 border-2 border-dashed border-slate-800 hover:border-[#D2A039]/40 rounded-xl md:rounded-2xl text-slate-400 hover:text-white transition-all cursor-pointer flex flex-col items-center justify-center gap-2 group-hover:scale-[1.01]">
                            <i data-lucide="file-up" class="w-5 h-5 md:w-6 md:h-6 text-[#D2A039]"></i>
                            <span id="file-label" class="font-bold text-[10px] md:text-xs">Pilih File Excel (.xlsx, .xls)</span>
                        </label>
                    </div>
                </div>

                <!-- Branch selection removed as per request - now fully automated -->

                <!-- Periode Bulan -->
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Bulan</label>
                    <div class="relative group/select">
                        <select name="periode_bulan" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none appearance-none cursor-pointer text-xs md:text-sm">
                            @php
                                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            @endphp
                            <option value="" selected disabled hidden>-- Pilih Bulan --</option>
                            @foreach($months as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Periode Tahun -->
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Tahun</label>
                    <div class="relative">
                        <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none text-xs md:text-sm">
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="md:col-span-2 pt-4">
                    <button type="submit" class="w-full py-5 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] hover:shadow-[0_0_25px_rgba(210,160,57,0.4)] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span class="uppercase tracking-widest text-xs font-black">Simpan Data Laporan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Section -->
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 px-2">
            <div>
                <h3 class="text-xl md:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <i data-lucide="database" class="w-5 h-5 md:w-6 md:h-6 text-[#D2A039]"></i>
                    Daftar Riwayat Laporan
                </h3>
                <p class="text-slate-500 text-[10px] md:text-xs mt-0.5 uppercase tracking-widest font-bold">Catatan Penahanan Terpusat</p>
            </div>
            
            <div class="relative group max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-4 md:pl-5 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-3.5 h-3.5 md:w-4 md:h-4 text-slate-600 group-focus-within:text-[#D2A039] transition-colors"></i>
                </div>
                <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#031121]/50 border border-slate-800 text-white text-[10px] md:text-[11px] rounded-xl md:rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 block pl-10 md:pl-12 p-3 md:p-4 transition-all outline-none" placeholder="Cari laporan...">
            </div>
        </div>

        <div class="bg-[#031121]/50 backdrop-blur-xl border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-800">
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">No</th>
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">No Input</th>
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tanggal</th>
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                            <th class="px-4 py-4 md:px-8 md:py-6 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/40">
                        @forelse($tahanans as $tahanan)
                        <tr class="hover:bg-white/[0.02] transition-all group">
                            <td class="px-4 py-4 md:px-8 md:py-5 text-[10px] md:text-xs font-bold text-slate-600 group-hover:text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 md:px-8 md:py-5">
                                <span class="px-2 py-0.5 md:px-2.5 md:py-1 rounded-md bg-blue-500/10 border border-blue-500/20 text-[9px] md:text-[10px] font-mono font-bold text-blue-400 tracking-wider whitespace-nowrap">
                                    {{ $tahanan->no_input }}
                                </span>
                            </td>
                            <td class="px-4 py-4 md:px-8 md:py-5">
                                <div class="flex flex-col">
                                    <span class="text-[10px] md:text-[11px] font-bold text-white whitespace-nowrap">{{ date('d M Y', strtotime($tahanan->tanggal_input)) }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 md:px-8 md:py-5">
                                <div class="flex items-center">
                                    <div class="px-3 py-1.5 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-xl text-[10px] md:text-[11px] font-black text-[#D2A039] uppercase tracking-tighter shadow-lg shadow-[#D2A039]/5 min-w-[140px] flex items-center gap-2.5">
                                        <div class="w-6 h-6 rounded-lg bg-[#D2A039]/20 flex items-center justify-center text-[#D2A039] shrink-0">
                                            <i data-lucide="building-2" class="w-3 h-3"></i>
                                        </div>
                                        <span class="truncate">{{ $tahanan->cabang->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 md:px-8 md:py-5">
                                <div class="flex flex-col sm:flex-row items-center gap-1">
                                    <span class="px-2 py-1 md:px-3 md:py-1.5 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/20 text-[9px] md:text-[10px] font-black text-[#D2A039] uppercase tracking-widest whitespace-nowrap">
                                        {{ $tahanan->periode_bulan }}
                                    </span>
                                    <span class="px-2 py-1 md:px-3 md:py-1.5 rounded-lg bg-slate-800 border border-slate-700 text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        {{ $tahanan->periode_tahun }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-4 md:px-8 md:py-5 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    @if($tahanan->file_path)
                                    <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center text-slate-500 hover:text-emerald-400 hover:bg-emerald-400/10 rounded-xl transition-all" title="Download">
                                        <i data-lucide="download-cloud" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                                    </a>
                                    @endif
                                    <a href="{{ route('tahanans.show', $tahanan) }}" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all" title="Detail">
                                        <i data-lucide="eye" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                                    </a>
                                    <a href="{{ route('tahanans.edit', $tahanan) }}" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all" title="Edit">
                                        <i data-lucide="edit-3" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                                    </a>
                                    <form action="{{ route('tahanans.destroy', $tahanan) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 md:w-9 md:h-9 flex items-center justify-center text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-900/50 rounded-3xl flex items-center justify-center mb-6 border border-slate-800">
                                        <i data-lucide="inbox" class="w-10 h-10 text-slate-700"></i>
                                    </div>
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum Ada Laporan Masuk</p>
                                    <p class="text-slate-700 text-[10px] mt-2">Gunakan form di atas untuk menambahkan laporan pertama Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Floating Action Bar (Sticky) -->
<div class="fixed bottom-20 left-4 right-4 z-40 md:hidden animate-in fade-in slide-in-from-bottom-10 duration-500">
    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="w-full py-4 bg-[#D2A039] text-[#061B30] font-black rounded-2xl shadow-2xl shadow-black/50 flex items-center justify-center gap-3 border border-white/10 active:scale-95 transition-all">
        <i data-lucide="plus" class="w-6 h-6"></i>
        <span>TAMBAH LAPORAN BARU</span>
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    
    document.getElementById('excel_file')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih File Excel (.xlsx, .xls)';
        const label = document.getElementById('file-label');
        label.textContent = fileName;
        label.classList.add('text-[#D2A039]');
    });
});

function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return;
        const text = row.innerText.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = "";
            row.classList.add('animate-in', 'fade-in', 'duration-300');
        } else {
            row.style.display = "none";
        }
    });
}
</script>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<style>
/* Custom Gold Theme for TomSelect */
.ts-wrapper {
    background-color: transparent !important;
    border: none !important;
    padding: 0 !important;
}
.ts-control {
    background-color: rgba(15, 23, 42, 0.6) !important;
    border: 1px solid #1e293b !important;
    color: white !important;
    border-radius: 1rem !important;
    padding: 1rem 1.25rem !important;
    font-family: inherit !important;
    font-size: 14px;
    box-shadow: none !important;
    transition: all 0.3s ease !important;
}
.ts-wrapper.focus .ts-control {
    border-color: rgba(210, 160, 57, 0.5) !important;
    box-shadow: 0 0 0 4px rgba(210, 160, 57, 0.1) !important;
}
.ts-dropdown {
    background-color: #031121 !important;
    border: 1px solid #1e293b !important;
    border-radius: 1rem !important;
    color: white !important;
    box-shadow: 0 15px 50px -12px rgba(0, 0, 0, 0.8) !important;
    margin-top: 0.5rem !important;
    overflow: hidden !important;
    backdrop-filter: blur(20px);
}
.ts-dropdown .option {
    padding: 0.75rem 1.25rem !important;
    font-weight: 500 !important;
    font-size: 0.875rem !important;
}
.ts-dropdown .option:hover, .ts-dropdown .option.active {
    background-color: rgba(210, 160, 57, 0.1) !important;
    color: #D2A039 !important;
}
.ts-control > input {
    color: white !important;
    font-size: 14px !important;
}
</style>
@endsection
