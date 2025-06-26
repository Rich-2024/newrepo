<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestSetup extends Model
{
    protected $fillable = [
          'user_id', 
        'business_name',
        'business_size',
        'interest_rate',
        'loan_duration',
    ];
    public function interestSetup()
{
    return $this->belongsTo(\App\Models\InterestSetup::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
