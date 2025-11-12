<?php

namespace App\Models\mobileAPI;

use Illuminate\Database\Eloquent\Model;

class deviceHistory extends Model
{

    protected $fillable = ['user_id', 'token','device_name','device_token','device_type'];
}
