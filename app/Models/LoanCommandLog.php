<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanCommandLog extends Model
{
    protected $fillable = ['user_id', 'last_ran_on'];
}
