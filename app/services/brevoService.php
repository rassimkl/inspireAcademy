<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class BrevoService
{
    public function sendEmail(
        string $toEmail,
        string $subject,
        string $htmlContent,
        array $attachments = []
    ): void {
        $payload = [
            'sender' => [
                'email' => config('brevo.from_email'),
                'name'  => config('brevo.from_name'),
            ],
            'to' => [
                ['email' => $toEmail],
            ],
            'subject' => $subject,
            'htmlContent' => $htmlContent,
        ];

        if (!empty($attachments)) {
            $payload['attachment'] = [];

            foreach ($attachments as $path) {
                $payload['attachment'][] = [
                    'content' => base64_encode(Storage::get($path)),
                    'name' => basename($path),
                ];
            }
        }

        Http::withHeaders([
            'api-key' => config('brevo.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload);
    }
}
