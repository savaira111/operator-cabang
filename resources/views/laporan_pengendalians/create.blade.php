@extends('layouts.app')

@section('title', 'Tambah LPI Tambahan')
@section('page_title', 'Input Laporan LPI Tambahan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="w-full bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-3xl md:rounded-[2.5rem] p-4 md:p-10 shadow-2xl overflow-hidden relative group">
        <!-- Decorative Background Gradient -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 blur-[100px] rounded-full group-hover:bg-blue-500/20 transition-all duration-700 hidden sm:block"></div>

        <div class="mb-10 flex flex-col md:flex-row md:items-center gap-6 relative z-10">
            <a href="{{ route('laporan-pengendalian.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800/40 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-full border border-slate-700/50 transition-all active:scale-95 group order-2 md:order-1">
                <i data-lucide="x" class="w-4 h-4 mr-2 transition-transform group-hover:rotate-90"></i>
                <span class="text-[10px] uppercase tracking-[0.2em]">Batal</span>
            </a>

            <div class="flex items-center gap-4 order-1 md:order-2 flex-1">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-[#D2A039] to-[#f9d77e] flex items-center justify-center shadow-lg shadow-[#D2A039]/20 shrink-0">
                    <i data-lucide="file-plus" class="w-6 h-6 md:w-7 md:h-7 text-[#061B30]"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-3xl font-black text-white tracking-tight">Tambah Laporan LPI</h3>
                    <p class="text-slate-400 text-[11px] md:text-sm mt-1 leading-tight">Input data laporan pengendalian internal tambahan baru.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('laporan-pengendalian.store') }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                <!-- Basic Info Card for Mobile -->
                <div class="md:col-span-2 p-4 md:p-0 bg-white/5 md:bg-transparent rounded-2xl md:rounded-none border border-white/5 md:border-none space-y-6 md:space-y-8">
                    <div class="flex items-center gap-3 md:hidden mb-2">
                        <i data-lucide="info" class="w-4 h-4 text-[#D2A039]"></i>
                        <span class="text-[10px] font-black text-[#D2A039] uppercase tracking-widest">Informasi Dasar</span>
                    </div>

                    <!-- Satker / Cabang -->
                    <div class="space-y-1.5 md:space-y-2">
                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Kantor Cabang / Satker</label>
                        <div class="relative group/select">
                            <select name="cabang_id" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all outline-none cursor-pointer appearance-none text-xs md:text-sm">
                                <option value="">-- Pilih Cabang --</option>
                                @foreach($cabangs as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                                <i data-lucide="building-2" class="w-4 h-4"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Laporan -->
                    <div class="space-y-1.5 md:space-y-2">
                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama / Jenis Laporan</label>
                        <input type="text" name="nama_laporan" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all text-xs md:text-sm" placeholder="Contoh: Laporan Pengawasan Semester I">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Periode Bulan -->
                        <div class="space-y-1.5 md:space-y-2">
                            <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Bulan</label>
                            <div class="relative group/select">
                                <select name="periode_bulan" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none appearance-none cursor-pointer focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all text-xs md:text-sm">
                                    @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                                        <option value="{{ $b }}">{{ $b }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover/select:text-[#D2A039] transition-colors">
                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Periode Tahun -->
                        <div class="space-y-1.5 md:space-y-2">
                            <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Tahun</label>
                            <input type="number" name="periode_tahun" value="{{ date('Y') }}" required class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all text-xs md:text-sm">
                        </div>
                    </div>
                </div>

                <!-- File & Detail Card for Mobile -->
                <div class="md:col-span-2 p-4 md:p-0 bg-white/5 md:bg-transparent rounded-2xl md:rounded-none border border-white/5 md:border-none space-y-6 md:space-y-8">
                    <div class="flex items-center gap-3 md:hidden mb-2">
                        <i data-lucide="paperclip" class="w-4 h-4 text-[#D2A039]"></i>
                        <span class="text-[10px] font-black text-[#D2A039] uppercase tracking-widest">Dokumen & Detail</span>
                    </div>

                    <!-- File Upload -->
                    <div class="space-y-1.5 md:space-y-2">
                        <label class="block text-[10px] md:text-[11px] font-black text-[#D2A039] uppercase tracking-widest ml-1">Upload Dokumen Laporan</label>
                        <div class="relative group">
                            <input type="file" name="file" class="hidden" id="file_input">
                            <label for="file_input" class="w-full px-5 py-8 bg-[#D2A039]/5 hover:bg-[#D2A039]/10 border-2 border-dashed border-slate-800 hover:border-[#D2A039]/40 rounded-2xl text-slate-400 hover:text-white transition-all cursor-pointer flex flex-col items-center justify-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-[#D2A039]/10 flex items-center justify-center text-[#D2A039] group-hover:scale-110 transition-transform">
                                    <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                                </div>
                                <div class="text-center px-4">
                                    <span id="file_label" class="block font-bold text-sm truncate max-w-[250px]">Klik untuk memilih file...</span>
                                    <span class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">PDF, DOC, EXCEL, JPG (MAX. 10MB)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="space-y-1.5 md:space-y-2">
                        <label class="block text-[10px] md:text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-900/60 rounded-xl md:rounded-2xl border border-slate-800 text-white outline-none resize-none focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039]/50 transition-all text-xs md:text-sm leading-relaxed" placeholder="Tambahkan catatan khusus jika diperlukan..."></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-[#D2A039]/10 md:pb-0 pb-20">
                <button type="submit" class="w-full py-5 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 active:scale-95 flex items-center justify-center gap-3">
                    <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                    <span class="uppercase tracking-widest text-xs">Simpan Laporan LPI</span>
                </button>
            </div>

            <!-- Mobile Floating Action Bar (Sticky) -->
            <div class="fixed bottom-20 left-4 right-4 z-40 md:hidden animate-in fade-in slide-in-from-bottom-10 duration-500">
                <button type="button" onclick="this.form.submit()" class="w-full py-4 bg-[#D2A039] text-[#061B30] font-black rounded-2xl shadow-2xl shadow-black/50 flex items-center justify-center gap-3 border border-white/10 active:scale-95 transition-all">
                    <i data-lucide="save" class="w-6 h-6"></i>
                    <span>SIMPAN LAPORAN</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        document.getElementById('file_input')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Klik untuk memilih file...';
            const fileLabel = document.getElementById('file_label');
            fileLabel.textContent = fileName;
            fileLabel.classList.add('text-[#D2A039]');
        });
    });
</script>
@endsection
