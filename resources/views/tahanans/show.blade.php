@extends('layouts.app')

@section('title', 'Detail Laporan Tahanan')
@section('page_title', 'Informasi Detail Laporan')

@section('content')
<div class="max-w-6xl mx-auto space-y-10 pb-20">
    <div class="bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl relative overflow-hidden group">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 rounded-full blur-[100px] hidden sm:block"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 rounded-full blur-[100px] hidden sm:block"></div>

        <div class="mb-10 flex flex-col md:flex-row md:items-center gap-6 relative z-10">
            <a href="{{ route('tahanans.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800/40 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-full border border-slate-700/50 transition-all active:scale-95 group order-2 md:order-1">
                <i data-lucide="x" class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90"></i>
                <span class="text-[10px] uppercase tracking-[0.2em]">Batal</span>
            </a>

            <div class="flex items-center gap-6 order-1 md:order-2 flex-1">
                <div class="w-14 h-14 md:w-16 md:h-16 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center text-[#061B30] shadow-xl shadow-[#D2A039]/20 shrink-0">
                    <i data-lucide="file-text" class="w-7 h-7 md:w-8 md:h-8"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Laporan #{{ $tahanan->no_input }}</h3>
                    <p class="text-slate-400 text-[10px] md:text-xs mt-0.5 uppercase tracking-widest font-bold">Metadata Arsip Digital</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 order-3">
                <a href="{{ route('tahanans.edit', $tahanan) }}" class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 shadow-lg shadow-[#D2A039]/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-[10px] uppercase tracking-widest font-black">Ubah Data</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <!-- Main Info Card -->
            <div class="md:col-span-2 space-y-6 md:space-y-8">
                <div class="bg-slate-900/40 border border-slate-800/50 rounded-2xl md:rounded-3xl p-4 md:p-10">
                    <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-8 md:mb-10 flex items-center gap-3">
                        <i data-lucide="info" class="w-3.5 h-3.5 md:w-4 md:h-4 text-[#D2A039]"></i>
                        INFORMASI UMUM LAPORAN
                    </h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 md:gap-y-10 gap-x-8">
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-1.5 md:mb-2">NOMOR INPUT PASIN</p>
                            <p class="text-xl md:text-2xl font-black text-[#D2A039] tracking-tighter">{{ $tahanan->no_input }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-1.5 md:mb-2">TANGGAL TERCATAT</p>
                            <p class="text-xl md:text-2xl font-black text-white tracking-tight">{{ date('d F Y', strtotime($tahanan->tanggal_input)) }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-3 md:mb-4">PERIODE LAPORAN</p>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1.5 md:px-4 md:py-2 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-lg md:rounded-xl text-[10px] md:text-[11px] font-black text-[#D2A039] uppercase tracking-widest shadow-lg">
                                    {{ $tahanan->periode_bulan }}
                                </span>
                                <span class="px-3 py-1.5 md:px-4 md:py-2 bg-slate-800 border border-slate-700 rounded-lg md:rounded-xl text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest">
                                    {{ $tahanan->periode_tahun }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-3">LOKASI CABANG</p>
                            <div class="flex items-center text-white text-lg md:text-xl font-black tracking-tight">
                                <i data-lucide="building-2" class="w-4.5 h-4.5 md:w-5 md:h-5 mr-3 text-slate-600"></i>
                                {{ $tahanan->cabang->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/20 border border-slate-800/50 rounded-2xl md:rounded-3xl p-4 md:p-8">
                    <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                        <i data-lucide="message-square" class="w-3.5 h-3.5 md:w-4 md:h-4 text-[#D2A039]"></i>
                        Keterangan Tambahan
                    </h4>
                    <p class="text-slate-400 text-xs md:text-sm leading-relaxed whitespace-pre-line">
                        {{ $tahanan->keterangan ?? 'Tidak ada keterangan tambahan untuk laporan ini.' }}
                    </p>
                </div>
            </div>

            <!-- Side Card (File & Actions) -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-[#D2A039]/10 to-transparent border border-[#D2A039]/20 rounded-2xl md:rounded-3xl p-4 md:p-8 shadow-inner">
                    <h4 class="text-[9px] md:text-[10px] font-black text-[#D2A039] uppercase tracking-[0.2em] mb-6 md:mb-8">Lampiran Digital</h4>
                    
                    @if($tahanan->file_path)
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-[#D2A039]/10 rounded-[1.5rem] md:rounded-[2rem] border border-[#D2A039]/30 flex items-center justify-center text-[#D2A039] mb-4 md:mb-6 shadow-2xl shadow-[#D2A039]/5 group-hover:scale-105 transition-transform">
                            <i data-lucide="file-spreadsheet" class="w-8 h-8 md:w-10 md:h-10"></i>
                        </div>
                        <p class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest mb-1">File Terlampir</p>
                        <p class="text-[9px] text-slate-500 font-mono mb-6 md:mb-8 truncate max-w-full italic">{{ basename($tahanan->file_path) }}</p>
                        
                        <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="w-full py-3 md:py-4 bg-[#D2A039] hover:bg-[#D2A039]/90 text-[#061B30] font-black rounded-xl md:rounded-2xl transition-all shadow-xl shadow-[#D2A039]/10 active:scale-95 text-[9px] md:text-[10px] uppercase tracking-[0.2em] flex items-center justify-center">
                            <i data-lucide="download-cloud" class="w-3.5 h-3.5 md:w-4 md:h-4 mr-2"></i>
                            Download
                        </a>
                    </div>
                    @else
                    <div class="flex flex-col items-center text-center py-6">
                        <div class="w-16 h-16 bg-slate-900/50 rounded-2xl flex items-center justify-center text-slate-700 mb-4 border border-slate-800">
                            <i data-lucide="file-warning" class="w-8 h-8"></i>
                        </div>
                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Tidak Ada File Lampiran</p>
                    </div>
                    @endif
                </div>

                <div class="bg-slate-900/40 border border-slate-800/50 rounded-3xl p-6 md:p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-[#D2A039]"></i>
                        Log Aktivitas
                    </h4>
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#D2A039] mt-1.5 mr-3 shadow-[0_0_8px_rgba(210,160,57,0.5)]"></div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Laporan Dibuat</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $tahanan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mt-1.5 mr-3 shadow-[0_0_8px_rgba(59,130,246,0.5)]"></div>
                            <div>
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Terakhir Diperbarui</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">{{ $tahanan->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Preview Section -->
        <div class="mt-8 md:mt-12 pt-8 md:pt-12 border-t border-slate-800">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 md:gap-6 mb-8 md:mb-10">
                <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] flex items-center gap-3">
                    <i data-lucide="layout-grid" class="w-4 h-4 md:w-5 md:h-5 text-[#D2A039]"></i>
                    DATA PREVIEW (GRID)
                </h4>
                @if($tahanan->file_path)
                <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="px-4 py-2 md:px-6 md:py-3 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] rounded-xl md:rounded-2xl border border-emerald-500/20 transition-all active:scale-95 flex items-center gap-2">
                    <i data-lucide="external-link" class="w-3.5 h-3.5 md:w-4 md:h-4"></i>
                    Buka File Full
                </a>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8">
                @if(!empty($excelData))
                    @php 
                        $headers = array_shift($excelData); 
                        $validHeaders = array_filter($headers); 
                    @endphp
                    @foreach($excelData as $row)
                        @php 
                            if (count(array_filter($row)) < 2) continue;
                        @endphp
                        <div class="bg-slate-900/30 border border-slate-800/50 rounded-2xl md:rounded-3xl p-4 md:p-8 hover:border-[#D2A039]/30 hover:bg-slate-900/50 transition-all group relative overflow-hidden text-xs md:text-sm">
                            <div class="absolute -top-10 -right-10 w-24 h-24 bg-[#D2A039]/5 rounded-full blur-2xl group-hover:bg-[#D2A039]/10 transition-all"></div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 relative z-10">
                                @foreach($validHeaders as $col => $header)
                                    <div class="{{ $loop->last && $loop->count % 2 != 0 ? 'sm:col-span-2' : '' }}">
                                        <p class="text-[8px] md:text-[9px] font-black text-slate-600 uppercase tracking-[0.2em] mb-1 flex items-center gap-1.5">
                                            <span class="w-1 h-1 bg-slate-700 rounded-full"></span>
                                            {{ $header }}
                                        </p>
                                        <p class="text-[11px] md:text-[13px] font-bold text-slate-300 group-hover:text-white transition-colors leading-relaxed">
                                            {{ $row[$col] ?? '-' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full py-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-900/50 rounded-3xl flex items-center justify-center mb-6 border border-slate-800 text-slate-700">
                                <i data-lucide="file-question" class="w-10 h-10"></i>
                            </div>
                            <p class="text-slate-500 font-black uppercase tracking-[0.2em] text-[10px]">Data Excel Tidak Dapat Ditampilkan</p>
                            <p class="text-slate-700 text-[10px] mt-2">Pratinjau data excel saat ini tidak tersedia atau format tidak didukung.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
