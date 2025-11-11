<?php

namespace App\Http\Controllers\Backend\Auth\Setting;

use App\Models\Auth\User;
use App\Models\Setting\Setting;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Profiler\ProfileSection;
use App\Repositories\Inpanel\Profiler\DetailedProfileRepository;
use App\Models\Redeem\RequestRedeem;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Inpanel\Traffic\TrafficRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Models\Referral\ReferralProgram;
use App\Models\StaticAchievement;
use App\Models\Project\surveyGallery;
use DB;

/**
 * Class SettingController.
 */
class SettingController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository,TrafficRepository $trafficRepo, DetailedProfileRepository $detailedProfileRepo)
    {
        $this->userRepository = $userRepository;
        $this->trafficRepo = $trafficRepo;
        $this->detailedProfileRepo = $detailedProfileRepo;
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function activeFraudSetting(Request $request)
    {
        if($request->input()){
            //print_r($request->all()); die;
            Setting::where('key','PANEL_ACTIVE_MONTH_LIMIT')->update(['value'=>$request->input('month_limit')]);
            Setting::where('key','PANEL_FRAUD_LIMIT')->update(['value'=>$request->input('fraud_limit')]);
            Setting::where('key','PANEL_POPUP_DASHBOARD_MONTH_LIMIT')->update(['value'=>$request->input('popup_month_limit')]);
            return \Redirect::back()
            ->withFlashSuccess("Setting Updated Successfully");
        }
       


        $activeSetting = Setting::where('key','PANEL_ACTIVE_MONTH_LIMIT')->first();
        $fraudSetting = Setting::where('key','PANEL_FRAUD_LIMIT')->first();
        $popupMonthSetting = Setting::where('key','PANEL_POPUP_DASHBOARD_MONTH_LIMIT')->first();
        return view('backend.auth.setting.active_fraud_setting')
           ->with('activeSetting',$activeSetting)
           ->with('fraudSetting',$fraudSetting)
           ->with('popupMonthSetting',$popupMonthSetting);
    }


    public function pull_invite_duration(){

        $livesurveys = DB::table('projects')->where('survey_status_code','=','LIVE')
                                            ->select('apace_project_code','country_code','created_at','updated_at','survey_status_code')->orderBy('id', 'desc')->get();

        $zero_pull_invite_surveys = DB::table('survey_pull_invites')->select('apace_survey_code','invite_duration')->get();

        // echo "<pre>";
        // print_r($livesurveys); die();                
 
        
        return view('backend.auth.setting.pull_invite_duration')
           ->with('livesurveys',$livesurveys)
           ->with('zero_pull_invite_surveys',$zero_pull_invite_surveys);
    }

    public function pull_invite_duration_save(Request $request){

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
            $survey = $request->input('query');

            $duration = 0;
            $project = 'null';

            $data = ['invite_duration' => $duration, 'apace_survey_code' => $survey, 'project_id' => $project];

            DB::TABLE('survey_pull_invites') -> updateOrInsert($data);

            return response()->json(['data' => $survey]);

            
        }     

    }

    
    public function pull_invite_duration_delete(Request $request){

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
            $survey = $request->input('query');

            DB::TABLE('survey_pull_invites')->where('apace_survey_code', $survey)->delete();

            return response()->json(['data' => 'Deleted']);

            
        }     

    }

    public function pointSystemSetting(Request $request)
    {
        if($request->input()){
            
            //print_r($request->all()); die;
            Setting::where('key','PANEL_SIGNUP_POINTS')->update(['value'=>$request->input('signup_points')]);
            Setting::where('key','PANEL_ACCOUNT_ACTIVATION_POINTS')->update(['value'=>$request->input('account_activation')]);
            if($request->input('signup_points')){
                StaticAchievement::where('code','=','account_created')->update(['points'=>$request->input('signup_points')]);
            }
            if($request->input('account_activation')){
                StaticAchievement::where('code','=','user_joined')->update(['points'=>$request->input('account_activation')]);
            }
            if($request->input('basic_profile')){
                StaticAchievement::where('code','=','basic_details_filled')->update(['points'=>$request->input('basic_profile')]);
            }

            Setting::where('key','PANEL_TECHNOLOGY_POINTS')->update(['value'=>$request->input('technology_profile')]);
            Setting::where('key','PANEL_HEALTH_FOOD_POINTS')->update(['value'=>$request->input('helthfood_profile')]);
            Setting::where('key','PANEL_INTERNET_GAMES_POINTS')->update(['value'=>$request->input('internet_profile')]);
            Setting::where('key','PANEL_TRAVEL_LEISURE_POINTS')->update(['value'=>$request->input('travel_profile')]);
            Setting::where('key','PANEL_EMPLOYMENT_POINTS')->update(['value'=>$request->input('employment_profile')]);
            Setting::where('key','PANEL_AUTOMOTIVE_POINTS')->update(['value'=>$request->input('automotive_profile')]);
            Setting::where('key','PANEL_FAMILY_POINTS')->update(['value'=>$request->input('family_profile')]);
            Setting::where('key','PANEL_MY_PROFILE_POINTS')->update(['value'=>$request->input('my_profile')]);
            Setting::where('key','PANEL_BASIC_PROFILE_POINTS')->update(['value'=>$request->input('basic_profile')]);
            Setting::where('key','PANEL_SOCIAL_PROFILE_POINTS')->update(['value'=>$request->input('social_profile')]);
            Setting::where('key','PANEL_PROFILE_IMAGE_POINTS')->update(['value'=>$request->input('profile_image')]);
            Setting::where('key','PANEL_EMAIL_INVITE_CHECK')->update(['value'=>$request->input('email_invite')]);
            Setting::where('key','PANEL_FRIEND_REFERRAL_POINTS')->update(['value'=>$request->input('friend_referral')]);
            if($request->input('friend_referral')){
                ReferralProgram::where('id',1)->update(['points'=>$request->input('friend_referral')]);
            }
            //Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->update(['value'=>$request->input('redeemption_threshold')]);
            Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_US')->update(['value'=>$request->input('redeemption_threshold_US')]);
            Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_UK')->update(['value'=>$request->input('redeemption_threshold_UK')]);
            Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_CA')->update(['value'=>$request->input('redeemption_threshold_CA')]);
            Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_IN')->update(['value'=>$request->input('redeemption_threshold_IN')]);
            Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_AU')->update(['value'=>$request->input('redeemption_threshold_AU')]);
            Setting::where('key','REMINDER_INVITE_TIME')->update(['value'=>$request->input('reminder_invite_time')]);
            Setting::updateOrCreate(['key' => 'PROFILE_UPDATE_TIME'], ['value' => $request->input('profile_update_time')]);
            // Setting::where('key','PANEL_REDEEMPTIOM_MULTIPLY_POINTS')->update(['value'=>$request->input('redeemption_multiply')]);
            //for update profile section master in mongodb
            $arrayUpdateData = array("BASIC"=>$request->input('basic_profile'),"MY_PROFILE"=>$request->input('my_profile'),"FAMILY"=>$request->input('family_profile'),"AUTOMOTIVE"=>$request->input('automotive_profile'),"EMPLOYMENT"=>$request->input('employment_profile'),"TRAVEL_/_LEISURE"=>$request->input('travel_profile'),"INTERNET_/_GAMES_/_SPORTS"=>$request->input('internet_profile'),"HEALTH_/_FOOD"=>$request->input('helthfood_profile'),"TECHNOLOGY"=>$request->input('technology_profile'));

            // echo '<pre>';
             foreach($arrayUpdateData as $key=>$value){
                 // print_r($key); echo"<br>";
                 // print_r($value);
 
                 ProfileSection::where('general_name',$key)->update(['points'=>$value]);
             } 

            return \Redirect::back()
            ->withFlashSuccess("Point System Updated Successfully");
        }
       
        

        $signupPoints               = Setting::where('key','PANEL_SIGNUP_POINTS')->first();
        $accountActivation          = Setting::where('key','PANEL_ACCOUNT_ACTIVATION_POINTS')->first();
        $technologyPoints           = Setting::where('key','PANEL_TECHNOLOGY_POINTS')->first();
        $healthfoodPoints           = Setting::where('key','PANEL_HEALTH_FOOD_POINTS')->first();
        $internetPoints             = Setting::where('key','PANEL_INTERNET_GAMES_POINTS')->first();
        $travelLeisurePoints        = Setting::where('key','PANEL_TRAVEL_LEISURE_POINTS')->first();
        $employmentPoints           = Setting::where('key','PANEL_EMPLOYMENT_POINTS')->first();
        $automativePoints           = Setting::where('key','PANEL_AUTOMOTIVE_POINTS')->first();
        $familyPoints               = Setting::where('key','PANEL_FAMILY_POINTS')->first();
        $myProfilePoints            = Setting::where('key','PANEL_MY_PROFILE_POINTS')->first();
        $basicProfilePoints         = Setting::where('key','PANEL_BASIC_PROFILE_POINTS')->first();
        $socialProfilePoints        = Setting::where('key','PANEL_SOCIAL_PROFILE_POINTS')->first();
         $prfileImagePoints          = Setting::where('key','PANEL_PROFILE_IMAGE_POINTS')->first();
        $emailInviteCheck           = Setting::where('key','PANEL_EMAIL_INVITE_CHECK')->first();
        $frienfReferralPoints       = Setting::where('key','PANEL_FRIEND_REFERRAL_POINTS')->first();
        //$redeemptionThresholdPoints = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->first();
        $redeemptionThresholdPoints_US = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_US')->first();
        $redeemptionThresholdPoints_UK = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_UK')->first();
        $redeemptionThresholdPoints_CA = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_CA')->first();
        $redeemptionThresholdPoints_IN = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_IN')->first();
        $redeemptionThresholdPoints_AU = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS_AU')->first();
        $redeemptionMultiplyPoints  = Setting::where('key','PANEL_REDEEMPTIOM_MULTIPLY_POINTS')->first();
        $reminderInviteTime         = Setting::where('key','REMINDER_INVITE_TIME')->first();
        $profileUpdateTime         = Setting::where('key','PROFILE_UPDATE_TIME')->first();

        return view('backend.auth.setting.point_system_setting')
               ->with('signupPoints',$signupPoints)
               ->with('accountActivation',$accountActivation)
               ->with('technologyPoints',$technologyPoints)
               ->with('healthfoodPoints',$healthfoodPoints)
               ->with('internetPoints',$internetPoints)
               ->with('travelLeisurePoints',$travelLeisurePoints)
               ->with('employmentPoints',$employmentPoints)
               ->with('automativePoints',$automativePoints)
               ->with('familyPoints',$familyPoints)
               ->with('myProfilePoints',$myProfilePoints)
               ->with('profileImagePoints' , $prfileImagePoints)
               ->with('emailInviteCheck' , $emailInviteCheck)
               ->with('basicProfilePoints',$basicProfilePoints)
               ->with('socialProfilePoints',$socialProfilePoints)
               ->with('frienfReferralPoints',$frienfReferralPoints)
               //->with('redeemptionThresholdPoints',$redeemptionThresholdPoints)
               ->with('redeemptionThresholdPoints_US',$redeemptionThresholdPoints_US)
               ->with('redeemptionThresholdPoints_UK',$redeemptionThresholdPoints_UK)
               ->with('redeemptionThresholdPoints_CA',$redeemptionThresholdPoints_CA)
               ->with('redeemptionThresholdPoints_IN',$redeemptionThresholdPoints_IN)
               ->with('redeemptionThresholdPoints_AU',$redeemptionThresholdPoints_AU)
               ->with('redeemptionMultiplyPoints',$redeemptionMultiplyPoints)
               ->with('reminderInviteTime',$reminderInviteTime)
               ->with('profileUpdateTime',$profileUpdateTime);
    }
	
	/*****
		Developer : Parshant Sharma 
		Date  : 05-03-2024
		This function is used to fetch the top three Panelist for LUCKY DRAW		
	*****/

	public function surveyLuckyDraw(Request $request)
	{
		/* if($request->input()){			
			
			//print_r($request->all()); die;
			Setting::where('key','PANEL_ACTIVE_MONTH_LIMIT')->update(['value'=>$request->input('month_limit')]);
			Setting::where('key','PANEL_FRAUD_LIMIT')->update(['value'=>$request->input('fraud_limit')]);
			Setting::where('key','PANEL_POPUP_DASHBOARD_MONTH_LIMIT')->update(['value'=>$request->input('popup_month_limit')]);
			return \Redirect::back()
			->withFlashSuccess("Setting Updated Successfully"); 
		}*/
		$activeSetting = Setting::where('key','PANEL_ACTIVE_MONTH_LIMIT')->first();
		return view('backend.auth.setting.survey_lucky_draw')
		   ->with('activeSetting',$activeSetting); 
	}	
	public function panelistUpload(Request $request)
    {
        $datas = surveyGallery::all();
        return view('backend.auth.setting.upload_page')->with('datas',$datas);
    }

}