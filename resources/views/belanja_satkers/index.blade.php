@extends('layouts.app')

@section('title', 'Penyerapan Anggaran')
@section('page_title', 'Penyerapan Anggaran')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Penyerapan Anggaran</h3>
        <p class="text-slate-500 text-sm mt-1">Data realisasi penyerapan anggaran masing-masing cabang / satker.</p>
    </div>
    <a href="{{ route('belanja-satker.create') }}" class="px-6 py-3 bg-[#D2A039] text-[#061B30] font-bold rounded-2xl flex items-center hover:bg-[#b88a2e] transition-all duration-300 shadow-xl shadow-[#D2A039]/20 active:scale-95">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        Tambah Data
    </a>
</div>

<div class="mb-8 relative group max-w-md">
    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-[#D2A039] transition-colors"></i>
    </div>
    <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#031121] border border-[#D2A039]/20 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block pl-14 p-4 transition-all" placeholder="Cari nama satker atau kode...">
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

<div class="bg-[#031121] border border-[#D2A039]/20 rounded-[1.5rem] overflow-hidden shadow-xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-black/20 border-b border-[#D2A039]/10">
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest whitespace-nowrap">No</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Kode | Nama Satker</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Periode</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Keterangan</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Total</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center">Dokumen</th>
                    <th class="px-4 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#D2A039]/10">
                @forelse($belanjas as $belanja)
                <tr class="hover:bg-white/5 transition-all group">
                    <td class="px-4 py-4 whitespace-nowrap">
                        <span class="text-[11px] font-mono font-bold text-slate-600 group-hover:text-[#D2A039]">
                            {{ $loop->iteration }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center">
                            <span class="font-bold text-[13px] text-white tracking-tight leading-snug">{{ $belanja->cabang->kode_cabang ?? '-' }} | {{ $belanja->cabang->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <span class="text-[13px] font-semibold text-slate-300">{{ $belanja->bulan }} {{ $belanja->tahun }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <span class="text-[12px] text-slate-400">{{ $belanja->keterangan ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 text-right">
                        <span class="text-[13px] font-black text-[#D2A039]">Rp {{ number_format($belanja->total, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-4 py-4 text-center">
                        @if($belanja->dokumen_path)
                            <a href="{{ asset('storage/' . $belanja->dokumen_path) }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-[#D2A039]/10 text-[#D2A039] hover:bg-[#D2A039] hover:text-[#061B30] rounded-xl transition-all" title="Lihat Dokumen">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                            </a>
                        @else
                            <span class="text-[10px] text-slate-600 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end space-x-1.5 transition-all">
                            <a href="{{ route('belanja-satker.edit', $belanja) }}" class="p-2 text-slate-500 hover:text-blue-400 hover:bg-blue-400/10 rounded-xl transition-all">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('belanja-satker.destroy', $belanja) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-500 text-sm">Belum ada data penyerapan anggaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
