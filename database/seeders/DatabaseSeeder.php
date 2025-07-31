<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PesertaDidik;
use App\Models\Kriteria;
use App\Models\PenilaianPesertaDidik;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KriteriaSeeder::class,
            PesertaDidikSeeder::class,
            PenilaianSeeder::class,
        ]);
    }
}
