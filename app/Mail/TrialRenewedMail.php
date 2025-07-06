<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;
use App\Models\User;
use Carbon\Carbon;

class TrialRenewedMail extends Mailable
{
    public $user;
    public $newTrialEndDate;

    public function __construct(User $user, Carbon $newTrialEndDate)
    {
        $this->user = $user;
        $this->newTrialEndDate = $newTrialEndDate;
    }

    public function build()
    {
        return $this->subject('Account Access Period Renewed')  
                    ->view('emails.trial_renewed')  
                    ->with([
                        'user' => $this->user,
                        'newTrialEndDate' => $this->newTrialEndDate->toFormattedDateString(),
                    ]);
    }
}
