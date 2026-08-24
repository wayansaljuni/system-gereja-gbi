<?php

namespace App\Mail;

use App\Models\AgreementReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgreementReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public AgreementReminder $reminder
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reminder: ' . $this->reminder->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.agreement-reminder',
            with: [
                'reminderTitle' => $this->reminder->title,
                'agreementNumber' => $this->reminder->agreement->agreement_number ?? '-',
                'documentName' => $this->reminder->agreement->title ?? '-',
                'documentNotes' => $this->reminder->agreement->notes ?? '-',
                'remindAt' => $this->reminder->remind_at?->format('d M Y'),
                'message' => $this->reminder->message,
            ],
        );
    }
}