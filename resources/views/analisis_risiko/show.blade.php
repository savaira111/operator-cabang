@extends('layouts.app')

@section('title', 'Detail Analisis Risiko')
@section('page_title', 'Detail Analisis Risiko')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter flex items-center">
            <i data-lucide="activity" class="w-8 h-8 mr-4 text-blue-500"></i>
            Detail Analisis Risiko
        </h3>
        <p class="text-slate-500 text-sm mt-2 ml-12">Informasi lengkap mengenai analisis risiko.</p>
    </div>
    
    <a href="{{ route('analisis-risiko.index') }}" class="flex items-center px-5 py-2.5 bg-slate-800/40 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-xl border border-slate-700/50 transition-all active:scale-95">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-10">
                <!-- 1. IDENTIFIKASI -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-widest flex items-center">
                        <span class="w-4 h-px bg-blue-500/30 mr-2"></span>
                        Referensi Identifikasi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-1">Kode Risiko</p>
                            <span class="text-sm font-bold text-white tracking-tight uppercase">{{ $analisis_risiko->identifikasiRisiko->kode_risiko ?? '-' }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                            <p class="text-sm font-medium text-slate-300 leading-relaxed">{{ $analisis_risiko->identifikasiRisiko->pernyataan_risiko ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- 2. MELEKAT -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-amber-500 uppercase tracking-widest flex items-center">
                        <span class="w-4 h-px bg-amber-500/30 mr-2"></span>
                        Skor Risiko yang Melekat
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                            <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Probabilitas</p>
                            <p class="text-lg font-black text-amber-400">{{ $analisis_risiko->frekuensi ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                            <p class="text-[9px] font-black text-amber-600 uppercase tracking-widest mb-1">Dampak</p>
                            <p class="text-lg font-black text-amber-400">{{ $analisis_risiko->dampak ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl border {{ $analisis_risiko->getLevelBadgeClass($analisis_risiko->level_risiko) }}">
                            <p class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-70">Level</p>
                            <p class="text-lg font-black break-words leading-tight">{{ $analisis_risiko->level_risiko ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- 3. PENGENDALIAN -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-widest flex items-center">
                        <span class="w-4 h-px bg-emerald-500/30 mr-2"></span>
                        Pengendalian yang Ada
                    </h4>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Status Keberadaan</p>
                            <p class="text-sm font-bold text-white tracking-tight uppercase">{{ $analisis_risiko->ada_belum_ada ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                            <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-1">Status Kelayakan</p>
                            <p class="text-sm font-bold text-white tracking-tight uppercase">{{ $analisis_risiko->memadai_belum_memadai ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="p-6 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                        <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest mb-2">Uraian Pengendalian</p>
                        <p class="text-sm text-slate-300 font-medium leading-relaxed italic">{{ $analisis_risiko->uraian_pengendalian ?? '-' }}</p>
                    </div>
                </div>

                <!-- 4. RESIDU -->
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-blue-500 uppercase tracking-widest flex items-center">
                        <span class="w-4 h-px bg-blue-500/30 mr-2"></span>
                        Skor Risiko Residu
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-blue-500/5 border border-blue-500/10">
                            <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Probabilitas</p>
                            <p class="text-lg font-black text-blue-400">{{ $analisis_risiko->skor_probabilitas_residu ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-blue-500/5 border border-blue-500/10">
                            <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest mb-1">Dampak</p>
                            <p class="text-lg font-black text-blue-400">{{ $analisis_risiko->skor_dampak_residu ?? '-' }}</p>
                        </div>
                        <div class="p-4 rounded-2xl border {{ $analisis_risiko->getLevelBadgeClass($analisis_risiko->level_risiko_residu) }}">
                            <p class="text-[9px] font-black uppercase tracking-widest mb-1 opacity-70">Level</p>
                            <p class="text-lg font-black break-words leading-tight">{{ $analisis_risiko->level_risiko_residu ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-6 shadow-xl">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center">
                <i data-lucide="settings" class="w-3 h-3 mr-2"></i> Manajemen Data
            </h4>
            <div class="space-y-3">
                <a href="{{ route('analisis-risiko.edit', $analisis_risiko) }}" class="w-full flex items-center justify-center px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Data
                </a>
                <form action="{{ route('analisis-risiko.destroy', $analisis_risiko) }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-slate-800 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95" onclick="confirmHapus(event, this.form)">
                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
