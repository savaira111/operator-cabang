@extends('layouts.app')

@section('title', 'Perbarui Rencana Tindak Pengendalian')
@section('page_title', 'Perbarui Rencana Tindak')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('rencana-tindak.index') }}" class="p-3 bg-slate-800/50 hover:bg-slate-700 text-slate-400 hover:text-white rounded-2xl transition-all">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <h3 class="text-2xl font-black text-white tracking-tight">Perbarui Rencana Tindak</h3>
        </div>
        <p class="text-slate-500 text-sm mt-2 ml-14">Perbarui rencana tindak lanjut untuk risiko yang telah dianalisis.</p>
    </div>

    <form action="{{ route('rencana-tindak.update', $rencana_tindak) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6"><div class="bg-slate-800/30 border border-slate-700/50 rounded-[2rem] p-8">
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i data-lucide="link" class="w-5 h-5 mr-3 text-rose-400"></i>
                    Pilih Analisis Akar Masalah (Kode WP)
                </h4>
                
                <div class="mb-6">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Laporan</label>
                    <select name="resiko_id" id="resiko_id" required class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer" onchange="updateResikoInfo()">
                        <option value="" disabled hidden>-- Pilih Kode Laporan --</option>
                        @foreach($resikos as $resiko)
                            @php
                                $identifikasi = \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $resiko->pernyataan_risiko)->first();
                                $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                            @endphp
                            <option value="{{ $resiko->id }}" {{ $rencana_tindak->resiko_id == $resiko->id ? 'selected' : '' }}>
                                {{ $kodeRisiko }} - {{ $resiko->kode }} ({{ Str::limit($resiko->pernyataan_risiko, 40) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Auto-filled info preview -->
                <div id="resiko-preview" class="hidden bg-[#0B1120] rounded-2xl p-6 border border-slate-800">
                    <p class="text-xs font-bold text-slate-500 mb-4 uppercase tracking-widest border-b border-slate-800 pb-2">Data Analisis Akar Masalah</p>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                            <p id="preview-pernyataan" class="text-sm font-bold text-white"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Akar Penyebab / Pernyataan Penyebab</p>
                            <p id="preview-akar" class="text-sm font-bold text-white"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kegiatan Pengendalian</p>
                            <p id="preview-kegiatan" class="text-sm font-bold text-white"></p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1">Kode Penyebab</p>
                            <p id="preview-kodepenyebab" class="text-sm font-bold text-rose-400"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-800/30 border border-slate-700/50 rounded-[2rem] p-8">
                <h4 class="text-lg font-bold text-white mb-6 flex items-center">
                    <i data-lucide="check-square" class="w-5 h-5 mr-3 text-emerald-400"></i>
                    Formulir Rencana Tindak
                </h4>

                <div class="space-y-6"><div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Rencana Tindak Pengendalian</label>
                        <textarea name="rencana_tindak" required rows="3" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan rencana tindak pengendalian...">{{ old('rencana_tindak', $rencana_tindak->rencana_tindak) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Respons Risiko</label>
                            <textarea name="respons_risiko" rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan respons risiko...">{{ old('respons_risiko', $rencana_tindak->respons_risiko) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator Keluaran</label>
                            <textarea name="indikator_keluaran" rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan indikator keluaran...">{{ old('indikator_keluaran', $rencana_tindak->indikator_keluaran) }}</textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Klasifikasi Sub Unsur SPIP</label>
                            <input type="text" name="klasifikasi_sub_unsur_spip" value="{{ old('klasifikasi_sub_unsur_spip', $rencana_tindak->klasifikasi_sub_unsur_spip) }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Klasifikasi SPIP">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penanggung Jawab (PIC)</label>
                            <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $rencana_tindak->penanggung_jawab) }}" required class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Nama / Jabatan PIC">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target Waktu</label>
                            <input type="text" name="waktu_pelaksanaan" value="{{ old('waktu_pelaksanaan', $rencana_tindak->waktu_pelaksanaan) }}" required class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Q3 2026">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Frekuensi</label>
                            <input type="text" name="frekuensi" value="{{ old('frekuensi', $rencana_tindak->frekuensi) }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: 1">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Dampak</label>
                            <input type="text" name="dampak" value="{{ old('dampak', $rencana_tindak->dampak) }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Tinggi">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Level Risiko</label>
                        <input type="text" name="level_risiko" value="{{ old('level_risiko', $rencana_tindak->level_risiko) }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Sangat Tinggi">
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center pt-4">
                <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-400 hover:to-indigo-500 text-white font-bold rounded-2xl transition-all duration-300 shadow-xl shadow-blue-500/30 active:scale-95 flex items-center">
                    <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                    Perbarui Rencana
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const resikos = @json($resikos);

    function updateResikoInfo() {
        const select = document.getElementById('resiko_id');
        const previewDiv = document.getElementById('resiko-preview');
        const selectedId = select.value;
        
        if (selectedId) {
            const resiko = resikos.find(r => r.id == selectedId);
            if (resiko) {
                let kodeStr = resiko.kode ? resiko.kode.replace(/\s+/g, '') : '';
                let kodePenyebab = resiko.kode_penyebab_jenis && resiko.kode_penyebab_nomor 
                    ? `${kodeStr}${resiko.kode_penyebab_jenis}.${resiko.kode_penyebab_nomor}` 
                    : '-';

                document.getElementById('preview-pernyataan').innerText = resiko.pernyataan_risiko || resiko.name || '-';
                document.getElementById('preview-akar').innerText = resiko.akar_penyebab || '-';
                document.getElementById('preview-kegiatan').innerText = resiko.kegiatan_pengendalian || '-';
                document.getElementById('preview-kodepenyebab').innerText = kodePenyebab;
                
                previewDiv.classList.remove('hidden');
            }
        } else {
            previewDiv.classList.add('hidden');
        }
    }

    // Run on load
    document.addEventListener("DOMContentLoaded", () => {
        updateResikoInfo();
    });
</script>
@endsection


