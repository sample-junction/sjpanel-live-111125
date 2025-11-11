<?php

namespace App\Http\Controllers\Inpanel\Redeem;

use App\Events\Inpanel\Auth\UserRedeemRequest;
use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Backend\Auth\UserRepository as userBackRepo;
use App\Models\Redeem\RequestRedeem;
use App\Models\RedeemOption;
use  App\Mail\Backend\RedeemApprove\ThresoldCompMail;
use Illuminate\Http\Request;
use App\Events\Inpanel\Auth\UserTour;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Auth\User;
use App\Repositories\Inpanel\Redeem\RedeemRepository;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Http\Requests\Inpanel\RedeemPoints\RedeemRequest;
use Freshbitsweb\Laratables\Laratables;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use App\Models\Setting\Setting;
use Carbon;
use Illuminate\Support\Facades\Mail;
use App\Helpers\MailHelper;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Project\UserProject;
use DB;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;

// use App\Http\Controllers\Inpanel\Redeem\Activity;

/**
 * This class is used for handling all the Redeem Requests made by the Users.
 *
 * Class RedeemController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\Redeem\RedeemController
 */

class RedeemController extends Controller
{

    /**
     * @param $redeemRepo RedeemRepository
     * @param UserRepository $userRepository

     */
    public $redeemRepo, $notificationRepo, $userAdd, $userRepository, $userBackRepo, $countriesCurrenciesRepository;

    /**
     * RedeemController constructor.
     *
     * @param RedeemRepository $redeemRepo
     * @param UserAdditionalDataRepository $userAdd
     */
    public function __construct(RedeemRepository $redeemRepo, UserRepository $userRepository, UserAdditionalDataRepository $userAdd, UserNotificationRepository $notificationRepo, userBackRepo $userBackRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->redeemRepo = $redeemRepo;
        $this->userRepository = $userRepository;
        $this->notificationRepo = $notificationRepo;
        $this->userBackRepo = $userBackRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }

    /**
     * This action is used to redirect the User to the view of Redeem Index Page
     *
     * As the user is redirected to the Redeem Index page and he has crossed the threshold limit
     * he would be able to send the redeem request but if not than he would see the locked
     * redeem requests page
     *
     * @return resource redeem/index.blade.php
     */

    public function index(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = Auth::user();
        $user_id = $user->id;

        $country_lang = $user->locale;


        // date_default_timezone_set($user->timezone);
        /* $userPoints = $user->point()->first();*/
        $userPoints = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $userCountryId = $user->country;
        $redeemOptions = RedeemOption::where('status', '=', 'active')
            ->where('country_id', '=', 240)->get();
        $threshold_value = config('app.points.metric.threshold_points');

        //$getThresholdValue = setting::where('key','=','PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->first();


        /* Parshant Sharma [28-08-2024] STARTS */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }

        /* if($currencies['lang'] == 'UK'){
			$threshold_value = $countryPoints*5;
		}else{			
			$threshold_value = $getThresholdValue->value;
		} */
        $cntryy = explode('_', $countryPoint->country_language);

        $thresholdCountry = 'PANEL_REDEEMPTIOM_THRESHOLD_POINTS_' . $cntryy[1];

        $getThresholdValue = setting::where('key', '=', $thresholdCountry)->first();

        $threshold_value = $getThresholdValue->value;


        /* Parshant Sharma [28-08-2024] ENDS */

        if (empty($userPoints)) {
            $userPoints = false;
            $userpoint = false;
        } else {
            $userpoint = $userPoints->user_points;
        }

        // echo '<pre>';
        // print_r($threshold_value);die();

        $projects_completed_pending_ca = [];
        $projects_completed_pending_ca = UserProject::where('user_id', '=', $user_id)
            //->whereNotIn('status',[$this->getStartedStatus()])
            ->where('status', '=', 1)->paginate();

        //  		echo '<pre>';
        // print_r($projects_completed_pending_ca[0]['points']);die();   
        $count_completed_assignments = 0;

        foreach ($projects_completed_pending_ca as $proj) {

            $count_completed_assignments += $proj['cpi'];
        }
        //$count_completed_assignments;
        // newly added by SM 3-11-23

        // $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        // $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        // $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
        // $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);
        // $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $user_assign_projects =Cache::remember('user_assign_projects', 3600, function () use($user) {
            //echo"insie";
           // exit;

