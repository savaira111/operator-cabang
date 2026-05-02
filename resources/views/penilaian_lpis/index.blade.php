@extends('layouts.app')

@section('title', 'Penilaian LPI')
@section('page_title', 'Penilaian Laporan Pengendalian Internal')

@section('content')
    <div class="mb-8">
        <h3 class="text-3xl font-black text-white tracking-tighter">Laporan Pengendalian Internal</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola dan pantau tingkat pengendalian internal operasional di tiap cabang.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 mb-8 border-b border-slate-800/60 pb-4">
        @php
            $steps = [
                1 => ['Identifikasi Risiko', 'file-search'],
                2 => ['Analisis Risiko', 'activity'],
                3 => ['Daftar Risiko Prioritas', 'shield-alert'],
                4 => ['Analisis Akar Masalah', 'help-circle'],
                5 => ['Rencana Tindak Pengendalian', 'check-square'],
                6 => ['Pemantauan Kegiatan', 'bar-chart-2'],
                7 => ['Pemantauan Peristiwa', 'alert-triangle'],
                8 => ['Pemantauan Level Risiko', 'layers'],
                9 => ['Reviu Usulan Risiko', 'clipboard-check'],
                10 => ['Kegiatan Belum Realisasi', 'clock'],
                11 => ['Hasil Evaluasi / Komentar', 'check-circle-2'],
            ];
        @endphp

        @foreach($steps as $sNum => $sInfo)
        <a href="{{ route('penilaian-lpi.index', ['step' => $sNum]) }}" class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all duration-300 active:scale-95 flex items-center justify-center text-center {{ $step == $sNum ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30 shadow-[0_0_15px_rgba(59,130,246,0.15)]' : 'bg-slate-800/40 text-slate-500 hover:bg-slate-800 hover:text-slate-300 border border-transparent' }}">
            <i data-lucide="{{ $sInfo[1] }}" class="w-4 h-4 inline-block mr-2"></i> {{ $sNum }}. {{ $sInfo[0] }}
        </a>
        @endforeach
    </div>

    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700 ease-out fill-mode-both">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <form action="{{ route('penilaian-lpi.index') }}" method="GET" class="flex flex-col md:flex-row items-center gap-3 w-full">
            <div class="relative group w-full max-w-md">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-blue-400 transition-colors"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 block pl-14 p-4 transition-all" placeholder="Cari pernyataan risiko...">
            </div>

            <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                <select name="cabang_id" class="px-5 py-4 bg-[#111827] rounded-2xl border border-slate-800 text-[10px] font-black text-slate-400 uppercase tracking-widest outline-none focus:border-blue-500 transition-all cursor-pointer min-w-[150px]">
                    <option value="">Semua Cabang</option>
                    @foreach($cabangs as $c)
                        <option value="{{ $c->id }}" {{ request('cabang_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>

                <select name="status_evaluasi" class="px-5 py-4 bg-[#111827] rounded-2xl border border-slate-800 text-[10px] font-black text-slate-400 uppercase tracking-widest outline-none focus:border-blue-500 transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="sesuai" {{ request('status_evaluasi') == 'sesuai' ? 'selected' : '' }}>Sesuai</option>
                    <option value="menunggu" {{ request('status_evaluasi') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="tidak_sesuai" {{ request('status_evaluasi') == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="p-4 bg-blue-500 hover:bg-blue-600 text-white rounded-2xl shadow-xl shadow-blue-500/20 transition-all active:scale-90" title="Terapkan Filter">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                    </button>
                    <a href="{{ route('penilaian-lpi.index') }}" class="p-4 bg-slate-800 hover:bg-slate-700 text-slate-400 rounded-2xl transition-all active:scale-90" title="Reset Filter">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </form>
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
                <tr class="bg-slate-800/40 border-b border-slate-800">
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Kode Risiko</th>
                    
                    @if($step == 1 || $step == 11)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
                    @elseif($step == 2)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Frekuensi</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Dampak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Level</th>
                    @elseif($step == 3)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Skor Kemungkinan</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Skor Dampak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Level Residu</th>
                    @elseif($step == 4)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Akar Penyebab</th>
                    @elseif($step == 5)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Rencana Tindak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Target Waktu</th>
                    @elseif($step == 6)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Rencana Tindak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Capaian Output</th>
                    @elseif($step == 7)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Peristiwa Terjadi</th>
                    @elseif($step == 8)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Level Residu</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Level Aktual</th>
                    @elseif($step == 9)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status Reviu</th>
                    @elseif($step == 10)
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Rencana Tindak</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Hambatan</th>
                    @endif

                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Progres</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($identifikasi_risikos as $risiko)
                <tr class="hover:bg-slate-800/20 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm font-bold text-white">{{ $risiko->cabang->name ?? 'N/A' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black border bg-emerald-500/10 text-emerald-400 border-emerald-500/20 uppercase tracking-widest">
                            {{ $risiko->kode_risiko ?? '-' }}
                        </span>
                    </td>
                    @if($step == 1 || $step == 11)
                        <td class="px-6 py-5">
                            <span class="text-xs font-medium text-slate-400 block truncate max-w-xs" title="{{ $risiko->pernyataan_risiko }}">
                                {{ $risiko->pernyataan_risiko }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @if($risiko->status_evaluasi == 'sesuai')
                                <span class="inline-flex items-center px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase whitespace-nowrap">Sesuai</span>
                            @elseif($risiko->status_evaluasi == 'menunggu')
                                <span class="inline-flex items-center px-3 py-1.5 bg-amber-500/10 text-amber-400 text-[9px] font-black rounded-lg border border-amber-500/20 uppercase whitespace-nowrap">Menunggu</span>
                            @elseif($risiko->status_evaluasi == 'tidak_sesuai')
                                <span class="inline-flex items-center px-3 py-1.5 bg-rose-500/10 text-rose-400 text-[9px] font-black rounded-lg border border-rose-500/20 uppercase whitespace-nowrap">Tidak Sesuai</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 bg-slate-700/30 text-slate-500 text-[9px] font-black rounded-lg border border-slate-700/50 uppercase whitespace-nowrap">Belum Dievaluasi</span>
                            @endif
                        </td>
                    @elseif($step == 2)
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold border {{ 
                                $risiko->analisisRisiko && $risiko->analisisRisiko->frekuensi == 5 ? 'bg-red-500/10 text-red-400 border-red-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->frekuensi == 4 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->frekuensi == 3 ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->frekuensi == 2 ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                'bg-blue-500/10 text-blue-400 border-blue-500/20')))
                            }}">
                                {{ $risiko->analisisRisiko->frekuensi ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold border {{ 
                                $risiko->analisisRisiko && $risiko->analisisRisiko->dampak == 5 ? 'bg-red-500/10 text-red-400 border-red-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->dampak == 4 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->dampak == 3 ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->dampak == 2 ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                'bg-blue-500/10 text-blue-400 border-blue-500/20')))
                            }}">
                                {{ $risiko->analisisRisiko->dampak ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider border {{ $risiko->analisisRisiko ? $risiko->analisisRisiko->getLevelBadgeClass($risiko->analisisRisiko->level_risiko) : 'bg-slate-800/40 text-slate-500 border-transparent' }}">
                                {{ $risiko->analisisRisiko->level_risiko ?? '-' }}
                            </span>
                        </td>
                    @elseif($step == 3)
                        <td class="px-6 py-5 text-sm font-bold">
                             <span class="inline-flex items-center px-2 py-1 rounded-lg border {{ 
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_probabilitas_residu == 5 ? 'bg-red-500/10 text-red-400 border-red-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_probabilitas_residu == 4 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_probabilitas_residu == 3 ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_probabilitas_residu == 2 ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                'bg-blue-500/10 text-blue-400 border-blue-500/20')))
                            }}">
                                {{ $risiko->analisisRisiko->skor_probabilitas_residu ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-sm font-bold">
                             <span class="inline-flex items-center px-2 py-1 rounded-lg border {{ 
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_dampak_residu == 5 ? 'bg-red-500/10 text-red-400 border-red-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_dampak_residu == 4 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_dampak_residu == 3 ? 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20' : (
                                $risiko->analisisRisiko && $risiko->analisisRisiko->skor_dampak_residu == 2 ? 'bg-green-500/10 text-green-400 border-green-500/20' : 
                                'bg-blue-500/10 text-blue-400 border-blue-500/20')))
                            }}">
                                {{ $risiko->analisisRisiko->skor_dampak_residu ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider border {{ $risiko->analisisRisiko ? $risiko->analisisRisiko->getLevelBadgeClass($risiko->analisisRisiko->level_risiko_residu) : 'bg-slate-800/40 text-slate-500 border-transparent' }}">
                                {{ $risiko->analisisRisiko->level_risiko_residu ?? '-' }}
                            </span>
                        </td>
                    @elseif($step == 4)
                        <td class="px-6 py-5">
                            <span class="text-xs font-medium text-slate-400 block truncate max-w-xs">{{ $risiko->pernyataan_risiko }}</span>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold italic">
                            {{ $risiko->resiko->akar_penyebab ?? '-' }}
                        </td>
                    @elseif($step == 5)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->resiko->rencanaTindak->rencana_tindak ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->resiko->rencanaTindak->waktu_pelaksanaan ?? '-' }}</td>
                    @elseif($step == 6)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->resiko->rencanaTindak->rencana_tindak ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->resiko->rencanaTindak->pemantauanKegiatan->first()->realisasi_waktu ?? '-' }}</td>
                    @elseif($step == 7)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->pernyataan_risiko }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold italic">Check Events</td>
                    @elseif($step == 8)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->pernyataan_risiko }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->analisisRisiko->level_risiko_residu ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold italic">Monitoring Level</td>
                    @elseif($step == 9)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->pernyataan_risiko }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold italic">Status Reviu</td>
                    @elseif($step == 10)
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold">{{ $risiko->resiko->rencanaTindak->rencana_tindak ?? '-' }}</td>
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold italic">Hambatan</td>
                    @endif

                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-16 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500" style="width: {{ $risiko->prosentase }}%"></div>
                            </div>
                            <span class="text-xs font-black text-indigo-400">{{ $risiko->prosentase }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ route('penilaian-lpi.edit', $risiko) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 hover:bg-blue-500 text-blue-400 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                            <i data-lucide="edit-3" class="w-3.5 h-3.5"></i>
                            Penilaian
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-600 italic text-sm">Belum ada data identifikasi risiko untuk dinilai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
