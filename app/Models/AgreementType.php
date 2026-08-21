<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgreementType extends Model
{
      protected $fillable = [
        'code',
        'name',
        'description',
        'has_period',
        'is_active',
    ];

    protected $casts = [
        'has_period' => 'boolean',
        'is_active' => 'boolean',
    ];  //
}
