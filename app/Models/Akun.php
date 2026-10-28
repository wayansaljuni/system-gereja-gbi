<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Akun extends Model
{
    protected $table = 'akun';
    protected $fillable = [
        'kode',
        'nama',
        'jenis',
        'nama_bank',
        'no_rekening',
        'nama_rekening',
        'saldo_awal',
        'aktif',
        'keterangan',
    ];

    protected $casts = [
        'saldo_awal' => 'decimal:2',
        'aktif' => 'boolean',
    ];    //
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
