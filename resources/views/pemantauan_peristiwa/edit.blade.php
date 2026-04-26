@extends('layouts.app')

@section('title', 'Perbarui Pemantauan Peristiwa')
@section('page_title', 'Perbarui Pemantauan Peristiwa')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Perbarui Pemantauan Peristiwa</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui hasil pemantauan peristiwa yang terjadi.</p>
        </div>
        <a href="{{ route('pemantauan-peristiwa.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('pemantauan-peristiwa.update', $pemantauanPeristiwa) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">

            <!-- SELECT KODE & KODE PENYEBAB (READONLY IN EDIT) -->
            <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6 opacity-80 pointer-events-none">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Data Pemantauan (Kode & Kode Penyebab)</label>
                <select name="pemantauan_kegiatan_id" id="pemantauan_kegiatan_id" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white outline-none" readonly>
                    @foreach($pemantauanKegiatans as $kegiatan)
                        @php
                            $resiko = $kegiatan->rencanaTindak->resiko;
                            $kodePenyebab = ($resiko->kode_penyebab_jenis ?? '-') . '.' . ($resiko->kode_penyebab_nomor ?? '-');
                        @endphp
                        <option value="{{ $kegiatan->id }}" {{ $pemantauanPeristiwa->pemantauan_kegiatan_id == $kegiatan->id ? 'selected' : '' }}>
                            [{{ $resiko->kode ?? '-' }} | {{ $kodePenyebab }}] - {{ Str::limit($resiko->pernyataan_risiko, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- READONLY FIELDS -->
            @php
                $currentResiko = $pemantauanPeristiwa->pemantauanKegiatan->rencanaTindak->resiko;
                $currentKodePenyebab = ($currentResiko->kode_penyebab_jenis ?? '-') . '.' . ($currentResiko->kode_penyebab_nomor ?? '-');
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-80 pointer-events-none">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode</label>
                    <input type="text" value="{{ $currentResiko->kode ?? '-' }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none font-bold text-emerald-400" readonly>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Penyebab</label>
                    <input type="text" value="{{ $currentKodePenyebab }}" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none font-bold text-emerald-400" readonly>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                    <textarea rows="2" class="w-full px-5 py-4 bg-slate-900/50 rounded-2xl border border-slate-700/50 text-slate-400 outline-none resize-none" readonly>{{ $currentResiko->pernyataan_risiko ?? '-' }}</textarea>
                </div>
            </div>

            <!-- INPUT FIELDS FOR FILTER 7 -->
            <div class="border border-blue-500/20 p-6 rounded-2xl bg-blue-500/5 mt-8 space-y-6">
                
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Uraian Peristiwa</label>
                    <textarea name="uraian_peristiwa" required rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan uraian peristiwa yang terjadi...">{{ $pemantauanPeristiwa->uraian_peristiwa }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Waktu Kejadian</label>
                        <input type="text" name="waktu_kejadian" value="{{ $pemantauanPeristiwa->waktu_kejadian }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: 15 Agustus 2026">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Tempat Kejadian</label>
                        <input type="text" name="tempat_kejadian" value="{{ $pemantauanPeristiwa->tempat_kejadian }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: Ruang Server">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Skor Dampak (1 - 5)</label>
                        <select name="skor_dampak" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-rose-500/30 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer">
                            @for($i=1; $i<=5; $i++)
                                <option value="{{ $i }}" {{ $pemantauanPeristiwa->skor_dampak == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Pemicu Peristiwa</label>
                        <input type="text" name="pemicu_peristiwa" value="{{ $pemantauanPeristiwa->pemicu_peristiwa }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-blue-500/30 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Penyebab memicunya peristiwa ini...">
                    </div>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Perbarui Peristiwa Risiko
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
