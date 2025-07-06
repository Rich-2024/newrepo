<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserTrialWelcomeMail extends Mailable
{
    public $user;
    public $trialStartDate;
    public $trialEndDate;

    public function __construct($user, $trialStartDate, $trialEndDate)
    {
        $this->user = $user;
        $this->trialStartDate = $trialStartDate;
        $this->trialEndDate = $trialEndDate;
    }

    public function build()
    {
        return $this->subject('Welcome to LoanHubTracker! Start Your Free Trial')
                    ->view('emails.user_trial_welcome')
                    ->with([
                        'name' => $this->user->admin_name,
                        'trialStartDate' => $this->trialStartDate->format('F j, Y'),
                        'trialEndDate' => $this->trialEndDate->format('F j, Y'),
                    ]);
    }
}
