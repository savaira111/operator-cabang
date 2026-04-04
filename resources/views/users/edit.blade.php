@extends('layouts.app')

@section('title', 'Edit Pengguna')
@section('page_title', 'Update Pengguna')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 flex items-start justify-between">
        <div>
            <h3 class="text-2xl font-black text-white tracking-tight">Update Pengguna</h3>
            <p class="text-slate-500 text-sm mt-1">Modifikasi hak akses dan informasi akun.</p>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-3 bg-slate-800/80 rounded-2xl border border-slate-700/50">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">ID</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
                <i data-lucide="x" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                <span class="text-xs uppercase tracking-widest">Batal</span>
            </a>
        </div>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-8">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="Andi Wijaya">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="andiwijaya">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Role Akses</label>
                    <select name="role" required class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="operator admin" {{ $user->role == 'operator admin' ? 'selected' : '' }} class="bg-[#111827]">Operator Admin</option>
                        <option value="operator kanwil" {{ $user->role == 'operator kanwil' ? 'selected' : '' }} class="bg-[#111827]">Operator Kanwil</option>
                        <option value="operator cabang" {{ $user->role == 'operator cabang' ? 'selected' : '' }} class="bg-[#111827]">Operator Cabang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Penempatan</label>
                    <select name="cabang_id" class="w-full px-5 py-4 bg-[#1d2333] rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none appearance-none cursor-pointer">
                        <option value="" class="bg-[#111827]">-- Tanpa Cabang (Pusat/Kanwil) --</option>
                        @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}" {{ $user->cabang_id == $cabang->id ? 'selected' : '' }} class="bg-[#111827]">{{ $cabang->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required class="w-full px-5 py-4 bg-slate-800/50 rounded-2xl border border-slate-700 text-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" placeholder="andi@example.com">
            </div>

            <div class="p-8 bg-rose-500/5 rounded-[2rem] border border-rose-500/10 space-y-4">
                <div class="flex items-center text-rose-400 mb-2">
                    <i data-lucide="shield-check" class="w-4 h-4 mr-2"></i>
                    <span class="text-xs font-black uppercase tracking-widest">Keamanan Data</span>
                </div>
                <p class="text-xs text-slate-500 italic mb-4">Biarkan kosong jika tidak ingin mengubah kata sandi.</p>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-2 ml-1">Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="w-full px-5 py-3.5 bg-slate-800/50 rounded-xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500/30 transition-all outline-none text-sm pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-slate-600 hover:text-slate-400">
                                <i data-lucide="eye" id="toggleIcon1" class="w-4 h-4"></i>
                            </button>
                                       <div id="passwordHelp" class="mt-4 p-4 bg-slate-900/50 rounded-xl border border-slate-800 space-y-1.5 hidden opacity-0 transform -translate-y-2 transition-all duration-500 overflow-hidden">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Standard Keamanan:</p>
                            <div class="grid grid-cols-1 gap-1">
                                <p class="text-[9px] text-slate-500 flex items-center transition-all duration-500" id="rule-min">
                                    <i data-lucide="circle" class="w-2.5 h-2.5 mr-2 text-slate-600 icon-rule"></i>Minimal 8 Karakter
                                </p>
                                <p class="text-[9px] text-slate-500 flex items-center transition-all duration-500" id="rule-upper">
                                    <i data-lucide="circle" class="w-2.5 h-2.5 mr-2 text-slate-600 icon-rule"></i>Huruf Besar (A-Z)
                                </p>
                                <p class="text-[9px] text-slate-500 flex items-center transition-all duration-500" id="rule-lower">
                                    <i data-lucide="circle" class="w-2.5 h-2.5 mr-2 text-slate-600 icon-rule"></i>Huruf Kecil (a-z)
                                </p>
                                <p class="text-[9px] text-slate-500 flex items-center transition-all duration-500" id="rule-num">
                                    <i data-lucide="circle" class="w-2.5 h-2.5 mr-2 text-slate-600 icon-rule"></i>Angka (0-9)
                                </p>
                                <p class="text-[9px] text-slate-500 flex items-center transition-all duration-500" id="rule-symbol">
                                    <i data-lucide="circle" class="w-2.5 h-2.5 mr-2 text-slate-600 icon-rule"></i>Simbol (@$!%*#?&)
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-2 ml-1">Konfirmasi</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-5 py-3.5 bg-slate-800/50 rounded-xl border border-slate-700 text-white focus:ring-4 focus:ring-rose-500/5 focus:border-rose-500/30 transition-all outline-none text-sm pr-12" placeholder="••••••••">
                            <button type="button" onclick="togglePassword('password_confirmation', 'toggleIcon2')" class="absolute right-3 top-1/2 -translate-y-1/2 p-2 text-slate-600 hover:text-slate-400">
                                <i data-lucide="eye" id="toggleIcon2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <p id="match-status" class="text-[9px] mt-4 font-black uppercase tracking-[0.2em] hidden text-center py-2 rounded-xl border border-transparent transition-all"></p>
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
                                matchStatus.innerText = '✓ KONFIRMASI COCOK';
                                matchStatus.classList.remove('text-rose-500', 'border-rose-500/20', 'bg-rose-500/5');
                                matchStatus.classList.add('text-emerald-500', 'border-emerald-500/20', 'bg-emerald-500/5');
                            } else {
                                matchStatus.innerText = '✕ KONFIRMASI TIDAK COCOK';
                                matchStatus.classList.remove('text-emerald-500', 'border-emerald-500/20', 'bg-emerald-500/5');
                                matchStatus.classList.add('text-rose-500', 'border-rose-500/20', 'bg-rose-500/5');
                            }
                        } else {
                            matchStatus.classList.add('hidden');
                        }
                    }

                    password.addEventListener('input', validatePasswords);
                    confirm.addEventListener('input', validatePasswords);
                </script>asswords);
                </script>
            </div>
            
            <div class="pt-6 flex space-x-4">
                <button type="submit" class="px-10 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
