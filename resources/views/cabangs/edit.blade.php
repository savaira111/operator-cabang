@extends('layouts.app')

@section('title', 'Edit Cabang')
@section('page_title', 'Edit Data Cabang')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Edit Cabang</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi operasional kantor cabang.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-3 bg-slate-800/80 rounded-2xl border border-slate-700/50">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">ID</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($cabang->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <a href="{{ route('cabangs.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('cabangs.update', $cabang) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Cabang</label>
                    <input type="text" name="name" value="{{ $cabang->name }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Contoh: Cabang Jakarta Pusat">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kepala Cabang</label>
                    <input type="text" name="kepala_cabang" value="{{ $cabang->kepala_cabang }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Nama Lengkap Kepala Cabang">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Wilayah Operasional</label>
                <div class="relative group mt-2">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <i data-lucide="map-pin" class="w-4 h-4 text-indigo-500"></i>
                    </div>
                    <input type="text" name="location" value="Jawa Barat" readonly 
                        class="w-full pl-12 pr-5 py-4 bg-slate-800/30 rounded-2xl border border-slate-700/50 text-slate-400 font-bold focus:outline-none cursor-not-allowed transition-all"
                        placeholder="Wilayah Operasional">
                    <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none">
                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Fixed</span>
                    </div>
                </div>
                <p class="text-[10px] text-slate-600 mt-2 ml-1 italic">* Wilayah operasional saat ini terbatas hanya untuk area Jawa Barat.</p>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Masukkan alamat lengkap kantor cabang...">{{ $cabang->alamat }}</textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Deskripsi Tambahan</label>
                <textarea name="description" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Keterangan singkat mengenai operasional cabang...">{{ $cabang->description }}</textarea>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                    Update Cabang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
