<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepaymentNotification extends Mailable
{
    public $admin_name;
    public $name;
    public $contact;
    public $amount;
    public $paymentDate;

    public function __construct($admin_name, $name, $contact, $amount, $paymentDate)
    {
        $this->admin_name = $admin_name;
        $this->name = $name;
        $this->contact = $contact;
        $this->amount = $amount;
        $this->paymentDate = $paymentDate;
    }

    public function build()
    {
        return $this->subject('Loan Repayment Notification')
                    ->view('emails.repayment_notification');
    }
}
