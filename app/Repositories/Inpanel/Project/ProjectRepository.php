<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 08-04-2019
 * Time: 04:56 PM
 */

namespace App\Repositories\Inpanel\Project;

use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Events\Inpanel\Auth\UserReferralAchievementUpdate;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Project\Project;
use App\Repositories\Inpanel\Traffic\TrafficStatuses;
use App\Models\Project\UserProject;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Referral\ReferralLink;
use App\Models\Referral\ReferralProgram;
use App\Models\Referral\ReferralRelationship;
use App\Mail\Inpanel\Invite\UserInviteSurveyComplete;
use App\Mail\Inpanel\Invite\ReferPointsConfirm;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification\Notification;
use Illuminate\Support\Collection;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Cache;
/**
 * This Repository class is used for creating, updating the project, changing status of the Project,
 * start surveys, end surveys.
 *
 * Class ProjectRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\Project\ProjectRepository
 */
class ProjectRepository
{
    use TrafficStatuses;

    /**
     * This action is used for fetching all the active User Projects for the particular User.
     *
     * @param $user_id
     * @return array
     */
    public function getActiveUserProjectByUserdashId($user_id,$sorting=null)
    {
        /*if($sorting){
            $sort = $sorting;
        }else{
            $sort = 'DSC';
        }
        $projects = [];
        $project = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->select('up.*','p.apace_project_code','p.code','p.loi','p.end_date')
            //->where('p.survey_status_code', '=', 'LIVE')
            ->wherein('p.survey_status_code',  ['LIVE','PAUSE'])
            ->where('up.user_id','=',$user_id)
            ->where('up.status','=',null)
            // ->where(function($query){
            //     $query->where('status','=',null)
            //         ->orWhere('status','=',$this->getStartedStatus());
            // })

            ->orderBy('points',$sort)->paginate();

        return $project;*/


                $cacheKey = 'user_projects_' . $user_id . '_' . $sort . '_page_' . request('page', 1);
                Cache::forget($cacheKey);
        $projects = Cache::remember($cacheKey, 60 * 5, function() use ($user_id, $sort) {
            return UserProject::with(['project' => function($query) {
                $query->whereIn('survey_status_code', ['LIVE', 'PAUSE']);
            }])
            ->where('user_id', $user_id)
            ->whereNull('status')
            ->orderBy('points', $sort)
            ->paginate(20);
        });
    }


    /**
     * This action is used for fetching all the active User Projects for the particular User.
     *
     * @param $user_id
     * @return array
     */


    public function getActiveUserProjectByUserId($user_id,$sorting=null)
    {
        /*if($sorting){
            $sort = $sorting;
        }else{
            $sort = 'DSC';
        }
        $user = auth()->user();
        $userRole = $user->roles->pluck('name')->first(); // Get first role directly
        $languageCode = strtoupper(explode('_', $user->locale)[0]);
        
        $query = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->select('up.*', 'p.apace_project_code', 'p.code', 'p.loi', 'p.end_date', 'p.survey_name', 'p.study_type_id')
            ->where('p.survey_status_code', 'LIVE')
            ->where('p.language_code', $languageCode)
            ->where('up.user_id', $user_id)
            ->whereNull('up.status');
    
        if ($userRole !== 'panelist') {
            $query->where('p.study_type_id', 12);
        } else {
            $query->where('p.study_type_id', '!=', 12);
        }
    
        return $query->orderBy('points', $sort)->paginate(1000); */
        $sort = $sorting ?? 'DSC';
        $user = auth()->user();
        $userRole = $user->roles->pluck('name')->first();
         $languageCode = strtoupper(explode('_', $user->locale)[0]);
         $countryCode = strtoupper(explode('_', $user->locale)[1]);
        $page = request('page', 1);  // to keep pagination cache key correct
        $cacheKey = "user_projects_{$user->id}_{$userRole}_{$languageCode}_{$countryCode}_{$sort}_page_{$page}";
         Cache::forget($cacheKey);
        $projects = Cache::remember($cacheKey, 20, function () use ($user_id, $userRole, $languageCode,$countryCode, $sort) {
            $query = DB::table('user_projects as up')
                ->join('projects as p', 'up.project_id', '=', 'p.id')
                ->select('up.*', 'p.apace_project_code', 'p.code', 'p.loi', 'p.end_date', 'p.survey_name', 'p.study_type_id')
                ->where('p.survey_status_code', 'LIVE')
                ->where('p.language_code', $languageCode)
                ->where('p.country_code', $countryCode)
                ->where('up.user_id', $user_id)
                ->whereNull('up.status');

            if ($userRole !== 'panelist') {
                $query->where('p.study_type_id', 12);
            } else {
                $query->where('p.study_type_id', '!=', 12);
            }

            return $query->orderBy('points', $sort)->paginate(1000);
        });


        return $projects; 
    }

