<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    // Fillable properties
    protected $fillable = [
        'loan_id',  // Foreign key to loan
        'amount',  // Amount paid
        'payment_date',  // Payment date
        'note',  // Optio
    ];

    // Define the relationship between repayment and loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
