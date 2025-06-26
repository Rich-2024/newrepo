<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettledLoan extends Model
{
    use HasFactory;

    // Add the fields that you want to be mass assignable
    protected $fillable = [
        'name',
        'contact',
        'loan_date',
        'amount',
        'interest_rate',
        'total_amount',
        'daily_repayment',
        'balance_left',
          'user_id',
        'created_at',
        'updated_at',
    ];
}
