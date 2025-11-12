<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class SurveyReport extends Model
{
    protected $fillable = [
        'id',
        'RespID',
        'uuid',
        'project_code',
        'survey_code',
        'source_code',
        'country_code',
        'language_code',
        'cpi',
        'status',
        'status_name',
        'resp_status',
        'resp_status_name',
        'reject_reason',
        'duration',
        'start_ip_address',
        'end_ip_address',
        'traffic_flag',
        'client_survey_link',
        'client_end_link',
        'vendor_start_link',
        'vendor_end_link',
        'channel_name',
        'started_at',
        'ended_at',
        'createdOn',
        'updateOn'
    ];
    public $timestamps = false;
}
