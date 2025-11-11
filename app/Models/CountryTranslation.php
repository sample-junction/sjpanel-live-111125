<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    public $fillable = ['country_id','name','capital','citizenship','locale'];
    public $timestamps = false;
}
