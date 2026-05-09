@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Ringkasan Dashboard')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-black text-white tracking-tight">Dashboard Overview</h1>
        <p class="text-slate-500 text-sm mt-1">Pantau performa dan progres sistem secara real-time.</p>
    </div>
    
    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-3">
        <div class="relative group">
            <select name="tahun" onchange="this.form.submit()" class="pl-12 pr-10 py-3 bg-[#031121] border border-[#D2A039]/20 text-white text-sm font-black rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] transition-all cursor-pointer appearance-none">
                @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                @endfor
            </select>
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i data-lucide="calendar" class="w-5 h-5 text-[#D2A039]"></i>
            </div>
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-500"></i>
            </div>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stat Card 1: LPI Terhitung -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 transition-all">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-blue-400 bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/10 uppercase tracking-widest">Evaluated</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">LPI Terhitung</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($lpiApprovedCount) }}</p>
    </div>

    <!-- Stat Card 2: Total LPI -->
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-500/10 border border-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 group-hover:bg-purple-500/20 transition-all">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-purple-400 bg-purple-500/10 px-3 py-1 rounded-full border border-purple-500/10 uppercase tracking-widest">Total Data</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Total LPI Dibuat</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($totalLpiCount) }}</p>
    </div>

    <!-- Stat Card 3: Tahanan -->
    @if(auth()->user()?->hasPermission('tahanan_management'))
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
    @endif

    <!-- Stat Card 4: ZI -->
    @if(auth()->user()?->hasPermission('zi_manajemen_data') || auth()->user()?->hasPermission('zi_input_data'))
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 group-hover:bg-amber-500/20 transition-all">
                <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-amber-400 bg-amber-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">Monitoring</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Monitoring ZI</h3>
        <p class="text-3xl font-black text-white tracking-tighter">{{ number_format($ziCount) }}</p>
    </div>
    @endif

    <!-- Stat Card 5: Anggaran -->
    @if(auth()->user()?->hasPermission('belanja_management'))
    <div class="p-6 bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] hover:shadow-xl hover:shadow-cyan-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-cyan-500/10 border border-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-400 group-hover:bg-cyan-500/20 transition-all">
                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
            </div>
            <span class="text-[10px] font-black text-cyan-400 bg-cyan-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">Realisasi</span>
        </div>
        <h3 class="text-slate-500 text-[11px] font-black uppercase tracking-[0.2em] mb-1">Anggaran Terhitung</h3>
        <p class="text-xl font-black text-white tracking-tighter">Rp {{ number_format($anggaranEvaluatedTotal, 0, ',', '.') }}</p>
    </div>
    @endif
</div>

<div class="grid grid-cols-1 gap-6">
    <!-- Analytical Matrix: Progress Comparison -->
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] p-8 shadow-xl relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 blur-3xl -mr-32 -mt-32 rounded-full"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 relative z-10 gap-4">
            <div>
                <h2 class="text-xl font-black text-white tracking-tight">Analitik Performa Sistem</h2>
                <p class="text-slate-500 text-xs mt-1">Perbandingan progres penyelesaian LPI dan ZI per periode.</p>
                
                <div class="flex items-center gap-6 mt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-slate-700"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progres LPI</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Progres ZI</span>
                    </div>
                </div>
            </div>
            
            <div class="w-12 h-12 bg-blue-500/10 border border-blue-500/20 rounded-2xl flex items-center justify-center text-blue-400">
                <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="relative h-64 flex items-end justify-between px-4 pb-2 border-b border-slate-800/50">
            <!-- Y-Axis Labels -->
            <div class="absolute left-0 top-0 bottom-0 flex flex-col justify-between text-[9px] font-black text-slate-600 pr-4">
                <span>100%</span>
                <span>75%</span>
                <span>50%</span>
                <span>25%</span>
                <span>0%</span>
            </div>

            <!-- Grid Lines -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none pb-2">
                <div class="w-full border-t border-slate-800/30"></div>
                <div class="w-full border-t border-slate-800/30"></div>
                <div class="w-full border-t border-slate-800/30"></div>
                <div class="w-full border-t border-slate-800/30"></div>
            </div>

            <!-- Chart Bars -->
            <div class="flex-1 flex items-end justify-around ml-8 h-full relative z-10">
                @foreach($chartData as $period => $data)
                    <div class="flex flex-col items-center group/bar w-full">
                        <div class="flex items-end gap-1.5 mb-2 h-48">
                            <!-- LPI Bar (Grey) -->
                            <div class="w-4 bg-slate-700/50 rounded-t-lg transition-all duration-700 group-hover/bar:bg-slate-600 relative" style="height: {{ max($data['lpi'], 5) }}%">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[9px] font-black text-white px-1.5 py-0.5 rounded opacity-0 group-hover/bar:opacity-100 transition-opacity whitespace-nowrap">{{ $data['lpi'] }}%</div>
                            </div>
                            <!-- ZI Bar (Blue) -->
                            <div class="w-4 bg-gradient-to-t from-blue-600 to-blue-400 rounded-t-lg transition-all duration-700 shadow-[0_0_15px_rgba(59,130,246,0.2)] group-hover/bar:shadow-[0_0_20px_rgba(59,130,246,0.4)] relative" style="height: {{ max($data['zi'], 5) }}%">
                                <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-blue-600 text-[9px] font-black text-white px-1.5 py-0.5 rounded opacity-0 group-hover/bar:opacity-100 transition-opacity whitespace-nowrap">{{ $data['zi'] }}%</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-2 group-hover/bar:text-blue-400 transition-colors">{{ $period }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
