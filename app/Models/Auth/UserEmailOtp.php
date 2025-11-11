<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class UserEmailOtp extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'email',
        'otp'
    ];
}
