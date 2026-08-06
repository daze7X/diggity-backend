<?php

namespace App\Mail;

use App\Models\SupportMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupportTicketRepliedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public SupportMessage $supportMessage)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $ticket = $this->supportMessage->supportTicket;
        $ticketNumber = $ticket?->ticket_number ?? 'TCK-XXXXX';
        $subject = $ticket?->subject ?? 'Bantuan';
        
        return new Envelope(
            subject: "[Diggity Support] Balasan Tiket #{$ticketNumber}: {$subject}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.support.replied',
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
