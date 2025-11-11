<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 4/15/2019
 * Time: 4:10 PM
 */

namespace App\Repositories\Backend\Affiliate;


use App\Models\Affiliate\AffiliateCampaign;
use App\Models\Affiliate\AffiliateCampaignData;
use App\Models\Affiliate\AffiliateList;
use App\Models\Auth\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * This repository class is used for creating updating affiliate list, campaign data, campaigns.
 *
 * Class AffiliateRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Backend\Affiliate\AffiliateRepository
 */
class AffiliateRepository extends BaseRepository
{

    public function model()
    {
        return User::class;
    }

    /**
     * This action for getting all the list of Affiliates.
     *
     * @return object
     */
    public function getAffiliateList()
    {
        $data = AffiliateList::all();
        return $data;
    }

    /**
     * This action is used for getting a particular Affiliate Details by its Affiliate Id.
     *
     * @param $affiliate_id
     * @return object
     */
    public function getAffiliate($affiliate_id)
    {
        $data = AffiliateList::where('id','=',$affiliate_id)->first();
        return $data;
    }

    /**
     * This action is used to update the Affiliate List.
     *
     * @param $input
     * @param $affiliate_id
     * @return boolean
     */
    public function updateAffiliate($input,$affiliate_id)
    {
        $update = AffiliateList::where('id','=',$affiliate_id)->update($input);
        return $update;
    }

    /**
     * This action is used to create New Affiliate.
     *
     * @param $input
     * @return object
     */
    public function createAffiliate($input)
    {
        $create = AffiliateList::create($input);
        return $create;
    }

    /**
     * This action is used to get all the Affiliate Campaigns.
     *
     * @return object
     */
    public function getAffiliateCampaign()
    {
        $data = AffiliateCampaign::all();
        return $data;
    }

    /**
     * This action is used to get a particular campaign by its campaign id.
     *
     * @param $campaign_id
     * @return object
     */
    public function getCampaignData($campaign_id)
    {
        $data = AffiliateCampaign::where('id','=',$campaign_id)->first();
        return $data;
    }

    /**
     * This action is used to update a campaign.
     *
     * @param $campaign_id
     * @param $input
     * @return boolean
     */
    public function updateCampaign($campaign_id,$input)
    {
        $update = AffiliateCampaign::where('id','=',$campaign_id)->update($input);
        return $update;
    }

    /**
     * This action is userd to create New Campaign.
     * @param $input
     * @return object
     */
    public function createCampaign($input)
    {
        $create  = AffiliateCampaign::create($input);
        return $create;
    }

    /**
     * This action is used to get all the Affiliate Campaigns Data.
     *
     * @return object
     */
    public function getAffiliateCampaignData()
    {
        $data = AffiliateCampaignData::all();
        return $data;
    }
}
