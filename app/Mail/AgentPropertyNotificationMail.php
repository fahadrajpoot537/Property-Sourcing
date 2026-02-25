<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgentPropertyNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $property;
    public $agent;

    /**
     * Create a new message instance.
     */
    public function __construct($property, $agent)
    {
        $this->property = $property;
        $this->agent = $agent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Off-Market Property Available: ' . $this->property->headline,
            from: new \Illuminate\Mail\Mailables\Address('inquiries@propertysourcinggroup.co.uk', 'Property Sourcing Group'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.agent-property-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
