<?php
// database/migrations/2025_01_10_000000_add_submission_fields_to_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom status submission ke penilaian_peserta_didik
        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            $table->enum('status_submission', ['pending', 'approved', 'rejected'])->default('pending')->after('sudah_dihitung');
            $table->text('alasan_penolakan')->nullable()->after('status_submission');
            $table->string('jurusan_dipilih', 10)->nullable()->after('alasan_penolakan'); // TKJ atau TKR
            $table->timestamp('tanggal_submission')->nullable()->after('jurusan_dipilih');
            $table->timestamp('tanggal_approved')->nullable()->after('tanggal_submission');
        });

        // Tambah kolom untuk tracking public submission
        Schema::table('peserta_didik', function (Blueprint $table) {
            $table->boolean('is_public_submission')->default(false)->after('tahun_ajaran');
            $table->string('email_submission')->nullable()->after('is_public_submission');
            $table->string('no_telepon_submission', 15)->nullable()->after('email_submission');
        });
    }

    public function down(): void
    {
        Schema::table('penilaian_peserta_didik', function (Blueprint $table) {
            $table->dropColumn([
                'status_submission',
                'alasan_penolakan',
                'jurusan_dipilih',
                'tanggal_submission',
                'tanggal_approved'
            ]);
        });

        Schema::table('peserta_didik', function (Blueprint $table) {
            $table->dropColumn([
                'is_public_submission',
                'email_submission',
                'no_telepon_submission'
            ]);
        });
    }
};
