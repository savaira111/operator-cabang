@extends('layouts.app')

@section('title', 'Detail Laporan Excel')
@section('page_title', 'Detail Laporan Internal Excel')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter">Detail Laporan</h3>
        <p class="text-slate-500 text-sm mt-1">Kategori: {{ $report->category_name }}</p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('laporan-internal-excel.index', ['category_id' => $report->category_id]) }}" class="px-5 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-2xl flex items-center hover:bg-slate-700 transition-all active:scale-95 text-xs">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Kembali
        </a>
        <a href="{{ asset($report->file_path) }}" target="_blank" class="px-5 py-2.5 bg-[#D2A039] text-[#061B30] font-bold rounded-2xl flex items-center hover:bg-[#b88a2e] transition-all active:scale-95 text-xs shadow-lg shadow-[#D2A039]/20">
            <i data-lucide="download" class="w-4 h-4 mr-2"></i> Download Excel
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    <div class="lg:col-span-2 space-y-8">
        <!-- Excel Content Table -->
        <div class="bg-[#031121]/50 backdrop-blur-xl border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="px-8 py-6 border-b border-slate-800/60 flex items-center justify-between">
                <h4 class="text-sm font-black text-white uppercase tracking-widest flex items-center gap-2">
                    <i data-lucide="table" class="w-4 h-4 text-[#D2A039]"></i>
                    Data File Excel
                </h4>
            </div>
            <div class="overflow-x-auto max-h-[600px] overflow-y-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-slate-800/40">
                        @forelse($excelData as $rowIndex => $row)
                            <tr class="{{ $rowIndex == 1 ? 'bg-slate-900/80 font-black text-slate-300' : 'hover:bg-white/[0.02] text-slate-400' }}">
                                @foreach($row as $cell)
                                    <td class="px-6 py-4 text-[11px] border-x border-slate-800/20 whitespace-nowrap">
                                        {{ $cell ?? '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td class="px-8 py-20 text-center text-slate-500 italic text-xs">
                                    Tidak ada data yang dapat ditampilkan atau format file tidak didukung.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Metadata Card -->
        <div class="bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#D2A039]/5 blur-3xl rounded-full"></div>
            
            <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Informasi Laporan</h4>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-1.5">No Input</label>
                    <p class="text-sm font-mono font-bold text-white">{{ $report->no_input }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-1.5">Tanggal Input</label>
                    <p class="text-sm font-bold text-white">{{ date('d F Y, H:i', strtotime($report->tanggal_input)) }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-1.5">Cabang / UPT</label>
                    <p class="text-sm font-bold text-white">{{ $report->cabang->name ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-1.5">Periode</label>
                    <p class="text-sm font-bold text-white">{{ $report->periode_bulan }} {{ $report->periode_tahun }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-1.5">Keterangan</label>
                    <p class="text-xs text-slate-400 leading-relaxed">{{ $report->keterangan ?: 'Tidak ada keterangan.' }}</p>
                </div>
            </div>
        </div>

        <!-- Evaluation Status Card -->
        <div class="bg-[#031121]/50 backdrop-blur-xl border border-slate-800 rounded-[2rem] p-8 shadow-2xl">
            <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Status Evaluasi</h4>
            
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-slate-400 uppercase">Progres</span>
                    <span class="text-sm font-black text-[#D2A039]">{{ $report->prosentase ?? 0 }}%</span>
                </div>
                <div class="w-full h-2 bg-slate-900 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-[#D2A039] to-[#f9d77e] transition-all duration-1000" style="width: {{ $report->prosentase ?? 0 }}%"></div>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Evaluasi</label>
                    <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-800 min-h-[100px]">
                        <p class="text-xs text-slate-300 italic">{{ $report->catatan_evaluasi ?: 'Belum ada catatan evaluasi dari pusat.' }}</p>
                    </div>
                </div>
                
                <div class="pt-2">
                    <span class="px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest 
                        {{ $report->status_evaluasi == 'Selesai' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
                        {{ $report->status_evaluasi ?: 'Pending' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #334155; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
});
</script>
@endsection
