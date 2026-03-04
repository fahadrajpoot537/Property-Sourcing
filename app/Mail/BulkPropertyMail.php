<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BulkPropertyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $properties;
    public $sender;
    public $customMessage;

    public function __construct($properties, $sender, $customMessage = '')
    {
        $this->properties = is_iterable($properties) ? $properties : collect([$properties]);
        $this->sender = $sender;
        $this->customMessage = $customMessage;
    }

    public function envelope(): Envelope
    {
        $subject = count($this->properties) > 1 
            ? 'New Property Deals from Property Sourcing Group' 
            : 'New Property Available: ' . $this->properties->first()->headline;

        return new Envelope(
            subject: $subject,
            from: new \Illuminate\Mail\Mailables\Address('inquiries@propertysourcinggroup.co.uk', 'Property Sourcing Group Inquiries'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.bulk-properties',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
