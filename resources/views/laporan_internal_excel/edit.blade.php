@extends('layouts.app')

@section('title', 'Edit Laporan Excel')
@section('page_title', 'Edit Laporan Internal Excel')

@section('content')
<div class="mb-8">
    <h3 class="text-3xl font-black text-white tracking-tighter">Edit Laporan</h3>
    <p class="text-slate-500 text-sm mt-1">{{ $report->category_name }} - {{ $report->no_input }}</p>
</div>

<div class="max-w-4xl mx-auto">
    <div class="bg-[#031121]/50 backdrop-blur-xl border border-[#D2A039]/20 rounded-[2.5rem] p-8 md:p-12 shadow-2xl relative group overflow-hidden">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/10 blur-[100px] rounded-full group-hover:bg-[#D2A039]/20 transition-all duration-700 hidden sm:block"></div>

        <form action="{{ route('laporan-internal-excel.update', $report) }}" method="POST" enctype="multipart/form-data" class="relative z-10 space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- File Upload -->
                <div class="md:col-span-2 space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Update File Excel (Kosongkan jika tidak ingin ganti)</label>
                    <div class="relative group">
                        <input type="file" name="excel_file" class="hidden" id="excel_file" accept=".xlsx,.xls,.csv">
                        <label for="excel_file" class="w-full px-6 py-8 bg-[#D2A039]/5 hover:bg-[#D2A039]/10 border-2 border-dashed border-slate-800 hover:border-[#D2A039]/40 rounded-2xl text-slate-400 hover:text-white transition-all cursor-pointer flex flex-col items-center justify-center gap-3">
                            <i data-lucide="file-up" class="w-8 h-8 text-[#D2A039]"></i>
                            <div class="text-center">
                                <span id="file-label" class="font-bold text-xs block">Pilih File Baru</span>
                                <span class="text-[10px] text-slate-500 mt-1 block">File saat ini: {{ basename($report->file_path) }}</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Periode -->
                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Bulan</label>
                    <select name="periode_bulan" required class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $m)
                            <option value="{{ $m }}" {{ $report->periode_bulan == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Periode Tahun</label>
                    <input type="number" name="periode_tahun" value="{{ $report->periode_tahun }}" required class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">
                </div>

                @if(!auth()->user()->cabang_id)
                <div class="md:col-span-2 space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Cabang / UPT</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ $report->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="md:col-span-2 space-y-3">
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Keterangan</label>
                    <textarea name="keterangan" rows="3" class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">{{ $report->keterangan }}</textarea>
                </div>

                <!-- Admin Only Fields -->
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pimpinan')
                <div class="md:col-span-2 border-t border-slate-800/60 pt-8 mt-4">
                    <h4 class="text-xs font-black text-[#D2A039] uppercase tracking-widest mb-6">Panel Evaluasi (Pusat)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Status Evaluasi</label>
                            <select name="status_evaluasi" class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">
                                <option value="Pending" {{ $report->status_evaluasi == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Dalam Reviu" {{ $report->status_evaluasi == 'Dalam Reviu' ? 'selected' : '' }}>Dalam Reviu</option>
                                <option value="Selesai" {{ $report->status_evaluasi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ $report->status_evaluasi == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Prosentase Progress (%)</label>
                            <input type="number" name="prosentase" value="{{ $report->prosentase ?? 0 }}" min="0" max="100" class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm">
                        </div>
                        <div class="md:col-span-2 space-y-3">
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Catatan Evaluasi</label>
                            <textarea name="catatan_evaluasi" rows="3" class="w-full px-5 py-4 bg-slate-900/60 rounded-2xl border border-slate-800 text-white text-sm" placeholder="Berikan masukan atau catatan untuk cabang...">{{ $report->catatan_evaluasi }}</textarea>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Buttons -->
                <div class="md:col-span-2 flex items-center gap-4 pt-6">
                    <a href="{{ route('laporan-internal-excel.index', ['category_id' => $report->category_id]) }}" class="flex-1 py-4 bg-slate-800 text-slate-300 font-black rounded-2xl text-center uppercase tracking-widest text-xs hover:bg-slate-700 transition-all">
                        Batalkan
                    </a>
                    <button type="submit" class="flex-[2] py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl uppercase tracking-widest text-xs shadow-xl shadow-[#D2A039]/20 active:scale-95 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    document.getElementById('excel_file')?.addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Pilih File Baru';
        const label = document.getElementById('file-label');
        label.textContent = fileName;
        label.classList.add('text-[#D2A039]');
    });
});
</script>
@endsection
