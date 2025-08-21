<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Data ASLI berdasarkan Excel - TIDAK DIUBAH
     * Dengan TOPSIS Service yang diperbaiki, data ini akan menghasilkan:
     * 1. NAILA RIZKI - 0.732211325 (TKJ)
     * 2. SRI SITI NURLATIFAH - 0.615767356 (TKJ) 
     * 3. BALQISY WARDAH HABIBAH - 0.388035034 (TKJ)
     * 4. SITI RAHAYU - 0.364923829 (TKJ)
     * 5. MUHAMMAD RIFFA - 0.29020469 (TKR)
     * 6. MUHAMMAD RAFFI - 0.246848151 (TKR)
     */
    public function run(): void
    {
        // Data penilaian berdasarkan Excel yang ASLI dan AKURAT
        $penilaianData = [
            [
                'nisn' => '0066731537',  // SRI SITI NURLATIFAH
                'nilai_ipa' => 80,
                'nilai_ips' => 82,
                'nilai_matematika' => 85,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 87,
                'nilai_pkn' => 81,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Kimia',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'perangkat lunak',
                'penghasilan_ortu' => 'G1. 1.000.000',
            ],
            [
                'nisn' => '3077762090',  // NAILA RIZKI
                'nilai_ipa' => 85,
                'nilai_ips' => 87,
                'nilai_matematika' => 85,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 86,
                'nilai_pkn' => 83,
                'minat_a' => 'Fotografi & Videografi',
                'minat_b' => 'Komputer',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'menganalisa',
                'penghasilan_ortu' => 'G2. 1.500.000',
            ],
            [
                'nisn' => '0079378430',  // MUHAMMAD RAFFI
                'nilai_ipa' => 86,
                'nilai_ips' => 80,
                'nilai_matematika' => 78,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 82,
                'nilai_pkn' => 82,
                'minat_a' => 'Seni & Kerajinan',
                'minat_b' => 'Elektronik',
                'minat_c' => 'Fisika',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'kelistrikan',
                'penghasilan_ortu' => 'G1. 1.000.000',
            ],
            [
                'nisn' => '0074255836',  // MUHAMMAD RIFFA
                'nilai_ipa' => 70,
                'nilai_ips' => 77,
                'nilai_matematika' => 77,
                'nilai_bahasa_indonesia' => 85,
                'nilai_bahasa_inggris' => 80,
                'nilai_pkn' => 82,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Mesin',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'Mengembangkan Rencana & Strategi',
                'penghasilan_ortu' => 'G3. 2.000.000',
            ],
            [
                'nisn' => '0071103523',  // BALQISY WARDAH HABIBAH
                'nilai_ipa' => 80,
                'nilai_ips' => 87,
                'nilai_matematika' => 77,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 85,
                'nilai_pkn' => 80,
                'minat_a' => 'Desain Grafis',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'Menggunakan Perangkat Lunak & Komputer',
                'penghasilan_ortu' => 'G3. 2.000.000',
            ],
            [
                'nisn' => '0074812147',  // SITI RAHAYU
                'nilai_ipa' => 72,
                'nilai_ips' => 75,
                'nilai_matematika' => 70,
                'nilai_bahasa_indonesia' => 74,
                'nilai_bahasa_inggris' => 80,
                'nilai_pkn' => 79,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'memecahkan masalah',
                'penghasilan_ortu' => 'G3. 2.000.000',
            ],
        ];

        foreach ($penilaianData as $data) {
            // Find peserta didik by NISN
            $pesertaDidik = PesertaDidik::where('nisn', $data['nisn'])->first();

            if ($pesertaDidik) {
                PenilaianPesertaDidik::updateOrCreate(
                    [
                        'peserta_didik_id' => $pesertaDidik->peserta_didik_id,
                        'tahun_ajaran' => '2024/2025'
                    ],
                    [
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
                        'penghasilan_ortu' => $data['penghasilan_ortu'],
                        'sudah_dihitung' => false,
                    ]
                );
            }
        }
    }
}
