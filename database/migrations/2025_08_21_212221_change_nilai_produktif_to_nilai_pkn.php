<?php

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
        // Pastikan tabel ada dan kolom nilai_produktif masih ada
        if (
            Schema::hasTable('penilaian_peserta_didik') &&
            Schema::hasColumn('penilaian_peserta_didik', 'nilai_produktif') &&
            !Schema::hasColumn('penilaian_peserta_didik', 'nilai_pkn')
        ) {

            // Untuk MySQL, gunakan raw SQL yang lebih reliable
            DB::statement('ALTER TABLE penilaian_peserta_didik CHANGE nilai_produktif nilai_pkn DECIMAL(5,2)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (
            Schema::hasTable('penilaian_peserta_didik') &&
            Schema::hasColumn('penilaian_peserta_didik', 'nilai_pkn') &&
            !Schema::hasColumn('penilaian_peserta_didik', 'nilai_produktif')
        ) {

            DB::statement('ALTER TABLE penilaian_peserta_didik CHANGE nilai_pkn nilai_produktif DECIMAL(5,2)');
        }
    }
};
