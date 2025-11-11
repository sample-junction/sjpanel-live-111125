<?php

namespace App\Models\Reward;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryAwardPoint extends Model
{
    // use HasFactory;

    protected $table = 'country_award_points';

    protected $fillable = [
        'country_code',
        'award_id',
        'award_point',
        'award_amount',
        'created_by',

    ];

}