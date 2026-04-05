@extends('layouts.app')

@section('title', 'Data Tahanan')
@section('page_title', 'Database Laporan Tahanan')

@section('content')
<!-- Form Section (Based on SS) -->
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl mb-10">
    <div class="mb-10 text-center">
        <h3 class="text-2xl font-black text-white tracking-tight">Input Laporan Baru</h3>
        <p class="text-slate-500 text-sm mt-1 uppercase tracking-[0.2em] font-bold">Tambahan Field Sesuai Prosedur</p>
    </div>

    <form action="{{ route('tahanans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-8">
            <!-- Impor Data Excel (New Field) -->
            <div class="space-y-3">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Impor Data Excel</label>
                <div class="relative group">
                    <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                    <label for="excel_file" class="w-full px-5 py-[1.1rem] bg-indigo-500/5 hover:bg-indigo-500/10 border-2 border-dashed border-slate-700 hover:border-indigo-500/50 rounded-2xl text-slate-400 hover:text-indigo-400 font-bold text-xs transition-all cursor-pointer flex items-center justify-center group-hover:scale-[1.01]">
                        <i data-lucide="file-up" class="w-4 h-4 mr-2"></i>
                        <span id="file-label">Pilih File Excel (.xlsx, .xls)</span>
                    </label>
                </div>
            </div>

            <!-- Id_Cabang (Dropdown) -->
            <div class="space-y-3">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">ID Cabang (Lokasi)</label>
                <div class="relative group">
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="" selected disabled hidden>-- Pilih Cabang --</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
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
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Periode Tahun</label>
                <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="2026">
            </div>

            <!-- Submit Action -->
            <div class="pt-6 col-span-2">
                <button type="submit" class="w-full py-5 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase tracking-widest text-xs flex items-center justify-center">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Simpan Laporan Tahunan
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Table Section -->
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-xl font-black text-white tracking-tight">Daftar Riwayat Laporan</h3>
        <p class="text-slate-500 text-xs mt-1 uppercase tracking-widest">Catatan Penahanan Terpusat</p>
    </div>
    
    <div class="relative group max-w-sm w-full">
        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-4 h-4 text-slate-600 group-focus-within:text-indigo-400 transition-colors"></i>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-[11px] rounded-[1.2rem] focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 block pl-12 p-3.5 transition-all" placeholder="Cari laporan...">
    </div>
</div>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800/60">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">No Input</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Tanggal Input</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @forelse($tahanans as $tahanan)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-8 py-5">
                        <span class="text-xs font-mono font-bold text-indigo-400">
                            {{ $tahanan->no_input }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-white">{{ date('d M Y', strtotime($tahanan->tanggal_input)) }}</span>
                            <span class="text-[9px] text-slate-600 uppercase tracking-tighter">System Recorded</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center text-[11px] font-bold text-slate-300">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 mr-2 text-slate-700"></i>
                            {{ $tahanan->cabang->name ?? '-' }}
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1.5 rounded-lg bg-indigo-500/5 border border-indigo-500/10 text-[10px] font-black text-indigo-300 uppercase tracking-tighter">
                            {{ $tahanan->periode_bulan }} {{ $tahanan->periode_tahun }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            @if($tahanan->file_path)
                            <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="p-2.5 text-slate-500 hover:text-emerald-400 hover:bg-emerald-400/10 rounded-2xl transition-all" title="Download Excel">
                                <i data-lucide="download-cloud" class="w-4 h-4"></i>
                            </a>
                            @endif
                            <a href="{{ route('tahanans.show', $tahanan) }}" class="p-2.5 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-2xl transition-all" title="Detail Laporan">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('tahanans.edit', $tahanan) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-2xl transition-all" title="Edit Laporan">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('tahanans.destroy', $tahanan) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-2xl transition-all" onclick="confirmDelete(event, this.form)">
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
                            <div class="p-5 bg-slate-800/30 rounded-full mb-4">
                                <i data-lucide="inbox" class="w-10 h-10 text-slate-700"></i>
                            </div>
                            <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px]">Belum Ada Laporan Masuk</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('excel_file')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Pilih File Excel (.xlsx, .xls)';
    document.getElementById('file-label').textContent = fileName;
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
@endsection
