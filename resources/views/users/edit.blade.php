@extends('layouts.app')

@section('title', 'Ubah Pengguna')
@section('page_title', 'Perbarui Pengguna')

@section('content')
<div class="w-full bg-[#111827] border border-slate-800 rounded-[2.5rem] p-10 shadow-2xl">
    <div class="mb-10 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 shrink-0">
                    <i data-lucide="user-cog" class="w-6 h-6 md:w-7 md:h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl md:text-2xl font-black text-white tracking-tight">Perbarui Pengguna</h3>
                    <p class="text-slate-500 text-xs md:text-sm mt-1">Modifikasi hak akses dan informasi akun.</p>
                </div>
            </div>
            <div class="flex items-center self-start sm:self-center px-4 py-2.5 bg-slate-800/80 rounded-2xl border border-slate-700/50 shrink-0">
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest mr-3">ID</span>
                <span class="text-sm font-mono font-bold text-indigo-400">{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        
        <a href="{{ route('users.index') }}" class="flex items-center justify-center w-full px-6 py-4 bg-slate-800/50 hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 font-bold rounded-2xl border border-slate-700/50 transition-all active:scale-95 group">
            <i data-lucide="x" class="w-5 h-5 mr-3 transition-transform group-hover:rotate-90"></i>
            <span class="text-xs uppercase tracking-[0.2em]">Batal</span>
        </a>
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

            <!-- Permission Section -->
            <div class="p-8 bg-slate-800/30 rounded-[2.5rem] border border-slate-800/50">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-white uppercase tracking-wider">Hak Akses Fitur</h4>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Tentukan fitur yang dapat diakses pengguna ini</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $available_permissions = [
                            'manajemen_pengguna' => ['label' => 'Manajemen Pengguna', 'icon' => 'users', 'group' => 'Utama'],
                            'manajemen_cabang' => ['label' => 'Manajemen Cabang', 'icon' => 'building-2', 'group' => 'Utama'],
                            
                            'lpi_rekap_pengendalian' => ['label' => 'LPI: Rekap Pengendalian', 'icon' => 'file-text', 'group' => 'Kelola LPI'],
                            'lpi_laporan_internal' => ['label' => 'LPI: Laporan Internal', 'icon' => 'clipboard-list', 'group' => 'Kelola LPI'],
                            'lpi_penilaian_lpi' => ['label' => 'LPI: Penilaian LPI', 'icon' => 'check-square', 'group' => 'Kelola LPI'],
                            'lpi_master_resiko' => ['label' => 'LPI: Master Resiko', 'icon' => 'database', 'group' => 'Kelola LPI'],
                            
                            'tahanan_penilaian' => ['label' => 'Tahanan: Penilaian', 'icon' => 'user-check', 'group' => 'Data Tahanan'],
                            'tahanan_management' => ['label' => 'Tahanan: Management', 'icon' => 'users-round', 'group' => 'Data Tahanan'],
                            
                            'zi_penilaian' => ['label' => 'ZI: Penilaian', 'icon' => 'award', 'group' => 'Zona Integritas'],
                            'zi_manajemen_data' => ['label' => 'ZI: Manajemen Data', 'icon' => 'settings', 'group' => 'Zona Integritas'],
                            'zi_input_data' => ['label' => 'ZI: Input Data', 'icon' => 'edit-3', 'group' => 'Zona Integritas'],
                            
                            'belanja_penilaian' => ['label' => 'Belanja: Penilaian', 'icon' => 'trending-up', 'group' => 'Belanja Satker'],
                            'belanja_management' => ['label' => 'Belanja: Management', 'icon' => 'shopping-bag', 'group' => 'Belanja Satker'],
                        ];

                        $groups = [];
                        foreach($available_permissions as $key => $data) {
                            $groups[$data['group']][$key] = $data;
                        }
                    @endphp

                    @foreach($groups as $groupName => $permissions)
                    <div class="col-span-full mt-4 first:mt-0">
                        <h5 class="text-[10px] font-black text-slate-600 uppercase tracking-[0.2em] mb-4 border-b border-slate-800 pb-2">{{ $groupName }}</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($permissions as $key => $data)
                            <label class="relative flex items-center p-4 rounded-2xl bg-slate-900/50 border border-slate-700/50 hover:border-indigo-500/50 transition-all cursor-pointer group">
                                <div class="flex items-center flex-1">
                                    <div class="p-2 bg-slate-800 rounded-lg mr-3 text-slate-500 group-hover:text-indigo-400 transition-colors">
                                        <i data-lucide="{{ $data['icon'] }}" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-400 group-hover:text-white transition-colors uppercase tracking-tight">{{ $data['label'] }}</span>
                                </div>
                                <div class="relative">
                                    <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $user->hasPermission($key) ? 'checked' : '' }} class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-slate-600 bg-slate-800 checked:bg-indigo-500 checked:border-indigo-500 transition-all">
                                    <i data-lucide="check" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none"></i>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
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
