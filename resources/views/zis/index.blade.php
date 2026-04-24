@extends('layouts.app')

@section('title', 'Zona Integritas Management')
@section('page_title', 'Zona Integritas')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Zona Integritas</h3>
        <p class="text-slate-500 text-sm mt-1">Management progres Wilayah Bebas dari Korupsi (WBK) & Wilayah Birokrasi Bersih dan Melayani (WBBM).</p>
    </div>
    <a href="{{ route('zis.create') }}" class="px-6 py-3 bg-[#D2A039] text-[#061B30] font-black uppercase text-[10px] tracking-widest rounded-2xl flex items-center hover:bg-[#b88a2e] transition-all duration-300 shadow-xl shadow-[#D2A039]/20 active:scale-95">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        Tambah Progres ZI
    </a>
</div>

<div class="mb-8 relative group max-w-md">
    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-[#D2A039] transition-colors"></i>
    </div>
    <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#031121] border border-[#D2A039]/20 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block pl-14 p-4 transition-all" placeholder="Cari predikat, tahun atau cabang...">
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

<div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#D2A039]/5 border-b border-[#D2A039]/10">
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest whitespace-nowrap">No</th>
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Kantor Cabang / Satker</th>
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Predikat</th>
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Tahun</th>
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-right whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#D2A039]/10">
                @forelse($zis as $zi)
                <tr class="hover:bg-[#D2A039]/5 transition-all group">
                    <td class="px-6 py-5 whitespace-nowrap">
                        <span class="text-[10px] font-mono font-bold text-slate-600 group-hover:text-[#D2A039]">
                            {{ $loop->iteration }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center">
                            <div class="w-9 h-9 rounded-xl flex-shrink-0 bg-[#D2A039]/10 flex items-center justify-center text-[#D2A039] mr-4 border border-[#D2A039]/20">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="font-black text-[11px] text-slate-200 tracking-widest uppercase block leading-none">{{ $zi->cabang->name }}</span>
                                <span class="text-[9px] text-slate-500 font-bold uppercase tracking-tight mt-1 inline-block">{{ $zi->cabang->kode_cabang }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1.5 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-widest">
                            {{ $zi->predikat }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center">
                            <span class="text-[13px] font-bold text-slate-300">{{ $zi->tahun }}</span>
                            @if($zi->bulan)
                            <span class="ml-2 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest bg-slate-800 text-slate-400">
                                {{ $zi->bulan }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $zi->status == 'Selesai' ? 'bg-emerald-500/10 text-emerald-500 border border-emerald-500/20' : 'bg-[#D2A039]/10 text-[#D2A039] border border-[#D2A039]/20' }}">
                            <span class="w-1 h-1 rounded-full mr-1.5 {{ $zi->status == 'Selesai' ? 'bg-emerald-500' : 'bg-[#D2A039]' }}"></span>
                            {{ $zi->status }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-2 transition-all opacity-0 group-hover:opacity-100">
                            <a href="{{ route('zis.show', $zi) }}" class="p-2.5 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all border border-transparent hover:border-blue-400/20" title="Kelola LKE Soal">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                            <a href="{{ route('zis.edit', $zi) }}" class="p-2.5 text-slate-500 hover:text-[#D2A039] hover:bg-[#D2A039]/10 rounded-xl transition-all border border-transparent hover:border-[#D2A039]/20" title="Edit ZI">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('zis.destroy', $zi) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all border border-transparent hover:border-rose-400/20" onclick="confirmHapus(event, this.form)" title="Hapus ZI">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-slate-800/10 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="database-zap" class="w-8 h-8 text-slate-700"></i>
                            </div>
                            <p class="text-slate-500 font-bold uppercase text-[10px] tracking-widest">Belum ada data progres Zona Integritas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
