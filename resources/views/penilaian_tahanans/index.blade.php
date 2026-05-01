@extends('layouts.app')

@section('title', 'Penilaian Data Tahanan')
@section('page_title', 'Penilaian Data Tahanan')

@section('content')
<div class="mb-10 flex items-start justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">PENILAIAN TAHANAN</h3>
        <p class="text-slate-500 text-sm mt-1">Evaluasi dan verifikasi laporan data tahanan dari cabang.</p>
    </div>
</div>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800">
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Data Dukung</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Progres</th>
                    <th class="px-6 py-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($tahanans as $tahanan)
                <tr class="hover:bg-slate-800/20 transition-colors group">
                    <td class="px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                                <i data-lucide="building" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm font-bold text-white">{{ $tahanan->cabang->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-slate-800 text-slate-400 rounded-lg text-[10px] font-black border border-slate-700 uppercase tracking-tighter">
                            {{ $tahanan->periode_bulan }} {{ $tahanan->periode_tahun }}
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        @if($tahanan->file_path)
                            <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="text-blue-400 hover:text-blue-300 text-xs font-bold flex items-center">
                                <i data-lucide="file-text" class="w-3.5 h-3.5 mr-1.5"></i>
                                Lihat Laporan
                            </a>
                        @else
                            <span class="text-slate-600 text-[10px] italic">Tidak ada file</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        @if($tahanan->status_evaluasi == 'sesuai')
                            <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-400 text-[9px] font-black rounded-lg border border-emerald-500/20 uppercase">Sesuai</span>
                        @elseif($tahanan->status_evaluasi == 'menunggu')
                            <span class="px-3 py-1.5 bg-amber-500/10 text-amber-400 text-[9px] font-black rounded-lg border border-amber-500/20 uppercase">Menunggu</span>
                        @elseif($tahanan->status_evaluasi == 'tidak_sesuai')
                            <span class="px-3 py-1.5 bg-rose-500/10 text-rose-400 text-[9px] font-black rounded-lg border border-rose-500/20 uppercase">Tidak Sesuai</span>
                        @else
                            <span class="px-3 py-1.5 bg-slate-700/30 text-slate-500 text-[9px] font-black rounded-lg border border-slate-700/50 uppercase">Belum Dievaluasi</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <div class="w-16 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500" style="width: {{ $tahanan->prosentase }}%"></div>
                            </div>
                            <span class="text-xs font-black text-indigo-400">{{ $tahanan->prosentase }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center">
                            <a href="{{ route('penilaian-tahanan.edit', $tahanan) }}" class="p-3 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg active:scale-90" title="Berikan Penilaian">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-600 italic text-sm">Belum ada data laporan tahanan untuk dinilai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
