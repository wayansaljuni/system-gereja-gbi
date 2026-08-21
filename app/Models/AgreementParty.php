<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
