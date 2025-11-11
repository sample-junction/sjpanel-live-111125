<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used to store all the redeem option with
 * all the giftcards data according to their countries where they are available.
 *
 * Class AffiliateList
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Affiliate\AffiliateList
 */

class RedeemOption extends Model
{
    protected $fillable = [
        'name', 'display_name','code','image_uri','country_code', 'country_id','type','status','order'
    ];

    public $timestamps = false;

    /**
     * This function is used making relationship with country_code of RedeemOption and country_code of CountryTrans
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(CountryTrans::class, 'country_code', 'country_code');
    }
}
