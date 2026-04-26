@extends('layouts.app')

@section('title', 'Detail Pemantauan Kegiatan')
@section('page_title', 'Detail Pemantauan Kegiatan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Detail Pemantauan Kegiatan</h3>
            <p class="text-slate-500 text-sm mt-1">Informasi lengkap hasil pemantauan kegiatan pengendalian.</p>
        </div>
        <a href="{{ route('pemantauan-kegiatan.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Kembali</span>
        </a>
    </div>

    <div class="space-y-8">
        <div class="bg-slate-800/30 rounded-3xl p-8 border border-slate-700/50 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <i data-lucide="bar-chart-2" class="w-32 h-32 text-white"></i>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Kode</p>
                    <p class="text-emerald-400 font-bold">{{ $pemantauanKegiatan->rencanaTindak->resiko->kode ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                    <p class="text-white text-sm leading-relaxed">{{ $pemantauanKegiatan->rencanaTindak->resiko->pernyataan_risiko ?? '-' }}</p>
                </div>
                
                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Kegiatan Pengendalian</p>
                    <p class="text-slate-300 text-sm leading-relaxed">{{ $pemantauanKegiatan->rencanaTindak->rencana_tindak ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Penanggung Jawab</p>
                    <p class="text-slate-400 font-bold text-sm">{{ $pemantauanKegiatan->rencanaTindak->penanggung_jawab ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Target Waktu</p>
                    <p class="text-slate-400 font-bold text-sm">{{ $pemantauanKegiatan->rencanaTindak->waktu_pelaksanaan ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Indikator (Keluaran)</p>
                    <p class="text-slate-400 font-bold text-sm">{{ $pemantauanKegiatan->rencanaTindak->indikator_keluaran ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-500/5 rounded-3xl p-8 border border-blue-500/20 relative overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                <div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-1">Realisasi Waktu</p>
                    <p class="text-white font-bold text-sm">{{ $pemantauanKegiatan->realisasi_waktu ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mb-1">Hambatan / Kendala</p>
                    <p class="text-white text-sm leading-relaxed">{{ $pemantauanKegiatan->hambatan_kendala ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
