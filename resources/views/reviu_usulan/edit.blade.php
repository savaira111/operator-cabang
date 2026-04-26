@extends('layouts.app')

@section('title', 'Edit Reviu Usulan Risiko')
@section('page_title', 'Edit Reviu Usulan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Edit Reviu Usulan Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui data reviu usulan risiko.</p>
        </div>
        <a href="{{ route('reviu-usulan.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('reviu-usulan.update', $reviuUsulan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Risiko (Filter 4)</label>
                        <select name="resiko_id" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                            @foreach($resikos as $r)
                                <option value="{{ $r->id }}" {{ $reviuUsulan->resiko_id == $r->id ? 'selected' : '' }}>{{ $r->kode }} - {{ Str::limit($r->pernyataan_risiko, 50) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Usulan Pernyataan Risiko</label>
                        <textarea name="usulan_pernyataan_risiko" rows="4" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none">{{ $reviuUsulan->usulan_pernyataan_risiko }}</textarea>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Unit Pemilik Risiko Pengusul (Pegawai)</label>
                        <input type="text" name="unit_pemilik_pengusul" value="{{ $reviuUsulan->unit_pemilik_pengusul }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Status Reviu</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex items-center justify-center p-4 bg-slate-800/30 rounded-2xl border-2 border-transparent cursor-pointer transition-all hover:bg-emerald-500/5 has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/10 group">
                                <input type="radio" name="status" value="Diterima" class="hidden" {{ $reviuUsulan->status == 'Diterima' ? 'checked' : '' }} onchange="toggleAlasan()">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-slate-600 group-hover:text-emerald-400 transition-colors"></i>
                                    <span class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-emerald-400">Diterima</span>
                                </div>
                            </label>
                            <label class="relative flex items-center justify-center p-4 bg-slate-800/30 rounded-2xl border-2 border-transparent cursor-pointer transition-all hover:bg-rose-500/5 has-[:checked]:border-rose-500/50 has-[:checked]:bg-rose-500/10 group">
                                <input type="radio" name="status" value="Ditolak" class="hidden" {{ $reviuUsulan->status == 'Ditolak' ? 'checked' : '' }} onchange="toggleAlasan()">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="x-circle" class="w-5 h-5 text-slate-600 group-hover:text-rose-400 transition-colors"></i>
                                    <span class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-rose-400">Ditolak</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div id="alasan_diterima_group">
                    <label class="block text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-3 ml-1">Alasan Jika Diterima (Opsional)</label>
                    <textarea name="alasan_diterima" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none">{{ $reviuUsulan->alasan_diterima }}</textarea>
                </div>
                <div id="alasan_ditolak_group">
                    <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Alasan Jika Ditolak</label>
                    <textarea name="alasan_ditolak" id="alasan_ditolak_field" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none">{{ $reviuUsulan->alasan_ditolak }}</textarea>
                </div>
            </div>
            
            <div class="pt-6 flex space-x-4 border-t border-slate-800/60 mt-8">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Perbarui Reviu Usulan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleAlasan() {
        const status = document.querySelector('input[name="status"]:checked').value;
        const diterimaGroup = document.getElementById('alasan_diterima_group');
        const ditolakGroup = document.getElementById('alasan_ditolak_group');
        const ditolakField = document.getElementById('alasan_ditolak_field');

        if (status === 'Diterima') {
            diterimaGroup.classList.remove('hidden');
            ditolakGroup.classList.add('hidden');
            ditolakField.removeAttribute('required');
        } else {
            diterimaGroup.classList.add('hidden');
            ditolakGroup.classList.remove('hidden');
            ditolakField.setAttribute('required', 'required');
        }
    }
    
    document.addEventListener('DOMContentLoaded', toggleAlasan);
</script>
@endsection