            return $this->userRepository->getUserAssignProjectCount($user);
        });
         $user_completed_surveys =Cache::remember('user_completed_surveys', 3600, function () use($user) {
            return $this->userRepository->getUserCompletedProject($user);
        });

         $user_attempted_surveys =Cache::remember('user_attempted_surveys', 3600, function ()  use($user){
            return $this->userRepository->getUserAttemptedProject($user);
        });
         $user_active_surveys =Cache::remember('user_active_surveys', 3600, function () use($user) {
            return $this->userRepository->getUserActiveSurveys($user);
        });
         $user_expire_surveys =Cache::remember('user_expire_surveys', 3600, function () use($user) {
            return $this->userRepository->getUserExpireSurveys($user);
        });


        $fetch_user_achievement1 = $userPoints->user_achievement;
        $active_user_count = count($fetch_user_achievement1);

        $fetch_user_achievement = $userPoints->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }

        $userPoints_head = $userPoints->user_points['completed'];

        $redeem_history = RequestRedeem::where('user_uuid', '=', $user->uuid)->get();

        //         		echo '<pre>';
        // print_r($redeem_history);die();

        //



        $redeem_requests = RequestRedeem::where('user_uuid', '=', $user->uuid)->where('status', '=', 'pending')->first();


        // 		echo '<pre>';
        // print_r($redeem_requests);die();
        $gift_cards = RedeemOption::where('country_code', '=', $user->country_code)->get();

        $tour_detail = isset($userPoints->user_tour_taken) ? $userPoints->user_tour_taken : 0;
        $tour_taken = 0;
        if ($tour_detail) {
            foreach ($tour_detail as $key => $value) {
                if ($value['section'] == 'redeem-points' && $value['taken'] == true) {
                    $tour_taken = 1;
                }
            }
        }

        if (!empty($redeem_requests)) {

            /* if($currencies['lang'] == 'UK' || $currencies['lang'] == 'CA' || $currencies['lang'] == 'IN'){
				$redeemValue = number_format($redeem_requests->redeem_points/$countryPoints,2);
			}else{			
				$redeemValue = RequestRedeem::laratablesCustomValue($redeem_requests);
				$redeemValue += $count_completed_assignments;
			} */

            $redeemValue = number_format($redeem_requests->redeem_points / $countryPoints, 2);
        } else {
            $redeemValue = "";
        }

        //$multiplypoint =  config('settings.redeemRequestCondition.check_multiply');
        $getmultiplyValue = setting::where('key', '=', 'PANEL_REDEEMPTIOM_MULTIPLY_POINTS')->first();
        $multiplypoint = $getmultiplyValue->value;
        if ($request->has('update')) {
            $update = $this->notificationRepo->updateNotificationSeenStatus($request->notification_id);
        }


        $users_Points = $userPoints;

        //echo"<pre>";print_r($users_Points); die;

          //$user_activity1 = Activity::inLog('user_achievements')->causedBy($user)->orderBy('created_at','desc')->get();



         //  //$ReferalUser=DB::table('referral_links')
         //  ->leftjoin('referral_relationships','referral_relationships.referral_link_id','=','referral_links.id')
         //  ->leftjoin('users','users.id','=','referral_relationships.user_id')
         // ->select('referral_relationships.user_id','users.email','users.first_name', 'referral_relationships.first_survey_completed')
         // ->where('referral_links.user_id','=',$user_id)
         // //->groupBy('products.id')
         // ->get();
        Cache::forget('user_activity');
         $user_activity = Cache::remember('user_activity', 3600, function () use($user) {
                return  Activity::inLog('user_achievements')->causedBy($user)->orderBy('created_at','desc')->get();
            });

              $ReferalUser = Cache::remember('ReferalUser', 3600, function ()  use($user_id){

                  return DB::table('referral_links')
                  ->leftjoin('referral_relationships','referral_relationships.referral_link_id','=','referral_links.id')
                  ->leftjoin('users','users.id','=','referral_relationships.user_id')
                 ->select('referral_relationships.user_id','users.email','users.first_name', 'referral_relationships.first_survey_completed')
                 ->where('referral_links.user_id','=',$user_id)
                 //->groupBy('products.id')
                 ->get();
            });
                 // Code Added By Vikas Dhull 07-March-2025(Starting)

        $pendingReferralPoints = 0;

        foreach ($user_activity as $activity) {

            if (strpos($activity->description, 'invite_points') !== false) {
                $properties = json_decode($activity->properties, true);
                $userIdFromActivity = $properties['user_id'] ?? null;

                // If user_id is found in properties, check for matching referral relationship
                if ($userIdFromActivity) {
                    // Find the referral relationship for the user_id
                    $referralRelationship = DB::table('referral_relationships')
                        ->where('user_id', $userIdFromActivity)
                        ->first();

                    // Case 1: If there's no referral relationship OR if first_survey_completed is false
                    if (!$referralRelationship || $referralRelationship->first_survey_completed == 'False' || is_null($referralRelationship->first_survey_completed)) {
                        // Add points from the activity to the total
                        $pendingReferralPoints += $properties['points']; // Add the points from the properties
                    }
                }
            }
            if (strpos($activity->description, 'referral_points') !== false) {
                $properties = json_decode($activity->properties, true);
                $pendingReferralPoints += $properties['points'] ?? 0;
            }
        }
        // Ending
        $userData = array();

        foreach ($ReferalUser as $referUser) {
            if (!empty($referUser->first_name)) {
                $after = \Crypt::decrypt($referUser->first_name);
                $email = \Crypt::decrypt($referUser->email);
                $userData[$user_id][] = $after . " (" . $email . ") ";
            } else {
                $userData[$user_id][] = '';
            }
        }

        $joining_bonus = Setting::whereIn('key', [
            'PANEL_AUTOMOTIVE_POINTS',
            'PANEL_MY_PROFILE_POINTS',
            'PANEL_BASIC_PROFILE_POINTS',
            'PANEL_EMPLOYMENT_POINTS',
            'PANEL_FAMILY_POINTS',
            'PANEL_HEALTH_FOOD_POINTS',
            'PANEL_TECHNOLOGY_POINTS',
            'PANEL_TRAVEL_LEISURE_POINTS'
        ])->sum('value');
        //$extraBonus = DB::table('expense_records')->where('user_id','=',$user->id)->get();
        $extraBonus = '';

        // dd($extraBonus);



        //   echo "<pre>";
        //   print_r($userData); die();
        $redirect = [];
        if ($request->has('update')) {
            $update = $this->notificationRepo->updateNotificationSeenStatus($request->notification_id);

            if ($request->has('history')) {
                $redirect[0] = 'history';
            }
        }
        $notifications = $this->notificationRepo->getNotification($user->uuid);

        return View('inpanel.redeem.new_mypoints')
            ->with('userPoints', $userpoint)
            ->with('user_point', $userPoints_head)
            ->with('redeemOptions', $redeemOptions)
            ->with('threshold_point', $threshold_value)
            ->with('redeem_requests', $redeem_requests)
            ->with('user_notifications', $notifications)
            ->with('redeemValue', $redeemValue)
            ->with('pendingReferralPoints', $pendingReferralPoints)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('completedSurveys', $user_completed_surveys)
            ->with('userActiveSurveys', $user_active_surveys)
            ->with('gift_cards', $gift_cards)
            ->with('tour_taken', $tour_taken)
            ->with('country_lang', $country_lang)
            ->with('multiplypoint', $multiplypoint)
            ->with('userExpireSurveys', $user_expire_surveys)
            ->with('user_count', $count_User)
            ->with('active_user_count', $active_user_count)
            ->with('redeem_history', $redeem_history)
            ->with('user', $user)
            ->with('history', $redirect)
            ->with('users_Points', $users_Points)
            ->with('userActivities',$user_activity)
            ->with('userrefer',$userData)
            ->with('user_id',$user_id)
            ->with('count_completed_assignments',$count_completed_assignments)
            ->with('tour_taken',$tour_taken)
            ->with('joining_bonus',$joining_bonus)
            ->with('extraBonus',$extraBonus)
            ->with('countryPoints',$countryPoints)
            ->with('currentCountry',$currentCountry)
            ->with('currencies',$currencies);
    }




    public function getRedeemHistory(Request $request)
    {
        $user = Auth::user();

        /* $userPoints = $user->point()->first();*/
        //  $userPoints = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        //  $userCountryId = $user->country;
        //  $redeemOptions = RedeemOption::where('status', '=', 'active')->where('country_id','=',240)->get();
        // $threshold_value = config('app.points.metric.threshold_points');
        // if(empty($userPoints)){
        //     $userPoints = false;
        //     $userpoint = false;
        // }else{
        //     $userpoint = $userPoints->user_points;
        // }
        $redeem_requests = RequestRedeem::where('user_uuid', '=', $user->uuid)->get();
        //  $gift_cards = RedeemOption::where('country_code','=',$user->country_code)->get();
        //  $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        //  $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken : 0;
        // $tour_taken=0;
        // if($tour_detail){
        //     foreach ($tour_detail as $key => $value){
        //         if($value['section']=='redeem-points' && $value['taken']==true){
        //             $tour_taken=1;
        //         }
        //     }
        // }
        if ($request->has('update')) {
            $update = $this->notificationRepo->updateNotificationSeenStatus($request->notification_id);
        }
        return View('inpanel.redeem.redeemhistory')
            //  ->with('userPoints', $userpoint)
            // ->with('redeemOptions', $redeemOptions)
            ->with('redeem_requests', $redeem_requests)
            //  ->with('gift_cards',$gift_cards)
            //  ->with('tour_taken',$tour_taken)
        ;
    }

    public function dataTableRedeemHistory()
    {
        $user = Auth::user();
        date_default_timezone_set($user->timezone);
        $data = Laratables::recordsOf(RequestRedeem::class, function ($query) {
            $user = Auth::user();
            return $query->where('user_uuid', '=', $user->uuid)->whereNotNull('coupon_redeemed')->orderBy('created_at', 'DESC');
        });

        return $data;
    }

    /**
     * This action is used to put the redeem requests by the User.
     *
     * SendRedeemRequest action for sending thr request
     * for redeem points to the admin and Super Admin and
     * sending the mail to the user, admin & super admin
     * and also check that User has requested points that is less than his total points
     *
     *
     * @param RedeemRequest $request
     * @return mixed
     */
    public function sendRedeemRequest(RedeemRequest $request)
    {

        $user = Auth::user();
        // $this->userBackRepo->thresoldAlert($user);
        // die;
        $recipients = ['amarjitm@samplejunction.com',
                      'rajann@samplejunction.com','rohinic@samplejunction.com','rameshk@samplejunction.com'];
        // $recipients = ['anil.samplejunction@gmail.com', 'virenk@samplejunction.com'];
        $input = $request->except(['_token']);
        $action = $request->action_id;
        $msg = '';
        $redeem_points = $request->input('request_points', false);

        if (!$redeem_points) {
            return \Redirect::back()->withFlashDanger("Please Provide the details for redeem points");
        }

        $redeem_requests = RequestRedeem::where('user_uuid', '=', $user->uuid)->where('status', '=', 'pending')->first();
        if($action == '0'){
            if($redeem_requests){
                return \Redirect::back()->withFlashDanger(__("inpanel.redeem.already_request_error"));
            }
        }
        /* Parshant Sharma [04-09-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
        /* Parshant Sharma [04-09-2024] Ends */
        /* *Code Added by Anil */
        $stateToRegionMapping = [
            // Northeast
            "CT" => "Northeast",
            "ME" => "Northeast",
            "MA" => "Northeast",
            "NH" => "Northeast",
            "RI" => "Northeast",
            "VT" => "Northeast",
            "NJ" => "Northeast",
            "NY" => "Northeast",
            "PA" => "Northeast",
            "DE" => "Northeast", // Delaware
            "MD" => "Northeast", // Maryland
            "DC" => "Northeast", // District of Columbia
            "WV" => "Northeast", // West Virginia

            // South
            "VA" => "South",
            "NC" => "South",
            "SC" => "South",
            "GA" => "South",
            "FL" => "South",
            "AL" => "South",
            "MS" => "South",
            "TN" => "South",
            "KY" => "South",
            "LA" => "South",
            "AR" => "South",
            "OK" => "South",
            "TX" => "South",

            // Midwest
            "OH" => "Midwest",
            "MI" => "Midwest",
            "IN" => "Midwest",
            "IL" => "Midwest",
            "WI" => "Midwest",
            "MN" => "Midwest",
            "IA" => "Midwest",
            "MO" => "Midwest",
            "KS" => "Midwest",
            "NE" => "Midwest",
            "SD" => "Midwest",
            "ND" => "Midwest",

            // West
            "WA" => "West",
            "OR" => "West",
            "CA" => "West",
            "NV" => "West",
            "ID" => "West",
            "MT" => "West",
            "WY" => "West",
            "CO" => "West",
            "UT" => "West",
            "AZ" => "West",
            "NM" => "West",
            "AK" => "West",
            "HI" => "West",

            // India
            /*"AP" => "India",
        "AR" => "India",
        "AS" => "India",
        "BR" => "India",
        "CG" => "India",
        "GA" => "India",
        "GJ" => "India",
        "HR" => "South West",
        "GJ" => "West",
        "GJ" => "India",
        "DL" => "North",
        "WB" => "East" ,
        "CH" => "North",*/
        ];

        $currencies = array(
            'countryPoints' => $countryPoints,
            'currency_denom_singular' => __($countryPoint->currency_denom_singular),
            'currency_denom_plural' => __($countryPoint->currency_denom_plural),

        );

        $thresholdCountry = 'PANEL_REDEEMPTIOM_THRESHOLD_POINTS_' . strtoupper($user->country);
        $getThresholdValue = setting::where('key', '=', $thresholdCountry)->first();
        if ($getThresholdValue) {
            $calPoints = $getThresholdValue->value;
        } else {
            $calPoints = ($user->country == 'IN') ? ($countryPoints * 5 * 40) : $countryPoints * 5;
        }
        $metricConversion = 1 / $countryPoints;
        $totalEarnedAmount = '';
        if ($redeem_points * $metricConversion < 1) {
            if ($user->country_code == 'IN') {
                $totalEarnedAmount = $countryPoint->currency_symbols . '' . number_format($redeem_points * $metricConversion, 2);
            } else {
                $currency = ($redeem_points * $metricConversion * 100 > 1)
                    ? $currencies['currency_denom_plural']
                    : $currencies['currency_denom_singular'];
                $totalEarnedAmount = number_format($redeem_points * $metricConversion * 100, 2) . '' . __($currency);
            }
        } else {
            $totalEarnedAmount = $countryPoint->currency_symbols . '' . number_format($redeem_points * $metricConversion, 2);
        }
        /* *End Code Added by Anil */


        $user_uuid = $user->uuid;
        $user_add_data = UserAdditionalData::where('uuid', '=', $user_uuid)->first();
        $user_points = $user_add_data->user_points;
        $total_points = $user_points['completed'];
        $data = [
            'redeem_points'  => $redeem_points,
            'country_points' => $countryPoints,
            'redeem_method'  => 'Select from rybbon reward page',
        ];
        
        if ($redeem_points <= $total_points) {
            if ($action == '0' || $action == '1') {
                if ($action == '1') {
                    $this->redeemRepo->deleteRedeemRequest($user_uuid);
                    $msg = __('inpanel.redeem.success_2');
                } else {
                    $msg = __('inpanel.redeem.success');
                }
                $create_redeem_request = $this->redeemRepo->createRedeemRequest($user_uuid, $total_points, $data);
                
                // Platform Tracking code added by Vikas(Code Starting)
                $this->userRepository->storePlatForm($user_uuid,'web','redemption_request',$create_redeem_request->id);
                // Platform Tracking (Code Ending)

                $user_panelist_address = DB::table('panellist_address')
                    ->where('user_id', $user->id)
                    ->first();
                if ($user_panelist_address) {
                    $state = $user_panelist_address->state;
                } else {
                    $state = $this->getStateFromZipCode($user->zipcode, $user->country, $user->panellist_id, $stateToRegionMapping);
                }
                event(new UserRedeemRequest($user, $create_redeem_request));
                $request_data = [$redeem_points];
                MailHelper::sendCustomMail(auth()->user(), $recipients, 'Panel Manager Redemption Request', $request_data, $totalEarnedAmount, $redeem_points, $state);
            } else {
                $this->redeemRepo->deleteRedeemRequest($user_uuid);
                $msg = __('inpanel.redeem.success_3');
            }
            return \Redirect::back()->withFlashSuccess($msg);
        } else {
            return \Redirect::back()->withFlashDanger(__('inpanel.redeem.error'));
        }
    }
    private function getStateFromZipCode(
        $zipcode,
        $country,
        $panellist_id,
        $stateToRegionMapping
    ) {
        $country_code = "";
switch (strtoupper($country)) {
    case "US":
        $country_code = "US";
        $zipcode = rawurlencode($zipcode);
        break;

    case "IN":
        $country_code = "IN";
        $zipcode = rawurlencode($zipcode);
        break;

    case "UK":
    case "GB":
        $country_code = "GB";
        $zipcode_parts = explode(' ', trim($zipcode));
        $zipcode = rawurlencode($zipcode_parts[0]);
        break;

    case "CA":
        $country_code = "CA";
        $zipcode_parts = explode(' ', trim($zipcode));
        $zipcode = rawurlencode($zipcode_parts[0]);
        break;

    default:
        $country_code = "US";
        $zipcode = rawurlencode($zipcode);
        break;
}
        if ($country_code != 'IN') {
            $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";
        } else {
            $url = "https://api.postalpincode.in/pincode/{$zipcode}";
        }
        // print_r($url);die;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            return null;
        }
        $data = json_decode($response, true);
        if ($country_code == 'IN') {
            if (isset($data[0]['PostOffice'][0])) {
                $state = $data[0]['PostOffice'][0]['State'];
                return $state;
            } else {
                return null;
            }
        } else {
            if (isset($data["places"][0])) {
                $state = $data["places"][0]["state"];
                return $state;
            } else {
                return null;
            }
        }

        curl_close($ch);
    }
}
