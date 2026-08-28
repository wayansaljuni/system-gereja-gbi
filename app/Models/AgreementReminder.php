<?php

namespace App\Models;

use App\Models\Agreement;
use App\Models\AgreementReminderRecipient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

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
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
