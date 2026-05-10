@extends('layouts.app')

@section('title', 'Create Rencana Kegiatan Belum Terealisasi')
@section('page_title', 'Rencana Belum Realisasi')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                <i data-lucide="calendar-x" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Rencana Kegiatan Belum Terealisasi</h3>
                <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mencatat rencana yang belum terlaksana.</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('rencana-belum-terealisasi.index') }}" class="flex items-center justify-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('rencana-belum-terealisasi.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-blue-500/20 z-20 row-number">1</div>
                
                <div class="space-y-8">
                    <div class="bg-slate-800/30 p-6 rounded-2xl border border-slate-700/50 mb-6">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pilih Kode (Filter 5)</label>
                        <div class="relative group">
                            <select name="rows[0][rencana_tindak_pengendalian_id]" onchange="updateRencanaInfo(this)" required class="rencana_tindak_pengendalian_id w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer appearance-none">
                                <option value="" selected disabled hidden>-- Pilih Kode --</option>
                                @foreach($rencanaTindaks as $rtp)
                                    @php
                                        $resiko = $rtp->resiko;
                                        $identifikasi = $resiko ? \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $resiko->pernyataan_risiko)->first() : null;
                                        $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                                    @endphp
                                    <option value="{{ $rtp->id }}"
                                        data-rencana="{{ $rtp->rencana_tindak }}"
                                        data-waktu="{{ $rtp->waktu_pelaksanaan }}"
                                        data-risiko="{{ $rtp->resiko->pernyataan_risiko }}"
                                        data-penyebab="{{ $rtp->resiko->kode_penyebab_jenis }}{{ $rtp->resiko->kode_penyebab_nomor }}"
                                        data-pj="{{ $rtp->penanggung_jawab }}"
                                    >
                                        [{{ $kodeRisiko }}] - {{ $rtp->resiko->kode }} - {{ Str::limit($rtp->rencana_tindak, 80) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-blue-400 transition-colors">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- READONLY PREVIEW -->
                    <div class="preview-container hidden grid grid-cols-1 md:grid-cols-2 gap-8 opacity-80">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Rencana Kegiatan</label>
                                <p class="ro_rencana text-sm text-slate-400 bg-slate-800/10 p-4 rounded-xl border border-slate-800 italic"></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Target Waktu</label>
                                    <p class="ro_waktu text-sm text-slate-400 bg-slate-800/10 p-4 rounded-xl border border-slate-800 italic text-center"></p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Kode Penyebab</label>
                                    <p class="ro_penyebab text-sm text-slate-400 bg-slate-800/10 p-4 rounded-xl border border-slate-800 italic text-center"></p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Pernyataan Risiko</label>
                                <p class="ro_risiko text-sm text-slate-400 bg-slate-800/10 p-4 rounded-xl border border-slate-800 italic"></p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1 italic">Penanggungjawab</label>
                                <p class="ro_pj text-sm text-slate-400 bg-slate-800/10 p-4 rounded-xl border border-slate-800 italic"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-500/5 p-8 rounded-[2rem] border border-blue-500/10">
                        <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-4 ml-1">Keterangan (Manual)</label>
                        <textarea name="rows[0][keterangan]" rows="4" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Berikan keterangan mengapa rencana ini belum terealisasi..."></textarea>
                    </div>
                </div>

                <button type="button" onclick="removeRow(this)" class="remove-btn hidden absolute -right-4 top-8 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center hover:bg-rose-600 transition-all z-20 shadow-lg shadow-rose-500/20">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="pt-10 flex space-x-4 border-t border-slate-800 mt-12">
            <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95 flex items-center gap-3">
                <i data-lucide="save" class="w-5 h-5"></i>
                <span>Simpan Semua Realisasi</span>
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

        newRow.querySelector('.preview-container').classList.add('hidden');

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

    function updateRencanaInfo(element) {
        const row = element.closest('.row-item');
        const previewDiv = row.querySelector('.preview-container');
        const opt = element.options[element.selectedIndex];
        
        if (element.value) {
            row.querySelector('.ro_rencana').innerText = opt.dataset.rencana || '';
            row.querySelector('.ro_waktu').innerText = opt.dataset.waktu || '';
            row.querySelector('.ro_risiko').innerText = opt.dataset.risiko || '';
            row.querySelector('.ro_penyebab').innerText = opt.dataset.penyebab || '';
            row.querySelector('.ro_pj').innerText = opt.dataset.pj || '';
            previewDiv.classList.remove('hidden');
        } else {
            previewDiv.classList.add('hidden');
        }
    }
</script>
@endsection
