<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * BOBOT KRITERIA SESUAI EXCEL ASLI
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
                'keterangan' => 'Minat pada bidang seni, musik, fotografi, desain grafis',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MB',
                'nama_kriteria' => 'Minat Bidang Teknologi',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.3900, // 39% - TERBESAR!
                'keterangan' => 'Minat pada bidang teknologi informasi, komputer, elektronik, mesin',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MC',
                'nama_kriteria' => 'Minat Bidang Ilmiah',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0300, // 3%
                'keterangan' => 'Minat pada bidang sains, fisika, kimia, biologi',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MD',
                'nama_kriteria' => 'Minat Bidang Bisnis',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0300, // 3%
                'keterangan' => 'Minat pada bidang bisnis, kewirausahaan, pemasaran',
                'is_active' => true,
            ],

            // Bakat/Keahlian (39% - SAMA BESAR DENGAN MB!)
            [
                'kode_kriteria' => 'BB',
                'nama_kriteria' => 'Bakat (Keahlian Teknis)',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.3900, // 39%
                'keterangan' => 'Keahlian dan bakat teknis yang dimiliki',
                'is_active' => true,
            ],

            // Biaya Gelombang (1% - COST!)
            [
                'kode_kriteria' => 'BP',
                'nama_kriteria' => 'Biaya Gelombang',
                'jenis_kriteria' => 'cost', // COST! Lower is better
                'bobot' => 0.0100, // 1%
                'keterangan' => 'Biaya pendaftaran gelombang - semakin rendah semakin baik',
                'is_active' => true,
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::updateOrCreate(
                ['kode_kriteria' => $k['kode_kriteria']],
                $k
            );
        }

        // Validasi
        $totalBobot = Kriteria::sum('bobot');

        $this->command->info("\n=== VALIDASI BOBOT ===");
        if (abs($totalBobot - 1.0) < 0.001) {
            $this->command->info("✓ Total bobot = 100% (Valid)");
        } else {
            $this->command->warn("⚠ Total bobot = " . ($totalBobot * 100) . "%");
        }

        $this->command->info("\n=== DISTRIBUSI BOBOT ===");
        $this->command->info("Akademik (N1-N6): 12%");
        $this->command->info("Minat Kreatif (MA): 3%");
        $this->command->info("Minat Teknologi (MB): 39% ⭐");
        $this->command->info("Minat Ilmiah (MC): 3%");
        $this->command->info("Minat Bisnis (MD): 3%");
        $this->command->info("Bakat (BB): 39% ⭐");
        $this->command->info("Biaya (BP): 1% [COST]");
        $this->command->info("TOTAL: 100%\n");
    }
}
