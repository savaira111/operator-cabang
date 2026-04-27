<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPINTER JABAR - Sistem Pengendalian Internal Terpadu Jawa Barat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-image: linear-gradient(rgba(6, 27, 48, 0.88), rgba(6, 27, 48, 0.95)), url('{{ asset('Background.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
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
        .proximity-letter {
            display: inline-block;
            font-variation-settings: 'wght' 700;
            will-change: font-variation-settings;
        }

        /* Border Glow Component Styles */
        .border-glow-card {
            position: relative;
            background: #031121;
            border-radius: 40px;
            border: none;
            --cursor-angle: 45deg;
            --edge-proximity: 0;
            --glow-opacity: 0;
        }

        .border-glow-border {
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            border: 2px solid transparent;
            mask-image: conic-gradient(from var(--cursor-angle) at center, transparent 0%, black 5%, black 20%, transparent 25%);
            -webkit-mask-image: conic-gradient(from var(--cursor-angle) at center, transparent 0%, black 5%, black 20%, transparent 25%);
            background: radial-gradient(circle at center, #D2A039 0%, #f9d77e 50%, transparent 100%) border-box;
            background-size: 200% 200%;
            opacity: var(--glow-opacity);
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: 10;
        }

        .border-glow-outer {
            position: absolute;
            inset: -40px;
            border-radius: inherit;
            mask-image: conic-gradient(from var(--cursor-angle) at center, black 5%, transparent 20%, transparent 80%, black 95%);
            -webkit-mask-image: conic-gradient(from var(--cursor-angle) at center, black 5%, transparent 20%, transparent 80%, black 95%);
            background: radial-gradient(circle at center, rgba(210, 160, 57, 0.3) 0%, transparent 70%);
            opacity: var(--glow-opacity);
            transition: opacity 0.3s ease;
            pointer-events: none;
            z-index: -1;
            filter: blur(20px);
        }

        /* Top Loading Bar */
        #loading-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #D2A039, #f9d77e);
            z-index: 9999;
            transition: width 0.3s ease;
            box-shadow: 0 0 10px rgba(210,160,57,0.5);
        }

        /* Mascot Card Styles (Accreditation Style) */
        .mascot-card {
            position: absolute;
            bottom: -30px;
            right: -30px;
            z-index: 40;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            padding: 10px 16px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(210, 160, 57, 0.3);
            animation: mascot-float 4s ease-in-out infinite;
            pointer-events: auto;
        }
        .mascot-thumb {
            width: 50px;
            height: 50px;
            background: #f0f4f8;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(210, 160, 57, 0.2);
        }
        .mascot-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.1);
        }
        .mascot-text {
            display: flex;
            flex-direction: column;
        }
        .mascot-title {
            font-size: 11px;
            font-weight: 800;
            color: #061B30;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            line-height: 1.2;
        }
        .mascot-subtitle {
            font-size: 9px;
            font-weight: 600;
            color: #D2A039;
            margin-top: 2px;
        }
        @keyframes mascot-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @media (max-width: 1024px) {
            .mascot-card {
                display: none;
            }
        }
    </style>
