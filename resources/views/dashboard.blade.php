@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Stat Card 1 -->
    <div class="p-5 bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] hover:shadow-xl hover:shadow-[#D2A039]/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-xl flex items-center justify-center text-[#D2A039] group-hover:bg-[#D2A039]/20 transition-all">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
            <span class="text-[9px] font-black text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/10 uppercase tracking-widest">+12%</span>
        </div>
        <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Total Pengguna</h3>
        <p class="text-2xl font-black text-white tracking-tighter">{{ number_format($userCount) }}</p>
    </div>

    <!-- Stat Card 2 -->
    <div class="p-5 bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-all">
                <i data-lucide="building-2" class="w-5 h-5"></i>
            </div>
            <span class="text-[9px] font-black text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-full border border-emerald-500/10 uppercase tracking-widest">+5%</span>
        </div>
        <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Cabang Aktif</h3>
        <p class="text-2xl font-black text-white tracking-tighter">{{ number_format($cabangCount) }}</p>
    </div>

    <!-- Stat Card 3 -->
    <div class="p-5 bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] hover:shadow-xl hover:shadow-rose-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 bg-rose-500/10 border border-rose-500/10 rounded-xl flex items-center justify-center text-rose-400 group-hover:bg-rose-500/20 transition-all">
                <i data-lucide="shield-alert" class="w-5 h-5"></i>
            </div>
            <span class="text-[9px] font-black text-rose-400 bg-rose-500/10 px-2 py-0.5 rounded-full border border-rose-500/10 uppercase tracking-widest">-3%</span>
        </div>
        <h3 class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Resiko Aktif</h3>
        <p class="text-2xl font-black text-white tracking-tighter">{{ number_format($resikoCount) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Recent Activity -->
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[1.5rem] p-5 overflow-hidden shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Aktivitas Terbaru</h3>
            <button class="text-[10px] font-black text-[#D2A039] hover:text-[#f9d77e] uppercase tracking-widest">Lihat Semua</button>
        </div>
        <div class="space-y-3">
            @foreach(['Tingkat Resiko Diperbarui #2', 'Cabang Baru Ditambahkan: Bandung', 'Resiko Diselesaikan: Server #4'] as $activity)
            <div class="flex items-start group">
                <div class="w-1.5 h-1.5 mt-1.5 rounded-full bg-[#D2A039] mr-3 group-hover:scale-150 transition-all shadow-[0_0_6px_rgba(210,160,57,0.6)]"></div>
                <div>
                    <p class="text-xs font-bold text-slate-200 group-hover:text-white transition-colors">{{ $activity }}</p>
                    <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mt-0.5">2 jam yang lalu</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats Visualization -->
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[1.5rem] p-5 shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Matriks Analitik</h3>
            <i data-lucide="trending-up" class="w-4 h-4 text-[#D2A039]"></i>
        </div>
        <div class="h-24 flex items-end justify-between space-x-2 px-1">
            @for ($i = 0; $i < 7; $i++)
                <div class="w-full bg-[#D2A039]/10 rounded-lg transition-all duration-500 hover:bg-[#D2A039]/30 hover:shadow-[0_0_10px_rgba(210,160,57,0.3)] cursor-pointer group relative" style="height: {{ rand(30, 95) }}%">
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-[#061B30] border border-[#D2A039]/50 text-[9px] font-bold text-[#D2A039] px-1.5 py-0.5 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ rand(10, 99) }}%
                    </div>
                </div>
            @endfor
        </div>
        <div class="flex justify-between mt-3 px-1 text-[9px] font-black text-slate-600 uppercase tracking-[0.15em]">
            <span>Sen</span>
            <span>Sel</span>
            <span>Rab</span>
            <span>Kam</span>
            <span>Jum</span>
            <span>Sab</span>
            <span>Min</span>
        </div>
    </div>
</div>
@endsection
