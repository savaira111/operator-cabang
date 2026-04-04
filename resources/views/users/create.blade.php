@extends('layouts.app')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Registrasi Pengguna Baru')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Registrasi Baru</h3>
            <p class="text-slate-500 text-sm mt-1">Tambahkan kredensial untuk pengguna sistem yang baru.</p>
        </div>
        <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
            <span class="text-xs uppercase tracking-widest">Batal</span>
        </a>
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="space-y-8">
            <!-- Systems Info -->
            <div class="p-6 bg-indigo-500/5 rounded-3xl border border-indigo-500/10 flex items-start">
                <div class="p-2 bg-indigo-500/10 rounded-xl mr-4 text-indigo-400">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-xs font-black text-indigo-300 uppercase tracking-widest mb-1">Status Automasi</p>
                    <p class="text-sm text-slate-400 leading-relaxed">ID Pengguna akan dihasilkan secara otomatis oleh sistem saat data disimpan.</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Andi Wijaya">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Username</label>
                    <input type="text" name="username" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="andiwijaya">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Role Akses</label>
                    <select name="role" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="" selected disabled hidden>-- Pilih Role Akses --</option>
                        <option value="operator admin" class="bg-[#111827]">Operator Admin</option>
                        <option value="operator kanwil" class="bg-[#111827]">Operator Kanwil</option>
                        <option value="operator cabang" class="bg-[#111827]">Operator Cabang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penempatan</label>
                    <select name="cabang_id" class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="" selected disabled hidden>-- Pilih Lokasi Penempatan --</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" class="bg-[#111827]">{{ $cabang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                <input type="email" name="email" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="andi@example.com">
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Kata Sandi</label>
                    <div class="relative group/pass">
                        <input type="password" name="password" id="password" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none pr-14" placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-slate-500 hover:text-white transition-colors">
                            <i data-lucide="eye" id="toggleIcon1" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div id="passwordHelp" class="mt-4 p-4 bg-slate-900/50 rounded-2xl border border-slate-800 space-y-2 hidden opacity-0 transform -translate-y-2 transition-all duration-500 overflow-hidden">
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Persyaratan Keamanan:</p>
                        <div class="grid grid-cols-1 gap-1.5">
                            <p class="text-[10px] text-slate-500 flex items-center transition-all duration-500" id="rule-min">
                                <i data-lucide="circle" class="w-3 h-3 mr-2 text-slate-600 icon-rule"></i>Minimal 8 Karakter
                            </p>
                            <p class="text-[10px] text-slate-500 flex items-center transition-all duration-500" id="rule-upper">
                                <i data-lucide="circle" class="w-3 h-3 mr-2 text-slate-600 icon-rule"></i>Huruf Besar (A-Z)
                            </p>
                            <p class="text-[10px] text-slate-500 flex items-center transition-all duration-500" id="rule-lower">
                                <i data-lucide="circle" class="w-3 h-3 mr-2 text-slate-600 icon-rule"></i>Huruf Kecil (a-z)
                            </p>
                            <p class="text-[10px] text-slate-500 flex items-center transition-all duration-500" id="rule-num">
                                <i data-lucide="circle" class="w-3 h-3 mr-2 text-slate-600 icon-rule"></i>Angka (0-9)
                            </p>
                            <p class="text-[10px] text-slate-500 flex items-center transition-all duration-500" id="rule-symbol">
                                <i data-lucide="circle" class="w-3 h-3 mr-2 text-slate-600 icon-rule"></i>Simbol (@$!%*#?&)
                            </p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Konfirmasi</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none pr-14" placeholder="••••••••">
                        <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-slate-500 hover:text-white transition-colors">
                            <i data-lucide="eye" id="toggleIcon2" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <p id="match-status" class="text-[10px] mt-4 font-black uppercase tracking-[0.2em] hidden text-center py-2 rounded-xl border border-transparent transition-all"></p>
                </div>
            </div>

            <script>
                function togglePassword(inputId, iconId) {
                    const input = document.getElementById(inputId);
                    const icon = document.getElementById(iconId);
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.setAttribute('data-lucide', 'eye-off');
                    } else {
                        input.type = 'password';
                        icon.setAttribute('data-lucide', 'eye');
                    }
                    lucide.createIcons();
                }

                const password = document.getElementById('password');
                const confirm = document.getElementById('password_confirmation');
                const matchStatus = document.getElementById('match-status');
                const helpDiv = document.getElementById('passwordHelp');

                const rules = {
                    min: { regex: /.{8,}/, el: document.getElementById('rule-min') },
                    upper: { regex: /[A-Z]/, el: document.getElementById('rule-upper') },
                    lower: { regex: /[a-z]/, el: document.getElementById('rule-lower') },
                    num: { regex: /[0-9]/, el: document.getElementById('rule-num') },
                    symbol: { regex: /[@$!%*#?&]/, el: document.getElementById('rule-symbol') }
                };

                // Focus/Blur Animation
                password.addEventListener('focus', () => {
                    helpDiv.classList.remove('hidden');
                    setTimeout(() => {
                        helpDiv.classList.remove('opacity-0', '-translate-y-2');
                    }, 10);
                });

                password.addEventListener('blur', () => {
                    helpDiv.classList.add('opacity-0', '-translate-y-2');
                    setTimeout(() => {
                        helpDiv.classList.add('hidden');
                    }, 500); // Wait for transition
                });

                function updateRule(rule, isValid) {
                    const el = rule.el;
                    const icon = el.querySelector('.icon-rule');
                    
                    if (isValid) {
                        if (!el.classList.contains('text-emerald-400')) {
                            el.classList.remove('text-slate-500');
                            el.classList.add('text-emerald-400', 'scale-[1.02]', 'font-black');
                            icon.setAttribute('data-lucide', 'check-circle');
                            icon.classList.remove('text-slate-600');
                            icon.classList.add('text-emerald-500');
                            lucide.createIcons();
                        }
                    } else {
                        el.classList.add('text-slate-500');
                        el.classList.remove('text-emerald-400', 'scale-[1.02]', 'font-black');
                        icon.setAttribute('data-lucide', 'circle');
                        icon.classList.add('text-slate-600');
                        icon.classList.remove('text-emerald-500');
                        lucide.createIcons();
                    }
                }

                function validatePasswords() {
                    const val = password.value;
                    const confVal = confirm.value;
                    
                    let allValid = true;
                    for (const key in rules) {
                        const isValid = rules[key].regex.test(val);
                        updateRule(rules[key], isValid);
                        if (!isValid) allValid = false;
                    }
                    
                    if (val.length > 0) {
                        password.classList.remove('border-slate-700');
                        password.classList.toggle('border-emerald-500', allValid);
                        password.classList.toggle('border-rose-500', !allValid);
                    } else {
                        password.classList.add('border-slate-700');
                        password.classList.remove('border-emerald-500', 'border-rose-500');
                    }

                    if (confVal.length > 0) {
                        matchStatus.classList.remove('hidden');
                        if (val === confVal) {
                            confirm.classList.remove('border-slate-700', 'border-rose-500', 'bg-rose-500/5', 'text-rose-400');
                            confirm.classList.add('border-emerald-500', 'bg-emerald-500/5', 'text-emerald-400');
                            matchStatus.innerText = '✓ KONFIRMASI COCOK';
                            matchStatus.classList.remove('text-rose-500', 'border-rose-500/20');
                            matchStatus.classList.add('text-emerald-500', 'border-emerald-500/20', 'bg-emerald-500/5');
                        } else {
                            confirm.classList.remove('border-slate-700', 'border-emerald-500', 'bg-emerald-500/5', 'text-emerald-400');
                            confirm.classList.add('border-rose-500', 'bg-rose-500/5', 'text-rose-400');
                            matchStatus.innerText = '✕ KONFIRMASI TIDAK COCOK';
                            matchStatus.classList.remove('text-emerald-500', 'border-emerald-500/20');
                            matchStatus.classList.add('text-rose-500', 'border-rose-500/20', 'bg-rose-500/5');
                        }
                    } else {
                        confirm.classList.add('border-slate-700');
                        confirm.classList.remove('border-emerald-500', 'border-rose-500', 'bg-emerald-500/5', 'bg-rose-500/5');
                        matchStatus.classList.add('hidden');
                    }
                }

                password.addEventListener('input', validatePasswords);
                confirm.addEventListener('input', validatePasswords);
            </script>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                    Daftarkan Sekarang
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
