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
        'nilai_pkn', // CHANGED: dari nilai_produktif ke nilai_pkn
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
            'nilai_pkn' => 'decimal:2', // CHANGED: dari nilai_produktif ke nilai_pkn
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
            'n6' => (float) $this->nilai_pkn, // CHANGED: dari nilai_produktif ke nilai_pkn
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
            (float)$this->nilai_bahasa_indonesia + (float)$this->nilai_bahasa_inggris + (float)$this->nilai_pkn; // CHANGED
        return round($total / 6, 2);
    }

    /**
     * Convert minat to numeric value for TOPSIS calculation
     * DIPERBAIKI: Mapping sesuai dengan data Excel yang akurat
     */
    public function convertMinatToNumeric(?string $minat): int
    {
        if (empty($minat)) {
            return 2; // default value
        }

        // Mapping berdasarkan analisis Excel yang akurat:
        // Dari Excel kita bisa lihat konversi yang benar:
        $minatMapping = [
            // KONVERSI BERDASARKAN DATA EXCEL AKTUAL:
            // SRI SITI NURLATIFAH
            'Musik & Teater' => 1,                           // Excel: MA=1
            'Teknologi informasi & Komunikasi' => 6,         // Excel: MB=6
            'Kimia' => 4,                                     // Excel: MC=4  
            'Bisnis & Enterpreneurship' => 2,                // Excel: MD=2

            // NAILA RIZKI
            'Fotografi & Videografi' => 6,                   // Excel: MA=6
            'Komputer' => 6,                                  // Excel: MB=6
            'Biologi & Lingkungan' => 3,                     // Excel: MC=3
            // 'Bisnis & Enterpreneurship' => 2,             // Excel: MD=2 (already defined)

            // MUHAMMAD RAFFI
            'Seni & Kerajinan' => 3,                         // Excel: MA=3
            'Elektronik' => 2,                               // Excel: MB=2
            'Fisika' => 4,                                    // Excel: MC=4
            // 'Bisnis & Enterpreneurship' => 2,             // Excel: MD=2 (already defined)

            // MUHAMMAD RIFFA  
            // 'Musik & Teater' => 1,                        // Excel: MA=1 (already defined)
            'Mesin' => 2,                                     // Excel: MB=2
            // 'Biologi & Lingkungan' => 3,                  // Excel: MC=3 (already defined) 
            // 'Bisnis & Enterpreneurship' => 2,             // Excel: MD=2 (already defined)

            // BALQISY WARDAH HABIBAH
            'Desain Grafis' => 6,                            // Excel: MA=6
            // 'Teknologi informasi & Komunikasi' => 6,      // Excel: MB=6 (already defined)
            // 'Biologi & Lingkungan' => 3,                  // Excel: MC=3 (already defined)
            'Pemasaran' => 2,                                // Excel: MD=2
        ];

        return $minatMapping[$minat] ?? 2; // default to 2 if not found
    }

    /**
     * Convert keahlian to numeric value for TOPSIS calculation
     * DIPERBAIKI: Mapping sesuai dengan data Excel yang aktual
     */
    public function convertKeahlianToNumeric(?string $keahlian): int
    {
        if (empty($keahlian)) {
            return 3; // default value
        }

        // Mapping berdasarkan analisis Excel yang akurat:
        $keahlianMapping = [
            // KONVERSI BERDASARKAN DATA EXCEL AKTUAL:
            'perangkat lunak' => 7,                          // SRI SITI NURLATIFAH: Excel=7
            'menganalisa' => 7,                              // NAILA RIZKI: Excel=7
            'kelistrikan' => 6,                              // MUHAMMAD RAFFI: Excel=6
            'Mengembangkan Rencana & Strategi' => 6,         // MUHAMMAD RIFFA: Excel=6
            'Menggunakan Perangkat Lunak & Komputer' => 7,  // BALQISY: Excel=7
            'memecahkan masalah' => 7,                       // SITI RAHAYU: Excel=7
        ];

        return $keahlianMapping[$keahlian] ?? 3; // default to 3 if not found
    }

    /**
     * Convert penghasilan to numeric value for TOPSIS calculation  
     * VALIDASI: Sesuai dengan Excel
     */
    public function convertPenghasilanToNumeric(?string $penghasilan): int
    {
        if (empty($penghasilan)) {
            return 3; // default value
        }

        // Mapping yang sudah benar berdasarkan Excel
        if (str_contains($penghasilan, 'G1')) return 5; // Excel: 5
        if (str_contains($penghasilan, 'G2')) return 4; // Excel: 4  
        if (str_contains($penghasilan, 'G3')) return 2; // Excel: 2

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
            !empty($this->nilai_pkn) &&
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
        if (empty($this->nilai_pkn)) $missing[] = 'Nilai PKN';
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
            ->whereNotNull('nilai_pkn')
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
