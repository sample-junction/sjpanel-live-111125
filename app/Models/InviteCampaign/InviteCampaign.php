<?php

namespace App\Models\InviteCampaign;

use Illuminate\Database\Eloquent\Model;

class InviteCampaign extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'ipquality_token',
        'email_verified',
        'email_status',
        'email_sent',
        'email_sent_at',
        'validation_response',
        'error_log',
    ];

    protected $casts = [
        'validation_response' => 'array',
    ];
}
