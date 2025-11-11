<?php

namespace App\Http\Controllers\Inpanel\Survey;

use App\Events\Inpanel\Project\ProfileSurveyAttempted;
use App\Events\Inpanel\Project\ProfileSurveyComplete;
use App\Events\Inpanel\Project\StartSurvey;
use App\Http\Controllers\Inpanel\DashboardController;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use Illuminate\Support\Facades\Session;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use App\Repositories\Inpanel\Project\ProjectRepository;
use Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Inpanel\Traffic\TrafficStatuses;

use Carbon\Carbon;
use DB;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
/**
 * This class is used for handling Survey Functionality to take survey, view the available surveys, completed surveys.
 *
 * Class SurveyController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\Survey\SurveyController
 */

class SurveyController extends Controller
{

    /**
     * @param TrafficStatuses
     * @param $userRepository,$projectRepo
     */
    use TrafficStatuses;
    protected $userRepository, $projectRepo, $profileSectionRepo,$notificationRepo, $countriesCurrenciesRepository;

    /**
     * SurveyController constructor.
     *
     * @param UserRepository $userRepository
     * @param ProjectRepository $projectRepo
     */
    public function __construct(UserRepository $userRepository, ProjectRepository $projectRepo, ProfileSectionRepository $profileSectionRepo, UserNotificationRepository $notificationRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->userRepository = $userRepository;
        $this->projectRepo = $projectRepo;
        $this->profileSectionRepo = $profileSectionRepo;
        $this->notificationRepo = $notificationRepo;
		$this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }

    /**
     * This action is used to redirect the user to the view of Survey Index page where
     * user can check all the available surveys and could take surveys.
     *
     * @return resource survey/index.blade.php
     */
    public function index(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        $country_lang = $user->locale;
        if($request->get('sort')){
            //print_r($request->get('sort'));die;
            $sorting = $request->get('sort');
            $surveys = $userProject = $this->projectRepo->getActiveUserProjectByUserId($user->id,$sorting);
        }else{
            $surveys = $userProject = $this->projectRepo->getActiveUserProjectByUserId($user->id); 
        }
		
		//dd(count($surveys));

        $userRoles = $user->roles->pluck('name')->toArray();

        // echo '<pre>';
        // print_r($surveys); die();

        $timezone=$user->timezone;

        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
       
        $hsurveys = $userProject = $this->projectRepo->getUserTakenSurveys($user->id);

        $hstatus = $this->getTrafficStatuses($status_id = null);

                //27-9-23 SM

        $getAllUserTakenSurveys = $this->projectRepo->getAllUserTakenSurveys($user->id);
        //$getAllUserTakenSurveys=[];


    //    dd($surveys)->count;die;
        //$surveys = $userProject = $this->projectRepo->getActiveUserProjectByUserId($user->id);
        //$status = $this->getTrafficStatuses($status_id = null);

        $status =$hstatus;
        //$profile_repo = new ProfileSectionRepository();
        //Not in Use Comment By Ramesh [17-07-2025]
        //$detailed_profile_survey = $profile_repo->getDetailedProfileSurvey();
        $detailed_profile_survey=[];
         //echo"<pre>";
       //print_r($detailed_profile_survey);
        //exit;
        //$user_activity_info = Activity::causedBy($user)->where('description','inpanel.activity_log.log_in')->take(1)->orderBy('created_at','desc')->first();
        $user_activity_info =[];
        //print_r($user_activity_info);
        //exit;

        //$user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_assign_projects =[];

        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        // echo '<pre>';
        // print_r($user_expire_surveys); die();
        
         //$user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_completed_surveys=[];
         $get_user_add_data = UserAdditionalData::where('uuid','=',auth()->user()->uuid)->first();


        // $user_points = $this->userRepository->getUserPoints($user);

           $userPoints = $get_user_add_data->user_points['completed'];
          
          $fetch_user_achievement1 = $get_user_add_data->user_achievement;
           $active_user_count=count($fetch_user_achievement1);
           //$updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
           $updated_user_add_data =$get_user_add_data;

           $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
           if(!empty($fetch_user_achievement)){
            $count_User=count(@$fetch_user_achievement);
            }else{
            $count_User=0;
            }

           // $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);

            $redirect = [];
        if($request->has('update')){
            $notification_ids = $request->notification_id;
            // echo '<pre>';
            // print_r($notification_ids);die();
            foreach($notification_ids as $not_id){
                $update = $this->notificationRepo->updateNotificationSeenStatus($not_id);
            }
            
            if($request->has('history')){
                $redirect[0] = 'history'; 
            }
            
        }

            $notifications = $this->notificationRepo->getNotification($user->uuid); 

        //$notifications =[];

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
         //echo "insie" ;
         //exit;		
		/* Parshant Sharma [22-08-2024] Ends */			
         // echo "insie" ;
         //exit;  
         return view('inpanel.survey.new_survey', compact('surveys','detailed_profile_survey'))
            ->with('status',$status)
            ->with('completedSurveys',$user_completed_surveys)
            ->with('allUserSurveys',$user_assign_projects)
            ->with('activity',$user_activity_info)
            ->with('user_expire_surveys',$user_expire_surveys)
            ->with('timezone',$timezone)
            ->with('status',$hstatus)
            ->with('user_notifications' , $notifications)
            ->with('hsurveys',$hsurveys)
            ->with('user_point' , $userPoints)
            ->with('history',$redirect)
            ->with('userExpireSurveys',$user_expire_surveys)
            ->with('active_user_count' , $active_user_count)
            ->with('user_count' , $count_User)
            ->with('country_lang',$country_lang)
            ->with('currentCountry',$currentCountry)
            ->with('getAllUserTakenSurveys' , $getAllUserTakenSurveys)
            ->with('attemptedSurvey',$user_attempted_surveys)
            ->with('userRole',$userRoles)
			->with('countryPoints',$countryPoints)
            ->with('currencies',$currencies);


            
    }

