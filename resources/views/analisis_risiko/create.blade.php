@extends('layouts.app')

@section('title', 'Analisis Risiko')
@section('page_title', 'Analisis Risiko Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Analisis Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk menganalisis risiko yang telah diidentifikasi.</p>
        </div>
        <a href="{{ route('analisis-risiko.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('analisis-risiko.store') }}" method="POST">
        @csrf
        <div class="space-y-10">
            <!-- SECTION 1: IDENTIFIKASI -->
            <div class="space-y-6">
                <h4 class="text-xs font-black text-blue-400 uppercase tracking-[0.2em] flex items-center">
                    <span class="w-8 h-px bg-blue-500/30 mr-3"></span>
                    1. Referensi Identifikasi
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Risiko (Dari Tabel 1)</label>
                        <select name="identifikasi_risiko_id" id="identifikasi_risiko_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Kode Risiko --</option>
                            @foreach($identifikasi_risikos as $risiko)
                                <option value="{{ $risiko->id }}" data-pernyataan="{{ $risiko->pernyataan_risiko }}">{{ $risiko->kode_risiko }} - {{ Str::limit($risiko->pernyataan_risiko, 50) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                        <div id="pernyataan_preview" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-800 text-slate-400 text-sm min-h-[58px] flex items-center italic">
                            Pilih kode risiko untuk melihat pernyataan...
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: RISIKO MELEKAT -->
            <div class="space-y-6">
                <h4 class="text-xs font-black text-blue-400 uppercase tracking-[0.2em] flex items-center">
                    <span class="w-8 h-px bg-blue-500/30 mr-3"></span>
                    2. Skor Risiko yang Melekat
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Skor Probabilitas (Melekat)</label>
                        <select name="frekuensi" id="frekuensi" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Probabilitas --</option>
                            <option value="1">1 - Hampir tidak terjadi</option>
                            <option value="2">2 - Jarang terjadi</option>
                            <option value="3">3 - Kadang terjadi</option>
                            <option value="4">4 - Sering terjadi</option>
                            <option value="5">5 - Hampir pasti terjadi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Skor Dampak (Melekat)</label>
                        <select name="dampak" id="dampak" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Dampak --</option>
                            <option value="1">1 - Tidak Signifikan</option>
                            <option value="2">2 - Minor</option>
                            <option value="3">3 - Moderat</option>
                            <option value="4">4 - Signifikan</option>
                            <option value="5">5 - Sangat Signifikan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Level Risiko (Melekat)</label>
                        <input type="text" name="level_risiko" id="level_risiko" readonly class="w-full px-5 py-4 bg-slate-800/30 rounded-2xl border border-slate-700 text-white focus:ring-0 outline-none font-bold" placeholder="Otomatis terisi...">
                    </div>
                </div>
            </div>

            <!-- SECTION 3: PENGENDALIAN -->
            <div class="space-y-6">
                <h4 class="text-xs font-black text-blue-400 uppercase tracking-[0.2em] flex items-center">
                    <span class="w-8 h-px bg-blue-500/30 mr-3"></span>
                    3. Pengendalian yang Ada
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Ada / Belum Ada</label>
                        <select name="ada_belum_ada" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="Ada">Ada</option>
                            <option value="Belum Ada">Belum Ada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Memadai / Belum Memadai</label>
                        <select name="memadai_belum_memadai" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="Memadai">Memadai</option>
                            <option value="Belum Memadai">Belum Memadai</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Uraian Pengendalian</label>
                        <textarea name="uraian_pengendalian" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan uraian pengendalian..."></textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: RISIKO RESIDU -->
            <div class="space-y-6">
                <h4 class="text-xs font-black text-blue-400 uppercase tracking-[0.2em] flex items-center">
                    <span class="w-8 h-px bg-blue-500/30 mr-3"></span>
                    4. Skor Risiko Residu (Setelah Pengendalian)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Skor Probabilitas (Residu)</label>
                        <select name="skor_probabilitas_residu" id="skor_probabilitas_residu" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Probabilitas --</option>
                            <option value="1">1 - Hampir tidak terjadi</option>
                            <option value="2">2 - Jarang terjadi</option>
                            <option value="3">3 - Kadang terjadi</option>
                            <option value="4">4 - Sering terjadi</option>
                            <option value="5">5 - Hampir pasti terjadi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Skor Dampak (Residu)</label>
                        <select name="skor_dampak_residu" id="skor_dampak_residu" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            <option value="" selected disabled hidden>-- Pilih Dampak --</option>
                            <option value="1">1 - Tidak Signifikan</option>
                            <option value="2">2 - Minor</option>
                            <option value="3">3 - Moderat</option>
                            <option value="4">4 - Signifikan</option>
                            <option value="5">5 - Sangat Signifikan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Level Risiko (Residu)</label>
                        <input type="text" name="level_risiko_residu" id="level_risiko_residu" readonly class="w-full px-5 py-4 bg-slate-800/30 rounded-2xl border border-slate-700 text-white focus:ring-0 outline-none font-bold" placeholder="Otomatis terisi...">
                    </div>
                </div>
            </div>

            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Simpan Analisis Risiko
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('identifikasi_risiko_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const pernyataan = selectedOption.getAttribute('data-pernyataan');
    document.getElementById('pernyataan_preview').innerText = pernyataan || 'Tidak ada pernyataan risiko.';
    document.getElementById('pernyataan_preview').classList.remove('italic');
});

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

function calculateRisk(probId, impactId, resultId) {
    const prob = document.getElementById(probId).value;
    const impact = document.getElementById(impactId).value;
    const resultInput = document.getElementById(resultId);

    if (prob && impact) {
        const score = matrix[prob][impact];
        const info = getLevelInfo(score);
        resultInput.value = `${score} - ${info.label}`;
        
        // Remove existing color classes
        resultInput.classList.remove('bg-red-500/20', 'text-red-400', 'border-red-500/50', 
                                   'bg-orange-500/20', 'text-orange-400', 'border-orange-500/50',
                                   'bg-yellow-500/20', 'text-yellow-400', 'border-yellow-500/50',
                                   'bg-green-500/20', 'text-green-400', 'border-green-500/50',
                                   'bg-blue-500/20', 'text-blue-400', 'border-blue-500/50',
                                   'bg-slate-800/30', 'text-white', 'border-slate-700');
        
        // Add new classes
        const classes = info.class.split(' ');
        resultInput.classList.add(...classes);
        resultInput.classList.add('border');
    }
}

document.getElementById('frekuensi').addEventListener('change', () => calculateRisk('frekuensi', 'dampak', 'level_risiko'));
document.getElementById('dampak').addEventListener('change', () => calculateRisk('frekuensi', 'dampak', 'level_risiko'));
document.getElementById('skor_probabilitas_residu').addEventListener('change', () => calculateRisk('skor_probabilitas_residu', 'skor_dampak_residu', 'level_risiko_residu'));
document.getElementById('skor_dampak_residu').addEventListener('change', () => calculateRisk('skor_probabilitas_residu', 'skor_dampak_residu', 'level_risiko_residu'));
</script>
@endsection
