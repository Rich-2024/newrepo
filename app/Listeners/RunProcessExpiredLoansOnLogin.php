<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Artisan;

class RunProcessExpiredLoansOnLogin
{
    /**
     * Handle the event.
     */
    // public function handle(Login $event): void
    // {
    //     // Run the loans:process-expired command when a user logs in
    //     Artisan::call('loans:process-expired');
    // }
      public function handle(Login $event): void
    {
        $userId = $event->user->id;

        // Run the command for the logged-in user
        Artisan::call('loans:process-expired', [
            'user_id' => $userId,
        ]);
    }
}
