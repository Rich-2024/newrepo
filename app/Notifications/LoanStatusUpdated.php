<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Notifications\Channels\VonageCustomChannel;

class LoanStatusUpdated extends Notification
{
    protected $loan;

    public function __construct($loan)
    {
        $this->loan = $loan;
    }

    public function via($notifiable)
    {
        return [VonageCustomChannel::class];
    }

    public function toVonageCustom($notifiable)
    {
        return "Hello {$notifiable->name}, your loan #{$this->loan->id} status is now: {$this->loan->status}.";
    }
}
