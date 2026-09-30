<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

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

     public function dpoItems()
    {
        return $this->hasMany(Dpo::class, 'nota', 'nota');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function supplier(): BelongsTo
    {
         return $this->belongsTo(Supplier::class, 'kd_supp', 'kd_supp');
    }
    
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
    
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }

}

