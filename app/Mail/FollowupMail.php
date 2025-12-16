<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FollowupMail extends Mailable
{
public $student;
public $progress;

public function __construct($student, $progress)
{
    $this->student = $student;
    $this->progress = round($progress, 1);
}

public function build()
{
    return $this->subject('Suivi de votre formation - The Inspire Academy')
        ->view('mail.followup');
}

}
