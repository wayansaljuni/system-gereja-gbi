<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dpr extends Model
{
    protected $table = 'dpr';

    // Sesuaikan kalau tabel dpr ternyata punya kolom created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'nota', 'kd_brg', 'nama', 'qty', 'harga', 'sat', 'ket', 'ket1', 'ket2',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'harga' => 'decimal:2',
    ];

    /**
     * Relasi balik ke header PR (tabel hpr) lewat kolom nota.
     */
    public function hpr(): BelongsTo
    {
        return $this->belongsTo(Hpr::class, 'nota', 'nota');
    }
}