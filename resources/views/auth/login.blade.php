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
            background-image: linear-gradient(rgba(6, 27, 48, 0.9), rgba(6, 27, 48, 0.95)), url('{{ asset('Background.png') }}');
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
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-tr from-[#D2A039] to-[#f9d77e] rounded-[2rem] shadow-2xl shadow-[#D2A039]/20 mb-6 group transition-transform hover:scale-105 duration-500">
                <i data-lucide="shield-check" class="w-10 h-10 text-[#061B30]"></i>
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

                <!-- Remember Me -->
                <div class="flex items-center px-1">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="sr-only">
                            <div class="w-4 h-4 border-2 border-slate-700 rounded-md group-hover:border-[#D2A039]/50 transition-colors"></div>
                            <i data-lucide="check" class="w-3 h-3 text-[#D2A039] absolute top-0.5 left-0.5 opacity-0 transition-opacity"></i>
                        </div>
                        <span class="ml-3 text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-slate-300 transition-colors">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#D2A039]/20 hover:shadow-[#D2A039]/30 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    Masuk Ke Sistem
                </button>
            </form>
        </div>

        <!-- Footer Info -->
        <p class="text-center mt-8 text-[10px] font-black text-slate-600 uppercase tracking-widest">
            &copy; {{ date('Y') }} Kementerian Imigrasi dan Pemasyarakatan
        </p>
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
        
        // Custom checkbox logic
        const checkbox = document.querySelector('input[type="checkbox"]');
        const checkIcon = document.querySelector('[data-lucide="check"]');
        
        checkbox.addEventListener('change', function() {
            if(this.checked) {
                checkIcon.style.opacity = '1';
                this.nextElementSibling.classList.add('bg-[#D2A039]/10', 'border-[#D2A039]');
            } else {
                checkIcon.style.opacity = '0';
                this.nextElementSibling.classList.remove('bg-[#D2A039]/10', 'border-[#D2A039]');
            }
        });
    </script>
</body>
</html>
