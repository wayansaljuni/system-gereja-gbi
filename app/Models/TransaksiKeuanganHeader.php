<?php

namespace App\Models;

use App\Models\Ibadah;
use App\Models\TransaksiKeuangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class TransaksiKeuanganHeader extends Model
{
    protected $table = 'transaksi_keuangan_header';

    protected $fillable = [
        'tanggal',
        'ibadah_id',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'datetime',
        ];
    }

    public function ibadah(): BelongsTo
    {
        return $this->belongsTo(Ibadah::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            TransaksiKeuangan::class,
            'transaksi_keuangan_header_id'
        );
    }

    public function getTotalAttribute(): float
    {
        return (float) $this->details()->sum('jumlah');
    }    //
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

}
