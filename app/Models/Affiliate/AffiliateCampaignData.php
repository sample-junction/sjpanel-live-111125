<?php

namespace App\Models\Affiliate;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing all the data of Affiliate List data.
 *
 * Class AffiliateCampaignData
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Affiliate\AffiliateCampaignData
 */

class AffiliateCampaignData extends Model
{
    protected $fillable = [
        'user_id',
        'aff_camp_id',
        'source_id',
        'medium',
        'aff_vars',
    ];

    protected $dates = ['timestamp'];

    /**
     * This function is used for relationship between user_id AffiliateCampaignData and id of user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * This function is used for relationship between aff_camp_id AffiliateCampaignData and id of AffiliateCampaign model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(AffiliateCampaign::class, 'aff_camp_id', 'id');
    }

    /**
     * This function is used for relationship between source_id AffiliateCampaignData and id of AffiliateList model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliate()
    {
        return $this->belongsTo(AffiliateList::class, 'source_id', 'id');
    }

}
