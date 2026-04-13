@extends('layouts.app')

@section('title', 'Detail Pengguna')
@section('page_title', 'Informasi Detail Pengguna')

@section('content')
<div class="w-full">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="mb-10 flex items-start justify-between relative z-10">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mr-6 shadow-xl shadow-blue-500/5">
                    <i data-lucide="user" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Profil Akun @<span>{{ $user->username }}</span></p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('users.edit', $user) }}" class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Ubah Akun</span>
                </a>
                <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Kembali</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <!-- Account Info Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center">
                        <i data-lucide="shield" class="w-3 h-3 mr-2 text-blue-400"></i>
                        Kredensial & Otoritas
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-y-8">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Username Akun</p>
                            <p class="text-lg font-mono font-bold text-blue-400">@<span>{{ $user->username }}</span></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Email Terdaftar</p>
                            <p class="text-lg font-bold text-white tracking-tight lowercase">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Hak Akses (Role)</p>
                            <span class="inline-flex px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-xl text-xs font-black text-blue-300 uppercase tracking-widest mt-1">
                                {{ $user->role }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Penempatan Kantor</p>
                            <div class="flex items-center text-white font-bold mt-1">
                                <i data-lucide="building-2" class="w-4 h-4 mr-2 text-slate-500"></i>
                                {{ $user->cabang->name ?? 'Administrator (Pusat)' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="info" class="w-3 h-3 mr-2 text-blue-400"></i>
                        Status Sistem
                    </h4>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 mr-2 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                            <span class="text-sm font-bold text-slate-300">Aktif</span>
                        </div>
                        <div class="flex items-center">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2 text-slate-600"></i>
                            <span class="text-sm text-slate-500 font-medium">Terdaftar sejak {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Sidebar -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-blue-500/10 to-indigo-500/10 border border-blue-500/20 rounded-3xl p-8 shadow-inner overflow-hidden relative">
                    <div class="absolute -right-8 -top-8 opacity-5">
                         <i data-lucide="user" class="w-40 h-40"></i>
                    </div>
                    
                    <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-[0.2em] mb-8">Metadata Pengguna</h4>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 bg-blue-500/20 rounded-[2.5rem] border border-blue-500/30 flex items-center justify-center text-blue-400 mb-6 shadow-2xl shadow-blue-500/10">
                            <i data-lucide="user" class="w-12 h-12"></i>
                        </div>
                        <p class="text-xs font-black text-white uppercase tracking-widest mb-1">{{ $user->name }}</p>
                        <p class="text-[10px] text-slate-500 font-mono mb-4 uppercase tracking-tighter">{{ $user->role }}</p>
                        <hr class="w-1/2 border-slate-700/50 mb-4">
                        <p class="text-[9px] text-slate-600 italic">ID Pengguna: {{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="bg-slate-800/10 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Informasi Keamanan</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Password</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-400 font-black">AKTIF</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase">Terakhir Diperbarui</span>
                            <span class="text-[10px] font-mono text-slate-600">{{ $user->updated_at->format('d/m/y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
