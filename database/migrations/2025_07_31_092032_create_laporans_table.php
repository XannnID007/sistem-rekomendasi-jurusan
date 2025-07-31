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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('laporan_id');
            $table->string('judul_laporan');
            $table->enum('jenis_laporan', ['individual', 'ringkasan', 'perbandingan']);
            $table->string('tahun_ajaran', 9);
            $table->unsignedBigInteger('dibuat_oleh');
            $table->string('file_path', 500)->nullable();
            $table->json('parameter')->nullable(); // menyimpan parameter filter/kriteria laporan
            $table->timestamps();

            $table->foreign('dibuat_oleh')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
