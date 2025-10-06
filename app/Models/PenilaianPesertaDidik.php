<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianPesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'penilaian_peserta_didik';
    protected $primaryKey = 'penilaian_id';

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
        'biaya_gelombang', // CHANGED dari penghasilan_ortu
        'sudah_dihitung'
    ];

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
        ];
    }

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    public function perhitunganTopsis()
    {
        return $this->hasMany(PerhitunganTopsis::class, 'penilaian_id', 'penilaian_id');
    }

    public function getNilaiAkademikAttribute(): array
    {
        return [
            'n1' => (float) $this->nilai_ipa,
            'n2' => (float) $this->nilai_ips,
            'n3' => (float) $this->nilai_bahasa_inggris, // SESUAI EXCEL
            'n4' => (float) $this->nilai_matematika,
            'n5' => (float) $this->nilai_bahasa_indonesia,
            'n6' => (float) $this->nilai_pkn,
        ];
    }

    public function getMinatAttribute(): array
    {
        return [
            'ma' => $this->minat_a ?? '',
            'mb' => $this->minat_b ?? '',
            'mc' => $this->minat_c ?? '',
            'md' => $this->minat_d ?? '',
        ];
    }

    public function getRataNilaiAkademikAttribute(): float
    {
        $total = (float)$this->nilai_ipa + (float)$this->nilai_ips + (float)$this->nilai_matematika +
            (float)$this->nilai_bahasa_indonesia + (float)$this->nilai_bahasa_inggris + (float)$this->nilai_pkn;
        return round($total / 6, 2);
    }

    /**
     * Convert minat to numeric value SESUAI EXCEL
     * SEMUA MINAT = BENEFIT (semakin tinggi semakin baik)
     */
    public function convertMinatToNumeric(?string $minat): int
    {
        if (empty($minat)) {
            return 2; // default neutral
        }

        // Mapping SESUAI EXCEL - SEMUA minat adalah benefit
        $minatMapping = [
            // Minat A - Kreatif (MA)
            'Musik & Teater' => 4,
            'Fotografi & Videografi' => 4,
            'Seni & Kerajinan' => 4,
            'Desain Grafis' => 4,

            // Minat B - Teknologi (MB) - PALING PENTING!
            'Teknologi informasi & Komunikasi' => 6,
            'Komputer' => 6,
            'Elektronik' => 2,
            'Mesin' => 2,

            // Minat C - Ilmiah (MC)
            'Kimia' => 4,
            'Biologi & Lingkungan' => 4,
            'Fisika' => 4,

            // Minat D - Bisnis (MD)
            'Bisnis & Enterpreneurship' => 2,
            'Pemasaran' => 2,
        ];

        return $minatMapping[$minat] ?? 2;
    }

    /**
     * Convert keahlian to numeric value SESUAI EXCEL
     * BB = BENEFIT (semakin tinggi semakin baik)
     */
    public function convertKeahlianToNumeric(?string $keahlian): int
    {
        if (empty($keahlian)) {
            return 4;
        }

        $keahlianMapping = [
            // Keahlian yang sangat relevan untuk TKJ
            'perangkat lunak' => 7,
            'Menggunakan Perangkat Lunak & Komputer' => 7,
            'menganalisa' => 7,

            // Keahlian yang relevan untuk TKR
            'kelistrikan' => 6,

            // Keahlian umum
            'Mengembangkan Rencana & Strategi' => 6,
            'memecahkan masalah' => 7,

            // Default
            'komunikasi' => 5,
            'kerja sama tim' => 5,
        ];

        foreach ($keahlianMapping as $key => $value) {
            if (stripos($keahlian, $key) !== false) {
                return $value;
            }
        }

        return 4;
    }

    /**
     * Convert biaya gelombang to numeric value
     * BP = COST (semakin rendah semakin baik)
     * Jadi nilai yang lebih tinggi = biaya lebih mahal = lebih tidak diinginkan
     */
    public function convertBiayaGelombangToNumeric(?string $biaya): int
    {
        if (empty($biaya)) {
            return 2; // default middle
        }

        // Mapping SESUAI EXCEL
        // G1 = 1 juta (paling murah) = nilai 4 (rendah)
        // G2 = 1.5 juta (menengah) = nilai 3 (menengah)
        // G3 = 2 juta (paling mahal) = nilai 2 (tinggi/lebih mahal)
        $biayaMapping = [
            'G1' => 4, // Paling murah - nilai rendah karena COST
            'G2' => 3, // Menengah
            'G3' => 2, // Paling mahal - nilai tinggi karena COST
        ];

        foreach ($biayaMapping as $code => $value) {
            if (stripos($biaya, $code) !== false) {
                return $value;
            }
        }

        return 2; // default
    }

    /**
     * BACKWARD COMPATIBILITY - alias untuk method lama
     */
    public function convertPenghasilanToNumeric(?string $penghasilan): int
    {
        return $this->convertBiayaGelombangToNumeric($penghasilan);
    }

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
            !empty($this->biaya_gelombang);
    }

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
        if (empty($this->biaya_gelombang)) $missing[] = 'Biaya Gelombang';

        return $missing;
    }

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

    public function scopeUncalculated($query)
    {
        return $query->where('sudah_dihitung', false);
    }

    public function markAsCalculated(): bool
    {
        return $this->update(['sudah_dihitung' => true]);
    }

    public function markAsUncalculated(): bool
    {
        return $this->update(['sudah_dihitung' => false]);
    }

    public function getDebugInfo(): array
    {
        return [
            'penilaian_id' => $this->penilaian_id,
            'peserta_didik' => $this->pesertaDidik->nama_lengkap ?? 'Unknown',
            'nilai_akademik' => $this->nilai_akademik,
            'minat_converted' => [
                'ma' => $this->convertMinatToNumeric($this->minat_a),
                'mb' => $this->convertMinatToNumeric($this->minat_b),
                'mc' => $this->convertMinatToNumeric($this->minat_c),
                'md' => $this->convertMinatToNumeric($this->minat_d),
            ],
            'keahlian_converted' => $this->convertKeahlianToNumeric($this->keahlian),
            'biaya_gelombang_converted' => $this->convertBiayaGelombangToNumeric($this->biaya_gelombang),
            'is_ready' => $this->isReadyForCalculation(),
            'missing_fields' => $this->getMissingFields(),
        ];
    }
}
