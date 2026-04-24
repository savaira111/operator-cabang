@extends('layouts.app')

@section('title', 'Edit Progres ZI')
@section('page_title', 'Update Progres ZI')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">EDIT PROGRES ZI</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui data pencapaian Zona Integritas.</p>
        </div>
        <a href="{{ route('zis.index') }}" class="p-3 bg-slate-800/50 text-slate-400 hover:text-white rounded-2xl border border-slate-700 hover:border-slate-500 transition-all">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
    </div>

    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/5 rounded-full blur-3xl"></div>
        
        <form action="{{ route('zis.update', $zi) }}" method="POST" class="relative z-10">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="cabang_id">Kantor Cabang / Satker</label>
                    <select name="cabang_id" id="cabang_id" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4 shadow-inner">
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" {{ old('cabang_id', $zi->cabang_id) == $cabang->id ? 'selected' : '' }}>{{ $cabang->kode_cabang }} - {{ $cabang->name }}</option>
                        @endforeach
                    </select>
                    @error('cabang_id') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="predikat">Predikat / Capaian</label>
                        <select name="predikat" id="predikat" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4">
                            <option value="WBK" {{ old('predikat', $zi->predikat) == 'WBK' ? 'selected' : '' }}>WBK</option>
                            <option value="WBBM" {{ old('predikat', $zi->predikat) == 'WBBM' ? 'selected' : '' }}>WBBM</option>
                            <option value="Menuju WBK" {{ old('predikat', $zi->predikat) == 'Menuju WBK' ? 'selected' : '' }}>Menuju WBK</option>
                            <option value="Menuju WBBM" {{ old('predikat', $zi->predikat) == 'Menuju WBBM' ? 'selected' : '' }}>Menuju WBBM</option>
                        </select>
                        @error('predikat') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="tahun">Tahun</label>
                        <input type="number" name="tahun" id="tahun" value="{{ old('tahun', $zi->tahun) }}" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4">
                        @error('tahun') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4">
                            <option value="B03" {{ old('bulan', $zi->bulan) == 'B03' ? 'selected' : '' }}>B03 (Maret)</option>
                            <option value="B06" {{ old('bulan', $zi->bulan) == 'B06' ? 'selected' : '' }}>B06 (Juni)</option>
                            <option value="B09" {{ old('bulan', $zi->bulan) == 'B09' ? 'selected' : '' }}>B09 (September)</option>
                            <option value="B12" {{ old('bulan', $zi->bulan) == 'B12' ? 'selected' : '' }}>B12 (Desember)</option>
                        </select>
                        @error('bulan') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="status">Status Progres</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 rounded-2xl border border-slate-800 bg-[#061B30] cursor-pointer hover:border-[#D2A039]/50 transition-all has-[:checked]:border-[#D2A039] has-[:checked]:bg-[#D2A039]/5">
                            <input type="radio" name="status" value="Aktif" class="hidden" {{ $zi->status == 'Aktif' ? 'checked' : '' }}>
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full border-2 border-[#D2A039] mr-3 flex items-center justify-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#D2A039]"></span>
                                </span>
                                <span class="text-xs font-bold text-slate-300">AKTIF</span>
                            </div>
                        </label>
                        <label class="relative flex items-center p-4 rounded-2xl border border-slate-800 bg-[#061B30] cursor-pointer hover:border-emerald-500/50 transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-500/5">
                            <input type="radio" name="status" value="Selesai" class="hidden" {{ $zi->status == 'Selesai' ? 'checked' : '' }}>
                            <div class="flex items-center">
                                <span class="w-4 h-4 rounded-full border-2 border-slate-700 mr-3"></span>
                                <span class="text-xs font-bold text-slate-300">SELESAI</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3" for="keterangan">Keterangan / Catatan</label>
                    <textarea name="keterangan" id="keterangan" rows="4" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4 shadow-inner">{{ old('keterangan', $zi->keterangan) }}</textarea>
                    @error('keterangan') <p class="text-rose-500 text-[10px] mt-2 font-bold uppercase tracking-tight">{{ $message }}</p> @enderror
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-5 bg-[#D2A039] hover:bg-[#b88a2e] text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 active:scale-95 uppercase text-xs tracking-widest flex items-center justify-center">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                        Update Data ZI
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
