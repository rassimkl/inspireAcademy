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
            'to' => [[ 'email' => $to ]],
            'subject' => $subject,
            'htmlContent' => $html,
        ];

if (!empty($attachments)) {
    $payload['attachment'] = collect($attachments)->map(function ($item) {

        // Cas 1 : ancien format (string)
        if (is_string($item)) {
            $path = $item;
            $name = basename($item);
        }
        // Cas 2 : upload avec nom original
        else {
            $path = $item['path'];
            $name = $item['name'];
        }

        return [
            'content' => base64_encode(Storage::get($path)),
            'name' => $name,
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
