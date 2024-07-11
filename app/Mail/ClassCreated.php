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
        // Parse the start_time and remove the seconds
        $startTime = Carbon::parse($this->classSession->start_time)->format('H:i');

        // Format the hours to H:M
        $totalMinutes = intval($this->classSession->hours * 60); // Convert hours to total minutes
        $hours = floor($totalMinutes / 60); // Get the whole hours
        $minutes = $totalMinutes % 60; // Get the remaining minutes
        $formattedHours = sprintf('%d:%02d', $hours, $minutes); // Format as H:M

        return new Content(
            view: 'mail.classcreated',
            with: [
                'date' => Carbon::parse($this->classSession->date)->format('F j, Y'),
                'start_time' => $startTime,
                'hours' => $formattedHours,
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
