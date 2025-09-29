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
     * Data penilaian berdasarkan Excel yang AKURAT dan TELAH DIVALIDASI
     * Dengan TOPSIS Service yang diperbaiki, urutan hasil yang diharapkan:
     * 1. NAILA RIZKI (Nilai tertinggi - TKJ)
     * 2. SRI SITI NURLATIFAH (TKJ) 
     * 3. BALQISY WARDAH HABIBAH (TKJ)
     * 4. SITI RAHAYU (TKJ)
     * 5. MUHAMMAD RIFFA (TKR)
     * 6. MUHAMMAD RAFFI (TKR)
     */
    public function run(): void
    {
        $penilaianData = [
            [
                'nisn' => '0066731537',  // SRI SITI NURLATIFAH
                'nilai_ipa' => 80.00,
                'nilai_ips' => 82.00,
                'nilai_matematika' => 85.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 87.00,
                'nilai_pkn' => 81.00,
                'minat_a' => 'Musik & Teater',                           // Konversi: 3 (kreatif)
                'minat_b' => 'Teknologi informasi & Komunikasi',         // Konversi: 7 (sangat relevan TKJ)
                'minat_c' => 'Kimia',                                     // Konversi: 4 (sains menengah)
                'minat_d' => 'Bisnis & Enterpreneurship',                // Konversi: 3 (bisnis)
                'keahlian' => 'perangkat lunak',                         // Konversi: 7 (sangat relevan TKJ)
                'penghasilan_ortu' => 'G1. Rp 1.000.000',              // Konversi: 3 (rendah)
            ],
            [
                'nisn' => '3077762090',  // NAILA RIZKI 
                'nilai_ipa' => 85.00,
                'nilai_ips' => 87.00,
                'nilai_matematika' => 85.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 86.00,
                'nilai_pkn' => 83.00,
                'minat_a' => 'Fotografi & Videografi',                   // Konversi: 6 (kreatif-teknologi)
                'minat_b' => 'Komputer',                                 // Konversi: 7 (sangat relevan TKJ)
                'minat_c' => 'Biologi & Lingkungan',                     // Konversi: 4 (sains)
                'minat_d' => 'Bisnis & Enterpreneurship',                // Konversi: 3 (bisnis)
                'keahlian' => 'menganalisa',                             // Konversi: 6 (analisis)
                'penghasilan_ortu' => 'G2. Rp 1.500.000',              // Konversi: 5 (menengah)
            ],
            [
                'nisn' => '0079378430',  // MUHAMMAD RAFFI
                'nilai_ipa' => 86.00,
                'nilai_ips' => 80.00,
                'nilai_matematika' => 78.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 82.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Seni & Kerajinan',                         // Konversi: 3 (kreatif)
                'minat_b' => 'Elektronik',                               // Konversi: 6 (relevan TKR)
                'minat_c' => 'Fisika',                                   // Konversi: 5 (sains teknis)
                'minat_d' => 'Bisnis & Enterpreneurship',                // Konversi: 3 (bisnis)
                'keahlian' => 'kelistrikan',                             // Konversi: 7 (sangat relevan TKR)
                'penghasilan_ortu' => 'G1. Rp 1.000.000',              // Konversi: 3 (rendah)
            ],
            [
                'nisn' => '0074255836',  // MUHAMMAD RIFFA
                'nilai_ipa' => 70.00,
                'nilai_ips' => 77.00,
                'nilai_matematika' => 77.00,
                'nilai_bahasa_indonesia' => 85.00,
                'nilai_bahasa_inggris' => 80.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Musik & Teater',                           // Konversi: 3 (kreatif)
                'minat_b' => 'Mesin',                                    // Konversi: 6 (relevan TKR)
                'minat_c' => 'Biologi & Lingkungan',                     // Konversi: 4 (sains)
                'minat_d' => 'Bisnis & Enterpreneurship',                // Konversi: 3 (bisnis)
                'keahlian' => 'Mengembangkan Rencana & Strategi',       // Konversi: 6 (strategis)
                'penghasilan_ortu' => 'G3. Rp 2.000.000',              // Konversi: 6 (menengah-tinggi)
            ],
            [
                'nisn' => '0071103523',  // BALQISY WARDAH HABIBAH
                'nilai_ipa' => 80.00,
                'nilai_ips' => 87.00,
                'nilai_matematika' => 77.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 85.00,
                'nilai_pkn' => 80.00,
                'minat_a' => 'Desain Grafis',                            // Konversi: 6 (kreatif-teknologi)
                'minat_b' => 'Teknologi informasi & Komunikasi',         // Konversi: 7 (sangat relevan TKJ)
                'minat_c' => 'Biologi & Lingkungan',                     // Konversi: 4 (sains)
                'minat_d' => 'Pemasaran',                                // Konversi: 3 (bisnis)
                'keahlian' => 'Menggunakan Perangkat Lunak & Komputer', // Konversi: 7 (sangat relevan TKJ)
                'penghasilan_ortu' => 'G3. Rp 2.000.000',              // Konversi: 6 (menengah-tinggi)
            ],
            [
                'nisn' => '0074812147',  // SITI RAHAYU
                'nilai_ipa' => 72.00,
                'nilai_ips' => 75.00,
                'nilai_matematika' => 70.00,
                'nilai_bahasa_indonesia' => 74.00,
                'nilai_bahasa_inggris' => 80.00,
                'nilai_pkn' => 79.00,
                'minat_a' => 'Musik & Teater',                           // Konversi: 3 (kreatif)
                'minat_b' => 'Teknologi informasi & Komunikasi',         // Konversi: 7 (sangat relevan TKJ)
                'minat_c' => 'Biologi & Lingkungan',                     // Konversi: 4 (sains)
                'minat_d' => 'Pemasaran',                                // Konversi: 3 (bisnis)
                'keahlian' => 'memecahkan masalah',                      // Konversi: 6 (problem solving)
                'penghasilan_ortu' => 'G3. Rp 2.000.000',              // Konversi: 6 (menengah-tinggi)
            ],
        ];

        $successCount = 0;
        $errorCount = 0;

        foreach ($penilaianData as $data) {
            try {
                // Find peserta didik by NISN
                $pesertaDidik = PesertaDidik::where('nisn', $data['nisn'])->first();

                if ($pesertaDidik) {
                    $penilaian = PenilaianPesertaDidik::updateOrCreate(
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

                    // Display conversion info for debugging
                    $debugInfo = $penilaian->getDebugInfo();
                    $this->command->info("✓ {$pesertaDidik->nama_lengkap}:");
                    $this->command->info("  - Rata nilai: " . $penilaian->rata_nilai_akademik);
                    $this->command->info("  - Minat konversi: MA={$debugInfo['minat_converted']['ma']}, MB={$debugInfo['minat_converted']['mb']}, MC={$debugInfo['minat_converted']['mc']}, MD={$debugInfo['minat_converted']['md']}");
                    $this->command->info("  - Keahlian: {$debugInfo['keahlian_converted']} | Penghasilan: {$debugInfo['penghasilan_converted']}");

                    $successCount++;
                } else {
                    $this->command->error("✗ Peserta didik tidak ditemukan untuk NISN: {$data['nisn']}");
                    $errorCount++;
                }
            } catch (\Exception $e) {
                $this->command->error("✗ Error processing NISN {$data['nisn']}: " . $e->getMessage());
                $errorCount++;
            }
        }

        // Summary
        $this->command->info("\n=== SUMMARY PENILAIAN SEEDER ===");
        $this->command->info("✓ Berhasil: {$successCount} data");
        if ($errorCount > 0) {
            $this->command->error("✗ Gagal: {$errorCount} data");
        }

        // Validation check
        $totalPenilaian = PenilaianPesertaDidik::where('tahun_ajaran', '2024/2025')->count();
        $readyForCalculation = PenilaianPesertaDidik::where('tahun_ajaran', '2024/2025')
            ->readyForCalculation()
            ->count();

        $this->command->info("Total penilaian 2024/2025: {$totalPenilaian}");
        $this->command->info("Siap untuk kalkulasi: {$readyForCalculation}");

        if ($readyForCalculation == $totalPenilaian && $totalPenilaian > 0) {
            $this->command->info("✅ Semua data penilaian siap untuk perhitungan TOPSIS!");
        } else {
            $this->command->warn("⚠️  Ada data yang belum lengkap untuk perhitungan TOPSIS");
        }
    }
}
