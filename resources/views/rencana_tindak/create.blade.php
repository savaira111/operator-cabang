@extends('layouts.app')

@section('title', 'Rencana Tindak Pengendalian')
@section('page_title', 'Rencana Tindak Pengendalian')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10 relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Rencana Tindak Pengendalian</h3>
                <p class="text-slate-500 text-sm mt-1">Tambahkan rencana tindak lanjut untuk risiko yang telah dianalisis.</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('rencana-tindak.index') }}" class="flex items-center justify-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('rencana-tindak.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-rose-500/20 z-20 row-number">1</div>
                
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Analisis Akar Masalah (Kode WP)</label>
                            <div class="relative group">
                                <select name="rows[0][resiko_id]" onchange="updateResikoInfo(this)" required class="resiko_id w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer appearance-none">
                                    <option value="" selected disabled hidden>-- Pilih Kode Laporan --</option>
                                    @foreach($resikos as $resiko)
                                        @php
                                            $identifikasi = \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $resiko->pernyataan_risiko)->first();
                                            $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                                        @endphp
                                        <option value="{{ $resiko->id }}" data-pernyataan="{{ $resiko->pernyataan_risiko }}" data-akar="{{ $resiko->akar_penyebab }}" data-kegiatan="{{ $resiko->kegiatan_pengendalian }}" data-kode="{{ $resiko->kode }}">{{ $kodeRisiko }} - {{ $resiko->kode }} ({{ Str::limit($resiko->pernyataan_risiko, 40) }})</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="resiko-preview hidden bg-[#0B1120] rounded-2xl p-6 border border-slate-800">
                            <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 border-b border-slate-800 pb-1">Detail Analisis</p>
                            <div class="space-y-2">
                                <div><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Akar Penyebab</p><p class="preview-akar text-xs font-bold text-white"></p></div>
                                <div><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Pengendalian</p><p class="preview-kegiatan text-xs font-bold text-white"></p></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Rencana Tindak Pengendalian</label>
                            <textarea name="rows[0][rencana_tindak]" required rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan rencana tindak pengendalian..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Respons Risiko</label>
                                <textarea name="rows[0][respons_risiko]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan respons risiko..."></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator Keluaran</label>
                                <textarea name="rows[0][indikator_keluaran]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan indikator keluaran..."></textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Klasifikasi Sub Unsur SPIP</label>
                                <input type="text" name="rows[0][klasifikasi_sub_unsur_spip]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Klasifikasi SPIP">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penanggung Jawab (PIC)</label>
                                <input type="text" name="rows[0][penanggung_jawab]" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Nama / Jabatan PIC">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target Waktu</label>
                                <input type="text" name="rows[0][waktu_pelaksanaan]" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Q3 2026">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Frekuensi</label>
                                <input type="text" name="rows[0][frekuensi]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: 1">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Dampak</label>
                                <input type="text" name="rows[0][dampak]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Tinggi">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Level Risiko</label>
                            <input type="text" name="rows[0][level_risiko]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: Sangat Tinggi">
                        </div>
                    </div>
                </div>

                <button type="button" onclick="removeRow(this)" class="remove-btn hidden absolute -right-4 top-8 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center hover:bg-rose-600 transition-all z-20 shadow-lg shadow-rose-500/20">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="pt-10 flex space-x-4 border-t border-slate-800 mt-12">
            <button type="submit" class="px-10 py-4 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-rose-500/20 active:scale-95 flex items-center gap-3">
                <i data-lucide="save" class="w-5 h-5"></i>
                <span>Simpan Semua Rencana</span>
            </button>
        </div>
    </form>
</div>

<script>
    let rowCount = 1;

    function updateRowNumbers() {
        document.querySelectorAll('.row-item').forEach((row, index) => {
            row.querySelector('.row-number').innerText = index + 1;
            const removeBtn = row.querySelector('.remove-btn');
            if (index === 0) {
                removeBtn.classList.add('hidden');
            } else {
                removeBtn.classList.remove('hidden');
            }
        });
    }

    function addRow() {
        const container = document.getElementById('rows-container');
        const rows = container.querySelectorAll('.row-item');
        const firstRow = rows[0];
        const newRow = firstRow.cloneNode(true);
        
        // Reset inputs
        newRow.querySelectorAll('input, select, textarea').forEach(input => {
            input.value = '';
            // Update name index
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/rows\[\d+\]/, `rows[${rowCount}]`));
            }
        });

        newRow.querySelector('.resiko-preview').classList.add('hidden');

        container.appendChild(newRow);
        rowCount++;
        updateRowNumbers();
        lucide.createIcons();
    }

    function removeRow(btn) {
        const row = btn.closest('.row-item');
        row.classList.add('animate-out', 'fade-out', 'zoom-out-95', 'duration-300');
        setTimeout(() => {
            row.remove();
            updateRowNumbers();
        }, 300);
    }

    function updateResikoInfo(element) {
        const row = element.closest('.row-item');
        const previewDiv = row.querySelector('.resiko-preview');
        const selectedOption = element.options[element.selectedIndex];
        
        if (element.value) {
            row.querySelector('.preview-akar').innerText = selectedOption.getAttribute('data-akar') || '-';
            row.querySelector('.preview-kegiatan').innerText = selectedOption.getAttribute('data-kegiatan') || '-';
            previewDiv.classList.remove('hidden');
        } else {
            previewDiv.classList.add('hidden');
        }
    }
</script>
@endsection
