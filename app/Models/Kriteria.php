<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $table = 'kriteria';
    protected $primaryKey = 'kriteria_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_kriteria',
        'nama_kriteria',
        'jenis_kriteria',
        'bobot',
        'keterangan',
        'is_active'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bobot' => 'decimal:4',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope to get only active criteria
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get criteria by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_kriteria', $type);
    }

    /**
     * Check if criteria is benefit type
     */
    public function isBenefit(): bool
    {
        return $this->jenis_kriteria === 'benefit';
    }

    /**
     * Check if criteria is cost type
     */
    public function isCost(): bool
    {
        return $this->jenis_kriteria === 'cost';
    }

    /**
     * Get formatted weight percentage
     */
    public function getBobotPersenAttribute(): string
    {
        return number_format($this->bobot * 100, 2) . '%';
    }

    /**
     * Get criteria type in Indonesian
     */
    public function getJenisKriteriaIndonesiaAttribute(): string
    {
        return $this->jenis_kriteria === 'benefit' ? 'Keuntungan' : 'Biaya';
    }
}
