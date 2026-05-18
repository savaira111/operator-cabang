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
                            <select name="frekuensi" id="frekuensi" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer appearance-none" required>
                                <option value="" disabled hidden>-- Pilih Probabilitas --</option>
                                <option value="1" {{ old('frekuensi', $rencana_tindak->frekuensi) == '1' ? 'selected' : '' }}>1 - Hampir tidak terjadi</option>
                                <option value="2" {{ old('frekuensi', $rencana_tindak->frekuensi) == '2' ? 'selected' : '' }}>2 - Jarang terjadi</option>
                                <option value="3" {{ old('frekuensi', $rencana_tindak->frekuensi) == '3' ? 'selected' : '' }}>3 - Kadang terjadi</option>
                                <option value="4" {{ old('frekuensi', $rencana_tindak->frekuensi) == '4' ? 'selected' : '' }}>4 - Sering terjadi</option>
                                <option value="5" {{ old('frekuensi', $rencana_tindak->frekuensi) == '5' ? 'selected' : '' }}>5 - Hampir pasti terjadi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Dampak</label>
                            <select name="dampak" id="dampak" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer appearance-none" required>
                                <option value="" disabled hidden>-- Pilih Dampak --</option>
                                <option value="1" {{ old('dampak', $rencana_tindak->dampak) == '1' ? 'selected' : '' }}>1 - Tidak Signifikan</option>
                                <option value="2" {{ old('dampak', $rencana_tindak->dampak) == '2' ? 'selected' : '' }}>2 - Minor</option>
                                <option value="3" {{ old('dampak', $rencana_tindak->dampak) == '3' ? 'selected' : '' }}>3 - Moderat</option>
                                <option value="4" {{ old('dampak', $rencana_tindak->dampak) == '4' ? 'selected' : '' }}>4 - Signifikan</option>
                                <option value="5" {{ old('dampak', $rencana_tindak->dampak) == '5' ? 'selected' : '' }}>5 - Sangat Signifikan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Level Risiko</label>
                        <input type="text" name="level_risiko" id="level_risiko" value="{{ old('level_risiko', $rencana_tindak->level_risiko) }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" readonly placeholder="Otomatis terisi...">
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
    const matrix = {
        5: { 1: 9, 2: 15, 3: 18, 4: 23, 5: 25 },
        4: { 1: 6, 2: 12, 3: 16, 4: 19, 5: 24 },
        3: { 1: 4, 2: 10, 3: 14, 4: 17, 5: 22 },
        2: { 1: 2, 2: 7, 3: 11, 4: 13, 5: 21 },
        1: { 1: 1, 2: 3, 3: 5, 4: 8, 5: 20 }
    };

    function getLevelInfo(score) {
        if (score >= 20) return { label: 'Sangat Tinggi (5)', class: 'bg-red-500/20 text-red-400 border-red-500/50' };
        if (score >= 16) return { label: 'Tinggi (4)', class: 'bg-orange-500/20 text-orange-400 border-orange-500/50' };
        if (score >= 12) return { label: 'Sedang (3)', class: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/50' };
        if (score >= 6) return { label: 'Rendah (2)', class: 'bg-green-500/20 text-green-400 border-green-500/50' };
        return { label: 'Sangat Rendah (1)', class: 'bg-blue-500/20 text-blue-400 border-blue-500/50' };
    }

    function calculateRisk() {
        const frekVal = document.getElementById('frekuensi').value;
        const dampVal = document.getElementById('dampak').value;
        const levelInput = document.getElementById('level_risiko');

        if (frekVal && dampVal) {
            const score = matrix[frekVal][dampVal];
            const info = getLevelInfo(score);
            levelInput.value = `${score} - ${info.label}`;
            levelInput.className = `w-full px-5 py-4 rounded-2xl border focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none font-bold text-sm ${info.class}`;
        } else {
            levelInput.className = 'w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none';
        }
    }

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
        calculateRisk();
        
        document.getElementById('frekuensi').addEventListener('change', calculateRisk);
        document.getElementById('dampak').addEventListener('change', calculateRisk);
    });
</script>
@endsection


