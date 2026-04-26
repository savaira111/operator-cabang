@extends('layouts.app')

@section('title', 'Detail Laporan Pengendalian')
@section('page_title', 'Informasi Detail Laporan Pengendalian')

@section('content')
<div class="w-full">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-rose-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl"></div>

        <div class="mb-10 flex items-start justify-between relative z-10">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 mr-6 shadow-xl shadow-rose-500/5">
                    <i data-lucide="shield-alert" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ $resiko->kode ?? 'WP. ' . $resiko->id }}</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Identitas Laporan Pengendalian</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('resikos.edit', $resiko) }}" class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Ubah Laporan</span>
                </a>
                <a href="{{ route('resikos.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Kembali</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <!-- Risk Info Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center">
                        <i data-lucide="alert-triangle" class="w-3 h-3 mr-2 text-rose-400"></i>
                        Klasifikasi Laporan Pengendalian
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                            <p class="text-sm font-bold text-white tracking-tight">{{ $resiko->pernyataan_risiko ?? ($resiko->name ?? '-') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kode Penyebab</p>
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border mt-1 bg-rose-500/10 text-rose-400 border-rose-500/20">
                                {{ str_replace(' ', '', $resiko->kode) }}{{ $resiko->kode_penyebab_jenis }}.{{ $resiko->kode_penyebab_nomor }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Akar Penyebab</p>
                            <p class="text-sm font-bold text-white mt-1">{{ $resiko->akar_penyebab ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Waktu Identifikasi</p>
                            <p class="text-sm font-bold text-slate-300 mt-1 uppercase tracking-tighter">{{ $resiko->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="align-left" class="w-3 h-3 mr-2 text-rose-400"></i>
                        Analisis 5 Why
                    </h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="text-rose-400 font-bold mr-4">W1</span>
                            <p class="text-slate-300 text-sm flex-1">{{ $resiko->why_1 ?? '-' }}</p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-rose-400 font-bold mr-4">W2</span>
                            <p class="text-slate-300 text-sm flex-1">{{ $resiko->why_2 ?? '-' }}</p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-rose-400 font-bold mr-4">W3</span>
                            <p class="text-slate-300 text-sm flex-1">{{ $resiko->why_3 ?? '-' }}</p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-rose-400 font-bold mr-4">W4</span>
                            <p class="text-slate-300 text-sm flex-1">{{ $resiko->why_4 ?? '-' }}</p>
                        </div>
                        <div class="flex items-start">
                            <span class="text-rose-400 font-bold mr-4">W5</span>
                            <p class="text-slate-300 text-sm flex-1">{{ $resiko->why_5 ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Risk Sidebar -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-indigo-500/10 to-blue-500/10 border border-indigo-500/20 rounded-3xl p-8 shadow-inner overflow-hidden relative h-full">
                    <div class="absolute -right-8 -top-8 opacity-5">
                         <i data-lucide="check-circle" class="w-40 h-40"></i>
                    </div>
                    
                    <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                        Kegiatan Pengendalian
                    </h4>
                    <div class="text-slate-300 text-sm leading-relaxed whitespace-pre-line relative z-10">
                        {{ $resiko->kegiatan_pengendalian ?? ($resiko->description ?? 'Tidak ada kegiatan pengendalian detail.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
