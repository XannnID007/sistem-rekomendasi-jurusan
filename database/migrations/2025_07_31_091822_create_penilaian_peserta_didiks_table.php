<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_peserta_didik', function (Blueprint $table) {
            $table->id('penilaian_id');
            $table->unsignedBigInteger('peserta_didik_id');
            $table->string('tahun_ajaran', 9);

            // Nilai Akademik
            $table->decimal('nilai_ipa', 5, 2);
            $table->decimal('nilai_ips', 5, 2);
            $table->decimal('nilai_matematika', 5, 2);
            $table->decimal('nilai_bahasa_indonesia', 5, 2);
            $table->decimal('nilai_bahasa_inggris', 5, 2);
            $table->decimal('nilai_produktif', 5, 2);

            // Minat (akan dikonversi ke nilai numerik)
            $table->string('minat_a')->nullable(); // Minat A
            $table->string('minat_b')->nullable(); // Minat B  
            $table->string('minat_c')->nullable(); // Minat C
            $table->string('minat_d')->nullable(); // Minat D

            // Keahlian dan Ekonomi
            $table->string('keahlian')->nullable();
            $table->string('penghasilan_ortu', 50)->nullable(); // G1, G2, G3 dengan keterangan

            // Status perhitungan
            $table->boolean('sudah_dihitung')->default(false);
            $table->timestamps();

            $table->foreign('peserta_didik_id')->references('peserta_didik_id')->on('peserta_didik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_peserta_didik');
    }
};
