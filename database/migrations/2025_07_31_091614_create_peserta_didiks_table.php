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
        Schema::create('peserta_didik', function (Blueprint $table) {
            $table->id('peserta_didik_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nisn', 10)->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir');
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('no_telepon_orang_tua', 15)->nullable();
            $table->string('tahun_ajaran', 9); // 2024/2025
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_didik');
    }
};
