<?php

namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing country data.
 *
 * Class Country
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Country
 */

class Country extends Model
{
    use Translatable;
    protected $fillable = [
        'country_code',
        'currency_code',
        'iso_3166_2',
        'iso_3166_3',
        'currency_symbol',
        'currency_decimals',
        'calling_code',
        'flag',
        'order',
        'language',
        'status',
        'is_filterable',
        'is_active',
        'default_locale',
    ];
    public $translatedAttributes = ['name','capital','citizenship','locale'];
    public $timestamps = false;
    public function country_translation()
    {
        return $this->hasOne(CountryTranslation::class,'country_id','id');
    }
}
