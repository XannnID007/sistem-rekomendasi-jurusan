<?php
// database/migrations/2025_10_07_000000_change_penghasilan_ortu_to_biaya_gelombang.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename column dari penghasilan_ortu ke biaya_gelombang
        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            // Menggunakan raw SQL untuk MySQL yang lebih reliable
            DB::statement('ALTER TABLE penilaian_peserta_didik CHANGE penghasilan_ortu biaya_gelombang VARCHAR(30) NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            DB::statement('ALTER TABLE penilaian_peserta_didik CHANGE biaya_gelombang penghasilan_ortu VARCHAR(30) NULL');
        });
    }
};
