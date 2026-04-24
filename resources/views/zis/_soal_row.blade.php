<tr class="{{ $level == 0 ? 'bg-slate-800/20' : 'hover:bg-slate-800/10' }} transition-colors">
    <td class="px-4 py-3 align-top">
        <span class="text-xs font-bold {{ $level == 0 ? 'text-white' : 'text-slate-400' }}" style="margin-left: {{ $level * 1.5 }}rem;">
            {{ $soal->nomor }}
        </span>
    </td>
    <td class="px-4 py-3 align-top">
        <div style="margin-left: {{ $level * 1.5 }}rem;">
            <p class="text-xs {{ $level == 0 ? 'font-black text-[#D2A039] uppercase tracking-widest' : ($soal->tipe == 'kategori' ? 'font-bold text-white' : 'text-slate-300') }} leading-relaxed">
                {{ $soal->judul }}
            </p>
            @if($soal->tipe == 'soal' && $soal->kriteria_nilai)
                <p class="text-[10px] text-slate-500 mt-1 italic leading-relaxed whitespace-pre-line">{{ $soal->kriteria_nilai }}</p>
                <div class="mt-2 bg-[#061B30] p-3 rounded-xl border border-slate-700/50">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Bukti Dukung ({{ $soal->kebutuhan_bukti_dukung }} File):</p>
                    <p class="text-[10px] text-slate-400">{{ $soal->keterangan_bukti_dukung }}</p>
                </div>
            @endif
        </div>
    </td>
    <td class="px-4 py-3 align-top text-center">
        <span class="text-xs font-mono font-bold {{ $soal->bobot ? 'text-indigo-400' : 'text-slate-600' }}">
            {{ $soal->bobot ? number_format($soal->bobot, 2) : '-' }}
        </span>
        @if($soal->tipe == 'soal' && $soal->nilai_standar)
            <p class="text-[9px] text-slate-500 mt-1 uppercase tracking-widest">Max: {{ $soal->nilai_standar }}</p>
        @endif
    </td>
    <td class="px-4 py-3 align-top">
        @if($soal->tipe == 'soal' && $soal->tipe_jawaban)
            <span class="inline-block px-2 py-1 bg-slate-800 border border-slate-700 rounded text-[9px] font-black text-slate-400 uppercase tracking-widest">
                {{ str_replace('_', ' ', $soal->tipe_jawaban) }}
            </span>
            @if($soal->tipe_jawaban != 'ya_tidak')
                <div class="mt-2 space-y-1">
                    @if($soal->penjelasan_a)<p class="text-[9px] text-slate-500 truncate" title="{{ $soal->penjelasan_a }}"><span class="font-bold text-white">A.</span> {{ $soal->penjelasan_a }}</p>@endif
                    @if($soal->penjelasan_b)<p class="text-[9px] text-slate-500 truncate" title="{{ $soal->penjelasan_b }}"><span class="font-bold text-white">B.</span> {{ $soal->penjelasan_b }}</p>@endif
                    @if($soal->penjelasan_c)<p class="text-[9px] text-slate-500 truncate" title="{{ $soal->penjelasan_c }}"><span class="font-bold text-white">C.</span> {{ $soal->penjelasan_c }}</p>@endif
                </div>
            @endif
        @else
            <span class="text-[10px] text-slate-600">-</span>
        @endif
    </td>
    <td class="px-4 py-3 align-top text-right">
        <div class="flex items-center justify-end space-x-1">
            @if($soal->tipe == 'kategori')
                <button onclick="openSoalModal('{{ $soal->id }}', 'kategori')" class="p-1.5 bg-slate-800/50 hover:bg-[#D2A039]/10 text-slate-400 hover:text-[#D2A039] rounded-lg transition-all" title="Tambah Sub Kategori">
                    <i data-lucide="folder-plus" class="w-3.5 h-3.5"></i>
                </button>
                <button onclick="openSoalModal('{{ $soal->id }}', 'soal')" class="p-1.5 bg-slate-800/50 hover:bg-blue-500/10 text-slate-400 hover:text-blue-400 rounded-lg transition-all" title="Tambah Soal Indikator">
                    <i data-lucide="file-plus" class="w-3.5 h-3.5"></i>
                </button>
            @endif
            <button onclick="openSoalModal('{{ $soal->parent_id }}', '{{ $soal->tipe }}', {{ json_encode($soal) }})" class="p-1.5 bg-slate-800/50 hover:bg-slate-700 text-slate-400 hover:text-white rounded-lg transition-all">
                <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
            </button>
            <form action="{{ route('zi_soals.destroy', $soal) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" onclick="if(confirm('Hapus item ini beserta sub-nya?')) this.form.submit()" class="p-1.5 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 rounded-lg transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                </button>
            </form>
        </div>
    </td>
</tr>

@foreach($soal->children as $child)
    @include('zis._soal_row', ['soal' => $child, 'level' => $level + 1])
@endforeach
