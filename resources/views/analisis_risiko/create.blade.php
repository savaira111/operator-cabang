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

            <div class="mb-10 relative z-10">
                <div class="flex items-center gap-4 mb-6">
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

                <a href="{{ route('analisis-risiko.index') }}"
                    class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                    <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                    <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
                </a>
            </div>

            <form action="{{ route('analisis-risiko.store') }}" method="POST" class="relative z-10">
                @csrf
                <div class="space-y-8 md:space-y-12">
                    <!-- SECTION 1: IDENTIFIKASI -->
                    <div
                        class="p-0 md:p-0 bg-transparent md:bg-transparent rounded-none md:rounded-none border-none md:border-none space-y-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-xs font-bold shrink-0">01</span>
                            <h4 class="text-[10px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">
                                Referensi Identifikasi</h4>
                            <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <div class="space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Referensi
                                    Identifikasi</label>
                                <div class="relative group/select">
                                    <select name="identifikasi_id" id="identifikasi_id" required
                                        class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none appearance-none cursor-pointer text-xs md:text-sm">
                                        <option value="" selected disabled hidden>-- Pilih Kode Risiko --</option>
                                        @foreach($identifikasi_risikos as $risiko)
                                            <option value="{{ $risiko->id }}"
                                                data-pernyataan="{{ $risiko->pernyataan_risiko }}">{{ $risiko->kode_risiko }} -
                                                {{ Str::limit($risiko->pernyataan_risiko, 50) }}</option>
                                        @endforeach
                                    </select>
                                    <div
                                        class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Lokasi
                                    / Unit</label>
                                <input type="text" id="lokasi" readonly
                                    class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-slate-400 outline-none text-xs md:text-sm"
                                    placeholder="-">
                            </div>
                        </div>

                        <div class="space-y-1.5 md:space-y-2">
                            <label
                                class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Pernyataan
                                Risiko</label>
                            <textarea id="pernyataan_risiko" readonly rows="2"
                                class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 text-slate-400 outline-none resize-none text-xs md:text-sm leading-relaxed"
                                placeholder="-"></textarea>
                        </div>
                    </div>

                    <!-- SECTION 2: RISIKO MELEKAT -->
                    <div
                        class="p-4 md:p-0 bg-white/5 md:bg-transparent rounded-2xl md:rounded-none border border-white/5 md:border-none space-y-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-[10px] md:text-xs font-bold shrink-0">02</span>
                            <h4 class="text-[9px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">Skor
                                Risiko yang Melekat</h4>
                            <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-8">
                            <div class="md:col-span-4 space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Kemungkinan
                                    (1-5)</label>
                                <input type="number" name="melekat_kemungkinan" id="melekat_kemungkinan" min="1" max="5"
                                    required
                                    class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none text-xs md:text-sm"
                                    placeholder="1-5">
                            </div>
                            <div class="md:col-span-4 space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Dampak
                                    (1-5)</label>
                                <input type="number" name="melekat_dampak" id="melekat_dampak" min="1" max="5" required
                                    class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none text-xs md:text-sm"
                                    placeholder="1-5">
                            </div>
                            <div class="md:col-span-4">
                                <div id="melekat_result_container"
                                    class="h-full flex flex-col justify-center p-4 md:p-6 bg-slate-900/40 rounded-xl md:rounded-2xl border border-slate-800/50 transition-all">
                                    <p
                                        class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">
                                        Besaran Risiko</p>
                                    <div class="flex items-end gap-2">
                                        <span id="melekat_skor"
                                            class="text-2xl md:text-4xl font-black text-white leading-none">0</span>
                                        <span id="melekat_level"
                                            class="text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Low</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: PENGENDALIAN -->
                    <div
                        class="p-4 md:p-0 bg-white/5 md:bg-transparent rounded-2xl md:rounded-none border border-white/5 md:border-none space-y-6">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex items-center justify-center w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 text-[#D2A039] text-[10px] md:text-xs font-bold shrink-0">03</span>
                            <h4 class="text-[9px] md:text-xs font-black text-[#D2A039] uppercase tracking-[0.2em]">
                                Pengendalian yang Ada</h4>
                            <div class="flex-1 h-px bg-gradient-to-r from-[#D2A039]/30 to-transparent"></div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Uraian
                                    Pengendalian</label>
                                <textarea name="pengendalian_uraian" rows="2"
                                    class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all resize-none text-xs md:text-sm leading-relaxed"
                                    placeholder="Jelaskan pengendalian yang telah diimplementasikan..."></textarea>
                            </div>
                            <div class="space-y-1.5 md:space-y-2">
                                <label
                                    class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Apakah
                                    Sudah Memadai?</label>
                                <div class="relative group/select">
                                    <select name="pengendalian_memadai" required
                                        class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all appearance-none cursor-pointer text-xs md:text-sm">
                                        <option value="Ya">Ya, Sudah Memadai</option>
                                        <option value="Tidak">Tidak, Belum Memadai</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-500 group-hover/select:text-[#D2A039]">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: RISIKO RESIDU -->
                    <option value="4">4 - Sering terjadi</option>
                    <option value="5">5 - Hampir pasti terjadi</option>
                    </select>
                    <div
                        class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                    </div>
                </div>
        </div>
        <div class="space-y-2">
            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Dampak Residu</label>
            <div class="relative group/select">
                <select name="skor_dampak_residu" id="skor_dampak_residu"
                    class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none">
                    <option value="" selected disabled hidden>-- Pilih Dampak --</option>
                    <option value="1">1 - Tidak Signifikan</option>
                    <option value="2">2 - Minor</option>
                    <option value="3">3 - Moderat</option>
                    <option value="4">4 - Signifikan</option>
                    <option value="5">5 - Sangat Signifikan</option>
                </select>
                <div
                    class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                    <i data-lucide="target" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
        <div class="space-y-2 sm:col-span-2 md:col-span-1">
            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Level Risiko
                Residu</label>
            <div class="relative">
                <input type="text" name="level_risiko_residu" id="level_risiko_residu" readonly
                    class="w-full px-5 py-4 bg-slate-900/40 rounded-2xl border border-slate-800 text-white focus:ring-0 outline-none font-bold placeholder:text-slate-700"
                    placeholder="Otomatis terisi...">
                <div class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-600">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="pt-10 flex flex-col sm:flex-row items-center gap-4 border-t border-[#D2A039]/10 md:pb-0 pb-20">
        <button type="submit"
            class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] hover:shadow-[0_0_25px_rgba(210,160,57,0.4)] text-[#061B30] font-black rounded-2xl transition-all active:scale-95 flex items-center justify-center gap-2">
            <i data-lucide="save" class="w-5 h-5"></i>
            <span>Simpan Analisis Risiko</span>
        </button>
        <a href="{{ route('analisis-risiko.index') }}"
            class="w-full sm:w-auto px-10 py-4 bg-transparent hover:bg-white/5 text-slate-400 font-bold rounded-2xl transition-all text-center">
            Batal
        </a>
    </div>

    <!-- Mobile Floating Action Bar (Sticky) -->
    <div class="fixed bottom-20 left-4 right-4 z-40 md:hidden animate-in fade-in slide-in-from-bottom-10 duration-500">
        <button type="button" onclick="this.form.submit()"
            class="w-full py-4 bg-[#D2A039] text-[#061B30] font-black rounded-2xl shadow-2xl shadow-black/50 flex items-center justify-center gap-3 border border-white/10 active:scale-95 transition-all">
            <i data-lucide="check" class="w-6 h-6"></i>
            <span>SIMPAN SEKARANG</span>
        </button>
    </div>
    </div>
    </form>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();

            document.getElementById('identifikasi_risiko_id').addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const pernyataan = selectedOption.getAttribute('data-pernyataan');
                const preview = document.getElementById('pernyataan_preview');
                preview.innerText = pernyataan || 'Tidak ada pernyataan risiko.';
                preview.classList.remove('italic');
                preview.classList.add('text-white', 'not-italic');
            });

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

            function calculateRisk(probId, impactId, resultId) {
                const prob = document.getElementById(probId).value;
                const impact = document.getElementById(impactId).value;
                const resultInput = document.getElementById(resultId);

                if (prob && impact) {
                    const score = matrix[prob][impact];
                    const info = getLevelInfo(score);
                    resultInput.value = `${score} - ${info.label}`;

                    // Reset classes
                    resultInput.className = "w-full px-5 py-4 rounded-2xl border font-bold transition-all duration-300 outline-none focus:ring-0";

                    // Add new classes
                    const classes = info.class.split(' ');
                    resultInput.classList.add(...classes);
                }
            }

            document.getElementById('frekuensi').addEventListener('change', () => calculateRisk('frekuensi', 'dampak', 'level_risiko'));
            document.getElementById('dampak').addEventListener('change', () => calculateRisk('frekuensi', 'dampak', 'level_risiko'));
            document.getElementById('skor_probabilitas_residu').addEventListener('change', () => calculateRisk('skor_probabilitas_residu', 'skor_dampak_residu', 'level_risiko_residu'));
            document.getElementById('skor_dampak_residu').addEventListener('change', () => calculateRisk('skor_probabilitas_residu', 'skor_dampak_residu', 'level_risiko_residu'));
        });
    </script>
@endsection