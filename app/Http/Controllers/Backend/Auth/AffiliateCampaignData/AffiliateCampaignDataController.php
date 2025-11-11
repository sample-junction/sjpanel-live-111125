<?php

namespace App\Http\Controllers\Backend\Auth\AffiliateCampaignData;

use App\Models\Affiliate\AffiliateCampaignData;
use App\Repositories\Backend\Affiliate\AffiliateRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * This class is handling the displaying the Affiliate Campaign Data.
 *
 * Class AffiliateCampaignDataController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Backend\Auth\AffiliateCampaignData\AffiliateCampaignDataController
 */
class AffiliateCampaignDataController extends Controller
{
    /**
     * @param $affRepo
     * @param AffiliateRepository
     */
    public $affRepo;

    /**
     * AffiliateCampaignDataController constructor.
     *
     * @param AffiliateRepository $affRepo
     */
    public function __construct(AffiliateRepository $affRepo)
    {
        $this->affRepo = $affRepo;
    }

    /**
     * Thia action is used to redirect the User to View of Displaying all the Affiliate Campaign Data.
     *
     * @return resource affiliate_campaign_data/index.blade.php
     */
    public function index()
    {
        $affiliate_campaign_data = $this->affRepo->getAffiliateCampaignData();
        return view('backend.auth.affiliate_campaign_data.index')
            ->with('affiliate_campaign_datas',$affiliate_campaign_data);
    }

    /**
     * This action is used for using using query for getting all the data included
     * in data tables in affiliate_campaign_data/index.blade.php.
     *
     * @return array
     */
    public function dataTable()
    {
        return Laratables::recordsOf(AffiliateCampaignData::class, function($query)
        {
            return $query;
        });
    }
}
