<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used to store all the redeem option with
 * all the giftcards data according to their countries where they are available.
 *
 * Class AffiliateList
 * @author Ramesh Kamboj
 * 
 * @access public
 * @package  App\Models\Affiliate\AffiliateList
 */

class RespondentTraffics extends Model
{
    protected $fillable = [
        'panelistId', 'status','respstatus','project_code','project_status', 'incentive','sjid'
    ];

    public $timestamps = false;

}