    /**
     * This action is used to redirect to the view of History of all the surveys that had been taken.
     *
     * @return resource survey/history.blade.php
     */
    public function history()
    {
        $user = auth()->user();
        
         $timezone=$user->timezone;
       
        $surveys = $userProject = $this->projectRepo->getUserTakenSurveys($user->id);
        $status = $this->getTrafficStatuses($status_id = null);
        return view('inpanel.survey.history', compact('surveys'))
        ->with('timezone',$timezone)
        ->with('status',$status);
    }

    /**
     * This action is used to handle the functionality of Starting the Surveys and redirecting the user
     * to the client redirect link.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @return $client_new_redirect_link
     */
    public function startSurvey(Request $request)
    {
        
        $user = auth()->user();
        $survey_id = $request->survey_id;
     
        Session::forget('status');
        if($user && $survey_id){
            
            $user_project_details = $this->projectRepo->getProjectDetails($survey_id,$user);
            
            // Platform Tracking code added by Vikas(Code Starting)
            if(!empty($user_project_details)){
                $this->userRepository->storePlatForm($user->uuid,'web','survey_participation',$user_project_details->apace_project_code);
            }else{
                return \Redirect::back()->withErrors('You have already attempted the survey. Please refresh the page.');
            }
            // Platform Tracking (Code Ending)

             //echo '<pre>';
            // print_r("aaaaaaa4545 : ".$user_project_details->project->isLive());die();
            if($user_project_details && $user_project_details->project->isLive()){
                $change_Status = $this->projectRepo->changeStatus($user_project_details);
                
                if($change_Status){
                    event(new ProfileSurveyAttempted($user));
                    $client_new_redirect_link = $this->projectRepo->getRedirectClientLink($user,$user_project_details);

             //echo '<pre>';
             //echo $client_new_redirect_link; die();
                    if($client_new_redirect_link){
            //             echo '<pre>';
            // print_r("aaaaaaa4545 : ".$user_project_details->project->isLive());die();
        //                 echo '<pre>';
        // print_r("aaaaaaa4545 : ".$client_new_redirect_link);die();
                        return redirect()->to($client_new_redirect_link);
                    }
                }
            }else{
                return \Redirect::back()
                    ->withErrors('You have already attempted the survey. Please refresh the page.');
            }
        }
    }

    /**
     * This action is used to handle the Functionality of end surveys by receiving the status and details of
     * the user and surveys and marking the status the status as per received.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function endSurvey(Request $request)
    {

        $sjpid = $request->input('sjpid', false);
        $user_data = explode('_',$sjpid);
        $user_project_code = $user_data[1];
        $user_uuid = $user_data[0];
        $status = $request->input('status', false);
        $checksum = $request->input('hash', false);
       // $checksum_validate = $this->hashValidate($checksum,$request->getRequestUri());
       $checksum_validate = true;
        $user = $this->projectRepo->getUserDetails($user_uuid);
        $project = $this->projectRepo->getProject($user_project_code);
        if($user && $project){
            $get_user_project = $this->projectRepo->getUserProject($user,$project);
            if($get_user_project){
                if(!$checksum_validate){
                    $status = 4;
                    $this->projectRepo->changeStatusQualityTerminate($get_user_project);
                }else{
                    if($status==1){
                        $this->projectRepo->changeStatusComplete($get_user_project);
                        $this->projectRepo->updateUserAchievements($user,$get_user_project);
                        event(new ProfileSurveyComplete($user));
                        //Added by RAS on 01.09.23 for notifications
                        // $this->notificationRepo->createNotification($req_data->user_uuid,'Redeem Request',$req_data->id,'4');
                        // $this->notificationRepo->createNotification($uuid,'New Survey',$project->apace_project_code,'7','Assigned');
                    } elseif ($status==2){
                        $this->projectRepo->changeStatusTerminate($get_user_project);
                    } elseif($status==3){
                        $this->projectRepo->changeStatusQuotaFull($get_user_project);
                    }
                }
                return view('inpanel.survey.survey_end_page')
                    ->with('user_project',$get_user_project)
                    ->with('status',$status);
            }
        }
        return redirect()->route('inpanel.survey.index');
    }

    private function hashValidate($checksum,$url)
    {
        $url_explode = explode('?',$url);
        $url_explode = explode('&',$url_explode[1]);
        foreach($url_explode as $i => $val){
            list($k, $v) = explode('=', $val);
            if(substr($val,-1)=='='){
                $v.='=';
            }
            $result[ $k ] = $v;
        }
        $parameters = $result;
        $checksumValue = $parameters[config('app.vvars.checksum')];
        //print_r($checksumValue); echo '<br>';
        $raw_url = '';
        $raw_url = explode( $checksumValue, $url)[0];
        //print_r($raw_url); echo '<br>';
        $raw_url = explode('&'.config('app.vvars.checksum').'='.$checksumValue, $url )[0];
        //print_r($raw_url); echo '<br>';
        $raw_url = explode('?', $raw_url)[1];
        //print_r($raw_url); echo '<br>';
        $SJChecksumValue = hash_hmac( 'sha1', $raw_url, 'r7UrrUpUyBX');
        //print_r($SJChecksumValue); echo '<br>';

        //print_r($checksumValue);die;
        if($SJChecksumValue !== $checksumValue){
            return false;
        }else{
            return true;
        }
    }
}