    /**
     * This action is used for getting all the Taken Surveys by the User.
     *
     * @param $user_id
     * @return array
     */
    public function getUserTakenSurveys($user_id)
    {
        $projects = [];
        $projects = UserProject::where('user_id', '=', $user_id)
            //->whereNotIn('status',[$this->getStartedStatus()])
            ->where('status','!=',null)
            ->orderBy('updated_at','desc')
            ->with('project')->paginate(1000);
        return $projects;
    }


    public function getAllUserTakenSurveys($user_id=null)
    {
        $projects = [];
    if(!empty($user_id)){
     $projects = UserProject::wherein('status',[1,50,5])
        ->where('user_id', '=', $user_id)
            ->orderBy('updated_at','desc')
            ->with('project')->paginate(1000);   
        }else{
            $projects = UserProject::wherein('status',[1,50,5])
       // ->where('user_id', '=', $user_id)
            ->orderBy('updated_at','desc')
            ->with('project')->paginate(1000);
        }

        return $projects;
    }

    /**
     * This action is used for getting all the Project Details assign to a particular User from user project id & status.
     *
     * @param $user_project_id
     * @param $user
     * @return mixed
     */
    public function getProjectDetails($user_project_id,$user)
    {
        $project = UserProject::where('user_id','=',$user->id)
            ->where('id','=',$user_project_id)
            ->where(function ($query){
                $query->where('status','=',null)
                    ->orWhere('status','=',$this->getStartedStatus());
            })->with('project')->first();
        return $project;
    }

    /**'
     * This action is used for chaning the status of User Project.
     * @param $user_project_details
     * @return mixed
     */
    public function changeStatus($user_project_details)
    {
        // echo '<pre>';
        // print_r($this->getStartedStatus());die();
        $update_status = [
            'status' => $this->getStartedStatus(),
        ];
        $change_status = UserProject::where('id','=',$user_project_details->id)
            ->update($update_status);
        return $change_status;
    }

    /**
     * This action is used for creating new client redirect link which include sjpid also as the User start Surveys.
     *
     * @param $user
     * @param $user_project
     * @return string
     */
    public function getRedirectClientLink($user,$user_project)
    {
        $client_var = [config('app.vvars.user_id')];
        $client_redirect_link = $user_project->user_live_link;
        $parameters = explode('&',$client_redirect_link);
        foreach ($parameters as $key=>$value){
            $param = explode('=',$value);
            foreach($param as $param_var){
                if(in_array($param_var,$client_var)){
                    unset($parameters[$key]);
                    $new_pid = $param_var.'='.$user->uuid.'_'.$user_project->project->code;
                    $new_parameter = array_push($parameters,$new_pid);
                }
            }
        }
        $client_redirect_new_link = implode('&',$parameters);
        return $client_redirect_new_link."&ch=1";
    }

    /**
     * This action is used for getting project by code.
     *
     * @param $user_project_code
     * @return mixed
     */
    public function getProject($user_project_code)
    {
        $project = Project::where('code','=',$user_project_code)
            ->first();
        return $project;
    }

