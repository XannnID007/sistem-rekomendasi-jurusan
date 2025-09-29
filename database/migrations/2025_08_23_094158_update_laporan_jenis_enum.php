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
        // Update enum untuk menambahkan 'recommendation_filter'
        DB::statement("ALTER TABLE laporan MODIFY COLUMN jenis_laporan ENUM('individual', 'ringkasan', 'perbandingan', 'recommendation_filter')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke enum semula
        DB::statement("ALTER TABLE laporan MODIFY COLUMN jenis_laporan ENUM('individual', 'ringkasan', 'perbandingan')");
    }
};
