<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Hpo extends Model
{
    protected $connection = 'mysql55';
    protected $table = 'hpo';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tgl' => 'date',
            'tgl_krm' => 'date',
            'tgl_krm_rev' => 'date',
            'tglapp' => 'datetime',
        ];
    }    //
    public function scopePerluApprovalPO(Builder $query, ?string $kdCab): Builder
    {
        if (blank($kdCab)) {
            return $query->whereRaw('1 = 0');
        }

        $query->whereDate('hpo.tgl', '>=', now()->subDays(180)->toDateString());
        return $query
            ->where('hpo.kd_cab', $kdCab)
            ->where('hpo.approve', '');
    }

}

