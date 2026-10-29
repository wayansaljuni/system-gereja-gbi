<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbsensiDetail extends Model
{
    protected $table = 'absensi_detail';

    protected $fillable = [
        'absensi_id',
        'jemaat_id',
        'status',
        'jam_hadir',
        'keterangan',
    ];

    public function absensi(): BelongsTo
    {
        return $this->belongsTo(
            Absensi::class,
            'absensi_id'
        );
    }

    public function jemaat(): BelongsTo
    {
        return $this->belongsTo(
            Jemaat::class,
            'jemaat_id'
        );
    }    //
}
