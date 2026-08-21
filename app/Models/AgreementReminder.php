<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgreementReminder extends Model
{
    protected $fillable = [
        'agreement_id',
        'remind_at',
        'title',
        'message',
        'is_sent',
        'sent_at',
    ];

    protected $casts = [
        'remind_at' => 'date',
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
    ];

    public function agreement(): BelongsTo
    {
        return $this->belongsTo(Agreement::class);
    }    //
    public function recipients(): HasMany
    {
        return $this->hasMany(AgreementReminderRecipient::class);
    }
}
