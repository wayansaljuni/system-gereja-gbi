<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kdcab extends Model
{
    protected $connection = 'mysql55';

    protected $table = 'kd_cab';

    protected $primaryKey = 'kd_cab';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'kd_cab',
        'nama',
        'kota_cab',
        'nm_cab',
        'alm_cab',
        'npwp_cab',
        'telp_cab',
        'fax_cab',
    ];
}