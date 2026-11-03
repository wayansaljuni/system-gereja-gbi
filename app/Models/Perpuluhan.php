<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perpuluhan extends Model
{
    protected $table = 'perpuluhan';
    protected $fillable = ['no_kantong', 'jemaat_id'];

    public function jemaat(): BelongsTo
    {
        return $this->belongsTo(Jemaat::class);
    }    //

    public function transaksiKeuangan(): HasMany
    {
        return $this->hasMany(TransaksiKeuangan::class);
    }
}
