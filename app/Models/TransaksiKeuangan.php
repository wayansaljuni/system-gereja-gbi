<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Ibadah;
use App\Models\Jemaat;
use App\Models\KategoriKeuangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class TransaksiKeuangan extends Model
{
    protected $table = 'transaksi_keuangan';

    protected $fillable = [
        'tanggal',
        'transaksi_keuangan_header_id',
        'ibadah_id',
        'kategori_keuangan_id',
        'akun_id',
        'jemaat_id',
        'metode_pembayaran',
        'jumlah',
        'no_referensi',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'decimal:2',
    ];

    public function ibadah(): BelongsTo
    {
        return $this->belongsTo(Ibadah::class);
    }

    public function kategoriKeuangan(): BelongsTo
    {
        return $this->belongsTo(KategoriKeuangan::class);
    }

    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class);
    }

    public function jemaat(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class);
    }    //

    // public function details(): HasMany
    // {
    //     return $this->hasMany(
    //         TransaksiKeuangan::class,
    //         'transaksi_keuangan_header_id'
    //     );
    // }

    public function header(): BelongsTo
    {
        return $this->belongsTo(
            TransaksiKeuanganHeader::class,
            'transaksi_keuangan_header_id'
        );
    }

    public function getTotalAttribute(): float
    {
        return (float) $this->details()->sum('jumlah');
    }
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

}
