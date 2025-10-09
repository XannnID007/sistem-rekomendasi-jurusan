{{-- resources/views/public/submission/partials/minat-bakat.blade.php --}}

@php
    $minatOptions = [
        'minat_a' => [
            'label' => 'Minat Bidang Kreatif',
            'options' => ['Musik & Teater', 'Fotografi & Videografi', 'Seni & Kerajinan', 'Desain Grafis'],
        ],
        'minat_b' => [
            'label' => 'Minat Bidang Teknologi',
            'options' => ['Teknologi informasi & Komunikasi', 'Komputer', 'Elektronik', 'Mesin'],
        ],
        'minat_c' => ['label' => 'Minat Bidang Ilmiah', 'options' => ['Kimia', 'Biologi & Lingkungan', 'Fisika']],
        'minat_d' => ['label' => 'Minat Bidang Bisnis', 'options' => ['Bisnis & Enterpreneurship', 'Pemasaran']],
    ];
@endphp

@foreach ($minatOptions as $field => $data)
    <div>
        <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">{{ $data['label'] }}</label>
        <select id="{{ $field }}" name="{{ $field }}" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
            <option value="">Pilih minat...</option>
            @foreach ($data['options'] as $option)
                <option value="{{ $option }}" {{ old($field) == $option ? 'selected' : '' }}>{{ $option }}
                </option>
            @endforeach
        </select>
    </div>
@endforeach

<div class="md:col-span-2">
    <label for="keahlian" class="block text-sm font-medium text-gray-700">Bakat / Keahlian Paling Menonjol</label>
    <select id="keahlian" name="keahlian" required
        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
        <option value="">Pilih keahlian...</option>
        @foreach (['perangkat lunak', 'menganalisa', 'kelistrikan', 'Mengembangkan Rencana & Strategi', 'memecahkan masalah', 'Menggunakan Perangkat Lunak & Komputer'] as $option)
            <option value="{{ $option }}" {{ old('keahlian') == $option ? 'selected' : '' }}>
                {{ ucfirst($option) }}</option>
        @endforeach
    </select>
</div>
