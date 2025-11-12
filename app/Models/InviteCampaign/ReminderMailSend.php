<?php

namespace App\Models\InviteCampaign;

use Illuminate\Database\Eloquent\Model;

class ReminderMailSend extends Model
{
    //
    protected $fillable = [
        'reminder_count',
        'batch_number',
        'email',
        'reminder_code',
        'invite_campaign_id',
    ];

    protected $casts = [
        'validation_response' => 'array',
    ];
}
