@extends('layouts.app')

@section('title', 'Detail & Verifikasi ZI')
@section('page_title', 'Verifikasi Data ZI')

@section('content')
<div class="mb-10 flex items-start justify-between">
    <div>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Verifikasi Capaian ZI</h3>
        <p class="text-slate-500 text-sm mt-2 tracking-tight">Tinjau data dukung per periode dan berikan penilaian evaluasi.</p>
    </div>
    <a href="{{ route('zi-data-manage.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group shadow-lg">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
        <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
    </a>
</div>

<div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    {{-- INFO PANEL --}}
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-xl">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center border border-blue-500/20">
                <i data-lucide="info" class="w-6 h-6 text-blue-400"></i>
            </div>
            <div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Informasi Rincian Kegiatan</span>
                <h4 class="text-lg font-bold text-white tracking-tight">{{ $item->nomor }} - {{ $item->rincian_kegiatan }}</h4>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Indikator Output</label>
                    <p class="text-slate-300 font-medium leading-relaxed">{{ $item->indikator_output }}</p>
                </div>
                <div class="flex gap-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Target</label>
                        <p class="text-xl font-black text-white">{{ $item->target_output ?: '0' }}</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Progress Total</label>
                        <p class="text-xl font-black text-indigo-400">{{ $item->prosentase }}%</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="p-6 bg-slate-900/50 rounded-3xl border border-slate-800">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2">Pelaksana</label>
                    <p class="text-xs font-bold text-slate-300">{{ $item->pelaksana ?: '-' }}</p>
                </div>
                <div class="p-6 bg-slate-900/50 rounded-3xl border border-slate-800">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2">Koordinator</label>
                    <p class="text-xs font-bold text-slate-300">{{ $item->koordinator ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- FILE VERIFICATION LIST --}}
    <div class="space-y-6">
        <h4 class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-4 mb-2">Daftar File Data Dukung Per Periode</h4>
        
        @forelse($item->files as $file)
            <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-lg group hover:border-amber-500/30 transition-all">
                <div class="bg-slate-800/40 px-8 py-5 border-b border-slate-800 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center border border-amber-500/20">
                            <i data-lucide="calendar" class="w-5 h-5 text-amber-400"></i>
                        </div>
                        <h5 class="text-sm font-black text-white tracking-tight">Verifikasi Periode {{ $file->period }}</h5>
                    </div>
                    <div class="flex items-center space-x-2 px-3 py-1.5 rounded-lg {{ $file->status == 'sesuai' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : ($file->status == 'tidak_sesuai' ? 'bg-rose-500/10 border-rose-500/20 text-rose-400' : 'bg-amber-500/10 border-amber-500/20 text-amber-400') }}">
                        <span class="text-[9px] font-black uppercase tracking-widest">{{ $file->status == 'sesuai' ? 'Sesuai' : ($file->status == 'tidak_sesuai' ? 'Tidak Sesuai' : 'Menunggu Evaluasi') }}</span>
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 lg:grid-cols-2 gap-10">
                    {{-- PDF Viewer --}}
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest flex items-center">
                                <i data-lucide="eye" class="w-3.5 h-3.5 mr-2"></i>
                                Pratinjau Dokumen
                            </span>
                            <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 flex items-center">
                                Buka di Tab Baru
                                <i data-lucide="external-link" class="w-3 h-3 ml-1.5"></i>
                            </a>
                        </div>
                        <div class="aspect-video w-full rounded-2xl overflow-hidden border border-slate-700 bg-slate-900 shadow-inner">
                            <iframe src="{{ Storage::url($file->file_path) }}" class="w-full h-full"></iframe>
                        </div>
                    </div>

                    {{-- Status Form --}}
                    <div class="bg-slate-900/40 p-8 rounded-[2rem] border border-slate-800 shadow-inner">
                        <form action="{{ route('zi-data-manage.update-file-status', $file->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pilih Hasil Evaluasi</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <label class="flex items-center p-4 rounded-xl border border-slate-700 bg-[#0f172a] cursor-pointer group/label hover:border-emerald-500/50 transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/5">
                                        <input type="radio" name="status" value="sesuai" {{ $file->status == 'sesuai' ? 'checked' : '' }} class="w-4 h-4 text-emerald-500 bg-slate-900 border-slate-700 focus:ring-emerald-500">
                                        <div class="ml-4">
                                            <span class="block text-xs font-bold text-white uppercase group-hover/label:text-emerald-400 transition-colors">Sesuai (100%)</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-4 rounded-xl border border-slate-700 bg-[#0f172a] cursor-pointer group/label hover:border-amber-500/50 transition-all has-[:checked]:border-amber-500 has-[:checked]:bg-amber-500/5">
                                        <input type="radio" name="status" value="menunggu" {{ $file->status == 'menunggu' ? 'checked' : '' }} class="w-4 h-4 text-amber-500 bg-slate-900 border-slate-700 focus:ring-amber-500">
                                        <div class="ml-4">
                                            <span class="block text-xs font-bold text-white uppercase group-hover/label:text-amber-400 transition-colors">Menunggu (75%)</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-4 rounded-xl border border-slate-700 bg-[#0f172a] cursor-pointer group/label hover:border-rose-500/50 transition-all has-[:checked]:border-rose-500 has-[:checked]:bg-rose-500/5">
                                        <input type="radio" name="status" value="tidak_sesuai" {{ $file->status == 'tidak_sesuai' ? 'checked' : '' }} class="w-4 h-4 text-rose-500 bg-slate-900 border-slate-700 focus:ring-rose-500">
                                        <div class="ml-4">
                                            <span class="block text-xs font-bold text-white uppercase group-hover/label:text-rose-400 transition-colors">Tidak Sesuai (25%)</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Catatan / Alasan Perbaikan</label>
                                <textarea name="catatan" rows="3" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none shadow-inner text-sm" placeholder="Wajib diisi jika status Tidak Sesuai...">{{ $file->catatan }}</textarea>
                            </div>

                            <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white font-black rounded-xl transition-all shadow-xl shadow-amber-500/20 active:scale-95 uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                                <i data-lucide="check-square" class="w-4 h-4"></i>
                                Simpan Verifikasi {{ $file->period }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 flex flex-col items-center justify-center text-center bg-slate-900/50 rounded-3xl border border-dashed border-slate-700">
                <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4">
                    <i data-lucide="file-x" class="w-8 h-8 text-slate-600"></i>
                </div>
                <p class="text-slate-500 font-bold tracking-tight">Belum ada file data dukung yang diunggah untuk rincian kegiatan ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
