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
        User::create([
            'username' => 'admin',
            'email' => 'admin@smkpenida2.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'full_name' => 'Administrator',
            'is_active' => true,
        ]);

        // Create sample student users (will be linked with PesertaDidik)
        $studentData = [
            [
                'username' => '0066731537',
                'email' => '0066731537@smkpenida2.id',
                'full_name' => 'SRI SITI NURLATIFAH',
            ],
            [
                'username' => '3077762090',
                'email' => '3077762090@smkpenida2.id',
                'full_name' => 'NAILA RIZKI',
            ],
            [
                'username' => '0079378430',
                'email' => '0079378430@smkpenida2.id',
                'full_name' => 'MUHAMMAD RAFFI',
            ],
            [
                'username' => '0074255836',
                'email' => '0074255836@smkpenida2.id',
                'full_name' => 'MUHAMMAD RIFFA',
            ],
            [
                'username' => '0071103523',
                'email' => '0071103523@smkpenida2.id',
                'full_name' => 'BALQISY WARDAH HABIBAH',
            ],
            [
                'username' => '0074812147',
                'email' => '0074812147@smkpenida2.id',
                'full_name' => 'SITI RAHAYU',
            ],
        ];

        foreach ($studentData as $data) {
            User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make('password'), // Default password
                'role' => 'student',
                'full_name' => $data['full_name'],
                'is_active' => true,
            ]);
        }
    }
}
