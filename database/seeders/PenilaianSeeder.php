<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penilaianData = [
            [
                'nisn' => '0066731537',
                'nilai_ipa' => 80,
                'nilai_ips' => 82,
                'nilai_matematika' => 85,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 87,
                'nilai_produktif' => 81,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Kimia',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'Mengembangkan Rencana & Strategi',
                'penghasilan_ortu' => 'G3. 2.000.000',
            ],
            [
                'nisn' => '0071103523',
                'nilai_ipa' => 80,
                'nilai_ips' => 87,
                'nilai_matematika' => 77,
                'nilai_bahasa_indonesia' => 80,
                'nilai_bahasa_inggris' => 85,
                'nilai_produktif' => 80,
                'minat_a' => 'Desain Grafis',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'Menggunakan Perangkat Lunak & Komputer',
                'penghasilan_ortu' => 'G3. 2.000.000',
            ],
            [
                'nisn' => '0074812147',
                'nilai_ipa' => 72,
                'nilai_ips' => 75,
                'nilai_matematika' => 70,
                'nilai_bahasa_indonesia' => 74,
                'nilai_bahasa_inggris' => 80,
                'nilai_produktif' => 79,
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
                PenilaianPesertaDidik::create([
                    'peserta_didik_id' => $pesertaDidik->peserta_didik_id,
                    'tahun_ajaran' => '2024/2025',
                    'nilai_ipa' => $data['nilai_ipa'],
                    'nilai_ips' => $data['nilai_ips'],
                    'nilai_matematika' => $data['nilai_matematika'],
                    'nilai_bahasa_indonesia' => $data['nilai_bahasa_indonesia'],
                    'nilai_bahasa_inggris' => $data['nilai_bahasa_inggris'],
                    'nilai_produktif' => $data['nilai_produktif'],
                    'minat_a' => $data['minat_a'],
                    'minat_b' => $data['minat_b'],
                    'minat_c' => $data['minat_c'],
                    'minat_d' => $data['minat_d'],
                    'keahlian' => $data['keahlian'],
                    'penghasilan_ortu' => $data['penghasilan_ortu'],
                    'sudah_dihitung' => false,
                ]);
            }
        }
    }
}
