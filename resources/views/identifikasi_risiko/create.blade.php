@extends('layouts.app')

@section('title', 'Identifikasi Risiko')
@section('page_title', 'Identifikasi Risiko Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shrink-0">
                <i data-lucide="shield-alert" class="w-6 h-6 md:w-7 md:h-7"></i>
            </div>
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight">Identifikasi Risiko</h3>
                <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mengidentifikasi risiko pada unit kerja.</p>
            </div>
        </div>
        
        <div class="flex flex-wrap gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('identifikasi-risiko.index') }}" class="flex items-center justify-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('identifikasi-risiko.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-rose-500/20 z-20 row-number">1</div>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Kode Risiko</label>
                            <div class="relative group">
                                <select name="rows[0][kode_risiko_jenis]" onchange="updateKodeRisiko(this)" class="kode_risiko_jenis w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih kode risiko...</option>
                                    @foreach($master_risikos as $master)
                                        <option value="{{ $master->kode }}" class="bg-slate-900 text-white">{{ $master->kode }} - {{ $master->nama_risiko }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nomor Kode Risiko</label>
                            <div class="relative group">
                                <select name="rows[0][kode_risiko_nomor]" onchange="updateKodeRisiko(this)" class="kode_risiko_nomor w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih nomor...</option>
                                    @for($i=1; $i<=40; $i++)
                                        <option value="{{ $i }}" class="bg-slate-900 text-white">{{ $i }}</option>
                                    @endfor
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="rows[0][kode_risiko]" class="kode_risiko_hidden">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Jenis Konteks</label>
                            <div class="relative group">
                                <select name="rows[0][jenis_konteks]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih jenis konteks...</option>
                                    <option value="Sasaran Kegiatan" class="bg-slate-900 text-white">Sasaran Kegiatan</option>
                                    <option value="Program Kerja" class="bg-slate-900 text-white">Program Kerja</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Konteks</label>
                            <input type="text" name="rows[0][nama_konteks]" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none" placeholder="Masukkan nama konteks...">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator</label>
                        <textarea name="rows[0][indikator]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan indikator..."></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pernyataan Risiko</label>
                        <textarea name="rows[0][pernyataan_risiko]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan pernyataan risiko..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kategori Risiko</label>
                            <div class="relative group">
                                <select name="rows[0][kategori_risiko]" onchange="updateKodeRisiko(this)" class="kategori_risiko_select w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="" disabled selected class="bg-slate-900 text-slate-400">Pilih kategori risiko...</option>
                                    <option value="Risiko Bencana" class="bg-slate-900 text-white">Risiko Bencana</option>
                                    <option value="Risiko Kebijakan" class="bg-slate-900 text-white">Risiko Kebijakan</option>
                                    <option value="Risiko Kecurangan" class="bg-slate-900 text-white">Risiko Kecurangan</option>
                                    <option value="Risiko Kepatuhan" class="bg-slate-900 text-white">Risiko Kepatuhan</option>
                                    <option value="Risiko Operasional" class="bg-slate-900 text-white">Risiko Operasional</option>
                                    <option value="Risiko Pemangku Kepentingan" class="bg-slate-900 text-white">Risiko Pemangku Kepentingan</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-rose-400 transition-colors">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Uraian Dampak</label>
                        <textarea name="rows[0][uraian_dampak]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan uraian dampak..."></textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Metode Pencapaian Tujuan SPIP</label>
                        <textarea name="rows[0][metode_pencapaian_tujuan_spip]" rows="2" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Masukkan metode pencapaian..."></textarea>
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
                <span>Simpan Semua Data</span>
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

        // Clear row content animations and classes if any
        newRow.classList.remove('animate-in', 'fade-in', 'slide-in-from-top-4');
        void newRow.offsetWidth; // trigger reflow
        newRow.classList.add('animate-in', 'fade-in', 'slide-in-from-top-4');

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

    function updateKodeRisiko(element) {
        const row = element.closest('.row-item');
        const jenisSelect = row.querySelector('.kode_risiko_jenis');
        const nomorSelect = row.querySelector('.kode_risiko_nomor');
        const kategoriSelect = row.querySelector('.kategori_risiko_select');
        const hiddenInput = row.querySelector('.kode_risiko_hidden');

        if (!jenisSelect || !nomorSelect || !kategoriSelect || !hiddenInput) return;

        const jenis = jenisSelect.value;
        const nomor = nomorSelect.value;
        
        let kategoriIndex = '';
        if (kategoriSelect.selectedIndex > 0) {
            kategoriIndex = kategoriSelect.selectedIndex;
        }

        let code = jenis;
        if (kategoriIndex) {
            code = code + '.' + kategoriIndex;
        }
        if (nomor) {
            code = code + '.' + nomor;
        }
        
        hiddenInput.value = code;
    }
</script>
@endsection
