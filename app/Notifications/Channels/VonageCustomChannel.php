<?php

namespace App\Notifications\Channels;

use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic as VonageBasicCredentials;
use Illuminate\Notifications\Notification;

class VonageCustomChannel
{
    protected $client;

    public function __construct()
    {
        $basic  = new VonageBasicCredentials(
            config('services.vonage.key'),
            config('services.vonage.secret')
        );
        $this->client = new VonageClient($basic);
    }

    public function send($notifiable, Notification $notification)
    {
        if (! method_exists($notification, 'toVonageCustom')) {
            return;
        }

        $message = $notification->toVonageCustom($notifiable);

        $response = $this->client->sms()->send(
            new \Vonage\SMS\Message\SMS(
                $notifiable->phone_number, // assumes user has phone_number attribute
                config('services.vonage.sms_from'),
                $message
            )
        );

        $messageResponse = $response->current();

        if ($messageResponse->getStatus() != 0) {
            \Log::error('Vonage SMS failed', [
                'status' => $messageResponse->getStatus(),
                'message' => $messageResponse->getErrorText()
            ]);
        }
    }
}
