@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page_title', 'Management Pengguna')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter">Daftar Pengguna</h3>
        <p class="text-slate-500 text-sm mt-1">Kelola akses dan otoritas akun dalam sistem.</p>
    </div>
    <a href="{{ route('users.create') }}" class="px-6 py-3 bg-indigo-500 text-white font-bold rounded-2xl flex items-center hover:bg-indigo-600 transition-all duration-300 shadow-xl shadow-indigo-500/30 active:scale-95">
        <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
        Tambah Pengguna
    </a>
</div>

<div class="mb-8 relative group max-w-md">
    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors"></i>
    </div>
    <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 block pl-14 p-4 transition-all" placeholder="Cari pengguna...">
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
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">No</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Username</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nama Lengkap</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Role Akses</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @forelse($users as $user)
                <tr class="hover:bg-slate-800/30 transition-all group">
                    <td class="px-8 py-5">
                        <span class="text-xs font-mono font-bold text-slate-600 group-hover:text-indigo-400">
                            {{ $loop->iteration }}
                        </span>
                    </td>
                    <td class="px-8 py-5">
                        <div class="flex items-center">
                            <span class="text-indigo-500 font-black mr-2">@</span>
                            <span class="text-sm font-bold text-white tracking-tight">{{ $user->username }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-5 text-sm font-semibold text-slate-400 group-hover:text-slate-200 transition-colors">{{ $user->name }}</td>
                    <td class="px-8 py-5">
                        <span class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-[10px] font-black text-slate-300 uppercase tracking-tighter whitespace-nowrap">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-slate-500 text-sm font-medium">
                        <div class="flex items-center">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-2 text-slate-700"></i>
                            {{ $user->cabang->name ?? ($user->cabang_id ? 'ID: ' . $user->cabang_id : '-') }}
                        </div>
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex items-center justify-end space-x-2 transition-all">
                            <a href="{{ route('users.show', $user) }}" class="p-2.5 text-slate-500 hover:text-indigo-400 hover:bg-indigo-400/10 rounded-2xl transition-all">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-2xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-2xl transition-all" onclick="confirmHapus(event, this.form)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="p-5 bg-slate-800/30 rounded-full mb-4">
                                <i data-lucide="user-x" class="w-10 h-10 text-slate-700"></i>
                            </div>
                            <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada data pengguna</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
