@extends('layouts.app')

@section('title', 'Identifikasi Risiko')
@section('page_title', 'Identifikasi Risiko Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                <i data-lucide="shield-alert" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Identifikasi Risiko</h3>
                <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mengidentifikasi risiko pada unit kerja.</p>
            </div>
        </div>
        
        <a href="{{ route('identifikasi-risiko.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
    </div>

    <form action="{{ route('identifikasi-risiko.store') }}" method="POST">
        @csrf
        <div class="space-y-6">

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Kode Risiko</label>
                    <select id="kode_risiko_jenis" onchange="updateKodeRisiko()" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih kode risiko...</option>
                        @foreach($master_risikos as $master)
                            <option value="{{ $master->kode }}" class="bg-slate-900 text-white">{{ $master->kode }} - {{ $master->nama_risiko }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nomor Kode Risiko</label>
                    <input type="number" id="kode_risiko_nomor" oninput="updateKodeRisiko()" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: 1">
                </div>
            </div>
            <input type="hidden" name="kode_risiko" id="kode_risiko_hidden">
            <script>
                function updateKodeRisiko() {
                    const jenis = document.getElementById('kode_risiko_jenis').value;
                    const nomor = document.getElementById('kode_risiko_nomor').value;
                    if (jenis && nomor) {
                        document.getElementById('kode_risiko_hidden').value = jenis + '.' + nomor;
                    } else if (jenis) {
                        document.getElementById('kode_risiko_hidden').value = jenis;
                    } else {
                        document.getElementById('kode_risiko_hidden').value = '';
                    }
                }
            </script>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Konteks</label>
                    <div class="relative group">
                        <select name="jenis_konteks" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih jenis konteks...</option>
                            <option value="Sasaran Kegiatan" class="bg-slate-900 text-white">Sasaran Kegiatan</option>
                            <option value="Program Kerja" class="bg-slate-900 text-white">Program Kerja</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Konteks</label>
                    <input type="text" name="nama_konteks" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Masukkan nama konteks...">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator</label>
                <textarea name="indikator" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan indikator..."></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                <textarea name="pernyataan_risiko" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan pernyataan risiko..."></textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kategori Risiko</label>
                    <div class="relative group">
                        <select name="kategori_risiko" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih kategori risiko...</option>
                            <option value="Risiko Bencana" class="bg-slate-900 text-white">Risiko Bencana</option>
                            <option value="Risiko Kebijakan" class="bg-slate-900 text-white">Risiko Kebijakan</option>
                            <option value="Risiko Kecurangan" class="bg-slate-900 text-white">Risiko Kecurangan</option>
                            <option value="Risiko Kepatuhan" class="bg-slate-900 text-white">Risiko Kepatuhan</option>
                            <option value="Risiko Operasional" class="bg-slate-900 text-white">Risiko Operasional</option>
                            <option value="Risiko Pemangku Kepentingan" class="bg-slate-900 text-white">Risiko Pemangku Kepentingan</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Uraian Dampak</label>
                <textarea name="uraian_dampak" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan uraian dampak..."></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Metode Pencapaian Tujuan SPIP</label>
                <textarea name="metode_pencapaian_tujuan_spip" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan metode pencapaian..."></textarea>
            </div>

            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-rose-500/20 active:scale-95">
                    Simpan Identifikasi Risiko
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
