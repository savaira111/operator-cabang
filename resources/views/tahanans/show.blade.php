@extends('layouts.app')

@section('title', 'Detail Laporan Tahanan')
@section('page_title', 'Informasi Detail Laporan')

@section('content')
<div class="w-full">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>

        <div class="mb-10 flex items-start justify-between relative z-10">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 mr-6 shadow-xl shadow-indigo-500/5">
                    <i data-lucide="file-text" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight">Detail Laporan #{{ $tahanan->no_input }}</h3>
                    <p class="text-slate-500 text-sm mt-1 uppercase tracking-widest font-bold">Metadata Arsip Digital</p>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('tahanans.edit', $tahanan) }}" class="flex items-center px-6 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-500/20">
                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Edit Data</span>
                </a>
                <a href="{{ route('tahanans.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs uppercase tracking-widest">Kembali</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
            <!-- Main Info Card -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-slate-800/10 border border-slate-800/50 rounded-[2.5rem] p-10">
                    <h4 class="text-[12px] font-black text-slate-500 uppercase tracking-[0.3em] mb-12 flex items-center">
                        <i data-lucide="info" class="w-4 h-4 mr-3 text-indigo-400"></i>
                        INFORMASI UMUM LAPORAN
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-y-12">
                        <div>
                            <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-3">NOMOR INPUT PASIN</p>
                            <p class="text-3xl font-black text-indigo-400 tracking-tighter">{{ $tahanan->no_input }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-3">TANGGAL TERCATAT</p>
                            <p class="text-3xl font-black text-white tracking-tight">{{ date('d F Y', strtotime($tahanan->tanggal_input)) }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4">PERIODE LAPORAN</p>
                            <span class="inline-flex px-8 py-4 bg-[#1e243a] border border-slate-700/50 rounded-2xl text-xs font-black text-indigo-300 uppercase tracking-[0.2em] shadow-lg">
                                {{ $tahanan->periode_bulan }} {{ $tahanan->periode_tahun }}
                            </span>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-600 uppercase tracking-[0.2em] mb-3">LOKASI CABANG</p>
                            <div class="flex items-center text-white text-2xl font-black tracking-tight">
                                <i data-lucide="building-2" class="w-6 h-6 mr-3 text-slate-500"></i>
                                {{ $tahanan->cabang->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/20 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <i data-lucide="message-square" class="w-3 h-3 mr-2 text-indigo-400"></i>
                        Keterangan Tambahan
                    </h4>
                    <p class="text-slate-400 text-sm leading-relaxed whitespace-pre-line">
                        {{ $tahanan->keterangan ?? 'Tidak ada keterangan tambahan untuk laporan ini.' }}
                    </p>
                </div>
            </div>

            <!-- Side Card (File & Actions) -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-indigo-500/10 to-blue-500/10 border border-indigo-500/20 rounded-3xl p-8 shadow-inner">
                    <h4 class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-8">Lampiran Digital</h4>
                    
                    @if($tahanan->file_path)
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-emerald-500/20 rounded-[2rem] border border-emerald-500/30 flex items-center justify-center text-emerald-400 mb-6 shadow-2xl shadow-emerald-500/10">
                            <i data-lucide="file-spreadsheet" class="w-10 h-10"></i>
                        </div>
                        <p class="text-xs font-black text-white uppercase tracking-widest mb-1">Dokumen Excel Terlampir</p>
                        <p class="text-[10px] text-slate-500 font-mono mb-8 truncate max-w-full italic">{{ basename($tahanan->file_path) }}</p>
                        
                        <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="w-full py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-emerald-500/20 active:scale-95 text-[10px] uppercase tracking-[0.2em] flex items-center justify-center">
                            <i data-lucide="download-cloud" class="w-4 h-4 mr-2"></i>
                            Download Laporan
                        </a>
                    </div>
                    @else
                    <div class="flex flex-col items-center text-center py-6">
                        <div class="w-16 h-16 bg-slate-800/50 rounded-2xl flex items-center justify-center text-slate-600 mb-4">
                            <i data-lucide="file-warning" class="w-8 h-8"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Tiak Ada File Lampiran</p>
                    </div>
                    @endif
                </div>

                <div class="bg-slate-800/10 border border-slate-800/50 rounded-3xl p-8">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Log Aktivitas</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-1 h-1 rounded-full bg-indigo-500 mt-1.5 mr-3"></div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-300">Laporan Dibuat</p>
                                <p class="text-[9px] text-slate-600">{{ $tahanan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-1 h-1 rounded-full bg-blue-500 mt-1.5 mr-3"></div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-300">Terakhir Diperbarui</p>
                                <p class="text-[9px] text-slate-600">{{ $tahanan->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-12 bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 relative z-10 overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between mb-10">
                <h4 class="text-[12px] font-black text-slate-500 uppercase tracking-[0.3em] flex items-center">
                    <i data-lucide="table" class="w-4 h-4 mr-3 text-indigo-400"></i>
                    DATA PREVIEW LAPORAN (SELURUH DATA)
                </h4>
                <a href="{{ asset($tahanan->file_path) }}" target="_blank" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl transition-all shadow-lg shadow-emerald-500/20 active:scale-95 flex items-center">
                    <i data-lucide="download-cloud" class="w-4 h-4 mr-2"></i>
                    Download Full
                </a>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                @if(!empty($excelData))
                    @php 
                        $headers = array_shift($excelData); 
                        $validHeaders = array_filter($headers); // Only show columns that have a header text
                    @endphp
                    @foreach($excelData as $row)
                        @php 
                            // Check if the row is mostly empty (to skip internal empty rows)
                            if (count(array_filter($row)) < 2) continue;
                        @endphp
                        <div class="bg-slate-800/20 border border-slate-800/50 rounded-[2rem] p-8 hover:border-indigo-500/30 transition-all group">
                            <div class="grid grid-cols-2 gap-6">
                                @foreach($validHeaders as $col => $header)
                                    <div class="{{ $loop->last && $loop->count % 2 != 0 ? 'col-span-2' : '' }}">
                                        <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-2">{{ $header }}</p>
                                        <p class="text-[13px] font-bold text-slate-200 group-hover:text-white transition-colors leading-relaxed">
                                            {{ $row[$col] ?? '-' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-full py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="p-6 bg-slate-800/30 rounded-full mb-4 text-slate-700">
                                <i data-lucide="file-warning" class="w-12 h-12"></i>
                            </div>
                            <p class="text-slate-500 font-black uppercase tracking-[0.2em] text-[10px]">Data Excel Tidak Dapat Ditampilkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
