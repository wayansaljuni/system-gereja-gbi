<?php

namespace App\Jobs;

use App\Mail\AgreementReminderMail;
use App\Models\AgreementReminderRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAgreementReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $recipients = AgreementReminderRecipient::query()
            ->with('reminder.agreement')
            ->whereHas('reminder', function ($query) {
                $query->whereDate('remind_at', '<=', now());
            })
            ->where('is_active', true)
            ->where('is_notified', false)
            ->get();

        foreach ($recipients as $recipient) {
            try {
                Mail::to($recipient->email)->send(
                    new AgreementReminderMail($recipient->reminder)
                );

                $recipient->update([
                    'is_notified' => true,
                    'notified_at' => now(),
                ]);
            } catch (\Throwable $e) {
                report($e);
                // is_notified tetap false, biar bisa dicoba lagi nanti
            }
        }
    }
}