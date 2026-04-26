@extends('layouts.app')

@section('title', 'Detail Evaluasi Risiko')
@section('page_title', 'Detail Evaluasi')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight text-emerald-400">Hasil Evaluasi / Komentar</h3>
            <p class="text-slate-500 text-sm mt-1">Laporan lengkap efektivitas pengendalian risiko.</p>
        </div>
        <a href="{{ route('evaluasi-risiko.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Kembali</span>
        </a>
    </div>

    <div class="space-y-10">
        <!-- TOP INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-800/30 rounded-[2.5rem] p-8 border border-slate-700/50">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Pernyataan Risiko</p>
                <h4 class="text-xl font-bold text-white leading-relaxed mb-6">{{ $evaluasiRisiko->resiko->pernyataan_risiko }}</h4>
                
                <div class="flex items-center space-x-3 pt-6 border-t border-slate-800">
                    <span class="px-3 py-1 bg-slate-900 rounded-lg text-[10px] font-black text-slate-400 border border-slate-800 uppercase">
                        Kode: {{ $evaluasiRisiko->resiko->kode }}
                    </span>
                    <span class="px-3 py-1 bg-slate-900 rounded-lg text-[10px] font-black text-amber-500 border border-slate-800 uppercase tracking-widest">
                        Penyebab: {{ $evaluasiRisiko->resiko->kode_penyebab_jenis }}{{ $evaluasiRisiko->resiko->kode_penyebab_nomor }}
                    </span>
                </div>
            </div>

            <div class="bg-slate-800/30 rounded-[2.5rem] p-8 border border-slate-700/50">
                <div class="grid grid-cols-2 gap-8 h-full">
                    <div class="flex flex-col justify-center items-center p-6 bg-blue-500/5 rounded-3xl border border-blue-500/10">
                        <p class="text-[9px] font-black text-blue-400/60 uppercase mb-2">Risiko Direspons</p>
                        <p class="text-lg font-black text-blue-400 text-center">{{ $evaluasiRisiko->rtp ? $evaluasiRisiko->rtp->level_risiko : '-' }}</p>
                    </div>
                    <div class="flex flex-col justify-center items-center p-6 bg-rose-500/5 rounded-3xl border border-rose-500/10">
                        <p class="text-[9px] font-black text-rose-400/60 uppercase mb-2">Risiko Aktual</p>
                        <p class="text-lg font-black text-rose-400 text-center">{{ $evaluasiRisiko->analisis ? $evaluasiRisiko->analisis->level_risiko_residu : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- OWNER & COMMENT -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-emerald-500/5 rounded-[2.5rem] p-8 border border-emerald-500/10 flex flex-col justify-center">
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-4">Pemilik Risiko</p>
                <h4 class="text-2xl font-black text-white leading-tight">{{ $evaluasiRisiko->pemilik_risiko }}</h4>
            </div>
            
            <div class="md:col-span-2 bg-slate-800/30 rounded-[2.5rem] p-10 border border-slate-700/50 shadow-inner">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                    <i data-lucide="message-square" class="w-4 h-4 mr-2"></i> Keterangan (Usulan / Komentar)
                </p>
                <p class="text-white text-lg leading-relaxed italic font-medium">"{{ $evaluasiRisiko->keterangan }}"</p>
            </div>
        </div>
    </div>
</div>
@endsection
