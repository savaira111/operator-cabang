@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Overview Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
    <!-- Stat Card 1 -->
    <div class="p-8 bg-[#111827] border border-slate-800 rounded-[2.5rem] hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-blue-500/10 border border-blue-500/10 rounded-2xl flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 transition-all">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">+12%</span>
        </div>
        <h3 class="text-slate-500 text-xs font-black uppercase tracking-[0.2em] mb-2">Total Users</h3>
        <p class="text-4xl font-black text-white tracking-tighter">1,284</p>
    </div>

    <!-- Stat Card 2 -->
    <div class="p-8 bg-[#111827] border border-slate-800 rounded-[2.5rem] hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-purple-500/10 border border-purple-500/10 rounded-2xl flex items-center justify-center text-purple-400 group-hover:bg-purple-500/20 transition-all">
                <i data-lucide="building-2" class="w-7 h-7"></i>
            </div>
            <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/10 uppercase tracking-widest">+5%</span>
        </div>
        <h3 class="text-slate-500 text-xs font-black uppercase tracking-[0.2em] mb-2">Active Branches</h3>
        <p class="text-4xl font-black text-white tracking-tighter">42</p>
    </div>

    <!-- Stat Card 3 -->
    <div class="p-8 bg-[#111827] border border-slate-800 rounded-[2.5rem] hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-rose-500/10 border border-rose-500/10 rounded-2xl flex items-center justify-center text-rose-400 group-hover:bg-rose-500/20 transition-all">
                <i data-lucide="shield-alert" class="w-7 h-7"></i>
            </div>
            <span class="text-[10px] font-black text-rose-400 bg-rose-500/10 px-3 py-1 rounded-full border border-rose-500/10 uppercase tracking-widest">-3%</span>
        </div>
        <h3 class="text-slate-500 text-xs font-black uppercase tracking-[0.2em] mb-2">Active Risks</h3>
        <p class="text-4xl font-black text-white tracking-tighter">18</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    <!-- Recent Activity -->
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 overflow-hidden shadow-xl">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Recent Activity</h3>
            <button class="text-xs font-black text-indigo-400 hover:text-indigo-300 uppercase tracking-widest">Explore All</button>
        </div>
        <div class="space-y-8">
            @foreach(['Updated Risk Level #2', 'New Branch Added: Bandung', 'Risk Resolved: Server #4'] as $activity)
            <div class="flex items-start group">
                <div class="w-1.5 h-1.5 mt-2 rounded-full bg-indigo-500 mr-5 group-hover:scale-150 transition-all shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
                <div>
                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">{{ $activity }}</p>
                    <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-1.5">2 hours ago</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats Visualization -->
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
        <div class="flex items-center justify-between mb-10">
            <h3 class="text-lg font-bold text-white uppercase tracking-wider">Analytics Matrix</h3>
            <i data-lucide="trending-up" class="w-5 h-5 text-indigo-500"></i>
        </div>
        <div class="h-44 flex items-end justify-between space-x-3 px-2">
            @for ($i = 0; $i < 7; $i++)
                <div class="w-full bg-slate-800/50 rounded-xl transition-all duration-500 hover:bg-indigo-500/50 hover:shadow-[0_0_15px_rgba(99,102,241,0.3)] cursor-pointer group relative" style="height: {{ rand(30, 95) }}%">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-[10px] font-bold text-white px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ rand(10, 99) }}%
                    </div>
                </div>
            @endfor
        </div>
        <div class="flex justify-between mt-6 px-2 text-[10px] font-black text-slate-600 uppercase tracking-[0.2em]">
            <span>Mon</span>
            <span>Tue</span>
            <span>Wed</span>
            <span>Thu</span>
            <span>Fri</span>
            <span>Sat</span>
            <span>Sun</span>
        </div>
    </div>
</div>
@endsection
