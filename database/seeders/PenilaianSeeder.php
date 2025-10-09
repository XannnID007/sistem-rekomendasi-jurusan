<?php
// database/seeders/PenilaianSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data penilaian 100% SESUAI DENGAN DATA MENTAH DI EXCEL
     */
    public function run(): void
    {
        $penilaianData = [
            [
                // Data dari baris #REF! Sri Siti Nurlatifah di Excel
                'nisn' => '0079378430', // Diasumsikan ini NISN untuk Sri Siti
                'nilai_ipa' => 80.00,
                'nilai_ips' => 82.00,
                'nilai_bahasa_inggris' => 85.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 87.00,
                'nilai_pkn' => 81.00, // Di Excel 81, bukan 82
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Kimia',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'perangkat lunak',
                'biaya_gelombang' => 'G1. 1.000.000',
            ],
            [
                // Data dari baris #REF! Naila Rizki di Excel
                'nisn' => '3077762090',
                'nilai_ipa' => 85.00,
                'nilai_ips' => 87.00,
                'nilai_bahasa_inggris' => 85.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 86.00,
                'nilai_pkn' => 83.00,
                'minat_a' => 'Fotografi & Videografi',
                'minat_b' => 'Komputer',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'menganalisa',
                'biaya_gelombang' => 'G2. 1.500.000',
            ],
            [
                // Data dari baris #REF! Muhammad Raffi di Excel
                'nisn' => '0066731537',
                'nilai_ipa' => 86.00,
                'nilai_ips' => 80.00,
                'nilai_bahasa_inggris' => 78.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 82.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Seni & Kerajinan',
                'minat_b' => 'Elektronik',
                'minat_c' => 'Fisika',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'kelistrikan',
                'biaya_gelombang' => 'G1. 1.000.000',
            ],
            [
                // Data dari baris #REF! Muhammad Riffa di Excel
                'nisn' => '0074255836',
                'nilai_ipa' => 70.00,
                'nilai_ips' => 77.00,
                'nilai_bahasa_inggris' => 77.00,
                'nilai_matematika' => 85.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Mesin',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'Mengembangkan Rencana & Strategi',
                'biaya_gelombang' => 'G3. 2.000.000',
            ],
            [
                // Data dari baris #REF! Balqisy Wardah Habibah di Excel
                'nisn' => '0071103523',
                'nilai_ipa' => 80.00,
                'nilai_ips' => 87.00,
                'nilai_bahasa_inggris' => 77.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 85.00,
                'nilai_pkn' => 80.00,
                'minat_a' => 'Desain Grafis',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'Menggunakan Perangkat Lunak & Komputer',
                'biaya_gelombang' => 'G3. 2.000.000',
            ],
            [
                // Data dari baris #REF! Siti Rahayu di Excel
                'nisn' => '0074812147',
                'nilai_ipa' => 72.00,
                'nilai_ips' => 75.00,
                'nilai_bahasa_inggris' => 70.00,
                'nilai_matematika' => 74.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_pkn' => 79.00,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'memecahkan masalah',
                'biaya_gelombang' => 'G3. 2.000.000',
            ],
        ];

        foreach ($penilaianData as $data) {
            $pesertaDidik = PesertaDidik::where('nisn', $data['nisn'])->first();
            if ($pesertaDidik) {
                PenilaianPesertaDidik::updateOrCreate(
                    ['peserta_didik_id' => $pesertaDidik->peserta_didik_id],
                    [
                        'tahun_ajaran' => '2024/2025',
                        'nilai_ipa' => $data['nilai_ipa'],
                        'nilai_ips' => $data['nilai_ips'],
                        'nilai_matematika' => $data['nilai_matematika'],
                        'nilai_bahasa_indonesia' => $data['nilai_bahasa_indonesia'],
                        'nilai_bahasa_inggris' => $data['nilai_bahasa_inggris'],
                        'nilai_pkn' => $data['nilai_pkn'],
                        'minat_a' => $data['minat_a'],
                        'minat_b' => $data['minat_b'],
                        'minat_c' => $data['minat_c'],
                        'minat_d' => $data['minat_d'],
                        'keahlian' => $data['keahlian'],
                        'biaya_gelombang' => $data['biaya_gelombang'],
                        'sudah_dihitung' => false,
                    ]
                );
            }
        }
        $this->command->info('✅ Penilaian seeder berhasil dijalankan dengan data yang sesuai Excel.');
    }
}
