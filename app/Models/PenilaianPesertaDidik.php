<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'penilaian_peserta_didik';
    protected $primaryKey = 'penilaian_id';

    /**
     * The attributes that are mass assignable.
     * Ini penting untuk keamanan saat membuat data baru secara massal.
     */
    protected $fillable = [
        'peserta_didik_id',
        'tahun_ajaran',
        'nilai_ipa',
        'nilai_ips',
        'nilai_matematika',
        'nilai_bahasa_indonesia',
        'nilai_bahasa_inggris',
        'nilai_pkn',
        'minat_a',
        'minat_b',
        'minat_c',
        'minat_d',
        'keahlian',
        'biaya_gelombang',
        'sudah_dihitung',
        'status_submission',
        'tanggal_submission',
        'tanggal_approved',
        'alasan_penolakan',
        'jurusan_dipilih',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'nilai_ipa' => 'decimal:2',
            'nilai_ips' => 'decimal:2',
            'nilai_matematika' => 'decimal:2',
            'nilai_bahasa_indonesia' => 'decimal:2',
            'nilai_bahasa_inggris' => 'decimal:2',
            'nilai_pkn' => 'decimal:2',
            'sudah_dihitung' => 'boolean',
            'tanggal_submission' => 'datetime',
            'tanggal_approved' => 'datetime',
        ];
    }

    /**
     * Relasi ke model PesertaDidik.
     */
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    /**
     * Relasi ke model PerhitunganTopsis.
     */
    public function perhitunganTopsis()
    {
        return $this->hasMany(PerhitunganTopsis::class, 'penilaian_id', 'penilaian_id');
    }

    /**
     * Mengkonversi nilai Minat ke bobot numerik sesuai Excel.
     */
    public function convertMinatToNumeric(string $minatValue): int
    {
        $mapping = [
            // MA: Minat Bidang Kreatif
            'Desain Grafis' => 4,
            'Seni & Kerajinan' => 4,
            'Musik & Teater' => 4,
            'Fotografi & Videografi' => 4,
            // MB: Minat Bidang Teknologi
            'Komputer' => 6,
            'Teknologi informasi & Komunikasi' => 6,
            'Elektronik' => 2,
            'Mesin' => 2,
            // MC: Minat Bidang Ilmiah
            'Fisika' => 4,
            'Kimia' => 4,
            'Biologi & Lingkungan' => 4,
            // MD: Minat Bidang Bisnis
            'Pemasaran' => 2,
            'Bisnis & Enterpreneurship' => 2,
        ];
        return $mapping[$minatValue] ?? 1;
    }

    /**
     * Mengkonversi nilai Bakat (Keahlian) ke bobot numerik sesuai Excel.
     */
    public function convertKeahlianToNumeric(string $keahlianValue): int
    {
        $mapping = [
            'menganalisa' => 7,
            'memecahkan masalah' => 7,
            'Menggunakan Perangkat Lunak & Komputer' => 7,
            'perangkat lunak' => 7,
            'Mengembangkan Rencana & Strategi' => 6,
            'kelistrikan' => 6,
        ];
        return $mapping[$keahlianValue] ?? 1;
    }

    /**
     * Mengkonversi biaya gelombang ke bobot numerik sesuai 4 pilihan di Excel.
     */
    public function convertBiayaGelombangToNumeric(string $biayaValue): int
    {
        if (str_contains($biayaValue, '1.000.000')) return 4;
        if (str_contains($biayaValue, '1.500.000')) return 3;
        if (str_contains($biayaValue, '2.000.000')) return 2;
        if (str_contains($biayaValue, '2.500.000')) return 1;
        return 1;
    }

    /**
     * Memeriksa apakah semua field yang dibutuhkan untuk perhitungan sudah terisi.
     */
    public function isReadyForCalculation(): bool
    {
        return empty($this->getMissingFields());
    }

    /**
     * Mengembalikan daftar nama field yang masih kosong.
     */
    public function getMissingFields(): array
    {
        $missing = [];
        $requiredFields = [
            'nilai_ipa',
            'nilai_ips',
            'nilai_matematika',
            'nilai_bahasa_indonesia',
            'nilai_bahasa_inggris',
            'nilai_pkn',
            'minat_a',
            'minat_b',
            'minat_c',
            'minat_d',
            'keahlian',
            'biaya_gelombang'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                $missing[] = ucwords(str_replace('_', ' ', $field));
            }
        }
        return $missing;
    }

    /**
     * Scope untuk query data penilaian yang siap untuk dihitung.
     */
    public function scopeReadyForCalculation($query)
    {
        return $query->whereNotNull('nilai_ipa')
            ->whereNotNull('nilai_ips')
            ->whereNotNull('nilai_matematika')
            ->whereNotNull('nilai_bahasa_indonesia')
            ->whereNotNull('nilai_bahasa_inggris')
            ->whereNotNull('nilai_pkn')
            ->whereNotNull('minat_a')
            ->whereNotNull('minat_b')
            ->whereNotNull('minat_c')
            ->whereNotNull('minat_d')
            ->whereNotNull('keahlian')
            ->whereNotNull('biaya_gelombang');
    }
    public function markAsUncalculated(): bool
    {
        return $this->update(['sudah_dihitung' => false]);
    }


    /**
     * Scope untuk query data penilaian yang belum dihitung.
     */
    public function scopeUncalculated($query)
    {
        return $query->where('sudah_dihitung', false);
    }

    public function getRataRataNilaiAkademikAttribute(): float
    {
        $total = (float)$this->nilai_ipa +
            (float)$this->nilai_ips +
            (float)$this->nilai_matematika +
            (float)$this->nilai_bahasa_indonesia +
            (float)$this->nilai_bahasa_inggris +
            (float)$this->nilai_pkn;

        // Menghindari pembagian dengan nol jika tidak ada nilai
        return $total > 0 ? round($total / 6, 2) : 0;
    }
}
