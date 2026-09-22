<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'custom';
    protected $primaryKey = 'idcust';
    public $timestamps = false;

    protected $fillable = [
        'kd_cust',
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'tgl'     => 'date',
    //         'tg_user' => 'datetime',
    //     ];
    // }    //
}
