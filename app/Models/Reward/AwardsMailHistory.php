<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardsMailHistory extends Model
{
    // use HasFactory;

    protected $table = 'awards_mail_history';

    protected $fillable = [
        'panellist_id',
        'country_code',
        'mail_template',
        'mail_data',
        'created_by',
        'updated_at',
    ];
}