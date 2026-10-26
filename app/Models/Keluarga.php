<?php

namespace App\Models;

use App\Models\Jemaat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Keluarga extends Model
{
    protected $table = 'keluarga';

    protected $fillable = [
        'no_keluarga',
        'nama_keluarga',
        'alamat',
        'no_hp',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    /**
     * Relasi ke data jemaat dalam satu keluarga.
     * Aktifkan jika tabel jemaat memiliki foreign key keluarga_id.
     */
    public function jemaat(): HasMany
    {
        return $this->hasMany(Jemaat::class, 'keluarga_id');
    }
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
