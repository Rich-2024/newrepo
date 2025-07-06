<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\User;

use Carbon\Carbon;

class OtpVerificationController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.otp');
    }

   public function verifyOtp(Request $request)
{
  
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $enteredOtp = $request->otp;
    $sessionOtp = session('otp');
    $userId = session('otp_user_id');

    
    if ($enteredOtp == $sessionOtp && $userId) {
       
        Auth::loginUsingId($userId);

      
        session()->regenerate();

       
        session()->forget(['otp', 'otp_user_id']);

        $user = Auth::user();
        $trialEnd = Carbon::parse($user->trial_start_date)->addDays(60);
        
      
        if (now()->greaterThan($trialEnd)) {
            $user->is_trial_active = false;
            $user->save();

            Auth::logout();
            return redirect()->route('price')->with('error', 'Your free trial has expired. Please upgrade to continue.');
        }
  if ($user->email === 'ogwalrichie5@gmail.com') {
          
            return redirect()->route('admin.renew-trial');
        }

       
        return redirect()->route('view.dash')->with('success', 'OTP verified successfully!');
    }

  
    return back()->withErrors(['otp' => 'Invalid OTP, please try again.']);
}

public function resendOtp(Request $request)
{
    // Get user ID from session
    $userId = session('otp_user_id');

    // Check if session expired
    if (!$userId) {
        return redirect()->route('login')->withErrors(['otp' => 'Session expired. Please login again.']);
    }

    // Retrieve user from DB
    $user = User::find($userId);

    // If user not found, show error
    if (!$user) {
        return back()->withErrors(['otp' => 'User not found.']);
    }

    // Generate new OTP and store in session
    $otp = rand(100000, 999999);
    session(['otp' => $otp]);

    // Send OTP to user's email
    Mail::to($user->email)->send(new OtpMail($otp));

    // Inform the user that a new OTP was sent
    return back()->with('success', 'A new OTP has been sent to your email.');
}

}
