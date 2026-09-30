<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dpo extends Model
{
    protected $connection = 'mysql55';
    protected $primaryKey = 'iddpo';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $table = 'dpo';
    // Sesuaikan kalau tabel dpr ternyata punya kolom created_at/updated_at.
    public $timestamps = false;

    protected $fillable = [
        'nota', 'kd_brg', 'nama', 'qty', 'harga', 'sat', 'ket', 'ket1', 'ket2',
    ];

    protected $casts = [
        'qty' => 'decimal:3',
        'harga' => 'decimal:3',
    ];

    /**
     * Relasi balik ke header PR (tabel hpr) lewat kolom nota.
     */
    public function hpo(): BelongsTo
    {
        return $this->belongsTo(Hpo::class, 'nota', 'nota');
    }    //
}
