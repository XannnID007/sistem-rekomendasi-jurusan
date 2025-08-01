<?php
// app/Models/PenilaianPesertaDidik.php

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
            'n1' => (float) $this->nilai_ipa,
            'n2' => (float) $this->nilai_ips,
            'n3' => (float) $this->nilai_matematika,
            'n4' => (float) $this->nilai_bahasa_indonesia,
            'n5' => (float) $this->nilai_bahasa_inggris,
            'n6' => (float) $this->nilai_produktif,
        ];
    }

    /**
     * Get all interests as array
     */
    public function getMinatAttribute(): array
    {
        return [
            'ma' => $this->minat_a ?? '',
            'mb' => $this->minat_b ?? '',
            'mc' => $this->minat_c ?? '',
            'md' => $this->minat_d ?? '',
        ];
    }

    /**
     * Get average academic score
     */
    public function getRataNilaiAkademikAttribute(): float
    {
        $total = (float)$this->nilai_ipa + (float)$this->nilai_ips + (float)$this->nilai_matematika +
            (float)$this->nilai_bahasa_indonesia + (float)$this->nilai_bahasa_inggris + (float)$this->nilai_produktif;
        return round($total / 6, 2);
    }

    /**
     * Convert minat to numeric value for TOPSIS calculation
     */
    public function convertMinatToNumeric(?string $minat): int
    {
        if (empty($minat)) {
            return 2; // default value
        }

        // Mapping minat to numeric values based on relevance to TKJ/TKR
        $minatMapping = [
            // High relevance to TKJ (6-7)
            'Teknologi informasi & Komunikasi' => 7,
            'Komputer' => 7,
            'Desain Grafis' => 6,
            'Fotografi & Videografi' => 6,

            // Medium-High relevance (4-5)
            'Elektronik' => 5,
            'Fisika' => 4,
            'Kimia' => 4,

            // Medium relevance (3)
            'Biologi & Lingkungan' => 3,
            'Mesin' => 4, // More relevant for TKR
            'Seni & Kerajinan' => 3,

            // Low relevance (2)
            'Musik & Teater' => 2,
            'Bisnis & Enterpreneurship' => 2,
            'Pemasaran' => 2,
        ];

        return $minatMapping[$minat] ?? 2; // default to 2 if not found
    }

    /**
     * Convert keahlian to numeric value for TOPSIS calculation
     */
    public function convertKeahlianToNumeric(?string $keahlian): int
    {
        if (empty($keahlian)) {
            return 3; // default value
        }

        $keahlianMapping = [
            // High relevance to TKJ (6-7)
            'perangkat lunak' => 7,
            'menganalisa' => 7,
            'Menggunakan Perangkat Lunak & Komputer' => 7,
            'memecahkan masalah' => 6,

            // Medium relevance for TKR (4-5)
            'kelistrikan' => 5,

            // General skills (2-3)
            'Mengembangkan Rencana & Strategi' => 3,
        ];

        return $keahlianMapping[$keahlian] ?? 3; // default to 3 if not found
    }

    /**
     * Convert penghasilan to numeric value for TOPSIS calculation
     */
    public function convertPenghasilanToNumeric(?string $penghasilan): int
    {
        if (empty($penghasilan)) {
            return 3; // default value
        }

        // Higher score for lower income (cost criteria, but treated as benefit for accessibility)
        if (str_contains($penghasilan, 'G1')) return 5; // Lowest income, highest priority
        if (str_contains($penghasilan, 'G2')) return 4; // Medium income
        if (str_contains($penghasilan, 'G3')) return 2; // Highest income, lowest priority

        return 3; // default
    }

    /**
     * Check if all required data is available for TOPSIS calculation
     */
    public function isReadyForCalculation(): bool
    {
        return !empty($this->nilai_ipa) &&
            !empty($this->nilai_ips) &&
            !empty($this->nilai_matematika) &&
            !empty($this->nilai_bahasa_indonesia) &&
            !empty($this->nilai_bahasa_inggris) &&
            !empty($this->nilai_produktif) &&
            !empty($this->minat_a) &&
            !empty($this->minat_b) &&
            !empty($this->minat_c) &&
            !empty($this->minat_d) &&
            !empty($this->keahlian) &&
            !empty($this->penghasilan_ortu);
    }

    /**
     * Get missing data fields
     */
    public function getMissingFields(): array
    {
        $missing = [];

        if (empty($this->nilai_ipa)) $missing[] = 'Nilai IPA';
        if (empty($this->nilai_ips)) $missing[] = 'Nilai IPS';
        if (empty($this->nilai_matematika)) $missing[] = 'Nilai Matematika';
        if (empty($this->nilai_bahasa_indonesia)) $missing[] = 'Nilai Bahasa Indonesia';
        if (empty($this->nilai_bahasa_inggris)) $missing[] = 'Nilai Bahasa Inggris';
        if (empty($this->nilai_produktif)) $missing[] = 'Nilai Produktif';
        if (empty($this->minat_a)) $missing[] = 'Minat A';
        if (empty($this->minat_b)) $missing[] = 'Minat B';
        if (empty($this->minat_c)) $missing[] = 'Minat C';
        if (empty($this->minat_d)) $missing[] = 'Minat D';
        if (empty($this->keahlian)) $missing[] = 'Keahlian';
        if (empty($this->penghasilan_ortu)) $missing[] = 'Penghasilan Orang Tua';

        return $missing;
    }

    /**
     * Scope for assessments ready for calculation
     */
    public function scopeReadyForCalculation($query)
    {
        return $query->whereNotNull('nilai_ipa')
            ->whereNotNull('nilai_ips')
            ->whereNotNull('nilai_matematika')
            ->whereNotNull('nilai_bahasa_indonesia')
            ->whereNotNull('nilai_bahasa_inggris')
            ->whereNotNull('nilai_produktif')
            ->whereNotNull('minat_a')
            ->whereNotNull('minat_b')
            ->whereNotNull('minat_c')
            ->whereNotNull('minat_d')
            ->whereNotNull('keahlian')
            ->whereNotNull('penghasilan_ortu');
    }

    /**
     * Scope for uncalculated assessments
     */
    public function scopeUncalculated($query)
    {
        return $query->where('sudah_dihitung', false);
    }

    /**
     * Mark as calculated
     */
    public function markAsCalculated(): bool
    {
        return $this->update(['sudah_dihitung' => true]);
    }

    /**
     * Mark as uncalculated
     */
    public function markAsUncalculated(): bool
    {
        return $this->update(['sudah_dihitung' => false]);
    }
}
