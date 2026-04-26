@extends('layouts.app')

@section('title', 'Detail Pemantauan Level Risiko')
@section('page_title', 'Detail Pemantauan Level')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Detail Pemantauan Level Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Laporan lengkap hasil pemantauan tingkat risiko.</p>
        </div>
        <a href="{{ route('pemantauan-level.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Kembali</span>
        </a>
    </div>

    <div class="space-y-8">
        <!-- HEADER INFO -->
        <div class="bg-slate-800/30 rounded-3xl p-8 border border-slate-700/50">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Pernyataan Risiko</p>
            <h4 class="text-xl font-bold text-white leading-tight mb-4">{{ $pemantauanLevel->analisisRisiko->identifikasiRisiko->pernyataan_risiko ?? '-' }}</h4>
            <div class="inline-flex items-center px-4 py-2 bg-slate-900 rounded-2xl border border-slate-800">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3 border-r border-slate-800 pr-3">Kejadian (1 Thn)</span>
                <span class="text-blue-400 font-black">{{ $pemantauanLevel->kejadian_count }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Risiko Direspons -->
            <div class="bg-slate-900/40 p-8 rounded-[2rem] border border-slate-800 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                    <i data-lucide="shield-check" class="w-32 h-32 text-white"></i>
                </div>
                <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center">
                    <span class="w-8 h-[1px] bg-slate-800 mr-3"></span>
                    Risiko yang Direspons
                </h4>
                <div class="grid grid-cols-3 gap-6 relative z-10">
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-slate-600 uppercase mb-2">Frekuensi</p>
                        <p class="text-2xl font-black text-white">{{ $pemantauanLevel->analisisRisiko->frekuensi ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-slate-600 uppercase mb-2">Dampak</p>
                        <p class="text-2xl font-black text-white">{{ $pemantauanLevel->analisisRisiko->dampak ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-slate-600 uppercase mb-2">Nilai</p>
                        <span class="inline-block px-3 py-1 rounded-lg font-black {{ $pemantauanLevel->analisisRisiko->getLevelBadgeClass($pemantauanLevel->analisisRisiko->level_risiko) }}">
                            {{ $pemantauanLevel->analisisRisiko->level_risiko ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Level Risiko Aktual -->
            <div class="bg-blue-500/5 p-8 rounded-[2rem] border border-blue-500/10 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.08] transition-opacity">
                    <i data-lucide="activity" class="w-32 h-32 text-blue-400"></i>
                </div>
                <h4 class="text-[10px] font-black text-blue-400/60 uppercase tracking-[0.2em] mb-8 flex items-center">
                    <span class="w-8 h-[1px] bg-blue-500/20 mr-3"></span>
                    Level Risiko Aktual
                </h4>
                <div class="grid grid-cols-3 gap-6 relative z-10">
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-blue-400/40 uppercase mb-2">Frekuensi</p>
                        <p class="text-2xl font-black text-blue-400">{{ $pemantauanLevel->analisisRisiko->skor_probabilitas_residu ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-blue-400/40 uppercase mb-2">Dampak</p>
                        <p class="text-2xl font-black text-blue-400">{{ $pemantauanLevel->analisisRisiko->skor_dampak_residu ?? '-' }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-[10px] font-bold text-blue-400/40 uppercase mb-2">Nilai</p>
                        <span class="inline-block px-3 py-1 rounded-lg font-black {{ $pemantauanLevel->analisisRisiko->getLevelBadgeClass($pemantauanLevel->analisisRisiko->level_risiko_residu) }}">
                            {{ $pemantauanLevel->analisisRisiko->level_risiko_residu ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- MANUAL INPUT DISPLAY -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-rose-500/5 p-8 rounded-3xl border border-rose-500/10">
                <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-4 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-2"></i> Deviasi
                </p>
                <p class="text-slate-300 text-sm leading-relaxed">{{ $pemantauanLevel->deviasi ?? 'Tidak ada deviasi.' }}</p>
            </div>
            <div class="bg-emerald-500/5 p-8 rounded-3xl border border-emerald-500/10">
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-4 flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i> Rekomendasi
                </p>
                <p class="text-slate-300 text-sm leading-relaxed">{{ $pemantauanLevel->rekomendasi ?? 'Tidak ada rekomendasi.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
