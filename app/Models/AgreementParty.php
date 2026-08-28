<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class AgreementParty extends Model
{
    protected $fillable = [
        'agreement_id',
        'party_type',
        'name',
        'role',
        'contact_person',
        'email',
        'phone',
    ];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }    //
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
