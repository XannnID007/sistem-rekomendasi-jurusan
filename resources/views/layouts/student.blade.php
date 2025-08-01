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
                    },
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'fade-in': 'fadeIn 0.5s ease-in',
                        'bounce-gentle': 'bounceGentle 0.6s ease-in-out'
                    },
                    keyframes: {
                        slideIn: {
                            '0%': {
                                transform: 'translateX(-100%)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateX(0)',
                                opacity: '1'
                            }
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(10px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        bounceGentle: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-5px)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #fbbf24;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .nav-item:hover::before,
        .nav-item.active::before {
            transform: translateX(0);
        }

        .nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
        }

        .nav-item.active {
            background: #3b82f6;
            color: white;
        }

        .notification-dot {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-navy via-navy-dark to-navy-dark shadow-2xl transform sidebar-transition lg:translate-x-0 border-r border-navy-light/20">
        <!-- Logo & Brand -->
        <div
            class="flex items-center justify-center h-16 px-4 bg-gradient-to-r from-navy-dark to-navy border-b border-navy-light/20">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-gold to-gold-dark rounded-xl flex items-center justify-center shadow-lg transform hover:scale-105 transition-transform duration-200">
                    <span class="text-navy font-bold text-lg">SP</span>
                </div>
                <div class="text-white">
                    <h1 class="text-lg font-bold">Portal Siswa</h1>
                    <p class="text-xs text-gold opacity-90">SPK Pemilihan Jurusan</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-3 custom-scrollbar" style="height: calc(100vh - 140px); overflow-y: auto;">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('student.dashboard') }}"
                    class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }} group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('student.dashboard') ? 'bg-navy-light text-white shadow-lg' : 'text-gray-300 hover:text-white' }}">
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('student.dashboard') ? 'bg-white/20' : 'bg-navy-light/30 group-hover:bg-navy-light/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                        </svg>
                    </div>
                    <span class="flex-1">Dashboard</span>
                    @if (auth()->user()->pesertaDidik && !auth()->user()->pesertaDidik->perhitunganTerbaru)
                        <span class="w-2 h-2 bg-gold rounded-full notification-dot"></span>
                    @endif
                </a>

                <!-- Hasil Rekomendasi -->
                <a href="{{ route('student.rekomendasi.index') }}"
                    class="nav-item {{ request()->routeIs('student.rekomendasi.*') ? 'active' : '' }} group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('student.rekomendasi.*') ? 'bg-navy-light text-white shadow-lg' : 'text-gray-300 hover:text-white' }}">
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('student.rekomendasi.*') ? 'bg-white/20' : 'bg-navy-light/30 group-hover:bg-navy-light/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="flex-1">Hasil Rekomendasi</span>
                    @if (auth()->user()->pesertaDidik && auth()->user()->pesertaDidik->perhitunganTerbaru)
                        <span class="px-2 py-1 text-xs font-bold bg-green-400 text-green-900 rounded-full">
                            {{ auth()->user()->pesertaDidik->perhitunganTerbaru->jurusan_rekomendasi }}
                        </span>
                    @endif
                </a>

                <!-- Detail Analisis -->
                <a href="{{ route('student.analisis.index') }}"
                    class="nav-item {{ request()->routeIs('student.analisis.*') ? 'active' : '' }} group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('student.analisis.*') ? 'bg-navy-light text-white shadow-lg' : 'text-gray-300 hover:text-white' }}">
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('student.analisis.*') ? 'bg-white/20' : 'bg-navy-light/30 group-hover:bg-navy-light/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="flex-1">Detail Analisis</span>
                </a>

                <!-- Profil -->
                <a href="{{ route('student.profil.index') }}"
                    class="nav-item {{ request()->routeIs('student.profil.*') ? 'active' : '' }} group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('student.profil.*') ? 'bg-navy-light text-white shadow-lg' : 'text-gray-300 hover:text-white' }}">
                    <div
                        class="w-8 h-8 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('student.profil.*') ? 'bg-white/20' : 'bg-navy-light/30 group-hover:bg-navy-light/50' }} transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="flex-1">Profil Saya</span>
                </a>

                <!-- Divider -->
                <div class="border-t border-navy-light/30 my-4"></div>

                <!-- Help/Info Card -->
                <div class="px-3 py-4">
                    <div class="glass-effect rounded-xl p-4 border border-gold/20">
                        <div class="flex items-center space-x-2 mb-3">
                            <div class="w-6 h-6 bg-gold/20 rounded-lg flex items-center justify-center">
                                <svg class="h-4 w-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-gold font-medium text-sm">Tentang TOPSIS</span>
                        </div>
                        <p class="text-xs text-gray-300 leading-relaxed">
                            Sistem menggunakan metode TOPSIS untuk memberikan rekomendasi jurusan berdasarkan analisis
                            multi-kriteria yang objektif dan akurat.
                        </p>
                    </div>
                </div>
            </div>
        </nav>

        <!-- User Info at Bottom -->
        <div class="absolute bottom-0 w-full p-4 bg-gradient-to-t from-navy-dark to-transparent">
            <div class="glass-effect rounded-xl p-3">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-gold to-gold-dark rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-navy font-bold text-sm">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->full_name }}</p>
                        <p class="text-xs text-gold truncate">
                            {{ auth()->user()->pesertaDidik->nisn ?? 'Peserta Didik' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay"
        class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden hidden transition-opacity duration-300"></div>

    <!-- Main Content -->
    <div class="lg:ml-64 flex flex-col min-h-screen main-content">
        <!-- Top Navigation -->
        <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200 sticky top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" type="button"
                            class="lg:hidden p-2 rounded-xl text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-navy transition-all duration-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="ml-4 lg:ml-0">
                            <h1
                                class="text-2xl font-bold bg-gradient-to-r from-navy to-navy-dark bg-clip-text text-transparent">
                                @yield('page-title', 'Dashboard')
                            </h1>
                            <p class="text-sm text-gray-600 mt-0.5">@yield('page-description', 'Portal peserta didik')</p>
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
                                class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 transition-all duration-200 group">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-navy to-navy-dark rounded-full flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-200">
                                    <span
                                        class="text-white font-bold text-sm">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                                </div>
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->full_name }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ auth()->user()->pesertaDidik->nisn ?? 'Peserta Didik' }}</p>
                                </div>
                                <svg class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-200"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profile-dropdown"
                                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50 border border-gray-200 transform transition-all duration-200 origin-top-right">
                                <div class="p-3 border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-navy to-navy-dark rounded-full flex items-center justify-center">
                                            <span
                                                class="text-white font-bold text-sm">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ auth()->user()->full_name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ auth()->user()->pesertaDidik->nisn ?? 'Peserta Didik' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <a href="{{ route('student.profil.index') }}"
                                        class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>Profil Saya</span>
                                    </a>
                                    <a href="{{ route('student.profil.password') }}"
                                        class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        <span>Ubah Password</span>
                                    </a>
                                    <div class="border-t border-gray-100 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center space-x-3 px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>Keluar</span>
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
            <div class="max-w-7xl mx-auto">
                <!-- Alert Messages -->
                @if (session('success'))
                    <div
                        class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl animate-fade-in shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.parentElement.remove()"
                                class="ml-auto text-green-600 hover:text-green-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl animate-fade-in shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('error') }}</span>
                            <button onclick="this.parentElement.parentElement.remove()"
                                class="ml-auto text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-navy to-navy-dark rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">SP</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-900 font-medium">SPK Pemilihan Jurusan</p>
                            <p class="text-xs text-gray-500">SMK Penida 2 Katapang</p>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-sm text-gray-600">&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
                        <p class="text-xs text-gray-500 mt-1">Sistem Pendukung Keputusan v1.0</p>
                    </div>
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
            document.body.classList.toggle('overflow-hidden');
        }

        mobileMenuButton.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Profile dropdown
        const profileDropdownButton = document.getElementById('profile-dropdown-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        profileDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!profileDropdownButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.animate-fade-in');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('bg-green-50') || alert.classList.contains('bg-red-50')) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 300);
                }
            });
        }, 5000);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading states for navigation
        document.querySelectorAll('a[href]:not([href^="#"]):not([href^="javascript:"])').forEach(link => {
            link.addEventListener('click', function() {
                // Add subtle loading indication
                this.style.opacity = '0.7';
                this.style.pointerEvents = 'none';
            });
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Escape key closes dropdowns
            if (e.key === 'Escape') {
                profileDropdown.classList.add('hidden');

                // Close mobile sidebar on desktop
                if (window.innerWidth >= 1024) {
                    sidebar.classList.remove('sidebar-hidden');
                    sidebarOverlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
