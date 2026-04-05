@extends('layouts.app')

@section('title', 'Detail Cabang')
@section('page_title', 'Informasi Detail Kantor Cabang')

@section('content')
<div class="w-full">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="mb-10 flex items-start justify-between relative z-10">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mr-6 shadow-xl shadow-blue-500/5">
                    <i data-lucide="building-2" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ $cabang->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Kantor Cabang Operasional #{{ str_pad($cabang->id, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('cabangs.edit', $cabang) }}" class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Edit Cabang</span>
                </a>
                <a href="{{ route('cabangs.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Kembali</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <!-- Branch Info Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center">
                        <i data-lucide="map" class="w-3 h-3 mr-2 text-blue-400"></i>
                        Informasi Geografis & Operasional
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Nama Kantor Cabang</p>
                            <p class="text-lg font-bold text-white tracking-tight">{{ $cabang->name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kepala Cabang</p>
                            <p class="text-lg font-bold text-indigo-400 tracking-tight">{{ $cabang->kepala_cabang ?? 'Belum Ditunjuk' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Wilayah Operasional</p>
                            <div class="flex items-center text-white font-bold mt-1">
                                <i data-lucide="map-pin" class="w-4 h-4 mr-2 text-slate-500"></i>
                                {{ $cabang->location }}
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Status Kantor</p>
                            <span class="inline-flex px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-xs font-black text-emerald-400 uppercase tracking-widest mt-1">
                                AKTIF
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="home" class="w-3 h-3 mr-2 text-blue-400"></i>
                        Alamat Lengkap
                    </h4>
                    <p class="text-slate-400 text-sm leading-relaxed whitespace-pre-line">
                        {{ $cabang->alamat ?? 'Alamat lengkap belum dicatat untuk kantor cabang ini.' }}
                    </p>
                </div>
            </div>

            <!-- Profile Sidebar -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-blue-500/10 to-indigo-500/10 border border-blue-500/20 rounded-3xl p-8 shadow-inner overflow-hidden relative">
                    <div class="absolute -right-8 -top-8 opacity-5">
                         <i data-lucide="building-2" class="w-40 h-40"></i>
                    </div>
                    
                    <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] mb-8">Deskripsi Cabang</h4>
                    <p class="text-xs text-slate-400 leading-loose italic">
                         {{ $cabang->description ?? 'Tidak ada deskripsi tambahan mengenai operasional kantor cabang ini.' }}
                    </p>
                </div>

                <div class="bg-slate-800/10 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 text-center">Infrastruktur Digital</h4>
                    <div class="flex items-center justify-around">
                        <div class="text-center group">
                            <div class="w-12 h-12 bg-slate-800 group-hover:bg-blue-500/10 rounded-2xl flex items-center justify-center text-slate-600 group-hover:text-blue-400 mb-2 transition-all">
                                <i data-lucide="users" class="w-5 h-5"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-600 group-hover:text-slate-400 transition-all uppercase">Users</p>
                        </div>
                        <div class="text-center group">
                            <div class="w-12 h-12 bg-slate-800 group-hover:bg-rose-500/10 rounded-2xl flex items-center justify-center text-slate-600 group-hover:text-rose-400 mb-2 transition-all">
                                <i data-lucide="shield-alert" class="w-5 h-5"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-600 group-hover:text-slate-400 transition-all uppercase">Risks</p>
                        </div>
                        <div class="text-center group">
                            <div class="w-12 h-12 bg-slate-800 group-hover:bg-indigo-500/10 rounded-2xl flex items-center justify-center text-slate-600 group-hover:text-indigo-400 mb-2 transition-all">
                                <i data-lucide="file-text" class="w-5 h-5"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-600 group-hover:text-slate-400 transition-all uppercase">Logs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
