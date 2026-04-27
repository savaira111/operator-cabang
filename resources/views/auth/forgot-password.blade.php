<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi - SIPINTER JABAR</title>
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
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-[440px] animate-in fade-in zoom-in duration-700">
        <!-- Back Button -->
        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-[#D2A039] font-black text-[10px] uppercase tracking-widest mb-8 transition-colors group">
            <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
            Kembali Ke Login
        </a>

        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase mb-2">Lupa Sandi?</h1>
            <p class="text-slate-500 text-sm font-medium tracking-wide leading-relaxed">Masukkan alamat email Anda untuk menerima instruksi pemulihan kata sandi.</p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#D2A039]/10 blur-3xl -mr-16 -mt-16 rounded-full"></div>
            
            <form action="#" method="POST" class="space-y-6 relative z-10">
                @csrf
                
                <div class="space-y-2">
                    <label for="email" class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Alamat Email Terdaftar</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-500 group-focus-within:text-[#D2A039] transition-colors">
                            <i data-lucide="mail" class="w-5 h-5"></i>
                        </div>
                        <input type="email" name="email" id="email" required 
                            class="w-full pl-14 pr-5 py-4 bg-slate-900/50 border border-slate-800 rounded-2xl text-white placeholder-slate-600 focus:outline-none focus:border-[#D2A039]/50 transition-all" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div class="p-6 bg-indigo-500/5 rounded-3xl border border-indigo-500/10 flex items-start">
                    <div class="p-2 bg-indigo-500/10 rounded-xl mr-4 text-indigo-400">
                        <i data-lucide="info" class="w-5 h-5"></i>
                    </div>
                    <p class="text-[11px] text-slate-400 leading-relaxed font-medium">Jika email terdaftar, Anda akan menerima link pemulihan dalam beberapa menit.</p>
                </div>

                <button type="button" onclick="alert('Fitur pengiriman email pemulihan memerlukan konfigurasi SMTP Mail Server. Hubungi Administrator IT untuk reset manual.')" class="w-full py-4 bg-gradient-to-r from-[#D2A039] to-[#f9d77e] text-[#061B30] font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#D2A039]/20 hover:shadow-[#D2A039]/30 hover:-translate-y-0.5 active:scale-95 transition-all duration-300">
                    Kirim Instruksi
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-[10px] font-black text-slate-600 uppercase tracking-widest">
            &copy; {{ date('Y') }} Kementerian Imigrasi dan Pemasyarakatan
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
