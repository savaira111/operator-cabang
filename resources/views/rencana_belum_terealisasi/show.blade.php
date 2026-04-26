@extends('layouts.app')

@section('title', 'Detail Rencana Belum Realisasi')
@section('page_title', 'Detail Realisasi')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight text-emerald-400">Rencana Kegiatan Belum Terealisasi</h3>
            <p class="text-slate-500 text-sm mt-1">Laporan lengkap rencana kegiatan pengendalian yang tertunda.</p>
        </div>
        <a href="{{ route('rencana-belum-terealisasi.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Kembali</span>
        </a>
    </div>

    <div class="space-y-10">
        <!-- MAIN INFO -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-800/30 rounded-[2rem] p-8 border border-slate-700/50">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Rencana Kegiatan Pengendalian</p>
                <h4 class="text-xl font-bold text-white leading-relaxed mb-6">{{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->rencana_tindak }}</h4>
                
                <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-800">
                    <div>
                        <p class="text-[9px] font-bold text-slate-600 uppercase mb-1">Target Waktu</p>
                        <p class="text-sm font-black text-emerald-400">{{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->waktu_pelaksanaan }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-600 uppercase mb-1">Penanggungjawab</p>
                        <p class="text-sm font-black text-white">{{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->penanggung_jawab }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/30 rounded-[2rem] p-8 border border-slate-700/50">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Pernyataan Risiko & Penyebab</p>
                <h4 class="text-lg font-bold text-slate-400 leading-relaxed mb-6">{{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->resiko->pernyataan_risiko }}</h4>
                
                <div class="flex items-center space-x-3 pt-6 border-t border-slate-800">
                    <span class="px-3 py-1 bg-slate-900 rounded-lg text-xs font-black text-blue-400 border border-slate-800">
                        Kode: {{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->resiko->kode }}
                    </span>
                    <span class="px-3 py-1 bg-slate-900 rounded-lg text-xs font-black text-amber-400 border border-slate-800 uppercase tracking-widest">
                        Penyebab: {{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->resiko->kode_penyebab_jenis }}{{ $rencanaBelumTerealisasi->rencanaTindakPengendalian->resiko->kode_penyebab_nomor }}
                    </span>
                </div>
            </div>
        </div>

        <!-- KETERANGAN CARD -->
        <div class="bg-rose-500/5 rounded-[2.5rem] p-10 border border-rose-500/10 shadow-inner">
            <h5 class="text-xs font-black text-rose-400 uppercase tracking-[0.2em] mb-6 flex items-center">
                <i data-lucide="alert-octagon" class="w-5 h-5 mr-3"></i> Keterangan Penyebab Belum Terealisasi
            </h5>
            <p class="text-white text-lg leading-relaxed italic font-medium">"{{ $rencanaBelumTerealisasi->keterangan }}"</p>
        </div>
    </div>
</div>
@endsection
