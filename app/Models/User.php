<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
         'name',
        'email',
        'password',
        'contact',
        'admin_name',
        'trial_start_date',
        'trial_end_date',
        'is_trial_active',
        'trial_duration_months',
    ];
     protected $casts = [
        'trial_start_date' => 'datetime',
        'trial_end_date' => 'datetime',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPassword($token, $this->admin_name));
}
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
