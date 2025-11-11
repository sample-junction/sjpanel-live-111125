<?php
namespace App\Http\Controllers\Inpanel;

use App\Models\Country;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use App\Repositories\Inpanel\General\GeneralRepository;
use App\Models\Profiler\UserAdditionalData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use App\Models\Auth\User;
use Auth;
use App\Http\Requests\Inpanel\BasicProfileRequest;
// use App\Mail\Frontend\UserConfirm\ProfilePromptMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Auth\SjDfiqApiResponse;
use Response;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Mail;
use App\Events\Frontend\Auth\UserRegistered;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use Illuminate\Support\Facades\Crypt;

/**
 * This class is used for handling Update Preferences.
 *
 * Class BasicDetailController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\BasicDetailController
 */
class BasicDetailController extends Controller
{

    /**
     * @param $userRepository
     * @param $generalRepository
     */
    protected $userRepository, $generalRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     * @param GeneralRepository $generalRepository
     */
    public function __construct(UserRepository $userRepository, GeneralRepository $generalRepository, ProfileSectionRepository $profileSectionRepo)
    {
        $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
		$this->profileSectionRepo = $profileSectionRepo;
    }

    /**
     * This action to redirect the User to the view of
     * Filling the Basic Details after confirming the account.
     *
     * @return resource basic_details/index.blade.php
     */
    public function index()
    {
        $user = Auth::user();
        
        // echo '<pre>'; 
        // print_r($user);
        // print_r($user->email);
        // print_r($user->social_email);
        // die();
        
        $uuid = $user->uuid;
        
         $ip= request()->ip();
         $DFIQ=config('settings.dfiq.status');
         $geodata = geoip(request()->ip());

         $ipcountryCode = $geodata->getAttribute('iso_code');
        /* 
        * Language Section Start
        * Discription:- Set Language and country for logged in user , so that on panel 
        * dashboard it wouldn't be change
        */
      
  

        session()->put('locale', $user->locale);
        app()->setLocale($user->locale);
        setlocale(LC_TIME, $user->locale);
        
        $current_locale = explode('_', $user->locale);
        $current_lang = $current_locale[0];
        Carbon::setLocale($current_lang);
        /* Language Section Ends*/

        $countries = false;
        //if(empty($user->country)){
            $countries = $this->generalRepository->getActiveCountries();
        //}
            $user_activity = Activity::causedBy($user)->where('description','inpanel.activity_log.log_in')->take(1)->orderBy('created_at','desc')->first();
            $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
			$detailed_profile_survey = $this->profileSectionRepo->getDetailedProfileSurvey();
			$user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
			$user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
			$user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
			$user_active_surveys = $this->userRepository->getUserActiveSurveys($user);
			$user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
			$user_points = $this->userRepository->getUserPoints($user);
			$userPoints = $user_points->user_points['completed'];
			
			$active_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
            $fetch_user_achievement = $active_user_add_data->user_achievement;
            $active_user_count=count($fetch_user_achievement);
			if(!empty($fetch_user_achievement)){
                 $count_User=count($fetch_user_achievement);
             }else{
                $count_User=0;
             } 
        
        return view('inpanel.basic_detail.index')
            ->with('user', $user )
            ->with('countries', $countries )
            ->with('ip',str_replace('.','-',$ip))
            ->with('detailed_profile_survey',$detailed_profile_survey)
            ->with('uuid',$uuid)
            ->with('dfiq',$DFIQ)
             ->with('activity',$user_activity)
            ->with('completedSurveys',$user_completed_surveys)
            ->with('allUserSurveys',$user_assign_projects)
            ->with('userActiveSurveys',$user_active_surveys)
            ->with('attemptedSurvey',$user_attempted_surveys)
            ->with('user_points' , $userPoints)
			->with('userPoints',$user_points)
            ->with('userExpireSurveys',$user_expire_surveys)
			->with('active_user_count' , $active_user_count)
            ->with('user_count' , $count_User)
			->with('country_code',$ipcountryCode);
            /*->with(compact('countries'))*/;

    }

