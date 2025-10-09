<?php
// app/Models/PesertaDidik.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'peserta_didik';
    protected $primaryKey = 'peserta_didik_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'nama_orang_tua',
        'no_telepon_orang_tua',
        'tahun_ajaran',

        // ======================================================
        // PERBAIKAN UTAMA: TAMBAHKAN TIGA BARIS INI
        // ======================================================
        'is_public_submission',
        'email_submission',
        'no_telepon_submission',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_public_submission' => 'boolean', // Tambahkan ini untuk keamanan
        ];
    }

    /**
     * Get the user that owns the peserta didik.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the penilaian for the peserta didik.
     */
    public function penilaian()
    {
        return $this->hasMany(PenilaianPesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    /**
     * Get the latest penilaian for the peserta didik.
     */
    public function penilaianTerbaru()
    {
        return $this->hasOne(PenilaianPesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id')
            ->latest('created_at'); // Menggunakan created_at untuk data terbaru
    }

    /**
     * Get the perhitungan TOPSIS for the peserta didik.
     */
    public function perhitunganTopsis()
    {
        return $this->hasMany(PerhitunganTopsis::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    /**
     * Get the latest perhitungan TOPSIS for the peserta didik.
     */
    public function perhitunganTerbaru()
    {
        return $this->hasOne(PerhitunganTopsis::class, 'peserta_didik_id', 'peserta_didik_id')
            ->latest('tanggal_perhitungan');
    }

    /**
     * Get formatted gender
     */
    public function getJenisKelaminLengkapAttribute(): string
    {
        if ($this->jenis_kelamin === 'L') {
            return 'Laki-laki';
        }
        if ($this->jenis_kelamin === 'P') {
            return 'Perempuan';
        }
        return 'Tidak Diketahui';
    }

    /**
     * Get age from birth date
     */
    public function getUmurAttribute(): int
    {
        return $this->tanggal_lahir->age;
    }
}
