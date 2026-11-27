<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LibraryNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $mailSubject;
    public string $libraryName;
    public string $recipientName;
    public string $badgeText;
    public string $badgeColor;
    public string $introMessage;
    public array $details;
    public ?string $footerNote;

    public array $ccList;

    public function __construct(array $payload)
    {
        $this->mailSubject    = $payload['subject'];
        $this->libraryName    = $payload['library_name'] ?? 'Study Library';
        $this->recipientName  = $payload['recipient_name'] ?? 'Student';
        $this->badgeText      = $payload['badge_text'] ?? 'NOTIFICATION';
        $this->badgeColor     = $payload['badge_color'] ?? '#2563eb';
        $this->introMessage   = $payload['intro_message'] ?? '';
        $this->details        = $payload['details'] ?? [];
        $this->footerNote     = $payload['footer_note'] ?? null;
        $this->ccList         = $payload['cc'] ?? [];
    }

    public function envelope(): Envelope
    {
        $defaultCc = config('mail.cc_address');
        $allCc = array_values(array_unique(array_filter(array_merge(
            $this->ccList,
            !empty($defaultCc) ? [$defaultCc] : []
        ))));

        return new Envelope(
            subject: $this->mailSubject,
            cc: $allCc,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.library_notification',
        );
    }
}
