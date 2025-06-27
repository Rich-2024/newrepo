<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;
use Illuminate\Support\Facades\Log;

class LoanSmsController extends Controller
{
    protected $vonageClient;

    public function __construct()
    {
        $basic  = new Basic(config('services.vonage.key'), config('services.vonage.secret'));
        $this->vonageClient = new VonageClient($basic);
    }

    public function showForm()
    {
        return view('sms.bulk');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:160',
        ]);

        $messageText = $request->input('message');
        $clients = User::whereNotNull('contact')->pluck('contact');

        $failedNumbers = [];
        $successCount = 0;

        foreach ($clients as $phoneNumber) {
            // Normalize phone number to E.164 (Uganda country code example)
            if (!str_starts_with($phoneNumber, '+')) {
                $phoneNumber = '+256' . ltrim($phoneNumber, '0');
            }

            try {
                $response = $this->vonageClient->sms()->send(
                    new SMS($phoneNumber, config('services.vonage.sms_from'), $messageText)
                );

                $message = $response->current();

                if ($message->getStatus() == 0) {
                    $successCount++;
                    Log::info("SMS sent successfully to {$phoneNumber}");
                } else {
                    Log::error("SMS failed for {$phoneNumber} with status: " . $message->getStatus());
                    $failedNumbers[] = $phoneNumber;
                }
            } catch (\Exception $e) {
                Log::error("Exception sending SMS to {$phoneNumber}: " . $e->getMessage());
                $failedNumbers[] = $phoneNumber;
            }
        }

        if (count($failedNumbers) > 0) {
            return redirect()->back()->with('success', "Sent to $successCount clients. Failed for: " . implode(', ', $failedNumbers));
        }

        return redirect()->back()->with('success', "Successfully sent SMS to all $successCount clients.");
    }
}
