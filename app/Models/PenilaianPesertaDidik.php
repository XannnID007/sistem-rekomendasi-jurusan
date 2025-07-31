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
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'peserta_didik_id',
        'tahun_ajaran',
        'nilai_ipa',
        'nilai_ips',
        'nilai_matematika',
        'nilai_bahasa_indonesia',
        'nilai_bahasa_inggris',
        'nilai_produktif',
        'minat_a',
        'minat_b',
        'minat_c',
        'minat_d',
        'keahlian',
        'penghasilan_ortu',
        'sudah_dihitung'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai_ipa' => 'decimal:2',
            'nilai_ips' => 'decimal:2',
            'nilai_matematika' => 'decimal:2',
            'nilai_bahasa_indonesia' => 'decimal:2',
            'nilai_bahasa_inggris' => 'decimal:2',
            'nilai_produktif' => 'decimal:2',
            'sudah_dihitung' => 'boolean',
        ];
    }

    /**
     * Get the peserta didik that owns the penilaian.
     */
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    /**
     * Get the perhitungan TOPSIS for the penilaian.
     */
    public function perhitunganTopsis()
    {
        return $this->hasMany(PerhitunganTopsis::class, 'penilaian_id', 'penilaian_id');
    }

    /**
     * Get all academic grades as array
     */
    public function getNilaiAkademikAttribute(): array
    {
        return [
            'n1' => $this->nilai_ipa,
            'n2' => $this->nilai_ips,
            'n3' => $this->nilai_matematika,
            'n4' => $this->nilai_bahasa_indonesia,
            'n5' => $this->nilai_bahasa_inggris,
            'n6' => $this->nilai_produktif,
        ];
    }

    /**
     * Get all interests as array
     */
    public function getMinatAttribute(): array
    {
        return [
            'ma' => $this->minat_a,
            'mb' => $this->minat_b,
            'mc' => $this->minat_c,
            'md' => $this->minat_d,
        ];
    }

    /**
     * Get average academic score
     */
    public function getRataNilaiAkademikAttribute(): float
    {
        $total = $this->nilai_ipa + $this->nilai_ips + $this->nilai_matematika +
            $this->nilai_bahasa_indonesia + $this->nilai_bahasa_inggris + $this->nilai_produktif;
        return round($total / 6, 2);
    }

    /**
     * Convert minat to numeric value for TOPSIS calculation
     */
    public function convertMinatToNumeric(string $minat): int
    {
        // Mapping minat to numeric values based on relevance to TKJ/TKR
        $minatMapping = [
            // High relevance to TKJ (6-7)
            'Teknologi informasi & Komunikasi' => 6,
            'Komputer' => 6,
            'Desain Grafis' => 6,
            'Fotografi & Videografi' => 6,

            // Medium-High relevance (4-5)
            'Elektronik' => 4,
            'Fisika' => 4,
            'Kimia' => 4,

            // Medium relevance (3)
            'Biologi & Lingkungan' => 3,
            'Mesin' => 3,
            'Seni & Kerajinan' => 3,

            // Low relevance (2)
            'Musik & Teater' => 2,
            'Bisnis & Enterpreneurship' => 2,
            'Pemasaran' => 2,

            // Default
            'default' => 2
        ];

        return $minatMapping[$minat] ?? $minatMapping['default'];
    }

    /**
     * Convert keahlian to numeric value for TOPSIS calculation
     */
    public function convertKeahlianToNumeric(string $keahlian): int
    {
        $keahlianMapping = [
            // High relevance to TKJ (6-7)
            'perangkat lunak' => 7,
            'menganalisa' => 7,
            'Menggunakan Perangkat Lunak & Komputer' => 7,
            'memecahkan masalah' => 6,

            // Medium relevance (4-5)
            'kelistrikan' => 4,

            // Low relevance (2-3)
            'Mengembangkan Rencana & Strategi' => 2,

            // Default
            'default' => 3
        ];

        return $keahlianMapping[$keahlian] ?? $keahlianMapping['default'];
    }

    /**
     * Convert penghasilan to numeric value for TOPSIS calculation
     */
    public function convertPenghasilanToNumeric(string $penghasilan): int
    {
        if (str_contains($penghasilan, 'G1')) return 5;
        if (str_contains($penghasilan, 'G2')) return 4;
        if (str_contains($penghasilan, 'G3')) return 2;

        return 3; // default
    }
}
