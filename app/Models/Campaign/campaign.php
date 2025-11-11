<?php

namespace App\Models\Campaign;

use Illuminate\Database\Eloquent\Model;

class campaign extends Model
{
    protected $fillable = [
        'campaign_name',
        'campaign_subject',
        'template_name',
        'template_id',
        'template_type',
        'campaign_content',
        'campaign_amount',
        'type',
        'campaign_link',
        'campaign_status',
        'campaign_start_date'
    ];
   
}
