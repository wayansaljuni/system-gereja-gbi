<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Produk extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'produk';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'noko',
        'kdb',
        'nmb',
        'nosr',
        'nop',
        'tglg',
        'klh',
        'krskn',
        'solusi',
        'rtgl',
        'stgl',
        'sts',
        'kdcab',
        'ho',

        'tgldtg1',
        'tglplg1',
        'tgldtg2',
        'tglplg2',
        'tgldtg3',
        'tglplg3',

        'electrical',
        'waterinlet',
        'drainage',
        'steamwand',
        'showers',
        'portafilt',
        'backflush',
        'gasket',
        'volmetric',
        'group1',
        'group2',
        'group3',
        'waterqual',
        'hotwtrtmp',
        'cofwtrtmp',
        'wtrpress',
        'boilpress',
        'pumppress',
        'motor',
        'blades',
        'autobutt',

        'yvolt',
        'yampere',
        'ymbar',
        'ybar',
        'ycelcius',

        'updated_at',
        'remark_kom',
        'foto_produk',
        'video_produk',
        'part_kembali',
    ];

    protected function casts(): array
    {
        return [
            'tglg' => 'date',
            'rtgl' => 'datetime',
            'stgl' => 'datetime',
            'tgldtg1' => 'datetime',
            'tglplg1' => 'datetime',
            'tgldtg2' => 'datetime',
            'tglplg2' => 'datetime',
            'tgldtg3' => 'datetime',
            'tglplg3' => 'datetime',
            'updated_at' => 'datetime',
            'foto_produk' => 'array',
            'video_produk' => 'array',
        ];
    }    
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
