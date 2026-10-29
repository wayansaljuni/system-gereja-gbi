<?php

namespace App\Models;

use App\Models\AbsensiDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'ibadah_id',
        'tanggal',
        'jam',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function ibadah(): BelongsTo
    {
        return $this->belongsTo(Ibadah::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            AbsensiDetail::class,
            'absensi_id'
        );
    }    //
}
