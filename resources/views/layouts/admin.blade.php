<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') - SPK Pemilihan Jurusan</title>
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
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-navy transform sidebar-transition lg:translate-x-0">
        <div class="flex items-center justify-center h-16 px-4 bg-navy-dark">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gold rounded-lg flex items-center justify-center">
                    <span class="text-navy font-bold text-lg">SP</span>
                </div>
                <div class="text-white">
                    <h1 class="text-lg font-bold">Admin Panel</h1>
                    <p class="text-xs text-gold">SPK Pemilihan Jurusan</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-5 px-2">
            <div class="space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z" />
                    </svg>
                    Dashboard
                </a>

                <!-- Kelola Peserta Didik -->
                <a href="{{ route('admin.peserta-didik.index') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.peserta-didik.*') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Kelola Peserta Didik
                </a>

                <!-- Kelola Perhitungan -->
                <a href="{{ route('admin.perhitungan.index') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.perhitungan.*') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Kelola Perhitungan
                </a>

                <!-- Hasil Rekomendasi -->
                <a href="{{ route('admin.rekomendasi.index') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.rekomendasi.*') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 00-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Hasil Rekomendasi
                </a>

                <!-- Cetak Laporan -->
                <a href="{{ route('admin.laporan.index') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.laporan.*') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Laporan
                </a>

                <!-- Divider -->
                <div class="border-t border-navy-light my-4"></div>

                <!-- Settings/Kriteria -->
                <a href="{{ route('admin.kriteria.index') }}"
                    class="nav-item group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.kriteria.*') ? 'bg-navy-light text-white' : 'text-gray-300 hover:bg-navy-light hover:text-white' }} transition duration-150 ease-in-out">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kelola Kriteria
                </a>
            </div>
        </nav>

        <!-- User Info at Bottom -->
        <div class="absolute bottom-0 w-full p-4 bg-navy-dark">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-gold rounded-full flex items-center justify-center">
                    <span class="text-navy font-bold text-sm">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-xs text-gold truncate">Administrator</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden hidden"></div>

    <!-- Main Content -->
    <div class="lg:ml-64 flex flex-col min-h-screen main-content">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm border-b border-gray-200 fixed w-full lg:ml-64 top-0 z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" type="button"
                            class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-navy">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="ml-4 lg:ml-0">
                            <h1 class="text-2xl font-bold text-navy">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600">@yield('page-description', 'Selamat datang di panel admin')</p>
                        </div>
                    </div>

                    <!-- Right side items -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 text-gray-400 hover:text-gray-500 relative">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5-5-5h5v-5H9l5-5 5 5h-5z" />
                            </svg>
                            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400"></span>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profile-dropdown-button"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition duration-150">
                                <div class="w-8 h-8 bg-navy rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white font-bold text-sm">{{ substr(auth()->user()->full_name, 0, 1) }}</span>
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-medium text-gray-700">{{ auth()->user()->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profile-dropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1">
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan</a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
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
        <main class="flex-1 pt-16">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Breadcrumb -->
                    @yield('breadcrumb')

                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div
                            class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg fade-in">
                            <div class="flex">
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
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg fade-in">
                            <div class="flex">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        &copy; 2024 SMK Penida 2 Katapang. All rights reserved.
                    </p>
                    <p class="text-sm text-gray-500">
                        Sistem Pendukung Keputusan v1.0
                    </p>
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
