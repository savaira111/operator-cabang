@extends('layouts.app')

@section('title', 'Perbarui Laporan Pengendalian')
@section('page_title', 'Perbarui Analisis Pengendalian')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                    <i data-lucide="shield-check" class="w-6 h-6 md:w-7 md:h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black text-white tracking-tight">Perbarui Laporan Pengendalian</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Perbarui analisis dan status pengendalian internal operasional.</p>
                </div>
            </div>
            <div class="flex items-center self-start sm:self-center px-4 py-2.5 bg-slate-800/80 rounded-2xl border border-slate-700/50 shrink-0">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">REF</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($resiko->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <a href="{{ route('resikos.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
    </div>

    <form action="{{ route('resikos.update', $resiko) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">


            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                <select name="pernyataan_risiko" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                    <option value="" disabled hidden>-- Pilih Risiko Prioritas --</option>
                    @foreach($analisis_risikos as $analisis)
                        @if($analisis->identifikasiRisiko)
                            <option value="{{ $analisis->identifikasiRisiko->pernyataan_risiko }}" {{ ($resiko->pernyataan_risiko ?? $resiko->name) == $analisis->identifikasiRisiko->pernyataan_risiko ? 'selected' : '' }}>
                                [{{ $analisis->identifikasiRisiko->kode_risiko ?? '-' }}] {{ $analisis->identifikasiRisiko->pernyataan_risiko }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why 1</label>
                    <input type="text" name="why_1" value="{{ $resiko->why_1 }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why 2</label>
                    <input type="text" name="why_2" value="{{ $resiko->why_2 }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why 3</label>
                    <input type="text" name="why_3" value="{{ $resiko->why_3 }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why 4</label>
                    <input type="text" name="why_4" value="{{ $resiko->why_4 }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why 5</label>
                    <input type="text" name="why_5" value="{{ $resiko->why_5 }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Akar Penyebab</label>
                <input type="text" name="akar_penyebab" value="{{ $resiko->akar_penyebab }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Masukkan akar penyebab...">
            </div>

            <div class="grid grid-cols-2 gap-6 border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Kode Penyebab</label>
                    <select name="kode_penyebab_jenis" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                        <option value="" selected disabled hidden>-- Pilih Jenis --</option>
                        <option value="MN" {{ $resiko->kode_penyebab_jenis == 'MN' ? 'selected' : '' }}>Orang (Man) : MN</option>
                        <option value="MY" {{ $resiko->kode_penyebab_jenis == 'MY' ? 'selected' : '' }}>Dana (Money) : MY</option>
                        <option value="MD" {{ $resiko->kode_penyebab_jenis == 'MD' ? 'selected' : '' }}>Metode (Method) : MD</option>
                        <option value="MR" {{ $resiko->kode_penyebab_jenis == 'MR' ? 'selected' : '' }}>Bahan (Material) : MR</option>
                        <option value="MC" {{ $resiko->kode_penyebab_jenis == 'MC' ? 'selected' : '' }}>Mesin (Machine) : MC</option>
                        <option value="EX" {{ $resiko->kode_penyebab_jenis == 'EX' ? 'selected' : '' }}>Eksternal : EX</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nomor Kode Penyebab</label>
                    <input type="number" name="kode_penyebab_nomor" value="{{ $resiko->kode_penyebab_nomor }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: 1">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kegiatan Pengendalian</label>
                <textarea name="kegiatan_pengendalian" required rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan kegiatan pengendalian...">{{ $resiko->kegiatan_pengendalian ?? $resiko->description }}</textarea>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-rose-500/20 active:scale-95">
                    Perbarui Laporan Pengendalian
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
