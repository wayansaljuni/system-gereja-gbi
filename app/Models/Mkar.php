<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mkar extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'mkar';
    protected $primaryKey = 'nik';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nik',
        'ket',
    ];    //
}
