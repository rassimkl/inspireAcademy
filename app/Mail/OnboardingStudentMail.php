<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OnboardingStudentMail extends Mailable
{
    public string $mailContent;
    public string $programmePath;
    public string $conventionPath;
    public string $reglementPath;
    public ?string $uploadedPath = null;
    public ?string $uploadedName = null;


    public function __construct(string $mailContent, string $programmePath, string $conventionPath, string $reglementPath)
    {
        $this->mailContent = $mailContent;
        $this->programmePath = $programmePath;
        $this->conventionPath = $conventionPath;
        $this->reglementPath = $reglementPath;
        $this->uploadedPath = $uploadedPath;
        $this->uploadedName = $uploadedName;
    }

    public function build()
    {
        $mail = $this->subject('Votre inscription – The Inspire Academy')
            ->html($this->mailContent)
            ->attach(storage_path('app' . $this->programmePath), [
                'as' => 'Programme_de_formation.pdf',
            ])
            ->attach(storage_path('app' . $this->conventionPath), [
                'as' => 'Convention_de_formation.pdf',
            ])

            ->attach(storage_path('app' . $this->reglementPath), [
                'as' => 'Reglement_interieur.pdf',
            ]);

            if ($this->uploadedPath && $this->uploadedName) {
                $mail->attach(
                  storage_path('app' . $this->uploadedPath),
                     ['as' => $this->uploadedName]
                    );
                }

                return $mail;
    }

}
