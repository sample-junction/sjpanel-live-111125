<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SJPanelMonthlyAward extends Model
{
    // use HasFactory;

    protected $table = 'SJPanel_Monthly_award';

    protected $fillable = [
        'panellist_id',
        'country_code',
        'city_state',
        'award_type',
        'award_month',
        'nominations',
        'points',
        'amount',
        'dollar_amount',
        'redemption_status',
        'redemption_at',
        'amount_credited_date',
    ];

}