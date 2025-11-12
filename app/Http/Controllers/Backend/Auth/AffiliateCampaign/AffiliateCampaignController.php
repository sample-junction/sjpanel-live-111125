<?php

namespace App\Http\Controllers\Backend\Auth\AffiliateCampaign;

use App\Models\Affiliate\AffiliateCampaign;
use App\Repositories\Backend\Affiliate\AffiliateRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * This class is handling the create,update for Campaign Data.
 *
 * Class AffiliateCampaignController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController
 */
class AffiliateCampaignController extends Controller
{
    /**
     * @param $affRepo
     * @param AffiliateRepository
     */
    public $affRepo;

    /**
     * AffiliateCampaignController constructor.
     *
     * @param AffiliateRepository $affRepo
     */
    public function __construct(AffiliateRepository $affRepo)
    {
        $this->affRepo = $affRepo;
    }

    /**
     * This action has to redirect it to the view of all the Affiliate Campaigns.
     *
     * @return resource affiliate_campaign/index.blade.php
     */
    public function index()
    {
        $get_campaign = $this->affRepo->getAffiliateCampaign();
       return view('backend.auth.affiliate_campaign.index')
           ->with('campaigns',$get_campaign);
    }

    /**
     * This action is used for using using query for getting all the data included
     * in data tables in affiliate_campaign/index.blade.php.
     *
     * @return array
     */
    public function dataTable()
    {
        return Laratables::recordsOf(AffiliateCampaign::class, function($query)
        {
            return $query;
        });
    }

    /**
     * This action to redirect the User to the Edit Campaign Form View Page.
     *
     * @param Request $request
     * @return resource affiliate_campaign/edit.blade.php
     */
    public function editCampaign(Request $request)
    {
       $campaign_id = $request->campaign_id;
       $campaign_detail = $this->affRepo->getCampaignData($campaign_id);
       return view('backend.auth.affiliate_campaign.edit')
           ->with('campaign',$campaign_detail)
           ->with('campaign_id',$campaign_id);
    }

    /**
     * This action is used for Posting the Edit Campaign Data.
     *
     * @param Request $request
     * @return mixed
     */

    public function postUpdateCampaign(Request $request)
    {
        $campaign_id = $request->campaign_id;
        $input = $request->only('name','code','type','payout','c_type');
        if($input){
            $update_campaign = $this->affRepo->updateCampaign($campaign_id,$input);
            if($update_campaign){
                return \Redirect::back()
                    ->withFlashSuccess("Campaign Updated");
            } else{
                return \Redirect::back()
                    ->withDanger("Campaign Not Updated");
            }
        }
    }

    /**
     * This action for redirecting the User to the form of Create Campaign View Page.
     *
     * @return resource affiliate_campaign/create.blade.php
     */

    public function createCampaign()
    {
        return view('backend.auth.affiliate_campaign.create');
    }

    /**
     * This action to post Created Campaign Data.
     *
     * @param Request $request
     * @return mixed
     */
    public function postCreateCampaign(Request $request)
    {
        $input = $request->only('name','code','type','payout','c_type');
        if($input){
            $create_campaign = $this->affRepo->createCampaign($input);
            if($create_campaign){
                return \Redirect::back()
                    ->withFlashSuccess("Campaign Created");
             } else{
                return \Redirect::back()
                    ->withDanger("Campaign Not Created");
            }
        }
    }
}
