<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Optimasi ukuran field database agar sesuai kebutuhan aktual
     */
    public function up(): void
    {
        // 1. Optimasi tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->change(); // dari 100 ke 50
            $table->string('email', 100)->change(); // dari 255 ke 100
            $table->string('full_name', 100)->change(); // dari 255 ke 100
        });

        // 2. Optimasi tabel peserta_didik
        Schema::table('peserta_didik', function (Blueprint $table) {
            $table->string('nama_lengkap', 100)->change(); // dari 255 ke 100
            $table->string('no_telepon', 13)->change(); // dari 15 ke 13 (max Indonesia: 0812-3456-7890)
            $table->string('nama_orang_tua', 100)->nullable()->change(); // dari 255 ke 100
            $table->string('no_telepon_orang_tua', 13)->nullable()->change(); // dari 15 ke 13
        });

        // 3. Optimasi tabel kriteria
        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 5)->change(); // dari 10 ke 5 (N1, N2, MA, MB, dll)
            $table->string('nama_kriteria', 100)->change(); // dari 255 ke 100
            $table->text('keterangan')->nullable()->change(); // tetap text untuk deskripsi panjang
        });

        // 4. Optimasi tabel penilaian_peserta_didik
        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            $table->string('minat_a', 50)->nullable()->change(); // dari 255 ke 50
            $table->string('minat_b', 50)->nullable()->change();
            $table->string('minat_c', 50)->nullable()->change();
            $table->string('minat_d', 50)->nullable()->change();
            $table->string('keahlian', 100)->nullable()->change(); // dari 255 ke 100
            $table->string('penghasilan_ortu', 30)->nullable()->change(); // dari 50 ke 30 (cukup untuk "G1. Rp 1.000.000")
        });

        // 5. Optimasi tabel laporan
        Schema::table('laporan', function (Blueprint $table) {
            $table->string('judul_laporan', 150)->change(); // dari 255 ke 150
            $table->string('file_path', 255)->nullable()->change(); // dari 500 ke 255 (cukup untuk path file)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke ukuran semula
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 100)->change();
            $table->string('email', 255)->change();
            $table->string('full_name', 255)->change();
        });

        Schema::table('peserta_didik', function (Blueprint $table) {
            $table->string('nama_lengkap', 255)->change();
            $table->string('no_telepon', 15)->change();
            $table->string('nama_orang_tua', 255)->nullable()->change();
            $table->string('no_telepon_orang_tua', 15)->nullable()->change();
        });

        Schema::table('kriteria', function (Blueprint $table) {
            $table->string('kode_kriteria', 10)->change();
            $table->string('nama_kriteria', 255)->change();
        });

        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            $table->string('minat_a', 255)->nullable()->change();
            $table->string('minat_b', 255)->nullable()->change();
            $table->string('minat_c', 255)->nullable()->change();
            $table->string('minat_d', 255)->nullable()->change();
            $table->string('keahlian', 255)->nullable()->change();
            $table->string('penghasilan_ortu', 50)->nullable()->change();
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->string('judul_laporan', 255)->change();
            $table->string('file_path', 500)->nullable()->change();
        });
    }
};
