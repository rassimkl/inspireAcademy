<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishedCourseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $progress;

    public function __construct($student, $progress)
    {
        $this->student = $student;
        $this->progress = round($progress, 1);
    }

    public function build()
    {
        return $this->subject('🎉 Votre formation est terminée !')
            ->view('mail.finished');
    }
}
