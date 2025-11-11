<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Model;

class campaign_history extends Model
{
    protected $fillable =[
        'campaign_id',
        'c_type',
        'panelist_id',
        'campaign_subject',
        'campaign_content',
        'campaign_amount',
        'campaign_code',
        'status_link',
        'link_status_date',
        'campaign_start_date',
        'campaign_status',
        'survey_loi',
        'survey_topic',
        'survey_code',
        'project_id',
        'user_pro_id',
        'survey_email_reminder',
        'email_reminder_date'
    ];
}