    /**
     * This action used for filling the basic profile details provided by the user
     * and also giving the user achievements points for filling it.
     *
     * @param BasicProfileRequest $request
     * @return mixed
     */
    
    public function update(BasicProfileRequest $request){
        
        if($request->has('is_partial')){

            $input = $request->only('dob');
            $dateformat=explode('-',$input['dob']);

            $user = Auth::user();
            $user->email = $request->get('user_email2');
            $user->save();

            $locales = [];
            if($user->is_social==1){
                if(!empty($input)){
                    //$date = Carbon::parse($input['dob'])->format('Y-m-d');
                    $request->merge(['dob' => $dateformat[0].'-'.$dateformat[1].'-'.$dateformat[2]]);
                }
            }else{
                if(!empty($input)){
                    // $date = Carbon::parse($input['dob'])->format('Y-m-d');
                    // $request->merge(['dob' => $date]);
                    $request->merge(['dob' => $dateformat[0].'-'.$dateformat[1].'-'.$dateformat[2]]);
                } 
            }
            $user_id = $request->user()->id;
            // if(!empty($request->get('device_preference'))){
            //     $device_preference = implode(',',$request->get('device_preference'));
            // }else{
            //     $device_preference = '1,2,3,4';
            // }
            
            $zipcodeFailedCount = $request->get('zipcode_counter');

            $inputs = $request->all();
            // echo '<pre>';print_r($inputs);die();
            //unset($request->input('device_preference'));
            $rand_code = md5(uniqid(mt_rand(), true));

            if($user->is_social==1){
                $email_hash=sha1($request->get('user_email1')); 
            }else{
                $email_hash=sha1($request->get('user_email2')); 
            }
            $filled_user_profile_details = [
                // 'filled_basic_details' => 1,
                // 'device_preference' => $device_preference,
                'zipcode'=>$request->get('zipcode1'),
                'gender'=>$request->get('gender1'),
                'email'=>$request->get('user_email2'),
                'email_hash'=>$email_hash,
                'social_email'=>$request->get('user_email1'),
                'confirmation_code' => $rand_code,
                'confirmed'         => config('access.users.requires_approval') || config('access.users.confirm_email') ? 0 : 1,
            ];

        

            $update_data = array_merge($inputs,$filled_user_profile_details);
            $lang = $request->input('language',false);

            $con = $request->input('country',false);
            if($con){
                $locales = [
                    'locale' => strtolower($lang).'_'.$con
                ];
                unset($update_data['language']);
            
            }

            $updated_data = array_merge($locales,$update_data);

            // echo '<pre>';print_r($updated_data);die();
            $output = $this->userRepository->update($user_id, $updated_data);

            /*--- modified by obhi--*/
            // $updatesocialEmail = ['social_email' => $request->user_email2,];
            // User::where('id', $user_id)->update($updatesocialEmail);
            /*--- modified by obhi--*/
        
            //$output = $this->userRepository->update( $user_id, $inputs);
            //  $promptMail = new ProfilePromptMail($user);
            // Mail::to($user->email)->send($promptMail);
            
            if ($user) {
                /*
                * Add the default site role to the new user
                */
                $user->assignRole(config('access.users.default_role'));
            }
                // print($user);exit();
            $check_invite_cookie = $this->userRepository->checkInviteCookieCode();
            $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
            $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');
                // event(new UserRegistered($user,$register_input_data));
            event(new UserRegistered($user,$updated_data));
            if($check_invite_cookie){

                $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
                $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');
                $this->userRepository->giveUserInvitePoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
                //Add code by vikash (29-11-2022)
                $this->userRepository->giveUserReferralPoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
                }
                session()->put('last_active', time());


            //Added by RAS for confirmation mail coming in english for spanish account issue 07-09-23
            app()->setLocale((!empty($request->session()->get('locale')))?$request->session()->get('locale'):'en_US');
            //end code by RAS 
            if (config('access.users.confirm_email')) {
                // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                $get_unsubscribe_details = $user->checkUnsubscribedEmail($user->email);
                if(!$get_unsubscribe_details){
                    \Log::info('User DOI Email Confirmed: '.$user->social_email);
                    $get_reffer_point = Setting::whereIn('key',['PANEL_SIGNUP_POINTS','PANEL_ACCOUNT_ACTIVATION_POINTS','PANEL_BASIC_PROFILE_POINTS'])->sum('value');
                    $email = new UserConfirmation($user,$rand_code,$get_reffer_point,0,1);
                    Mail::send($email);                    
                }
                    /* $user->notify(new UserNeedsConfirmation($user->confirmation_code));*/
            }
            
            if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
                activity()
                    ->causedBy($user)
                    ->log('inpanel.activity_log.registration');
                return view('frontend.auth.thank-you')->withFlashSuccess(
                        config('access.users.requires_approval') ?
                            __('exceptions.frontend.auth.confirmation.created_pending') :
                            __('exceptions.frontend.auth.confirmation.created_confirm')
                    );
            }
        }else{

            $input = $request->only('dob');
        
            $dobInput=explode(' ',$input['dob']);
            $dateformat = explode('-',$dobInput[0]);
            $user = Auth::user();

            $locales = [];
            if($user->is_social==1){
                if(!empty($input)){
                    //$date = Carbon::parse($input['dob'])->format('Y-m-d');
                    $request->merge(['dob' => $dateformat[0].'-'.$dateformat[1].'-'.$dateformat[2]]);
                }
            }else{
                if(!empty($input)){
                    // $date = Carbon::parse($input['dob'])->format('Y-m-d');
                    // $request->merge(['dob' => $date]);
                    $request->merge(['dob' => $dateformat[0].'-'.$dateformat[1].'-'.$dateformat[2]]);
                } 
            }
            $user_id = $request->user()->id;

            $check_invite_cookie = $this->userRepository->checkInviteCookieCode();
            $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
            $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');

            
            if(!empty($request->get('device_preference'))){
                $device_preference = implode(',',$request->get('device_preference'));
            }else{
                $device_preference = '1,2,3,4';
            }
            
            $zipcodeFailedCount = $request->get('zipcode_counter');

            $inputs = $request->all();
            
            //unset($request->input('device_preference'));
            if($user->is_social==1){
            $email_hash=sha1($request->get('user_email2')); 
            }else{
                $email_hash=sha1($request->get('user_email1')); 
            }
            $filled_user_profile_details = [
                // 'filled_basic_details' => 1,
                'device_preference' => $device_preference,
                'zipcode'=>$request->get('zipcode1'),
                'gender'=>$request->get('gender1'),
                'email'=>$request->get('user_email1'),
                'email_hash'=>$email_hash,
                'social_email'=>$request->get('user_email2'),
            ];
            $update_data = array_merge($inputs,$filled_user_profile_details);
        
            $lang = $request->input('language',false);
            $con = $request->input('country',false);
            if($con){
                $locales = [
                    'locale' => strtolower($lang).'_'.$con
                ];
                unset($update_data['language']);
            
            }

            $updated_data = array_merge($locales,$update_data);
            // echo 'Spre>';
            // print_r($update_data);die();
            $output = $this->userRepository->update($user_id, $updated_data);

            if($check_invite_cookie){
                $this->userRepository->giveUserInvitePoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
                //Add code by vikash (29-11-2022)
                $this->userRepository->giveUserReferralPoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
            }
            //echo $request->session()->get('locale');
            app()->setLocale((!empty($request->session()->get('locale')))?$request->session()->get('locale'):'en_US');
            //echo  __('strings.frontend.user.profile_updated');
            //exit;
            //$output = $this->userRepository->update( $user_id, $inputs);
            //  $promptMail = new ProfilePromptMail($user);
            // Mail::to($user->email)->send($promptMail);
            //echo $request->session()->get('locale');
            app()->setLocale((!empty($request->session()->get('locale')))?$request->session()->get('locale'):'en_US');
            //echo  __('strings.frontend.user.profile_updated');
            //exit;
            // return redirect()->route('inpanel.dashboard')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
            $uuid = $user->uuid;
            return redirect()->route('inpanel.basic.pro');
            
        
        }
         
    }

    public function getCountryLanguage(Request $request)
    {
        $country_code = $request->country_code;
        $language = $this->userRepository->getCountry($country_code);
        return response()->json($language);
    }
