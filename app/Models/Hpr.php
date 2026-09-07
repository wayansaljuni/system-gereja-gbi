<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Hpr extends Model
{
    use HasFactory;
    protected $connection = 'mysql55';
    protected $table = 'hpr';
    protected $primaryKey = 'idhpr';
    public $incrementing = true;
    protected $keyType = 'int';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $fillable = [
        'nota', 'tgl', 'nop', 'dept', 'gp', 'repacking', 'user', 'kd_cab',
        'budget', 'jnsbudget',
        'approve', 'tglapp',
        'approve1', 'tglapp1',
        'approve2', 'tglapp2',
        'approve3', 'tglapp3',
        'total', 'nodo', 'nmproject', 'tgldel', 'instplace', 'adress',
        'map', 'layout', 'others',
        'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7',
        'jnspack', 'tgl_update', 'tglentry', 'updateke',
        'approveby', 'approveby1', 'inventory', 'tambahan', 'kd_supp',
        'jnspr', 'nik', 'kdlok', 'nojr', 'otorisasifa', 'kdseg',
    ];
    protected $casts = [
        'tgl'        => 'date',
        'tglapp'     => 'date',
        'tglapp1'    => 'date',
        'tglapp2'    => 'date',
        'tglapp3'    => 'date',
        'tgldel'     => 'date',
        'tglentry'   => 'date',
        'tgl_update' => 'datetime',
        'total'      => 'decimal:2',
        'map'        => 'integer',
        'layout'     => 'integer',
        'others'     => 'integer',
        'c1'         => 'integer',
        'c2'         => 'integer',
        'c3'         => 'integer',
        'c4'         => 'integer',
        'c5'         => 'integer',
        'c6'         => 'integer',
        'c7'         => 'integer',
        'updateke'   => 'integer',
        'tambahan'   => 'integer',
    ];

    public function dprItems()
    {
        return $this->hasMany(Dpr::class, 'nota', 'nota');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

}
