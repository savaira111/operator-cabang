@extends('layouts.app')

@section('title', 'LPI Tambahan')
@section('page_title', 'Laporan LPI Tambahan')

@section('content')
<div class="mb-10 flex items-start justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">LPI TAMBAHAN</h3>
        <p class="text-slate-500 text-sm mt-1">Data laporan pengendalian internal tambahan per cabang.</p>
    </div>
    <a href="{{ route('laporan-pengendalian.create') }}" class="flex items-center px-6 py-4 bg-[#D2A039] hover:bg-[#b88a2e] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 shadow-xl shadow-[#D2A039]/20 uppercase tracking-widest text-[10px]">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        Tambah Laporan Baru
    </a>
</div>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800">
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang / Satker</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Nama Laporan</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Progres</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($laporans as $laporan)
                <tr class="hover:bg-slate-800/20 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-white">{{ $laporan->cabang->name }}</span>
                                <span class="text-[10px] text-slate-500 uppercase font-black">{{ $laporan->cabang->kode_cabang ?? 'KODE N/A' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="text-sm font-medium text-slate-300">{{ $laporan->nama_laporan }}</span>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-black border border-slate-700 uppercase tracking-tighter">
                            {{ $laporan->periode_bulan }} {{ $laporan->periode_tahun }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        @if($laporan->status_evaluasi == 'sesuai')
                            <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase">Sesuai</span>
                        @elseif($laporan->status_evaluasi == 'menunggu')
                            <span class="px-3 py-1.5 bg-amber-500/10 text-amber-400 text-[9px] font-black rounded-lg border border-amber-500/20 uppercase">Menunggu</span>
                        @elseif($laporan->status_evaluasi == 'tidak_sesuai')
                            <span class="px-3 py-1.5 bg-rose-500/10 text-rose-400 text-[9px] font-black rounded-lg border border-rose-500/20 uppercase">Tidak Sesuai</span>
                        @else
                            <span class="px-3 py-1.5 bg-slate-700/30 text-slate-500 text-[9px] font-black rounded-lg border border-slate-700/50 uppercase">Belum Dicek</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-16 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500" style="width: {{ $laporan->prosentase }}%"></div>
                            </div>
                            <span class="text-xs font-black text-indigo-400">{{ $laporan->prosentase }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center space-x-2">
                            @if($laporan->file_path)
                            <a href="{{ asset($laporan->file_path) }}" target="_blank" class="p-2.5 bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white rounded-xl transition-all border border-blue-500/20" title="Download">
                                <i data-lucide="download" class="w-4 h-4"></i>
                            </a>
                            @endif
                            <a href="{{ route('laporan-pengendalian.edit', $laporan) }}" class="p-2.5 bg-amber-500/10 text-amber-400 hover:bg-amber-500 hover:text-white rounded-xl transition-all border border-amber-500/20" title="Edit / Penilaian">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('laporan-pengendalian.destroy', $laporan) }}" method="POST" class="inline-block" onsubmit="return confirmHapus(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white rounded-xl transition-all border border-rose-500/20" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-600 italic text-sm">Belum ada data laporan LPI tambahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
