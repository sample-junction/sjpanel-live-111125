<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * This modal class is for storing all the active countries data with their different languages used.
 *
 * Class CountryTrans
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\CountryTrans
 */

class CountryTrans extends Eloquent
{
    protected $connection = 'mongodb';
    protected $table = 'countries_trans';
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'country_code',
        'country_name',
        'capital',
        'currency_code',
        'iso_3166_2',
        'iso_3166_3',
        'is_filterable',
        'currency_symbol',
        'client_project_no',
        'calling_code',
        'translation',
        'min_age',
    ];
    protected $dates = ['started_at', 'ended_at', 'created_at', 'updated_at' ];
}
