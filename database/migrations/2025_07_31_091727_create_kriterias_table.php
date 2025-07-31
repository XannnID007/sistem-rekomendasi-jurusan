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
        Schema::create('kriteria', function (Blueprint $table) {
            $table->id('kriteria_id');
            $table->string('kode_kriteria', 10)->unique(); // N1, N2, N3, N4, N5, N6, MA, MB, MC, MD, BB, BP
            $table->string('nama_kriteria');
            $table->enum('jenis_kriteria', ['benefit', 'cost'])->default('benefit');
            $table->decimal('bobot', 5, 4); // bobot kriteria dengan 4 digit desimal
            $table->text('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria');
    }
};
