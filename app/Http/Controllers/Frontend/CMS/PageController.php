<?php

namespace App\Http\Controllers\Frontend\CMS;

use App\Models\RedeemOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Profiler\UserAdditionalData;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting\Setting;
use Illuminate\Support\Str;
use App\Repositories\Inpanel\General\GeneralRepository;

/**
 * This class is used for redirecting the User to different CMS pages.
 *
 * Class PageController
 * @author Munesh Kumar
 * @author Aman Gupta
 * @access public
 * @package App\Http\Controllers\Frontend\CMS\PageController
 */
class PageController extends Controller
{
    /**
     * This action will redirect the User to View of Faq Page.
     *
     * @return resource cms/page/faq.blade.php
     */
    protected $userRepository;

    public function __construct(
        UserRepository $userRepository,GeneralRepository $generalRepository
        
    ){
        $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
    }

    public function showFaq(Request $request)
    {
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);
        $user = auth()->user();
        if(!$user){
            return view('frontend.cms.page.faq')
                ->with('uuid',$uuid)
                ->with('dfiq',$DFIQ)
                ->withCountries($countries) 
                ->with('country_name',strtoupper($country))
                ->with('countryCode',$countryCode)
                ->with('flags',$flags);
        }
        $viewName = 'frontend.cms.page.faq';
        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);
        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
                $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
                if(!empty($fetch_user_achievement)){
                 $count_User=count(@$fetch_user_achievement);
             }else{
                $count_User=0;
             }
         $active_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
                $fetch_user_achievement1 = $active_user_add_data->user_achievement;
                 $active_user_count=count($fetch_user_achievement1);
        return View($viewName)->with('allUserSurveys',$user_assign_projects)
                              ->with('user',$user)
                              ->with('active_user_count' , $active_user_count)
                              ->with('allUserSurveys',$user_assign_projects)
                                ->with('completedSurveys',$user_completed_surveys)
                                ->with('userActiveSurveys',$user_active_surveys)
                                ->with('attemptedSurvey',$user_attempted_surveys)
                                ->with('user_count' , $count_User)
                                ->with('userExpireSurveys',$user_expire_surveys)
                                ->with('uuid',$uuid)
                                ->with('dfiq',$DFIQ)
                                ->withCountries($countries) 
                                ->with('country_name',strtoupper($country))
                                ->with('countryCode',$countryCode)
                                ->with('flags',$flags);
    }

    // public function FAQ(){
    //     return view('frontend.cms.page.faq')
    // }

    /**
     * This action will redirect the User to View of Privacy Policy.
     *
     * @return resource cms/page/privacy.blade.php
     */
    public function showPrivacyPolicy(Request $request)
    {
        $viewName = 'frontend.cms.page.privacy';        
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return View($viewName)
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags);
    }

    /**
     * This action will redirect the User to View of CCPA Privacy Policy.
     *
     * @return resource cms/page/privacy.blade.php
     */
    public function showCCPAPrivacyPolicy(Request $request)
    {
        $viewName = 'frontend.cms.page.ccpa-privacy';

        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);
        return View($viewName)
            ->with('uuid',$uuid)
            ->with('dfiq',$DFIQ)
            ->withCountries($countries) 
            ->with('country_name',strtoupper($country))
            ->with('countryCode',$countryCode)
            ->with('flags',$flags);
    }

    /**
     * This action will redirect the User to View of Cookie Policy Page.
     *
     * @return resource cms/page/cookie.blade.php
     */
    public function showCookiePolicy(Request $request)
    {
        $viewName = 'frontend.cms.page.cookie';
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return View($viewName)
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags);
    }

    /**
     * This action will redirect the User to View of T&C Page.
     *
     * @return resource cms/page/term_condition
     */
    public function showTermsAndCondition(Request $request)
    {

        $viewName = 'frontend.cms.page.term_condition';

        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return View($viewName)
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags);
    }

