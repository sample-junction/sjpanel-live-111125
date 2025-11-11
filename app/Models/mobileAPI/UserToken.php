<?php

namespace App\Models\mobileAPI;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{

    protected $fillable = ['user_id', 'token','device_name'];
}
