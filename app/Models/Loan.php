<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'amount',
        'loan_date',
        'interest_rate',
        'loan_duration',
        'total_amount',  // Total loan amount (loan + interest)
        'daily_repayment',  // Daily repayment amount
        'balance_to_pay',  // Remaining balance to pay
    ];
       public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }
}
