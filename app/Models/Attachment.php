<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'file_name',
        'file_path',
    ];

 public function copyLoan()
{
    return $this->belongsTo(CopyLoan::class, 'copy_loan_id');
}




}

