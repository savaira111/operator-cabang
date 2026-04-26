@extends('layouts.app')

@section('title', 'Edit Monitoring Zi')
@section('page_title', 'Update Data LKE RB')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight uppercase">Update Rencana Aksi Zi</h3>
            <p class="text-slate-500 text-sm mt-1">Perbarui data monitoring atau upload data dukung baru.</p>
        </div>
        <a href="{{ route('zi-monitoring.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('zi-monitoring.update', $ziMonitoring) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-10">
            {{-- LEVEL & CABANG --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Cabang Satker</label>
                    <select name="cabang_id" required class="w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ $ziMonitoring->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Tipe Level</label>
                    <select name="tipe" id="tipe_select" required class="w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" onchange="toggleFields()">
                        <option value="SS1" {{ $ziMonitoring->tipe == 'SS1' ? 'selected' : '' }}>Sasaran Strategis (SS1)</option>
                        <option value="SS2" {{ $ziMonitoring->tipe == 'SS2' ? 'selected' : '' }}>Sasaran Indikatif (SS2)</option>
                        <option value="K" {{ $ziMonitoring->tipe == 'K' ? 'selected' : '' }}>Kegiatan Utama (K)</option>
                        <option value="RK" {{ $ziMonitoring->tipe == 'RK' ? 'selected' : '' }}>Rincian Kegiatan (RK)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Nomor (No)</label>
                    <input type="text" name="nomor" value="{{ $ziMonitoring->nomor }}" required class="w-full px-5 py-4 bg-[#111827] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: SS.1, K.2, RK.2.2">
                </div>
            </div>

            {{-- PARENT --}}
            <div id="parent_field" class="{{ $ziMonitoring->tipe == 'SS1' ? 'hidden' : '' }} animate-in fade-in duration-300">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Parent (Induk)</label>
                <select name="parent_id" class="w-full px-5 py-4 bg-slate-800/30 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    <option value="">-- Pilih Induk --</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" {{ $ziMonitoring->parent_id == $p->id ? 'selected' : '' }}>{{ $p->nomor }} - {{ $p->sasaran_kegiatan ?: $p->rincian_kegiatan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- FIELDS DYNAMISM --}}
            <div id="main_fields" class="{{ $ziMonitoring->tipe == 'RK' ? 'hidden' : '' }} grid grid-cols-1 md:grid-cols-2 gap-10">
                <div id="field_sasaran" class="space-y-6">
                    <label class="block text-[11px] font-black text-blue-400 uppercase tracking-widest mb-1 ml-1">Sasaran / Kegiatan Utama</label>
                    <textarea name="sasaran_kegiatan" rows="4" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none">{{ $ziMonitoring->sasaran_kegiatan }}</textarea>
                </div>

                <div id="field_indikator" class="space-y-6">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator</label>
                        <input type="text" name="indikator" value="{{ $ziMonitoring->indikator }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target</label>
                            <input type="text" name="target" value="{{ $ziMonitoring->target }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Outcome</label>
                            <input type="text" name="outcome" value="{{ $ziMonitoring->outcome }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- RK SPECIFIC FIELDS --}}
            <div id="rk_fields" class="{{ $ziMonitoring->tipe == 'RK' ? '' : 'hidden' }} space-y-10 animate-in slide-in-from-top-4 duration-500">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label class="block text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-4 ml-1">Rincian Kegiatan</label>
                        <textarea name="rincian_kegiatan" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none">{{ $ziMonitoring->rincian_kegiatan }}</textarea>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator Output</label>
                            <input type="text" name="indikator_output" value="{{ $ziMonitoring->indikator_output }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target Output</label>
                                <input type="text" name="target_output" value="{{ $ziMonitoring->target_output }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Anggaran</label>
                                <input type="text" name="anggaran" value="{{ $ziMonitoring->anggaran }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: 15.000.000">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Waktu Pelaksanaan</label>
                        <div class="flex flex-wrap gap-3 p-4 bg-slate-800/30 rounded-2xl border border-slate-700">
                            @foreach(['B03', 'B06', 'B09', 'B12'] as $b)
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="waktu_pelaksanaan[]" value="{{ $b }}" {{ in_array($b, $selectedWaktu) ? 'checked' : '' }} class="w-5 h-5 rounded-lg bg-slate-900 border-slate-700 text-blue-500 focus:ring-offset-slate-900 focus:ring-blue-500/30">
                                    <span class="text-xs font-black text-slate-500 group-hover:text-blue-400 transition-colors uppercase">{{ $b }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pelaksana</label>
                        <input type="text" name="pelaksana" value="{{ $ziMonitoring->pelaksana }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Koordinator</label>
                        <input type="text" name="koordinator" value="{{ $ziMonitoring->koordinator }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-indigo-500/5 p-8 rounded-[2.5rem] border border-indigo-500/10">
                        <label class="block text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-4 ml-1">Data Dukung (File Bukti)</label>
                        <div class="relative group">
                            <input type="file" name="data_dukung" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-indigo-500 file:text-white hover:file:bg-indigo-600">
                        </div>
                        @if($ziMonitoring->data_dukung)
                            <div class="mt-4 flex items-center space-x-3 p-4 bg-slate-900 rounded-2xl border border-slate-800">
                                <i data-lucide="file-check" class="w-5 h-5 text-emerald-400"></i>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sudah ada file: </span>
                                <a href="{{ Storage::url($ziMonitoring->data_dukung) }}" target="_blank" class="text-blue-400 hover:underline font-bold text-xs">Lihat File</a>
                            </div>
                        @endif
                        <p class="text-[10px] text-slate-600 mt-3 italic ml-1">Format: PDF, JPG, PNG. Max: 10MB. Kosongkan jika tidak ingin mengganti.</p>
                    </div>
                    <div class="bg-amber-500/5 p-8 rounded-[2.5rem] border border-amber-500/10">
                        <label class="block text-[11px] font-black text-amber-400 uppercase tracking-widest mb-4 ml-1">Status & Progress</label>
                        <div class="grid grid-cols-2 gap-4">
                            <select name="status_data_dukung" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none">
                                <option value="belum_ada" {{ $ziMonitoring->status_data_dukung == 'belum_ada' ? 'selected' : '' }}>Belum Ada Data</option>
                                <option value="menunggu" {{ $ziMonitoring->status_data_dukung == 'menunggu' ? 'selected' : '' }}>Menunggu Evaluasi</option>
                                <option value="sesuai" {{ $ziMonitoring->status_data_dukung == 'sesuai' ? 'selected' : '' }}>Sesuai (Diterima)</option>
                                <option value="tidak_sesuai" {{ $ziMonitoring->status_data_dukung == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                            </select>
                            <div class="relative">
                                <input type="number" name="prosentase" min="0" max="100" value="{{ $ziMonitoring->prosentase }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none pl-12">
                                <span class="absolute left-5 top-4 text-slate-500 font-bold">%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/30 p-8 rounded-[2.5rem] border border-slate-700/50">
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Catatan Hasil Evaluasi</label>
                    <textarea name="catatan" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none">{{ $ziMonitoring->catatan }}</textarea>
                </div>
            </div>

            <div class="pt-6 flex space-x-4 border-t border-slate-800/60 mt-8">
                <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95">
                    Update Data Monitoring
                </button>
                <form action="{{ route('zi-monitoring.destroy', $ziMonitoring) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-10 py-4 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white font-bold rounded-2xl transition-all border border-rose-500/30 active:scale-95" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleFields() {
        const tipe = document.getElementById('tipe_select').value;
        const rkFields = document.getElementById('rk_fields');
        const mainFields = document.getElementById('main_fields');
        const parentField = document.getElementById('parent_field');

        if (tipe === 'RK') {
            rkFields.classList.remove('hidden');
            mainFields.classList.add('hidden');
        } else {
            rkFields.classList.add('hidden');
            mainFields.classList.remove('hidden');
        }

        if (tipe === 'SS1') {
            parentField.classList.add('hidden');
        } else {
            parentField.classList.remove('hidden');
        }
    }
    
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection
