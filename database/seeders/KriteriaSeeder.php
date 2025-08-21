<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            // Nilai Akademik (30% total)
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
                // CHANGED: dari "Nilai Produktif" ke "Nilai PKN"
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
                'nama_kriteria' => 'Minat A',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Minat pada bidang seni dan kreativitas',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MB',
                'nama_kriteria' => 'Minat B',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1500,
                'keterangan' => 'Minat pada bidang teknologi dan komputer',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MC',
                'nama_kriteria' => 'Minat C',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Minat pada bidang sains dan penelitian',
                'is_active' => true,
            ],
            [
                'kode_kriteria' => 'MD',
                'nama_kriteria' => 'Minat D',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.0500,
                'keterangan' => 'Minat pada bidang bisnis dan kewirausahaan',
                'is_active' => true,
            ],

            // Keahlian (20% total)
            [
                'kode_kriteria' => 'BB',
                'nama_kriteria' => 'Bidang Keahlian',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.2000,
                'keterangan' => 'Keahlian yang dimiliki peserta didik',
                'is_active' => true,
            ],

            // Faktor Ekonomi (15% total)  
            [
                'kode_kriteria' => 'BP',
                'nama_kriteria' => 'Background Penghasilan',
                'jenis_kriteria' => 'benefit',
                'bobot' => 0.1000,
                'keterangan' => 'Latar belakang penghasilan orang tua',
                'is_active' => true,
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create($k);
        }
    }
}
