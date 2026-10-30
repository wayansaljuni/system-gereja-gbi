<?php

namespace App\Models;

use App\Models\AbsensiDetail;
use App\Models\Kelompok;
use App\Models\Keluarga;
use App\Models\Organisasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Jemaat extends Model
{
    protected $table = 'jemaat';

    protected $fillable = [
        'no_jemaat',
        'no_kantong',
        'keluarga_id',
        'organisasi_id',
        'kelompok_id',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'alamat',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'aktif' => 'boolean',
        ];
    }
    
    public function organisasi(): BelongsTo
    {
        return $this->belongsTo(Organisasi::class, 'organisasi_id');
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class, 'keluarga_id');
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    public function absensiDetails(): HasMany
    {
        return $this->hasMany(
            AbsensiDetail::class,
            'jemaat_id'
        );
    }    

    // public static function generateNoJemaat(): string
    // {
    //     return DB::transaction(function () {
    //         // Mengunci tabel jemaat selama proses generate
    //         DB::table('jemaat')
    //             ->where('no_jemaat', 'like', 'NIJ-%')
    //             ->lockForUpdate()
    //             ->get();

    //         $lastNumber = self::query()
    //             ->where('no_jemaat', 'like', 'NIJ-%')
    //             ->selectRaw("
    //                 MAX(CAST(SUBSTRING(no_jemaat, 5) AS UNSIGNED)) as last_number
    //             ")
    //             ->value('last_number');

    //         $nextNumber = ((int) $lastNumber) + 1;

    //         return 'NIJ-' . str_pad(
    //             $nextNumber,
    //             4,
    //             '0',
    //             STR_PAD_LEFT
    //         );
    //     });        
    // }
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
