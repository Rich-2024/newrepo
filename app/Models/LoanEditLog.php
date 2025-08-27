<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanEditLog extends Model
{
    protected $fillable = [
        'loan_id', 'edited_by', 'note', 'before_changes', 'after_changes'
    ];

    protected $casts = [
        'before_changes' => 'array',
        'after_changes'  => 'array',
    ];

    public function editor()
    {
        return $this->belongsTo(User::class, 'edited_by');
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
