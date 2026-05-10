@extends('layouts.app')

@section('title', 'Analisis Risiko')
@section('page_title', 'Analisis Risiko Baru')

@section('content')
    <div class="max-w-5xl mx-auto">
        <div
            class="w-full bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl overflow-hidden relative group">
            <!-- Decorative Background Gradient -->
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 blur-[100px] rounded-full group-hover:bg-blue-500/20 transition-all duration-700 hidden sm:block">
            </div>

            <div class="mb-10 relative z-10 flex flex-col md:flex-row md:justify-between md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center shadow-lg shadow-[#D2A039]/20 shrink-0">
                        <i data-lucide="shield-alert" class="w-6 h-6 md:w-7 md:h-7 text-[#061B30]"></i>
                    </div>
                    <div>
                        <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Analisis Risiko</h3>
                        <p class="text-slate-400 text-[11px] md:text-sm mt-1 leading-tight">Gunakan formulir ini untuk
                            menganalisis risiko yang telah diidentifikasi.</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                        <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                        <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
                    </button>
                    <a href="{{ route('analisis-risiko.index') }}"
                        class="flex items-center justify-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                        <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                        <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
                    </a>
                </div>
            </div>

            <form action="{{ route('analisis-risiko.store') }}" method="POST" class="relative z-10">
                @csrf
                <div id="rows-container" class="space-y-16">
                    <!-- Initial Row -->
                    <div class="row-item bg-slate-900/30 p-8 rounded-[2.5rem] border border-[#D2A039]/10 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                        <div class="absolute -left-4 top-8 w-10 h-10 bg-gradient-to-br from-[#D2A039] to-[#f9d77e] text-[#061B30] rounded-xl flex items-center justify-center font-black text-sm shadow-xl shadow-[#D2A039]/20 z-20 row-number">1</div>
                        
                        <div class="space-y-8 md:space-y-12">
                            <!-- SECTION 1: IDENTIFIKASI -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-xs font-bold shrink-0">01</span>
                                    <h4 class="text-[10px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">Referensi Identifikasi</h4>
                                    <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Referensi Identifikasi</label>
                                        <div class="relative group/select">
                                            <select name="rows[0][identifikasi_risiko_id]" class="identifikasi_risiko_id w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none appearance-none cursor-pointer text-xs md:text-sm" required>
                                                <option value="" selected disabled hidden>-- Pilih Kode Risiko --</option>
                                                @foreach($identifikasi_risikos as $risiko)
                                                    <option value="{{ $risiko->id }}" data-pernyataan="{{ $risiko->pernyataan_risiko }}">{{ $risiko->kode_risiko }} - {{ Str::limit($risiko->pernyataan_risiko, 50) }}</option>
                                                @endforeach
                                            </select>
                                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Pernyataan Risiko</label>
                                        <div class="pernyataan_preview w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-slate-400 text-xs md:text-sm min-h-[58px] flex items-center">
                                            -
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 2: RISIKO MELEKAT -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-[10px] md:text-xs font-bold shrink-0">02</span>
                                    <h4 class="text-[9px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">Skor Risiko yang Melekat</h4>
                                    <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-8">
                                    <div class="md:col-span-4 space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Kemungkinan (1-5)</label>
                                        <select name="rows[0][frekuensi]" class="frekuensi w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none text-xs md:text-sm" required>
                                            <option value="" disabled selected hidden>-- Pilih Probabilitas --</option>
                                            <option value="1">1 - Hampir tidak terjadi</option>
                                            <option value="2">2 - Jarang terjadi</option>
                                            <option value="3">3 - Kadang terjadi</option>
                                            <option value="4">4 - Sering terjadi</option>
                                            <option value="5">5 - Hampir pasti terjadi</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-4 space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Dampak (1-5)</label>
                                        <select name="rows[0][dampak]" class="dampak w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none text-xs md:text-sm" required>
                                            <option value="" disabled selected hidden>-- Pilih Dampak --</option>
                                            <option value="1">1 - Tidak Signifikan</option>
                                            <option value="2">2 - Minor</option>
                                            <option value="3">3 - Moderat</option>
                                            <option value="4">4 - Signifikan</option>
                                            <option value="5">5 - Sangat Signifikan</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-4 space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Level Risiko (Melekat)</label>
                                        <input type="text" name="rows[0][level_risiko]" class="level_risiko w-full px-5 py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-white focus:ring-0 outline-none font-bold text-xs md:text-sm" readonly placeholder="Otomatis terisi...">
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 3: PENGENDALIAN -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-[10px] md:text-xs font-bold shrink-0">03</span>
                                    <h4 class="text-[9px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">Pengendalian yang Ada</h4>
                                    <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Ada / Belum Ada</label>
                                        <select name="rows[0][ada_belum_ada]" class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all appearance-none cursor-pointer text-xs md:text-sm" required>
                                            <option value="Ada">Ada</option>
                                            <option value="Belum Ada">Belum Ada</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Memadai / Belum Memadai</label>
                                        <select name="rows[0][memadai_belum_memadai]" class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all appearance-none cursor-pointer text-xs md:text-sm" required>
                                            <option value="Memadai">Memadai</option>
                                            <option value="Belum Memadai">Belum Memadai</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5 md:space-y-2 md:col-span-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Uraian Pengendalian</label>
                                        <textarea name="rows[0][uraian_pengendalian]" rows="2" class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all resize-none text-xs md:text-sm leading-relaxed" placeholder="Jelaskan pengendalian yang telah diimplementasikan..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SECTION 4: RISIKO RESIDU -->
                            <div class="space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-[10px] md:text-xs font-bold shrink-0">04</span>
                                    <h4 class="text-[9px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">Skor Risiko Residu (Setelah Pengendalian)</h4>
                                    <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Skor Probabilitas (Residu)</label>
                                        <select name="rows[0][skor_probabilitas_residu]" class="skor_probabilitas_residu w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none text-xs md:text-sm">
                                            <option value="" selected disabled hidden>-- Pilih Probabilitas --</option>
                                            <option value="1">1 - Hampir tidak terjadi</option>
                                            <option value="2">2 - Jarang terjadi</option>
                                            <option value="3">3 - Kadang terjadi</option>
                                            <option value="4">4 - Sering terjadi</option>
                                            <option value="5">5 - Hampir pasti terjadi</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Skor Dampak (Residu)</label>
                                        <select name="rows[0][skor_dampak_residu]" class="skor_dampak_residu w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none text-xs md:text-sm">
                                            <option value="" selected disabled hidden>-- Pilih Dampak --</option>
                                            <option value="1">1 - Tidak Signifikan</option>
                                            <option value="2">2 - Minor</option>
                                            <option value="3">3 - Moderat</option>
                                            <option value="4">4 - Signifikan</option>
                                            <option value="5">5 - Sangat Signifikan</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5 md:space-y-2">
                                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Level Risiko Residu</label>
                                        <input type="text" name="rows[0][level_risiko_residu]" class="level_risiko_residu w-full px-5 py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-white focus:ring-0 outline-none font-bold text-xs md:text-sm" readonly placeholder="Otomatis terisi...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="removeRow(this)" class="remove-btn hidden absolute -right-4 top-8 w-10 h-10 bg-rose-500 text-white rounded-xl flex items-center justify-center hover:bg-rose-600 transition-all z-20 shadow-xl shadow-rose-500/20">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-10 flex flex-col sm:flex-row items-center gap-4 border-t border-[#D2A039]/10 md:pb-0 pb-20 mt-12">
                    <button type="submit"
                        class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] hover:shadow-[0_0_25px_rgba(210,160,57,0.4)] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span>Simpan Semua Analisis</span>
                    </button>
                    <a href="{{ route('analisis-risiko.index') }}"
                        class="w-full sm:w-auto px-10 py-4 bg-transparent hover:bg-white/5 text-slate-400 font-bold rounded-2xl transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const matrix = {
            5: { 1: 9, 2: 15, 3: 18, 4: 23, 5: 25 },
            4: { 1: 6, 2: 12, 3: 16, 4: 19, 5: 24 },
            3: { 1: 4, 2: 10, 3: 14, 4: 17, 5: 22 },
            2: { 1: 2, 2: 7, 3: 11, 4: 13, 5: 21 },
            1: { 1: 1, 2: 3, 3: 5, 4: 8, 5: 20 }
        };

        function getLevelInfo(score) {
            if (score >= 20) return { label: 'Sangat Tinggi (5)', class: 'bg-red-500/20 text-red-400 border-red-500/50 shadow-[0_0_15px_rgba(239,68,68,0.2)]' };
            if (score >= 16) return { label: 'Tinggi (4)', class: 'bg-orange-500/20 text-orange-400 border-orange-500/50 shadow-[0_0_15px_rgba(249,115,22,0.2)]' };
            if (score >= 12) return { label: 'Sedang (3)', class: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/50 shadow-[0_0_15px_rgba(234,179,8,0.2)]' };
            if (score >= 6) return { label: 'Rendah (2)', class: 'bg-green-500/20 text-green-400 border-green-500/50 shadow-[0_0_15_rgba(34,197,94,0.2)]' };
            return { label: 'Sangat Rendah (1)', class: 'bg-blue-500/20 text-blue-400 border-blue-500/50 shadow-[0_0_15px_rgba(59,130,246,0.2)]' };
        }

        function calculateRisk(row) {
            const frekVal = row.querySelector('.frekuensi').value;
            const dampVal = row.querySelector('.dampak').value;
            const levelInput = row.querySelector('.level_risiko');

            if (frekVal && dampVal) {
                const score = matrix[frekVal][dampVal];
                const info = getLevelInfo(score);
                levelInput.value = `${score} - ${info.label}`;
                levelInput.className = `level_risiko w-full px-5 py-4 rounded-xl md:rounded-2xl border font-bold text-xs md:text-sm ${info.class}`;
            }

            const residuProbVal = row.querySelector('.skor_probabilitas_residu').value;
            const residuDampVal = row.querySelector('.skor_dampak_residu').value;
            const levelResiduInput = row.querySelector('.level_risiko_residu');

            if (residuProbVal && residuDampVal) {
                const score = matrix[residuProbVal][residuDampVal];
                const info = getLevelInfo(score);
                levelResiduInput.value = `${score} - ${info.label}`;
                levelResiduInput.className = `level_risiko_residu w-full px-5 py-4 rounded-xl md:rounded-2xl border font-bold text-xs md:text-sm ${info.class}`;
            }
        }

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
                // Reset classes for level inputs
                if (input.classList.contains('level_risiko') || input.classList.contains('level_risiko_residu')) {
                    input.className = input.classList.contains('level_risiko') ? 'level_risiko w-full px-5 py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-white focus:ring-0 outline-none font-bold text-xs md:text-sm' : 'level_risiko_residu w-full px-5 py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-white focus:ring-0 outline-none font-bold text-xs md:text-sm';
                }
            });

            newRow.querySelector('.pernyataan_preview').innerText = '-';

            container.appendChild(newRow);
            rowCount++;
            updateRowNumbers();
            lucide.createIcons();
            attachRowEvents(newRow);
        }

        function removeRow(btn) {
            const row = btn.closest('.row-item');
            row.classList.add('animate-out', 'fade-out', 'zoom-out-95', 'duration-300');
            setTimeout(() => {
                row.remove();
                updateRowNumbers();
            }, 300);
        }

        function attachRowEvents(row) {
            row.querySelector('.identifikasi_risiko_id').addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const pernyataan = selectedOption.getAttribute('data-pernyataan');
                const preview = row.querySelector('.pernyataan_preview');
                preview.innerText = pernyataan || 'Tidak ada pernyataan risiko.';
                preview.classList.remove('text-slate-400');
                preview.classList.add('text-white');
            });

            ['frekuensi', 'dampak', 'skor_probabilitas_residu', 'skor_dampak_residu'].forEach(cls => {
                row.querySelector('.' + cls).addEventListener('change', () => calculateRisk(row));
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
            document.querySelectorAll('.row-item').forEach(attachRowEvents);
        });
    </script>
@endsection
