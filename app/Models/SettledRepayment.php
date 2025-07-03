<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettledRepayment extends Model
{
protected $fillable = [
    'settled_loan_id',
    'amount',
    'payment_date',
    'note',
];
// public function settledLoan()
// {
//     return $this->belongsTo(SettledLoan::class);

public function settledLoan()
{
    return $this->belongsTo(SettledLoan::class, 'settled_loan_id');
}

}
