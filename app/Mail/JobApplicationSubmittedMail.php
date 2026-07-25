<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class JobApplicationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public JobApplication $application)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $jobTitle = $this->application->career?->title ?? 'Posisi Tidak Diketahui';
        return new Envelope(
            subject: 'Lamaran Karir Baru: ' . $this->application->name . ' - ' . $jobTitle,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.careers.submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->application->cv_path) {
            return [
                Attachment::fromStorageDisk('public', $this->application->cv_path)
                    ->as('CV_' . str_replace(' ', '_', $this->application->name) . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
