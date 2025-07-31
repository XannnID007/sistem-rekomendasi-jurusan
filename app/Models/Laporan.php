<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul_laporan',
        'jenis_laporan',
        'tahun_ajaran',
        'dibuat_oleh',
        'file_path',
        'parameter'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'parameter' => 'array',
        ];
    }

    /**
     * Get the user that created the laporan.
     */
    public function pembuatLaporan()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh', 'user_id');
    }

    /**
     * Get report type in Indonesian
     */
    public function getJenisLaporanIndonesiaAttribute(): string
    {
        $types = [
            'individual' => 'Laporan Individual',
            'ringkasan' => 'Laporan Ringkasan',
            'perbandingan' => 'Laporan Perbandingan'
        ];

        return $types[$this->jenis_laporan] ?? 'Laporan Umum';
    }

    /**
     * Check if file exists
     */
    public function fileExists(): bool
    {
        return $this->file_path && file_exists(storage_path('app/' . $this->file_path));
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): string
    {
        return $this->file_path ? asset('storage/' . str_replace('public/', '', $this->file_path)) : '';
    }

    /**
     * Scope to get reports by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_laporan', $type);
    }

    /**
     * Scope to get reports by academic year
     */
    public function scopeByTahunAjaran($query, $tahunAjaran)
    {
        return $query->where('tahun_ajaran', $tahunAjaran);
    }

    /**
     * Scope to get reports by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('dibuat_oleh', $userId);
    }
}
