<?php

namespace App\Models\MasterData;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * This modal class is used for hidden autopunch details of User after filling basic details.
 *
 * Class CountryMasterData
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\MasterData\CountryMasterData
 */

class CountryMasterData extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'country_master_data';

    /**
     * @var array $fillable
     */
    protected $fillable = [
        'country_code',
        'country_name',
        'country_data',
        'fillable',
        'field',
    ];

    public $timestamps = true;
}
