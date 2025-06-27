<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class SmsService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }

    // Format and validate Uganda phone number
    private function formatPhoneNumber(string $phone): ?string
    {
        // Remove all non-digit characters
        $digits = preg_replace('/\D+/', '', $phone);

        // Normalize numbers starting with 0 (local format)
        if (strlen($digits) === 10 && substr($digits, 0, 1) === '0') {
            $digits = '256' . substr($digits, 1);
        }

        // Ensure country code prefix
        if (strlen($digits) === 9 && substr($digits, 0, 1) === '7') {
            $digits = '256' . $digits;
        }

        // Add plus sign
        $formatted = '+' . $digits;

        // Validate pattern for Uganda mobile numbers: +2567XXXXXXXX
        if (preg_match('/^\+2567\d{8}$/', $formatted)) {
            return $formatted;
        }

        return null;
    }

    public function sendSms(string $to, string $message): bool
    {
        $to = $this->formatPhoneNumber($to);
        if (!$to) {
            // Invalid phone number format
            return false;
        }

        try {
            $this->twilio->messages->create($to, [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => $message,
            ]);
            return true;
        } catch (RestException $e) {
            \Log::error("Twilio SMS send failed for number {$to}: " . $e->getMessage());
            return false;
        }
    }

    public function sendBulkSms(array $numbers, string $message): array
    {
        $results = [];

        foreach ($numbers as $number) {
            $success = $this->sendSms($number, $message);
            $results[$number] = $success;
        }

        return $results;
    }
}
