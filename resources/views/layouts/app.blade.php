<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Website - @yield('title', 'Dashboard')</title>
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
    </style>
</head>
<body class="bg-[#061B30] text-slate-300 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#031121] border-r border-[#D2A039]/20 flex-shrink-0 flex flex-col">
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
            <nav class="flex-1 px-3 space-y-0.5">
                <!-- Section Label -->
                <p class="px-3 mb-2 text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Main Menu</p>

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
                    <span class="text-[13px] font-semibold tracking-wide">User Management</span>
                </a>

                <a href="{{ route('cabangs.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('cabangs.*') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="building-2" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Cabang Management</span>
                </a>

                <!-- Section Label -->
                <p class="px-3 pt-4 mb-2 text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Data & Risiko</p>

                <a href="{{ route('resikos.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('resikos.*') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="shield-alert" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Management Resiko</span>
                </a>

                <a href="{{ route('tahanans.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 text-slate-400 rounded-xl transition-all duration-200 {{ request()->routeIs('tahanans.*') ? 'active' : '' }}">
                    <span class="nav-icon w-8 h-8 rounded-lg flex items-center justify-center bg-transparent transition-all duration-200">
                        <i data-lucide="user-minus" class="w-4 h-4"></i>
                    </span>
                    <span class="text-[13px] font-semibold tracking-wide">Data Tahanan</span>
                </a>
            </nav>
            <div class="p-4 border-t border-[#D2A039]/20 mb-4 space-y-3">
                <a href="{{ route('profile') }}" class="flex items-center p-3 bg-slate-800/30 rounded-2xl border border-[#D2A039]/20 hover:bg-slate-800/60 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-[#D2A039]/10 flex items-center justify-center text-[#D2A039] group-hover:bg-[#D2A039]/20 group-hover:scale-105 transition-all">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-xs font-bold text-slate-200 truncate font-black tracking-widest uppercase">Admin</p>
                        <p class="text-[9px] text-slate-500 font-medium tracking-tight whitespace-nowrap">Super Administrator</p>
                    </div>
                </a>
                <a href="{{ route('landing') }}" class="flex items-center justify-center space-x-3 px-6 py-3.5 bg-[#D2A039]/10 border border-[#D2A039]/20 rounded-2xl text-[#D2A039] font-black text-[10px] uppercase tracking-[0.2em] hover:bg-[#D2A039] hover:text-[#061B30] transition-all duration-300 shadow-lg shadow-[#D2A039]/10 active:scale-95">
                    <i data-lucide="globe" class="w-4 h-4"></i>
                    <span>Tinjau Landing Page</span>
                </a>
                <a href="{{ route('logout') }}" onclick="confirmLogout(event)" class="flex items-center justify-center space-x-3 px-6 py-3.5 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-400 font-black text-[10px] uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all duration-300 shadow-lg shadow-rose-500/5 active:scale-95">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#061B30]">
            <header class="h-16 bg-[#031121]/80 backdrop-blur-md border-b border-[#D2A039]/20 flex items-center justify-between px-8 sticky top-0 z-10">
                <h2 class="text-sm font-bold text-slate-200 uppercase tracking-widest">
                    @yield('page_title', 'Overview')
                </h2>
                <div class="flex items-center space-x-3">
                    <button class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                    </button>
                    <button class="p-2 text-slate-500 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                        <i data-lucide="settings" class="w-4 h-4"></i>
                    </button>
                </div>
            </header>

            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-[#D2A039]/10 border border-[#D2A039]/20 text-[#D2A039] rounded-2xl flex items-center animate-in fade-in slide-in-from-top-4">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

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
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = href;
                }
            });
        }

        // Delete Confirmation Helper
        function confirmDelete(event, form) {
            event.preventDefault();
            swalDark.fire({
                title: 'Konfirmasi Hapus',
                text: "Data ini akan dihapus secara permanen dari sistem.",
                icon: 'warning',
                iconColor: '#f43f5e',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
