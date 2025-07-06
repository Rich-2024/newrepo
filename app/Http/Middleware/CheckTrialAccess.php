<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckTrialAccess
{
 public function handle(Request $request, Closure $next)
{
    // Only proceed with trial check if the user is logged in
    if (auth()->check()) {
        $user = auth()->user();
        // Log the trial end date and current date
        \Log::info("User trial end date: " . $user->trial_end_date);
        \Log::info("Current date: " . now());

        // Check if trial has expired based on trial_end_date
        if (now()->greaterThan($user->trial_end_date) && $user->is_trial_active) {
            \Log::info("Trial expired, logging out the user.");

            // Mark trial as inactive
            $user->is_trial_active = false;
            $user->save();

            // Log the user out and redirect to the pricing page
            auth()->logout();  // Log the user out immediately
            return redirect()->route('price')->with('error', 'Your free trial has expired. Please upgrade to continue.');
        }
    }

    return $next($request);
}

}

