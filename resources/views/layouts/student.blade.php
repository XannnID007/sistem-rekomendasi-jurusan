<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa') - SPK Pemilihan Jurusan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'navy-light': '#3b82f6',
                        'gold': '#fbbf24',
                        'gold-dark': '#f59e0b'
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        @media (min-width: 1024px) {
            .sidebar-hidden {
                transform: translateX(0);
            }
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-item {
            position: relative;
        }

        .nav-item:hover::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #fbbf24;
            border-radius: 0 4px 4px 0;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #fbbf24;
            border-radius: 0 4px 4px 0;
        }

        .dropdown-enter {
            transform: translateY(-8px);
            opacity: 0;
        }

        .dropdown-enter-active {
            transform: translateY(0);
            opacity: 1;
            transition: all 0.2s ease-out;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transform sidebar-transition lg:translate-x-0 border-r border-gray-200">
        <!-- Logo & Brand -->
        <div class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-navy to-navy-dark">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <img src="/images/logo.png" alt="Logo SPK" class="w-6 h-6 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <span class="text-navy font-bold text-lg" style="display: none;">SP</span>
                </div>
                <div class="text-white">
                    <h1 class="text-lg font-semibold">Portal Siswa</h1>
                    <p class="text-xs text-gold opacity-90">SPK Pemilihan Jurusan</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-4">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('student.dashboard') }}"
                    class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('student.dashboard') ? 'bg-navy text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-navy' }} transition duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                    </svg>
                    Dashboard
                    @if (auth()->user()->pesertaDidik && !auth()->user()->pesertaDidik->perhitunganTerbaru)
                        <span class="ml-auto w-2 h-2 bg-gold rounded-full"></span>
                    @endif
                </a>

                <!-- Hasil Rekomendasi -->
                <a href="{{ route('student.rekomendasi.index') }}"
                    class="nav-item {{ request()->routeIs('student.rekomendasi.*') ? 'active' : '' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('student.rekomendasi.*') ? 'bg-navy text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-navy' }} transition duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Hasil Rekomendasi
                    @if (auth()->user()->pesertaDidik && auth()->user()->pesertaDidik->perhitunganTerbaru)
                        <span class="ml-auto px-2 py-1 text-xs font-bold bg-green-400 text-green-900 rounded-full">
                            {{ auth()->user()->pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi }}
                        </span>
                    @endif
                </a>

                <!-- Detail Analisis -->
                <a href="{{ route('student.analisis.index') }}"
                    class="nav-item {{ request()->routeIs('student.analisis.*') ? 'active' : '' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('student.analisis.*') ? 'bg-navy text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-navy' }} transition duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Detail Analisis
                </a>

                <!-- Profil -->
                <a href="{{ route('student.profil.index') }}"
                    class="nav-item {{ request()->routeIs('student.profil.*') ? 'active' : '' }} group flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('student.profil.*') ? 'bg-navy text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-navy' }} transition duration-200">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Saya
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-4"></div>

                <!-- Help/Info Card -->
                <div class="px-4 py-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-blue-600 font-medium text-sm">Tentang TOPSIS</span>
                        </div>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Sistem menggunakan metode TOPSIS untuk memberikan rekomendasi jurusan berdasarkan analisis
                            multi-kriteria yang objektif dan akurat.
                        </p>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>

    <!-- Main Content -->
    <div class="lg:ml-64 flex flex-col min-h-screen main-content">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" type="button"
                            class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-navy transition duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="ml-4 lg:ml-0">
                            <h1 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-500">@yield('page-description', 'Portal peserta didik')</p>
                        </div>
                    </div>

                    <!-- Right side items -->
                    <div class="flex items-center space-x-4">
                        <!-- Quick Stats (if on dashboard) -->
                        @if (request()->routeIs('student.dashboard'))
                            @if (auth()->user()->pesertaDidik && auth()->user()->pesertaDidik->perhitunganTerbaru)
                                <div class="hidden md:flex items-center space-x-4 mr-4">
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500">Rekomendasi</div>
                                        <div
                                            class="text-sm font-bold text-{{ auth()->user()->pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green' }}-600">
                                            {{ auth()->user()->pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi }}
                                        </div>
                                    </div>
                                    <div class="w-px h-8 bg-gray-300"></div>
                                    <div class="text-center">
                                        <div class="text-xs text-gray-500">Nilai Preferensi</div>
                                        <div class="text-sm font-bold text-navy">
                                            {{ number_format(auth()->user()->pesertaDidik->perhitunganTerbaru->nilai_preferensi, 3) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profile-dropdown-button"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition duration-200">
                                <div class="w-8 h-8 bg-navy rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-medium text-sm">{{ substr(auth()->user()->full_name ?? 'S', 0, 1) }}</span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-700">
                                        {{ auth()->user()->full_name ?? 'Siswa' }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ auth()->user()->pesertaDidik->nisn ?? 'Peserta Didik' }}</p>
                                </div>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profile-dropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50 border border-gray-200">
                                <div class="py-1">
                                    <a href="{{ route('student.profil.index') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">
                                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('student.profil.password') }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">
                                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Ubah Password
                                    </a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-200">
                                            <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg fade-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Main Content Area -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="px-6">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <p>&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
                    <p>Sistem Pendukung Keputusan v1.0</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-hidden');
            sidebarOverlay.classList.toggle('hidden');
        }

        mobileMenuButton.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Profile dropdown
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        profileDropdownButton.addEventListener('click', function() {
            profileDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.fade-in');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('bg-green-50') || alert.classList.contains('bg-red-50')) {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 300);
                }
            });
        }, 5000);
    </script>

    @stack('scripts')
</body>

</html>
