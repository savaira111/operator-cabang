@extends('layouts.app')

@section('title', 'Laporan Monitoring Pengendalian')
@section('page_title', 'Laporan Monitoring Pengendalian')

@section('content')
<div class="space-y-8">
    <!-- Filter Section -->
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-8 shadow-2xl">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-black text-white tracking-tight flex items-center">
                <i data-lucide="filter" class="w-5 h-5 mr-3 text-indigo-400"></i>
                FILTER LAPORAN
            </h3>
            <button type="button" onclick="openPrintModal()" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-emerald-500/20 active:scale-95 flex items-center justify-center uppercase tracking-widest text-[10px]">
                <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                Cetak PDF
            </button>
        </div>
        
        <form action="{{ route('laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6 items-end">
            <!-- Cabang -->
            <div class="space-y-3 lg:col-span-3">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Cabang</label>
                <select name="cabang_id" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                    <option value="all">Semua Cabang</option>
                    @foreach($cabangs as $cabang)
                        <option value="{{ $cabang->id }}" {{ $selectedCabang == $cabang->id ? 'selected' : '' }}>{{ $cabang->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Periode -->
            <div class="space-y-3 lg:col-span-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Periode</label>
                <select name="periode" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                    <option value="all">Semua</option>
                    <option value="B03" {{ $selectedPeriode == 'B03' ? 'selected' : '' }}>B03</option>
                    <option value="B06" {{ $selectedPeriode == 'B06' ? 'selected' : '' }}>B06</option>
                    <option value="B09" {{ $selectedPeriode == 'B09' ? 'selected' : '' }}>B09</option>
                    <option value="B12" {{ $selectedPeriode == 'B12' ? 'selected' : '' }}>B12</option>
                </select>
            </div>

            <!-- Tahun -->
            <div class="space-y-3 lg:col-span-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Tahun</label>
                <input type="number" name="tahun" value="{{ $selectedTahun }}" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="2026">
            </div>

            <!-- Jenis Laporan -->
            <div class="space-y-3 lg:col-span-2">
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">J. Laporan</label>
                <select name="jenis_laporan" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                    <option value="all">Semua Laporan</option>
                    <option value="zi" {{ $selectedJenis == 'zi' ? 'selected' : '' }}>Zona Integritas</option>
                    <option value="resiko" {{ $selectedJenis == 'resiko' ? 'selected' : '' }}>Manajemen Resiko</option>
                    <option value="tahanan" {{ $selectedJenis == 'tahanan' ? 'selected' : '' }}>Data Tahanan</option>
                    <option value="belanja" {{ $selectedJenis == 'belanja' ? 'selected' : '' }}>Belanja Satker</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 lg:col-span-3">
                <button type="submit" class="flex-1 px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 flex items-center justify-center uppercase tracking-widest text-xs">
                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                    Cari
                </button>
                <a href="{{ route('laporan.index') }}" class="px-6 py-4 bg-slate-800 text-slate-400 font-bold rounded-2xl border border-slate-700 transition-all hover:bg-slate-700 hover:text-white flex items-center justify-center uppercase tracking-widest text-[10px]">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table Section -->
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-800/40 border-b border-slate-800/60">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">No</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Cabang</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Periode</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Presentase Data Masuk</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Progress Evaluasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/40">
                    @forelse($reportData as $index => $data)
                    <tr class="hover:bg-slate-800/30 transition-all group">
                        <td class="px-8 py-10 text-xs font-bold text-slate-500 align-top">{{ $index + 1 }}</td>
                        <td class="px-8 py-10 align-top">
                            <span class="font-bold text-white tracking-tight uppercase text-sm">
                                {{ $data['cabang'] }}
                            </span>
                        </td>
                        <td class="px-8 py-10 align-top">
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-indigo-400 bg-indigo-500/10 px-3 py-1 rounded-lg border border-indigo-500/20 w-fit">
                                    {{ $data['periode'] }}
                                </span>
                                <span class="text-[10px] text-slate-500 font-bold mt-2 ml-1">{{ $data['tahun'] }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-10">
                            <div class="grid grid-cols-1 gap-8">
                                @foreach($data['modules'] as $module => $scores)
                                    @php
                                        $percentage = $scores['input'];
                                        $total = 26;
                                        $current = round(($percentage / 100) * $total);
                                        
                                        $shouldShow = $selectedJenis == 'all' || 
                                            ($selectedJenis == 'zi' && $module == 'Zona Integritas') ||
                                            ($selectedJenis == 'resiko' && $module == 'Manajemen Resiko') ||
                                            ($selectedJenis == 'tahanan' && $module == 'Data Tahanan') ||
                                            ($selectedJenis == 'belanja' && $module == 'Belanja Satker');
                                    @endphp

                                    @if($shouldShow)
                                    <div class="flex flex-col items-center w-full max-w-[200px] mx-auto">
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 text-center leading-tight">{{ $module }}</span>
                                        <div class="w-full flex flex-col items-center">
                                            <div class="flex items-center gap-1 mb-1.5">
                                                <span class="text-sm font-black text-white">{{ $current }}</span>
                                                <span class="text-xs font-bold text-slate-600">/ {{ $total }}</span>
                                            </div>
                                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden mb-1.5">
                                                <div class="bg-indigo-500 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-[11px] font-bold text-slate-400">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-10">
                            <div class="grid grid-cols-1 gap-8">
                                @foreach($data['modules'] as $module => $scores)
                                    @php
                                        $percentage = $scores['evaluasi'];
                                        $total = 26;
                                        $current = round(($percentage / 100) * $total);
                                        
                                        $shouldShow = $selectedJenis == 'all' || 
                                            ($selectedJenis == 'zi' && $module == 'Zona Integritas') ||
                                            ($selectedJenis == 'resiko' && $module == 'Manajemen Resiko') ||
                                            ($selectedJenis == 'tahanan' && $module == 'Data Tahanan') ||
                                            ($selectedJenis == 'belanja' && $module == 'Belanja Satker');
                                    @endphp

                                    @if($shouldShow)
                                    <div class="flex flex-col items-center w-full max-w-[200px] mx-auto">
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-2 text-center leading-tight">{{ $module }}</span>
                                        <div class="w-full flex flex-col items-center">
                                            <div class="flex items-center gap-1 mb-1.5">
                                                <span class="text-sm font-black text-emerald-400">{{ $current }}</span>
                                                <span class="text-xs font-bold text-slate-600">/ {{ $total }}</span>
                                            </div>
                                            <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden mb-1.5">
                                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-[11px] font-bold text-slate-400">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <i data-lucide="inbox" class="w-12 h-12 text-slate-700 mb-4"></i>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Data tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Print Layout (Hidden on screen, shown on print) -->
    <div id="printableArea" class="hidden print:block font-serif text-black p-4">
        @foreach($reportData as $data)
        <div class="mb-20 last:mb-0 page-break-after-always">
            <!-- KOP -->
            <div class="text-center border-b-2 border-black pb-4 mb-6">
                <h1 class="text-xl font-bold uppercase">Kantor Wilayah Kemenkumham Jawa Barat</h1>
                <p class="text-sm italic">Jl. Jakarta No. 27, Bandung, Jawa Barat</p>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h2 class="text-lg font-bold underline uppercase">LAPORAN PENGENDALIAN INTERNAL</h2>
            </div>

            <!-- Info Section -->
            <div class="mb-6 space-y-1 text-sm">
                <div class="flex">
                    <span class="w-32">Nama Cabang</span>
                    <span class="mr-2">:</span>
                    <span class="font-bold">{{ $data['cabang'] }}</span>
                </div>
                <div class="flex">
                    <span class="w-32">Periode</span>
                    <span class="mr-2">:</span>
                    <span>{{ $data['periode'] }} / {{ $data['tahun'] }}</span>
                </div>
                <div class="flex">
                    <span class="w-32">Data</span>
                    <span class="mr-2">:</span>
                    <span>{{ $selectedJenis == 'all' ? 'All' : strtoupper($selectedJenis) }}</span>
                </div>
            </div>

            <!-- Table -->
            <table class="w-full border-collapse border border-black text-sm mb-12">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-black px-3 py-2 w-12 text-center">No</th>
                        <th class="border border-black px-3 py-2 text-left">Data</th>
                        <th class="border border-black px-3 py-2 text-center w-48">Kelengkapan Data</th>
                        <th class="border border-black px-3 py-2 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($data['modules'] as $module => $scores)
                        @php
                            $shouldShow = $selectedJenis == 'all' || 
                                ($selectedJenis == 'zi' && $module == 'Zona Integritas') ||
                                ($selectedJenis == 'resiko' && $module == 'Manajemen Resiko') ||
                                ($selectedJenis == 'tahanan' && $module == 'Data Tahanan') ||
                                ($selectedJenis == 'belanja' && $module == 'Belanja Satker');
                        @endphp
                        @if($shouldShow)
                        <tr>
                            <td class="border border-black px-3 py-4 text-center">{{ $no++ }}</td>
                            <td class="border border-black px-3 py-4 font-bold">{{ $module }}</td>
                            <td class="border border-black px-3 py-4 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold">{{ $scores['input'] }}%</span>
                                    <span class="text-[10px] text-gray-500">Terlaksana</span>
                                </div>
                            </td>
                            <td class="border border-black px-3 py-4 text-xs italic text-gray-400">
                                -
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <!-- Signature Section -->
            <div class="flex justify-end text-right">
                <div class="inline-block text-right">
                    <p class="text-sm" id="displayKotaTanggal_{{ $loop->index }}">Bandung, {{ date('d F Y') }}</p>
                    <p class="text-sm font-bold uppercase tracking-tight" id="displayInstansi_{{ $loop->index }}">Kantor Wilayah Kemenkumham Jawa Barat</p>
                    <div class="h-24"></div>
                    <p class="text-sm font-bold" id="displayNama_{{ $loop->index }}">( . . . . . . . . . . . . . . . . . . )</p>
                    <p class="text-xs font-bold mt-1" id="displayNip_{{ $loop->index }}">NIP. ............................</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Print Modal -->
<div id="printModal" class="fixed inset-0 z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 backdrop-blur-sm bg-black/60">
    <div class="bg-[#111827] border border-slate-800 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl transform scale-95 transition-all duration-300" id="modalContent">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-black text-white tracking-tight uppercase">Pengaturan Cetak</h3>
            <button onclick="closePrintModal()" class="text-slate-500 hover:text-white transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Kota</label>
                    <input type="text" id="inputKota" value="{{ auth()->user()->cabang->location ?? 'Bandung' }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal</label>
                    <input type="text" id="inputTanggal" value="{{ date('d F Y') }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
                </div>
            </div>
            
            <div class="space-y-1.5">
                <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Instansi / Kantor</label>
                <input type="text" id="inputInstansi" value="{{ auth()->user()->cabang->name ?? 'Kantor Wilayah Kemenkumham Jawa Barat' }}" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
            </div>
            
            <div class="space-y-1.5">
                <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama Penandatangan</label>
                <input type="text" id="inputNama" placeholder="Contoh: John Doe, S.H." class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
            </div>
            
            <div class="space-y-1.5">
                <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest ml-1">NIP</label>
                <input type="text" id="inputNip" placeholder="19XXXXXXXXXXXXXX" class="w-full px-4 py-3 bg-slate-800/50 rounded-xl border border-slate-700 text-sm text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none">
            </div>
        </div>
        
        <div class="flex gap-3 mt-8">
            <button onclick="closePrintModal()" class="flex-1 px-5 py-3.5 bg-slate-800 text-slate-400 font-bold rounded-xl border border-slate-700 transition-all hover:bg-slate-700 hover:text-white uppercase tracking-widest text-[9px]">
                Batal
            </button>
            <button onclick="doPrint()" class="flex-1 px-5 py-3.5 bg-indigo-500 text-white font-black rounded-xl shadow-xl shadow-indigo-500/20 transition-all hover:bg-indigo-600 active:scale-95 uppercase tracking-widest text-[9px]">
                Cetak Laporan
            </button>
        </div>
    </div>
</div>

<style>
    @media print {
        body { background: white !important; color: black !important; }
        aside, header, #sidebarToggle, form, .filter-header, button, #printModal, .bg-[#111827], main header { display: none !important; }
        main { padding: 0 !important; margin: 0 !important; width: 100% !important; background: white !important; }
        .hidden.print\:block { display: block !important; }
        .page-break-after-always { page-break-after: always; }
        
        /* Reset table styles for print */
        table { width: 100% !important; border-collapse: collapse !important; }
        th, td { border: 1px solid black !important; color: black !important; }
    }
</style>

<script>
    function openPrintModal() {
        const modal = document.getElementById('printModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closePrintModal() {
        const modal = document.getElementById('printModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');
    }

    function doPrint() {
        const kota = document.getElementById('inputKota').value;
        const tanggal = document.getElementById('inputTanggal').value;
        const instansi = document.getElementById('inputInstansi').value;
        const nama = document.getElementById('inputNama').value || '............................';
        const nip = document.getElementById('inputNip').value || '............................';

        // Update all signature sections in the printable area
        @foreach($reportData as $index => $data)
            document.getElementById('displayKotaTanggal_{{ $index }}').textContent = kota + ', ' + tanggal;
            document.getElementById('displayInstansi_{{ $index }}').textContent = instansi;
            document.getElementById('displayNama_{{ $index }}').textContent = '( ' + nama + ' )';
            document.getElementById('displayNip_{{ $index }}').textContent = 'NIP. ' + nip;
        @endforeach
        
        closePrintModal();
        setTimeout(() => {
            window.print();
        }, 500);
    }
</script>
@endsection
