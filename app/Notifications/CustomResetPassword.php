<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    protected $userName;

    public function __construct($token, $userName)
    {
        parent::__construct($token);
        $this->userName = $userName;
    }

   public function toMail($notifiable)
{
    $resetUrl = url(route('password.reset', [
        'token' => $this->token,
        'email' => $notifiable->getEmailForPasswordReset(),
    ], false));

    return (new MailMessage)
        ->subject('Reset Your Loan Hub Password')
        ->greeting("Hello {$this->userName},")
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', $resetUrl)
        ->line('This password reset link will expire in 60 minutes.')
        ->line('If you did not request a password reset, no further action is required.')
        ->line('If you encounter any issue, contact LoanHub Technical team at the email richardogwal97@gmail.com or WhatsApp +256787860378.')
        ->salutation('Regards, Loan Hub');
}

}
