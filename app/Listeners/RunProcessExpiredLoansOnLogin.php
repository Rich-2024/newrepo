<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Artisan;

class RunProcessExpiredLoansOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Run the loans:process-expired command when a user logs in
        Artisan::call('loans:process-expired');
    }
}
