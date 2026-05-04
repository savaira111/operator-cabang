@extends('layouts.app')

@section('title', 'Edit Pemantauan Level Risiko')
@section('page_title', 'Edit Pemantauan Level')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Edit Pemantauan Level Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui data pemantauan level risiko.</p>
        </div>
        <a href="{{ route('pemantauan-level.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('pemantauan-level.update', $pemantauanLevel) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6"><!-- SELECT ANALISIS RISIKO (READONLY IN EDIT) -->
            <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6 opacity-80 pointer-events-none">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko (Filter 2)</label>
                <select name="analisis_risiko_id" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white outline-none" readonly>
                    @foreach($analisisRisikos as $ar)
                        <option value="{{ $ar->id }}" {{ $pemantauanLevel->analisis_risiko_id == $ar->id ? 'selected' : '' }}>
                            [{{ $ar->identifikasiRisiko->kode_risiko ?? '-' }}] - {{ Str::limit($ar->identifikasiRisiko->pernyataan_risiko, 100) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- AUTO-FILL SECTION -->
            @php
                $ar = $pemantauanLevel->analisisRisiko;
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 opacity-80 pointer-events-none">
                <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800/60">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 pb-2 border-b border-slate-800">Risiko yang Direspons</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Frekuensi</label>
                            <input type="text" value="{{ $ar->frekuensi }}" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-slate-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Dampak</label>
                            <input type="text" value="{{ $ar->dampak }}" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-slate-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Nilai</label>
                            <input type="text" value="{{ $ar->level_risiko ?? '-' }}" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-emerald-400 font-black text-center" readonly>
                        </div>
                    </div>
                </div>

                <!-- Level Risiko Aktual -->
                <div class="bg-blue-500/5 p-6 rounded-3xl border border-blue-500/10">
                    <h4 class="text-[10px] font-black text-blue-400/60 uppercase tracking-widest mb-6 pb-2 border-b border-blue-500/10">Level Risiko Aktual</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Frekuensi</label>
                            <input type="text" value="{{ $ar->skor_probabilitas_residu }}" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Dampak</label>
                            <input type="text" value="{{ $ar->skor_dampak_residu }}" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Nilai</label>
                            <input type="text" value="{{ $ar->level_risiko_residu ?? '-' }}" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-black text-center" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MANUAL INPUT SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Deviasi</label>
                    <textarea name="deviasi" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan deviasi jika ada...">{{ $pemantauanLevel->deviasi }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Rekomendasi</label>
                    <textarea name="rekomendasi" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan rekomendasi tindakan...">{{ $pemantauanLevel->rekomendasi }}</textarea>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Perbarui Pemantauan Level
                </button>
            </div>
        </div>
    </form>
</div>
@endsection


