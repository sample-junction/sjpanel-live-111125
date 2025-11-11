<?php

namespace App\Http\Controllers\Inpanel\Invite;

use App\Events\Inpanel\Auth\TestingEvent;
use App\Events\Inpanel\Auth\UserTour;
use App\Listeners\Inpanel\ReferralManage;
use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Repositories\Inpanel\ReferralProgram\ReferralProgramRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inpanel\Invite\EmailInviteRequest;
use App\Jobs\Inpanel\Invite\SendInvitationEmail;
use App\Models\Referral\ReferralLink;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use App\Models\Setting\Setting;
use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Mail\Inpanel\Invite\UserInviteSurveyComplete;
use Illuminate\Support\Facades\Mail;
use App\Models\Referral\ReferralRelationship;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;

/**
 * This class is used for handling all the Invite functionality
 * including refer friend, Show All the referral of the User.
 *
 * Class InviteController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\Invite\InviteController
 */


class InviteController extends Controller
{


    /**
     *
     * @var UserRepository
     * @var ReferralProgramRepository
     */
    protected $userRepository, $referralRepository,$notificationRepo, $countriesCurrenciesRepository;

    /**
     * InviteController constructor.
     *
     * @param UserRepository $userRepository
     * @param ReferralProgramRepository $referralRepository
     */
    public function __construct(UserRepository $userRepository, ReferralProgramRepository $referralRepository,ProfileSectionRepository $profileSectionRepo, UserNotificationRepository $notificationRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->userRepository = $userRepository;
        $this->referralRepository = $referralRepository;
        $this->profileSectionRepo = $profileSectionRepo;
        $this->notificationRepo = $notificationRepo;
		$this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }

    /**
     * This function return Invite Index view Page where user can refer
     * to his friend by sending the mail or by copying the referral link.
     *
     * @return resource invite/index.blade.php
     */

