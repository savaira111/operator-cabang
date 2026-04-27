@extends('layouts.app')

@section('title', 'Penilaian Zona Integritas')
@section('page_title', 'Penilaian Zona Integritas')

@section('content')
<div class="mb-8">
    <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Penilaian Zona Integritas</h3>
    <p class="text-slate-500 text-sm mt-1 tracking-tight">Kelola capaian dan data dukung rencana aksi Zona Integritas.</p>
</div>

<div class="animate-in fade-in slide-in-from-bottom-4 duration-700 ease-out fill-mode-both">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div class="relative group w-full max-w-md">
        <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
            <i data-lucide="search" class="w-5 h-5 text-slate-500 group-focus-within:text-blue-400 transition-colors"></i>
        </div>
        <input type="text" id="searchInput" onkeyup="filterTable()" class="w-full bg-[#111827] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 block pl-14 p-4 transition-all shadow-inner" placeholder="Cari indikator output atau sasaran...">
    </div>

    <div class="flex items-center space-x-3 w-full sm:w-auto">
        <a href="{{ route('zi-monitoring.create') }}" class="flex-1 sm:flex-none px-6 py-4 bg-blue-500 text-white font-bold rounded-2xl flex items-center justify-center hover:bg-blue-600 transition-all duration-300 shadow-xl shadow-blue-500/30 active:scale-95 group">
            <i data-lucide="plus-circle" class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform"></i>
            Create New
        </a>
    </div>
</div>

