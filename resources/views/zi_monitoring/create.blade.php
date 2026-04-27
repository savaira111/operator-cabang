@extends('layouts.app')

@section('title', 'Create Monitoring ZI')
@section('page_title', 'Tambah Data LKE RB')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Hierarchy Builder ZI</h3>
            <p class="text-slate-500 text-sm mt-2 tracking-tight">Bangun struktur monitoring mulai dari Sasaran, Kegiatan, hingga Indikator Output.</p>
        </div>
        <a href="{{ route('zi-monitoring.index') }}" class="flex items-center px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group shadow-lg">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-[10px] uppercase tracking-[0.2em]">Kembali</span>
        </a>
    </div>

    <form action="{{ route('zi-monitoring.store') }}" method="POST" enctype="multipart/form-data" id="hierarchyForm">
        @csrf
        <div class="space-y-10">
            {{-- CABANG & TIPE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-800/30 p-8 rounded-[2rem] border border-slate-700/50">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Cabang Satker</label>
                    <select name="cabang_id" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none">
                        <option value="">Semua Cabang (Global)</option>
                        @foreach($cabangs as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Tipe Level Yang Dibuat</label>
                    <select name="tipe" id="tipe_select" required class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" onchange="updateView()">
                        <option value="SS2">Sasaran Indikatif (SS2)</option>
                        <option value="K">Kegiatan Utama (K)</option>
                        <option value="IO">Indikator Output (IO) - Kolektif</option>
                    </select>
                </div>
            </div>

            {{-- DYNAMIC HIERARCHY SELECTION --}}
            <div id="hierarchy_selection" class="hidden space-y-8 animate-in slide-in-from-top-4 duration-500">
                {{-- SASARAN STRATEGIS (SS) SELECTION --}}
                <div class="bg-blue-500/5 p-8 rounded-[2rem] border border-blue-500/10">
                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center text-[11px] font-black text-blue-400 uppercase tracking-widest ml-1">
                            <i data-lucide="layers" class="w-4 h-4 mr-2"></i>
                            1. Pilih Sasaran Indikatif (SS2)
                        </label>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="setSSSelection('existing')" id="btn_ss_existing" class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-blue-500 text-white shadow-lg">Pilih Eksisting</button>
                            <button type="button" onclick="setSSSelection('new')" id="btn_ss_new" class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700">Buat Baru</button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="ss_selection_mode" id="ss_selection_type" value="existing">
                    
                    <div id="ss_existing_container">
                        <select id="ss_id_select" name="ss_selection" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" onchange="updateKOptions()">
                            <option value="">-- Pilih Sasaran Indikatif (SS2) --</option>
                            @foreach($ss_parents as $ss)
                                <option value="{{ $ss->id }}">{{ $ss->nomor }} - {{ $ss->sasaran_kegiatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="ss_new_container" class="hidden space-y-4 animate-in fade-in duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="md:col-span-1">
                                <input type="text" name="new_ss_nomor" placeholder="No (ex: SS.1)" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                            </div>
                            <div class="md:col-span-3">
                                <input type="text" name="new_ss_name" placeholder="Nama Sasaran Indikatif Baru..." class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KEGIATAN UTAMA (K) SELECTION --}}
                <div id="k_selection_box" class="bg-emerald-500/5 p-8 rounded-[2rem] border border-emerald-500/10 hidden animate-in slide-in-from-top-2 duration-500">
                    <div class="flex items-center justify-between mb-4">
                        <label class="flex items-center text-[11px] font-black text-emerald-400 uppercase tracking-widest ml-1">
                            <i data-lucide="git-branch" class="w-4 h-4 mr-2"></i>
                            2. Pilih Kegiatan Utama (K)
                        </label>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="setKSelection('existing')" id="btn_k_existing" class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg">Pilih Eksisting</button>
                            <button type="button" onclick="setKSelection('new')" id="btn_k_new" class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700">Buat Baru</button>
                        </div>
                    </div>

                    <input type="hidden" name="k_selection_mode" id="k_selection_type" value="existing">

                    <div id="k_existing_container">
                        <select id="k_id_select" name="k_selection" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none">
                            <option value="">-- Pilih Kegiatan Utama --</option>
                            {{-- Filtered via JS --}}
                        </select>
                    </div>

                    <div id="k_new_container" class="hidden space-y-6 animate-in fade-in duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <input type="text" name="new_k_nomor" placeholder="No (ex: K.1)" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                            <input type="text" name="new_k_name" placeholder="Nama Kegiatan Baru..." class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none md:col-span-3">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <input type="text" name="new_k_indikator" placeholder="Indikator" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                            <input type="text" name="new_k_target" placeholder="Target" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                            <input type="text" name="new_k_outcome" placeholder="Outcome" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- SS / K SINGLE FORM --}}
            <div id="single_entry_fields" class="space-y-8 animate-in slide-in-from-bottom-4 duration-500">
                <div class="bg-slate-800/30 p-8 rounded-[2.5rem] border border-slate-700/50">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Nomor (No)</label>
                            <input type="text" name="nomor" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none" placeholder="Contoh: SS.1, K.2">
                        </div>
                        <div class="md:col-span-3">
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Sasaran / Kegiatan Utama</label>
                            <textarea name="sasaran_kegiatan" rows="1" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none resize-none"></textarea>
                        </div>
                    </div>
                    <div id="k_extra_fields" class="hidden mt-6 grid grid-cols-1 md:grid-cols-5 gap-6 animate-in slide-in-from-top-2 duration-300">
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Indikator</label>
                            <input type="text" name="indikator" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Target</label>
                            <input type="text" name="target" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Outcome</label>
                            <input type="text" name="outcome" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Pelaksana</label>
                            <input type="text" name="pelaksana" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-4 ml-1">Koordinator</label>
                            <input type="text" name="koordinator" class="w-full px-5 py-4 bg-[#0f172a] rounded-2xl border border-slate-700 text-white outline-none text-xs">
                        </div>
                    </div>
                </div>
            </div>

            {{-- IO REPEATER FORM --}}
            <div id="io_repeater" class="hidden space-y-10 animate-in slide-in-from-bottom-8 duration-700">
                <div class="flex items-center justify-between">
                    <h4 class="text-xl font-black text-white uppercase tracking-tighter italic">List Indikator Output (IO)</h4>
                    <button type="button" onclick="addIoRow()" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all shadow-lg active:scale-95 flex items-center">
                        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                        Tambah Baris IO
                    </button>
                </div>

                <div id="io_container" class="space-y-8">
                    {{-- IO Rows will be added here --}}
                </div>
            </div>

            <div class="pt-10 flex border-t border-slate-800/60 mt-10">
                <button type="submit" class="px-12 py-5 bg-blue-500 hover:bg-blue-600 text-white font-black rounded-[2rem] transition-all shadow-2xl shadow-blue-500/20 active:scale-95 uppercase tracking-widest text-xs">
                    Simpan Seluruh Data Hierarchy
                </button>
            </div>
        </div>
    </form>
</div>

{{-- TEMPLATE FOR IO ROW --}}
<template id="io_row_template">
    <div class="io-row group relative p-1 pr-1 bg-slate-800/40 rounded-[2.5rem] border border-slate-700/50 hover:border-emerald-500/30 transition-all animate-in zoom-in-95 duration-500">
        <button type="button" onclick="removeIoRow(this)" class="absolute -top-3 -right-3 w-8 h-8 bg-rose-500 text-white rounded-full flex items-center justify-center shadow-lg hover:rotate-90 transition-transform z-10">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
            <div class="p-8 space-y-6">
                <label class="flex items-center text-[11px] font-black text-emerald-400 uppercase tracking-widest ml-1">
                    <i data-lucide="target" class="w-4 h-4 mr-2"></i>
                    Rencana Aksi / Kegiatan
                </label>
                <textarea name="io_entries[INDEX][rincian_kegiatan]" rows="4" required class="w-full px-6 py-5 bg-[#0f172a] rounded-[2rem] border border-slate-700 text-white outline-none resize-none shadow-inner" placeholder="Rincian kegiatan..."></textarea>
                <div class="grid grid-cols-3 gap-4 mt-4">
                    <input type="text" name="io_entries[INDEX][nomor]" placeholder="No IO (ex: IO.1.1)" class="w-full px-5 py-3 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-[10px]">
                    <input type="text" name="io_entries[INDEX][pelaksana]" placeholder="Pelaksana" class="w-full px-5 py-3 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-[10px]">
                    <input type="text" name="io_entries[INDEX][koordinator]" placeholder="Koordinator" class="w-full px-5 py-3 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-[10px]">
                </div>
            </div>
            <div class="p-8 bg-slate-900/50 rounded-r-[2.5rem] space-y-6 border-l border-slate-800">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Indikator Output</label>
                        <input type="text" name="io_entries[INDEX][indikator_output]" class="w-full px-5 py-4 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Target</label>
                            <input type="text" name="io_entries[INDEX][target_output]" class="w-full px-5 py-4 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Anggaran</label>
                            <input type="text" name="io_entries[INDEX][anggaran]" class="w-full px-5 py-4 bg-[#0f172a] rounded-xl border border-slate-700 text-white text-xs">
                        </div>
                    </div>
                </div>
                <div class="pt-4 border-t border-slate-800/50">
                    <div class="flex flex-wrap gap-2">
                        @foreach(['B03', 'B06', 'B09', 'B12'] as $b)
                            <label class="flex-1 flex items-center justify-center p-2 rounded-lg bg-[#0f172a] border border-slate-800 cursor-pointer group hover:border-emerald-500/50">
                                <input type="checkbox" name="io_entries[INDEX][waktu_pelaksanaan][]" value="{{ $b }}" class="hidden peer">
                                <span class="text-[9px] font-black text-slate-600 peer-checked:text-emerald-400 group-hover:text-slate-300 uppercase">{{ $b }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const allK = @json($k_parents);
    let ioCount = 0;

    function updateView() {
        const tipe = document.getElementById('tipe_select').value;
        const hierarchySelection = document.getElementById('hierarchy_selection');
        const kSelectionBox = document.getElementById('k_selection_box');
        const singleFields = document.getElementById('single_entry_fields');
        const ioRepeater = document.getElementById('io_repeater');
        const kExtra = document.getElementById('k_extra_fields');

        // Reset visibility
        hierarchySelection.classList.add('hidden');
        kSelectionBox.classList.add('hidden');
        singleFields.classList.add('hidden');
        ioRepeater.classList.add('hidden');
        kExtra.classList.add('hidden');

        if (tipe === 'SS2') {
            // Sasaran Indikatif - Root, no parent selection
            singleFields.classList.remove('hidden');
        } else if (tipe === 'K') {
            // Kegiatan - Show SS2 parent selection
            hierarchySelection.classList.remove('hidden');
            singleFields.classList.remove('hidden');
            kExtra.classList.remove('hidden');
        } else if (tipe === 'IO') {
            // Indikator Output - Show SS2 and K parent selection + Repeater
            hierarchySelection.classList.remove('hidden');
            kSelectionBox.classList.remove('hidden');
            ioRepeater.classList.remove('hidden');
            if (ioCount === 0) addIoRow();
        }
        
        lucide.createIcons();
    }

    function setSSSelection(type) {
        document.getElementById('ss_selection_type').value = type;
        document.getElementById('ss_existing_container').classList.toggle('hidden', type === 'new');
        document.getElementById('ss_new_container').classList.toggle('hidden', type === 'existing');
        
        const btnExisting = document.getElementById('btn_ss_existing');
        const btnNew = document.getElementById('btn_ss_new');
        
        if (type === 'new') {
            btnNew.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-blue-500 text-white shadow-lg";
            btnExisting.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700";
        } else {
            btnExisting.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-blue-500 text-white shadow-lg";
            btnNew.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700";
        }
    }

    function setKSelection(type) {
        document.getElementById('k_selection_type').value = type;
        document.getElementById('k_existing_container').classList.toggle('hidden', type === 'new');
        document.getElementById('k_new_container').classList.toggle('hidden', type === 'existing');
        
        const btnExisting = document.getElementById('btn_k_existing');
        const btnNew = document.getElementById('btn_k_new');
        
        if (type === 'new') {
            btnNew.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg";
            btnExisting.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700";
        } else {
            btnExisting.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-emerald-500 text-white shadow-lg";
            btnNew.className = "px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all bg-slate-800 text-slate-500 border border-slate-700";
        }
    }

    function updateKOptions() {
        const ssId = document.getElementById('ss_id_select').value;
        const kSelect = document.getElementById('k_id_select');
        
        kSelect.innerHTML = '<option value="">-- Pilih Kegiatan Utama --</option>';
        
        allK.filter(k => k.parent_id == ssId).forEach(k => {
            const opt = document.createElement('option');
            opt.value = k.id;
            opt.textContent = `${k.nomor} - ${k.sasaran_kegiatan}`;
            kSelect.appendChild(opt);
        });
    }

    function addIoRow() {
        const container = document.getElementById('io_container');
        const template = document.getElementById('io_row_template');
        const content = template.innerHTML.replace(/INDEX/g, ioCount);
        
        const wrapper = document.createElement('div');
        wrapper.innerHTML = content;
        container.appendChild(wrapper.firstElementChild);
        
        ioCount++;
        lucide.createIcons();
    }

    function removeIoRow(btn) {
        btn.closest('.io-row').remove();
    }

    document.addEventListener('DOMContentLoaded', updateView);
</script>
@endsection
