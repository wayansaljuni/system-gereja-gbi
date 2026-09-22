<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komplain extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'komplain';
    protected $primaryKey = 'noko';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'noko',
    ];

    protected function casts(): array
    {
        return [
            'tgl'     => 'date',
            'tg_user' => 'datetime',
        ];
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            Custom::class,
            'kdcust',
            'kd_cust'
        );
    }    
    //
}
