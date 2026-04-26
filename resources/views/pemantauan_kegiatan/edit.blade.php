@extends('layouts.app')

@section('title', 'Perbarui Pemantauan Kegiatan Pengendalian')
@section('page_title', 'Perbarui Pemantauan Kegiatan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Perbarui Pemantauan Kegiatan</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui hasil pemantauan kegiatan pengendalian operasional.</p>
        </div>
        <a href="{{ route('pemantauan-kegiatan.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('pemantauan-kegiatan.update', $pemantauanKegiatan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">

            <!-- SELECT KODE -->
            <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Rencana Tindak Pengendalian</label>
                <select name="rencana_tindak_pengendalian_id" id="rencana_tindak_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer pointer-events-none opacity-80" readonly>
                    @foreach($rencanas as $rencana)
                        <option value="{{ $rencana->id }}" 
                            data-pernyataan="{{ $rencana->resiko->pernyataan_risiko ?? '-' }}"
                            data-kegiatan="{{ $rencana->rencana_tindak ?? '-' }}"
                            data-penanggung="{{ $rencana->penanggung_jawab ?? '-' }}"
                            data-indikator="{{ $rencana->indikator_keluaran ?? '-' }}"
                            data-target="{{ $rencana->waktu_pelaksanaan ?? '-' }}"
                            {{ $pemantauanKegiatan->rencana_tindak_pengendalian_id == $rencana->id ? 'selected' : '' }}
                        >
                            [{{ $rencana->resiko->kode ?? '-' }}] - {{ Str::limit($rencana->rencana_tindak, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- READONLY FIELDS FROM FILTER 5 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-80 pointer-events-none">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                    <textarea id="ro_pernyataan" rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none resize-none" readonly>{{ $pemantauanKegiatan->rencanaTindak->resiko->pernyataan_risiko ?? '' }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kegiatan Pengendalian</label>
                    <textarea id="ro_kegiatan" rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none resize-none" readonly>{{ $pemantauanKegiatan->rencanaTindak->rencana_tindak ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penanggung Jawab</label>
                    <input type="text" id="ro_penanggung" value="{{ $pemantauanKegiatan->rencanaTindak->penanggung_jawab ?? '' }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none" readonly>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target Waktu</label>
                    <input type="text" id="ro_target" value="{{ $pemantauanKegiatan->rencanaTindak->waktu_pelaksanaan ?? '' }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none" readonly>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator (Keluaran)</label>
                    <input type="text" id="ro_indikator" value="{{ $pemantauanKegiatan->rencanaTindak->indikator_keluaran ?? '' }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none" readonly>
                </div>
            </div>

            <!-- INPUT FIELDS FOR FILTER 6 -->
            <div class="border border-blue-500/20 p-6 rounded-2xl bg-blue-500/5 mt-8 space-y-6">
                <div>
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Realisasi Waktu</label>
                    <input type="text" name="realisasi_waktu" value="{{ $pemantauanKegiatan->realisasi_waktu }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: Terlaksana pada minggu ke-2 bulan April">
                </div>

                <div>
                    <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Hambatan / Kendala</label>
                    <textarea name="hambatan_kendala" required rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-rose-500/30 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Deskripsikan hambatan atau kendala yang dihadapi...">{{ $pemantauanKegiatan->hambatan_kendala }}</textarea>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Perbarui Data Pemantauan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
