<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BrevoService
{
    public function sendEmail(
        string $to,
        string $subject,
        string $html,
        array $attachments = []
    ): void {
        $payload = [
    'sender' => [
        'email' => config('services.brevo.from_email'),
        'name'  => config('services.brevo.from_name'),
    ],
    'to' => [[
        'email' => $to,
    ]],
    'bcc' => [[
        'email' => 'inspireacademybiarritz@gmail.com',
    ]],
    'subject' => $subject,
    'htmlContent' => $html,
];

        if (!empty($attachments)) {
            $payload['attachment'] = collect($attachments)->map(function ($path) {
                return [
                    'content' => base64_encode(Storage::get($path)),
                    'name' => basename($path),
                ];
            })->toArray();
        }

        Http::withHeaders([
            'api-key' => config('services.brevo.key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.brevo.com/v3/smtp/email', $payload)
         ->throw();
    }
}
