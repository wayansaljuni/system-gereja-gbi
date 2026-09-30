<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'ks_supp',
        'nama',
        'alamat',
        'alamat1',
    ];

    protected function casts(): array
    {
        return [
            'tgl_update' => 'datetime',
        ];
    }

    /**
     * Produk yang terkait dengan SPK.
     *
     * spk.idp -> produk.id
     */
    // public function teknisi(): HasMany
    // {
    //     return $this->hasMany(Teknisi::class, 'nospk', 'nospk');
    // }
    //
}
