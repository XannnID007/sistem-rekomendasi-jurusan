<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PesertaDidik;

class PesertaDidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentsData = [
            [
                'nisn' => '0066731537',
                'nama_lengkap' => 'SRI SITI NURLATIFAH',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2006-01-15',
                'alamat' => 'Katapang, Bandung',
                'no_telepon' => '081234567890',
                'nama_orang_tua' => 'Bapak Nurdin',
                'no_telepon_orang_tua' => '081234567891',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nisn' => '3077762090',
                'nama_lengkap' => 'NAILA RIZKI',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2006-03-22',
                'alamat' => 'Soreang, Bandung',
                'no_telepon' => '081234567892',
                'nama_orang_tua' => 'Ibu Siti',
                'no_telepon_orang_tua' => '081234567893',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nisn' => '0079378430',
                'nama_lengkap' => 'MUHAMMAD RAFFI',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2006-05-10',
                'alamat' => 'Banjaran, Bandung',
                'no_telepon' => '081234567894',
                'nama_orang_tua' => 'Bapak Ahmad',
                'no_telepon_orang_tua' => '081234567895',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nisn' => '0074255836',
                'nama_lengkap' => 'MUHAMMAD RIFFA',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2006-07-18',
                'alamat' => 'Margahayu, Bandung',
                'no_telepon' => '081234567896',
                'nama_orang_tua' => 'Bapak Ridwan',
                'no_telepon_orang_tua' => '081234567897',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nisn' => '0071103523',
                'nama_lengkap' => 'BALQISY WARDAH HABIBAH',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2006-09-25',
                'alamat' => 'Dayeuhkolot, Bandung',
                'no_telepon' => '081234567898',
                'nama_orang_tua' => 'Ibu Wardah',
                'no_telepon_orang_tua' => '081234567899',
                'tahun_ajaran' => '2024/2025',
            ],
            [
                'nisn' => '0074812147',
                'nama_lengkap' => 'SITI RAHAYU',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2006-11-12',
                'alamat' => 'Ciwidey, Bandung',
                'no_telepon' => '081234567800',
                'nama_orang_tua' => 'Ibu Rahayu',
                'no_telepon_orang_tua' => '081234567801',
                'tahun_ajaran' => '2024/2025',
            ],
        ];

        foreach ($studentsData as $studentData) {
            // Find the user by username (NISN)
            $user = User::where('username', $studentData['nisn'])->first();

            if ($user) {
                PesertaDidik::create([
                    'user_id' => $user->user_id,
                    'nisn' => $studentData['nisn'],
                    'nama_lengkap' => $studentData['nama_lengkap'],
                    'jenis_kelamin' => $studentData['jenis_kelamin'],
                    'tanggal_lahir' => $studentData['tanggal_lahir'],
                    'alamat' => $studentData['alamat'],
                    'no_telepon' => $studentData['no_telepon'],
                    'nama_orang_tua' => $studentData['nama_orang_tua'],
                    'no_telepon_orang_tua' => $studentData['no_telepon_orang_tua'],
                    'tahun_ajaran' => $studentData['tahun_ajaran'],
                ]);
            }
        }
    }
}
