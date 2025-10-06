<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesertaDidik;
use App\Models\PenilaianPesertaDidik;

class PenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Data penilaian 100% SESUAI EXCEL
     */
    public function run(): void
    {
        $penilaianData = [
            [
                'nisn' => '0066731537',  // SRI SITI NURLATIFAH
                'nilai_ipa' => 80.00,
                'nilai_ips' => 82.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 85.00, // N3 di Excel
                'nilai_pkn' => 81.00,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Kimia',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'perangkat lunak',
                'biaya_gelombang' => 'G1. Rp 1.000.000',
            ],
            [
                'nisn' => '3077762090',  // NAILA RIZKI
                'nilai_ipa' => 85.00,
                'nilai_ips' => 87.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 85.00,
                'nilai_pkn' => 83.00,
                'minat_a' => 'Fotografi & Videografi',
                'minat_b' => 'Komputer',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'menganalisa',
                'biaya_gelombang' => 'G2. Rp 1.500.000',
            ],
            [
                'nisn' => '0079378430',  // MUHAMMAD RAFFI
                'nilai_ipa' => 86.00,
                'nilai_ips' => 80.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 78.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Seni & Kerajinan',
                'minat_b' => 'Elektronik',
                'minat_c' => 'Fisika',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'kelistrikan',
                'biaya_gelombang' => 'G1. Rp 1.000.000',
            ],
            [
                'nisn' => '0074255836',  // MUHAMMAD RIFFA
                'nilai_ipa' => 70.00,
                'nilai_ips' => 77.00,
                'nilai_matematika' => 85.00,
                'nilai_bahasa_indonesia' => 85.00,
                'nilai_bahasa_inggris' => 77.00,
                'nilai_pkn' => 82.00,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Mesin',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Bisnis & Enterpreneurship',
                'keahlian' => 'Mengembangkan Rencana & Strategi',
                'biaya_gelombang' => 'G3. Rp 2.000.000',
            ],
            [
                'nisn' => '0071103523',  // BALQISY WARDAH HABIBAH
                'nilai_ipa' => 80.00,
                'nilai_ips' => 87.00,
                'nilai_matematika' => 80.00,
                'nilai_bahasa_indonesia' => 80.00,
                'nilai_bahasa_inggris' => 77.00,
                'nilai_pkn' => 80.00,
                'minat_a' => 'Desain Grafis',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'Menggunakan Perangkat Lunak & Komputer',
                'biaya_gelombang' => 'G3. Rp 2.000.000',
            ],
            [
                'nisn' => '0074812147',  // SITI RAHAYU
                'nilai_ipa' => 72.00,
                'nilai_ips' => 75.00,
                'nilai_matematika' => 74.00,
                'nilai_bahasa_indonesia' => 74.00,
                'nilai_bahasa_inggris' => 70.00,
                'nilai_pkn' => 79.00,
                'minat_a' => 'Musik & Teater',
                'minat_b' => 'Teknologi informasi & Komunikasi',
                'minat_c' => 'Biologi & Lingkungan',
                'minat_d' => 'Pemasaran',
                'keahlian' => 'memecahkan masalah',
                'biaya_gelombang' => 'G3. Rp 2.000.000',
            ],
        ];

        $successCount = 0;
        $errorCount = 0;

        foreach ($penilaianData as $data) {
            try {
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
                            'biaya_gelombang' => $data['biaya_gelombang'],
                            'sudah_dihitung' => false,
                        ]
                    );

                    $debugInfo = $penilaian->getDebugInfo();
                    $this->command->info("✓ {$pesertaDidik->nama_lengkap}:");
                    $this->command->info("  - Rata nilai: " . $penilaian->rata_nilai_akademik);
                    $this->command->info("  - Minat: MA={$debugInfo['minat_converted']['ma']}, MB={$debugInfo['minat_converted']['mb']}, MC={$debugInfo['minat_converted']['mc']}, MD={$debugInfo['minat_converted']['md']}");
                    $this->command->info("  - Keahlian: {$debugInfo['keahlian_converted']} | Biaya Gelombang: {$debugInfo['biaya_gelombang_converted']}");

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

        $this->command->info("\n=== DATA SESUAI EXCEL ===");
        $this->command->info("✓ Bobot MB (Teknologi) = 39%");
        $this->command->info("✓ Bobot BB (Bakat) = 39%");
        $this->command->info("✓ BP = Biaya Gelombang (COST)");
    }
}
