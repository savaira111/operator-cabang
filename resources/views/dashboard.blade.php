@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stat Card 1: Users -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-[#D2A039]/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-2xl flex items-center justify-center text-[#D2A039] group-hover:bg-[#D2A039]/20 transition-all">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">Active</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Total Pengguna</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($userCount) }}</p>
    </div>

    <!-- Stat Card 2: Branches -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-500/10 border border-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500/20 transition-all">
                <i data-lucide="building-2" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">Verified</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Cabang Aktif</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($cabangCount) }}</p>
    </div>

    <!-- Stat Card 3: LPI -->
    @if(auth()->user()?->role !== 'operator cabang')
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-rose-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-rose-500/10 border border-rose-500/10 rounded-2xl flex items-center justify-center text-rose-400 group-hover:bg-rose-500/20 transition-all">
                <i data-lucide="shield-alert" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-rose-400 bg-rose-500/10 px-3 py-1 rounded-full border border-rose-500/10 uppercase tracking-widest">In-Progress</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Pengendalian Aktif</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($resikoCount) }}</p>
    </div>
    @endif

    <!-- Stat Card 4: Tahanan -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-indigo-500/10 border border-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 group-hover:bg-indigo-500/20 transition-all">
                <i data-lucide="user-minus" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-indigo-400 bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/10 uppercase tracking-widest">Registered</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Data Tahanan</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($tahananCount) }}</p>
    </div>

    <!-- Stat Card 5: ZI -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 group-hover:bg-amber-500/20 transition-all">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-amber-500/10 uppercase tracking-widest">Monitoring</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Zona Integritas</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($ziCount) }}</p>
    </div>

    <!-- Stat Card 6: Anggaran -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-cyan-500/10 border border-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500/20 transition-all">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-cyan-400 bg-cyan-500/10 px-3 py-1 rounded-full border border-cyan-500/10 uppercase tracking-widest">Realisasi</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Penyerapan Anggaran</h3>
        <p class="text-xl font-black text-white tracking-tighter">Rp {{ number_format($anggaranTotal, 0, ',', '.') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Analytical Matrix: General Activity -->
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-[#D2A039]/5 blur-3xl -mr-16 -mt-16 rounded-full"></div>
        <div class="flex items-center justify-between mb-8 relative z-10">
            <div>
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Statistik Aktivitas</h3>
                <h2 class="text-lg font-bold text-white">Matriks Analitik</h2>
            </div>
            <div class="w-10 h-10 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-xl flex items-center justify-center text-[#D2A039]">
                <i data-lucide="trending-up" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="h-40 flex items-end justify-between space-x-3 px-2 relative z-10">
            @php $days = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']; @endphp
            @foreach($days as $day)
                @php $h = rand(30, 95); @endphp
                <div class="w-full flex flex-col items-center group/bar">
                    <div class="w-full bg-slate-800/50 rounded-2xl transition-all duration-700 hover:shadow-[0_0_20px_rgba(210,160,57,0.3)] cursor-pointer relative overflow-hidden h-40 flex items-end">
                        <div class="w-full bg-gradient-to-t from-[#D2A039] to-[#f9d77e] opacity-20 group-hover/bar:opacity-100 transition-all duration-700 rounded-t-xl" style="height: {{ $h }}%"></div>
                        <!-- Tooltip -->
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#061B30] border border-[#D2A039]/50 text-[10px] font-black text-[#D2A039] px-2 py-1 rounded-lg opacity-0 group-hover/bar:opacity-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl">
                            {{ rand(40, 99) }}% Data
                        </div>
                    </div>
                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest mt-4 group-hover/bar:text-[#D2A039] transition-colors">{{ $day }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Analytical Matrix: ZI Progress -->
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 blur-3xl -mr-16 -mt-16 rounded-full"></div>
        <div class="flex items-center justify-between mb-8 relative z-10">
            <div>
                <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Monitoring Bulanan</h3>
                <h2 class="text-lg font-bold text-white">Progres Zona Integritas</h2>
            </div>
            <div class="w-10 h-10 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center justify-center text-emerald-400">
                <i data-lucide="bar-chart" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="h-40 flex items-end justify-between space-x-3 px-2 relative z-10">
            @php $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul']; @endphp
            @foreach($months as $month)
                @php $h = rand(40, 90); @endphp
                <div class="w-full flex flex-col items-center group/bar">
                    <div class="w-full bg-slate-800/50 rounded-2xl transition-all duration-700 hover:shadow-[0_0_20px_rgba(16,185,129,0.3)] cursor-pointer relative overflow-hidden h-40 flex items-end">
                        <div class="w-full bg-gradient-to-t from-emerald-500 to-emerald-300 opacity-20 group-hover/bar:opacity-100 transition-all duration-700 rounded-t-xl" style="height: {{ $h }}%"></div>
                        <!-- Tooltip -->
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#061B30] border border-emerald-500/50 text-[10px] font-black text-emerald-400 px-2 py-1 rounded-lg opacity-0 group-hover/bar:opacity-100 transition-all duration-300 pointer-events-none whitespace-nowrap shadow-2xl">
                            {{ $h }}% Completed
                        </div>
                    </div>
                    <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest mt-4 group-hover/bar:text-emerald-400 transition-colors">{{ $month }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
