@extends('layouts.app')

@section('title', 'Create Rencana Kegiatan Belum Terealisasi')
@section('page_title', 'Rencana Belum Realisasi')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Rencana Kegiatan Belum Terealisasi</h3>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mencatat rencana yang belum terlaksana.</p>
        </div>
        <a href="{{ route('rencana-belum-terealisasi.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('rencana-belum-terealisasi.store') }}" method="POST">
        @csrf
        <div class="space-y-10">
            <!-- SELECTION -->
            <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pilih Kode (Filter 5)</label>
                <select name="rencana_tindak_pengendalian_id" id="kode_select" required class="w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer" onchange="updateFields()">
                    <option value="" selected disabled hidden>-- Pilih Kode --</option>
                    @foreach($rencanaTindaks as $rtp)
                        <option value="{{ $rtp->id }}"
                            data-rencana="{{ $rtp->rencana_tindak }}"
                            data-waktu="{{ $rtp->waktu_pelaksanaan }}"
                            data-risiko="{{ $rtp->resiko->pernyataan_risiko }}"
                            data-penyebab="{{ $rtp->resiko->kode_penyebab_jenis }}{{ $rtp->resiko->kode_penyebab_nomor }}"
                            data-pj="{{ $rtp->penanggung_jawab }}"
                        >
                            {{ $rtp->resiko->kode }} - {{ Str::limit($rtp->rencana_tindak, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- AUTO-FILLED INFO -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Rencana Kegiatan Pengendalian</label>
                        <textarea id="ro_rencana" rows="3" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic resize-none" readonly placeholder="Otomatis..."></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Target Waktu</label>
                            <input type="text" id="ro_waktu" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic" readonly placeholder="Otomatis...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Kode Penyebab</label>
                            <input type="text" id="ro_penyebab" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic" readonly placeholder="Otomatis...">
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Pernyataan Risiko</label>
                        <textarea id="ro_risiko" rows="3" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic resize-none" readonly placeholder="Otomatis..."></textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3 ml-1 italic">Penanggungjawab</label>
                        <input type="text" id="ro_pj" class="w-full px-5 py-4 bg-slate-800/10 rounded-2xl border border-slate-800 text-slate-500 text-sm italic" readonly placeholder="Otomatis...">
                    </div>
                </div>
            </div>

            <!-- MANUAL INPUT -->
            <div class="bg-blue-500/5 p-8 rounded-[2rem] border border-blue-500/10">
                <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-4 ml-1">Keterangan (Manual)</label>
                <textarea name="keterangan" rows="4" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Berikan keterangan mengapa rencana ini belum terealisasi..."></textarea>
            </div>
            
            <div class="pt-6 flex space-x-4 border-t border-slate-800/60 mt-8">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Simpan Data Realisasi
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
            document.getElementById('ro_rencana').value = opt.dataset.rencana;
            document.getElementById('ro_waktu').value = opt.dataset.waktu;
            document.getElementById('ro_risiko').value = opt.dataset.risiko;
            document.getElementById('ro_penyebab').value = opt.dataset.penyebab;
            document.getElementById('ro_pj').value = opt.dataset.pj;
        }
    }
</script>
@endsection
