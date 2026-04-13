@extends('layouts.app')

@section('title', 'Detail Resiko')
@section('page_title', 'Informasi Detail Resiko')

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
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ $resiko->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Identitas Resiko Terdeteksi #{{ str_pad($resiko->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('resikos.edit', $resiko) }}" class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Ubah Resiko</span>
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
                        Klasifikasi & Tingkat Resiko
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Nama Identitas Resiko</p>
                            <p class="text-lg font-bold text-white tracking-tight">{{ $resiko->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Status Tingkatan</p>
                            @php
                                $badgeColor = match($resiko->status) {
                                    'low' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    'medium' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    'high' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                    default => 'bg-slate-800 text-slate-500 border-slate-700'
                                };
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest border mt-1 {{ $badgeColor }}">
                                {{ $resiko->status }} Risk
                            </span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Ditemukan di Cabang</p>
                            <div class="flex items-center text-white font-bold mt-1">
                                <i data-lucide="building-2" class="w-4 h-4 mr-2 text-slate-500"></i>
                                {{ $resiko->cabang->name ?? 'N/A' }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Waktu Identifikasi</p>
                            <p class="text-sm font-bold text-slate-300 mt-1 uppercase tracking-tighter">{{ $resiko->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="align-left" class="w-3 h-3 mr-2 text-rose-400"></i>
                        Deskripsi & Analisa Singkat
                    </h4>
                    <p class="text-slate-400 text-sm leading-relaxed whitespace-pre-line">
                        {{ $resiko->description ?? 'Tidak ada deskripsi detail atau analisa tambahan mengenai resiko ini.' }}
                    </p>
                </div>
            </div>

            <!-- Risk Sidebar -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-rose-500/10 to-amber-500/10 border border-rose-500/20 rounded-3xl p-8 shadow-inner overflow-hidden relative">
                    <div class="absolute -right-8 -top-8 opacity-5">
                         <i data-lucide="shield-alert" class="w-40 h-40"></i>
                    </div>
                    
                    <h4 class="text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] mb-8 text-center">Rekomendasi Tindakan</h4>
                    <div class="flex flex-col items-center text-center space-y-6">
                        @if($resiko->status == 'high')
                        <div class="p-4 bg-rose-500/20 border border-rose-500/30 rounded-2xl">
                            <p class="text-[10px] font-black text-rose-400 uppercase mb-2">Tindakan Segera</p>
                            <p class="text-[9px] text-slate-400">Hubungi administrator pusat dan cabang terkait untuk mitigasi langsung.</p>
                        </div>
                        @elseif($resiko->status == 'medium')
                        <div class="p-4 bg-amber-500/20 border border-amber-500/30 rounded-2xl">
                            <p class="text-[10px] font-black text-amber-400 uppercase mb-2">Pantau Berkala</p>
                            <p class="text-[9px] text-slate-400">Lakukan pemantauan setiap minggu untuk memastikan resiko tidak naik.</p>
                        </div>
                        @else
                        <div class="p-4 bg-emerald-500/20 border border-emerald-500/30 rounded-2xl">
                            <p class="text-[10px] font-black text-emerald-400 uppercase mb-2">Operasi Normal</p>
                            <p class="text-[9px] text-slate-400">Resiko rendah, cukup lakukan pencatatan dalam laporan bulanan.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-slate-800/10 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Audit Keamanan</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Integritas Data</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-400 font-black tracking-tighter">TERVERIFIKASI</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">UpdateID</span>
                            <span class="text-[10px] font-mono text-slate-600">R-{{ $resiko->id }}-OK</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
