<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Munit extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'munit';
    protected $primaryKey = 'kdun';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'kdun',
        'ket',
    ];
}
