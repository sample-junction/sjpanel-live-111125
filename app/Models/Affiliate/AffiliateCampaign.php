<?php

namespace App\Models\Affiliate;

use Illuminate\Database\Eloquent\Model;


/**
 * This modal class is used for storing all the data of Affiliate Campaign.
 *
 * Class AffiliateCampaign
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Affiliate\AffiliateCampaign
 */

class AffiliateCampaign extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'payout',
        'c_type',
    ];

    /**
     * @var array $dates
     */
    protected $dates = ['timestamp'];

    /**
     * This function is used for custom laratable Action drop down button
     * @param $campaign
     * @return string
     * @throws \Throwable
     */
    public static function laratablesCustomAction($campaign)
    {
        return view('backend.auth.affiliate_campaign.includes.index_action')
            ->with('campaign',$campaign)
            ->render();
    }
}
