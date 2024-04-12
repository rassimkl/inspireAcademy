<?php

namespace App\Mail;

use Carbon\Carbon;
use App\Models\ClassSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClassCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $classSession;
    /**
     * Create a new message instance.
     */
    public function __construct(ClassSession $classSession)
    {
        $this->classSession = $classSession;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Class Scheduele',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.classcreated',
            with: [
                'date' => Carbon::parse($this->classSession->date)->format('F j, Y'),
                'start_time' => $this->classSession->start_time,
                'hours' => $this->classSession->hours,

            ],
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
