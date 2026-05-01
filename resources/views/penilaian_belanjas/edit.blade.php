@extends('layouts.app')

@section('title', 'Isi Penilaian Anggaran')
@section('page_title', 'Evaluasi Penyerapan Anggaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">PENILAIAN ANGGARAN</h3>
            <p class="text-slate-500 text-sm mt-1">Berikan evaluasi terhadap realisasi penyerapan anggaran.</p>
        </div>
        <a href="{{ route('penilaian-belanja.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
        </a>
    </div>

    <!-- Metadata View Only -->
    <div class="bg-emerald-500/5 border border-emerald-500/20 rounded-[2rem] p-8 mb-8">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Kantor Cabang</p>
                <p class="text-sm font-bold text-white">{{ $belanjaSatker->cabang->name }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Periode</p>
                <p class="text-sm font-bold text-white">{{ $belanjaSatker->bulan }} {{ $belanjaSatker->tahun }}</p>
            </div>
            <div class="pt-4 border-t border-emerald-500/10">
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-1">Total Realisasi</p>
                <p class="text-lg font-black text-white">Rp {{ number_format($belanjaSatker->total, 0, ',', '.') }}</p>
            </div>
            <div class="pt-4 border-t border-emerald-500/10">
                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mb-2">Dokumen Pendukung</p>
                @if($belanjaSatker->dokumen_path)
                    <a href="{{ Storage::url($belanjaSatker->dokumen_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-[#061B30] rounded-xl text-xs font-bold hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                        <i data-lucide="external-link" class="w-3.5 h-3.5 mr-2"></i>
                        Buka Dokumen
                    </a>
                @else
                    <p class="text-slate-500 text-xs italic">Tidak ada dokumen</p>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <form action="{{ route('penilaian-belanja.update', $belanjaSatker) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Status Evaluasi -->
                <div class="md:col-span-1">
                    <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest mb-3 ml-1">Status Evaluasi</label>
                    <div class="relative group">
                        <select name="status_evaluasi" id="status_evaluasi" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none appearance-none cursor-pointer" onchange="updateProsentase()">
                            <option value="belum_dievaluasi" {{ $belanjaSatker->status_evaluasi == 'belum_dievaluasi' ? 'selected' : '' }}>Belum Dievaluasi</option>
                            <option value="menunggu" {{ $belanjaSatker->status_evaluasi == 'menunggu' ? 'selected' : '' }}>Menunggu Evaluasi</option>
                            <option value="sesuai" {{ $belanjaSatker->status_evaluasi == 'sesuai' ? 'selected' : '' }}>Sesuai (Diterima)</option>
                            <option value="tidak_sesuai" {{ $belanjaSatker->status_evaluasi == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500 group-hover:text-amber-500 transition-colors">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Progres Capaian -->
                <div class="md:col-span-1">
                    <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest mb-3 ml-1">Progres Capaian (%)</label>
                    <div class="relative">
                        <input type="number" name="prosentase" id="prosentase" min="0" max="100" value="{{ $belanjaSatker->prosentase ?? 0 }}" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none pl-14 font-black">
                        <span class="absolute left-6 top-[1.1rem] text-slate-500 font-black text-sm">%</span>
                    </div>
                </div>

                <!-- Catatan Evaluasi -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest mb-3 ml-1">Catatan / Feedback Evaluasi</label>
                    <textarea name="catatan_evaluasi" rows="4" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none resize-none" placeholder="Masukkan catatan atau alasan jika tidak sesuai...">{{ $belanjaSatker->catatan_evaluasi }}</textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-amber-500 hover:bg-amber-600 text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-amber-500/20 active:scale-95 uppercase text-xs tracking-widest flex items-center justify-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Penilaian Anggaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateProsentase() {
    const status = document.getElementById('status_evaluasi').value;
    const prosentaseInput = document.getElementById('prosentase');
    
    const map = {
        'belum_dievaluasi': 0,
        'menunggu': 50,
        'sesuai': 100,
        'tidak_sesuai': 25
    };
    
    if (map.hasOwnProperty(status)) {
        prosentaseInput.value = map[status];
    }
}
</script>
@endsection
