@extends('layouts.app')

@section('title', 'Pemantauan Kegiatan Pengendalian')
@section('page_title', 'Pemantauan Kegiatan Pengendalian')

@section('content')
<div class="mb-8">
    <h3 class="text-3xl font-black text-white tracking-tighter">Laporan Pengendalian Internal</h3>
    <p class="text-slate-500 text-sm mt-1">Kelola dan pantau tingkat pengendalian internal operasional di tiap cabang.</p>
</div>

<div class="flex flex-wrap gap-2 mb-8 border-b border-slate-800/60 pb-4">
    <a href="{{ route('identifikasi-risiko.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="file-search" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 1. Identifikasi Risiko
    </a>
    <a href="{{ route('analisis-risiko.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="activity" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 2. Analisis Risiko
    </a>
    <a href="{{ route('daftar-prioritas.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="shield-alert" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 3. Daftar Risiko Prioritas
    </a>
    <a href="{{ route('resikos.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="help-circle" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 4. Analisis Akar Masalah
    </a>
    <a href="{{ route('rencana-tindak.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="check-square" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 5. Rencana Tindak Pengendalian
    </a>
    <a href="{{ route('pemantauan-kegiatan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('pemantauan-kegiatan.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="bar-chart-2" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 6. Pemantauan Kegiatan
    </a>
    <a href="{{ route('pemantauan-peristiwa.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('pemantauan-peristiwa.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="alert-triangle" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 7. Pemantauan Peristiwa
    </a>
    <a href="{{ route('pemantauan-level.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('pemantauan-level.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="layers" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 8. Pemantauan Level Risiko
    </a>
    <a href="{{ route('reviu-usulan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('reviu-usulan.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="clipboard-check" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 9. Reviu Usulan Risiko
    </a>
    <a href="{{ route('rencana-belum-terealisasi.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('rencana-belum-terealisasi.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="clock" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 10. Kegiatan Belum Realisasi
    </a>
    <a href="{{ route('evaluasi-risiko.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 {{ request()->routeIs('evaluasi-risiko.*') ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
        <i data-lucide="check-circle-2" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 11. Hasil Evaluasi / Komentar
    </a>
</div>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-700 ease-out fill-mode-both">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="relative group w-full max-w-md">
        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-rose-400 transition-colors"></i>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 block pl-14 p-4 transition-all" placeholder="Cari data pemantauan...">
    </div>

    <a href="{{ route('pemantauan-kegiatan.create') }}" class="px-6 py-3 bg-blue-500 text-white font-bold rounded-2xl flex items-center hover:bg-blue-600 transition-all duration-300 shadow-xl shadow-blue-500/30 active:scale-95 shrink-0">
        <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
        Create
    </a>
</div>

<script>
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

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800/60">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap">Kode</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap">Pernyataan Risiko</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap">Kegiatan Pengendalian</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap">Penanggung Jawab</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @forelse($pemantauans as $pemantauan)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                            {{ $pemantauan->rencanaTindak->resiko->kode ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-white tracking-tight text-sm block min-w-[200px]">
                            {{ $pemantauan->rencanaTindak->resiko->pernyataan_risiko ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-slate-300 tracking-tight text-sm block min-w-[200px]">
                            {{ $pemantauan->rencanaTindak->rencana_tindak ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-400 font-bold uppercase tracking-tight whitespace-nowrap">
                        {{ $pemantauan->rencanaTindak->penanggung_jawab ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2 transition-all">
                            <a href="{{ route('pemantauan-kegiatan.show', $pemantauan) }}" class="p-2.5 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-2xl transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('pemantauan-kegiatan.edit', $pemantauan) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-2xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('pemantauan-kegiatan.destroy', $pemantauan) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-2xl transition-all" onclick="confirmHapus(event, this.form)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500 text-sm italic">Belum ada data pemantauan kegiatan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
