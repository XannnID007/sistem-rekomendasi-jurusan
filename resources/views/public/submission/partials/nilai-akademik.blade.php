{{-- resources/views/public/submission/partials/nilai-akademik.blade.php --}}

@foreach ([
        'nilai_ipa' => 'Nilai IPA',
        'nilai_ips' => 'Nilai IPS',
        'nilai_matematika' => 'Nilai Matematika',
        'nilai_bahasa_indonesia' => 'Nilai Bahasa Indonesia',
        'nilai_bahasa_inggris' => 'Nilai Bahasa Inggris',
        'nilai_pkn' => 'Nilai PKN',
    ] as $field => $label)
    <div>
        <label for="{{ $field }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
        <input type="number" id="{{ $field }}" name="{{ $field }}" min="0" max="100" step="0.01"
            value="{{ old($field) }}" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-navy focus:border-navy">
    </div>
@endforeach
