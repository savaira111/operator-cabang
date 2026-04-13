@extends('layouts.app')

@section('title', 'Tambah Cabang')
@section('page_title', 'Tambah Cabang Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-2xl p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Tambah Cabang Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Registrasikan area operasional kantor cabang baru.</p>
        </div>
        <a href="{{ route('cabangs.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('cabangs.store') }}" method="POST">
        @csrf
        <div class="space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Cabang</label>
                    <input type="text" name="kode_cabang" value="{{ $nextCode }}" readonly required class="w-full px-5 py-4 bg-slate-800/30 rounded-2xl border border-slate-700/50 text-slate-400 font-bold focus:outline-none cursor-not-allowed transition-all">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Cabang</label>
                    <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Contoh: Cabang Bandung Raya">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kepala Cabang</label>
                    <input type="text" name="kepala_cabang" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Nama Lengkap Kepala Cabang">
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
                <textarea name="alamat" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Masukkan alamat lengkap kantor cabang..."></textarea>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Deskripsi Tambahan</label>
                <textarea name="description" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none" placeholder="Keterangan singkat mengenai operasional cabang..."></textarea>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                    Simpan Cabang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
