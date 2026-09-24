<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;


class Spk extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'spk';
    protected $primaryKey = 'idwo';
    public $timestamps = false;

    protected $fillable = [
        'idp',
        'noko',
        'kdb',
        'nosr',
        'nospk',
        'rctgl',
        'tgk',
        'ins',
        'prwt',
        'prbk',
        'srvc',
        'pmnd',
        'foc',
        'noin',
        'bjs',
        'spbk',
        'approve',
        'updated_at',
        'nmcust',
    ];

    protected function casts(): array
    {
        return [
            'rctgl'      => 'date',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Produk yang terkait dengan SPK.
     *
     * spk.idp -> produk.id
     */
    public function teknisi(): HasMany
    {
        return $this->hasMany(Teknisi::class, 'nospk', 'nospk');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'idp',
            'id'
        );
    }    
    public function komplain(): HasOne 
    {
        return $this->hasOne(
            Komplain::class,
            'noko',   // field di tabel spk
            'noko'    // field di tabel komplain
        );
    }    
    public function scopeAktif(Builder $query): Builder
    {
        $nik = auth()->user()?->nik;
        return $query
            // Filter SPK mulai 2026-01-01
            ->where('tgk', '>=', '2026-01-01')
            // Produk belum Closed 
            ->whereHas('produk', function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query
                        ->where('sts', '<>', 'Closed');
                });
            })
            // Jika users.nik terisi, filter teknisi berdasarkan NIK
            // Jika NULL / kosong, jangan filter NIK
            ->when(
                filled($nik),
                fn (Builder $query) =>
                    $query->whereHas(
                        'teknisi',
                        fn (Builder $teknisi) =>
                            $teknisi->where('nik', $nik)
                    )
            );        
    }   
    

    public function scopeDikerjakanBulanIni(Builder $query): Builder
    {
        $nik = auth()->user()?->nik;
        $start = now()->startOfMonth();
        $end   = now()->endOfMonth();
        return $query
            ->whereHas('produk', function (Builder $query) use ($start, $end) {
                $query->where(function (Builder $query) use ($start, $end) {
                    $query
                        ->whereBetween('tgldtg1', [$start, $end])
                        ->orWhereBetween('tgldtg2', [$start, $end])
                        ->orWhereBetween('tgldtg3', [$start, $end]);
                });
            })
            // Kalau user mempunyai NIK, hanya SPK teknisi tersebut
            ->when(
                filled($nik),
                fn (Builder $query) =>
                    $query->whereHas(
                        'teknisi',
                        fn (Builder $teknisi) =>
                            $teknisi->where('nik', $nik)
                    )
            );
    }
    public function scopeBulanIni(Builder $query): Builder
    {
        $nik = auth()->user()?->nik;

        return $query
            // SPK berdasarkan tanggal bulan berjalan
            ->whereBetween('tgk', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ])

            // Jika users.nik terisi, filter berdasarkan teknisi
            ->when(
                filled($nik),
                fn (Builder $query) =>
                    $query->whereHas(
                        'teknisi',
                        fn (Builder $teknisi) =>
                            $teknisi->where('nik', $nik)
                    )
            );
    }    
    public function scopeBelumDikerjakanBulanIni(Builder $query): Builder
    {
        $nik = auth()->user()?->nik;

        return $query
            // SPK yang dibuat bulan ini
            ->whereBetween('tgk', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString(),
            ])

            // Belum pernah dikerjakan / dikunjungi
            ->whereHas('produk', function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query
                        ->whereNull('tgldtg1')
                        ->orWhere('tgldtg1', '')
                        ->orWhere('tgldtg1', '0000-00-00 00:00:00');
                });
            })

            // Jika user memiliki NIK, hanya SPK teknisi tersebut
            ->when(
                filled($nik),
                fn (Builder $query) =>
                    $query->whereHas(
                        'teknisi',
                        fn (Builder $teknisi) =>
                            $teknisi->where('nik', $nik)
                    )
            );
    }    
}
