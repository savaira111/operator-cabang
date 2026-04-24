@extends('layouts.app')

@section('title', 'Detail Zona Integritas')
@section('page_title', 'Detail Progres Zona Integritas')

@section('content')
<div class="w-full">
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden mb-8">
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/5 rounded-full blur-3xl"></div>
        
        <div class="flex items-start justify-between relative z-10 mb-8">
            <div class="flex items-center">
                <div class="w-16 h-16 rounded-2xl bg-[#D2A039]/10 border border-[#D2A039]/20 flex items-center justify-center text-[#D2A039] mr-6">
                    <i data-lucide="award" class="w-8 h-8"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-white tracking-tight uppercase">{{ $zi->cabang->name }}</h3>
                    <p class="text-slate-500 text-sm mt-1 font-bold">Progres Pembangunan Zona Integritas Menuju {{ $zi->predikat }}</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('zis.index') }}" class="px-5 py-2.5 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white font-bold rounded-2xl border border-slate-700/50 transition-all text-xs uppercase tracking-widest">
                    <i data-lucide="arrow-left" class="w-4 h-4 inline mr-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 relative z-10">
            <div class="bg-slate-800/20 border border-slate-800/50 p-5 rounded-2xl">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Tahun/Bulan</p>
                <p class="text-lg font-bold text-white">{{ $zi->tahun }} <span class="text-xs text-slate-400">{{ $zi->bulan ? '('.$zi->bulan.')' : '' }}</span></p>
            </div>
            <div class="bg-slate-800/20 border border-slate-800/50 p-5 rounded-2xl">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Predikat Target</p>
                <p class="text-lg font-bold text-indigo-400">{{ $zi->predikat }}</p>
            </div>
            <div class="bg-slate-800/20 border border-slate-800/50 p-5 rounded-2xl">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Status</p>
                <p class="text-lg font-bold {{ $zi->status == 'Selesai' ? 'text-emerald-400' : 'text-[#D2A039]' }} uppercase">{{ $zi->status }}</p>
            </div>
            <div class="bg-slate-800/20 border border-slate-800/50 p-5 rounded-2xl flex items-center justify-between">
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Soal LKE</p>
                    <p class="text-lg font-bold text-white">{{ $zi->allSoals->where('tipe', 'soal')->count() }} Soal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- LKE Builder Section -->
    <div class="bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl relative overflow-hidden">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h4 class="text-xl font-black text-white tracking-tight uppercase">Lembar Kerja Evaluasi (LKE)</h4>
                <p class="text-slate-500 text-sm mt-1">Kelola struktur kategori dan pertanyaan LKE ZI.</p>
            </div>
            <button onclick="openSoalModal()" class="px-5 py-2.5 bg-[#D2A039] hover:bg-[#b88a2e] text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 text-xs uppercase tracking-widest">
                <i data-lucide="plus" class="w-4 h-4 inline mr-1"></i> Kategori Utama
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800/30 border-b border-slate-700/50">
                        <th class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-16">No</th>
                        <th class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Uraian / Judul</th>
                        <th class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-24 text-center">Bobot</th>
                        <th class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-24">Tipe Jawaban</th>
                        <th class="px-4 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest w-32 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @forelse($zi->soals as $soal)
                        @include('zis._soal_row', ['soal' => $soal, 'level' => 0])
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-500">
                                Belum ada data LKE. Silakan tambah kategori utama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="soalModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
    <div class="bg-[#111827] border border-slate-700 rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto shadow-2xl relative">
        <div class="p-6 border-b border-slate-700 flex items-center justify-between sticky top-0 bg-[#111827] z-10">
            <h5 class="text-lg font-black text-white uppercase tracking-tight" id="modalTitle">Tambah Item LKE</h5>
            <button onclick="closeSoalModal()" class="text-slate-400 hover:text-white transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        
        <form id="soalForm" action="{{ route('zi_soals.store', $zi) }}" method="POST" class="p-6 space-y-5">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="parent_id" id="inputParentId" value="">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tipe Item</label>
                    <select name="tipe" id="inputTipe" onchange="toggleSoalFields()" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3">
                        <option value="kategori">Kategori (Mempunyai Sub)</option>
                        <option value="soal">Soal / Indikator (Ada Input Jawaban)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nomor/Kode (Misal: A, I, 1, a)</label>
                    <input type="text" name="nomor" id="inputNomor" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="A.">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Judul / Uraian</label>
                <textarea name="judul" id="inputJudul" rows="2" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="Misal: PENGUNGKIT / Manajemen Perubahan"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Bobot (%)</label>
                    <input type="number" step="0.01" name="bobot" id="inputBobot" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="60.00">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Urutan (Sorting)</label>
                    <input type="number" name="urutan" id="inputUrutan" value="0" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3">
                </div>
            </div>

            <!-- Fields for 'Soal' Only -->
            <div id="soalFields" class="hidden space-y-5 border-t border-slate-700 pt-5 mt-5">
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Kriteria Nilai (Kondisi Ya/Tidak)</label>
                    <textarea name="kriteria_nilai" id="inputKriteriaNilai" rows="2" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="Ya, jika Tim telah dibentuk di dalam unit kerja..."></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tipe Pilihan Jawaban</label>
                        <select name="tipe_jawaban" id="inputTipeJawaban" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3">
                            <option value="">-- Pilih --</option>
                            <option value="ya_tidak">Ya / Tidak</option>
                            <option value="a_b_c">A / B / C</option>
                            <option value="a_b_c_d">A / B / C / D</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nilai Standar Per Soal (Maksimal)</label>
                        <input type="number" step="0.01" name="nilai_standar" id="inputNilaiStandar" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="1.00">
                    </div>
                </div>

                <div class="space-y-3">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Keterangan Pilihan (Jika Tipe A/B/C/D)</p>
                    <input type="text" name="penjelasan_a" id="inputPenjelasanA" class="w-full bg-[#061B30] border border-slate-700 text-white text-xs rounded-xl p-3" placeholder="Pilihan A: Jika dengan prosedur yang jelas...">
                    <input type="text" name="penjelasan_b" id="inputPenjelasanB" class="w-full bg-[#061B30] border border-slate-700 text-white text-xs rounded-xl p-3" placeholder="Pilihan B: Jika sebagian prosedur jelas...">
                    <input type="text" name="penjelasan_c" id="inputPenjelasanC" class="w-full bg-[#061B30] border border-slate-700 text-white text-xs rounded-xl p-3" placeholder="Pilihan C: Jika tidak dilakukan...">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Jml Bukti Dukung (Upload)</label>
                        <input type="number" name="kebutuhan_bukti_dukung" id="inputKebutuhanBukti" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="Contoh: 3, 7, 10">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Keterangan Bukti Dukung</label>
                        <textarea name="keterangan_bukti_dukung" id="inputKeteranganBukti" rows="2" class="w-full bg-[#061B30] border border-slate-700 text-white text-sm rounded-xl focus:border-blue-500 p-3" placeholder="1. SK Tim Kerja, 2. Notula..."></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <button type="button" onclick="closeSoalModal()" class="px-5 py-2.5 text-slate-400 hover:text-white font-bold text-xs uppercase tracking-widest">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-black rounded-xl transition-all shadow-lg shadow-blue-500/20 text-xs uppercase tracking-widest">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleSoalFields() {
        const tipe = document.getElementById('inputTipe').value;
        const fields = document.getElementById('soalFields');
        if(tipe === 'soal') {
            fields.classList.remove('hidden');
        } else {
            fields.classList.add('hidden');
        }
    }

    function openSoalModal(parentId = '', type = 'kategori', editData = null) {
        document.getElementById('soalModal').classList.remove('hidden');
        document.getElementById('soalForm').reset();
        
        document.getElementById('inputParentId').value = parentId;
        document.getElementById('inputTipe').value = type;
        
        toggleSoalFields();

        if (editData) {
            document.getElementById('modalTitle').innerText = 'Edit Item LKE';
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('soalForm').action = '/zi_soals/' + editData.id;
            
            document.getElementById('inputNomor').value = editData.nomor || '';
            document.getElementById('inputJudul').value = editData.judul || '';
            document.getElementById('inputBobot').value = editData.bobot || '';
            document.getElementById('inputUrutan').value = editData.urutan || 0;
            
            if (editData.tipe === 'soal') {
                document.getElementById('inputKriteriaNilai').value = editData.kriteria_nilai || '';
                document.getElementById('inputTipeJawaban').value = editData.tipe_jawaban || '';
                document.getElementById('inputNilaiStandar').value = editData.nilai_standar || '';
                document.getElementById('inputPenjelasanA').value = editData.penjelasan_a || '';
                document.getElementById('inputPenjelasanB').value = editData.penjelasan_b || '';
                document.getElementById('inputPenjelasanC').value = editData.penjelasan_c || '';
                document.getElementById('inputKebutuhanBukti').value = editData.kebutuhan_bukti_dukung || '';
                document.getElementById('inputKeteranganBukti').value = editData.keterangan_bukti_dukung || '';
            }
        } else {
            document.getElementById('modalTitle').innerText = 'Tambah Item LKE';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('soalForm').action = '{{ route("zi_soals.store", $zi) }}';
        }
    }

    function closeSoalModal() {
        document.getElementById('soalModal').classList.add('hidden');
    }
</script>
@endsection