</head>
<body class="relative min-h-screen flex flex-col justify-between overflow-x-hidden">
    <div id="loading-bar"></div>
    <!-- Ambient Kembaliground Glow -->
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
                <!-- Navbar actions removed -->
            </div>
        </div>
    </nav>

    <!-- Main Hero Section -->
    <main class="flex-grow flex items-center pt-40 pb-16 relative z-10">
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

                    <h2 id="proximity-title" class="heading-serif text-3xl lg:text-5xl font-bold leading-[1.1] mb-4 text-white">
                        <span class="proximity-item block">Sistem Pengendalian</span>
                        <span class="proximity-item block text-gold">
                            Internal Terpadu
                        </span>
                        <span class="proximity-item block text-2xl lg:text-4xl text-slate-300">Jawa Barat</span>
                    </h2>

                    <p class="text-slate-400 text-sm leading-relaxed mb-6 max-w-md font-medium border-l-4 border-gold/50 pl-4">
                        Platform sentralisasi data operasional untuk mengelola, memantau, dan melaporkan aktivitas cabang, pengendalian internal, serta pusat pendataan secara *real-time* dan terstruktur.
                    </p>

                    <div class="flex flex-col sm:flex-row">
                        <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="px-8 py-4 bg-gold hover-bg-gold text-[#061B30] font-black text-xs uppercase tracking-widest rounded-2xl transition-all duration-300 shadow-[0_10px_30px_-10px_rgba(210,160,57,0.6)] hover:-translate-y-1 flex items-center justify-center group">
                            {{ Auth::check() ? 'Menuju Dashboard' : 'Masuk Ke Sistem' }}
                            <i data-lucide="{{ Auth::check() ? 'layout-dashboard' : 'log-in' }}" class="w-4 h-4 ml-3 group-hover:rotate-12 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <!-- Visual Element with Border Glow -->
                <div class="relative hidden lg:block animate-in fade-in slide-in-from-right-8 duration-1000 delay-300">
                    <div id="border-glow-target" class="border-glow-card relative inline-flex items-center justify-center p-1 shadow-2xl scale-[0.8] lg:scale-85 origin-right ml-auto translate-x-12">
                        <div class="border-glow-border"></div>
                        <div class="border-glow-outer"></div>
                        <img src="{{ asset('Logo_2.png') }}" alt="Sipinter Jabar" class="max-w-[300px] lg:max-w-[350px] h-auto rounded-[38px] drop-shadow-[0_0_15px_rgba(210,160,57,0.15)] z-20">
                    </div>
                    
                    <!-- Mascot Card Addition -->
                    <div class="mascot-card animate-in fade-in slide-in-from-right-12 duration-1000 delay-500">
                        <div class="mascot-thumb">
                            <img src="{{ asset('mascot.png') }}" alt="Maskot Sipinter">
                        </div>
                        <div class="mascot-text">
                            <div class="flex items-center gap-1.5">
                                <span class="mascot-title">Integritas Pelayanan</span>
                                <div class="bg-green-500 rounded-full p-0.5">
                                    <i data-lucide="check" class="w-2 h-2 text-white stroke-[4]"></i>
                                </div>
                            </div>
                            <span class="mascot-subtitle">Terakreditasi Unggul</span>
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

        // Variable Proximity Animation Logic
        const container = document.querySelector('main');
        const title = document.querySelector('#proximity-title');
        const items = document.querySelectorAll('.proximity-item');
        
        // Wrap letters
        items.forEach(item => {
            const text = item.textContent.trim();
            item.innerHTML = '';
            text.split('').forEach(char => {
                const span = document.createElement('span');
                span.textContent = char === ' ' ? '\u00A0' : char;
                span.className = char === ' ' ? 'inline-block' : 'proximity-letter';
                item.appendChild(span);
            });
        });

        const letters = document.querySelectorAll('.proximity-letter');
        const radius = 180;
        const fromWght = 400;
        const toWght = 900;

        let mouseX = -1000;
        let mouseY = -1000;

        window.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animate() {
            letters.forEach(letter => {
                const rect = letter.getBoundingClientRect();
                const letterX = rect.left + rect.width / 2;
                const letterY = rect.top + rect.height / 2;

                const dist = Math.sqrt(Math.pow(mouseX - letterX, 2) + Math.pow(mouseY - letterY, 2));
                
                if (dist < radius) {
                    const norm = 1 - (dist / radius);
                    const falloff = Math.pow(norm, 2); // Exponential falloff for snappier feel
                    const wght = fromWght + (toWght - fromWght) * falloff;
                    
                    letter.style.fontVariationSettings = `'wght' ${wght}`;
                    
                    // Add glow effect
                    const glowIntensity = falloff * 15;
                    const glowColor = letter.parentElement.classList.contains('text-gold') || letter.parentElement.classList.contains('from-gold') 
                        ? 'rgba(210, 160, 57, ' + (norm * 0.8) + ')' 
                        : 'rgba(255, 255, 255, ' + (norm * 0.6) + ')';
                    
                    letter.style.textShadow = `0 0 ${glowIntensity}px ${glowColor}`;
                    letter.style.opacity = 1;
                } else {
                    letter.style.fontVariationSettings = `'wght' ${fromWght}`;
                    letter.style.textShadow = 'none';
                }
            });
            requestAnimationFrame(animate);
        }
        
        animate();

        // Border Glow Logic
        const card = document.querySelector('#border-glow-target');
        if (card) {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const cx = rect.width / 2;
                const cy = rect.height / 2;
                
                const dx = x - cx;
                const dy = y - cy;
                
                const radians = Math.atan2(dy, dx);
                let degrees = radians * (180 / Math.PI) + 90;
                if (degrees < 0) degrees += 360;
                
                // Edge proximity logic simplified
                const distToCenter = Math.sqrt(dx*dx + dy*dy);
                const maxDist = Math.sqrt(cx*cx + cy*cy);
                const proximity = Math.min(distToCenter / (maxDist * 0.7), 1);
                
                card.style.setProperty('--cursor-angle', `${degrees}deg`);
                card.style.setProperty('--glow-opacity', proximity);
            });
            
            card.addEventListener('mouseenter', () => {
                card.style.setProperty('--glow-opacity', '1');
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.setProperty('--glow-opacity', '0');
            });
        }

        // Top Loading Bar Logic
        window.addEventListener('beforeunload', function() {
            const bar = document.getElementById('loading-bar');
            bar.style.width = '30%';
            setTimeout(() => {
                bar.style.width = '70%';
            }, 100);
        });

        window.addEventListener('load', function() {
            const bar = document.getElementById('loading-bar');
            bar.style.width = '100%';
            setTimeout(() => {
                bar.style.opacity = '0';
                setTimeout(() => {
                    bar.style.width = '0%';
                    bar.style.opacity = '1';
                }, 300);
            }, 200);
        });
    </script>
</body>
</html>