<div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl relative">
    <div class="overflow-x-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
        <style>
            .overflow-x-auto::-webkit-scrollbar {
                display: none;
            }
        </style>
        <table class="w-full text-left border-collapse min-w-[2000px]">
            <thead>
                <tr class="bg-slate-800/40 border-b border-slate-800/60 backdrop-blur-md sticky top-0 z-10">
                    <th class="px-4 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center border-r border-slate-800/60">No</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Sasaran / Kegiatan Utama</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Indikator</th>
                    <th class="px-4 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center border-r border-slate-800/60">Target</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Outcome</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Indikator Output (IO)</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Indikator Output</th>
                    <th class="px-4 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-center border-r border-slate-800/60">Target</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Waktu</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Anggaran</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Penanggung Jawab</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Data Dukung</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60 text-center">%</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-r border-slate-800/60">Catatan</th>
                    <th class="px-6 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/40">
                @foreach($monitorings as $item)
                    {{-- Row Sasaran Indikatif (SS2) --}}
                    @if($item->tipe == 'SS2')
                        <tr class="bg-blue-500/10 hover:bg-blue-500/15 transition-colors group">
                            <td class="px-4 py-4 text-xs font-black text-blue-400 text-center border-r border-slate-800/60">{{ $item->nomor }}</td>
                            <td colspan="13" class="px-6 py-4 text-xs font-black text-blue-300 tracking-tight">{{ $item->sasaran_kegiatan }}</td>
                            <td class="px-6 py-4 text-right">
                                 <a href="{{ route('zi-monitoring.edit', $item) }}" class="p-2 text-slate-500 hover:text-blue-400 transition-all"><i data-lucide="edit-3" class="w-4 h-4"></i></a>
                            </td>
                        </tr>
                    @endif

                    {{-- Recursive display for children if this is a root node --}}
                    @foreach($item->children as $child)
                        @php $grandChildren = collect([$child]); @endphp

                        @foreach($grandChildren as $k)
                            @if($k->tipe == 'K')
                                {{-- Row Kegiatan (K.z) --}}
                                @php $rkCount = $k->children->count(); @endphp
                                <tr class="hover:bg-slate-800/20 transition-colors group text-xs align-top">
                                    <td class="px-4 py-6 font-bold text-slate-500 text-center border-r border-slate-800/60">{{ $k->nomor }}</td>
                                    <td class="px-6 py-6 text-white font-medium border-r border-slate-800/60 w-64">{{ $k->sasaran_kegiatan }}</td>
                                    <td class="px-6 py-6 text-slate-400 border-r border-slate-800/60 w-48">{{ $k->indikator }}</td>
                                    <td class="px-4 py-6 text-center font-black text-white border-r border-slate-800/60">{{ $k->target }}</td>
                                    <td class="px-6 py-6 text-slate-500 border-r border-slate-800/60 w-64 italic">{{ $k->outcome }}</td>
                                    
                                    @php $firstRk = $k->children->first(); @endphp
                                    @if($firstRk)
                                        <td class="px-6 py-6 text-white border-r border-slate-800/60 w-64">
                                            <span class="text-[10px] font-black text-blue-400 mr-2">{{ $firstRk->nomor }}</span>
                                            {{ $firstRk->rincian_kegiatan }}
                                        </td>
                                        <td class="px-6 py-6 text-slate-400 border-r border-slate-800/60 w-64">
                                            <span class="text-[10px] font-black text-slate-500 mr-2">{{ $firstRk->nomor }}</span>
                                            {{ $firstRk->indikator_output }}
                                        </td>
                                        <td class="px-4 py-6 text-center font-black text-white border-r border-slate-800/60">{{ $firstRk->target_output }}</td>
                                        <td class="px-6 py-6 border-r border-slate-800/60">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(explode(',', $firstRk->waktu_pelaksanaan) as $waktu)
                                                    <span class="px-2 py-0.5 bg-slate-800 rounded-md text-[9px] font-black text-slate-400 border border-slate-700 uppercase tracking-tighter">{{ $waktu }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-emerald-400 font-bold border-r border-slate-800/60 whitespace-nowrap">{{ $firstRk->anggaran ?: '-' }}</td>
                                        <td class="px-6 py-6 border-r border-slate-800/60 w-48">
                                            <div class="space-y-2">
                                                <div class="flex flex-col"><span class="text-[9px] font-black text-slate-600 uppercase mb-0.5 tracking-widest italic">Pelaksana</span><span class="px-2 py-1 bg-indigo-500/10 text-indigo-400 rounded-lg text-[10px] font-bold border border-indigo-500/20">{{ $firstRk->pelaksana }}</span></div>
                                                <div class="flex flex-col"><span class="text-[9px] font-black text-slate-600 uppercase mb-0.5 tracking-widest italic">Koordinator</span><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 rounded-lg text-[10px] font-bold border border-emerald-500/20">{{ $firstRk->koordinator }}</span></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 border-r border-slate-800/60 w-56">
                                            <div class="flex flex-col gap-2">
                                                <p class="text-[10px] text-slate-400 italic leading-relaxed">{{ $firstRk->data_dukung ?: 'Belum ditentukan' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-center border-r border-slate-800/60 font-black text-white text-lg">{{ $firstRk->prosentase }}%</td>
                                        <td class="px-6 py-6 text-slate-500 border-r border-slate-800/60 w-64 italic">{{ $firstRk->catatan ?: '-' }}</td>
                                        <td class="px-6 py-6 text-right">
                                            <div class="flex items-center justify-end space-x-1">
                                                <a href="{{ route('zi-monitoring.edit', $firstRk) }}" class="p-3 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg active:scale-90" title="Isi Data">
                                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    @else
                                        <td colspan="10" class="px-6 py-6 border-r border-slate-800/60 text-slate-700 italic text-center">Belum ada indikator output</td>
                                    @endif
                                </tr>
                                
                                {{-- IO Lainnya --}}
                                @foreach($k->children as $rk)
                                    @if($loop->first) @continue @endif
                                    <tr class="hover:bg-slate-800/20 transition-colors group text-xs align-top border-t border-slate-800/30">
                                        <td class="px-4 py-6 border-r border-slate-800/60"></td>
                                        <td class="px-6 py-6 border-r border-slate-800/60"></td>
                                        <td class="px-6 py-6 border-r border-slate-800/60"></td>
                                        <td class="px-4 py-6 border-r border-slate-800/60"></td>
                                        <td class="px-6 py-6 border-r border-slate-800/60"></td>
                                        
                                        <td class="px-6 py-6 text-white border-r border-slate-800/60 w-64">
                                            <span class="text-[10px] font-black text-blue-400 mr-2">{{ $rk->nomor }}</span>
                                            {{ $rk->rincian_kegiatan }}
                                        </td>
                                        <td class="px-6 py-6 text-slate-400 border-r border-slate-800/60 w-64">
                                            <span class="text-[10px] font-black text-slate-500 mr-2">{{ $rk->nomor }}</span>
                                            {{ $rk->indikator_output }}
                                        </td>
                                        <td class="px-4 py-6 text-center font-black text-white border-r border-slate-800/60">{{ $rk->target_output }}</td>
                                        <td class="px-6 py-6 border-r border-slate-800/60">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach(explode(',', $rk->waktu_pelaksanaan) as $waktu)
                                                    <span class="px-2 py-0.5 bg-slate-800 rounded-md text-[9px] font-black text-slate-400 border border-slate-700 uppercase tracking-tighter">{{ $waktu }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-emerald-400 font-bold border-r border-slate-800/60 whitespace-nowrap">{{ $rk->anggaran ?: '-' }}</td>
                                        <td class="px-6 py-6 border-r border-slate-800/60 w-48">
                                            <div class="space-y-2">
                                                <div class="flex flex-col"><span class="text-[9px] font-black text-slate-600 uppercase mb-0.5 tracking-widest italic">Pelaksana</span><span class="px-2 py-1 bg-indigo-500/10 text-indigo-400 rounded-lg text-[10px] font-bold border border-indigo-500/20">{{ $rk->pelaksana }}</span></div>
                                                <div class="flex flex-col"><span class="text-[9px] font-black text-slate-600 uppercase mb-0.5 tracking-widest italic">Koordinator</span><span class="px-2 py-1 bg-emerald-500/10 text-emerald-400 rounded-lg text-[10px] font-bold border border-emerald-500/20">{{ $rk->koordinator }}</span></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 border-r border-slate-800/60 w-56">
                                            <div class="flex flex-col gap-2">
                                                <p class="text-[10px] text-slate-400 italic leading-relaxed">{{ $rk->data_dukung ?: 'Belum ditentukan' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 text-center border-r border-slate-800/60 font-black text-white text-lg">{{ $rk->prosentase }}%</td>
                                        <td class="px-6 py-6 text-slate-500 border-r border-slate-800/60 w-64 italic">{{ $rk->catatan ?: '-' }}</td>
                                        <td class="px-6 py-6 text-right">
                                            <div class="flex items-center justify-end space-x-1">
                                                <a href="{{ route('zi-monitoring.edit', $rk) }}" class="p-3 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-all shadow-lg active:scale-90" title="Isi Data">
                                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
    <div class="flex items-center space-x-3 bg-[#111827] p-4 rounded-2xl border border-slate-800">
        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sesuai (Unit Eselon I + Itjen)</span>
    </div>
    <div class="flex items-center space-x-3 bg-[#111827] p-4 rounded-2xl border border-slate-800">
        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Menunggu Evaluasi</span>
    </div>
    <div class="flex items-center space-x-3 bg-[#111827] p-4 rounded-2xl border border-slate-800">
        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tidak Sesuai</span>
    </div>
    <div class="flex items-center space-x-3 bg-[#111827] p-4 rounded-2xl border border-slate-800">
        <div class="w-3 h-3 rounded-full bg-slate-600"></div>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Belum Ada Data Dukung</span>
    </div>
</div>

</div>

<script>
function filterTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
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
@endsection
