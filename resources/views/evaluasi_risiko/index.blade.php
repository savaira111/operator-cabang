@extends('layouts.app')

@section('title', 'Hasil Evaluasi / Komentar')
@section('page_title', 'Hasil Evaluasi / Komentar')

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
    <a href="{{ route('pemantauan-level.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="layers" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 8. Pemantauan Level Risiko
    </a>
    <a href="{{ route('reviu-usulan.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="clipboard-check" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 9. Reviu Usulan Risiko
    </a>
    <a href="{{ route('rencana-belum-terealisasi.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent">
        <i data-lucide="clock" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 10. Kegiatan Belum Realisasi
    </a>
    <a href="{{ route('evaluasi-risiko.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
        <i data-lucide="check-circle-2" class="w-4 h-4 inline-block mr-1 -mt-0.5"></i> 11. Hasil Evaluasi / Komentar
    </a>
</div>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-700 ease-out fill-mode-both">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="relative group w-full max-w-md">
        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-emerald-400 transition-colors"></i>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 block pl-14 p-4 transition-all" placeholder="Cari data evaluasi...">
    </div>

    <a href="{{ route('evaluasi-risiko.create') }}" class="px-6 py-3 bg-emerald-500 text-white font-bold rounded-2xl flex items-center hover:bg-emerald-600 transition-all duration-300 shadow-xl shadow-emerald-500/30 active:scale-95 shrink-0">
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
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">No</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Kode</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Pernyataan Risiko</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Kode Penyebab</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60 text-center">Risiko yang Direspons</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60 text-center">Risiko Aktual</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Pemilik Risiko</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap border-r border-slate-800/60">Keterangan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] whitespace-nowrap text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @forelse($evaluasis as $index => $e)
                <tr class="hover:bg-slate-800/30 transition-all group text-xs">
                    <td class="px-6 py-4 font-bold text-slate-500 border-r border-slate-800/60">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-white font-black border-r border-slate-800/60 whitespace-nowrap">{{ $e->resiko->kode }}</td>
                    <td class="px-6 py-4 text-slate-400 border-r border-slate-800/60 min-w-[200px]">{{ $e->resiko->pernyataan_risiko }}</td>
                    <td class="px-6 py-4 border-r border-slate-800/60 text-center uppercase font-bold text-slate-500">
                        {{ $e->resiko->kode_penyebab_jenis }}{{ $e->resiko->kode_penyebab_nomor }}
                    </td>
                    <td class="px-6 py-4 text-center border-r border-slate-800/60">
                        @if($e->rtp)
                            <span class="px-2 py-1 rounded text-[10px] font-black bg-slate-800 border border-slate-700 text-blue-400">
                                {{ $e->rtp->level_risiko }}
                            </span>
                        @else
                            <span class="text-slate-700">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center border-r border-slate-800/60">
                        @if($e->analisis)
                            <span class="px-2 py-1 rounded text-[10px] font-black bg-slate-800 border border-slate-700 text-rose-400">
                                {{ $e->analisis->level_risiko_residu }}
                            </span>
                        @else
                            <span class="text-slate-700">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-white font-bold border-r border-slate-800/60 whitespace-nowrap">{{ $e->pemilik_risiko }}</td>
                    <td class="px-6 py-4 text-slate-400 border-r border-slate-800/60 italic min-w-[200px]">{{ $e->keterangan }}</td>

                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-1">
                            <a href="{{ route('evaluasi-risiko.show', $e) }}" class="p-2 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-xl transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('evaluasi-risiko.edit', $e) }}" class="p-2 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('evaluasi-risiko.destroy', $e) }}" method="POST" class="inline">
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
                    <td colspan="9" class="px-8 py-10 text-center text-slate-500 text-sm italic">Belum ada data evaluasi / komentar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
