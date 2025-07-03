<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedSettledLoan extends Model
{
  protected $fillable = [
    'user_id',
    'name',
    'amount',
    'balance_left',
    'status',
    'created_at',
    'updated_at',
];

}
