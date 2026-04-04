@extends('layouts.app')

@section('title', 'Update Resiko')
@section('page_title', 'Update Analisis Resiko')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Update Resiko</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui analisis dan status mitigasi resiko operasional.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-3 bg-slate-800/80 rounded-2xl border border-slate-700/50">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">REF</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($resiko->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <a href="{{ route('resikos.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('resikos.update', $resiko) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Resiko / Isu</label>
                <input type="text" name="name" value="{{ $resiko->name }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Kebocoran Data Sesi">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Tingkat Status</label>
                    <select name="status" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="low" {{ $resiko->status == 'low' ? 'selected' : '' }}>Low (Rendah)</option>
                        <option value="medium" {{ $resiko->status == 'medium' ? 'selected' : '' }}>Medium (Sedang)</option>
                        <option value="high" {{ $resiko->status == 'high' ? 'selected' : '' }}>High (Tinggi)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Cabang Terdampak</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="">-- Pilih Cabang --</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" {{ $resiko->cabang_id == $cabang->id ? 'selected' : '' }}>{{ $cabang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Analisis / Detail Resiko</label>
                <textarea name="description" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Jelaskan dampak dan mitigasi resiko ini...">{{ $resiko->description }}</textarea>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-rose-500/20 active:scale-95">
                    Update Resiko
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
