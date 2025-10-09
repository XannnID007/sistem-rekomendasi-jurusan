<?php
// app/Models/PenilaianPesertaDidik.php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'biaya_gelombang',
        'sudah_dihitung',
        'status_submission',
        'tanggal_submission',
        'tanggal_approved',
        'alasan_penolakan',
        'jurusan_dipilih',
    ];

    protected function casts(): array
    {
        return [
            'sudah_dihitung' => 'boolean',
            'tanggal_submission' => 'datetime',
            'tanggal_approved' => 'datetime',
        ];
    }

    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    public function convertNilaiToBobot($nilai): int
    {
        $nilai = (float) $nilai;
        if ($nilai > 90) return 4;
        if ($nilai >= 81) return 3;
        if ($nilai >= 76) return 2;
        return 1;
    }

    public function convertMinatToNumeric(string $minatValue): int
    {
        $mapping = [
            'Desain Grafis' => 4,
            'Seni & Kerajinan' => 4,
            'Musik & Teater' => 4,
            'Fotografi & Videografi' => 4,
            'Komputer' => 6,
            'Teknologi informasi & Komunikasi' => 6,
            'Elektronik' => 2,
            'Mesin' => 2,
            'Fisika' => 4,
            'Kimia' => 4,
            'Biologi & Lingkungan' => 4,
            'Pemasaran' => 2,
            'Bisnis & Enterpreneurship' => 2,
        ];
        return $mapping[trim($minatValue)] ?? 1;
    }

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
        return $mapping[trim($keahlianValue)] ?? 1;
    }

    public function convertBiayaGelombangToNumeric(string $biayaValue): int
    {
        if (str_contains($biayaValue, '1.000.000') || str_contains($biayaValue, 'G1')) return 4;
        if (str_contains($biayaValue, '1.500.000') || str_contains($biayaValue, 'G2')) return 3;
        if (str_contains($biayaValue, '2.000.000') || str_contains($biayaValue, 'G3')) return 2;
        if (str_contains($biayaValue, '2.500.000') || str_contains($biayaValue, 'G4')) return 1;
        return 1;
    }

    // === HELPER METHODS ===

    public function isReadyForCalculation(): bool
    {
        return empty($this->getMissingFields());
    }

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

    public function scopeUncalculated($query)
    {
        return $query->where('sudah_dihitung', false);
    }

    public function getNilaiAkademikAttribute(): array
    {
        return [
            'n1' => (float)$this->nilai_ipa,
            'n2' => (float)$this->nilai_ips,
            'n3' => (float)$this->nilai_bahasa_inggris,
            'n4' => (float)$this->nilai_matematika,
            'n5' => (float)$this->nilai_bahasa_indonesia,
            'n6' => (float)$this->nilai_pkn,
        ];
    }

    public function getRataRataNilaiAkademikAttribute(): float
    {
        $total = (float)$this->nilai_ipa +
            (float)$this->nilai_ips +
            (float)$this->nilai_matematika +
            (float)$this->nilai_bahasa_indonesia +
            (float)$this->nilai_bahasa_inggris +
            (float)$this->nilai_pkn;

        return $total > 0 ? round($total / 6, 2) : 0;
    }
}
