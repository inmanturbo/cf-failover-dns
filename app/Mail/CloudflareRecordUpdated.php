<?php

namespace App\Mail;

use App\Models\CloudflareRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Monolog\Formatter\GoogleCloudLoggingFormatter;

class CloudflareRecordUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Cloudflare record instance.
     */
    public CloudflareRecord $record;

    /**
     * Create a new message instance.
     */
    public function __construct(CloudflareRecord $record)
    {
        $this->record = $record;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cloudflare Record Updated',
            from: new Address('test@example.com'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->markdown('mail.cloudflare-record-updated',[
            'record' => $this->record,
        ]);
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
