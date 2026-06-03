<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPINTER JABAR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: linear-gradient(rgba(6, 27, 48, 0.88), rgba(6, 27, 48, 0.95)), url('{{ asset('Background.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(3, 17, 33, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(210, 160, 57, 0.2);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(210, 160, 57, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-[440px] animate-in fade-in zoom-in duration-700">
        <!-- Logo & Title -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-24 h-24 mb-6 group transition-transform hover:scale-105 duration-500">
                <img src="{{ asset('Logo_transparent.png') }}" alt="Logo SIPINTER" class="w-full h-full object-contain drop-shadow-2xl">
            </div>
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase mb-2">Sipinter Jabar</h1>
            <p class="text-slate-500 text-sm font-medium tracking-wide">Sistem Pengendalian Internal Terpadu</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
            <!-- Decorative Glow -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#D2A039]/10 blur-3xl -mr-16 -mt-16 rounded-full"></div>
            
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                
                @if($errors->any())
                    <div class="p-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl animate-in shake duration-500">
                        <div class="flex items-center gap-3">
                            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
                            <p class="text-xs font-bold text-rose-400 uppercase tracking-wider">Gagal Masuk</p>
                        </div>
                        <p class="text-xs text-rose-300/80 mt-1 ml-8">{{ $errors->first() }}</p>
                    </div>
                @endif

                <!-- Login Input (Email/Username) -->
                <div class="space-y-2">
                    <label for="login" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email atau Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-[#D2A039] transition-colors">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required 
                            class="w-full pl-14 pr-5 py-4 bg-slate-900/50 border border-slate-800 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:border-[#D2A039]/50 input-focus transition-all" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-black text-[#D2A039] uppercase tracking-widest hover:text-[#f9d77e] transition-colors">Lupa Sandi?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-[#D2A039] transition-colors">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" required 
                            class="w-full pl-14 pr-14 py-4 bg-slate-900/50 border border-slate-800 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:border-[#D2A039]/50 input-focus transition-all" 
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-500 hover:text-[#D2A039] transition-colors">
                            <i data-lucide="eye" id="eyeIcon" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>


                <!-- Submit Button & Back Link -->
                <div class="flex flex-col gap-3 mt-2">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#D2A039]/20 hover:shadow-[#D2A039]/30 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                        Masuk Ke Sistem
                    </button>
                    <a href="{{ url('/') }}" class="w-full flex items-center justify-center py-3.5 bg-slate-800/40 hover:bg-slate-800/80 text-slate-400 hover:text-[#D2A039] border border-slate-700/50 hover:border-[#D2A039]/30 font-black text-[10px] uppercase tracking-[0.2em] rounded-2xl transition-all duration-300 group">
                        <i data-lucide="arrow-left" class="w-3.5 h-3.5 mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Kembali Ke Halaman Utama
                    </a>
                </div>
            </form>
        </div>

        <!-- Footer Info -->
        <p class="text-center mt-8 text-[10px] font-black text-slate-600 uppercase tracking-widest">
            &copy; {{ date('Y') }} Kementerian Imigrasi dan Pemasyarakatan
        </p>
    </div>
    
    <!-- Floating Mascot -->
    <div class="fixed bottom-8 right-8 hidden lg:block animate-in fade-in slide-in-from-right-10 duration-1000 delay-500 pointer-events-none">
        <div class="relative group pointer-events-auto">
            <!-- Background Glow -->
            <div class="absolute inset-0 bg-[#D2A039]/10 blur-3xl rounded-full scale-110 group-hover:bg-[#D2A039]/20 transition-all duration-700"></div>
            
            <!-- Mascot Image -->
            <img src="{{ asset('mascot.png') }}" alt="Maskot Sipinter" class="w-56 h-auto relative z-10 drop-shadow-[0_20px_50px_rgba(0,0,0,0.4)] transition-all duration-700 group-hover:-translate-y-6 group-hover:scale-105">
            
            <!-- Floating Badge -->
            <div class="absolute -bottom-2 -left-6 bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-[#D2A039]/30 shadow-2xl z-20 flex items-center gap-2.5 transition-all duration-500 group-hover:translate-x-2">
                <div class="flex flex-col">
                    <span class="text-[9px] font-black text-[#061B30] uppercase tracking-widest leading-none">Integritas</span>
                    <span class="text-[7px] font-bold text-[#D2A039] uppercase mt-0.5">Pelayanan</span>
                </div>
                <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center shadow-lg shadow-green-500/20">
                    <i data-lucide="check" class="w-3 h-3 text-white stroke-[4]"></i>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
        
    </script>
</body>
</html>
