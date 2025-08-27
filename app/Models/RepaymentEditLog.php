<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepaymentEditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'repayment_id',
        'edited_by',
        'changes',
    ];

    protected $casts = [
        'changes' => 'array',
    ];

    public function repayment()
    {
        return $this->belongsTo(SettledRepayment::class, 'repayment_id');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }
}
