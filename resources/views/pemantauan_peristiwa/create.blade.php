@extends('layouts.app')

@section('title', 'Pemantauan Terhadap Peristiwa Risiko')
@section('page_title', 'Pemantauan Peristiwa')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Pemantauan Terhadap Peristiwa Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk memantau peristiwa yang terjadi berkaitan dengan risiko.</p>
        </div>
        <a href="{{ route('pemantauan-peristiwa.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('pemantauan-peristiwa.store') }}" method="POST">
        @csrf
        <div class="space-y-6"><!-- SELECT KODE & KODE PENYEBAB -->
            <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Data Pemantauan (Kode & Kode Penyebab)</label>
                <select name="pemantauan_kegiatan_id" id="pemantauan_kegiatan_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer">
                    <option value="" selected disabled hidden>-- Pilih Kode Pemantauan --</option>
                    @foreach($pemantauanKegiatans as $kegiatan)
                        @php
                            $resiko = $kegiatan->rencanaTindak->resiko;
                            $kodePenyebab = ($resiko->kode_penyebab_jenis ?? '-') . '.' . ($resiko->kode_penyebab_nomor ?? '-');
                            $identifikasi = $resiko ? \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $resiko->pernyataan_risiko)->first() : null;
                            $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                        @endphp
                        <option value="{{ $kegiatan->id }}" 
                            data-kode="{{ $resiko->kode ?? '-' }}"
                            data-kodepenyebab="{{ $kodePenyebab }}"
                            data-pernyataan="{{ $resiko->pernyataan_risiko ?? '-' }}"
                        >
                            [{{ $kodeRisiko }} | {{ $kodePenyebab }}] - {{ Str::limit($resiko->pernyataan_risiko, 80) }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-slate-500 mt-3 font-bold"><i data-lucide="info" class="w-3 h-3 inline mr-1"></i> Field readonly di bawah ini akan terisi otomatis setelah Anda memilih opsi.</p>
            </div>

            <!-- READONLY FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-80 pointer-events-none">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode</label>
                    <input type="text" id="ro_kode" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none font-bold text-emerald-400" readonly>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Penyebab</label>
                    <input type="text" id="ro_kodepenyebab" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none font-bold text-emerald-400" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                    <textarea id="ro_pernyataan" rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none resize-none" readonly></textarea>
                </div>
            </div>

            <!-- INPUT FIELDS FOR FILTER 7 -->
            <div class="border border-blue-500/20 p-6 rounded-2xl bg-blue-500/5 mt-8 space-y-6">
                
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Uraian Peristiwa</label>
                    <textarea name="uraian_peristiwa" required rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan uraian peristiwa yang terjadi..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Waktu Kejadian</label>
                        <input type="text" name="waktu_kejadian" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: 15 Agustus 2026">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Tempat Kejadian</label>
                        <input type="text" name="tempat_kejadian" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: Ruang Server">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Skor Dampak (1 - 5)</label>
                        <select name="skor_dampak" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-rose-500/30 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Skor Dampak --</option>
                            <option value="1">1 - Sangat Rendah</option>
                            <option value="2">2 - Rendah</option>
                            <option value="3">3 - Sedang</option>
                            <option value="4">4 - Tinggi</option>
                            <option value="5">5 - Sangat Tinggi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Pemicu Peristiwa</label>
                        <input type="text" name="pemicu_peristiwa" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Penyebab memicunya peristiwa ini...">
                    </div>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Simpan Peristiwa Risiko
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectPemantauan = document.getElementById('pemantauan_kegiatan_id');
        const roKode = document.getElementById('ro_kode');
        const roKodePenyebab = document.getElementById('ro_kodepenyebab');
        const roPernyataan = document.getElementById('ro_pernyataan');

        selectPemantauan.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            roKode.value = selectedOption.dataset.kode || '';
            roKodePenyebab.value = selectedOption.dataset.kodepenyebab || '';
            roPernyataan.value = selectedOption.dataset.pernyataan || '';
        });
    });
</script>
@endsection


