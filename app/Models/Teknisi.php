<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teknisi extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'teknisi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'noko',
        'nospk',
        'nik',
        'nama',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }

    /**
     * SPK yang dikerjakan oleh teknisi.
     *
     * teknisi.nospk -> spk.nospk
     */
    public function spk(): BelongsTo
    {
        return $this->belongsTo(
            Spk::class,
            'noko', // field pada teknisi
            'noko'  // field pada spk
        );
    }

    public function komplain(): HasOne
    {
        return $this->hasOne(
            Komplain::class,
            'noko', // komplain.noko
            'noko'  // teknisi.noko
        );
    }    
}
