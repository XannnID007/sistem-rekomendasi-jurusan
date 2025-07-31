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
        Schema::create('perhitungan_topsis', function (Blueprint $table) {
            $table->id('perhitungan_id');
            $table->unsignedBigInteger('peserta_didik_id');
            $table->unsignedBigInteger('penilaian_id');
            $table->string('tahun_ajaran', 9);

            // Matriks ternormalisasi
            $table->decimal('normalized_n1', 10, 8)->nullable();
            $table->decimal('normalized_n2', 10, 8)->nullable();
            $table->decimal('normalized_n3', 10, 8)->nullable();
            $table->decimal('normalized_n4', 10, 8)->nullable();
            $table->decimal('normalized_n5', 10, 8)->nullable();
            $table->decimal('normalized_n6', 10, 8)->nullable();
            $table->decimal('normalized_ma', 10, 8)->nullable();
            $table->decimal('normalized_mb', 10, 8)->nullable();
            $table->decimal('normalized_mc', 10, 8)->nullable();
            $table->decimal('normalized_md', 10, 8)->nullable();
            $table->decimal('normalized_bb', 10, 8)->nullable();
            $table->decimal('normalized_bp', 10, 8)->nullable();

            // Matriks ternormalisasi terbobot
            $table->decimal('weighted_n1', 10, 8)->nullable();
            $table->decimal('weighted_n2', 10, 8)->nullable();
            $table->decimal('weighted_n3', 10, 8)->nullable();
            $table->decimal('weighted_n4', 10, 8)->nullable();
            $table->decimal('weighted_n5', 10, 8)->nullable();
            $table->decimal('weighted_n6', 10, 8)->nullable();
            $table->decimal('weighted_ma', 10, 8)->nullable();
            $table->decimal('weighted_mb', 10, 8)->nullable();
            $table->decimal('weighted_mc', 10, 8)->nullable();
            $table->decimal('weighted_md', 10, 8)->nullable();
            $table->decimal('weighted_bb', 10, 8)->nullable();
            $table->decimal('weighted_bp', 10, 8)->nullable();

            // Solusi ideal
            $table->decimal('jarak_positif', 10, 8)->nullable();
            $table->decimal('jarak_negatif', 10, 8)->nullable();
            $table->decimal('nilai_preferensi', 10, 8)->nullable();

            // Hasil rekomendasi
            $table->enum('jurusan_rekomendasi', ['TKJ', 'TKR']);
            $table->timestamp('tanggal_perhitungan')->useCurrent();
            $table->timestamps();

            $table->foreign('peserta_didik_id')->references('peserta_didik_id')->on('peserta_didik')->onDelete('cascade');
            $table->foreign('penilaian_id')->references('penilaian_id')->on('penilaian_peserta_didik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perhitungan_topsis');
    }
};