    /**
     * This action is used for getting User by uuid.
     *
     * @param $user_uuid
     * @return mixed
     */
    public function getUserDetails($user_uuid)
    {
        $user = User::where('uuid','=',$user_uuid)
            ->first();
        return $user;
    }
    /**
     * This action is used for getting UserProject by project_id,status including project details.
     *
     * @param $user
     * @param $project
     * @return mixed
     */
    public function getUserProject($user,$project)
    {
        $user_project = UserProject::where('user_id','=',$user->id)
            ->where('project_id','=',$project->id)
            //->where('status','=',$this->getStartedStatus())
            ->where(function($query){
                $query->where('status','=',null)
                    ->orWhere('status','=',$this->getStartedStatus());
            })
            ->with('project','user')
            ->first();

        return $user_project;
    }

    /**
     * This action is usd for changing the status of User Project to Completes
     *
     * @param $get_user_project
     * @return boolean
     */
    public function changeStatusComplete($get_user_project)
    {
        $update_data = [
            'status' => $this->getCompleteStatus(),
        ];
        return $this->updateStatus($get_user_project,$update_data);
    }

    /**
     * This action is usd for changing the status of User Project to Terminate
     *
     * @param $get_user_project
     * @return boolean
     */
    public function changeStatusTerminate($get_user_project)
    {
        $update_data = [
            'status' => $this->getTerminateStatus(),
        ];

        return $this->updateStatus($get_user_project,$update_data);
    }

    /**
     * This action is usd for changing the status of User Project to QuotaFull
     *
     * @param $get_user_project
     * @return boolean
     */
    public function changeStatusQuotaFull($get_user_project)
    {
        $update_data = [
            'status' => $this->getQuotaFullStatus(),
        ];
        return $this->updateStatus($get_user_project,$update_data);
    }

    /**
     * This action is usd for changing the status of User Project to Quality Terminate.
     *
     * @param $get_user_project
     * @return boolean
     */
    public function changeStatusQualityTerminate($get_user_project)
    {
        $update_data = [
            'status' => $this->getQualityTerminateStatus(),
        ];
        return $this->updateStatus($get_user_project,$update_data);
    }

    /**
     * This action is used where user projects status is changed.
     * @param $get_user_project
     * @param $update_data
     * @return mixed
     */
    private function updateStatus($get_user_project,$update_data)
    {
        $changeStatus = UserProject::where('id','=',$get_user_project->id)
            ->update($update_data);
        return $changeStatus;
    }

