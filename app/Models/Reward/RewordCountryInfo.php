<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewordCountryInfo extends Model
{
    // use HasFactory;

    protected $table = 'reword_country_info';

    protected $fillable = [
        'country_code',
        'zoom_link',
        'date_time',
        'status',
        'active_cron_job',
        'award_mail_temp'
    ];

}