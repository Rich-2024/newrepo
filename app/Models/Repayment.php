<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    // Fillable properties
    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'note',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
