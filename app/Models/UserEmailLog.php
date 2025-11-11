<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmailLog extends Model
{
    protected $table = 'user_email_logs';
    
    protected $fillable = [
        'user_id','slot', 'date','sent_at'
    ];
}
