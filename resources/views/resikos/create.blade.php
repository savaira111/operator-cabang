@extends('layouts.app')

@section('title', 'Laporan Pengendalian Internal')
@section('page_title', 'Identifikasi Pengendalian Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                <i data-lucide="shield-check" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Identifikasi Pengendalian</h3>
                <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk melaporkan pengendalian internal operasional.</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('resikos.index') }}" class="flex items-center justify-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('resikos.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-indigo-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-indigo-500/20 z-20 row-number">1</div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                        <div class="relative group">
                            <select name="rows[0][pernyataan_risiko]" onchange="updateGabunganKode(this)" required class="pernyataan_risiko_select w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer appearance-none">
                                <option value="" selected disabled hidden>-- Pilih Risiko Prioritas --</option>
                                @foreach($analisis_risikos as $analisis)
                                    @if($analisis->identifikasiRisiko)
                                        <option value="{{ $analisis->identifikasiRisiko->pernyataan_risiko }}" data-kode-risiko="{{ $analisis->identifikasiRisiko->kode_risiko ?? '-' }}">[{{ $analisis->identifikasiRisiko->kode_risiko ?? '-' }}] {{ $analisis->identifikasiRisiko->pernyataan_risiko }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        @for($i=1; $i<=5; $i++)
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Why {{ $i }}</label>
                            <input type="text" name="rows[0][why_{{ $i }}]" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 outline-none" placeholder="...">
                        </div>
                        @endfor
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Akar Penyebab</label>
                        <input type="text" name="rows[0][akar_penyebab]" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Masukkan akar penyebab...">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border border-slate-700/50 p-6 rounded-2xl bg-slate-800/20">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Kode Penyebab</label>
                            <div class="relative group">
                                <select name="rows[0][kode_penyebab_jenis]" onchange="updateGabunganKode(this)" required class="kode_penyebab_jenis w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none cursor-pointer appearance-none">
                                    <option value="" selected disabled hidden>-- Pilih Jenis --</option>
                                    @foreach($master_penyebabs as $master)
                                        <option value="{{ $master->kode }}">{{ $master->nama_penyebab }} : {{ $master->kode }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nomor Kode Penyebab</label>
                            <input type="number" name="rows[0][kode_penyebab_nomor]" oninput="updateGabunganKode(this)" required class="kode_penyebab_nomor w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Contoh: 1">
                        </div>
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Hasil Gabungan Kode</label>
                            <input type="text" class="hasil_gabungan_kode w-full px-5 py-4 bg-slate-900/40 rounded-2xl border border-slate-800 text-rose-400 font-bold focus:ring-0 outline-none placeholder:text-slate-700" readonly placeholder="Otomatis terisi...">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kegiatan Pengendalian</label>
                        <textarea name="rows[0][kegiatan_pengendalian]" required rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan kegiatan pengendalian..."></textarea>
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
                <span>Simpan Semua Laporan</span>
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

    function updateGabunganKode(element) {
        const row = element.closest('.row-item');
        const selectRisiko = row.querySelector('.pernyataan_risiko_select');
        const kodePenyebabJenis = row.querySelector('.kode_penyebab_jenis').value || '';
        const kodePenyebabNomor = row.querySelector('.kode_penyebab_nomor').value || '';
        const hasilGabungan = row.querySelector('.hasil_gabungan_kode');

        let kodeRisiko = '';
        if (selectRisiko && selectRisiko.selectedIndex > 0) {
            const option = selectRisiko.options[selectRisiko.selectedIndex];
            kodeRisiko = option.getAttribute('data-kode-risiko') || '';
        }

        let kodePenyebab = '';
        if (kodePenyebabJenis && kodePenyebabNomor) {
            kodePenyebab = kodePenyebabJenis + '.' + kodePenyebabNomor;
        } else if (kodePenyebabJenis) {
            kodePenyebab = kodePenyebabJenis;
        }

        if (kodeRisiko && kodePenyebab) {
            hasilGabungan.value = kodeRisiko + ' - ' + kodePenyebab;
        } else if (kodeRisiko) {
            hasilGabungan.value = kodeRisiko;
        } else if (kodePenyebab) {
            hasilGabungan.value = kodePenyebab;
        } else {
            hasilGabungan.value = '';
        }
    }
</script>
@endsection
