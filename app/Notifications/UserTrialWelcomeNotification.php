<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;

class UserTrialWelcomeNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $trialEndDate;

    public function __construct($user, $trialEndDate)
    {
        $this->user = $user;
        $this->trialEndDate = $trialEndDate;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Welcome to LoanHubTracking Management System!')
                    ->greeting('Dear ' . $this->user->name . ',')
                    ->line('Your free trial starts today: ' . Carbon::now()->toFormattedDateString())
                    ->line('Your trial will end on: ' . $this->trialEndDate->toFormattedDateString())
                    ->line('Enjoy exploring LoanHubTracking Management System and all its features!')
                    ->action('Get Started', url('/dashboard'))
                    ->line('Thank you for choosing LoanHubTracking!');
    }

    public function toArray($notifiable)
    {
        return [
            // Add any additional data here for array format, if needed
        ];
    }
}
