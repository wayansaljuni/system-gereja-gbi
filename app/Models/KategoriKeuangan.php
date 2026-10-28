<?php

namespace App\Models;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class KategoriKeuangan extends Model
{
    protected $table = 'kategori_keuangan';

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'akun_default_id',
        'bisa_detail_jemaat',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'akun_default_id' => 'integer',
        'bisa_detail_jemaat' => 'boolean',
        'aktif' => 'boolean',
    ];

    public function akunDefault(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'akun_default_id');
    }    //
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
