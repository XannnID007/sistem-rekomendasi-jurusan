<?php
// app/Models/Laporan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            'parameter' => 'array', // This will automatically handle JSON conversion
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
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
        return $this->file_path && Storage::exists($this->file_path);
    }

    /**
     * Get file URL
     */
    public function getFileUrlAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }

        return Storage::url($this->file_path);
    }

    /**
     * Get parameter safely
     */
    public function getParameterAttribute($value)
    {
        if (is_string($value)) {
            return json_decode($value, true) ?? [];
        }

        return $value ?? [];
    }

    /**
     * Set parameter safely
     */
    public function setParameterAttribute($value)
    {
        $this->attributes['parameter'] = is_array($value) ? json_encode($value) : $value;
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

    /**
     * Get formatted file size
     */
    public function getFileSizeAttribute()
    {
        if (!$this->file_path || !Storage::exists($this->file_path)) {
            return null;
        }

        $bytes = Storage::size($this->file_path);
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
