@extends('layouts.app')

@section('title', 'Daftar Pemantauan Level Risiko')
@section('page_title', 'Pemantauan Level Risiko')

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
    <a href="{{ route('pemantauan-kegiatan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="bar-chart-2" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 6. Pemantauan Kegiatan
    </a>
    <a href="{{ route('pemantauan-peristiwa.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
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
            <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-blue-400 transition-colors"></i>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 block pl-14 p-4 transition-all" placeholder="Cari data pemantauan level...">
    </div>

    <a href="{{ route('pemantauan-level.create') }}" class="px-6 py-3 bg-blue-500 text-white font-bold rounded-2xl flex items-center hover:bg-blue-600 transition-all duration-300 shadow-xl shadow-blue-500/30 active:scale-95 shrink-0">
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
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800/60">
                    <th rowspan="2" class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">No</th>
                    <th rowspan="2" class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Pernyataan Risiko</th>
                    <th rowspan="2" class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Kejadian (1 Thn)</th>
                    <th colspan="3" class="px-6 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center border-b border-r border-slate-800/60">Risiko Direspons</th>
                    <th colspan="3" class="px-6 py-2 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center border-b border-r border-slate-800/60">Level Risiko Aktual</th>
                    <th rowspan="2" class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap text-right">Aksi</th>
                </tr>
                <tr class="bg-slate-800/20 border-b border-slate-800/60">
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">F</th>
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">D</th>
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">Nilai</th>
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">F</th>
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">D</th>
                    <th class="px-4 py-2 text-[9px] font-black text-slate-500 uppercase tracking-widest text-center border-r border-slate-800/60">Nilai</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @forelse($pemantauans as $index => $p)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-6 py-4 text-sm font-bold text-slate-500 border-r border-slate-800/60">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 border-r border-slate-800/60">
                        <span class="font-bold text-white tracking-tight text-sm block min-w-[250px]">
                            {{ $p->analisisRisiko->identifikasiRisiko->pernyataan_risiko ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center border-r border-slate-800/60">
                        <span class="px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-black">{{ $p->kejadian_count }}</span>
                    </td>
                    
                    <!-- Risiko Direspons -->
                    <td class="px-4 py-4 text-center text-xs text-slate-400 border-r border-slate-800/60">{{ $p->analisisRisiko->frekuensi ?? '-' }}</td>
                    <td class="px-4 py-4 text-center text-xs text-slate-400 border-r border-slate-800/60">{{ $p->analisisRisiko->dampak ?? '-' }}</td>
                    <td class="px-4 py-4 text-center border-r border-slate-800/60">
                        <span class="px-2 py-1 rounded text-[10px] font-black {{ $p->analisisRisiko->getLevelBadgeClass($p->analisisRisiko->level_risiko) }}">
                            {{ $p->analisisRisiko->level_risiko ?? '-' }}
                        </span>
                    </td>

                    <!-- Level Risiko Aktual -->
                    <td class="px-4 py-4 text-center text-xs text-blue-400 border-r border-slate-800/60">{{ $p->analisisRisiko->skor_probabilitas_residu ?? '-' }}</td>
                    <td class="px-4 py-4 text-center text-xs text-blue-400 border-r border-slate-800/60">{{ $p->analisisRisiko->skor_dampak_residu ?? '-' }}</td>
                    <td class="px-4 py-4 text-center border-r border-slate-800/60">
                        <span class="px-2 py-1 rounded text-[10px] font-black {{ $p->analisisRisiko->getLevelBadgeClass($p->analisisRisiko->level_risiko_residu) }}">
                            {{ $p->analisisRisiko->level_risiko_residu ?? '-' }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('pemantauan-level.show', $p) }}" class="p-2 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('pemantauan-level.edit', $p) }}" class="p-2 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('pemantauan-level.destroy', $p) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-8 py-10 text-center text-slate-500 text-sm italic">Belum ada data pemantauan level risiko.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
