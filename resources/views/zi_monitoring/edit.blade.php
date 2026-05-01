@extends('layouts.app')

@section('title', 'Edit Monitoring ZI')
@section('page_title', 'Update Data LKE RB')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Update Rencana Aksi ZI</h3>
            <p class="text-slate-500 text-sm mt-2 tracking-tight">Perbarui data monitoring atau unggah dokumen bukti pendukung baru.</p>
        </div>
        <a href="{{ route('zi-monitoring.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group shadow-lg">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
        </a>
    </div>

    <form action="{{ route('zi-monitoring.update', $ziMonitoring->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-10">
            {{-- CABANG & TIPE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Cabang Satker</label>
                    <select name="cabang_id" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        <option value="" {{ is_null($ziMonitoring->cabang_id) ? 'selected' : '' }}>Semua Cabang (Global)</option>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}" {{ $ziMonitoring->cabang_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Tipe Level</label>
                    <select name="tipe" id="tipe_select" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" onchange="updateView()">
                        <option value="SS2" {{ $ziMonitoring->tipe == 'SS2' ? 'selected' : '' }}>Sasaran Indikatif (SS2)</option>
                        <option value="K" {{ $ziMonitoring->tipe == 'K' ? 'selected' : '' }}>Kegiatan Utama (K)</option>
                        <option value="IO" {{ $ziMonitoring->tipe == 'IO' ? 'selected' : '' }}>Indikator Output (IO)</option>
                    </select>
                </div>
            </div>

            {{-- HIERARCHY SELECTION FOR EDIT --}}
            <div id="hierarchy_selection" class="{{ $ziMonitoring->tipe == 'SS1' ? 'hidden' : '' }} space-y-8 animate-in slide-in-from-top-4 duration-500">
                <div class="bg-blue-500/5 p-8 rounded-[2rem] border border-blue-500/10">
                    <label class="flex items-center text-[11px] font-black text-blue-400 uppercase tracking-widest mb-4 ml-1">
                        <i data-lucide="layers" class="w-4 h-4 mr-2"></i>
                        Sasaran Indikatif (SS2 - Parent)
                    </label>
                    <select name="ss_selection" id="ss_id_select" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" onchange="updateKOptions()">
                        <option value="">-- Pilih Sasaran Indikatif (SS2) --</option>
                        @foreach($ss_parents as $ss)
                            <option value="{{ $ss->id }}" {{ ($ziMonitoring->parent?->tipe == 'K' ? $ziMonitoring->parent->parent_id : $ziMonitoring->parent_id) == $ss->id ? 'selected' : '' }}>{{ $ss->nomor }} - {{ $ss->sasaran_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="k_selection_box" class="{{ $ziMonitoring->tipe == 'IO' ? '' : 'hidden' }} bg-emerald-500/5 p-8 rounded-[2rem] border border-emerald-500/10 animate-in slide-in-from-top-2 duration-500">
                    <label class="flex items-center text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-4 ml-1">
                        <i data-lucide="git-branch" class="w-4 h-4 mr-2"></i>
                        Kegiatan Utama (Parent)
                    </label>
                    <select name="k_selection" id="k_id_select" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none">
                        <option value="">-- Pilih Kegiatan Utama --</option>
                        @foreach($k_parents as $k)
                            <option value="{{ $k->id }}" {{ $ziMonitoring->parent_id == $k->id ? 'selected' : '' }}>{{ $k->nomor }} - {{ $k->sasaran_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div id="main_fields" class="{{ $ziMonitoring->tipe == 'IO' ? 'hidden' : '' }} space-y-10">
                <div class="bg-slate-800/30 p-8 rounded-[2.5rem] border border-slate-700/50 shadow-inner">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div class="md:col-span-1">
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Nomor (No)</label>
                            <input type="text" name="nomor" value="{{ $ziMonitoring->nomor }}" required class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none" placeholder="Contoh: SS.1, K.2, IO.2.2">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Sasaran / Kegiatan Utama</label>
                            <textarea name="sasaran_kegiatan" rows="2" class="w-full px-6 py-5 bg-[#0f172a] rounded-[2rem] border border-slate-700 text-white outline-none resize-none shadow-inner">{{ $ziMonitoring->sasaran_kegiatan }}</textarea>
                        </div>
                    </div>
                </div>

                <div id="k_fields" class="{{ $ziMonitoring->tipe == 'K' ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-3 gap-8 animate-in slide-in-from-top-4 duration-500">
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Indikator</label>
                        <textarea name="indikator" rows="3" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none">{{ $ziMonitoring->indikator }}</textarea>
                    </div>
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Target</label>
                        <textarea name="target" rows="3" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none">{{ $ziMonitoring->target }}</textarea>
                    </div>
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Outcome</label>
                        <textarea name="outcome" rows="3" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none">{{ $ziMonitoring->outcome }}</textarea>
                    </div>
                </div>
            </div>

            {{-- IO SPECIFIC FIELDS --}}
            <div id="io_fields" class="{{ $ziMonitoring->tipe == 'IO' ? '' : 'hidden' }} space-y-8 animate-in slide-in-from-top-4 duration-500">
                <div class="p-1 pr-1 bg-emerald-500/10 rounded-[2.5rem] border border-emerald-500/20 shadow-inner">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                        <div class="p-8 space-y-6">
                            <label class="flex items-center text-[11px] font-black text-emerald-400 uppercase tracking-widest ml-1">
                                <i data-lucide="target" class="w-4 h-4 mr-2"></i>
                                Rencana Aksi / Kegiatan
                            </label>
                            <textarea name="rincian_kegiatan" rows="6" class="w-full px-6 py-5 bg-[#0f172a] rounded-[2rem] border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none shadow-inner">{{ $ziMonitoring->rincian_kegiatan }}</textarea>
                        </div>
                        <div class="p-8 bg-slate-900/50 rounded-r-[2.5rem] space-y-6 border-l border-emerald-500/10">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Indikator Output (IO)</label>
                                <input type="text" name="indikator_output" value="{{ $ziMonitoring->indikator_output }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none shadow-sm">
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Target Output</label>
                                    <input type="text" name="target_output" value="{{ $ziMonitoring->target_output }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Anggaran (Rp)</label>
                                    <input type="text" name="anggaran" value="{{ $ziMonitoring->anggaran }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none shadow-sm" placeholder="Contoh: 15.000.000">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="flex items-center text-[11px] font-black text-slate-500 uppercase tracking-widest mb-5 ml-1">
                            <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                            Waktu Pelaksanaan
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['B03', 'B06', 'B09', 'B12'] as $b)
                                <label class="flex-1 flex items-center justify-center p-3 rounded-xl bg-[#0f172a] border border-slate-700 cursor-pointer group hover:border-blue-500 transition-all">
                                    <input type="checkbox" name="waktu_pelaksanaan[]" value="{{ $b }}" {{ in_array($b, $selectedWaktu) ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-[10px] font-black text-slate-500 peer-checked:text-blue-400 group-hover:text-slate-300 transition-colors uppercase tracking-widest">{{ $b }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="flex items-center text-[11px] font-black text-slate-500 uppercase tracking-widest mb-5 ml-1">
                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                            Pelaksana
                        </label>
                        <input type="text" name="pelaksana" value="{{ $ziMonitoring->pelaksana }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>
                    <div class="bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                        <label class="flex items-center text-[11px] font-black text-slate-500 uppercase tracking-widest mb-5 ml-1">
                            <i data-lucide="users" class="w-4 h-4 mr-2"></i>
                            Koordinator
                        </label>
                        <input type="text" name="koordinator" value="{{ $ziMonitoring->koordinator }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-indigo-500/5 p-8 rounded-[2.5rem] border border-indigo-500/10 group hover:bg-indigo-500/10 transition-all">
                        <label class="flex items-center text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-5 ml-1">
                            <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                            Keterangan Data Dukung
                        </label>
                        <textarea name="data_dukung" rows="4" class="w-full px-6 py-5 bg-[#0f172a] rounded-[2rem] border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none resize-none shadow-inner">{{ $ziMonitoring->data_dukung }}</textarea>
                        <p class="text-[10px] text-slate-500 mt-4 ml-1 italic leading-relaxed">Jelaskan jenis dokumen atau bukti dukung yang harus diunggah oleh pelaksana pada bagian pengisian data.</p>
                    </div>
                    <div class="bg-amber-500/5 p-8 rounded-[2.5rem] border border-amber-500/10 group hover:bg-amber-500/10 transition-all">
                        <label class="flex items-center text-[11px] font-black text-amber-400 uppercase tracking-widest mb-5 ml-1">
                            <i data-lucide="activity" class="w-4 h-4 mr-2"></i>
                            Status & Progress Capaian
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <select id="status_data_dukung" name="status_data_dukung" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none" onchange="updateProsentase()">
                                <option value="belum_ada" {{ $ziMonitoring->status_data_dukung == 'belum_ada' ? 'selected' : '' }}>Belum Ada Data</option>
                                <option value="menunggu" {{ $ziMonitoring->status_data_dukung == 'menunggu' ? 'selected' : '' }}>Menunggu Evaluasi</option>
                                <option value="sesuai" {{ $ziMonitoring->status_data_dukung == 'sesuai' ? 'selected' : '' }}>Sesuai (Diterima)</option>
                                <option value="tidak_sesuai" {{ $ziMonitoring->status_data_dukung == 'tidak_sesuai' ? 'selected' : '' }}>Tidak Sesuai</option>
                            </select>
                            <div class="relative">
                                <input type="number" id="prosentase" name="prosentase" min="0" max="100" value="{{ $ziMonitoring->prosentase }}" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 transition-all outline-none pl-14 font-black">
                                <span class="absolute left-6 top-5 text-slate-500 font-black text-sm">%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-800/30 p-8 rounded-[2.5rem] border border-slate-700/50">
                    <label class="flex items-center text-[11px] font-black text-slate-500 uppercase tracking-widest mb-5 ml-1">
                        <i data-lucide="message-square" class="w-4 h-4 mr-2"></i>
                        Catatan Hasil Evaluasi (Opsional)
                    </label>
                    <textarea name="catatan" rows="3" class="w-full px-6 py-5 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none shadow-inner">{{ $ziMonitoring->catatan }}</textarea>
                </div>
            </div>

            <div class="pt-10 flex border-t border-slate-800/60 mt-10">
                <button type="submit" class="px-12 py-5 bg-blue-500 hover:bg-blue-600 text-white font-black rounded-[2rem] transition-all shadow-2xl shadow-blue-500/20 active:scale-95 uppercase tracking-widest text-xs">
                    Update Data Monitoring
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    const allK = @json($k_parents);

    function updateView() {
        const tipe = document.getElementById('tipe_select').value;
        const hierarchySelection = document.getElementById('hierarchy_selection');
        const kSelectionBox = document.getElementById('k_selection_box');
        const mainFields = document.getElementById('main_fields');
        const kFields = document.getElementById('k_fields');
        const ioFields = document.getElementById('io_fields');

        hierarchySelection.classList.toggle('hidden', tipe === 'SS2');
        kSelectionBox.classList.toggle('hidden', tipe !== 'IO');
        mainFields.classList.toggle('hidden', tipe === 'IO');
        kFields.classList.toggle('hidden', tipe !== 'K');
        ioFields.classList.toggle('hidden', tipe !== 'IO');
        
        lucide.createIcons();
    }

    function updateKOptions() {
        const ssId = document.getElementById('ss_id_select').value;
        const kSelect = document.getElementById('k_id_select');
        const currentKId = "{{ $ziMonitoring->parent_id }}";
        
        kSelect.innerHTML = '<option value="">-- Pilih Kegiatan Utama --</option>';
        
        allK.filter(k => k.parent_id == ssId).forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = `${k.nomor} - ${k.sasaran_kegiatan}`;
            if (k.id == currentKId) opt.selected = true;
            kSelect.appendChild(opt);
        });
    }

    function updateProsentase() {
        const status = document.getElementById('status_data_dukung').value;
        const prosentaseInput = document.getElementById('prosentase');
        
        const map = {
            'belum_ada': 0,
            'menunggu': 50,
            'sesuai': 100,
            'tidak_sesuai': 25
        };
        
        if (map.hasOwnProperty(status)) {
            prosentaseInput.value = map[status];
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateView();
        updateKOptions();
    });
</script>
@endsection
