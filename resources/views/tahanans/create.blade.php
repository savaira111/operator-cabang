@extends('layouts.app')

@section('title', 'Tambah Tahanan')
@section('page_title', 'Registrasi Tahanan Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Data Tahanan Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Lengkapi informasi biodata dan lokasi penahanan.</p>
        </div>
        <a href="{{ route('tahanans.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('tahanans.store') }}" method="POST">
        @csrf
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">ID Tahanan</label>
                    <div class="relative">
                        <input type="text" name="id_tahanan" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="T-001">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Nama lengkap sesuai KTP">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kasus / Perkara</label>
                    <input type="text" name="kasus" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Contoh: Pencurian">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penempatan Cabang</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white transition-all outline-none appearance-none cursor-pointer">
                        <option value="" class="bg-[#111827]">-- Pilih Lokasi --</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" class="bg-[#111827]">{{ $cabang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Status Tahanan</label>
                    <select name="status" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white transition-all outline-none appearance-none cursor-pointer">
                        <option value="aktif" class="bg-[#111827]">Aktif</option>
                        <option value="bebas" class="bg-[#111827]">Bebas</option>
                        <option value="pindah" class="bg-[#111827]">Pindah</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Catatan khusus mengenai tahanan..."></textarea>
            </div>
            
            <div class="pt-6">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 uppercase tracking-widest text-sm">
                    Simpan Data Tahanan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
