@extends('layouts.app')

@section('title', 'Isi Data Dukung ZI')
@section('page_title', 'Pengisian Data Dukung')

@section('content')
<div class="mb-10 flex items-start justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Pengisian Data Dukung</h3>
        <p class="text-slate-500 text-sm mt-2 tracking-tight">Unggah file data dukung sesuai rincian kegiatan dan periode yang ditentukan.</p>
    </div>
    <a href="{{ route('zi-data-fill.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group shadow-lg">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
    </a>
</div>

<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    {{-- HEADER INFO --}}
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
        <h4 class="text-[11px] font-black text-blue-400 uppercase tracking-widest mb-6 flex items-center">
            <i data-lucide="info" class="w-4 h-4 mr-2"></i>
            Rincian Kegiatan Utama
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Rincian Kegiatan</label>
                    <p class="text-slate-200 font-bold leading-relaxed">[{{ $item->nomor }}] {{ $item->rincian_kegiatan }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Indikator Output</label>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $item->indikator_output }}</p>
                </div>
            </div>
            <div class="space-y-6">
                <div class="flex gap-10">
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Target</label>
                        <p class="text-2xl font-black text-white">{{ $item->target_output ?: '0' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Waktu Pelaksanaan</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($periods as $p)
                                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-[10px] font-black border border-blue-500/20">{{ $p }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-900/50 rounded-2xl border border-slate-800">
                        <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Pelaksana</label>
                        <p class="text-xs font-bold text-slate-300">{{ $item->pelaksana ?: '-' }}</p>
                    </div>
                    <div class="p-4 bg-slate-900/50 rounded-2xl border border-slate-800">
                        <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Koordinator</label>
                        <p class="text-xs font-bold text-slate-300">{{ $item->koordinator ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- PERIOD SECTIONS --}}
    <div class="space-y-6">
        <h4 class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-4 mb-2">Upload Data Dukung Per Periode</h4>
        
        @foreach($periods as $p)
            @php 
                $file = $item->files->where('period', $p)->first(); 
            @endphp
            <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-lg group hover:border-indigo-500/30 transition-all">
                <div class="bg-slate-800/40 px-8 py-5 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20">
                            <i data-lucide="calendar" class="w-5 h-5 text-indigo-400"></i>
                        </div>
                        <h5 class="text-sm font-black text-white tracking-tight">Periode {{ $p }}</h5>
                    </div>
                    @if($file)
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-emerald-500/10 border border-emerald-500/20">
                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-400"></i>
                                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Terunggah</span>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">
                            <i data-lucide="alert-circle" class="w-3.5 h-3.5 text-rose-400"></i>
                            <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Belum Ada File</span>
                        </div>
                    @endif
                </div>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-10">
                    {{-- Instruction and File Status --}}
                    <div class="space-y-6">
                        <div class="p-6 bg-indigo-500/5 border border-indigo-500/20 rounded-2xl shadow-inner">
                            <label class="block text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-3 flex items-center">
                                <i data-lucide="help-circle" class="w-3 h-3 mr-1.5"></i>
                                Instruksi Data Dukung (Wajib Diunggah)
                            </label>
                            <p class="text-xs text-slate-300 font-bold leading-relaxed">{{ $item->data_dukung ?: 'Silakan unggah dokumen yang sesuai.' }}</p>
                        </div>

                        @if($file)
                            <div class="space-y-6">
                                <div class="flex items-center space-x-4 p-5 bg-slate-900/50 rounded-2xl border border-slate-800 shadow-inner">
                                    <div class="w-12 h-12 rounded-xl bg-slate-800 flex items-center justify-center border border-slate-700">
                                        <i data-lucide="file-text" class="w-6 h-6 text-indigo-400"></i>
                                    </div>
                                    <div class="flex-1 overflow-hidden">
                                        <span class="block text-[9px] font-black text-slate-600 uppercase tracking-[0.2em] mb-1">File Terupload</span>
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="block text-xs font-bold text-white truncate hover:text-indigo-400 transition-colors">
                                            {{ basename($file->file_path) }}
                                        </a>
                                        <span class="block text-[9px] text-slate-500 mt-1 italic">{{ $file->updated_at->format('d M Y (H:i)') }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 rounded-2xl bg-slate-900/30 border border-slate-800">
                                        <span class="block text-[9px] font-black text-slate-600 uppercase tracking-widest mb-3 text-center">Unit Eselon I</span>
                                        <div class="flex justify-center">
                                            @if($file->status == 'sesuai')
                                                <span class="px-3 py-1.5 bg-emerald-500 text-white text-[9px] font-black rounded-lg shadow-lg shadow-emerald-500/20">SESUAI</span>
                                            @elseif($file->status == 'tidak_sesuai')
                                                <span class="px-3 py-1.5 bg-rose-500 text-white text-[9px] font-black rounded-lg shadow-lg shadow-rose-500/20">TIDAK SESUAI</span>
                                            @else
                                                <span class="px-3 py-1.5 bg-amber-500 text-white text-[9px] font-black rounded-lg shadow-lg shadow-amber-500/20 uppercase">Menunggu Evaluasi</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-slate-900/30 border border-slate-800 opacity-50">
                                        <span class="block text-[9px] font-black text-slate-600 uppercase tracking-widest mb-3 text-center">Itjen</span>
                                        <div class="flex justify-center">
                                            <span class="px-3 py-1.5 bg-slate-700 text-slate-400 text-[9px] font-black rounded-lg uppercase tracking-tighter">Dalam Antrian</span>
                                        </div>
                                    </div>
                                </div>

                                @if($file->catatan)
                                    <div class="p-4 bg-rose-500/5 border border-rose-500/20 rounded-2xl">
                                        <label class="block text-[9px] font-black text-rose-400 uppercase tracking-widest mb-2 flex items-center">
                                            <i data-lucide="message-circle" class="w-3 h-3 mr-1.5"></i>
                                            Catatan Evaluasi
                                        </label>
                                        <p class="text-xs text-rose-300 italic font-medium leading-relaxed">{{ $file->catatan }}</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="h-full flex flex-col items-center justify-center p-8 bg-[#0f172a]/40 rounded-[2rem] border border-dashed border-slate-800/60 text-center group-hover:border-indigo-500/40 group-hover:bg-indigo-500/[0.02] transition-all duration-500 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                <div class="relative z-10">
                                    <div class="w-16 h-16 rounded-[1.5rem] bg-slate-800/50 flex items-center justify-center mb-4 mx-auto border border-slate-700/50 shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-500/10 flex items-center justify-center border border-indigo-500/20 shadow-inner">
                                            <i data-lucide="file-warning" class="w-5 h-5 text-indigo-400"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-lg font-black text-white tracking-tight mb-1 uppercase italic opacity-80">Belum Ada Data</h6>
                                    <p class="text-[10px] text-slate-500 max-w-[180px] mx-auto leading-relaxed font-medium">
                                        Unggah dokumen <span class="text-indigo-400 font-bold">PDF</span> (Maks <span class="text-white">25MB</span>) untuk periode <span class="px-1.5 py-0.5 bg-slate-800 rounded text-indigo-400 font-black">{{ $p }}</span>.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Upload Form --}}
                    <div class="bg-slate-800/20 p-8 rounded-[2rem] border border-slate-800 shadow-2xl relative overflow-hidden group/form">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-500/5 blur-[40px] -mr-12 -mt-12 rounded-full transition-all group-hover/form:bg-indigo-500/10"></div>
                        
                        <form action="{{ route('zi-data-fill.upload', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                            @csrf
                            <input type="hidden" name="period" value="{{ $p }}">
                            
                            <div class="space-y-3">
                                <label class="flex items-center text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em] ml-1">
                                    <span class="w-5 h-5 rounded-md bg-indigo-500/10 flex items-center justify-center mr-2 border border-indigo-500/20">
                                        <i data-lucide="upload-cloud" class="w-3 h-3"></i>
                                    </span>
                                    Pilih Dokumen PDF
                                </label>
                                
                                <div class="relative group/input">
                                    <input type="file" name="file" required accept="application/pdf" 
                                           class="w-full px-5 py-3.5 bg-[#031121] rounded-xl border border-slate-800 text-slate-400 text-xs focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none 
                                           file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-black file:bg-indigo-500 file:text-white hover:file:bg-indigo-600 file:cursor-pointer file:transition-all cursor-pointer">
                                </div>
                                
                                <div class="flex items-center gap-3 px-3 py-2 bg-indigo-500/[0.03] border border-indigo-500/10 rounded-xl">
                                    <i data-lucide="shield-check" class="w-3.5 h-3.5 text-indigo-500/50"></i>
                                    <p class="text-[9px] text-slate-500 font-medium leading-tight">
                                        Format <span class="text-indigo-400 font-bold">PDF</span>, Maks <span class="text-white font-bold">25MB</span>.
                                    </p>
                                </div>
                            </div>

                            <button type="submit" class="w-full group/btn relative overflow-hidden py-4 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-black rounded-xl transition-all shadow-[0_10px_25px_rgba(79,70,229,0.2)] active:scale-[0.98] uppercase tracking-[0.15em] text-[10px] flex items-center justify-center gap-2">
                                <i data-lucide="upload" class="w-3.5 h-3.5 group-hover/btn:-translate-y-1 transition-transform duration-300"></i>
                                <span>Unggah Data {{ $p }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
