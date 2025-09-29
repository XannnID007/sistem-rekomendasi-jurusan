<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Bobot kriteria yang telah disesuaikan untuk sistem TOPSIS SMK Penida 2
     */
    public function run(): void
    {
        $kriteria = [
            // Nilai Akademik (30% total - masing-masing 5%)
            [
                'kode_kriteria' => 'N1',
                'nama_kriteria' => 'Nilai IPA',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Ilmu Pengetahuan Alam',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N2',
                'nama_kriteria' => 'Nilai IPS',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Ilmu Pengetahuan Sosial',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N3',
                'nama_kriteria' => 'Nilai Matematika',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Matematika',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N4',
                'nama_kriteria' => 'Nilai Bahasa Indonesia',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Bahasa Indonesia',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N5',
                'nama_kriteria' => 'Nilai Bahasa Inggris',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Bahasa Inggris',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'N6',
                'nama_kriteria' => 'Nilai PKN',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Nilai mata pelajaran Pendidikan Kewarganegaraan',
                'is_active' => true,
            ],

            // Minat (35% total)
            [
                'kode_kriteria' => 'MA',
                'nama_kriteria' => 'Minat Seni & Kreativitas',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Minat pada bidang seni, musik, fotografi, dan kreativitas',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MB',
                'nama_kriteria' => 'Minat Teknologi',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1500,
                'keterangan' => 'Minat pada bidang teknologi, komputer, elektronik, dan mesin',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MC',
                'nama_kriteria' => 'Minat Sains',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Minat pada bidang sains, fisika, kimia, dan biologi',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MD',
                'nama_kriteria' => 'Minat Bisnis',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Minat pada bidang bisnis, kewirausahaan, dan pemasaran',
                'is_active' => true,
            ],

            // Keahlian Teknis (20% total)
            [
                'kode_kriteria' => 'BB',
                'nama_kriteria' => 'Bidang Keahlian',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.2000,
                'keterangan' => 'Keahlian teknis yang dimiliki peserta didik',
                'is_active' => true,
            ],

            // Background Ekonomi (15% total)  
            [
                'kode_kriteria' => 'BP',
                'nama_kriteria' => 'Background Penghasilan',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Latar belakang ekonomi keluarga sebagai pertimbangan praktis',
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

        $this->command->info('Kriteria seeded successfully!');
    }
}
