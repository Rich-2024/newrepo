<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class UpdateTrialStatus extends Command
{
   
    protected $signature = 'update:trial-status';
    protected $description = 'Update trial status for users whose trial period has expired';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    // Get current date
    $currentDate = Carbon::now();

    // Fetch users with active trials
    $users = User::where('is_trial_active', true)
                 ->whereNotNull('trial_end_date')  // Make sure the trial end date exists
                 ->get();

    foreach ($users as $user) {
        // Check if trial has expired by comparing trial_end_date with current date
        if (Carbon::parse($user->trial_end_date)->isPast()) {
            // Set trial as inactive if expired
            $user->is_trial_active = false;
            $user->save();

            $this->info('Trial expired and status updated for user: ' . $user->name);
        }
    }

    $this->info('Trial status check complete!');
}

}
