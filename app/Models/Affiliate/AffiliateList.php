<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Model;


/**
 * This modal class is used for storing all the data of Affiliate List data.
 *
 * Class AffiliateList
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Affiliate\AffiliateList
 */

class AffiliateList extends Model
{
    protected $fillable = [
        'name',
        'code',
        'c_link',
        'aff_vars'
    ];

    protected $dates = ['timestamp'];


    /**
     * This function is used for custom laratable Action drop down button
     *
     * @param $affiliate
     * @return resource affiluates/includes/index_action
     * @throws \Throwable
     */
    public static function laratablesCustomAction($affiliate)
    {
        return view('backend.auth.affiliate.includes.index_action')
            ->with('affiliate',$affiliate)
            ->render();
    }
}