    /**
     * This action is used when the status of User Project is marked to Completes and than UserAchievements is updated.
     *
     * @param $user
     * @param $user_projects
     * @return bool
     */
    public function updateUserAchievements($user,$user_projects)
    {
        $user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement = $user_add_data->user_achievement;
        $user_achievement = [];
        $points_data = [];
        $project_code = $user_projects->project->code;
        // Live Added By Ramesh Kamboj to fetch Apace Project Code//
        $apace_project_code=$user_projects->project->apace_project_code;
        $points = $user_projects->points;
        if(empty(array_column($fetch_user_achievement,"survey_achievements"))) {
            $points_data["id"] = $user_projects->id;
            $points_data["code"] = $apace_project_code;
            $points_data["points"] = $points;
            $points_data["status"] = "completed";
            $user_achievement['survey_achievements'][] = $points_data;
            $user_add_data->push("user_achievement", $user_achievement);
            \Log::info("ASSSSSSSSSSSSSSSSSSSSSS");
            event(new UserAchievementUpdate($user));
            activity("user_achievements")
                ->causedBy($user->id)
                ->withProperties(['points'=>$points,'survey_code'=>$apace_project_code])
                ->log('inpanel.activity_log.survey_points');
            
            $this->updateReferralUserPoints($user);
             return true;
        }

        $achievements = array_column($fetch_user_achievement,"survey_achievements");

        // \Log::info("checking achievements : " . $achievements);
        
        if(isset($achievements)){
            $user_achieve_present_code =in_array($project_code,array_column($achievements[0], 'code'));
            if($user_achieve_present_code==false){
                $points_data["id"] = $user_projects->id;
                $points_data["code"] = $apace_project_code;
                $points_data["points"] = $points;
                $points_data["status"] = "completed";
                $data = [];
                foreach($user_add_data['user_achievement'] as $key=>$value){
                    if(array_key_exists("survey_achievements",$value)){
                        foreach ($value as $profile_data){
                            $value['survey_achievements'][] = $points_data;
                        }
                    }
                    $data['user_achievement'][] = $value;
                }
                UserAdditionalData::where('uuid', '=', $user->uuid)
                    ->update($data);
                event(new UserAchievementUpdate($user));
                activity("user_achievements")
                    ->causedBy($user->id)
                    ->withProperties(['points'=>$points,'survey_code'=>$apace_project_code])
                    ->log('inpanel.activity_log.survey_points');
                /**
                 * Add code for check invited user and give points
                 * By Vikash Yadav (29-11-2022)
                 */
                $this->checkReferralGivePoints($user);
                
                return true;
        }
    }
}
    /**
     * Add code for check invited user and give points
     * By Vikash Yadav (29-11-2022)
     */
    private function checkReferralGivePoints($user){

        $referalRelation =ReferralRelationship::select('referral_links.*','referral_relationships.first_survey_completed')
                            ->leftJoin('referral_links', 'referral_relationships.referral_link_id', '=', 'referral_links.id')
                            ->where('referral_relationships.user_id',$user->id)
                            ->first();
        if(!empty($referalRelation)){
            $referral_user_id = $referalRelation->user_id;
            $refered_user_id  = $user->id;
            if($referalRelation->first_survey_completed=='False'){    
                //event call for point update
                event(new UserReferralAchievementUpdate($referral_user_id,$refered_user_id));
                ReferralRelationship::where('user_id',$user->id)->update(['first_survey_completed'=>'True']);

                //email send for invite user
                $referalLinks =ReferralLink::select('referral_programs.points')
                        ->leftJoin('referral_programs', 'referral_links.referral_program_id', '=', 'referral_programs.id')
                        ->where('referral_links.user_id',$referral_user_id)
                        ->first();
                $referral_user = User::where('id',$referral_user_id)->first();
                $referred_name = $user->first_name.' '.$user->last_name;
                $referred_first_name = $user->first_name;
                $email = new UserInviteSurveyComplete($referral_user,$referred_name,$referalLinks->points,$referred_first_name);
                Mail::send($email);
            }
        }
    }

