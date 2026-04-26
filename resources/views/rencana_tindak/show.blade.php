@extends('layouts.app')

@section('title', 'Detail Rencana Tindak Pengendalian')
@section('page_title', 'Informasi Detail Rencana Tindak')

@section('content')
<div class="w-full animate-in fade-in zoom-in-95 duration-500 ease-out fill-mode-both">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="mb-10 flex flex-col md:flex-row md:items-start justify-between relative z-10 gap-6">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mr-6 shadow-xl shadow-emerald-500/5">
                    <i data-lucide="check-square" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Rencana Tindak</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Kode Analisis: {{ $rencana_tindak->resiko->kode ?? '-' }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('rencana-tindak.edit', $rencana_tindak) }}" class="flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-blue-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Ubah Data</span>
                </a>
                <a href="{{ route('rencana-tindak.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Kembali</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
            <!-- Rencana Info Card -->
            <div class="space-y-8">
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8 h-full">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center">
                        <i data-lucide="clipboard-list" class="w-3 h-3 mr-2 text-emerald-400"></i>
                        Detail Pelaksanaan
                    </h4>
                    
                    <div class="space-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Rencana Tindak Pengendalian</p>
                            <p class="text-sm font-bold text-white tracking-tight leading-relaxed">{{ $rencana_tindak->rencana_tindak ?? '-' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Respons Risiko</p>
                            <p class="text-sm font-bold text-slate-300 leading-relaxed">{{ $rencana_tindak->respons_risiko ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Indikator Keluaran</p>
                            <p class="text-sm font-bold text-slate-300 leading-relaxed">{{ $rencana_tindak->indikator_keluaran ?? '-' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Klasifikasi Sub Unsur SPIP</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black tracking-widest border mt-1 bg-indigo-500/10 text-indigo-400 border-indigo-500/20">
                                    {{ $rencana_tindak->klasifikasi_sub_unsur_spip ?? '-' }}
                                </span>
                            </div>
                            
                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Level Risiko</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black tracking-widest border mt-1 bg-rose-500/10 text-rose-400 border-rose-500/20">
                                    {{ $rencana_tindak->level_risiko ?? '-' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Target Waktu</p>
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black tracking-widest border mt-1 bg-amber-500/10 text-amber-400 border-amber-500/20">
                                    <i data-lucide="clock" class="w-3 h-3 mr-2"></i> {{ $rencana_tindak->waktu_pelaksanaan ?? '-' }}
                                </span>
                            </div>

                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Penanggung Jawab</p>
                                <div class="flex items-center text-white font-bold mt-1">
                                    <i data-lucide="user" class="w-4 h-4 mr-2 text-slate-500"></i>
                                    {{ $rencana_tindak->penanggung_jawab ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Frekuensi</p>
                                <div class="text-sm font-bold text-white mt-1">{{ $rencana_tindak->frekuensi ?? '-' }}</div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Dampak</p>
                                <div class="text-sm font-bold text-white mt-1">{{ $rencana_tindak->dampak ?? '-' }}</div>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Waktu Dibuat</p>
                            <p class="text-sm font-bold text-slate-300 mt-1 uppercase tracking-tighter">{{ $rencana_tindak->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Referensi Analisis Card -->
            <div class="space-y-8">
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8 h-full relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center relative z-10">
                        <i data-lucide="file-search" class="w-3 h-3 mr-2 text-rose-400"></i>
                        Referensi Analisis Akar Masalah
                    </h4>
                    
                    <div class="space-y-6 relative z-10">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kode Penyebab</p>
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border mt-1 bg-rose-500/10 text-rose-400 border-rose-500/20">
                                @if($rencana_tindak->resiko)
                                    {{ str_replace(' ', '', $rencana_tindak->resiko->kode) }}{{ $rencana_tindak->resiko->kode_penyebab_jenis }}.{{ $rencana_tindak->resiko->kode_penyebab_nomor }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                            <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                                <p class="text-sm text-slate-300 font-medium leading-relaxed">{{ $rencana_tindak->resiko->pernyataan_risiko ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Akar Penyebab / Pernyataan Penyebab</p>
                            <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                                <p class="text-sm text-slate-300 font-medium leading-relaxed">{{ $rencana_tindak->resiko->akar_penyebab ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kegiatan Pengendalian</p>
                            <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                                <p class="text-sm text-slate-300 font-medium leading-relaxed">{{ $rencana_tindak->resiko->kegiatan_pengendalian ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-800/60">
                            <a href="{{ route('resikos.show', $rencana_tindak->resiko_id) }}" class="inline-flex items-center text-xs font-bold text-rose-400 hover:text-rose-300 transition-colors uppercase tracking-widest">
                                Lihat Detail Laporan Penuh <i data-lucide="arrow-right" class="w-3 h-3 ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
