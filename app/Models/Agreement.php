<?php

namespace App\Models;

use App\Models\AgreementAttachment;
use App\Models\AgreementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agreement extends Model
{
    protected $fillable = [
        'agreement_number',
        'agreement_type_id',
        'qty',
        'title',
        'pic',
        'sifat',
        'start_date',
        'end_date',
        'duration_value',
        'duration_unit',
        'auto_renewal',
        'renewal_period_value',
        'renewal_period_unit',
        'status',
        'reminder_enabled',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renewal' => 'boolean',
        'reminder_enabled' => 'boolean',
        'duration_value' => 'integer',
        'renewal_period_value' => 'integer',
    ];

    public function agreementType(): BelongsTo
    {
        return $this->belongsTo(AgreementType::class);
    }    //
    public function attachments(): HasMany
    {
        return $this->hasMany(AgreementAttachment::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(AgreementReminder::class);
    }

    public function parties(): HasMany
    {
        return $this->hasMany(AgreementParty::class);
    }
}
