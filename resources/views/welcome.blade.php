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
        .hero-slider {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
        }

        .slide {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            opacity: 1;
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-navy rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">SP</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-navy">SPK Pemilihan Jurusan</h1>
                        <p class="text-sm text-gray-600">SMK Penida 2 Katapang</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about"
                        class="text-gray-700 hover:text-navy transition duration-300 font-medium">Tentang</a>
                    <a href="#features"
                        class="text-gray-700 hover:text-navy transition duration-300 font-medium">Fitur</a>
                    <a href="#contact"
                        class="text-gray-700 hover:text-navy transition duration-300 font-medium">Kontak</a>
                    <a href="/login"
                        class="bg-navy text-white px-6 py-3 rounded-lg hover:bg-navy-dark transition duration-300 font-medium shadow-lg">
                        Masuk Sistem
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-navy">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="#about" class="block py-2 text-gray-700 hover:text-navy">Tentang</a>
                <a href="#features" class="block py-2 text-gray-700 hover:text-navy">Fitur</a>
                <a href="#contact" class="block py-2 text-gray-700 hover:text-navy">Kontak</a>
                <a href="/login" class="block mt-2 bg-navy text-white px-4 py-2 rounded-lg text-center">Masuk
                    Sistem</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Image Slider -->
    <section class="hero-slider min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
        <!-- Background Slides -->
        <div class="absolute inset-0">
            <!-- Slide 1: Main -->
            <div
                class="slide active absolute inset-0 bg-gradient-to-r from-navy to-navy-dark flex items-center justify-center">
                <div class="text-center text-white max-w-5xl mx-auto px-4 z-10">
                    <div class="floating-animation mb-8">
                        <div
                            class="w-32 h-32 bg-gold rounded-full mx-auto flex items-center justify-center mb-6 shadow-2xl">
                            <svg class="w-16 h-16 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold mb-6 fade-in">Sistem Pendukung Keputusan</h1>
                    <p class="text-xl md:text-3xl mb-8 fade-in text-gold">Pemilihan Jurusan dengan Metode TOPSIS</p>
                    <p class="text-lg md:text-xl mb-8 opacity-90 fade-in max-w-3xl mx-auto">Temukan jurusan yang tepat
                        sesuai dengan minat, bakat, dan kemampuan Anda melalui analisis yang akurat dan objektif</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="/login"
                            class="bg-gold text-navy px-8 py-4 rounded-lg font-bold text-lg hover:bg-gold-dark transition duration-300 shadow-xl">
                            Mulai Sekarang
                        </a>
                        <a href="#about"
                            class="border-2 border-white text-white px-8 py-4 rounded-lg font-bold text-lg hover:bg-white hover:text-navy transition duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2: TKJ -->
            <div
                class="slide absolute inset-0 bg-gradient-to-br from-navy via-blue-800 to-navy-dark flex items-center justify-center">
                <div class="text-center text-white max-w-5xl mx-auto px-4 z-10">
                    <div class="floating-animation mb-8">
                        <div
                            class="w-32 h-32 bg-gold rounded-full mx-auto flex items-center justify-center mb-6 shadow-2xl">
                            <svg class="w-16 h-16 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">Teknik Komputer & Jaringan</h1>
                    <p class="text-xl md:text-3xl mb-8 text-gold">TKJ - Masa Depan Digital</p>
                    <p class="text-lg md:text-xl mb-8 opacity-90 max-w-3xl mx-auto">Pelajari teknologi komputer,
                        jaringan, dan sistem informasi untuk berkarir di era digital</p>
                </div>
            </div>

            <!-- Slide 3: TKR -->
            <div
                class="slide absolute inset-0 bg-gradient-to-br from-navy via-green-800 to-navy-dark flex items-center justify-center">
                <div class="text-center text-white max-w-5xl mx-auto px-4 z-10">
                    <div class="floating-animation mb-8">
                        <div
                            class="w-32 h-32 bg-gold rounded-full mx-auto flex items-center justify-center mb-6 shadow-2xl">
                            <svg class="w-16 h-16 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-5xl md:text-7xl font-bold mb-6">Teknik Kendaraan Ringan</h1>
                    <p class="text-xl md:text-3xl mb-8 text-gold">TKR - Teknologi Otomotif</p>
                    <p class="text-lg md:text-xl mb-8 opacity-90 max-w-3xl mx-auto">Kuasai teknologi otomotif dan sistem
                        kendaraan untuk industri transportasi masa depan</p>
                </div>
            </div>
        </div>

        <!-- Slide indicators -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3 z-20">
            <button class="indicator w-4 h-4 bg-white bg-opacity-50 rounded-full transition-all duration-300 active"
                onclick="currentSlide(1)"></button>
            <button class="indicator w-4 h-4 bg-white bg-opacity-50 rounded-full transition-all duration-300"
                onclick="currentSlide(2)"></button>
            <button class="indicator w-4 h-4 bg-white bg-opacity-50 rounded-full transition-all duration-300"
                onclick="currentSlide(3)"></button>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-navy mb-6">Tentang Sistem</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Sistem Pendukung Keputusan ini menggunakan metode
                    TOPSIS untuk membantu siswa SMK Penida 2 Katapang dalam memilih jurusan yang sesuai dengan kemampuan
                    dan minat mereka.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-3xl font-bold text-navy mb-6">Mengapa TOPSIS?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-8 h-8 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-navy">Objektif dan Akurat</h4>
                                <p class="text-gray-600">Menganalisis multiple kriteria secara matematis untuk hasil
                                    yang objektif</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-8 h-8 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-navy">Komprehensif</h4>
                                <p class="text-gray-600">Mempertimbangkan nilai akademik, minat, keahlian, dan faktor
                                    ekonomi</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div
                                class="w-8 h-8 bg-gold rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-navy">Transparan</h4>
                                <p class="text-gray-600">Proses perhitungan yang jelas dan dapat dipertanggungjawabkan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-xl">
                    <h3 class="text-2xl font-bold text-navy mb-6">Kriteria Penilaian</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-navy">30%</div>
                            <div class="text-sm text-gray-600">Nilai Akademik</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-navy">35%</div>
                            <div class="text-sm text-gray-600">Minat & Bakat</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-navy">20%</div>
                            <div class="text-sm text-gray-600">Keahlian</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-navy">15%</div>
                            <div class="text-sm text-gray-600">Faktor Ekonomi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-navy mb-6">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Sistem kami menyediakan berbagai fitur untuk
                    mendukung proses pengambilan keputusan yang tepat</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-navy rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-4">Analisis TOPSIS</h3>
                    <p class="text-gray-600">Menggunakan metode TOPSIS yang terbukti akurat untuk pengambilan keputusan
                        multi-kriteria</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-navy rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-4">Laporan Detail</h3>
                    <p class="text-gray-600">Dapatkan laporan lengkap dengan analisis mendalam dan rekomendasi yang
                        jelas</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <div class="w-16 h-16 bg-navy rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-4">Mudah Digunakan</h3>
                    <p class="text-gray-600">Interface yang user-friendly memudahkan siswa dan admin dalam menggunakan
                        sistem</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-navy">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center text-white">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Hubungi Kami</h2>
                <p class="text-xl mb-12 opacity-90">Butuh bantuan atau memiliki pertanyaan? Jangan ragu untuk
                    menghubungi kami</p>

                <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Alamat</h3>
                        <p class="opacity-90">SMK Penida 2 Katapang<br>Kabupaten Bandung, Jawa Barat</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Telepon</h3>
                        <p class="opacity-90">(022) 1234-5678<br>admin@smkpenida2.sch.id</p>
                    </div>

                    <div class="text-center">
                        <div class="w-16 h-16 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-navy" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Jam Operasional</h3>
                        <p class="opacity-90">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-gold rounded-lg flex items-center justify-center">
                        <span class="text-navy font-bold text-lg">SP</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">SPK Pemilihan Jurusan</h3>
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
        // Hero slider functionality
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const indicators = document.querySelectorAll('.indicator');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
                if (i === index) {
                    indicator.style.backgroundColor = '#fbbf24';
                } else {
                    indicator.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
                }
            });
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }

        function currentSlide(index) {
            currentSlideIndex = index - 1;
            showSlide(currentSlideIndex);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);

        // Initialize first slide
        showSlide(0);

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
    </script>
</body>

</html>
