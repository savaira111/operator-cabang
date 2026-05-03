@extends('layouts.app')

@section('title', 'Master Resiko')
@section('page_title', 'Master Data Resiko')

@section('content')
<div class="mb-8" x-data="{ activeTab: 'risk' }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-3xl font-black text-white tracking-tighter uppercase">Master Resiko</h3>
            <p class="text-slate-500 text-sm mt-1 tracking-tight">Kelola standarisasi kode risiko dan kode penyebab untuk laporan LPI.</p>
        </div>
        <div class="flex bg-[#031121] p-1.5 rounded-2xl border border-[#D2A039]/20 shadow-inner">
            <button @click="activeTab = 'risk'" :class="activeTab === 'risk' ? 'bg-[#D2A039] text-[#061B30]' : 'text-slate-500 hover:text-white'" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                Kode Risiko
            </button>
            <button @click="activeTab = 'cause'" :class="activeTab === 'cause' ? 'bg-[#D2A039] text-[#061B30]' : 'text-slate-500 hover:text-white'" class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300">
                Kode Penyebab
            </button>
        </div>
    </div>

    <!-- TAB: KODE RISIKO -->
    <div x-show="activeTab === 'risk'" class="animate-in fade-in zoom-in-95 duration-500">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Card -->
            <div class="lg:col-span-1">
                <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#D2A039]/5 blur-[80px] rounded-full group-hover:bg-[#D2A039]/10 transition-all duration-700"></div>
                    
                    <h4 class="text-lg font-black text-white uppercase tracking-tighter mb-6 flex items-center">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-3 text-[#D2A039]"></i>
                        Tambah Kode Risiko
                    </h4>

                    <form action="{{ route('master-resiko.store-risk') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Risiko</label>
                            <input type="text" name="kode" required class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4 transition-all" placeholder="Contoh: R.01">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama / Pernyataan Risiko</label>
                            <textarea name="nama_risiko" required rows="4" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-[#D2A039]/10 focus:border-[#D2A039] block p-4 transition-all resize-none" placeholder="Deskripsikan risiko..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black rounded-2xl shadow-xl shadow-[#D2A039]/20 active:scale-95 transition-all uppercase text-[10px] tracking-[0.2em]">
                            Simpan Kode Risiko
                        </button>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="lg:col-span-2">
                <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#D2A039]/5 border-b border-[#D2A039]/10">
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest w-24">Kode</th>
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Pernyataan Risiko</th>
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#D2A039]/5">
                                @forelse($riskCodes as $risk)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 bg-[#D2A039]/10 text-[#D2A039] rounded-lg text-xs font-black border border-[#D2A039]/20">
                                            {{ $risk->kode }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm text-slate-300 leading-relaxed font-medium">{{ $risk->nama_risiko }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <form action="{{ route('master-resiko.destroy-risk', $risk) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-600 italic text-sm">Belum ada data kode risiko.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB: KODE PENYEBAB -->
    <div x-show="activeTab === 'cause'" class="animate-in fade-in zoom-in-95 duration-500">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Card -->
            <div class="lg:col-span-1">
                <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-500/5 blur-[80px] rounded-full group-hover:bg-blue-500/10 transition-all duration-700"></div>
                    
                    <h4 class="text-lg font-black text-white uppercase tracking-tighter mb-6 flex items-center">
                        <i data-lucide="zap" class="w-5 h-5 mr-3 text-blue-400"></i>
                        Tambah Kode Penyebab
                    </h4>

                    <form action="{{ route('master-resiko.store-cause') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kode Penyebab</label>
                            <input type="text" name="kode" required class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 block p-4 transition-all" placeholder="Contoh: P.01">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama / Kategori Penyebab</label>
                            <textarea name="nama_penyebab" required rows="4" class="w-full bg-[#061B30] border border-slate-800 text-white text-sm rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 block p-4 transition-all resize-none" placeholder="Deskripsikan penyebab..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase text-[10px] tracking-[0.2em]">
                            Simpan Kode Penyebab
                        </button>
                    </form>
                </div>
            </div>

            <!-- Table Card -->
            <div class="lg:col-span-2">
                <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] overflow-hidden shadow-2xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-blue-500/5 border-b border-blue-500/10">
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest w-24">Kode</th>
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest">Kategori Penyebab</th>
                                    <th class="px-6 py-5 text-[9px] font-black text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-blue-500/5">
                                @forelse($causeCodes as $cause)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-lg text-xs font-black border border-blue-500/20">
                                            {{ $cause->kode }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <p class="text-sm text-slate-300 leading-relaxed font-medium">{{ $cause->nama_penyebab }}</p>
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <form action="{{ route('master-resiko.destroy-cause', $cause) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-500 hover:text-rose-400 hover:bg-rose-400/10 rounded-xl transition-all" onclick="confirmHapus(event, this.form)">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-slate-600 italic text-sm">Belum ada data kode penyebab.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection
