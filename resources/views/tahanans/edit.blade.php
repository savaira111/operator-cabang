@extends('layouts.app')

@section('title', 'Edit Tahanan')
@section('page_title', 'Update Informasi Tahanan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Edit Data Tahanan</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui status hukum atau lokasi penempatan saat ini.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-3 bg-slate-800/80 rounded-2xl border border-slate-700/50">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">REF</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ $tahanan->id_tahanan }}</span>
            </div>
            <a href="{{ route('tahanans.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('tahanans.update', $tahanan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">ID Tahanan</label>
                    <input type="text" name="id_tahanan" value="{{ $tahanan->id_tahanan }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="T-001">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $tahanan->nama }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Nama lengkap sesuai KTP">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kasus / Perkara</label>
                    <input type="text" name="kasus" value="{{ $tahanan->kasus }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Contoh: Pencurian">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penempatan Cabang</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white transition-all outline-none appearance-none cursor-pointer">
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" {{ $tahanan->cabang_id == $cabang->id ? 'selected' : '' }} class="bg-[#111827]">{{ $cabang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="{{ $tahanan->tanggal_masuk }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Status Tahanan</label>
                    <select name="status" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white transition-all outline-none appearance-none cursor-pointer">
                        <option value="aktif" {{ $tahanan->status == 'aktif' ? 'selected' : '' }} class="bg-[#111827]">Aktif</option>
                        <option value="bebas" {{ $tahanan->status == 'bebas' ? 'selected' : '' }} class="bg-[#111827]">Bebas</option>
                        <option value="pindah" {{ $tahanan->status == 'pindah' ? 'selected' : '' }} class="bg-[#111827]">Pindah</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Catatan khusus mengenai tahanan...">{{ $tahanan->keterangan }}</textarea>
            </div>
            
            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase tracking-widest text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
