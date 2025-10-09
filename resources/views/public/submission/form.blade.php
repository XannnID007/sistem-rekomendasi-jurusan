<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Rekomendasi Jurusan - SPK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/heroicons/2.0.16/24/outline/heroicons.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy': '#1e3a8a',
                        'navy-dark': '#1e40af',
                        'gold': '#fbbf24',
                    }
                }
            }
        }
    </script>
    <style>
        /* Optional: Smooth scrolling for better UX */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <a href="{{ route('welcome') }}"
                    class="text-sm font-medium text-navy hover:text-navy-dark transition-colors duration-200">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-navy text-white rounded-2xl mx-auto mb-4 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Formulir Rekomendasi</h1>
                <p class="mt-2 text-lg text-gray-600">Lengkapi data di bawah ini untuk mendapatkan rekomendasi jurusan
                    yang paling sesuai untukmu.</p>
            </div>

            @if (session('error') || $errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat Kesalahan</h3>
                            <div class="mt-2 text-sm text-red-700">
                                @if (session('error'))
                                    <p>{{ session('error') }}</p>
                                @endif
                                @if ($errors->any())
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('submission.submit') }}" method="POST" class="space-y-8">
                @csrf

                @php
                    $sections = [
                        1 => [
                            'title' => 'Data Diri Siswa',
                            'icon' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>',
                        ],
                        2 => [
                            'title' => 'Nilai Akademik',
                            'icon' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M12 8h.01M15 8h.01M15 5h.01M12 5h.01M9 5h.01M4 7h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V8a1 1 0 011-1z" /></svg>',
                        ],
                        3 => [
                            'title' => 'Minat & Bakat',
                            'icon' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                        ],
                        4 => [
                            'title' => 'Biaya Pendaftaran',
                            'icon' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
                        ],
                    ];
                @endphp

                @foreach ($sections as $index => $section)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-200 p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 bg-navy text-white rounded-xl flex items-center justify-center">
                                {!! $section['icon'] !!}
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $section['title'] }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            @if ($index === 1)
                                @include('public.submission.partials.data-pribadi')
                            @elseif ($index === 2)
                                @include('public.submission.partials.nilai-akademik')
                            @elseif ($index === 3)
                                @include('public.submission.partials.minat-bakat')
                            @elseif ($index === 4)
                                @include('public.submission.partials.biaya')
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="pt-6 flex justify-end items-center">
                    <a href="{{ route('welcome') }}"
                        class="text-sm font-semibold text-gray-600 hover:text-gray-900 mr-6">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-navy text-white font-bold py-4 px-8 rounded-lg hover:bg-navy-dark transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Dapatkan Rekomendasi
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        document.querySelectorAll('input[type="tel"], input[name="nisn"]').forEach(function(input) {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>

</body>

</html>
