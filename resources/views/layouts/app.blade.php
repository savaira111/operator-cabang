<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Website - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #0f172a; /* Deep Slate */
        }
        .sidebar-link.active {
            background-color: #1e293b;
            color: #60a5fa; /* Blue 400 */
            border-left: 4px solid #3b82f6;
            font-weight: 600;
        }
        .night-card {
            background-color: #1a2333;
            border-color: #2d3648;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-300 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#111827] border-r border-slate-800 flex-shrink-0 flex flex-col">
            <div class="p-8">
                <h1 class="text-2xl font-black bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent tracking-tighter">
                    MANAGEMENT
                </h1>
            </div>
            <nav class="flex-1 px-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('users.index') }}" class="sidebar-link flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                    <span class="text-sm font-medium">User Management</span>
                </a>
                <a href="{{ route('cabangs.index') }}" class="sidebar-link flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white {{ request()->routeIs('cabangs.*') ? 'active' : '' }}">
                    <i data-lucide="building-2" class="w-5 h-5 mr-3"></i>
                    <span class="text-sm font-medium">Cabang Management</span>
                </a>
                <a href="{{ route('resikos.index') }}" class="sidebar-link flex items-center px-4 py-3 text-slate-400 rounded-xl transition-all duration-200 hover:bg-slate-800/50 hover:text-white {{ request()->routeIs('resikos.*') ? 'active' : '' }}">
                    <i data-lucide="shield-alert" class="w-5 h-5 mr-3"></i>
                    <span class="text-sm font-medium">Management Resiko</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800/50 mb-4 space-y-3">
                <a href="{{ route('profile') }}" class="flex items-center p-3 bg-slate-800/30 rounded-2xl border border-slate-700/30 hover:bg-slate-800/60 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:bg-blue-500/20 group-hover:scale-105 transition-all">
                        <i data-lucide="user" class="w-6 h-6"></i>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-xs font-bold text-slate-200 truncate font-black tracking-widest uppercase">Admin</p>
                        <p class="text-[9px] text-slate-500 font-medium tracking-tight whitespace-nowrap">Super Administrator</p>
                    </div>
                </a>
                <a href="{{ route('logout') }}" onclick="confirmLogout(event)" class="flex items-center justify-center space-x-3 px-6 py-3.5 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-400 font-black text-[10px] uppercase tracking-[0.2em] hover:bg-rose-500 hover:text-white transition-all duration-300 shadow-lg shadow-rose-500/5 active:scale-95">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Keluar Akun</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-[#0a0f1c]">
            <header class="h-16 bg-[#111827]/80 backdrop-blur-md border-b border-slate-800/50 flex items-center justify-between px-8 sticky top-0 z-10">
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
                    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center animate-in fade-in slide-in-from-top-4">
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
                popup: 'bg-[#111827] border border-slate-800 rounded-[2rem] text-slate-300 shadow-2xl',
                title: 'text-white font-black tracking-tight',
                htmlContainer: 'text-slate-400 font-medium',
                confirmButton: 'px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-500/20 active:scale-95 outline-none focus:ring-0',
                cancelButton: 'px-8 py-3 bg-slate-800 text-slate-400 font-bold rounded-2xl hover:bg-slate-700 hover:text-white transition-all outline-none focus:ring-0'
            },
            buttonsStyling: false
        });

        // Global Alert Handler
        @if(session('success'))
            swalDark.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                iconColor: '#10b981',
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
                iconColor: '#6366f1',
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
