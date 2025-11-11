<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_ip_map extends Model
{
    protected $fillable = ['user_id', 'user_ip'];
}
