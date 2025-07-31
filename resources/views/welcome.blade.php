<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Pemilihan Jurusan - SMK Penida 2 Katapang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#fbbf24',
                        'gold-dark': '#f59e0b'
                    }
                }
            }
        }
    </script>
    <style>
        .fade-in {
            animation: fadeIn 0.8s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center">
                        <span class="text-white font-semibold text-lg">SP</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">SPK Pemilihan Jurusan</h1>
                        <p class="text-xs text-gray-500">SMK Penida 2 Katapang</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="#about"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Tentang</a>
                    <a href="#features"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Fitur</a>
                    <a href="#contact"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Kontak</a>
                    <a href="/login"
                        class="bg-navy text-white px-4 py-2 rounded-lg hover:bg-navy-dark transition duration-200 text-sm font-medium">
                        Masuk Sistem
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-navy p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 border-t border-gray-200 mt-4 pt-4">
                <div class="space-y-2">
                    <a href="#about" class="block py-2 text-gray-700 hover:text-navy text-sm">Tentang</a>
                    <a href="#features" class="block py-2 text-gray-700 hover:text-navy text-sm">Fitur</a>
                    <a href="#contact" class="block py-2 text-gray-700 hover:text-navy text-sm">Kontak</a>
                    <a href="/login"
                        class="block mt-2 bg-navy text-white px-4 py-2 rounded-lg text-center text-sm">Masuk Sistem</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-navy via-navy-dark to-blue-900 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <div class="fade-in">
                    <div class="w-20 h-20 bg-gold rounded-2xl mx-auto mb-8 flex items-center justify-center">
                        <svg class="w-10 h-10 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">Sistem Pendukung Keputusan</h1>
                    <p class="text-lg md:text-xl text-gold mb-6">Pemilihan Jurusan dengan Metode TOPSIS</p>
                    <p class="text-base md:text-lg mb-8 text-blue-100 max-w-2xl mx-auto">
                        Temukan jurusan yang tepat sesuai dengan minat, bakat, dan kemampuan Anda melalui analisis yang
                        akurat dan objektif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/login"
                            class="bg-gold text-navy px-6 py-3 rounded-lg font-semibold hover:bg-gold-dark transition duration-200 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Mulai Sekarang
                        </a>
                        <a href="#about"
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-navy transition duration-200">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Tentang Sistem</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Sistem ini menggunakan metode TOPSIS untuk membantu siswa SMK Penida 2 Katapang dalam memilih
                    jurusan yang sesuai
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="slide-in">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Mengapa TOPSIS?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-3 h-3 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Objektif dan Akurat</h4>
                                <p class="text-gray-600 text-sm">Menganalisis multiple kriteria secara matematis untuk
                                    hasil yang objektif</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-3 h-3 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Komprehensif</h4>
                                <p class="text-gray-600 text-sm">Mempertimbangkan nilai akademik, minat, keahlian, dan
                                    faktor ekonomi</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-6 h-6 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-3 h-3 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Transparan</h4>
                                <p class="text-gray-600 text-sm">Proses perhitungan yang jelas dan dapat
                                    dipertanggungjawabkan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kriteria Penilaian</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-white rounded-lg">
                            <div class="text-xl font-bold text-navy">30%</div>
                            <div class="text-sm text-gray-600">Nilai Akademik</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg">
                            <div class="text-xl font-bold text-navy">35%</div>
                            <div class="text-sm text-gray-600">Minat & Bakat</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg">
                            <div class="text-xl font-bold text-navy">20%</div>
                            <div class="text-sm text-gray-600">Keahlian</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg">
                            <div class="text-xl font-bold text-navy">15%</div>
                            <div class="text-sm text-gray-600">Faktor Ekonomi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Berbagai fitur untuk mendukung proses pengambilan keputusan yang tepat
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="hover-lift bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-12 h-12 bg-navy rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Analisis TOPSIS</h3>
                    <p class="text-gray-600">Menggunakan metode TOPSIS yang terbukti akurat untuk pengambilan keputusan
                        multi-kriteria</p>
                </div>

                <!-- Feature 2 -->
                <div class="hover-lift bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-12 h-12 bg-navy rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Laporan Detail</h3>
                    <p class="text-gray-600">Dapatkan laporan lengkap dengan analisis mendalam dan rekomendasi yang
                        jelas</p>
                </div>

                <!-- Feature 3 -->
                <div class="hover-lift bg-white p-6 rounded-xl border border-gray-200">
                    <div class="w-12 h-12 bg-navy rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Mudah Digunakan</h3>
                    <p class="text-gray-600">Interface yang user-friendly memudahkan siswa dan admin dalam menggunakan
                        sistem</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-navy">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white mb-12">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Hubungi Kami</h2>
                <p class="text-lg text-blue-100">Butuh bantuan atau memiliki pertanyaan? Jangan ragu untuk menghubungi
                    kami</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Alamat</h3>
                    <p class="text-blue-100">SMK Penida 2 Katapang<br>Kabupaten Bandung, Jawa Barat</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Telepon</h3>
                    <p class="text-blue-100">(022) 1234-5678<br>admin@smkpenida2.sch.id</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Jam Operasional</h3>
                    <p class="text-blue-100">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-8 h-8 bg-gold rounded-lg flex items-center justify-center">
                        <span class="text-navy font-bold">SP</span>
                    </div>
                    <div>
                        <h3 class="font-bold">SPK Pemilihan Jurusan</h3>
                        <p class="text-sm text-gray-400">SMK Penida 2 Katapang</p>
                    </div>
                </div>
                <div class="text-center md:text-right">
                    <p class="text-gray-400">&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
                    <p class="text-sm text-gray-500 mt-1">Sistem Pendukung Keputusan dengan Metode TOPSIS</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
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
                // Close mobile menu if open
                mobileMenu.classList.add('hidden');
            });
        });

        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });
    </script>
</body>

</html>
