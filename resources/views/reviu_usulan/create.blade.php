@extends('layouts.app')

@section('title', 'Create Reviu Usulan Risiko')
@section('page_title', 'Create Reviu Usulan')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Reviu Usulan Risiko Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Gunakan formulir ini untuk mereviu usulan risiko yang baru masuk.</p>
        </div>
        <div class="flex gap-4">
            <button type="button" onclick="addRow()" class="flex items-center justify-center px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all active:scale-95 group shadow-lg shadow-emerald-500/20">
                <i data-lucide="plus" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
                <span class="text-xs uppercase tracking-[0.2em]">Tambah Baris</span>
            </button>
            <a href="{{ route('reviu-usulan.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('reviu-usulan.store') }}" method="POST">
        @csrf
        <div id="rows-container" class="space-y-12">
            <!-- Initial Row -->
            <div class="row-item bg-slate-900/30 p-8 rounded-[2rem] border border-slate-800/50 relative group/row animate-in fade-in slide-in-from-top-4 duration-500">
                <div class="absolute -left-4 top-8 w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center font-black text-xs shadow-lg shadow-blue-500/20 z-20 row-number">1</div>
                
                <div class="space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Pilih Kode Risiko (Filter 4)</label>
                                <div class="relative group">
                                    <select name="rows[0][resiko_id]" required class="resiko_id w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none cursor-pointer appearance-none">
                                        <option value="" selected disabled hidden>-- Pilih Kode --</option>
                                        @foreach($resikos as $r)
                                            @php
                                                $identifikasi = \App\Models\IdentifikasiRisiko::where('pernyataan_risiko', $r->pernyataan_risiko)->first();
                                                $kodeRisiko = $identifikasi ? $identifikasi->kode_risiko : '-';
                                            @endphp
                                            <option value="{{ $r->id }}">{{ $kodeRisiko }} - {{ $r->kode }} - {{ Str::limit($r->pernyataan_risiko, 50) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500 group-hover:text-blue-400 transition-colors">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Usulan Pernyataan Risiko</label>
                                <textarea name="rows[0][usulan_pernyataan_risiko]" rows="3" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Tuliskan usulan pernyataan risiko baru..."></textarea>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Unit Pemilik Risiko Pengusul (Pegawai)</label>
                                <input type="text" name="rows[0][unit_pemilik_pengusul]" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all outline-none" placeholder="Nama Pegawai / Unit...">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Status Reviu</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex items-center justify-center p-4 bg-slate-800/30 rounded-2xl border-2 border-transparent cursor-pointer transition-all hover:bg-emerald-500/5 has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/10 group">
                                        <input type="radio" name="rows[0][status]" value="Diterima" class="status-radio hidden" checked onchange="toggleAlasan(this)">
                                        <div class="flex items-center space-x-3">
                                            <i data-lucide="check-circle" class="w-5 h-5 text-slate-600 group-hover:text-emerald-400 transition-colors"></i>
                                            <span class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-emerald-400">Diterima</span>
                                        </div>
                                    </label>
                                    <label class="relative flex items-center justify-center p-4 bg-slate-800/30 rounded-2xl border-2 border-transparent cursor-pointer transition-all hover:bg-rose-500/5 has-[:checked]:border-rose-500/50 has-[:checked]:bg-rose-500/10 group">
                                        <input type="radio" name="rows[0][status]" value="Ditolak" class="status-radio hidden" onchange="toggleAlasan(this)">
                                        <div class="flex items-center space-x-3">
                                            <i data-lucide="x-circle" class="w-5 h-5 text-slate-600 group-hover:text-rose-400 transition-colors"></i>
                                            <span class="text-xs font-black uppercase tracking-widest text-slate-500 group-hover:text-rose-400">Ditolak</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                        <div class="alasan_diterima_group animate-in fade-in slide-in-from-top-2 duration-300">
                            <label class="block text-[11px] font-black text-emerald-400 uppercase tracking-widest mb-3 ml-1">Alasan Jika Diterima (Opsional)</label>
                            <textarea name="rows[0][alasan_diterima]" rows="3" class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all outline-none resize-none" placeholder="Tuliskan catatan atau alasan diterima..."></textarea>
                        </div>
                        <div class="alasan_ditolak_group hidden animate-in fade-in slide-in-from-top-2 duration-300">
                            <label class="block text-[11px] font-black text-rose-400 uppercase tracking-widest mb-3 ml-1">Alasan Jika Ditolak</label>
                            <textarea name="rows[0][alasan_ditolak]" rows="3" class="alasan_ditolak_field w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all outline-none resize-none" placeholder="Berikan alasan penolakan..."></textarea>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="removeRow(this)" class="remove-btn hidden absolute -right-4 top-8 w-8 h-8 bg-rose-500 text-white rounded-lg flex items-center justify-center hover:bg-rose-600 transition-all z-20 shadow-lg shadow-rose-500/20">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="pt-10 flex space-x-4 border-t border-slate-800 mt-12">
            <button type="submit" class="px-10 py-4 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-blue-500/20 active:scale-95 flex items-center gap-3">
                <i data-lucide="save" class="w-5 h-5"></i>
                <span>Simpan Semua Reviu</span>
            </button>
        </div>
    </form>
</div>

<script>
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
        
        // Reset inputs and handle radio unique names
        const uniqueName = `rows[${rowCount}][status]`;
        newRow.querySelectorAll('input, select, textarea').forEach(input => {
            if (input.type === 'radio') {
                input.name = uniqueName;
                if (input.value === 'Diterima') input.checked = true;
                else input.checked = false;
            } else {
                input.value = '';
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/rows\[\d+\]/, `rows[${rowCount}]`));
                }
            }
        });

        newRow.querySelector('.alasan_diterima_group').classList.remove('hidden');
        newRow.querySelector('.alasan_ditolak_group').classList.add('hidden');
        newRow.querySelector('.alasan_ditolak_field').removeAttribute('required');

        container.appendChild(newRow);
        rowCount++;
        updateRowNumbers();
        lucide.createIcons();
    }

    function removeRow(btn) {
        const row = btn.closest('.row-item');
        row.classList.add('animate-out', 'fade-out', 'zoom-out-95', 'duration-300');
        setTimeout(() => {
            row.remove();
            updateRowNumbers();
        }, 300);
    }

    function toggleAlasan(radio) {
        const row = radio.closest('.row-item');
        const status = radio.value;
        const diterimaGroup = row.querySelector('.alasan_diterima_group');
        const ditolakGroup = row.querySelector('.alasan_ditolak_group');
        const ditolakField = row.querySelector('.alasan_ditolak_field');

        if (status === 'Diterima') {
            diterimaGroup.classList.remove('hidden');
            ditolakGroup.classList.add('hidden');
            ditolakField.removeAttribute('required');
        } else {
            diterimaGroup.classList.add('hidden');
            ditolakGroup.classList.remove('hidden');
            ditolakField.setAttribute('required', 'required');
        }
    }
</script>
@endsection
