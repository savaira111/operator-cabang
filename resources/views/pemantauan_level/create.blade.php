@extends('layouts.app')

@section('title', 'Create Pemantauan Level Risiko')
@section('page_title', 'Create Pemantauan Level')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Daftar Pemantauan Level Risiko</h3>
            <p class="text-slate-500 text-sm mt-1">Formulir pemantauan tingkat risiko yang direspons dan aktual.</p>
        </div>
        <div class="flex gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('pemantauan-level.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('pemantauan-level.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-blue-500/20 z-20 row-number">1</div>
                
                <div class="space-y-6">
                    <div class="border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20 mb-6">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Pernyataan Risiko (Filter 2)</label>
                        <div class="relative group">
                            <select name="rows[0][analisis_risiko_id]" onchange="updateARInfo(this)" required class="analisis_risiko_id w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer appearance-none">
                                <option value="" selected disabled hidden>-- Pilih Pernyataan Risiko --</option>
                                @foreach($analisisRisikos as $ar)
                                    <option value="{{ $ar->id }}" 
                                        data-frekuensi="{{ $ar->frekuensi }}"
                                        data-dampak="{{ $ar->dampak }}"
                                        data-nilai="{{ $ar->level_risiko ?? '-' }}"
                                        data-f_aktual="{{ $ar->skor_probabilitas_residu }}"
                                        data-d_aktual="{{ $ar->skor_dampak_residu }}"
                                        data-n_aktual="{{ $ar->level_risiko_residu ?? '-' }}"
                                    >
                                        [{{ $ar->identifikasiRisiko->kode_risiko ?? '-' }}] - {{ Str::limit($ar->identifikasiRisiko->pernyataan_risiko, 100) }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-blue-400 transition-colors">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- AUTO-FILL PREVIEW -->
                    <div class="preview-container hidden grid grid-cols-1 md:grid-cols-2 gap-8 opacity-80">
                        <div class="bg-slate-900/40 p-6 rounded-3xl border border-slate-800/60">
                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4 pb-2 border-b border-slate-800">Risiko yang Direspons</h4>
                            <div class="grid grid-cols-3 gap-4">
                                <div><label class="block text-[9px] font-bold text-slate-600 uppercase mb-1">F</label><p class="ro_f text-xs font-bold text-white text-center"></p></div>
                                <div><label class="block text-[9px] font-bold text-slate-600 uppercase mb-1">D</label><p class="ro_d text-xs font-bold text-white text-center"></p></div>
                                <div><label class="block text-[9px] font-bold text-slate-600 uppercase mb-1">Nilai</label><p class="ro_n text-xs font-black text-emerald-400 text-center"></p></div>
                            </div>
                        </div>
                        <div class="bg-blue-500/5 p-6 rounded-3xl border border-blue-500/10">
                            <h4 class="text-[10px] font-black text-blue-400/60 uppercase tracking-widest mb-4 pb-2 border-b border-blue-500/10">Level Risiko Aktual</h4>
                            <div class="grid grid-cols-3 gap-4">
                                <div><label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-1">F</label><p class="ro_f_akt text-xs font-bold text-blue-400 text-center"></p></div>
                                <div><label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-1">D</label><p class="ro_d_akt text-xs font-bold text-blue-400 text-center"></p></div>
                                <div><label class="block text-[9px] font-bold text-blue-400/40 uppercase mb-1">Nilai</label><p class="ro_n_akt text-xs font-black text-blue-400 text-center"></p></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Deviasi</label>
                            <textarea name="rows[0][deviasi]" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Tuliskan deviasi jika ada..."></textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-3 ml-1">Rekomendasi</label>
                            <textarea name="rows[0][rekomendasi]" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan rekomendasi tindakan..."></textarea>
                        </div>
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
                <span>Simpan Semua Pemantauan</span>
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

    function updateARInfo(element) {
        const row = element.closest('.row-item');
        const previewDiv = row.querySelector('.preview-container');
        const opt = element.options[element.selectedIndex];
        
        if (element.value) {
            row.querySelector('.ro_f').innerText = opt.dataset.frekuensi || '-';
            row.querySelector('.ro_d').innerText = opt.dataset.dampak || '-';
            row.querySelector('.ro_n').innerText = opt.dataset.nilai || '-';
            
            row.querySelector('.ro_f_akt').innerText = opt.dataset.f_aktual || '-';
            row.querySelector('.ro_d_akt').innerText = opt.dataset.d_aktual || '-';
            row.querySelector('.ro_n_akt').innerText = opt.dataset.n_aktual || '-';
            
            previewDiv.classList.remove('hidden');
        } else {
            previewDiv.classList.add('hidden');
        }
    }
</script>
@endsection
