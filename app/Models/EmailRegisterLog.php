<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailRegisterLog extends Model
{
protected $table = 'email_register_logs';

    protected $fillable = [
        'user_ip',
        'country_code',
        'country_name',
        'user_agent',
        'platform',
        'affiliate',
    ];

}
