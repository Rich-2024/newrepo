<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminRegisteredNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

  public function build()
{
    return $this->subject('New Admin Registered')
                ->view('emails.admin_registered')
                ->with([
                    'adminName' => $this->user->admin_name,
                    'email' => $this->user->email,
                    'contact' => $this->user->contact,
                ]);
}
}
