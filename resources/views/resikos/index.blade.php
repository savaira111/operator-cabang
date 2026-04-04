@extends('layouts.app')

@section('title', 'Management Resiko')
@section('page_title', 'Management Resiko')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter">Daftar Resiko</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola dan pantau tingkat resiko operasional di tiap cabang.</p>
    </div>
    <a href="{{ route('resikos.create') }}" class="px-6 py-3 bg-rose-500 text-white font-bold rounded-2xl flex items-center hover:bg-rose-600 transition-all duration-300 shadow-xl shadow-rose-500/30 active:scale-95">
        <i data-lucide="shield-alert" class="w-5 h-5 mr-2"></i>
        Identifikasi Resiko
    </a>
</div>

<div class="mb-8 relative group max-w-md">
    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-rose-400 transition-colors"></i>
    </div>
    <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 block pl-14 p-4 transition-all" placeholder="Cari resiko atau cabang...">
</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        if (row.querySelector('td[colspan]')) return;
        const text = row.innerText.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = "";
            row.classList.add('animate-in', 'fade-in', 'duration-300');
        } else {
            row.style.display = "none";
        }
    });
}
</script>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800/60">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nama Resiko</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status Tingkat</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang Terkait</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @foreach($resikos as $resiko)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-8 py-5">
                        <span class="font-bold text-white tracking-tight group-hover:text-rose-400 transition-colors uppercase text-sm">
                            {{ $resiko->name }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        @php
                            $badgeColor = match($resiko->status) {
                                'low' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                'medium' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                'high' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                default => 'bg-slate-800 text-slate-500 border-slate-700'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border {{ $badgeColor }}">
                            {{ $resiko->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center text-slate-400 font-bold text-xs uppercase tracking-tighter">
                            <i data-lucide="building-2" class="w-3.5 h-3.5 mr-2 text-slate-600"></i>
                            {{ $resiko->cabang->name ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end space-x-2 transition-all">
                            <a href="{{ route('resikos.edit', $resiko) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-2xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('resikos.destroy', $resiko) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-2xl transition-all" onclick="confirmDelete(event, this.form)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
