<?php

namespace App\Http\Controllers\Backend\Auth\Affiliate;

use App\Models\Affiliate\AffiliateList;
use App\Repositories\Backend\Affiliate\AffiliateRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;


/**
 * This class is used for handling all the updation,creation for the affiliate.
 *
 * Class AffiliateController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Backend\Auth\Affiliate\AffiliateController
 */
class AffiliateController extends Controller
{

    /**
     * @param $affRepo
     * @param AffiliateRepository
     */
    public $affRepo;

    /**
     * AffiliateController constructor.
     *
     * @param AffiliateRepository $affRepo
     */
    public function __construct(AffiliateRepository $affRepo)
    {
        $this->affRepo = $affRepo;
    }

    /**
     * This action is used to show view Details of the Affiliate List.
     *
     * @param Request $request
     * @return resource affiliate.affiliate_list.blade.php
     */
    public function affiliateList(Request $request)
    {
           $affiliate_list = $this->affRepo->getAffiliateList();
           return view('backend.auth.affiliate.affiliate_list')
               ->with('affiliate_lists',$affiliate_list);
    }

    /**
     * This action is used for using using query for getting all the data included
     * in data tables in affiliate_list/index.blade.php.
     *
     * @return array
     */
    public function dataTable()
    {
        return Laratables::recordsOf(AffiliateList::class, function($query)
        {
            return $query;
        });
    }

    /**
     * This action is used to show the view of Edit form of Affiliate List.
     *
     * @param Request $request
     * @return resource auth.affiliate.edit.blade.php
     */
    public function editAffiliateList(Request $request)
    {
        $affiliate_id = $request->affiliate_id;
        $affiliate_details= $this->affRepo->getAffiliate($affiliate_id);
        return view('backend.auth.affiliate.edit')
            ->with('affiliate_detail',$affiliate_details)
            ->with('affiliate_id',$affiliate_id);
    }

    /**
     * This action to post the Updated Affiliate List
     *
     * @param Request $request
     * @return mixed
     */
    public function postUpdateAffiliate(Request $request)
    {
        $affiliate_id = $request->affiliate_id;
        $input = $request->only('name','code','c_link','aff_vars');
        $update_affiliate = $this->affRepo->updateAffiliate($input,$affiliate_id);
        if($update_affiliate){
            return \Redirect::back()
                ->withFlashSuccess("Affiliate Updated");
        } else{
            return \Redirect::back()
                ->withDanger("Affiliate Not Updated");
        }
    }

    /**
     * This action for redirecting User to the view of Creating the Affiliate and showing the Create Form.
     *
     * @return resource affiliate/create.blade.php
     */

    public function createAffiliate()
    {
        return view('backend.auth.affiliate.create');
    }

    /**
     * This action for Posting the new Affiliate Created.
     *
     * @param Request $request
     * @return mixed
     */
    public function postCreateProject(Request $request)
    {
       $input  = $request->only('name','code','c_link','aff_vars');
       if($input){
           $createAffiliate = $this->affRepo->createAffiliate($input);
           if($createAffiliate){
               return \Redirect::back()
                   ->withFlashSuccess("New Affiliate Created");
           } else{
               return \Redirect::back()
                   ->withDanger("Affiliate Not Updated");
           }
       }
    }


   
}
