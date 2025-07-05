<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanCreationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $admin_name;
    public $loan_date;
    public $client_name;
    public $contact;
    public $amount;
    public $interest_rate;
    public $total_repayable;
    public $end_date;

    public function __construct(
        $admin_name,
        $loan_date,
        $client_name,
        $contact,
        $amount,
        $interest_rate,
        $total_repayable,
        $end_date
    ) {
        $this->admin_name = $admin_name;
        $this->loan_date = $loan_date;
        $this->client_name = $client_name;
        $this->contact = $contact;
        $this->amount = $amount;
        $this->interest_rate = $interest_rate;
        $this->total_repayable = $total_repayable;
        $this->end_date = $end_date;
    }

    public function build()
    {
        return $this->subject('New Loan Issued')
                    ->view('emails.loan_created');
    }
}
