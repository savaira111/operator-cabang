@extends('layouts.app')

@section('title', 'Detail Reviu Usulan Risiko')
@section('page_title', 'Detail Reviu Usulan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Detail Reviu Usulan Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Laporan lengkap reviu usulan risiko baru.</p>
        </div>
        <a href="{{ route('reviu-usulan.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Kembali</span>
        </a>
    </div>

    <div class="space-y-10">
        <!-- USULAN INFO -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 bg-slate-800/30 rounded-[2rem] p-8 border border-slate-700/50">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Usulan Pernyataan Risiko</p>
                <h4 class="text-xl font-bold text-white leading-relaxed mb-6">{{ $reviuUsulan->usulan_pernyataan_risiko }}</h4>
                <div class="flex items-center space-x-6 pt-6 border-t border-slate-800">
                    <div>
                        <p class="text-[9px] font-bold text-slate-600 uppercase mb-1">Kode Terkait</p>
                        <p class="text-sm font-black text-blue-400">{{ $reviuUsulan->resiko->kode }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-bold text-slate-600 uppercase mb-1">Unit Pengusul</p>
                        <p class="text-sm font-black text-white">{{ $reviuUsulan->unit_pemilik_pengusul }}</p>
                    </div>
                </div>
            </div>

            <!-- STATUS CARD -->
            <div class="bg-slate-900/40 rounded-[2rem] p-8 border border-slate-800 flex flex-col items-center justify-center text-center">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">Status Reviu</p>
                @if($reviuUsulan->status === 'Diterima')
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="check-circle" class="w-10 h-10 text-emerald-400"></i>
                    </div>
                    <h5 class="text-2xl font-black text-emerald-400 uppercase tracking-tighter">Diterima</h5>
                @else
                    <div class="w-20 h-20 bg-rose-500/10 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="x-circle" class="w-10 h-10 text-rose-400"></i>
                    </div>
                    <h5 class="text-2xl font-black text-rose-400 uppercase tracking-tighter">Ditolak</h5>
                @endif
            </div>
        </div>

        <!-- ALASAN DETAILS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 rounded-3xl bg-emerald-500/5 border border-emerald-500/10 {{ $reviuUsulan->status === 'Diterima' ? '' : 'opacity-40 grayscale' }}">
                <h6 class="text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-4 flex items-center">
                    <i data-lucide="message-square" class="w-4 h-4 mr-2"></i> Alasan Diterima
                </h6>
                <p class="text-slate-300 text-sm leading-relaxed">{{ $reviuUsulan->alasan_diterima ?? '-' }}</p>
            </div>

            <div class="p-8 rounded-3xl bg-rose-500/5 border border-rose-500/10 {{ $reviuUsulan->status === 'Ditolak' ? '' : 'opacity-40 grayscale' }}">
                <h6 class="text-[11px] font-black text-rose-400 uppercase tracking-widest mb-4 flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-2"></i> Alasan Ditolak
                </h6>
                <p class="text-slate-300 text-sm leading-relaxed">{{ $reviuUsulan->alasan_ditolak ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