/**
     * This action will redirect the User to View of T&C Page.
     *
     * @return resource cms/page/safeguard
     */
    public function showSafeGuard(Request $request)
    {

        $viewName = 'frontend.cms.page.safeguards';
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return View($viewName)
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags);
    }

    /**
     * This action will redirect the User to View Rewards Page with the details of Reward Gift Card.
     *
     * @return resource cms/page/rewards.blade.php
     */
    // public function showExternalRewards()
    // {
    //     $geoip = geoip(request()->ip());
    //     $ipcountryCode = $geoip->getAttribute('iso_code');
    //     $redeemOptions = RedeemOption::where('status', '=', 'active')
    //     ->where('country_code', '=', $ipcountryCode)
    //     ->get();
    //     $viewName = 'frontend.cms.page.rewards';

    //     return View($viewName)
    //         ->with('redeemOptions', $redeemOptions);
    // }

    public function showExternalRewards(Request $request)
    {        
        //DB::enableQueryLog(); 
        $geoip = geoip(request()->ip());
        $ipcountryCode = $geoip->getAttribute('iso_code');
        $langString = session()->get('locale');
        $location = explode('_', $langString);
        $country = $location[1];
        if($ipcountryCode != $country){
            $countryCode = $country;
        }else{
            $countryCode = $ipcountryCode;
        }

        $redeemOptions = RedeemOption::where('status', '=', 'active')
        ->where('country_code', '=', $countryCode)
		->where('locale', '=', $langString)
        ->get();
        
        //dd(DB::getQueryLog());
        $viewName = 'frontend.cms.page.rewards';

        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return View($viewName)
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags)
        ->with('redeemOptions', $redeemOptions);
        
            
    }

    /**
     * This action will redirect the User to View Rewards Page with the details of Reward Gift Card as per his Country section.
     *
     * @return resource cms/page/rewards.blade.php
     */
    public function externalRewardsAsPerLocation($location)
    {        
        //DB::enableQueryLog(); 
        $geoip = geoip(request()->ip());
        $ipcountryCode = $geoip->getAttribute('iso_code');


        $redeemOptions = RedeemOption::where('status', '=', 'active')
        ->where('country_code', '=', $ipcountryCode)
        ->get();
        
        //dd(DB::getQueryLog());
        $viewName = 'frontend.cms.page.rewards';

        return View($viewName)
            ->with('redeemOptions', $redeemOptions);
    }
    
    /**
     * This action will redirect the User to View of Help&Support Page.
     *
     * @return resource cms.page.help_support
     */
    public function showHelpSupport(Request $request)
    {
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return view('frontend.cms.page.help_support')
            ->with('uuid',$uuid)
            ->with('dfiq',$DFIQ)
            ->withCountries($countries) 
            ->with('country_name',strtoupper($country))
            ->with('countryCode',$countryCode)
            ->with('flags',$flags);
    }
    public function showRewardsPolicy(Request $request)
    {
       
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return view('frontend.cms.page.reward_policy')
        ->with('uuid',$uuid)
        ->with('dfiq',$DFIQ)
        ->withCountries($countries) 
        ->with('country_name',strtoupper($country))
        ->with('countryCode',$countryCode)
        ->with('flags',$flags);
    }

    public function showReferralPolicy(Request $request)
    {
        //print_r('hello');die;
        $referal_point_value = setting::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();
        $get_referal_point = $referal_point_value->value;
        [$flags,$uuid,$DFIQ,$countryCode,$country,$countries]=$this->getFlags($request);

        return view('frontend.cms.page.referral_program')
            ->with('get_referal_point',$get_referal_point)
            ->with('uuid',$uuid)
            ->with('dfiq',$DFIQ)
            ->withCountries($countries) 
            ->with('country_name',strtoupper($country))
            ->with('countryCode',$countryCode)
            ->with('flags',$flags);
       
    }

    public function showTestPage(Request $request)
    {
        $emails = ['muneshk@samplejunction.com', 'munesh.sj@gmail.com'];

        Mail::send( 'testemail', [], function($message) use ($emails) {
            $message->to($emails)->subject('Testing mails');
        });
        dd('done');
    }

    private function getFlags(Request $request){
         
        $uuid = Str::uuid()->toString();
        $ip= request()->ip();
        $DFIQ=config('settings.dfiq.status');
        $geodata = geoip(request()->ip());
        $countries = $this->generalRepository->getActiveCountries();
        $country=$geodata->getAttribute('country');
        $countryCode = $geodata->getAttribute('iso_code');
        
       if($countryCode!='US'){
           if(!empty($request->session()->get('locale'))){
               $flags=str_replace('_','-',strtoupper($request->session()->get('locale')));
           }else{
             app()->setLocale('EN-'.$countryCode);
             $flags='EN-'.$countryCode;  
           }
           
       }else{
           $flags=str_replace('_','-',strtoupper($request->session()->get('locale')));
       }

       return [$flags,$uuid,$DFIQ,$countryCode,$country,$countries];
    
   }
}

