@extends('layouts.app')

@section('title', 'Penilaian LPI')
@section('page_title', 'Penilaian Laporan Pengendalian Internal')

@section('content')
<div class="mb-10 flex items-start justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">PENILAIAN LPI</h3>
        <p class="text-slate-500 text-sm mt-1">Evaluasi terhadap data identifikasi risiko (Laporan Internal).</p>
    </div>
</div>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800">
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Kode Risiko</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Pernyataan Risiko</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
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
                    <td class="px-6 py-5">
                        <span class="text-xs font-medium text-slate-400 block truncate max-w-xs" title="{{ $risiko->pernyataan_risiko }}">
                            {{ $risiko->pernyataan_risiko }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        @if($risiko->status_evaluasi == 'sesuai')
                            <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase">Sesuai</span>
                        @elseif($risiko->status_evaluasi == 'menunggu')
                            <span class="px-3 py-1.5 bg-amber-500/10 text-amber-400 text-[9px] font-black rounded-lg border border-amber-500/20 uppercase">Menunggu</span>
                        @elseif($risiko->status_evaluasi == 'tidak_sesuai')
                            <span class="px-3 py-1.5 bg-rose-500/10 text-rose-400 text-[9px] font-black rounded-lg border border-rose-500/20 uppercase">Tidak Sesuai</span>
                        @else
                            <span class="px-3 py-1.5 bg-slate-700/30 text-slate-500 text-[9px] font-black rounded-lg border border-slate-700/50 uppercase">Belum Dievaluasi</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-16 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500" style="width: {{ $risiko->prosentase }}%"></div>
                            </div>
                            <span class="text-xs font-black text-indigo-400">{{ $risiko->prosentase }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('penilaian-lpi.edit', $risiko) }}" class="p-3 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg active:scale-90" title="Berikan Penilaian">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                        </div>
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
