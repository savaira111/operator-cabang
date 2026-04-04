@extends('layouts.app')

@section('title', 'Cabang Management')
@section('page_title', 'Management Cabang')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter">Daftar Cabang</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola data seluruh kantor cabang operasional.</p>
    </div>
    <a href="{{ route('cabangs.create') }}" class="px-6 py-3 bg-indigo-500 text-white font-bold rounded-2xl flex items-center hover:bg-indigo-600 transition-all duration-300 shadow-xl shadow-indigo-500/30 active:scale-95">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        Tambah Cabang
    </a>
</div>

<div class="mb-8 relative group max-w-md">
    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors"></i>
    </div>
    <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 block pl-14 p-4 transition-all" placeholder="Cari cabang atau kepala cabang...">
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
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">ID</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nama Cabang</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Kepala Cabang</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Wilayah</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Alamat</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @foreach($cabangs as $cabang)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-8 py-5">
                        <span class="text-xs font-mono font-bold text-slate-600 group-hover:text-indigo-400">
                            {{ str_pad($cabang->id, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 mr-4 border border-blue-500/10">
                                <i data-lucide="building-2" class="w-5 h-5"></i>
                            </div>
                            <span class="font-bold text-white tracking-tight">{{ $cabang->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <span class="text-sm font-bold text-slate-300">{{ $cabang->kepala_cabang ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-sm font-semibold text-slate-400">{{ $cabang->location }}</span>
                    </td>
                    <td class="px-8 py-5">
                        <span class="text-sm text-slate-500 truncate max-w-xs block">{{ $cabang->alamat ?? '-' }}</span>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end space-x-2 transition-all">
                            <a href="{{ route('cabangs.edit', $cabang) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-2xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('cabangs.destroy', $cabang) }}" method="POST" class="inline">
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
