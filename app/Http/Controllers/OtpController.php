<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vonage\Client as VonageClient;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class OtpController extends Controller
{
    protected $vonageClient;

    public function __construct()
    {
        $basic  = new Basic(config('services.vonage.key'), config('services.vonage.secret'));
        $this->vonageClient = new VonageClient($basic);
    }

    public function showRequestForm()
    {
        return view('otp.request');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'contact' => 'required|string',
        ]);

        $formattedNumber = $this->formatPhoneNumber($request->input('contact'));
        $otp = rand(100000, 999999);
        $from = config('services.vonage.sms_from');
        $messageBody = "Your OTP code is: $otp";

        try {
            $response = $this->vonageClient->sms()->send(
                new SMS($formattedNumber, $from, $messageBody)
            );

            $message = $response->current();
            $status = $message->getStatus();

            if ($status == 0) {
                session(['otp' => $otp, 'contact' => $formattedNumber]);
                return redirect()->route('otp.verify.form')->with('success', 'OTP sent successfully to ' . $formattedNumber);
            } else {
                return back()->withErrors([
                    'sms' => 'Vonage returned status: ' . $status . ' - ' . $message->getErrorText()
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'sms' => 'Error sending OTP: ' . $e->getMessage()
            ]);
        }
    }

    public function showVerifyForm()
    {
        return view('otp.verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $enteredOtp = $request->input('otp');
        $storedOtp = session('otp');

        if ($enteredOtp == $storedOtp) {
            session()->forget(['otp', 'contact']);
            return redirect()->route('otp.request.form')->with('success', 'OTP verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
    }

    private function formatPhoneNumber($number)
    {
        // Remove non-numeric characters
        $number = preg_replace('/\D+/', '', $number);

        // Prefix +256 if it starts with 0 (Ugandan format)
        if (str_starts_with($number, '0')) {
            $number = '256' . substr($number, 1);
        }

        if (!str_starts_with($number, '256')) {
            $number = '256' . ltrim($number, '0');
        }

        return '+' . $number;
    }
}