    public function index(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        //$locale = app()->getLocale();
        $user = auth()->user();
        $user_referral_link = $this->referralRepository->getUserReferralLink($user);

        $ref_code_rand = rand(10000,99999);
        $country_lang = $user->locale;

        // echo '<pre>';
        // print_r($user_referral_link); die();
        // print_r($user_referral_link->getLinkAttribute('1',$ref_code_rand)); die();

        $user_referral_data = ['user_id' => $user->id, 'ref_code' => $ref_code_rand];

        DB::TABLE('user_referral_codes')->insert($user_referral_data);

        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        $tour_detail = $get_user_add_data->user_tour_taken ?? [];

        $tour_taken = collect($tour_detail)->contains(function ($item) {
            return $item['section'] === 'invite.refer' && !empty($item['taken']);
        }) ? 1 : 0;
        
        $user_points = $this->userRepository->getUserPoints($user);

        $userPoints = $user_points->user_points['completed'];

        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);

        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);

        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);

        $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);

        //echo "<pre>";

        //print_r($user_attempted_surveys);exit();

        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);

        $user_activity1 = Activity::causedBy($user)->where('description','inpanel.activity_log.log_in')->take(1)->orderBy('created_at','desc')->get();

        // echo "<pre>";

        // print_r($user_activity1);exit();

        $fetch_user_achievement = $get_user_add_data->user_filled_profiles;

        if(!empty($fetch_user_achievement)){

            $count_User=count(@$fetch_user_achievement);

        }else{

            $count_User=0;

        }

        $detailed_profile_survey = $this->profileSectionRepo->getDetailedProfileSurvey();

        $fetch_user_achievement1 = $get_user_add_data->user_achievement;

        $active_user_count=count($fetch_user_achievement1);

        $get_referal_point = Setting::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();

        $email_sent_results = DB::table('invite_emails')->join('user_referral_codes','invite_emails.refer_code','=','user_referral_codes.ref_code')->where('user_referral_codes.user_id','=',$user->id)    
                                ->where('invite_emails.status','=','Yes')
                                ->select('invite_emails.*')
                                ->get();

        // echo '<pre>';
        // print_r($email_sent_results);die();

        $myreferrals = $this->referralRepository->getMyReferrals();
        // echo '<pre>';
        // print_r($myreferrals);die();


        $mails_to_proceed = array();

        foreach($myreferrals as $key => $mrs){

            $email_crs = DB::table('invite_emails')->where('email','=',$mrs['email'])
                                        ->select('invite_emails.email')
                                        ->get();

            if(count($email_crs) > 0){
                array_push($mails_to_proceed,$email_crs);
            }
        }


        $ref_methods = [];
        
        foreach($myreferrals as $myref){
            $tmp_ref_method = DB::table('referral_relationships') ->where('user_id','=', $myref['referred_user_id'])->first();
            array_push($ref_methods,$tmp_ref_method);                                                    
        }

        // $ref_methods = DB::table('referral_relationships')->join('referral_links','referral_links.id','=','referral_relationships.referral_link_id')
        //                                                   ->where('referral_links.user_id','=',$user->id)
        //                                                   ->select('referral_relationships.ref_method')
        //                                                   ->orderBy('referral_relationships.id','asc')
        //                                                   ->get();
        // echo '<pre>';
        // print_r(count($ref_methods). " " . count($myreferrals));die();

        foreach($mails_to_proceed as $key => $mtp){
            DB::table('invite_emails')->where('email','=',$mtp[0]->email)->update(['status' => 'Completed']);
        }

        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='invite.my-referral' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }

        $title_social_media = 'Join SJ Panel now and earn Referral bonus! Click the link below to get started and let the rewards roll in! You and me both will get refferal bonus. #SJPanel #ReferralProgram #EarnRewards #OnlineSurveys';
        $redirect = [];
        if($request->has('update')){
            $update = $this->notificationRepo->updateNotificationSeenStatus($request->notification_id);
            $redirect[0] = 'history'; 
        }     
        $notifications = $this->notificationRepo->getNotification($user->uuid); 
        //     echo '<pre>';
        // print_r($redirect);die();

		/* Parshant Sharma [22-08-2024] Starts */
		
		$locale = app()->getLocale();
		
		$countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);		
		$countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
		
		// Initialize an empty array
		$currencies = array();

		if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
			
			$cntry = explode('_',$countryPoint->country_language);
			
			$currencies = array(
				'currency_logo'  => $countryPoint->currency_symbols,
				'currency_denom_singular' => $countryPoint->currency_denom_singular,
				'currency_denom_plural' => $countryPoint->currency_denom_plural,
				'lang'=>$cntry[1],
			);
		} 
		/* Parshant Sharma [22-08-2024] Ends */
        
        return view("inpanel.invite.new_refer")
            ->with('invite_link', $user_referral_link)
            ->with('get_referal_point', $get_referal_point)
            ->with('user_add_data',$get_user_add_data)
            ->with('userPoints',$user_points)
            ->with('allUserSurveys',$user_assign_projects)
            ->with('completedSurveys',$user_completed_surveys)
            ->with('userActiveSurveys',$user_active_surveys)
            ->with('attemptedSurvey',$user_attempted_surveys)
            ->with('userExpireSurveys',$user_expire_surveys)
            ->with('detailed_profile_survey',$detailed_profile_survey)
            ->with('user_point' , $userPoints)
            ->with('active_user_count' , $active_user_count)
            ->with('user_count' , $count_User)
            ->with('myreferrals', $myreferrals)
            ->with('tour_taken', $tour_taken)
            ->with('ref_code_rand',$ref_code_rand)
            ->with('email_sent_results',$email_sent_results)
            ->with('ref_methods',$ref_methods)
            ->with('country_lang',$country_lang)
            ->with('user_notifications',$notifications)
            ->with('history',$redirect)
            ->with('title_social_media',$title_social_media)
            ->with('countryPoints',$countryPoints)
            ->with('currentCountry',$currentCountry)
            ->with('currencies',$currencies);
    }

    /**
     * Refer Action for the person being invited and when the referral
     * click on the Accept Invitation button in invite email or directly visit the referral link
     * provided by the referrer.
     *
     * In this function SJ_SECURE_CHECK_CODE cookie is first checked as the user is first redirected by
     * clicking the referral button or the referral link and if the cookie exist than he directly
     * redirected to the registration page but if not than first SJ_SECURE_CHECK_CODE cookie is stored
     * than redirected to register page
     *
     * @param Request $request
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     * @return mixed
     */

    public function showMyRefer(Request $request, $m, $ref, $code)
    {
        // echo $m;
        // exit;
        if($m == "2"){
            // return redirect()->route('frontend.auth.register');
                
            $referral = ReferralLink::whereCode($code)->first();
    
            Cookie::queue('SJ_SECURE_CHECK_CODE', $referral->id, $referral->lifetime_minutes);
            Cookie::queue('SJ_SECURE_METHOD_TYPE', $m, $referral->lifetime_minutes);
            Cookie::queue('SJ_SECURE_REF_CODE', $ref, $referral->lifetime_minutes);
            return redirect()->route('frontend.auth.register');

        }else{

            $referral = ReferralLink::whereCode($code)->first();
    
            Cookie::queue('SJ_SECURE_CHECK_CODE', $referral->id, $referral->lifetime_minutes);
            Cookie::queue('SJ_SECURE_METHOD_TYPE', $m, $referral->lifetime_minutes);
            Cookie::queue('SJ_SECURE_REF_CODE', $ref, $referral->lifetime_minutes);
            return redirect()->route('frontend.auth.register');
        }


    }

    /**
     * This action is used for sending the invite email to the Referral Person
     *
     * @param EmailInviteRequest $request
     * @return mixed
     */

     

    public function executeEmailInvite(Request $request)
    {

        // echo '<pre>';
        // print_r($request->all());die();

        $user = auth()->user();
         $ref_code = $request->get('refer_code');
        
        $referralLink = $this->referralRepository->getUserReferralLink($user)->getLinkAttribute('2',$ref_code);
       // print_r($referralLink); die;
        $referralFirstName = $request->input('name');
        $referralLastName = $request->input('lastname');
        $referralEmail = $request->input('email');
        
        // echo '<pre>';
        // print_r($referralEmail);die();
        // $referralEmail = $request->input('email');
        /**Added by RAS for sjpl80 */
        // foreach($referralEmail as $refmail){

        // }
        // $email_exist = DB::table('users')->where('email_hash',sha1($referralEmail))->first();
        
        // if($email_exist){
        //     return Redirect::back()->withFlashDanger(__('inpanel.activity_log.existing_email'));
        // }

        $invalid_email_new = 0;
        $success_email_new = 0;
        $failure_email_new = 0;
        $email_exist_count = 0;
        $err_emails = array();
        $email_exist = array();
        $err_flag = 0;
        foreach ($referralEmail as $x => $email) {

            $email_status = 'Yes';

            $get_unsubscribe_details = $user->checkUnsubscribedEmail($email);
            $get_referal_point = Setting::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();
            //Code Added By Ramesh Kamboj//
             $emailVaild=$this->CheckInviteEmail($email);
            
            if($emailVaild=='2'){
                $email_status = 'No';
                $invalid_email_new++;
                array_push($err_emails,$email);
                $err_flag = 1;
                continue;
            //    return Redirect::back()->withFlashDanger(__('inpanel.activity_log.invalid_email')); 
            }
            //End Here//
            $email_chk = DB::table('users')->where('email_hash',sha1($email))->first();
            if($email_chk){
                $email_exist_count++;
                array_push($email_exist,$email);
                $err_flag = 1;
                $email_status = 'No';
                continue;
            }
            if(!$get_unsubscribe_details){
                dispatch(new SendInvitationEmail($user  ,$referralLink, $referralFirstName[$x], $email,$get_referal_point));
                // return Redirect::back()->withFlashSuccess(__('inpanel.activity_log.invite_sent'));
                $success_email_new++;
            } else {
                // return Redirect::back()->withFlashDanger(__('inpanel.activity_log.danger_email'));
                $failure_email_new++;
                $email_status = 'No';
            }

            $user_email_invite_data = ['first_name' => $referralFirstName[$x], 'last_name' => $referralLastName[$x], 'email' => $email, 'status' => $email_status, 'refer_code' => $ref_code];
            // DB::enableQueryLog();
            try{
                DB::TABLE('invite_emails')->updateOrInsert($user_email_invite_data);
            }catch(\Exception $e){
                echo $e->getMessage();
            }
        //    $qry = DB::getQueryLog();
        //    if(!empty($qry)){
        //     $last = end($qry)['query'];
        //     echo '<pre>';
        //     print_r($last);die();
        //    }
            
        }

        $all_err_mail_list = '';

        foreach ($err_emails as $error_mail) {
            $all_err_mail_list .= $error_mail.' ';
        }
        $existing_mail_list = '';
        foreach ($email_exist as $existing){
            $existing_mail_list .= $existing.' ';
        }
        $msg = '';
        if($err_flag ){
            if($invalid_email_new > 0 ){
                $msg = $invalid_email_new.' '.__('inpanel.activity_log.invalid_email').' '.$all_err_mail_list;
            }
            
            if($email_exist_count > 0){
                $msg .= ' '.__('inpanel.activity_log.existing_email').' '.$existing_mail_list;
            }
            return Redirect::back()->withFlashDanger($msg);
        }

        else{
            return Redirect::back()->withFlashSuccess(__('inpanel.activity_log.invite_sent'));
        }
      
    }

    public function CheckInviteEmail($email){
        $key=config('settings.EMAIL_QUALITY_SCORE');
        $EMAIL_QUALITY_URL=config('settings.EMAIL_QUALITY_URL');
        $timeout = 1;
        $fast = 'false';
        $abuse_strictness = 0;
        // Create parameters array.
            $parameters = array(
                'timeout' => $timeout,
                'fast' => $fast,
                'abuse_strictness' => $abuse_strictness
            );
            // Format our parameters.
            $formatted_parameters = http_build_query($parameters);
            $url = sprintf(
            $EMAIL_QUALITY_URL.'/%s/%s?%s', 
            $key,
            urlencode($email),
            $formatted_parameters
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

            $json = curl_exec($curl);
            curl_close($curl);

            // Decode the result into an array.
            $result = json_decode($json, true);
           
            if(isset($result['success']) && $result['success'] === true){
                if($result['recent_abuse'] === false && ($result['valid'] === true || $result['timed_out'] === true && $result['disposable'] === false && $result['dns_valid'] === true))
                {
                    return  "0";
                } else {
                return  "2";
                }
            }
    }

    /**
     * This action is used to show all the referral of the User and redirect
     * to the view of Show my referral.
     *
     * @return resource invite/myreferrals/index.blade.php
     */
    public function showMyReferrals()
    {

        //send email for referred user
        // $get_referral_user = auth()->user();
        // $referred_name = "test invite";
        // $points =100;
        // $email = new UserInviteSurveyComplete($get_referral_user,$referred_name,$points);
        // Mail::send($email); 
        // echo "mail send"; die;
        
        //event(new UserAchievementUpdate(auth()->user())); die;

        $myreferrals = $this->referralRepository->getMyReferrals();
        //print_r($myreferrals);die;
        $get_user_add_data = UserAdditionalData::where('uuid','=',auth()->user()->uuid)->first();
        $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken: 0;
        $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='invite.my-referral' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
        return view("inpanel.invite.myreferrals.index")
            ->with('myreferrals', $myreferrals)
            ->with('tour_taken', $tour_taken);
    }
}
