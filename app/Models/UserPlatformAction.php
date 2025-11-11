<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlatformAction extends Model
{
    protected $table = 'user_platform_actions';

    protected $fillable = [
        'user_uuid',
        'platform',
        'action_type', //Enum('registration','survey_participation','redemption_request','support_ticket','other')
        'action_id',
        'action_time',
    ];
}
