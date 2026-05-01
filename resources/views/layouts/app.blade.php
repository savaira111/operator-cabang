<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Manajemen - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #061B30; /* Logo Dark Blue */
        }
        .sidebar-link {
            position: relative;
            overflow: hidden;
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(210,160,57,0.15) 0%, rgba(210,160,57,0.04) 100%);
            color: #D2A039;
            font-weight: 700;
        }
        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            background: linear-gradient(180deg, #D2A039, #f9d77e);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px rgba(210,160,57,0.6);
        }
        .sidebar-link.active .nav-icon {
            background-color: rgba(210,160,57,0.2);
            color: #D2A039;
        }
        .sidebar-link:not(.active):hover .nav-icon {
            background-color: rgba(255,255,255,0.05);
            color: #cbd5e1;
        }
        .sidebar-link:not(.active):hover {
            background-color: rgba(255,255,255,0.03);
            color: #cbd5e1;
        }
        .night-card {
            background-color: #061B30;
            border-color: rgba(210, 160, 57, 0.2);
        }

        /* Sidebar Toggle */
        #sidebar {
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.3s ease,
                        transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            width: 16rem; /* 256px = w-64 */
            overflow: hidden;
        }
        #sidebar.collapsed {
            width: 0;
            opacity: 0;
            transform: translateX(-20px);
            pointer-events: none;
        }
        #sidebar .sidebar-text {
            transition: opacity 0.2s ease 0.1s;
            opacity: 1;
            white-space: nowrap;
        }
        #sidebar.collapsed .sidebar-text {
            opacity: 0;
            transition: opacity 0.1s ease;
        }

        /* Toggle button spin animation */
        #sidebarToggle i {
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebarToggle.active i {
            transform: rotate(90deg);
        }

        /* Hide sidebar scrollbar */
        nav::-webkit-scrollbar { display: none; }
        nav { scrollbar-width: none; -ms-overflow-style: none; }

        /* Page Transitions */
        .page-transition-enter {
            animation: pageEnter 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes pageEnter {
            from { 
                opacity: 0; 
                transform: translateY(10px);
                filter: blur(4px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
                filter: blur(0);
            }
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

        /* Dropdown Animation */
        .dropdown-container {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1), 
                        opacity 0.4s ease;
        }
        .dropdown-container.show {
            max-height: 200px;
            opacity: 1;
        }
        .dropdown-item {
            transform: translateX(-10px);
            opacity: 0;
            transition: transform 0.4s ease, opacity 0.4s ease;
        }
        .dropdown-container.show .dropdown-item {
            transform: translateX(0);
            opacity: 1;
        }
        /* Staggered delay for items */
        .dropdown-item:nth-child(1) { transition-delay: 0.1s; }
        .dropdown-item:nth-child(2) { transition-delay: 0.15s; }
        .dropdown-item:nth-child(3) { transition-delay: 0.2s; }
    </style>
</head>
<body class="bg-[#061B30] text-slate-300 antialiased">
    <div id="loading-bar"></div>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-[#031121] border-r border-[#D2A039]/20 flex-shrink-0 flex flex-col">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 flex-shrink-0 rounded-full border-2 border-[#D2A039] shadow-[0_0_12px_rgba(210,160,57,0.35)] overflow-hidden bg-transparent">
                        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-110" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\'flex items-center justify-center w-full h-full text-[#D2A039] font-black text-sm\'>M</span>';">
                    </div>
                    <h1 class="text-xl font-extrabold bg-gradient-to-r from-[#D2A039] to-[#f9d77e] bg-clip-text text-transparent tracking-tighter uppercase whitespace-nowrap">
                        MANAGEMENT
                    </h1>
                </div>
            </div>
            <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">
                <!-- Section Label -->
                <p class="px-3 mb-2 text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Menu Utama</p>

                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Dashboard</span>
                </a>

                <a href="{{ route('users.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="users" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Manajemen Pengguna</span>
                </a>

                <a href="{{ route('cabangs.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('cabangs.*') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Manajemen Cabang</span>
                </a>

                <!-- Dropdown Kelola LPI -->
                @if(auth()->user()?->role !== 'operator cabang')
                <div class="sidebar-dropdown">
                    <button onclick="toggleLpiMenu()" class="sidebar-link w-full flex items-center justify-between px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('laporan.*') || request()->routeIs('penilaian-lpi.*') || request()->routeIs('laporan-pengendalian.*') || request()->routeIs('identifikasi-risiko.*') || request()->routeIs('analisis-risiko.*') || request()->routeIs('resikos.*') || request()->routeIs('rencana-tindak.*') || request()->routeIs('daftar-prioritas.*') || request()->routeIs('pemantauan-kegiatan.*') || request()->routeIs('pemantauan-peristiwa.*') || request()->routeIs('pemantauan-level.*') || request()->routeIs('reviu-usulan.*') || request()->routeIs('rencana-belum-terealisasi.*') || request()->routeIs('evaluasi-risiko.*') ? 'bg-white/5' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                                <i data-lucide="shield-alert" class="w-4 h-4"></i>
                            </span>
                            <span class="text-[13px] font-semibold tracking-wide">Kelola LPI</span>
                        </div>
                        <i data-lucide="chevron-down" id="lpiChevron" class="w-3 h-3 transition-transform duration-300 {{ request()->routeIs('laporan.*') || request()->routeIs('penilaian-lpi.*') || request()->routeIs('laporan-pengendalian.*') || request()->routeIs('identifikasi-risiko.*') || request()->routeIs('analisis-risiko.*') || request()->routeIs('resikos.*') || request()->routeIs('rencana-tindak.*') || request()->routeIs('daftar-prioritas.*') || request()->routeIs('pemantauan-kegiatan.*') || request()->routeIs('pemantauan-peristiwa.*') || request()->routeIs('pemantauan-level.*') || request()->routeIs('reviu-usulan.*') || request()->routeIs('rencana-belum-terealisasi.*') || request()->routeIs('evaluasi-risiko.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    
                    <div id="lpiMenu" class="pl-11 space-y-0.5 mt-1 dropdown-container {{ request()->routeIs('laporan.*') || request()->routeIs('penilaian-lpi.*') || request()->routeIs('laporan-pengendalian.*') || request()->routeIs('identifikasi-risiko.*') || request()->routeIs('analisis-risiko.*') || request()->routeIs('resikos.*') || request()->routeIs('rencana-tindak.*') || request()->routeIs('daftar-prioritas.*') || request()->routeIs('pemantauan-kegiatan.*') || request()->routeIs('pemantauan-peristiwa.*') || request()->routeIs('pemantauan-level.*') || request()->routeIs('reviu-usulan.*') || request()->routeIs('rencana-belum-terealisasi.*') || request()->routeIs('evaluasi-risiko.*') ? 'show' : '' }}">
                        <a href="{{ route('laporan.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('laporan.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Rekap Pengendalian</span>
                        </a>
                        <a href="{{ route('identifikasi-risiko.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('identifikasi-risiko.*') || request()->routeIs('analisis-risiko.*') || request()->routeIs('resikos.*') || request()->routeIs('rencana-tindak.*') || request()->routeIs('daftar-prioritas.*') || request()->routeIs('pemantauan-kegiatan.*') || request()->routeIs('pemantauan-peristiwa.*') || request()->routeIs('pemantauan-level.*') || request()->routeIs('reviu-usulan.*') || request()->routeIs('rencana-belum-terealisasi.*') || request()->routeIs('evaluasi-risiko.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Laporan Internal</span>
                        </a>
                        <a href="{{ route('penilaian-lpi.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('penilaian-lpi.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Penilaian LPI</span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Section Label -->
                <p class="px-3 pt-4 mb-2 text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Data Input</p>

                <!-- Dropdown Data Tahanan -->
                <div class="sidebar-dropdown">
                    <button onclick="toggleTahananMenu()" class="sidebar-link w-full flex items-center justify-between px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('tahanans.*') ? 'bg-white/5' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                                <i data-lucide="user-minus" class="w-4 h-4"></i>
                            </span>
                            <span class="text-[13px] font-semibold tracking-wide">Data Tahanan</span>
                        </div>
                        <i data-lucide="chevron-down" id="tahananChevron" class="w-3 h-3 transition-transform duration-300 {{ request()->routeIs('tahanans.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    
                    <div id="tahananMenu" class="pl-11 space-y-0.5 mt-1 dropdown-container {{ request()->routeIs('tahanans.*') || request()->routeIs('penilaian-tahanan.*') ? 'show' : '' }}">
                        <a href="{{ route('penilaian-tahanan.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('penilaian-tahanan.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Penilaian Tahanan</span>
                        </a>
                        <a href="{{ route('tahanans.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('tahanans.index') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Tahanan Management</span>
                        </a>
                    </div>
                </div>

                <!-- Dropdown Kelola Zona Integritas -->
                <div class="sidebar-dropdown">
                    <button onclick="toggleZiMenu()" class="sidebar-link w-full flex items-center justify-between px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('zi-monitoring.*') || request()->routeIs('zi-data-manage.*') || request()->routeIs('zi-data-fill.*') ? 'bg-white/5' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                                <i data-lucide="award" class="w-4 h-4"></i>
                            </span>
                            <span class="text-[13px] font-semibold tracking-wide">Kelola Zona Integritas</span>
                        </div>
                        <i data-lucide="chevron-down" id="ziChevron" class="w-3 h-3 transition-transform duration-300 {{ request()->routeIs('zi-monitoring.*') || request()->routeIs('zi-data-manage.*') || request()->routeIs('zi-data-fill.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    
                    <div id="ziMenu" class="pl-11 space-y-0.5 mt-1 dropdown-container {{ request()->routeIs('zi-monitoring.*') || request()->routeIs('zi-data-manage.*') || request()->routeIs('zi-data-fill.*') ? 'show' : '' }}">
                        <a href="{{ route('zi-monitoring.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('zi-monitoring.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Penilaian ZI</span>
                        </a>
                        <a href="{{ route('zi-data-manage.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('zi-data-manage.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Manajemen Data</span>
                        </a>
                        <a href="{{ route('zi-data-fill.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('zi-data-fill.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Input Data ZI</span>
                        </a>
                    </div>
                </div>

                <!-- Dropdown Penyelenggaraan Anggaran -->
                <div class="sidebar-dropdown">
                    <button onclick="toggleAnggaranMenu()" class="sidebar-link w-full flex items-center justify-between px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('belanja-satker.*') ? 'bg-white/5' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </span>
                            <span class="text-[13px] font-semibold tracking-wide">Penyelenggaraan Belanja Satker</span>
                        </div>
                        <i data-lucide="chevron-down" id="anggaranChevron" class="w-3 h-3 transition-transform duration-300 {{ request()->routeIs('belanja-satker.*') ? 'rotate-180' : '' }}"></i>
                    </button>
                    
                    <div id="anggaranMenu" class="pl-11 space-y-0.5 mt-1 dropdown-container {{ request()->routeIs('belanja-satker.*') || request()->routeIs('penilaian-belanja.*') ? 'show' : '' }}">
                        <a href="{{ route('penilaian-belanja.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('penilaian-belanja.*') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Penilaian Belanja Satker</span>
                        </a>
                        <a href="{{ route('belanja-satker.index') }}" class="dropdown-item flex items-center gap-3 py-2 text-slate-500 hover:text-[#D2A039] transition-all {{ request()->routeIs('belanja-satker.index') ? 'text-[#D2A039] font-bold' : '' }}">
                            <span class="text-[12px] tracking-wide">Belanja Satker Management</span>
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#061B30]">
            <header class="h-16 bg-[#031121]/80 backdrop-blur-md border-b border-[#D2A039]/20 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <!-- Sidebar Toggle Button -->
                    <button id="sidebarToggle" onclick="toggleSidebar()" class="active p-2 rounded-xl text-[#D2A039] hover:bg-[#D2A039]/10 border border-[#D2A039]/20 hover:border-[#D2A039]/40 transition-all duration-200 hover:shadow-[0_0_12px_rgba(210,160,57,0.2)]" title="Toggle Sidebar">
                        <i data-lucide="panel-left-close" class="w-4 h-4"></i>
                    </button>
                    <h2 class="text-sm font-bold text-slate-200 uppercase tracking-widest">
                        @yield('page_title', 'Ringkasan')
                    </h2>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Admin Profile Dropdown -->
                    <div class="relative ml-1" id="profileDropdownWrap">
                        <button onclick="toggleProfileDropdown()" class="flex items-center gap-2.5 pl-2 pr-3 py-1.5 rounded-xl border border-[#D2A039]/20 hover:bg-[#D2A039]/10 transition-all duration-200 group">
                            <div class="w-7 h-7 rounded-lg bg-[#D2A039]/10 border border-[#D2A039]/30 flex items-center justify-center text-[#D2A039] group-hover:bg-[#D2A039]/20 transition-all">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-[10px] font-black text-slate-200 uppercase tracking-widest leading-none">Admin</p>
                                <p class="text-[8px] text-slate-500 tracking-tight leading-none mt-0.5">Super Administrator</p>
                            </div>
                            <i data-lucide="chevron-down" class="w-3 h-3 text-slate-500 ml-0.5 transition-transform duration-200" id="profileChevron"></i>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="profileDropdown" class="absolute right-0 top-full mt-2 w-44 bg-[#031121] border border-[#D2A039]/20 rounded-2xl shadow-2xl shadow-black/40 overflow-hidden opacity-0 scale-95 pointer-events-none transition-all duration-200 origin-top-right z-50">
                            <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-[#D2A039] hover:bg-[#D2A039]/5 transition-all text-xs font-semibold">
                                <i data-lucide="user-circle" class="w-4 h-4"></i>
                                <span>Profil Saya</span>
                            </a>
                            <div class="border-t border-[#D2A039]/10"></div>
                            <a href="{{ route('landing') }}" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-[#D2A039] hover:bg-[#D2A039]/5 transition-all text-xs font-semibold">
                                <i data-lucide="globe" class="w-4 h-4"></i>
                                <span>Tinjau Landing Page</span>
                            </a>
                            <div class="border-t border-[#D2A039]/10"></div>
                            <a href="{{ route('logout') }}" onclick="confirmLogout(event)" class="flex items-center gap-3 px-4 py-3 text-rose-400 hover:text-rose-300 hover:bg-rose-500/5 transition-all text-xs font-semibold">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span>Keluar Akun</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8 page-transition-enter">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-[#D2A039]/10 border border-[#D2A039]/20 text-[#D2A039] rounded-2xl flex items-center animate-in fade-in slide-in-from-top-4">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        // Sidebar Toggle
        let sidebarOpen = true;
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const btn = document.getElementById('sidebarToggle');
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                sidebar.classList.remove('collapsed');
                btn.classList.add('active');
                btn.innerHTML = '<i data-lucide="panel-left-close" class="w-4 h-4"></i>';
            } else {
                sidebar.classList.add('collapsed');
                btn.classList.remove('active');
                btn.innerHTML = '<i data-lucide="panel-left-open" class="w-4 h-4"></i>';
            }
            lucide.createIcons();
        }

        // Toggle Zi Dropdown Menu
        function toggleZiMenu() {
            const menu = document.getElementById('ziMenu');
            const chevron = document.getElementById('ziChevron');
            
            if (!menu.classList.contains('show')) {
                menu.classList.add('show');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('show');
                chevron.classList.remove('rotate-180');
            }
        }

        // Toggle Lpi Dropdown Menu
        function toggleLpiMenu() {
            const menu = document.getElementById('lpiMenu');
            const chevron = document.getElementById('lpiChevron');
            
            if (!menu.classList.contains('show')) {
                menu.classList.add('show');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('show');
                chevron.classList.remove('rotate-180');
            }
        }

        // Toggle Tahanan Dropdown Menu
        function toggleTahananMenu() {
            const menu = document.getElementById('tahananMenu');
            const chevron = document.getElementById('tahananChevron');
            
            if (!menu.classList.contains('show')) {
                menu.classList.add('show');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('show');
                chevron.classList.remove('rotate-180');
            }
        }

        // Toggle Anggaran Dropdown Menu
        function toggleAnggaranMenu() {
            const menu = document.getElementById('anggaranMenu');
            const chevron = document.getElementById('anggaranChevron');
            
            if (!menu.classList.contains('show')) {
                menu.classList.add('show');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.remove('show');
                chevron.classList.remove('rotate-180');
            }
        }

        // Profile Dropdown Toggle
        let profileOpen = false;
        function toggleProfileDropdown() {
            profileOpen = !profileOpen;
            const dd = document.getElementById('profileDropdown');
            const chevron = document.getElementById('profileChevron');
            if (profileOpen) {
                dd.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                dd.classList.add('opacity-100', 'scale-100');
                chevron.style.transform = 'rotate(180deg)';
            } else {
                dd.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                dd.classList.remove('opacity-100', 'scale-100');
                chevron.style.transform = 'rotate(0deg)';
            }
        }
        // Close dropdown on outside click
        document.addEventListener('click', function(e) {
            const wrap = document.getElementById('profileDropdownWrap');
            if (wrap && !wrap.contains(e.target) && profileOpen) {
                toggleProfileDropdown();
            }
        });

        // Custom SweetAlert2 Dark Theme
        const swalDark = Swal.mixin({
            customClass: {
                popup: 'bg-[#031121] border border-[#D2A039]/30 rounded-[2rem] text-slate-300 shadow-2xl',
                title: 'text-white font-black tracking-tight',
                htmlContainer: 'text-slate-400 font-medium',
                confirmButton: 'mx-2 px-8 py-3 bg-[#D2A039] hover:bg-[#b88a2e] text-[#061B30] font-bold rounded-2xl transition-all shadow-xl shadow-[#D2A039]/20 active:scale-95 outline-none focus:ring-0',
                cancelButton: 'mx-2 px-8 py-3 bg-slate-800 text-slate-400 font-bold rounded-2xl hover:bg-slate-700 hover:text-white transition-all outline-none focus:ring-0'
            },
            buttonsStyling: false
        });

        // Global Alert Handler
        @if(session('success'))
            swalDark.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                iconColor: '#D2A039',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            swalDark.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                iconColor: '#f43f5e',
                timer: 4000
            });
        @endif

        // Logout Confirmation
        function confirmLogout(event) {
            event.preventDefault();
            const href = event.currentTarget.getAttribute('href');
            swalDark.fire({
                title: 'Konfirmasi Keluar',
                text: "Apakah Anda yakin ingin mengakhiri sesi ini?",
                icon: 'question',
                iconColor: '#D2A039',
                showBatalButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        }

        // Hapus Confirmation Helper
        function confirmHapus(event, form) {
            event.preventDefault();
            swalDark.fire({
                title: 'Konfirmasi Hapus',
                text: "Data ini akan dihapus secara permanen dari sistem.",
                icon: 'warning',
                iconColor: '#f43f5e',
                showBatalButton: true,
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
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
