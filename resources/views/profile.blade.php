@extends('layouts.app')

@section('title', 'Halaman Profile')
@section('page_title', 'Profil Pengguna')

@section('content')
<div class="w-full">
    <div class="bg-[#031121] border border-[#D2A039]/20 rounded-[2.5rem] p-12 shadow-2xl relative overflow-hidden">
        <!-- Decoration side glow -->
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#D2A039]/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-[#D2A039]/5 rounded-full blur-3xl"></div>

        <div class="flex flex-col md:flex-row items-center space-y-8 md:space-y-0 md:space-x-12 relative z-10">
            <div class="w-48 h-48 rounded-[3rem] bg-gradient-to-br from-[#D2A039]/20 to-[#f9d77e]/20 p-1 border border-[#D2A039]/30 shadow-2xl group overflow-hidden">
                <div class="w-full h-full bg-[#061B30] rounded-[2.8rem] flex items-center justify-center border border-[#D2A039]/20 transition-all duration-500 group-hover:scale-110">
                    <i data-lucide="user" class="w-20 h-20 text-[#D2A039] group-hover:text-[#f9d77e]"></i>
                </div>
            </div>
            
            <div class="flex-1 text-center md:text-left">
                <div class="mb-6">
                    <span class="inline-flex px-3 py-1 rounded-full bg-[#D2A039]/10 border border-[#D2A039]/20 text-[10px] font-black text-[#D2A039] uppercase tracking-widest mb-4">
                        Super Administrator Access
                    </span>
                    <h2 class="text-5xl font-black text-white tracking-widest leading-none mb-2">ADMIN UTAMA</h2>
                    <p class="text-slate-500 text-lg font-medium tracking-tight">admin@management.system</p>
                </div>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                    <div class="px-6 py-3 bg-[#061B30]/50 rounded-2xl border border-[#D2A039]/20 flex items-center">
                        <i data-lucide="shield-check" class="w-4 h-4 mr-3 text-emerald-400"></i>
                        <span class="text-sm font-bold text-slate-300">Verified System</span>
                    </div>
                    <div class="px-6 py-3 bg-[#061B30]/50 rounded-2xl border border-[#D2A039]/20 flex items-center">
                        <i data-lucide="calendar" class="w-4 h-4 mr-3 text-[#D2A039]"></i>
                        <span class="text-sm font-bold text-slate-300">Joined April 2024</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-16 border-t border-[#D2A039]/20 pt-16">
            <div class="bg-[#061B30]/20 p-8 rounded-3xl border border-[#D2A039]/20">
                <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-6">Personal Informations</h4>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-slate-500">Full Name</span>
                        <span class="text-sm font-bold text-white tracking-tight">Admin Administrator</span>
                    </div>
                    <div class="flex items-center justify-between border-t border-[#D2A039]/20 pt-4">
                        <span class="text-sm font-medium text-slate-500">Security Level</span>
                        <div class="flex space-x-1">
                            @for($i=0; $i<5; $i++)
                            <div class="w-1.5 h-1.5 rounded-full bg-[#D2A039]/60 shadow-[0_0_8px_rgba(210,160,57,0.5)]"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="flex items-center justify-between border-t border-[#D2A039]/20 pt-4">
                        <span class="text-sm font-medium text-slate-500">Assigned Branch</span>
                        <span class="text-sm font-black text-[#D2A039] tracking-tighter uppercase whitespace-nowrap">KANTOR PUSAT CANARY</span>
                    </div>
                </div>
            </div>

            <div class="bg-[#061B30]/20 p-8 rounded-3xl border border-[#D2A039]/20 flex flex-col justify-between">
                <div>
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-6">Security Settings</h4>
                    <p class="text-sm text-slate-400 mb-8 italic italic italic italic italic italic italic italic">Secure your account by enabling multi-factor authentication and updating your security keys.</p>
                </div>
                <button class="w-full py-4 bg-[#D2A039] hover:bg-[#b88a2e] text-[#061B30] font-black rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 active:scale-95 text-xs uppercase tracking-widest">
                    Update Security
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
