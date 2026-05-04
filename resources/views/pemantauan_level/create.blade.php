@extends('layouts.app')

@section('title', 'Create Pemantauan Level Risiko')
@section('page_title', 'Create Pemantauan Level')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Daftar Pemantauan Level Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Formulir pemantauan tingkat risiko yang direspons dan aktual.</p>
        </div>
        <a href="{{ route('pemantauan-level.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('pemantauan-level.store') }}" method="POST">
        @csrf
        <div class="space-y-6"><!-- SELECT ANALISIS RISIKO -->
            <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Pernyataan Risiko (Filter 2)</label>
                <select name="analisis_risiko_id" id="analisis_risiko_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer">
                    <option value="" selected disabled hidden>-- Pilih Pernyataan Risiko --</option>
                    @foreach($analisisRisikos as $ar)
                        <option value="{{ $ar->id }}" 
                            data-frekuensi="{{ $ar->frekuensi }}"
                            data-dampak="{{ $ar->dampak }}"
                            data-nilai="{{ $ar->level_risiko ?? '-' }}"
                            data-f_aktual="{{ $ar->skor_probabilitas_residu }}"
                            data-d_aktual="{{ $ar->skor_dampak_residu }}"
                            data-n_aktual="{{ $ar->level_risiko_residu ?? '-' }}"
                        >
                            [{{ $ar->identifikasiRisiko->kode_risiko ?? '-' }}] - {{ Str::limit($ar->identifikasiRisiko->pernyataan_risiko, 100) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- AUTO-FILL SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 opacity-80 pointer-events-none">
                <!-- Risiko Direspons -->
                <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800/60">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6 pb-2 border-b border-slate-800">Risiko yang Direspons</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Frekuensi</label>
                            <input type="text" id="ro_f" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-slate-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Dampak</label>
                            <input type="text" id="ro_d" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-slate-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-slate-600 uppercase mb-2">Nilai</label>
                            <input type="text" id="ro_n" class="w-full px-4 py-3 bg-slate-800/30 rounded-xl border border-slate-700 text-emerald-400 font-black text-center" readonly>
                        </div>
                    </div>
                </div>

                <!-- Level Risiko Aktual -->
                <div class="bg-blue-500/5 p-6 rounded-3xl border border-blue-500/10">
                    <h4 class="text-[10px] font-black text-blue-400/60 uppercase tracking-widest mb-6 pb-2 border-b border-blue-500/10">Level Risiko Aktual</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Frekuensi</label>
                            <input type="text" id="ro_f_akt" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Dampak</label>
                            <input type="text" id="ro_d_akt" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-bold text-center" readonly>
                        </div>
                        <div>
                            <label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-2">Nilai</label>
                            <input type="text" id="ro_n_akt" class="w-full px-4 py-3 bg-blue-500/10 rounded-xl border border-blue-500/20 text-blue-400 font-black text-center" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MANUAL INPUT SECTION -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Deviasi</label>
                    <textarea name="deviasi" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan deviasi jika ada..."></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Rekomendasi</label>
                    <textarea name="rekomendasi" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan rekomendasi tindakan..."></textarea>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Simpan Pemantauan Level
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAR = document.getElementById('analisis_risiko_id');
        
        const roF = document.getElementById('ro_f');
        const roD = document.getElementById('ro_d');
        const roN = document.getElementById('ro_n');
        
        const roFAkt = document.getElementById('ro_f_akt');
        const roDAkt = document.getElementById('ro_d_akt');
        const roNAkt = document.getElementById('ro_n_akt');

        selectAR.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            
            roF.value = opt.dataset.frekuensi || '-';
            roD.value = opt.dataset.dampak || '-';
            roN.value = opt.dataset.nilai || '-';
            
            roFAkt.value = opt.dataset.f_aktual || '-';
            roDAkt.value = opt.dataset.d_aktual || '-';
            roNAkt.value = opt.dataset.n_aktual || '-';
        });
    });
</script>
@endsection


