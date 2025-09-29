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
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="/images/logo.png" alt="Logo SPK" class="w-10 h-10 object-contain"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="w-10 h-10 bg-navy rounded-lg flex items-center justify-center" style="display: none;">
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
                    <a href="#jurusan"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Jurusan</a>
                    <a href="{{ route('rekomendasi.index') }}"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Cek
                        Rekomendasi</a>
                    <a href="#contact"
                        class="text-gray-700 hover:text-navy transition duration-200 text-sm font-medium">Kontak</a>
                    <a href="/login"
                        class="bg-navy text-white px-4 py-2 rounded-lg hover:bg-navy-dark transition duration-200 text-sm font-medium">
                        Login Admin
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
                    <a href="#jurusan" class="block py-2 text-gray-700 hover:text-navy text-sm">Jurusan</a>
                    <a href="{{ route('rekomendasi.index') }}"
                        class="block py-2 text-gray-700 hover:text-navy text-sm">Cek Rekomendasi</a>
                    <a href="#contact" class="block py-2 text-gray-700 hover:text-navy text-sm">Kontak</a>
                    <a href="/login"
                        class="block mt-2 bg-navy text-white px-4 py-2 rounded-lg text-center text-sm">Login Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative py-40 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="/images/hero/aktivitas.jpg" alt="SMK Penida 2 Katapang" class="w-full h-full object-cover"
                onerror="this.style.display='none'; this.parentElement.classList.add('bg-navy');">
            <div class="absolute inset-0 bg-gradient-to-r from-navy/80 via-navy/40 to-transparent"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-white">
                <div class="fade-in">
                    <div class="w-20 h-20 bg-white rounded-2xl mx-auto mb-8 flex items-center justify-center shadow-xl">
                        <img src="/images/logo.png" alt="Logo SPK" class="w-12 h-12 object-contain"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <svg class="w-10 h-10 text-navy" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold mb-4 leading-tight">Sistem Pendukung Keputusan</h1>
                    <p class="text-lg md:text-xl text-gold mb-6 font-medium">Pemilihan Jurusan dengan Metode TOPSIS</p>
                    <a href="{{ route('rekomendasi.index') }}"
                        class="inline-flex items-center px-6 py-3 bg-gold text-navy rounded-lg hover:bg-gold-dark transition duration-200 font-semibold text-lg shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cek Rekomendasi Jurusan Saya
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Tentang SMK Penida 2 Katapang</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Sekolah Menengah Kejuruan yang berkomitmen dalam mencetak lulusan berkualitas dan siap kerja
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="slide-in">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Visi & Misi Sekolah</h3>
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
                                <h4 class="font-semibold text-gray-900">Pendidikan Berkualitas</h4>
                                <p class="text-gray-600 text-sm">Memberikan pendidikan kejuruan yang berkualitas tinggi
                                    sesuai standar industri</p>
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
                                <h4 class="font-semibold text-gray-900">Lulusan Siap Kerja</h4>
                                <p class="text-gray-600 text-sm">Mempersiapkan siswa dengan keterampilan teknis dan
                                    soft skill yang dibutuhkan dunia kerja</p>
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
                                <h4 class="font-semibold text-gray-900">Karakter Unggul</h4>
                                <p class="text-gray-600 text-sm">Membentuk siswa yang berakhlak mulia, disiplin, dan
                                    berjiwa entrepreneur</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Keunggulan Sekolah</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-gray-50 rounded-lg hover-lift">
                            <div class="text-xl font-bold text-navy">95%</div>
                            <div class="text-sm text-gray-600">Tingkat Kelulusan</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg hover-lift">
                            <div class="text-xl font-bold text-navy">85%</div>
                            <div class="text-sm text-gray-600">Alumni Terserap Kerja</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg hover-lift">
                            <div class="text-xl font-bold text-navy">20+</div>
                            <div class="text-sm text-gray-600">Guru Berpengalaman</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-lg hover-lift">
                            <div class="text-xl font-bold text-navy">2</div>
                            <div class="text-sm text-gray-600">Jurusan Unggulan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Jurusan Section -->
    <section id="jurusan" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Jurusan yang Tersedia</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Pilih jurusan yang sesuai dengan minat dan bakat Anda untuk masa depan yang cerah
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Jurusan TKR -->
                <div class="hover-lift bg-white p-8 rounded-xl border-2 border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-50 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M21.71 8.71c1.25-1.25.68-2.71 0-3.42l-3-3c-0.71-0.71-2.17-1.25-3.42 0l-12.29 12.29c-1.25 1.25-0.68 2.71 0 3.42l3 3c0.71 0.71 2.17 1.25 3.42 0l12.29-12.29zm-9.71-5.29l1.5 1.5-1.5 1.5-1.5-1.5 1.5-1.5zm-6 12l1.5 1.5-1.5 1.5-1.5-1.5 1.5-1.5z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Teknik Kendaraan Ringan (TKR)</h3>
                        <p class="text-gray-600 mb-6">Jurusan yang mempersiapkan siswa menjadi teknisi otomotif yang
                            handal dalam perawatan dan perbaikan kendaraan ringan.</p>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                Sistem Engine & Transmisi
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                Sistem Kelistrikan Otomotif
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                Diagnosis & Troubleshooting
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Prospek Kerja:</span>
                                <span class="text-green-600 font-medium">Bengkel, Dealer, Industri</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jurusan TKJ -->
                <div class="hover-lift bg-white p-8 rounded-xl border-2 border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20,18c1.1,0,2-0.9,2-2V6c0-1.1-0.9-2-2-2H4C2.9,4,2,4.9,2,6v10c0,1.1,0.9,2,2,2H0v2h24v-2H20z M4,6h16v10H4V6z" />
                                <path d="M6,8h2v2H6V8z M9,8h2v2H9V8z M12,8h2v2h-2V8z M6,11h8v2H6V11z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Teknik Komputer & Jaringan (TKJ)</h3>
                        <p class="text-gray-600 mb-6">Jurusan yang mempersiapkan siswa menjadi ahli dalam bidang
                            teknologi informasi, komputer, dan jaringan.</p>

                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                Administrasi Server & Jaringan
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                Programming & Web Development
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                Hardware & Software Support
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Prospek Kerja:</span>
                                <span class="text-blue-600 font-medium">IT Support, Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-900 mb-12">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Hubungi Kami</h2>
                <p class="text-lg text-gray-600">Butuh bantuan atau memiliki pertanyaan? Jangan ragu untuk menghubungi
                    kami</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-4xl mx-auto mb-12">
                <div class="text-center bg-white p-6 rounded-xl shadow-sm hover-lift">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Alamat</h3>
                    <p class="text-gray-600 text-sm">SMK Penida 2 Katapang<br>Jl. Raya Katapang No. 123<br>Kabupaten
                        Bandung</p>
                </div>

                <div class="text-center bg-white p-6 rounded-xl shadow-sm hover-lift">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Kontak</h3>
                    <p class="text-gray-600 text-sm">(022) 1234-5678<br>0812-3456-7890<br>admin@smkpenida2.sch.id</p>
                </div>

                <div class="text-center bg-white p-6 rounded-xl shadow-sm hover-lift">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold mb-2">Jam Operasional</h3>
                    <p class="text-gray-600 text-sm">Senin - Jumat: 07:00 - 16:00<br>Sabtu: 07:00 - 12:00<br>Minggu:
                        Tutup</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gold rounded-lg flex items-center justify-center">
                            <span class="text-navy font-bold text-lg">SP</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">SPK Pemilihan Jurusan</h3>
                            <p class="text-sm text-gray-400">SMK Penida 2 Katapang</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">Sistem Pendukung Keputusan untuk membantu siswa memilih
                        jurusan yang sesuai dengan minat dan bakat menggunakan metode TOPSIS.</p>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu Utama</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#about" class="hover:text-gold transition duration-200">Tentang Sekolah</a></li>
                        <li><a href="#jurusan" class="hover:text-gold transition duration-200">Program Keahlian</a>
                        </li>
                        <li><a href="{{ route('rekomendasi.index') }}"
                                class="hover:text-gold transition duration-200">Cek Rekomendasi</a></li>
                        <li><a href="/login" class="hover:text-gold transition duration-200">Login Admin</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 admin@smkpenida2.sch.id</li>
                        <li>📞 (022) 1234-5678</li>
                        <li>📱 0812-3456-7890</li>
                        <li>📍 Katapang, Bandung</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">&copy; 2024 SMK Penida 2 Katapang. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

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
                mobileMenu.classList.add('hidden');
            });
        });

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 10) {
                nav.classList.add('shadow-md');
            } else {
                nav.classList.remove('shadow-md');
            }
        });

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>

</html>