public function countryUpdate(Request $request){
    if($request->ajax()){
         $country_code=$request->get('country_code');
         $country=explode('_',$country_code);
         $user = Auth::user();
         $user_id = $user->id;
        session()->put('locale', $country_code);
        session()->put('country_update', 1);
         session()->get('locale');
        app()->setLocale($country_code);
        $locales = [
                'locale' => $country_code,
                'country'=>$country[1],
                'country_code'=>$country[1],

            ];
           
           
       

        //$updated_data = array_merge($locales,$update_data);
        
        $output = $this->userRepository->update($user_id, $locales);
        return Response::json(array(
                    'success' => true,
                    'data'   => '1'
                ));  
    }
}
    public function postDfiqData(Request $request){
        if($request->ajax()){
             
                $DFIQJSONData=$request->get('datajsondata')['forensic'];
                $requestId=$DFIQJSONData['requestId'];
                $deviceId=$DFIQJSONData['deviceId'];
                //property//
                /*$deviceType=$DFIQJSONData['property']['deviceType'];
                $isMobile=$DFIQJSONData['property']['isMobile'];
                $os=$DFIQJSONData['property']['os'];
                $platform=$DFIQJSONData['property']['platform'];
                $browser=$DFIQJSONData['property']['browser'];
                $hardwareName=$DFIQJSONData['property']['hardwareName'];
                $hardwareModel=$DFIQJSONData['property']['hardwareModel'];
                $hardwareVendor=$DFIQJSONData['property']['hardwareVendor'];
                $ipAddress=$DFIQJSONData['property']['ipAddress'];
                $domain=$DFIQJSONData['property']['domain'];
                //END Here//
                //frequency//
                $isEventUnique=$DFIQJSONData['unique']['isEventUnique'];
                $eventDupeId=$DFIQJSONData['unique']['eventDupeId'];
                $eventDupeDate=$DFIQJSONData['unique']['eventDupeDate'];
                $eventDupeReason=$DFIQJSONData['unique']['eventDupeReason'];
                //marker
                 $score=$DFIQJSONData['marker']['score'];
                 $invalidCount=$DFIQJSONData['marker']['invalidCount'];
                 $invalidLowCount=$DFIQJSONData['marker']['invalidLowCount'];
                 $invalidMediumCount=$DFIQJSONData['marker']['invalidMediumCount'];
                 $invalidHighCount=$DFIQJSONData['marker']['invalidHighCount'];
                 $invalidCriticalCount=$DFIQJSONData['marker']['invalidCriticalCount'];
                 $isKnownBrowser=$DFIQJSONData['marker']['isKnownBrowser'];
                 $isObsoleteBrowser=$DFIQJSONData['marker']['isObsoleteBrowser'];
                 $isKnownOs=$DFIQJSONData['marker']['isKnownOs'];
                 $isObsoleteOs=$DFIQJSONData['marker']['isObsoleteOs'];
                 $isKnownDeviceType=$DFIQJSONData['marker']['isKnownDeviceType'];
                 $isKnownUserAgent=$DFIQJSONData['marker']['isKnownUserAgent'];
                 $isKnownDomain=$DFIQJSONData['marker']['isKnownDomain'];
                 $isBot=$DFIQJSONData['marker']['isBot'];
                 $isBlacklisted=$DFIQJSONData['marker']['isBlacklisted'];
                 $isWhitelisted=$DFIQJSONData['marker']['isWhitelisted'];
                 $isAnonymous=$DFIQJSONData['marker']['isAnonymous'];
                 $anonymousReason=$DFIQJSONData['marker']['anonymousReason'][0];
                 $isTampered=$DFIQJSONData['marker']['isTampered'];
                 $isResist=$DFIQJSONData['marker']['isResist'];
                 $isVelocity=$DFIQJSONData['marker']['isVelocity'];
                 $isOscillating=$DFIQJSONData['marker']['isOscillating'];
                 $isBehavioral=$DFIQJSONData['marker']['isBehavioral'];
                 $isLang=$DFIQJSONData['marker']['isLang'];
                 $isGeoLang=$DFIQJSONData['marker']['isGeoLang'];
                 $isGeoOsLang=$DFIQJSONData['marker']['isGeoOsLang'];
                 $isGeoPostal=$DFIQJSONData['marker']['isGeoPostal'];
                 $isGeoCountry=$DFIQJSONData['marker']['isGeoCountry'];
                 $isGeoTz=$DFIQJSONData['marker']['isGeoTz'];
                 //geo
                 $city=$DFIQJSONData['geo']['city'];
                 $stateProvince=$DFIQJSONData['geo']['stateProvince'];
                 $countryCode=$DFIQJSONData['geo']['countryCode'];*/
                 //JSon Format//
                 $geo_json=json_encode($DFIQJSONData['geo']);
                 $marker_json=json_encode($DFIQJSONData['marker']);
                 $unique_json=json_encode($DFIQJSONData['unique']);
                 $property_json=json_encode($DFIQJSONData['property']);
                 //End Here//

                 $rId=$DFIQJSONData['rId'];
                 $SjDfiqApiResponse=new SjDfiqApiResponse();
                 $SjDfiqApiResponse->requestId=$requestId;
                 $SjDfiqApiResponse->deviceId=$deviceId;
                 $SjDfiqApiResponse->property=$property_json;
                 $SjDfiqApiResponse->unique_ip=$unique_json;
                 $SjDfiqApiResponse->marker=$marker_json;
                 $SjDfiqApiResponse->geo=$geo_json;
                 $SjDfiqApiResponse->rId=$rId;
                 $SjDfiqApiResponse->email=$request->get('email');
                 $SjDfiqApiResponse->ip_address=$request->get('ip_address');
                 $SjDfiqApiResponse->panelistId=$request->get('panelistId');
                 $SjDfiqApiResponse->save();
                 

               
            }
            return Response::json(array(
                    'success' => true,
                    'data'   => '1'
                ));  

    }
 //End Here//
    public function checkEmail(Request $request){
        $key=config('settings.EMAIL_QUALITY_SCORE');
        $EMAIL_QUALITY_URL=config('settings.EMAIL_QUALITY_URL');
        $email=$request->input('email');
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

    public function emailExist1(Request $request){
        $email=$request->input('email');
        $check_email = User::where('email_hash',sha1($email))->count();
        if ($check_email > 0) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    /**
     * This function is used to check Email exit in database or not.
     **/
    public function emailExist(Request $request)
    {
         $key=config('settings.EMAIL_QUALITY_SCORE');
         $EMAIL_QUALITY_URL=config('settings.EMAIL_QUALITY_URL');
         $email = $request->input('email',false);
       
         //$is_email = User::where('email',$email)->count();
        //  $is_email = User::where('email_hash',sha1($email))->count();
       $is_email = User::where('email_hash',sha1($email))
                    ->where(function($qry){
                        $qry->where('id','!=',auth()->user()->id);
                    })->count();
        //  return json_decode($is_email);
        //code Added By Ramesh Kamboj//
        /*
        * Set the maximum number of seconds to wait for a reply
        * from an email service provider. If speed is not a concern 
        * or you want higher accuracy we recommend setting this in 
        * the 20 - 40 second range in some cases. Any results which 
        * experience a connection timeout will return the "timed_out" 
        * variable as true. Default value is 7 seconds.
        */
        $timeout = 1;

        /*
            * If speed is your major concern set this to true, 
            * but results will be less accurate.
            */
        $fast = 'false';
        /*
        * Adjusts abusive email patterns and detection rates
        * higher levels may cause false-positives (0-2)
        */
        $abuse_strictness = 0;
       
        if($is_email==0){
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
                // return  "0";
                return response()->json(['status' => 0]);
             } else {
            //    return  "2";
               return response()->json(['status' => 2]);
             }
            }


        }else{ 
        //   return $is_email;
          return response()->json(['status' => 200]);

       }
        //End Here//
        

    }


}