    public function updateReferralUserPoints($user){
        
        $referalRelation =ReferralRelationship::select('referral_links.*','referral_relationships.first_survey_completed')
                            ->leftJoin('referral_links', 'referral_relationships.referral_link_id', '=', 'referral_links.id')
                            ->where('referral_relationships.user_id',$user->id)
                            ->first();
        // print($referalRelation);exit();
        if(!empty($referalRelation)){
            $referral_user_id = $referalRelation->user_id;
            $refered_user_id  = $user->id;
            if($referalRelation->first_survey_completed=='False'){    
                event(new UserReferralAchievementUpdate($referral_user_id,$refered_user_id));
                ReferralRelationship::where('user_id',$user->id)->update(['first_survey_completed'=>'True']);

                $referalLinks =ReferralLink::select('referral_programs.points')
                        ->leftJoin('referral_programs', 'referral_links.referral_program_id', '=', 'referral_programs.id')
                        ->where('referral_links.user_id',$referral_user_id)
                        ->first();
                $referral_user = User::where('id',$referral_user_id)->first();

                $referred_name = $user->first_name.' '.$user->last_name;
                $referred_first_name = $user->first_name;
                $email = new ReferPointsConfirm($referral_user,$referred_name,$referalLinks->points,$referred_first_name);
                Mail::to($referral_user->email)->locale($referral_user->locale)->send($email);
                // Added by RAS for notification on 01/09/23
                $ref_req_id = DB::table('referral_relationships')
                ->where('user_id',$user->id)->first();
                // $referee = DB::table('users')
                // ->join('referral_links','referral_links.user_id','=','users.id')
                // ->where('referral_links.id',$ref_req_id->referral_link_id)
                // ->select('users.uuid')->first();
                $get_completion_point = Setting::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();
                
				//$comp_value = ($get_completion_point->value/1000 < 1) ? $get_completion_point->value/1000*100 . 'cents' : '$' . $get_completion_point->value/1000;
				app()->setLocale($referral_user->locale);
				
				/* Parshant Sharma [04-09-2024] Starts */
				
				//$locale = $user->locale;
				
				$countryPoint = DB::table('country_points')->where('country_language', $referral_user->locale)->first();   
				$countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
				
				// Initialize an empty array
				$currencies = array();

				if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
					
					$cntry = explode('_',$countryPoint->country_language);
					
					$currencies = array(
						'currency_logo'  => $countryPoint->currency_symbols,
						'currency_denom_singular' => $countryPoint->currency_denom_singular,
						'currency_denom_plural' => $countryPoint->currency_denom_plural
					);
				} 
				
				$metricConversion = 1/$countryPoints;	
				
				// calculate $comp_value [04-09-2024]
				
				if($get_completion_point->value*$metricConversion < 1){
					
					$currency = ($get_completion_point->value*100*$metricConversion > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];					
					$comp_value = number_format($get_completion_point->value*100*$metricConversion,2)." ".__($currency);
					
				}else{					
					$comp_value = $currencies['currency_logo']."".number_format($get_completion_point->value*$metricConversion,2);
				}
																				
				/* Parshant Sharma [04-09-2024] Ends */						
				
                $msg = __('frontend.notification_txt.referral_rqst_points', ['completion_points' => $get_completion_point->value,'completion_value' => $comp_value]);
                $notification_data = [
                'user_uuid' => $user->uuid,
                'notification_type' => 'Referral Request',
                'type_id' => $ref_req_id->referral_link_id,
                'notification_text' => $msg
                ];
                Notification::create($notification_data);
                \Log::info("user - ".$user->locale);
                \Log::info("referral_user - ".$referral_user->locale);
                //$orig_locale = app()->getLocale();
                app()->setLocale($referral_user->locale);
                $msg_1 = __('frontend.notification_txt.referral_rqst_points', ['completion_points' => $get_completion_point->value,'completion_value' => $comp_value]);
                $notification_refree_data = [
                'user_uuid' => $referral_user->uuid,
                'notification_type' => 'Referral Request',
                'type_id' => $ref_req_id->referral_link_id,
                'notification_text' => $msg_1
                ];
                Notification::create($notification_refree_data);
                //app()->setLocale($orig_locale);
                app()->setLocale($referral_user->locale);
                //End Code by RAS

                
            }
        }
    }

    private function checkInviteuser($userid){
        $referalRelation = ReferralRelationship::where('user_id',$userid)->first();
        if(!empty($referalRelation)){

            return true;
        }else{
            return false;
        }
    }

    /**
     * Function Name: getNextSurvey
     * Created By : Priyanka(18-june-2024)
     */
    public function getNextSurvey($user_id) {
        $project = DB::table('user_projects as up')
            ->join('projects', 'projects.id', '=', 'up.project_id')
            ->join('users', 'users.id', '=', 'up.user_id')
            ->select('up.id','up.user_live_link','projects.code','users.uuid')
            ->where('up.user_id', '=', $user_id)
            ->where('projects.survey_status_code', '=', 'LIVE')
            ->whereNull('up.status') // Check for null status
            //->where('up.status','=',null) // Is status null stands for fetching the new survesys assigned the panalist
            ->orderBy('up.cpi', 'DESC')
            ->orderBy('projects.loi', 'ASC')
            ->orderBy('projects.ir', 'ASC')
            ->first(); // Retrieve the first matching record
        return $project;
    }
}
