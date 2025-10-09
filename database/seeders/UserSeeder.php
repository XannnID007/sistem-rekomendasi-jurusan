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
    }
}
