@extends('layouts.app')

@section('title', 'Detail Identifikasi Risiko')
@section('page_title', 'Detail Identifikasi Risiko')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter flex items-center">
            <i data-lucide="file-search" class="w-8 h-8 mr-4 text-blue-500"></i>
            Detail Identifikasi Risiko
        </h3>
        <p class="text-slate-500 text-sm mt-2 ml-12">Informasi lengkap mengenai identifikasi risiko.</p>
    </div>
    
    <a href="{{ route('identifikasi-risiko.index') }}" class="flex items-center px-5 py-2.5 bg-slate-800/40 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-xl border border-slate-700/50 transition-all active:scale-95">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 space-y-8">
                <!-- Header Info -->
                <div class="flex items-start justify-between border-b border-slate-800/60 pb-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Kode Risiko</p>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-black tracking-widest border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                                <i data-lucide="hash" class="w-4 h-4 mr-1"></i> {{ $identifikasi_risiko->kode_risiko ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Konteks -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Nama Konteks</p>
                        <p class="text-sm font-bold text-white tracking-tight leading-relaxed">{{ $identifikasi_risiko->nama_konteks ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Jenis Konteks</p>
                        <p class="text-sm font-bold text-slate-300 leading-relaxed">{{ $identifikasi_risiko->jenis_konteks ?? '-' }}</p>
                    </div>
                </div>

                <!-- Indikator & Pernyataan -->
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Indikator</p>
                        <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                            <p class="text-sm text-slate-300 font-medium leading-relaxed">{{ $identifikasi_risiko->indikator ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                        <div class="p-4 rounded-2xl bg-rose-500/5 border border-rose-500/10">
                            <p class="text-sm text-rose-200 font-medium leading-relaxed">{{ $identifikasi_risiko->pernyataan_risiko ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Kategori & Dampak -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kategori Risiko</p>
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black tracking-widest border mt-1 bg-amber-500/10 text-amber-400 border-amber-500/20">
                            {{ $identifikasi_risiko->kategori_risiko ?? '-' }}
                        </span>
                    </div>
                </div>

                <div class="space-y-6 border-t border-slate-800/60 pt-6">
                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Uraian Dampak</p>
                        <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800">
                            <p class="text-sm text-slate-300 font-medium leading-relaxed">{{ $identifikasi_risiko->uraian_dampak ?? '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Metode Pencapaian Tujuan SPIP</p>
                        <div class="p-4 rounded-2xl bg-indigo-500/5 border border-indigo-500/10">
                            <p class="text-sm text-indigo-300 font-medium leading-relaxed">{{ $identifikasi_risiko->metode_pencapaian_tujuan_spip ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="space-y-6">
        <!-- Action Card -->
        <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-6 shadow-xl">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 flex items-center">
                <i data-lucide="settings" class="w-3 h-3 mr-2"></i> Manajemen Data
            </h4>
            <div class="space-y-3">
                <a href="{{ route('identifikasi-risiko.edit', $identifikasi_risiko) }}" class="w-full flex items-center justify-center px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-blue-500/20 active:scale-95">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Data
                </a>
                <form action="{{ route('identifikasi-risiko.destroy', $identifikasi_risiko) }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-slate-800 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95" onclick="confirmHapus(event, this.form)">
                        <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i> Hapus Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Meta Info Card -->
        <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-6 shadow-xl">
            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                <i data-lucide="info" class="w-3 h-3 mr-2"></i> Informasi Sistem
            </h4>
            
            <div class="space-y-6">
                <div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Cabang / Unit Kerja</p>
                    <div class="flex items-center text-white font-bold mt-1">
                        <i data-lucide="building-2" class="w-4 h-4 mr-2 text-blue-400"></i>
                        {{ $identifikasi_risiko->cabang->nama ?? '-' }}
                    </div>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Dibuat Pada</p>
                    <p class="text-sm font-bold text-slate-300 mt-1 flex items-center">
                        <i data-lucide="calendar" class="w-3 h-3 mr-2 text-slate-500"></i>
                        {{ $identifikasi_risiko->created_at->format('d F Y') }}
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5 ml-5">{{ $identifikasi_risiko->created_at->format('H:i') }} WIB</p>
                </div>
                
                <div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Terakhir Diperbarui</p>
                    <p class="text-sm font-bold text-slate-300 mt-1 flex items-center">
                        <i data-lucide="clock" class="w-3 h-3 mr-2 text-slate-500"></i>
                        {{ $identifikasi_risiko->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
