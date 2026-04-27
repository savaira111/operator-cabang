@extends('layouts.app')

@section('title', 'Tambah Penyerapan Anggaran')
@section('page_title', 'Tambah Penyerapan Anggaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('belanja-satker.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-[#D2A039] transition-colors mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Kembali ke Daftar
        </a>
        <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Tambah Penyerapan Anggaran</h3>
        <p class="text-slate-500 text-sm mt-1">Masukkan data realisasi penyerapan anggaran satker baru.</p>
    </div>

    <form action="{{ route('belanja-satker.store') }}" method="POST" enctype="multipart/form-data" class="bg-[#031121] border border-[#D2A039]/20 rounded-[1.5rem] p-6 sm:p-8 shadow-xl">
        @csrf

        <div class="space-y-6">
            <!-- Satker/Cabang Selection -->
            <div>
                <label for="cabang_id" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Pilih Satker / Cabang <span class="text-rose-500">*</span></label>
                <select name="cabang_id" id="cabang_id" required class="w-full bg-[#111827] border border-slate-700 text-white rounded-xl focus:ring-[#D2A039]/20 focus:border-[#D2A039] p-3 transition-all">
                    <option value="">-- Pilih Satker --</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>
                            {{ $cabang->kode_cabang ?? '-' }} | {{ $cabang->name }}
                        </option>
                    @endforeach
                </select>
                @error('cabang_id') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Periode Bulan & Tahun -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="bulan" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Bulan <span class="text-rose-500">*</span></label>
                    <select name="bulan" id="bulan" required class="w-full bg-[#111827] border border-slate-700 text-white rounded-xl focus:ring-[#D2A039]/20 focus:border-[#D2A039] p-3 transition-all">
                        @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $b)
                            <option value="{{ $b }}" {{ old('bulan', 'April') == $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                    @error('bulan') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="tahun" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Tahun <span class="text-rose-500">*</span></label>
                    <input type="number" name="tahun" id="tahun" value="{{ old('tahun', 2026) }}" required min="2020" class="w-full bg-[#111827] border border-slate-700 text-white rounded-xl focus:ring-[#D2A039]/20 focus:border-[#D2A039] p-3 transition-all">
                    @error('tahun') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Total Nominal -->
            <div>
                <label for="total" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Total Anggaran (Rp) <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-slate-500 font-bold">Rp</span>
                    </div>
                    <input type="number" name="total" id="total" value="{{ old('total') }}" required min="0" class="w-full bg-[#111827] border border-slate-700 text-white rounded-xl focus:ring-[#D2A039]/20 focus:border-[#D2A039] block pl-12 p-3 transition-all" placeholder="Contoh: 15000000">
                </div>
                @error('total') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Keterangan / Catatan</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full bg-[#111827] border border-slate-700 text-white rounded-xl focus:ring-[#D2A039]/20 focus:border-[#D2A039] p-3 transition-all" placeholder="Tuliskan keterangan detail jika ada...">{{ old('keterangan') }}</textarea>
                @error('keterangan') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
            </div>

            <!-- Upload Dokumen -->
            <div>
                <label for="dokumen" class="block text-xs font-bold text-slate-300 uppercase tracking-widest mb-2">Upload Dokumen Anggaran</label>
                <div class="relative group">
                    <input type="file" name="dokumen" id="dokumen" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-[#D2A039]/10 file:text-[#D2A039] hover:file:bg-[#D2A039]/20 file:transition-all bg-[#111827] border border-slate-700 rounded-xl focus:outline-none focus:ring-[#D2A039]/20 focus:border-[#D2A039] transition-all cursor-pointer">
                </div>
                <p class="text-[10px] text-slate-500 mt-2 italic">* Format yang didukung: PDF, JPG, PNG. Maksimal ukuran 5MB.</p>
                @error('dokumen') <p class="mt-1.5 text-xs font-medium text-rose-500">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-[#D2A039] text-[#061B30] font-bold rounded-2xl flex items-center hover:bg-[#b88a2e] transition-all duration-300 shadow-xl shadow-[#D2A039]/20 active:scale-95">
                <i data-lucide="save" class="w-5 h-5 mr-2"></i>
                Simpan Data Anggaran
            </button>
        </div>
    </form>
</div>
@endsection
