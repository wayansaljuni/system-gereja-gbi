<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgreementReminderRecipient extends Model
{
    protected $fillable = [
       'agreement_reminder_id',
        'user_id',
        'name',
        'email',
        'recipient_type',
        'is_active',
        'is_notified',
        'notified_at',
    ];

    protected $casts = [
        'is_notified' => 'boolean',
        'notified_at' => 'datetime',
    ];

    public function reminder(): BelongsTo
    {
        return $this->belongsTo(AgreementReminder::class, 'agreement_reminder_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }    //
}
