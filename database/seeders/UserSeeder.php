<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@smkpenida2.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'full_name' => 'Administrator',
                'is_active' => true,
            ]
        );

        $this->command->info('✓ Admin user created');

        // Create Student Users (SESUAI DATA EXCEL)
        $students = [
            [
                'nisn' => '0066731537',
                'nama' => 'SRI SITI NURLATIFAH',
                'email' => 'sri.siti@student.smkpenida2.id',
            ],
            [
                'nisn' => '3077762090',
                'nama' => 'NAILA RIZKI',
                'email' => 'naila.rizki@student.smkpenida2.id',
            ],
            [
                'nisn' => '0079378430',
                'nama' => 'MUHAMMAD RAFFI',
                'email' => 'muhammad.raffi@student.smkpenida2.id',
            ],
            [
                'nisn' => '0074255836',
                'nama' => 'MUHAMMAD RIFFA',
                'email' => 'muhammad.riffa@student.smkpenida2.id',
            ],
            [
                'nisn' => '0071103523',
                'nama' => 'BALQISY WARDAH HABIBAH',
                'email' => 'balqisy.wardah@student.smkpenida2.id',
            ],
            [
                'nisn' => '0074812147',
                'nama' => 'SITI RAHAYU',
                'email' => 'siti.rahayu@student.smkpenida2.id',
            ],
        ];

        foreach ($students as $student) {
            User::updateOrCreate(
                ['username' => $student['nisn']],
                [
                    'email' => $student['email'],
                    'password' => Hash::make('password'), // Default password
                    'role' => 'student',
                    'full_name' => $student['nama'],
                    'is_active' => true,
                ]
            );

            $this->command->info("✓ Student user created: {$student['nama']} ({$student['nisn']})");
        }

        $this->command->info("\n✅ Total users created: " . User::count());
    }
}
