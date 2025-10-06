<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Bobot kriteria SESUAI EXCEL yang BENAR
     * Total = 100% (1.00)
     */
    public function run(): void
    {
        $kriteria = [
            // Nilai Akademik (12% total - masing-masing 2%)
            [
                'kode_kriteria' => 'N1',
                'nama_kriteria' => 'Nilai IPA',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Ilmu Pengetahuan Alam',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N2',
                'nama_kriteria' => 'Nilai IPS',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Ilmu Pengetahuan Sosial',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N3',
                'nama_kriteria' => 'Nilai Bahasa Inggris',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Bahasa Inggris',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N4',
                'nama_kriteria' => 'Nilai Matematika',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Matematika',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N5',
                'nama_kriteria' => 'Nilai Bahasa Indonesia',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Bahasa Indonesia',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N6',
                'nama_kriteria' => 'Nilai PKN',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0200, // 2%
                'keterangan' => 'Nilai mata pelajaran Pendidikan Kewarganegaraan',
                'is_active' => true,
            ],

            // Minat (48% total)
            [
                'kode_kriteria' => 'MA',
                'nama_kriteria' => 'Minat Bidang Kreatif',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0300, // 3%
                'keterangan' => 'Minat pada bidang seni, musik, fotografi, desain grafis, dan kreativitas',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MB',
                'nama_kriteria' => 'Minat Bidang Teknologi',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.3900, // 39% - TERBESAR!
                'keterangan' => 'Minat pada bidang teknologi informasi, komputer, elektronik, dan mesin',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MC',
                'nama_kriteria' => 'Minat Bidang Ilmiah',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0300, // 3%
                'keterangan' => 'Minat pada bidang sains, fisika, kimia, dan biologi',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MD',
                'nama_kriteria' => 'Minat Bidang Bisnis & Manajemen',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0300, // 3%
                'keterangan' => 'Minat pada bidang bisnis, kewirausahaan, dan pemasaran',
                'is_active' => true,
            ],

            // Bakat/Keahlian (39% - TERBESAR!)
            [
                'kode_kriteria' => 'BB',
                'nama_kriteria' => 'Bakat (Keahlian Teknis)',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.3900, // 39% - SAMA BESAR DENGAN MB!
                'keterangan' => 'Keahlian dan bakat teknis yang dimiliki peserta didik',
                'is_active' => true,
            ],

            // Biaya Pergelombang (1% - COST)
            [
                'kode_kriteria' => 'BP',
                'nama_kriteria' => 'Biaya Pergelombang',
                'jenis_kriteria' => 'cost', // COST! Semakin rendah semakin baik
                'bobot' => 0.0100, // 1%
                'keterangan' => 'Biaya pergelombang pendaftaran (G1, G2, G3) - semakin rendah semakin baik',
                'is_active' => true,
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::updateOrCreate(
                ['kode_kriteria' => $k['kode_kriteria']],
                $k
            );
        }

        // Validasi total bobot = 100%
        $totalBobot = Kriteria::sum('bobot');

        if (abs($totalBobot - 1.0) > 0.001) {
            $this->command->warn("Warning: Total bobot kriteria = " . ($totalBobot * 100) . "%, seharusnya 100%");
        } else {
            $this->command->info("✓ Total bobot kriteria = 100% (Valid)");
        }

        // Tampilkan ringkasan
        $this->command->info("\n=== RINGKASAN BOBOT ===");
        $this->command->info("Akademik (N1-N6): 12%");
        $this->command->info("Minat Kreatif (MA): 3%");
        $this->command->info("Minat Teknologi (MB): 39% ⭐");
        $this->command->info("Minat Ilmiah (MC): 3%");
        $this->command->info("Minat Bisnis (MD): 3%");
        $this->command->info("Bakat (BB): 39% ⭐");
        $this->command->info("Biaya Gelombang (BP): 1% [COST]");
        $this->command->info("TOTAL: 100%");

        $this->command->info("\n✅ Kriteria seeded sesuai Excel!");
    }
}
