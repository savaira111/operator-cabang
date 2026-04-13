<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPINTER JABAR - Sistem Pengendalian Internal Terpadu Jawa Barat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #061B30; /* Logo Dark Blue */
            color: #ffffff;
        }
        .heading-serif {
            font-family: 'Playfair Display', serif;
        }
        .text-gold {
            color: #D2A039;
        }
        .bg-gold {
            background-color: #D2A039;
        }
        .border-gold {
            border-color: #D2A039;
        }
        .hover-bg-gold:hover {
            background-color: #b88a2e;
        }
        
        /* Glassmorphism utility */
        .glass-panel {
            background: rgba(6, 27, 48, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(210, 160, 57, 0.2);
        }

        /* Ambient glow */
        .glow-effect {
            position: absolute;
            background: radial-gradient(circle, rgba(210, 160, 57, 0.15) 0%, rgba(6, 27, 48, 0) 70%);
            width: 80vw;
            height: 80vw;
            border-radius: 50%;
            top: -40vw;
            left: 50%;
            transform: translateX(-50%);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="relative min-h-screen flex flex-col justify-between overflow-x-hidden">
    <!-- Ambient Background Glow -->
    <div class="glow-effect"></div>

    <!-- Navigation Bar -->
    <nav class="w-full glass-panel fixed top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-transparent rounded-full border-2 border-gold flex items-center justify-center shadow-[0_0_15px_rgba(210,160,57,0.3)] overflow-hidden">
                        <!-- Menggunakan tag img untuk logo asli -->
                        <img src="{{ asset('logo.png') }}" alt="Logo Instansi" class="w-full h-full object-cover scale-110" onerror="this.onerror=null; this.parentElement.innerHTML='<i data-lucide=\'shield-check\' class=\'w-6 h-6 text-gold\'></i>'; lucide.createIcons();" />
                    </div>
                    <div>
                        <h1 class="text-sm lg:text-base font-black tracking-widest text-gold uppercase leading-tight">
                            SIPINTER JABAR
                        </h1>
                        <p class="text-[7px] lg:text-[8px] text-slate-400 font-bold tracking-[0.1em] mt-1 uppercase">Sistem Pengendalian Internal Terpadu Jawa Barat</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-transparent border-2 border-gold text-gold font-bold text-[10px] uppercase tracking-widest rounded-full hover:bg-gold hover:text-[#061B30] transition-all duration-300 shadow-[0_0_20px_rgba(210,160,57,0.15)] hover:shadow-[0_0_25px_rgba(210,160,57,0.4)]">
                        Akses Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Hero Section -->
    <main class="flex-grow flex items-center pt-24 pb-16 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Text Content -->
                <div class="animate-in fade-in slide-in-from-bottom-8 duration-1000">
                    <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full border border-gold/30 bg-gold/5 mb-6">
                        <span class="flex h-1.5 w-1.5 rounded-full bg-gold relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-gold opacity-75"></span>
                        </span>
                        <span class="text-[9px] font-bold text-gold uppercase tracking-[0.2em]">Pusat Data Terpadu v2.0</span>
                    </div>

                    <h2 class="heading-serif text-3xl lg:text-5xl font-bold leading-[1.1] mb-4 text-white">
                        Sistem Pengendalian <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold to-[#f9d77e]">
                            Internal Terpadu
                        </span> <br>
                        <span class="text-2xl lg:text-4xl text-slate-300">Jawa Barat</span>
                    </h2>

                    <p class="text-slate-400 text-sm leading-relaxed mb-6 max-w-md font-medium border-l-4 border-gold/50 pl-4">
                        Platform sentralisasi data operasional untuk mengelola, memantau, dan melaporkan aktivitas cabang, resiko, serta pusat pendataan secara *real-time* dan terstruktur.
                    </p>

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-gold hover-bg-gold text-[#061B30] font-black text-[11px] uppercase tracking-widest rounded-2xl transition-all duration-300 shadow-[0_10px_30px_-10px_rgba(210,160,57,0.6)] hover:-translate-y-1 flex items-center justify-center group">
                            Masuk Portal
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-2 group-hover:translate-x-2 transition-transform"></i>
                        </a>
                        <a href="#features" class="px-6 py-3 bg-transparent border border-white/20 text-white hover:border-white/50 hover:bg-white/5 font-bold text-[11px] uppercase tracking-widest rounded-2xl transition-all duration-300 flex items-center justify-center">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <!-- Visual Element -->
                <div class="relative hidden lg:block animate-in fade-in slide-in-from-right-8 duration-1000 delay-300">
                    <div class="relative w-full h-[380px] lg:h-[420px] flex items-center justify-center scale-[0.85] lg:scale-90 origin-right">
                        <!-- Dashboard Mockup Abstract -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-gold/10 to-transparent rounded-[2.5rem] border border-gold/20 transform rotate-3"></div>
                        <div class="absolute inset-0 bg-[#0a2342] border border-gold/30 rounded-[2.5rem] shadow-2xl glass-panel p-6 transform -rotate-2 hover:rotate-0 transition-transform duration-700">
                            <!-- Fake UI -->
                            <div class="flex items-center justify-between mb-6 pb-4 border-b border-white/10">
                                <div class="w-20 h-2 bg-white/20 rounded-full"></div>
                                <div class="flex space-x-2">
                                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="h-24 bg-[#061B30]/80 rounded-2xl border border-white/5 p-4 flex flex-col justify-end">
                                    <div class="w-7 h-7 rounded-full bg-gold/20 mb-auto flex items-center justify-center">
                                        <i data-lucide="users" class="w-3.5 h-3.5 text-gold"></i>
                                    </div>
                                    <div class="w-10 h-2 bg-white/20 rounded-full mb-2"></div>
                                    <div class="w-16 h-4 bg-white/40 rounded-full"></div>
                                </div>
                                <div class="h-24 bg-[#061B30]/80 rounded-2xl border border-white/5 p-4 flex flex-col justify-end">
                                    <div class="w-7 h-7 rounded-full bg-indigo-500/20 mb-auto flex items-center justify-center">
                                        <i data-lucide="building" class="w-3.5 h-3.5 text-indigo-400"></i>
                                    </div>
                                    <div class="w-10 h-2 bg-white/20 rounded-full mb-2"></div>
                                    <div class="w-16 h-4 bg-white/40 rounded-full"></div>
                                </div>
                            </div>

                            <div class="h-32 bg-[#061B30]/80 rounded-2xl border border-white/5 p-4">
                                <div class="w-full h-full border-b border-l border-white/10 relative flex items-end px-3 space-x-3">
                                    <div class="w-1/4 bg-gradient-to-t from-gold/80 to-gold/20 h-[40%] rounded-t-md"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-gold/80 to-gold/20 h-[70%] rounded-t-md"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-gold/80 to-gold/20 h-[50%] rounded-t-md"></div>
                                    <div class="w-1/4 bg-gradient-to-t from-gold/80 to-gold/20 h-[90%] rounded-t-md"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full py-8 border-t border-white/10 relative z-10 bg-[#031121]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between">
            <p class="text-xs text-slate-500 font-medium">
                &copy; {{ date('Y') }} Kementerian Imigrasi dan Pemasyarakatan Republik Indonesia. Hak Cipta Dilindungi.
            </p>
            <div class="flex items-center space-x-6 mt-4 md:mt-0">
                <a href="#" class="text-xs text-slate-500 hover:text-gold transition-colors">Bantuan</a>
                <a href="#" class="text-xs text-slate-500 hover:text-gold transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-xs text-slate-500 hover:text-gold transition-colors">Kontak Developer</a>
            </div>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
