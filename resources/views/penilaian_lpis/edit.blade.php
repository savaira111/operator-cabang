@extends('layouts.app')

@section('title', 'Isi Penilaian LPI')
@section('page_title', 'Evaluasi Identifikasi Risiko')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10 relative z-10">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 shrink-0">
                <i data-lucide="clipboard-check" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-3xl font-black text-white tracking-tighter uppercase">PENILAIAN LPI</h3>
                <p class="text-slate-500 text-sm mt-1">Berikan evaluasi terhadap data identifikasi risiko (Laporan Internal).</p>
            </div>
        </div>
        
        <a href="{{ route('penilaian-lpi.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
    </div>

    <!-- Metadata View Only -->
    <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-[2rem] p-8 mb-8">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Kantor Cabang</p>
                <p class="text-sm font-bold text-white">{{ $identifikasi_risiko->cabang->name ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Kode Risiko</p>
                <p class="text-sm font-bold text-white">{{ $identifikasi_risiko->kode_risiko ?? '-' }}</p>
            </div>
            <div class="col-span-2 pt-4 border-t border-indigo-500/10">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Pernyataan Risiko</p>
                <p class="text-sm text-slate-300 leading-relaxed">{{ $identifikasi_risiko->pernyataan_risiko }}</p>
            </div>
            <div class="pt-4 border-t border-indigo-500/10">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Kategori Risiko</p>
                <p class="text-xs font-bold text-slate-400">{{ $identifikasi_risiko->kategori_risiko ?? '-' }}</p>
            </div>
            <div class="pt-4 border-t border-indigo-500/10">
                <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Metode SPIP</p>
                <p class="text-xs font-bold text-slate-400">{{ $identifikasi_risiko->metode_pencapaian_tujuan_spip ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <form action="{{ route('penilaian-lpi.update', $identifikasi_risiko) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Status Evaluasi -->
                <div class="md:col-span-1">
                    <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest mb-3 ml-1">Status Evaluasi</label>
                    <div class="relative group">
                        <select name="status_evaluasi" id="status_evaluasi" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none appearance-none cursor-pointer" onchange="updateProsentase()">
                            <option value="belum_dievaluasi" {{ $identifikasi_risiko->status_evaluasi == 'belum_dievaluasi' ? 'selected' : '' }}>Belum Dievaluasi</option>
                            <option value="menunggu" {{ $identifikasi_risiko->status_evaluasi == 'menunggu' ? 'selected' : '' }}>Menunggu Evaluasi</option>
                            <option value="sesuai" {{ $identifikasi_risiko->status_evaluasi == 'sesuai' ? 'selected' : '' }}>Sesuai (Diterima)</option>
                            <option value="tidak_sesuai" {{ $identifikasi_risiko->status_evaluasi == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
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
                        <input type="number" name="prosentase" id="prosentase" min="0" max="100" value="{{ $identifikasi_risiko->prosentase ?? 0 }}" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none pl-14 font-black">
                        <span class="absolute left-6 top-[1.1rem] text-slate-500 font-black text-sm">%</span>
                    </div>
                </div>

                <!-- Catatan Evaluasi -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-amber-500/70 uppercase tracking-widest mb-3 ml-1">Catatan / Feedback Evaluasi</label>
                    <textarea name="catatan_evaluasi" rows="4" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none resize-none" placeholder="Masukkan catatan atau alasan jika tidak sesuai...">{{ $identifikasi_risiko->catatan_evaluasi }}</textarea>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full py-5 bg-amber-500 hover:bg-amber-600 text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-amber-500/20 active:scale-95 uppercase text-xs tracking-widest flex items-center justify-center">
                    <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                    Simpan Penilaian LPI
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
