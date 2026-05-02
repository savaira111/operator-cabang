@extends('layouts.app')

@section('title', 'Identifikasi Risiko')
@section('page_title', 'Perbarui Identifikasi Risiko')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                    <i data-lucide="shield-alert" class="w-6 h-6 md:w-7 md:h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black text-white tracking-tight">Perbarui Identifikasi Risiko</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Perbarui data laporan identifikasi risiko unit kerja.</p>
                </div>
            </div>
            <div class="flex items-center self-start sm:self-center px-4 py-2.5 bg-slate-800/80 rounded-2xl border border-slate-700/50 shrink-0">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">ID</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($identifikasi_risiko->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <a href="{{ route('identifikasi-risiko.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
    </div>

    <form action="{{ route('identifikasi-risiko.update', $identifikasi_risiko) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">

            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Risiko</label>
                    <input type="text" name="kode_risiko" value="{{ old('kode_risiko', $identifikasi_risiko->kode_risiko) }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: R-01">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Konteks</label>
                    <div class="relative group">
                        <select name="jenis_konteks" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="Sasaran Kegiatan" {{ old('jenis_konteks', $identifikasi_risiko->jenis_konteks) == 'Sasaran Kegiatan' ? 'selected' : '' }} class="bg-slate-900 text-white">Sasaran Kegiatan</option>
                            <option value="Program Kerja" {{ old('jenis_konteks', $identifikasi_risiko->jenis_konteks) == 'Program Kerja' ? 'selected' : '' }} class="bg-slate-900 text-white">Program Kerja</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-blue-400 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Konteks</label>
                    <input type="text" name="nama_konteks" value="{{ old('nama_konteks', $identifikasi_risiko->nama_konteks) }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Masukkan nama konteks...">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator</label>
                <textarea name="indikator" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan indikator...">{{ old('indikator', $identifikasi_risiko->indikator) }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                <textarea name="pernyataan_risiko" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan pernyataan risiko...">{{ old('pernyataan_risiko', $identifikasi_risiko->pernyataan_risiko) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kategori Risiko</label>
                    <div class="relative group">
                        <select name="kategori_risiko" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none appearance-none cursor-pointer">
                            <option value="Risiko Bencana" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Bencana' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Bencana</option>
                            <option value="Risiko Kebijakan" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Kebijakan' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Kebijakan</option>
                            <option value="Risiko Kecurangan" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Kecurangan' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Kecurangan</option>
                            <option value="Risiko Kepatuhan" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Kepatuhan' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Kepatuhan</option>
                            <option value="Risiko Operasional" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Operasional' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Operasional</option>
                            <option value="Risiko Pemangku Kepentingan" {{ old('kategori_risiko', $identifikasi_risiko->kategori_risiko) == 'Risiko Pemangku Kepentingan' ? 'selected' : '' }} class="bg-slate-900 text-white">Risiko Pemangku Kepentingan</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-blue-400 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Uraian Dampak</label>
                <textarea name="uraian_dampak" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan uraian dampak...">{{ old('uraian_dampak', $identifikasi_risiko->uraian_dampak) }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Metode Pencapaian Tujuan SPIP</label>
                <textarea name="metode_pencapaian_tujuan_spip" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan metode pencapaian...">{{ old('metode_pencapaian_tujuan_spip', $identifikasi_risiko->metode_pencapaian_tujuan_spip) }}</textarea>
            </div>

            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Perbarui Identifikasi Risiko
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
