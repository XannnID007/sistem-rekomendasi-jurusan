<?php
// app/Models/PerhitunganTopsis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PerhitunganTopsis extends Model
{
    use HasFactory;

    protected $table = 'perhitungan_topsis';
    protected $primaryKey = 'perhitungan_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'peserta_didik_id',
        'penilaian_id',
        'tahun_ajaran',
        'normalized_n1',
        'normalized_n2',
        'normalized_n3',
        'normalized_n4',
        'normalized_n5',
        'normalized_n6',
        'normalized_ma',
        'normalized_mb',
        'normalized_mc',
        'normalized_md',
        'normalized_bb',
        'normalized_bp',
        'weighted_n1',
        'weighted_n2',
        'weighted_n3',
        'weighted_n4',
        'weighted_n5',
        'weighted_n6',
        'weighted_ma',
        'weighted_mb',
        'weighted_mc',
        'weighted_md',
        'weighted_bb',
        'weighted_bp',
        'jarak_positif',
        'jarak_negatif',
        'nilai_preferensi',
        'jurusan_rekomendasi',
        'tanggal_perhitungan'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'normalized_n1' => 'decimal:8',
            'normalized_n2' => 'decimal:8',
            'normalized_n3' => 'decimal:8',
            'normalized_n4' => 'decimal:8',
            'normalized_n5' => 'decimal:8',
            'normalized_n6' => 'decimal:8',
            'normalized_ma' => 'decimal:8',
            'normalized_mb' => 'decimal:8',
            'normalized_mc' => 'decimal:8',
            'normalized_md' => 'decimal:8',
            'normalized_bb' => 'decimal:8',
            'normalized_bp' => 'decimal:8',
            'weighted_n1' => 'decimal:8',
            'weighted_n2' => 'decimal:8',
            'weighted_n3' => 'decimal:8',
            'weighted_n4' => 'decimal:8',
            'weighted_n5' => 'decimal:8',
            'weighted_n6' => 'decimal:8',
            'weighted_ma' => 'decimal:8',
            'weighted_mb' => 'decimal:8',
            'weighted_mc' => 'decimal:8',
            'weighted_md' => 'decimal:8',
            'weighted_bb' => 'decimal:8',
            'weighted_bp' => 'decimal:8',
            'jarak_positif' => 'decimal:8',
            'jarak_negatif' => 'decimal:8',
            'nilai_preferensi' => 'decimal:8',
            'tanggal_perhitungan' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the peserta didik that owns the perhitungan.
     */
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id', 'peserta_didik_id');
    }

    /**
     * Get the penilaian that owns the perhitungan.
     */
    public function penilaian()
    {
        return $this->belongsTo(PenilaianPesertaDidik::class, 'penilaian_id', 'penilaian_id');
    }

    /**
     * Get tanggal perhitungan with safe formatting
     */
    public function getTanggalPerhitunganFormatted()
    {
        if (!$this->tanggal_perhitungan) {
            return null;
        }
        
        try {
            if ($this->tanggal_perhitungan instanceof Carbon) {
                return $this->tanggal_perhitungan;
            }
            
            return Carbon::parse($this->tanggal_perhitungan);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get normalized values as array
     */
    public function getNormalizedValuesAttribute(): array
    {
        return [
            'n1' => $this->normalized_n1,
            'n2' => $this->normalized_n2,
            'n3' => $this->normalized_n3,
            'n4' => $this->normalized_n4,
            'n5' => $this->normalized_n5,
            'n6' => $this->normalized_n6,
            'ma' => $this->normalized_ma,
            'mb' => $this->normalized_mb,
            'mc' => $this->normalized_mc,
            'md' => $this->normalized_md,
            'bb' => $this->normalized_bb,
            'bp' => $this->normalized_bp,
        ];
    }

    /**
     * Get weighted normalized values as array
     */
    public function getWeightedValuesAttribute(): array
    {
        return [
            'n1' => $this->weighted_n1,
            'n2' => $this->weighted_n2,
            'n3' => $this->weighted_n3,
            'n4' => $this->weighted_n4,
            'n5' => $this->weighted_n5,
            'n6' => $this->weighted_n6,
            'ma' => $this->weighted_ma,
            'mb' => $this->weighted_mb,
            'mc' => $this->weighted_mc,
            'md' => $this->weighted_md,
            'bb' => $this->weighted_bb,
            'bp' => $this->weighted_bp,
        ];
    }

    /**
     * Get preference score as percentage
     */
    public function getNilaiPreferensiPersenAttribute(): string
    {
        return number_format($this->nilai_preferensi * 100, 2) . '%';
    }

    /**
     * Get recommendation with description
     */
    public function getRekomendasiLengkapAttribute(): string
    {
        return $this->jurusan_rekomendasi === 'TKJ'
            ? 'TKJ (Teknik Komputer dan Jaringan)'
            : 'TKR (Teknik Kendaraan Ringan)';
    }

    /**
     * Get status color for recommendation
     */
    public function getStatusColorAttribute(): string
    {
        return $this->jurusan_rekomendasi === 'TKJ' ? 'blue' : 'green';
    }

    /**
     * Scope to get calculations by recommendation
     */
    public function scopeByRecommendation($query, $recommendation)
    {
        return $query->where('jurusan_rekomendasi', $recommendation);
    }

    /**
     * Scope to get calculations by academic year
     */
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }
}