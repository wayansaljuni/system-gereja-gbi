<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferAkun extends Model
{
    protected $table = 'transfer_akun';

    protected $fillable = [
        'tanggal',
        'ibadah_id',
        'akun_asal_id',
        'akun_tujuan_id',
        'jumlah',
        'no_referensi',
        'keterangan',
        'approve',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
            'jumlah' => 'decimal:2',
            'approve' => 'boolean',
        ];
    }

    public function ibadah(): BelongsTo
    {
        return $this->belongsTo(Ibadah::class);
    }

    public function akunAsal(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'akun_asal_id');
    }

    public function akunTujuan(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'akun_tujuan_id');
    }    //
}
