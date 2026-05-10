@extends('layouts.app')

@section('title', 'Laporan Internal Excel')
@section('page_title', 'Laporan Internal Excel')

@section('content')
<div class="mb-8">
    <h3 class="text-3xl font-black text-white tracking-tighter">Laporan Internal Excel</h3>
    <p class="text-slate-500 text-sm mt-1">Kelola laporan internal berbasis file Excel untuk tiap kategori risiko.</p>
</div>

<!-- Tabs Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mb-8 border-b border-slate-800/60 pb-4">
    @foreach($categories as $id => $label)
    <a href="{{ route('laporan-internal-excel.index', ['category_id' => $id]) }}" 
       class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 flex items-center justify-center text-center {{ $categoryId == $id ? 'bg-[#D2A039]/20 text-[#D2A039] border border-[#D2A039]/30 shadow-[0_0_15px_rgba(210,160,57,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="file-spreadsheet" class="w-4 h-4 inline-block mr-2"></i> {{ $id }}. {{ $label }}
    </a>
    @endforeach
</div>

<div class="max-w-6xl mx-auto space-y-10">
    <!-- Import Form Section -->
    <div class="w-full bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl overflow-hidden relative group">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block"></div>
        
        <div class="mb-6 md:mb-10 flex flex-col md:flex-row md:items-start justify-between gap-6 relative z-10">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center shadow-lg shadow-[#D2A039]/20 shrink-0">
                    <i data-lucide="upload-cloud" class="w-6 h-6 md:w-7 md:h-7 text-[#061B30]"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Impor {{ $categories[$categoryId] }}</h3>
                    <p class="text-slate-400 text-[10px] md:text-sm mt-0.5 uppercase tracking-[0.2em] font-bold">Unggah File Excel untuk Kategori ini</p>
                </div>
            </div>
        </div>

        <form action="{{ route('laporan-internal-excel.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
            @csrf
            <input type="hidden" name="category_id" value="{{ $categoryId }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">File Excel (.xlsx, .xls)</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv" required>
                        <label for="excel_file" class="w-full px-4 py-4 md:px-5 md:py-6 bg-[#D2A039]/5 hover:bg-[#D2A039]/10 border-2 border-dashed border-slate-800 hover:border-[#D2A039]/40 rounded-xl md:rounded-2xl text-slate-400 hover:text-white transition-all cursor-pointer flex flex-col items-center justify-center gap-2 group-hover:scale-[1.01]">
                            <i data-lucide="file-up" class="w-5 h-5 md:w-6 md:h-6 text-[#D2A039]"></i>
                            <span id="file-label" class="font-bold text-[10px] md:text-xs">Klik untuk pilih file</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2 md:space-y-3">
                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Bulan</label>
                        <select name="periode_bulan" required class="w-full px-4 py-3 bg-slate-900/60 rounded-xl border border-slate-800 text-white text-xs">
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                                <option value="{{ $m }}">{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-2 md:space-y-3">
                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Tahun</label>
                        <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-4 py-3 bg-slate-900/60 rounded-xl border border-slate-800 text-white text-xs">
                    </div>
                </div>

                @if(!auth()->user()->cabang_id)
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">UPT / Cabang</label>
                    <select name="cabang_id" required class="w-full px-4 py-3 bg-slate-900/60 rounded-xl border border-slate-800 text-white text-xs">
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-3 bg-slate-900/60 rounded-xl border border-slate-800 text-white text-xs"></textarea>
                </div>

                <div class="md:col-span-2 pt-2">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-3 shadow-xl shadow-[#D2A039]/20">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span class="uppercase tracking-widest text-xs">Simpan Laporan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Section -->
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 px-2">
            <div>
                <h3 class="text-xl md:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <i data-lucide="database" class="w-5 h-5 text-[#D2A039]"></i>
                    Riwayat Laporan {{ $categories[$categoryId] }}
                </h3>
            </div>
            <div class="relative group max-w-sm w-full">
                <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#031121]/50 border border-slate-800 text-white text-[11px] rounded-xl pl-10 p-3" placeholder="Cari laporan...">
                <i data-lucide="search" class="absolute left-4 top-3.5 w-4 h-4 text-slate-600"></i>
            </div>
        </div>

        <div class="bg-[#031121]/50 backdrop-blur-xl border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-900/50 border-b border-slate-800">
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">No</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">No Input</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Cabang</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest">Periode</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/40">
                        @forelse($reports as $report)
                        <tr class="hover:bg-white/[0.02] transition-all">
                            <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $loop->iteration }}</td>
                            <td class="px-8 py-5">
                                <span class="px-2.5 py-1 rounded-md bg-blue-500/10 border border-blue-500/20 text-[10px] font-mono font-bold text-blue-400">
                                    {{ $report->no_input }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-bold text-slate-300">{{ $report->cabang->name ?? '-' }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-xs font-bold text-[#D2A039]">{{ $report->periode_bulan }} {{ $report->periode_tahun }}</span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end space-x-1">
                                    <a href="{{ route('laporan-internal-excel.show', $report) }}" class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('laporan-internal-excel.edit', $report) }}" class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all">
                                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('laporan-internal-excel.destroy', $report) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="inbox" class="w-12 h-12 text-slate-800 mb-4"></i>
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada laporan untuk kategori ini</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    document.getElementById('excel_file')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Klik untuk pilih file';
        const label = document.getElementById('file-label');
        label.textContent = fileName;
        label.classList.add('text-[#D2A039]');
    });
});

function filterTable() {
    const filter = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return;
        row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
    });
}
</script>
@endsection
