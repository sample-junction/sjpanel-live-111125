<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;

class CountriesCurrencies extends Model
{
    //
     protected $table = 'country_points';
     protected $fillable = [
            'country',    // Add locale here
            'country_language',    // Add locale here
            'currency',
            'points',
            'user_id',
            'status',
            'updated_at'
            // Add other fillable attributes if necessary
        ];

}
