@extends('layouts.app')

@section('title', 'Create Evaluasi Risiko')
@section('page_title', 'Hasil Evaluasi')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Hasil Evaluasi / Komentar</h3>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk memberikan komentar efektivitas pengendalian.</p>
        </div>
        <a href="{{ route('evaluasi-risiko.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('evaluasi-risiko.store') }}" method="POST">
        @csrf
        <div class="space-y-10"><!-- SELECTION -->
            <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pilih Kode (Filter 4)</label>
                <select name="resiko_id" id="kode_select" required class="w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none cursor-pointer" onchange="updateFields()">
                    <option value="" selected disabled hidden>-- Pilih Kode --</option>
                    @foreach($resikos as $r)
                        @php
                            $identifikasi = \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $r->pernyataan_risiko)->first();
                            $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                        @endphp
                        <option value="{{ $r->id }}"
                            data-risiko="{{ $r->pernyataan_risiko }}"
                            data-penyebab="{{ $r->kode_penyebab }}"
                            data-direspons="{{ $r->risiko_direspons }}"
                            data-aktual="{{ $r->risiko_aktual }}"
                        >
                            [{{ $kodeRisiko }}] - {{ $r->kode }} - {{ Str::limit($r->pernyataan_risiko, 100) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- AUTO-FILLED INFO -->
                <div class="space-y-6"><div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Pernyataan Risiko</label>
                        <textarea id="ro_risiko" rows="3" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic resize-none" readonly placeholder="Otomatis..."></textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Kode Penyebab</label>
                        <input type="text" id="ro_penyebab" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic uppercase" readonly placeholder="Otomatis...">
                    </div>
                </div>

                <div class="space-y-6"><div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic text-blue-400/60">Risiko yang Direspons</label>
                            <input type="text" id="ro_direspons" class="w-full px-5 py-4 bg-blue-500/5 rounded-2xl border border-blue-500/10 text-blue-400 font-black text-center text-xs" readonly placeholder="-">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic text-rose-400/60">Risiko Aktual</label>
                            <input type="text" id="ro_aktual" class="w-full px-5 py-4 bg-rose-500/5 rounded-2xl border border-rose-500/10 text-rose-400 font-black text-center text-xs" readonly placeholder="-">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-3 ml-1">Pemilik Risiko (Manual)</label>
                        <input type="text" name="pemilik_risiko" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none" placeholder="Masukkan nama unit / pegawai...">
                    </div>
                </div>
            </div>

            <!-- MANUAL INPUT -->
            <div class="bg-emerald-500/5 p-8 rounded-[2.5rem] border border-emerald-500/10 shadow-inner">
                <label class="block text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-4 ml-1">Keterangan (Usulan / Komentar)</label>
                <textarea name="keterangan" rows="5" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none" placeholder="Jelaskan usulan/komentar efektivitas pengendalian dan tindak lanjut yang diperlukan..."></textarea>
            </div>
            
            <div class="pt-6 flex space-x-4 border-t border-slate-800/60 mt-8">
                <button type="submit" class="px-10 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-emerald-500/20 active:scale-95">
                    Simpan Hasil Evaluasi
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function updateFields() {
        const select = document.getElementById('kode_select');
        const opt = select.options[select.selectedIndex];
        
        if (opt.value) {
            document.getElementById('ro_risiko').value = opt.dataset.risiko;
            document.getElementById('ro_penyebab').value = opt.dataset.penyebab;
            document.getElementById('ro_direspons').value = opt.dataset.direspons;
            document.getElementById('ro_aktual').value = opt.dataset.aktual;
        }
    }
</script>
@endsection


