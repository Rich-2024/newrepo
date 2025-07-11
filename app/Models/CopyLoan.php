<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopyLoan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'amount',
        'loan_date',
        'end_date',
        'interest_rate',
        'loan_duration',
        'total_amount',
        'balance_to_pay',
        'daily_repayment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
public function attachments()
{
    return $this->hasMany(Attachment::class, 'copy_loan_id');
}

}
