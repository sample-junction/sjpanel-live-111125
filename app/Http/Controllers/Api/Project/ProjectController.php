<?php
namespace App\Http\Controllers\Api\Project;
use App\Events\Inpanel\Project\AfterStatusChanged;
use App\Events\Inpanel\Project\ProjectQuotaUpdate;
use App\Http\Controllers\Api\BaseController;
use App\Mail\Inpanel\UserProject\SurveyCustomInvite;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;
use App\Mail\Inpanel\UserProject\UserProjectCreated;
use App\Models\Auth\User;
use App\Models\Project\Project;
use App\Models\Project\InviteSentDetails;
use App\Models\Project\ProjectQuota;
use App\Models\Project\UserProject;
use App\Models\Project\SjpanelResponserates;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\Project\ProjectQuotaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Api\Project\ProjectRepository;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Inpanel\Traffic\TrafficRepository;
use App\Models\Traffics\Traffic;
use App\Models\Report\SurveyStartCount;
use App\Models\Setting\Setting;
use App\Repositories\Inpanel\Project\ProjectRepository as ProjectInpanalRepository;
use App\Models\Report\SurveyReport;
use App\Events\Inpanel\Project\ProfileSurveyComplete;
use App\Mail\Inpanel\UserProject\autReminderSurveyMail;
use App\Mail\Backend\RejectedReconcilation\ReconcilationRejectedMail;
use App\Models\Campaign\campaign_history;
use DB;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use Illuminate\Support\Facades\Cache;
/**
 * This class handle all the functionality of creating a new project, updating it,
 * creating new quota and updating it, change status of Project and assigning the Project to the
 * eligible user.
 *
 * Class ProjectController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Api\Project\ProjectController
 */
class ProjectController extends BaseController
{
    /**
     * @var ProjectRepository
     * @param $projectRepo
     * @param $projectQuotaRepository
     */
    public $projectRepo, $projectQuotaRepository, $countriesCurrenciesRepository;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepo
     * @param ProjectQuotaRepository $projectQuotaRepository
     */

    public function __construct(ProjectRepository $projectRepo, ProjectQuotaRepository $projectQuotaRepository,TrafficRepository $trafficRepo,ProjectInpanalRepository $projectInpRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {

        $this->projectRepo = $projectRepo;
        $this->projectQuotaRepository = $projectQuotaRepository;
        $this->trafficRepo = $trafficRepo;
        $this->projectInpRepo = $projectInpRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;

    }

    /**
     * This action is used for creating new project as this api is hit by apace.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProject(Request $request)
    {
         

        $projectInputs  = $request->all();
        
        $project = $this->projectRepo->createProject($projectInputs);
        if (!$project) {
            return response()->json([], 404);
        }
        $responseData = ['Project' => $project, 'status' => 201];
        return response()->json($responseData, 201);
    }

    /**
     * This action is used for changing the status of Project and if the status has been changed
     * to Live than project has to be assigned to the eligible User based on the defined quota for
     * the project.
     *
     * @param Request $request
     * @param $survey_code
     * @return \Illuminate\Http\JsonResponse
     */

    public function changeStatus(Request $request, $survey_code)
    {
        $new_status = $request->input("survey_status_code",false);
        $new_status = $this->projectRepo->getNewStatus($new_status);
        $project_code = $survey_code;
        $project = $this->projectRepo->getProject($project_code);

        $project_current_status = $this->projectRepo->getCurrentStatus($project_code);
        //event( new AfterStatusChanged( $project,$new_status,$new_status) );
        $project = $this->projectRepo->updateProjectStatus( $project, $new_status);
        if ($project) {
            event( new AfterStatusChanged( $project,$project_current_status->status,$new_status) );
        }
        $responseData = ['Project' => $project, 'status' => 201];
        return response()->json($responseData);
    }


    /**
     * This action is used to update the Project not status but apart from this any field
     * of the project.
     *
     * @param Request $request
     * @param $survey_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProject(Request $request,$survey_code)
    {

        //$locale="es_US";
        //app()->setLocale($locale);

        $input = $request->all();
       //  \Log::info("update".json_encode($input));

        // \Log::info("update".json_encode($survey_code));

        $update_project = $this->projectRepo->updateProject($survey_code,$input);
        
        if($update_project){
           
            $projectDetails = Project::where('code','=',$survey_code)->first(['id','survey_status_code']);
            $new_cpi = $request->input("cpi",false);
            $pointsConversionMetric = config('app.points.metric.conversion');
            $updateData = array(
                'cpi'    => $new_cpi,
                'points' => round($new_cpi/$pointsConversionMetric),
            );
           //\Log::info("update".json_encode($updateData));
        //exit;
            $getUserProjects = UserProject::where('project_id', $projectDetails->id)
                                ->where('status', '=', null)
                                ->update($updateData);
            
            /**
             * Changed by Vikash Yadav 
             * date 21-02-2023
             */
            
            $useruuids = [];
            $inviteDetails = InviteSentDetails::where('project_id',$projectDetails->id)->get();
            if(!empty($inviteDetails)){
                foreach($inviteDetails as $invite){
                    $useruuidData = explode(',',$invite->user_ids);
                    foreach($useruuidData as $uuids){
                        $useruuids[] = $uuids;
                    }
                    
                }

                $uniqueUuids = array_unique($useruuids);
                $get_all_users = User::whereIn('uuid', $uniqueUuids)->get();
                $userIds =[];
                foreach($get_all_users as $user){
                    $userIds[] = $user->id;
                }
                
                //$project = Project::where('id', '=', $projectDetails->id)->first();
                $allUserProjects = [];
                if($projectDetails && $projectDetails->survey_status_code == 'LIVE' ){
                   
                    $allUserProjects = UserProject::whereIn('user_id', $userIds)
                                                ->with('user','project')
                                                ->where('project_id', '=', $projectDetails->id)
                                                ->where('status', '=', null)
                                                ->get();


                    //return response()->json($allUserProjects);
                    foreach($allUserProjects as $value){

                      //  \Log::info("UUID".json_encode($value));


                        //  $locale=$value->user->locale;
                        //  app()->setLocale($locale);
                        $project_data = $value->project;
                        //return response()->json($value->user->email);
                        //$surveyid = $value->id."?sid=".$createInviteId=1;
                        //print_r($project_data);die;


                        



                        $pointsConversionMetric = config('app.points.metric.conversion');
                        $surveyLiveLink = $this->getSurveyLink($value->user,$project_data,'live_url');
                        $surveyTestLink = $this->getSurveyLink($value->user,$project_data,'test_url');
                        $pointsData = round($project_data->cpi/$pointsConversionMetric);
                        $locale=$value->user->locale;
                        app()->setLocale($locale);
                        
                        /* Parshant Sharma [03-09-2024] STARTS */
                            $localeGet = app()->getLocale();

                            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                            
                            $metricConversion = 1/$countryPoints;
                            $countrySymbol    = $countryPoint->currency_symbols;
                            
                         
                        /* Parshant Sharma [03-09-2024] ENDS */
                        
                        $placehodlers = [
                            '{%S_POINTS%}'          => round($project_data->cpi/$pointsConversionMetric),
                            '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
                            '{%VALUE%}'   =>  number_format(($pointsData/$countryPoints),2),
                            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                            '{%S_CODE%}'            => $project_data->apace_project_code,
                            '{%DEVICE%}'            => $this->getProjectDeviceName($project_data),
                            '{%S_LOI%}'             => $project_data->loi,
                            '{%S_SDATE%}'           => $project_data->start_date,
                            '{%S_EDATE%}'           => $project_data->end_date,
                            '{%S_LINK%}'            => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=1&points='.$pointsData:"test.com",
                            '{%S_TEST_LINK%}'       => (!empty($surveyTestLink))?$surveyTestLink.'&ch=1&points='.$pointsData:"test.com",
                            '{%Points_Data%}'       => $pointsData,
                            '{%S_TOPIC%}'           => $project_data->project_topic_name,
                            '{%U_NAME%}'            => $value->user->first_name,
                            '{%U_EMAIL%}'           => $value->user->email,
                            '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
                            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                            '{%DETAILS_1%}'         => __('inpanel.mail.survey.salutation'),
                            '{%DETAILS_2%}'         => __('inpanel.mail.survey.details_1'),
                            '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                            '{%DETAILS_3%}'         => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            '{%DETAILS_4%}'         => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                            '{%DETAILS_5%}'         => __('inpanel.mail.survey.details_4'),
                            '{%DETAILS_6%}'         => __('inpanel.mail.survey.details_5'),
                            '{%device_use%}'        => __('inpanel.mail.survey.device_use'),
                            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                            '{%LABELS_1%}'          => __('inpanel.mail.survey.label_1'),
                            '{%LABELS_2%}'          => __('inpanel.mail.survey.label_2'),
                            '{%LABELS_3%}'          => __('inpanel.mail.survey.label_3'),
                            '{%POINTS%}'            => __('inpanel.mail.survey.points'),
                            '{%LABELS_4%}'          => __('inpanel.mail.survey.label_4'),
                            '{%BUTTON_S%}'          => __('inpanel.mail.survey.button'),
                            '{%LINE_TEXT%}'         => __('inpanel.mail.survey.link_text'),
                            '{%ENTER%}'             => __('inpanel.mail.survey.enter'),
                           // '{%HAPPY%}'             => __('inpanel.mail.survey.happy'),
                            '{%FOOTER_1%}'          => __("strings.emails.auth.confirmation.footer"),
                            '{%FOOTER_2%}'          => __("strings.emails.auth.confirmation.footer_1"),
                            '{%FOOTER_3%}'          => __("frontend.welcome_mail.team"),
                            '{%FOOTER_DETAILS%}'    => __("strings.emails.auth.confirmation.details_3"),
                            '{%REGARDS%}'           => __('inpanel.mail.survey.regards'),
                            '{%ROUTE_R%}'           => route('frontend.cms.rewards'),
                            '{%REWARDS%}'           => __('strings.emails.auth.confirmation.rewards'),
                            '{%POLICY%}'            => __("frontend.index.footer.links.privacy_policy"),
                            '{%SAFEGUARDS%}'        => __("strings.emails.auth.confirmation.safeguards"),
                            '{%COOKIE%}'            => __("strings.emails.auth.confirmation.cookie"),
                            '{%REWARDS_POLICY%}'    => __('frontend.index.footer.links.reward_policy'),
                            '{%T_CONDITION%}'       => __("frontend.index.footer.links.term_condition"),
                            '{%ROUTE_REWARD_P%}'    => route('frontend.cms.rewards_policy'),
                            '{%ROUTE_REFERRAL_P%}'  => route('frontend.cms.referral_policy'),
                            '{%REFERRAL_POLICY%}'   => __('frontend.index.footer.links.referral_policy'),
                            '{%ROUTE_TC%}'          => route('frontend.cms.term_condition'),
                            '{%ROUTE_S%}'           => route('frontend.cms.safeguard'),
                            '{%ROUTE_C%}'           => route('frontend.cms.cookie'),
                            '{%ROUTE_P%}'           => route('frontend.cms.privacy'),
                            '{%ROUTE_F%}'           => route('frontend.cms.faq'),
                            '{%ROUTE_CONT%}'        => route('frontend.cms.help_support'),
                            '{%FAQ%}'               => __("strings.emails.auth.confirmation.faq"),
                            '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
                            '{%DISCLAIMER%}'        => __("strings.frontend.disclaimer"),
                            '{%DISCLAIMER_1%}'      => __("strings.frontend.disclaimer_1"),
                            '{%UNSUBSCRIBE%}'       => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                            '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                            '{%COPYRIGHT%}'         => __("strings.emails.auth.confirmation.copyright"),
                            '{%COPYRIGHT_COMPANY%}' => __("strings.emails.auth.confirmation.copyrightcompany"),
                            '{%ALL_RIGHT%}'         => __("strings.emails.auth.confirmation.all_right"),
                            '{%YEAR%}'              => date("Y"),
                            '{%LOGO%}'              => asset('img/frontend/logo.png'),
                            '{%IMAGE%}'             => asset('img/img_email/survey1.png'),
                            '{%LOGOLINK%}'          => (env('APP_URL')),
                            '{%MAIL_CONTENT%}'      => __("strings.emails.auth.confirmation.mail_content"),
                            '{%LINK%}'              => __("strings.emails.auth.confirmation.link"),
                            '{%LINK1%}'             => __("strings.emails.auth.confirmation.link1"),
                            '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                            '{%MINUTE%}'            => __('inpanel.mail.survey.minutes'),
                            '{%NEW_CONTENT%}' => __('inpanel.mail.survey.new_content'),
                            '{%countrySymbol%}'=>__('inpanel.redeem.index.title_history_2'),
                            //'{%VALUE%}' => __('inpanel.mail.survey.value'),

                            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                        ];
                        $points_val = round($project_data->cpi/$pointsConversionMetric);
                        $email_data = [
                            'email'        => $value->user->email,
                            'from_name'    => 'SJ Panel',
                            'from_address' => config('mail.from.donotreply_address'),


                            //'subject'      => __('inpanel.mail.survey.survey_subject_new',['survey_points' => round($project_data->cpi)]),
                            'subject'      => __('inpanel.mail.survey.survey_subject_new',['survey_points' => number_format($pointsData/$countryPoints, 2)]),


                            // 'subject' => __('inpanel.mail.survey.survey_subject_new', ['survey_points' => ($project_data->cpi < 1 ? round($project_data->cpi * 100) . __('inpanel.dashboard.cents') : round($project_data->cpi))]),



                        ];
                        
                        // print_r($email_data);die();
                            $email = new SurveyTestInvite($email_data, $placehodlers);
                            //Mail::send($email);
                            

                    }
                   
                }
                // Get user id from invite sent details table where project id = $projectDetails->id
                // Create single array and remove duplicate array value
                // Send survey email.

            }
        }
        return response()->json($update_project);
    }


    /**
     * This action is used to add quota to a particular project.
     *
     * @param Request $request
     * @param $survey_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function addQuota(Request $request,$survey_code)
    {
        $input = $request->all();
        $project = Project::where('code', '=', $survey_code)->first();
        $quota = $this->projectQuotaRepository->addProjectQuota($project->id, $input);
        if($project->survey_status_code == 'LIVE'){
            $liveStatus = $this->projectRepo->getLiveStatus();
            event( new AfterStatusChanged( $project,$liveStatus,$liveStatus) );
        }
        return response()->json($quota);
    }

    /**
     * This action is used to update Quota fields.
     *
     * @param Request $request
     * @param $survey_code
     * @param $quota_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateQuota(Request $request,$survey_code,$quota_id)
    {
        $input = $request->all();
        $project = Project::where('code', '=', $survey_code)->first();

        $existingQuota = $this->projectQuotaRepository->getProjectQuota($project->id, $quota_id);

        if ($existingQuota) {
            $quota = $this->projectQuotaRepository->updateProjectQuota($existingQuota, $input);
            if($quota)
                event(new ProjectQuotaUpdate($quota, $project));
                return response()->json($quota, 200);
        }
        return response()->json([], 404);
    }

    /**
     * This action is for updating the status of Quota.
     *
     * @param Request $request
     * @param $survey_code
     * @param $quota_name
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeQuotaStatus(Request $request,$survey_code,$quota_name)
    {
        $status = $request->all();
       $change_quota_status = $this->projectRepo->updateQuotaStatus($status,$survey_code,$quota_name);
        return response()->json($change_quota_status);
    }

    /**
     * This action is used to update reconcilation process.
     * Start changed by Vikash yadav(31-01-2023)
     * @param Request $request
     * @param $survey_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReconcilation(Request $request)
    {
        $uploadreconcialDetails  = $request->input('reconcialDetails');
        $survetReportDetails = SurveyReport::select('survey_code')->where('RespID',$uploadreconcialDetails['respid'])->first();
        $uuid    = $uploadreconcialDetails['vvarvalues'];
       
        if(!empty($survetReportDetails)){
            $surveyCode = $survetReportDetails->survey_code;  
        }else{
            return response()->json(['status'=>0,'msg'=>'Survey code is not exist','uuid'=>$uuid]);
        }

        //$arr = explode('_',str_replace("'", "", $uploadreconcialDetails['vvarvalues']));
       // $uuid = $arr[0];
        //$surveyCode = $arr[1];

        $user    = $this->projectInpRepo->getUserDetails($uuid);
        //return response()->json(['status'=>0,'msg'=>'Survey code is not exist','uuid'=>$user->uuid]);
        //print_r($user);die;
        $project = $this->projectInpRepo->getProject($surveyCode);
        
       

        if($user && $project){
           // $get_user_project = $this->projectInpRepo->getUserProject($user,$project);
            $get_user_project = UserProject::where('user_id','=',$user->id)->where('project_id','=',$project->id)->first();

            if($get_user_project){
               // \Log::info($uploadreconcialDetails['vendor_final_status']);
                if(rtrim($uploadreconcialDetails['vendor_final_status']) == "Complete"){
                    $checkedUserAssign = UserProject::where('user_id','=',$user->id)->where('project_id','=',$project->id)->where('status','=',50)->get();
                    if(count($checkedUserAssign)==0){
                        $duration = 60;
                        $date= date("Y-m-d H:i:s", strtotime("+$duration sec"));
                        $update_data=[
                            'status'=>50,
                            'updated_at'=>$date,
                        ];
            
                        $changeStatus = UserProject::where('id','=',$get_user_project->id)
                ->update($update_data);
                        $this->updateSurveyReport($uploadreconcialDetails['respid'],1,$uploadreconcialDetails['vendor_final_status'],$uploadreconcialDetails['reason_rejection']);

                        $this->projectInpRepo->updateUserAchievements($user,$get_user_project);
                       // event(new ProfileSurveyComplete($user));  
                    }else{
                        return response()->json(['status'=>0,'msg'=>'Already Paid','uuid'=>$uuid]); 
                    }
                    

                } elseif (rtrim($uploadreconcialDetails['vendor_final_status']) == "Rejected"){

                    // code for sending Mail after Rejection added by obhi
                    $this->sendMailRejectedReconcilation($user, $get_user_project);
                    //End
                    
                    $update_data=[
                        'status'=>5,
                    ];
        
                    $changeStatus = UserProject::where('id','=',$get_user_project->id)->update($update_data);
                    $this->updateSurveyReport($uploadreconcialDetails['respid'],5,$uploadreconcialDetails['vendor_final_status'],$uploadreconcialDetails['reason_rejection']);

                    
                   
                } 
                return response()->json(['status'=>1,'msg'=>'Assign points are credited in your account','uuid'=>$uuid]);
            }else{
                return response()->json(['status'=>0,'msg'=>'User assign survey is not exist','uuid'=>$uuid]);
            }
        }else{
            return response()->json(['status'=>0,'msg'=>'User or project is not exist','uuid'=>$uuid]);
        }
        
        
    }

    public function updateSurveyReport($respid,$status,$statusName,$rejectReason){
        $survetReportDetails = SurveyReport::select('id')->where('RespID',$respid)->first();
        if(!empty($survetReportDetails)){
            $data=[
                'status'=>$status,
                'status_name'=>$statusName,
                'reject_reason'=>$rejectReason,
            ];

            \DB::table('survey_reports')
            ->where('id', $survetReportDetails->id)
            ->update($data);
        }
        return;
    }

/**
 * End changes.
 */
    public function checkProject($survey_code)
    {
        $project = $this->projectRepo->checkProject($survey_code);
        return response()->json($project);
    }


    private function checkUserForTestPanelist($user_uuid, $study_type)
    {
        
        $filtered_users = [];

        foreach ($user_uuid as $uuid) {
        $tmp_user_role = User::where('uuid', $uuid)->first()->roles->pluck('id')->first();
        //\Log::info("tmp_user_role".trim($tmp_user_role->first())."--".$uuid."--".$study_type);
        if (($study_type != 12 && $tmp_user_role == '4') || ($study_type == 12 && $tmp_user_role == '8')) {
            //\Log::info("tmp_user_role".trim($tmp_user_role)."--".$uuid."--".$study_type);
            array_push($filtered_users, $uuid);
        }
        }
        //\Log::info("tmp_user_role1".json_encode($filtered_users));
    return $filtered_users;
    }



    public function pullInvitesBySpec(Request $request)
    {
      
        /*$trafficStats = $this->trafficRepo->getTrafficsStats($project_id = 14721);

        return response()->json(['status' =>  $trafficStats, 'count' => 10, 'ids' => ['btxtxtrcvyvytc555'],'suggestion'=>round(10)]);*/

        /*Todo: Create Request for this Action*/
        $quotaSpec          = $request->input('quotaSpec');
        $country_code       = $request->input('country_code');
        $language_code      = $request->input('language_code');
        $apace_project_code = $request->input('projects_code');
        $study_type = Project::where('apace_project_code',$apace_project_code)->first()->study_type_id;
        $decoded = json_decode($quotaSpec,true);
       // \Log::info("Quota".json_encode($decoded));
        $formatted = [];

        foreach($decoded as $value){
            $string = $value['name'].'='.$value['value'];
            parse_str($string, $result);
            foreach($result as $key2 => $item2){
                foreach($item2 as $key3 => $item3){
                    if(!empty($item3)){
                        $formatted[$key2][$key3][] = $item3;
                    }
                }
            }
        }

        $newFormattedData = [];
        foreach($formatted as $type => $qualifications){
            if ($type == 'global') {
                $newQualification = [];
                if ( array_key_exists('GLOBAL_AGE', $qualifications) && array_key_exists('custom_age', $qualifications)) {
                    
                    $globalAgeItem = $qualifications['GLOBAL_AGE'];
                    $customAge = $qualifications['custom_age'];
                    unset($qualifications['custom_age']);
                    $qualifications['GLOBAL_AGE'] = $this->parseCustomAgeSpec($customAge);

                    $newFormattedData[$type] = $qualifications;
                }else{

                    $newFormattedData[$type] = $qualifications;
                }
            } else {
                $newFormattedData[$type] = $qualifications;
            }
        }

        $qualsMaps = [];
       
        foreach ($newFormattedData as $qualificationType => $qualificationItems) {
            
            if ($qualificationType == 'global') {
                $qualsMaps = array_merge($qualsMaps, $this->mapSJPanelQuestions($qualificationItems));
            }
            if ($qualificationType == 'detailed') {
                $qualsMaps = array_merge($qualsMaps, $this->mapSJPanelQuestions( $qualificationItems));
            }
            if ($qualificationType == 'hidden') {
                $qualsMaps = array_merge($qualsMaps, $this->mapSJPanelQuestions( $qualificationItems));
            }

        }

       // \Log::info("Quota Ramesh".json_encode($qualsMaps));

        $getMonthLimit = Setting::where('key','=','PANEL_ACTIVE_MONTH_LIMIT')->first();
        $fromLastMonths = $getMonthLimit->value;
        
        //Get project device option
       $projectData = Project::where('apace_project_code','=',$apace_project_code)->first();
        //Retrive explode device option
        /**
         * Change Date 11feb2023 and 14feb2023
         * change by vikash for device preference
         * */
         // Device filtering
       /* $activeUsersQuery = User::inCountry($country_code)
        ->leftJoin(DB::raw('(SELECT causer_id, MAX(created_at) as created_at FROM activity_log GROUP BY causer_id) as T4'),
            'users.id','=','T4.causer_id'
        )
        ->where([
            ['is_blacklist',0],
            ['confirmed',1],
            ['active',1],
        ])
        ->whereIn('unsubscribed',[0])
        ->where('T4.created_at','>',Carbon::now()->subMonths($fromLastMonths))
        ->select('users.uuid');

    if(!empty($projectData->device_options)){
        $devices = explode(',',$projectData->device_options);
        $activeUsersQuery->where(function($q) use ($devices){
            foreach ($devices as $d) {
                $q->orWhereRaw('FIND_IN_SET(?,device_preference)', [$d]);
            }
        });
    }*/
    $cacheKey = "active_users_{$country_code}";
        Cache::forget($cacheKey);
    
$activeUsersQuery = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($country_code, $fromLastMonths, $projectData) {
    $query = User::inCountry($country_code)

        ->leftJoin(DB::raw('(SELECT causer_id, MAX(created_at) as created_at FROM activity_log GROUP BY causer_id) as T4'),
            'users.id','=','T4.causer_id'
        )
        ->where([
            ['is_blacklist', 0],
            ['confirmed', 1],
            ['active', 1],
        ])
        ->whereIn('unsubscribed', [0])
        ->where('T4.created_at', '>', Carbon::now()->subMonths($fromLastMonths))
        ->select('users.uuid');

    if (!empty($projectData->device_options)) {
        $devices = explode(',', $projectData->device_options);
        $query->where(function ($q) use ($devices) {
            foreach ($devices as $d) {
                $q->orWhereRaw('FIND_IN_SET(?, device_preference)', [$d]);
            }
        });
    }


    return $query->get(); // run query only when cache is empty
});

        $activeUsers_org = $activeUsersQuery->pluck('uuid')->toArray();
       
        //$activeUsers = $this->checkUserForTestPanelist($activeUsers_org, $study_type);
        $activeUserids = $activeUsers_org;


        //\Log::info("Ramesh TEst Panelists".json_encode($activeUserids));
        
        $inviteDetails = InviteSentDetails::where('apace_project_code',$apace_project_code)->get();
        if(count($inviteDetails)>0){
            $sentUserids = [];
            foreach($inviteDetails as $result){
                $sentUserids[] = $result->user_ids;
            }
        }else{
            $sentUserids = [];     
        }

       $sentUserids = explode(",",implode("," , $sentUserids));
        $sentUserids = [];


        $unsentMailUserids = array_unique(array_diff($activeUserids,$sentUserids));
        //Code Added by Ramesh 06-11-2024

        $getUserProjects = UserProject::select('users.uuid')->join('users','users.id','=','user_projects.user_id')->where('user_projects.apace_project_code', '=', $apace_project_code)->whereNotNull('user_projects.status')->get();
        if(count($getUserProjects)>0){
            $UserProjectIDs=[];
            foreach($getUserProjects as $userIds){
              $UserProjectIDs[]=  $userIds->uuid;
            }
        }else{
            $UserProjectIDs=[];
        }
        $UserProjectIDs = explode(",",implode("," , $UserProjectIDs));
        $unsentMailUserids = array_unique(array_diff($unsentMailUserids,$UserProjectIDs));
        //End HEre
        
        $cacheKey1="unsentMailUserids_{$country_code}";
        Cache::forget($cacheKey1);
        $usersAdditionalData=Cache::remember($cacheKey1, now()->addMinutes(60), function () use ($unsentMailUserids) {
            $userRepo = new UserRepository();

         return $userRepo->getUserAnswersByUserIds($unsentMailUserids);
         });


        if (!$usersAdditionalData || $usersAdditionalData->isEmpty() ) {
            return response()->json(['status' => 'success', 'count' => 0 ]);
        }

        $matchingUsers = [];

        $emailInviteCheck = Setting::where('key','PANEL_EMAIL_INVITE_CHECK')->first();

       /* $check_zero_pull_invites = \DB::TABLE('survey_pull_invites')->where('apace_survey_code', $apace_project_code)->first();

        if($check_zero_pull_invites){

            $time_dif = 0;

        }else{
            $time_dif = $emailInviteCheck->value;

        }*/
        $GLOBALINCOME=['STANDARD_HHI_US'=>'US','STANDARD_HHI_INT_UK'=>'UK','STANDARD_HHI_INT_CA'=>'CA','STANDARD_HHI_IN'=>'IN'];
                    $profileArr=['REGION '=>'division','STANDARD_EDUCATION'=>'GLOBAL_EDUCATION','ETHNICITY'=>'GLOBAL_ETHNICITY','GLOBAL_INCOME'=>'GLOBAL_INCOME','STATE'=>'state','DMA'=>'dma','DMA_NAME'=>'dma_name','DIVISON'=>'divison','REGION'=>'region',"STANDARD_INDUSTRIES"=>'STANDARD_INDUSTRY','STANDARD_SUFFERER_AILMENTS_II_CA'=>'STANDARD_SUFFERER_AILMENTS_I_CA','STANDARD_HH_SUFFERER_AILMENTS_II_CA'=>'STANDARD_HH_SUFFERER_AILMENTS_I_CA','STANDARD_DIAGNOSED_AILMENTS_II'=>'STANDARD_DIAGNOSED_AILMENTS_I','STANDARD_HH_DIAGNOSD_AILMENTS_II'=>'STANDARD_HH_DIAGNOSED_AILMENTS_I','STANDARD_DIAGNOSED_AILMENTS_II_UK'=>'STANDARD_DIAGNOSED_AILMENTS_I_UK','STANDARD_HH_DIAGNOSD_AILMENTS_II_UK'=>'STANDARD_HH_DIAGNOSED_AILMENTS_I_UK','PROVINCE'=>'province'];



         $countArr=[];
        foreach ($usersAdditionalData as $userData) {
            //$countArr[]=$userData->uuid;
            $user = User::where('uuid', '=', $userData->uuid)->first();
            if(isset($user)){
                $userAnswers = collect($userData->user_answers);
                $matchFlag = true;
                //\Log::info("question_ids".json_encode($qualsMaps));
                $quota_specs_details = $qualsMaps;
                $question_ids = array_column($quota_specs_details ,'PreCodes','QuestionID');
                foreach ($question_ids as $question_id => $answerValues) {

                    $valArr=array_values($question_ids[$question_id]);
                    if(!empty($answerValues[0])){
                     $key=array_search($question_id,$profileArr);
                    if(!empty($key)){
                     if($key=='GLOBAL_INCOME'){
                        $keyNew=array_search($country_code,$GLOBALINCOME);
                       
                        $question_id=$keyNew;
                         }else{

                            $question_id=trim($key);   
                         }   
                    }else{
                        $question_id=$question_id;
                    }

                        $result = $userAnswers->where('profile_question_code', '=', $question_id )->filter(function ($value) use ($answerValues,$question_id) {
                            $userSelectedAnswer = $value['selected_answer'];

                            if($userSelectedAnswer && !is_array($userSelectedAnswer)){
                                $userSelectedAnswer = array(trim($value['selected_answer']));
                            }
                            if($question_id=='STANDARD_COMPANY_DEPARTMENT'){


                            // \Log::info("Ramesh Department".json_encode($userSelectedAnswer));
                            }

                            return !empty(array_intersect((array)$answerValues, (array)$userSelectedAnswer));
                        });
                       
                    if(!$result || $result->isEmpty() ){
                       $countArr[]=$userData->uuid;
                        $matchFlag = false;
                        break 1;
                        
                    }

                }
                }
                if ($matchFlag) {
                    //$matchingUsers[] = $userData->uuid;
                    $matchingUsers[] = $user->id;
                }
            }else{

                if(($user->email_ratio > 1) && ($user->count_mail_sent < $user->email_ratio)){ 

                    $userAnswers = collect($userData->user_answers);
                    $matchFlag = true;

                    $quota_specs_details = $qualsMaps;
                    $question_ids = array_column($quota_specs_details ,'PreCodes','QuestionID');

                    //$userAnswers->where('profile_question_code', '=', 'STANDARD_VOTE');
                    //ini_set("xdebug.overload_var_dump", "off");

                    foreach ($question_ids as $question_id => $answerValues) {

                    $key=array_search($question_id,$profileArr);
                    if(!empty($key)){
                     if($key=='GLOBAL_INCOME'){
                        $keyNew=array_search($country_code,$GLOBALINCOME);
                       
                        $question_id=$keyNew;
                         }else{

                            $question_id=trim($key);   

                         }     
                    }else{
                        $question_id=$question_id;
                    }
                   // \Log::info("Rmessh Question value ELSE".$question_id);

                        $result = $userAnswers->where('profile_question_code', '=',$question_id)
                            ->filter(function ($value) use ($answerValues) {
                                $userSelectedAnswer = $value['selected_answer'];
                                if($userSelectedAnswer && !is_array($userSelectedAnswer)){
                                    $userSelectedAnswer = array(trim($value['selected_answer']));
                                }
                                return !empty(array_intersect((array)$answerValues, (array)$userSelectedAnswer));
                            });
                        if(!$result || $result->isEmpty() ){
                            $matchFlag = false;
                            break 1;

                        }
                        
                    }
                    if ($matchFlag) {
                        //$matchingUsers[] = $userData->uuid;
                        $matchingUsers[] = $user->id;
                    }

                }
            }
        }
    

        // $matchingUsers
        // $sentUserarray
        // get unmatched user data in array 1 matchingUsers
       // \Log::info("Not Match IDS".json_encode($countArr));
        return response()->json(['status' => 'success', 'count' => count($matchingUsers), 'ids' => $matchingUsers]);
    }


    public function parseCustomAgeSpec($customAge)
    {
        $ageRule = false;
        //array_shift($customAgeArray); Was Removing it earlier as additional Status value was being passed in array
        $ageRange = [];
        foreach ($customAge as $ageGroups) {
            foreach($ageGroups as $count => $age){
                $keyflag = isset($age['start'])?'start':'end';
                $ageRange[$count][$keyflag] = isset($age['start'])?$age['start']:$age['end'];

            }
        }
        $formattedAgeRange = [];
        foreach ($ageRange as $range) {
            $formattedAgeRange[] = [
                $range['start'].'-'.$range['end']
            ];
        }
        return $formattedAgeRange;
    }

    private function mapSJPanelQuestions($qualificationItems)
    {
        $questionCodes = array_keys((array)$qualificationItems);

        $questionMapping = [];
        foreach ($qualificationItems as $question_name => $precodes) {
            $questionMapped['QuestionID'] = $question_name;
            
            /*Changed Global age range to specific values instead if range*/
            if ($question_name == 'GLOBAL_AGE') {
                $ageRanges = [];
                foreach ($precodes as $range) {
                    if(isset($range[0]) && $range[0] != ""){                    
                        $arrRange = explode('-', $range[0]);
                        $ageRange = range($arrRange[0], $arrRange[1]);
                        $ageRanges = array_merge($ageRanges, $ageRange);
                    }
                }
                $questionMapped['PreCodes'] = $ageRanges;
            } else if ($question_name == 'GLOBAL_ZIP') {

                /*Hotfix for Global Zip as there was additional character status in precodes*/
                if (!empty($precodes) && ( $key = array_search('status', $precodes[0])) !== false) {
                    unset($precodes[$key]);
                }
                $zipcodes = reset($precodes);
                if ($zipcodes['values']!== false) {

                    $zipcodes = explode(",", str_replace("\r\n", ',',$zipcodes['values']));
                    $selAnswers1 = [];
                    for($zip=0;$zip<count($zipcodes);$zip++){
                          $selAnswers1[] = $zipcodes[$zip];
                        }
                        
                        $questionMapped['PreCodes'] = $selAnswers1;
                       

                }
                
            } else{
                $selectedAnswersArrr = $qualificationItems[$question_name];
                $selAnswers = [];
                foreach ($selectedAnswersArrr as $answer) {
                    if(isset($answer[0]) && $answer[0] != ""){
                        $selAnswers[] = $answer[0];
                    }
                }
                $mappedPrecodes = $selAnswers;
                $questionMapped['PreCodes'] = $mappedPrecodes;
            }
            $questionMapping[] = $questionMapped;
        }
        return $questionMapping;
    }

    public function sendTestInvite(Request $request)
    {
        // \Log::info('');
        /*var_dump("tada");
        die();*/
       // $testInviteData = $request->input('testInviteData');
        //$testIds = $testInviteData['testMailIds'];
        //unset($testInviteData['testMailIds']);
       // $project = (object)$request->input('project');
        $testIds = 'rameshintouch@gmail.com';
        $projectinfo=Project::where('id','136')->get();
        $project_data=$projectinfo[0];
 
        $testInviteData=['template_type'=>'predefined','from_name'=>'sjpanel','from_email'=>'rameshk@samplejunction','name'=>'sjpanel'];
        $userIds=[1328,1332];
        $allUserProjects = UserProject::whereIn('user_id', $userIds)
                ->with('user','project')
                ->where('project_id', '=', '137')
                ->where('status', '=', null)
                ->get();
               
        $dataArray = $testInviteData;
        $is_custom = false;
        $subject = '';
        $body = '';
        $invite_id = false;
        /*if(!array_key_exists('custom_invite_flag', $dataArray)){
            $is_custom = true;
            $templateId = $dataArray['selected_template'];
            $inviteTemplate = $this->projectRepo->getInviteTemplateById($templateId);
            $subject = $inviteTemplate->subject;
            $body = $inviteTemplate->body;
            $invite_id = $inviteTemplate->id;
        }else{
            $subject = $dataArray['custom_invite_subject'];
            $body = $dataArray['custom_invite_body'];
        }*/

         $testingIds = array_map('trim', explode(',', $testIds));

        $pointsConversionMetric = config('app.points.metric.conversion');
        $task = true;
        foreach($allUserProjects as $value){
             $locale=$value->user->locale;
            app()->setLocale($locale);
           // \Log::info(app()->getLocale());
               /* $placehodlers = [
                    '{%S_POINTS%}' => round($project->cpi/$pointsConversionMetric),
                    '{%S_CODE%}' => $project->code,
                    '{%S_LOI%}' => $project->loi,
                    '{%S_SDATE%}' => $project->start_date,
                    '{%S_EDATE%}' => $project->end_date,
                    '{%S_LINK%}' => (!empty($project->live_url))?$project->live_url:"test.com",
                    '{%S_TEST_LINK%}' => (!empty($project->test_url))?$project->test_url:"test.com",
                    '{%S_TOPIC%}' => __($project->project_topic['name']),
                    '{%U_NAME%}' => 'John'.' '.'Doe',
                    '{%U_EMAIL%}' => $email_id,
                    '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                    '{%DETAILS_2%}' => __('inpanel.mail.survey.details_1'),
                    '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project->cpi/$pointsConversionMetric)]),
                    '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project->cpi/$pointsConversionMetric),'loi' => $project->loi]),
                    '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                    '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                    '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                    '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                    '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                    '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                    '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                    '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                    '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                    '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                    '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                    '{%POINTS%}' => __('inpanel.mail.survey.points'),
                    '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                    '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                    '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                    '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                    '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                    '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                    '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                    '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                    '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                    '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                    '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                    '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                    '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                    '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                    '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                    '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                    '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                    '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                    '{%ROUTE_F%}' => route('frontend.cms.faq'),
                    '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                    '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                    '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                    '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  'rameshk@samplejunction.com']),
                    '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                    '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                    '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                    '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                    '{%YEAR%}' =>date("Y"),
                    '{%LOGO%}' => asset('img/frontend/logo.png'),
                    '{%IMAGE%}' => asset('img/inpanel/email-notification.png'),
                ];*/
                $placehodlers = [
                            '{%S_POINTS%}' => round($project_data->cpi/$pointsConversionMetric),
                            '{%S_CODE%}' => $project_data->code,
                            '{%DEVICE%}' => $this->getProjectDeviceName($project_data),
                            '{%S_LOI%}' => $project_data->loi,
                            '{%S_SDATE%}' => $project_data->start_date,
                            '{%S_EDATE%}' => $project_data->end_date,
                            '{%S_LINK%}' => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=1&points='.$pointsData:"test.com",
                            '{%S_TEST_LINK%}' => (!empty($surveyTestLink))?$surveyTestLink.'&ch=1&points='.$pointsData:"test.com",
                            '{%S_TOPIC%}' => $project_data->project_topic_name,
                            '{%U_NAME%}' => $value->user->first_name,
                            '{%U_EMAIL%}' => $value->user->email,
                            '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                            '{%DETAILS_2%}' => __('inpanel.mail.survey.details_1'),
                            '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                            '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                            '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                            '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                            '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                            '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                            '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                            '{%POINTS%}' => __('inpanel.mail.survey.points'),
                            '{%VALUE%}' => __('inpanel.mail.survey.value'),
                            '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                            '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                            '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                            '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                            '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                            '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                            '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                            '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                            '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                            '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                            '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                            '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                            '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                            '{%REWARDS_POLICY%}' =>__('frontend.index.footer.links.reward_policy'),
                            '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                            '{%ROUTE_REWARD_P%}' =>route('frontend.cms.rewards_policy'),
                            '{%ROUTE_REFERRAL_P%}' =>route('frontend.cms.referral_policy'),
                            '{%REFERRAL_POLICY%}' =>__('frontend.index.footer.links.referral_policy'),
                            '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                            '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                            '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                            '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                            '{%ROUTE_F%}' => route('frontend.cms.faq'),
                            '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                            '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                            '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                            '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                            '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                            '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                            '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                            '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                            '{%YEAR%}' =>date("Y"),
                            '{%LOGO%}' => asset('img/frontend/logo.png'),
                            '{%LOGOLINK%}' => (env('APP_URL')),
                            '{%IMAGE%}' => asset('img/inpanel/email-notification.png'),
                            '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                        ];
                    
                        $email_data = [
                            'email' => $value->user->email,
                            'from_name' => ($dataArray['name'])?$dataArray['name']:'SJ Panel',
                            // 'from_address' => ($dataArray['email'])?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                            'from_address' => config('mail.from.donotreply_address'),
                            //'subject' => ($dataArray['subject'])?$dataArray['subject']:__('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            //'subject' => __('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            'subject' => __('inpanel.mail.survey.survey_subject_new'),
                        
                        ];
                     //$email = new SurveyTestInvite($email_data, $placehodlers);
                               // Mail::send($email);
                                 //   $counMail = 1+$value->user->count_mail_sent;
        
                                 //   $updateMailSent = User::where('id','=',$value->user->id)
                                  //  ->update(['count_mail_sent'=>$counMail]);
                                  //  $mailers[] = $value->user->uuid;   
            
            $task = "done";
            //Mail::send($email);
        }
        return response()->json([$task], 200);
    }

    public function getProjectDeviceName($project)
    {
        $allProjectDevice = $project->device_options;
        $projectDevice = explode(',',$allProjectDevice);
        
        $retunDevice=[];
        foreach($projectDevice as $device){
            
            if($device==2){
                $retunDevice[] = "DESKTOP";
            } 
            if($device==3){
                $retunDevice[] = "PHONE";
            }
            if($device==4){
                $retunDevice[] = "TABLET";
            }
            
        }

        return implode('/',$retunDevice);

    }

    public function sendInvitePulledUser(Request $request)
    {
      
        // var_dump("tada");
        // die();
        //$locale="es_US";
        //app()->setLocale($locale);
        
        $userIds = [];
        $testInviteData = $request->input('testInviteData');
        $projectData = $request->input('project');
        $apace_project_code=$projectData['code'];
        $emailInviteCheck = Setting::where('key','PANEL_EMAIL_INVITE_CHECK')->first();
        $check_zero_pull_invites = \DB::TABLE('survey_pull_invites')->where('apace_survey_code', $apace_project_code)->first();

        if($check_zero_pull_invites){

            $time_dif = 0;

        }else{
            $time_dif = $emailInviteCheck->value;

        }

        $user_uuids = explode(',', $testInviteData['uuids']);
        //\Log::info("Ramesh brefore".json_encode($user_uuids));
          //Code Added By Ramesh Kamboj//
             $lang=$projectData['language_code'];
             $con=$projectData['country_code'];
            //END HERE//
             $locale=strtolower($lang).'_'.$con;
             //\Log::info("Ramesh".$locale);
        //$get_all_users = User::whereIn('uuid', $user_uuids)->where('locale',$locale)->get();

             $get_all_users = User::whereIn('id', $user_uuids)->where('locale',$locale)->get();

     //\Log::info("Ramesh After".json_encode($get_all_users));
        $project_code = $projectData['code'];
        foreach($get_all_users as $user){
            $userIds[] = $user->id;
        }
        //\Log::info("Ramesh After".json_encode($userIds));
        $projectQuota = ProjectQuota::where('apace_quota_id', '=', $testInviteData['quotaId'])
        ->first();
       //\Log::info("Ramesh".$projectQuota->id);
        if(!isset($projectQuota->id)){
           return response()->json([], 404);die;
        }

        $project = Project::where('id', '=', $projectQuota->project_id)->first();


       
      //  $project = Project::where('code', '=', $project_code)->first();
        //project entries are not there in projects table
        //error webdecorum


       
        // Added by obhi
       //$data = $this->ReminderAfter24AlreadyPulldone($apace_project_code);
    //    return response()->json([$data]);

        // ****************
        
        if( $project && $project->survey_status_code == 'LIVE' ){
            $sjpanelprojectid = $project->id;
            
            // $projectQuota = ProjectQuota::where('apace_quota_id', '=', $testInviteData['quotaId'])
            //     ->first();
               
            //     if(!isset($projectQuota->id)){
            //        return response()->json([], 404);die;
            //     }
            //projectquota table don't having entries
            //error webdecorum
            
            foreach($userIds as $id){
                // $getUserProjects = UserProject::where('user_id','=', $id)
                //     ->where('project_id', '=', $project->id)
                //     ->first();
                $getUserProjects = UserProject::where('user_id', '=', $id)
                            ->where('apace_project_code', '=', $project->apace_project_code)
                            ->first();
                // $projectIds = Project::where('apace_project_code','=',$project->apace_project_code)->get()->pluck('id');

                // $user_project = UserProject::where('user_id','=',$id)->whereIn('project_id',$projectIds)->first();
                if(!$getUserProjects){
                    $pointsConversionMetric = config('app.points.metric.conversion');
                    $add_project = [
                        'user_id' => $id,
                        'project_id' => $project->id,
                        'cpi' => $project->cpi,
                        'points' => round($project->cpi/$pointsConversionMetric),
                        'project_quota_id' => $projectQuota->id,
                        'user_live_link' => $project->live_url,
                        'user_test_link' => $project->test_url,
                        'apace_project_code' => $project->apace_project_code,
                    ];
                    $createUserProject = UserProject::create($add_project);
                    $userIds[] = $createUserProject->id;
                }
            }
            
            $allUserProjects = UserProject::whereIn('user_id', $userIds)
                ->with('user','project')
                ->where('project_id', '=', $project->id)
                ->where('status', '=', null)
                ->get();
               
            /*$testIds = $testInviteData['testMailIds'];
            unset($testInviteData['testMailIds']);*/
            $project = (object)$request->input('project');
            $dataArray = $testInviteData;
            $is_custom = false;
            $subject = '';
            $body = '';
            $invite_id = false;
            $mailers = [];
           

            foreach($allUserProjects as $value){
                // \Log::info("Ramesh In Loop");
                if(count($mailers) >= $dataArray['currentInviteeCount']){

                    break;
                }

                if($value->user->is_blacklist == 0){
                   // \Log::info("If Case".$time_dif);
                    if(!$value->user->mail_sent_at || $value->user->mail_sent_at < Carbon::now()->subHours($time_dif)->toDateTimeString()){
                         //$locale=$value->user->locale;
                       // app()->setLocale($locale);
                        $project_data = $value->project;
                        $surveyid = $value->id."?sid=".$createInviteId=1;
                        //print_r($project_data);die;
                        $pointsConversionMetric = config('app.points.metric.conversion');
                        $surveyLiveLink = $this->getSurveyLink($value->user,$project_data,'live_url');
                        $surveyTestLink = $this->getSurveyLink($value->user,$project_data,'test_url');
                        // $project_value = Project::where('key','cpi')->first();    
                        $pointsData = round($project_data->cpi/$pointsConversionMetric);

                        $locale=$value->user->locale;
                        app()->setLocale($locale);
                        
                        /* Parshant Sharma [24-08-2024] STARTS */
                            $localeGet = app()->getLocale();

                            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                            
                            $metricConversion = round(1/$countryPoints, 4);
                            $countrySymbol    = $countryPoint->currency_symbols;
                            
                        /* Parshant Sharma [24-08-2024] ENDS */

                         $project_value = $project_data->cpi;

                        $placehodlers = [
                            '{%S_POINTS%}' => round($project_data->cpi/$pointsConversionMetric),
                            '{%S_CODE%}' => $project_data->apace_project_code,
                            '{%DEVICE%}' => $this->getProjectDeviceName($project_data),
                            '{%S_LOI%}' => $project_data->loi,
                           // '{%VALUE%}' => $project_data->cpi,
                            '{%VALUE%}' => number_format(($pointsData/$countryPoints),2),
                            '{%S_SDATE%}' => $project_data->start_date,
                            '{%S_EDATE%}' => $project_data->end_date,
                            '{%S_LINK%}' => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=2&points='.$pointsData:"test.com",
                            '{%S_TEST_LINK%}' => (!empty($surveyTestLink))?$surveyTestLink.'&ch=2&points='.$pointsData:"test.com",
                            '{%S_TOPIC%}' => $project_data->project_topic_name,
                            '{%U_NAME%}' => $value->user->first_name,
                            '{%U_EMAIL%}' => $value->user->email,
                            '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                            '{%DETAILS_2%}' => __('inpanel.mail.survey.details_1'),
                            '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                            '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                            '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                            '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                            '{%ENTER%}'             => __('inpanel.mail.survey.enter'),
                            '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                            '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                            '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                            '{%POINTS%}' => __('inpanel.mail.survey.points'),
                            '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                            '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                              '{%ENTER%}'  => __('inpanel.mail.survey.enter'),
                            '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                            '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                            '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                            '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                            '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                            '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                            '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                            '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                            '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                            '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                            '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                            '{%REWARDS_POLICY%}' =>__('frontend.index.footer.links.reward_policy'),
                            '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                            '{%ROUTE_REWARD_P%}' =>route('frontend.cms.rewards_policy'),
                            '{%ROUTE_REFERRAL_P%}' =>route('frontend.cms.referral_policy'),
                            '{%REFERRAL_POLICY%}' =>__('frontend.index.footer.links.referral_policy'),
                            '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                            '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                            '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                            '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                            '{%ROUTE_F%}' => route('frontend.cms.faq'),
                            '{%LOGOLINK%}' =>env('APP_URL'),
                            '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                            '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                            '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                            '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
                            '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                            '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                            '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                            '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                            '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                            '{%YEAR%}' =>date("Y"),
                            '{%LOGO%}' => asset('img/frontend/logo.png'),
                            '{%IMAGE%}' => asset('img/img_email/survey1.png'),


                            '{%ROUTE_CONT%}'        => route('frontend.cms.help_support'),
                            '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),

                            
                            '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
                            '{%NEW_CONTENT%}' => __('inpanel.mail.survey.new_content'),
                            '{%FACEBOOK%}' => asset('img/email_temp/fb.png'),
                            '{%INDEED%}' => asset('img/email_temp/ind.png'),
                            '{%TWITTER%}' => asset('img/email_temp/twitter.png'),
                            '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                            '{%countrySymbol%}'=>__('inpanel.redeem.index.title_history_2'),

                        ];
                        $points_val = round($project_data->cpi/$pointsConversionMetric);
                        $email_data = [
                            'email' => $value->user->email,
                            'from_name' => (@$dataArray['name'])?@$dataArray['name']:'SJ Panel',
                            // 'from_address' => ($dataArray['email'])?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                            'from_address' => config('mail.from.donotreply_address'),
                            //'subject' => ($dataArray['subject'])?$dataArray['subject']:__('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            //'subject' => __('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),

                            //'subject' => __('inpanel.mail.survey.survey_subject_new',['survey_points' => round($project_data->cpi)]),
                            'subject' => __('inpanel.mail.survey.survey_subject_new',['survey_points' => number_format($pointsData/$countryPoints, 2)]),

                        
                        ];
                        //print_r($email_data);//die;
                       
                        //if( $value->user->user_group == $value->project->project_type ){
                            $email = new SurveyTestInvite($email_data, $placehodlers);
                            //\Log::info("If 2".$email);
                            Mail::send($email);
                          
                                $updateMailSent = User::where('id','=',$value->user->id)
                                ->update(['mail_sent_at' => date("Y-m-d h:i:s"),'count_mail_sent'=>1]);
                                $mailers[] = $value->user->uuid;
                               
                        //}
                    // print_r($email);
                    }else{

                        if(($value->user->email_ratio > 1) && ($value->user->count_mail_sent < $value->user->email_ratio)){
                        // \Log::info("email_ratio".$time_dif); 

                            $project_data = $value->project;
                            $surveyid = $value->id."?sid=".$createInviteId=1;
                            //print_r($project_data);die;
                            $pointsConversionMetric = config('app.points.metric.conversion');
                            $surveyLiveLink = $this->getSurveyLink($value->user,$project_data,'live_url');
                            $surveyTestLink = $this->getSurveyLink($value->user,$project_data,'test_url');
                            $pointsData = round($project_data->cpi/$pointsConversionMetric);
                            $locale=$value->user->locale;
                            app()->setLocale($locale);
                            
                            /* Parshant Sharma [24-08-2024] STARTS */
                                $localeGet = app()->getLocale();

                                $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                                $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                                
                                $metricConversion = round(1/$countryPoints, 4);
                                $countrySymbol    = $countryPoint->currency_symbols;
                                
                            /* Parshant Sharma [24-08-2024] ENDS */
                        
                            $placehodlers = [
                                '{%S_POINTS%}' => round($project_data->cpi/$pointsConversionMetric),
                                '{%S_CODE%}' => $project_data->apace_project_code,
                                '{%DEVICE%}' => $this->getProjectDeviceName($project_data),
                                '{%S_LOI%}' => $project_data->loi,

                                //'{%VALUE%}' => $project_data->cpi,
                                '{%VALUE%}' => number_format(($pointsData/$countryPoints),2),
                                '{%S_SDATE%}' => $project_data->start_date,
                                '{%S_EDATE%}' => $project_data->end_date,
                                '{%S_LINK%}' => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=2&points='.$pointsData:"test.com",
                                '{%S_TEST_LINK%}' => (!empty($surveyTestLink))?$surveyTestLink.'&ch=2&points='.$pointsData:"test.com",
                                '{%S_TOPIC%}' => $project_data->project_topic_name,
                                '{%U_NAME%}' => $value->user->first_name,
                                '{%U_EMAIL%}' => $value->user->email,
                                '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                                '{%DETAILS_2%}' => __('inpanel.mail.survey.details_1'),
                                '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                                '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                                '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                                '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                                '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
                                '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                                '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                                '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                                '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                                '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                                '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                                '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                                '{%POINTS%}' => __('inpanel.mail.survey.points'),
                                '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                                '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                                '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                                '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                                '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                                '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                                '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                                '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                                '{%ENTER%}'             => __('inpanel.mail.survey.enter'),
                                '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                                '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                                '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                                '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                                '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                                '{%REWARDS_POLICY%}' =>__('frontend.index.footer.links.reward_policy'),
                                '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                                '{%ROUTE_REWARD_P%}' =>route('frontend.cms.rewards_policy'),
                                '{%ROUTE_REFERRAL_P%}' =>route('frontend.cms.referral_policy'),
                                '{%REFERRAL_POLICY%}' =>__('frontend.index.footer.links.referral_policy'),
                                '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                                '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                                '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                                '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                                '{%ROUTE_F%}' => route('frontend.cms.faq'),
                                '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                                '{%LOGOLINK%}' => env('APP_URL'),
                                '{%LOGO%}' => asset('img/frontend/logo.png'),
                                '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                                '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                                '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                                '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                                '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                                '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                                '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                                '{%YEAR%}' =>date("Y"),
                                '{%LOGO%}' => asset('img/frontend/logo.png'),
                                '{%IMAGE%}' => asset('img/img_email/survey1.png'),
                                '{%FACEBOOK%}' => asset('img/email_temp/fb.png'),
                                '{%INDEED%}' => asset('img/email_temp/ind.png'),
                                '{%TWITTER%}' => asset('img/email_temp/twitter.png'),
                                '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
                                '{%NEW_CONTENT%}' => __('inpanel.mail.survey.new_content'),
                                '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                                '{%countrySymbol%}'=>__('inpanel.redeem.index.title_history_2'),
                            ];
                             
                            $email_data = [
                                'email' => $value->user->email,
                                'from_name' => (@$dataArray['name'])?@$dataArray['name']:'SJ Panel',
                                'from_address' => (@$dataArray['email'])?@$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                                //'subject' => ($dataArray['subject'])?$dataArray['subject']:__('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                                //'subject' => __('inpanel.mail.survey.survey_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                                //'subject' => __('inpanel.mail.survey.survey_subject_new',['survey_points' => round($project_data->cpi)]),
                                'subject' => __('inpanel.mail.survey.survey_subject_new',['survey_points' => number_format($pointsData/$countryPoints, 2)]),
                            
                            ];
                           
                            //print_r($email_data);//die;
                            
                            //if( $value->user->user_group == $value->project->project_type ){
                                    $email = new SurveyTestInvite($email_data, $placehodlers);
                               
                                    Mail::send($email);
                                    $counMail = 1+$value->user->count_mail_sent;
        
                                    $updateMailSent = User::where('id','=',$value->user->id)
                                     ->update(['mail_sent_at' => date("Y-m-d h:i:s"),'count_mail_sent'=>$counMail]);
                                   
                                    $mailers[] = $value->user->uuid;
                                    // \Log::info($mailers);
                            //}
                        // print_r($email);

                        }   
                    }
                }
            }
            //die;
            $task = "done";
           
            if(isset($mailers)){
                $mailsCount = count($mailers);
        // \Log::info($mailers);
                if($mailsCount!=0){
                    $dates =date("Y-m-d");
                    $inviteDetails = [
                        "project_id" => $sjpanelprojectid,
                        "project_quota_id" => $projectQuota->id,
                        "apace_project_code" => $project_code,
                        "apace_project_quota_id" => $testInviteData['quotaId'],
                        "user_ids" => implode(',',$mailers),
                        "created_at" =>$dates,
                        'invitecnt' => $mailsCount,
                        'reminder' => 0,
                        'surveycnt' => 0
                    ];            
                    //var_dump($inviteDetails); 
                        $createInviteId = InviteSentDetails::create($inviteDetails)->id;
                        return response()->json(['sent' => $mailsCount, 'ids' => $mailers, 'sjinvitesentid' => $createInviteId ,'islive' =>1], 200);
                }else{
                    return response()->json(['sent' => $mailsCount, 'ids' => $mailers, 'sjinvitesentid' => 0 ,'islive' =>1], 200);
                }        
            }else{
                 return response()->json([], 404);
            }

        }else{
            return response()->json(['sent' => 0, 'ids' => 0, 'sjinvitesentid' => 0,'islive' =>0], 200);
        }
        
    }

    public function sendInvitePulledUserReminder(Request $request)
    {
        /*var_dump("tada");
        die();*/

        $userIds = [];
        $testInviteData = $request->input('testInviteData');
        $testInviteData['uuids'] = rtrim($testInviteData['uuids'], ",");
        $olduser_uuids = explode(',', $testInviteData['uuids']);
        $projectData = $request->input('project');
        $project_code = $projectData['code'];
        $user_uuids = array_unique($olduser_uuids); 

        
        
        //$get_all_users = User::whereIn('uuid', $user_uuids)->get();
        $get_all_users = User::whereIn('id', $user_uuids)->get();
        foreach($get_all_users as $user){
            $userIds[] = $user->id;
        }


        //$project = Project::where('code', '=', $project_code)->first();

        $projectQuota = ProjectQuota::where('apace_quota_id', '=', $testInviteData['quotaId'])
        ->first();
       // \Log::info("Ramesh".$projectQuota->id);
        if(!isset($projectQuota->id)){
           return response()->json([], 404);die;
        }

        $project = Project::where('id', '=', $projectQuota->project_id)->first();

        if( $project && $project->survey_status_code == 'LIVE' ){

            
            // $projectQuota = ProjectQuota::where('apace_quota_id', '=', $testInviteData['quotaId'])->first();

            foreach($userIds as $id){
                // $getUserProjects = UserProject::where('user_id','=', $id)
                //     ->where('project_id', '=', $project->id)
                //     ->first();
                $getUserProjects = UserProject::where('user_id', '=', $id)
                            ->where('apace_project_code', '=', $project->apace_project_code)
                            ->first();
                // $projectIds = Project::where('apace_project_code','=',$project->apace_project_code)->get()->pluck('id');

                // $user_project = UserProject::where('user_id','=',$id)->whereIn('project_id',$projectIds)->first();

                if(!$getUserProjects){
                    $pointsConversionMetric = config('app.points.metric.conversion');
                    $add_project = [
                        'user_id' => $id,
                        'project_id' => $project->id,
                        'cpi' => $project->cpi,
                        'points' => round($project->cpi/$pointsConversionMetric),
                        'project_quota_id' => $projectQuota->id,
                        'user_live_link' => $project->live_url,
                        'user_test_link' => $project->test_url,
                        'apace_project_code' => $project->apace_project_code,
                    ];
                    //$createUserProject = UserProject::create($add_project);
                    //$userIds[] = $createUserProject->id;
                }
            }
           
            $allUserProjects = UserProject::whereIn('user_id', $userIds)
                ->with('user','project')
                ->where('project_id', '=', $project->id)
                ->where('status', '=', null)
                ->get();
            /*$testIds = $testInviteData['testMailIds'];
            unset($testInviteData['testMailIds']);*/
            $project = (object)$request->input('project');
            $dataArray = $testInviteData;
            $is_custom = false;
            $subject = '';
            $body = '';
            $invite_id = false;
            $mailers = [];

            foreach($allUserProjects as $value){

                if($value->user->is_blacklist == 0){ 
                
                    if(!$value->user->mail_sent_at || $value->user->mail_sent_at < Carbon::now()->subDays(0)->toDateTimeString()){
                        
                        $project_data = $value->project;
                        $surveyid = $value->id;
                        $pointsConversionMetric = config('app.points.metric.conversion');
                        $surveyLiveLink = $this->getSurveyLink($value->user,$project_data,'live_url');
                        $surveyTestLink = $this->getSurveyLink($value->user,$project_data,'test_url');
                        $pointsData = round($project_data->cpi/$pointsConversionMetric);
                        $project_value = $project_data->cpi;
                         $locale=$value->user->locale;
                         app()->setLocale($locale);
                         
                        /* Parshant Sharma [24-08-2024] STARTS */
                            $localeGet = app()->getLocale();

                            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                            
                            $metricConversion = round(1/$countryPoints, 4);
                            $countrySymbol    = $countryPoint->currency_symbols;
                            
                        /* Parshant Sharma [24-08-2024] ENDS */                      

                        $placehodlers = [
                            '{%S_POINTS%}' => round($project_data->cpi/$pointsConversionMetric),
                            '{%S_CODE%}' => $project_data->apace_project_code,
                            '{%DEVICE%}' => $this->getProjectDeviceName($project_data),
                            '{%S_LOI%}' => $project_data->loi,
                            '{%S_SDATE%}' => $project_data->start_date,
                            //'{%VALUE%}'   =>  $project_data->cpi,
                            '{%VALUE%}'   =>  number_format(($pointsData/$countryPoints),2),
                            '{%S_EDATE%}' => $project_data->end_date,
                            '{%S_LINK%}' => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=2&points='.$pointsData:"test.com",
                            '{%S_TEST_LINK%}' => (!empty($surveyTestLink))?$surveyTestLink.'&ch=2&points='.$pointsData:"test.com",
                            '{%S_TOPIC%}' => __($project_data->project_topic_name),
                            '{%U_NAME%}' => $value->user->first_name,
                            '{%U_EMAIL%}' => $value->user->email,
                            '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),

                            '{%DETAILS_2%}' => __('inpanel.mail.survey.reminderdetails_1',['survey_num' => $project_data->apace_project_code]),

                            '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
                            '{%NEW_CONTENT%}' => __('inpanel.mail.survey.new_content'),

                            
                            '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                            '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                            '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                            '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                            '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                            '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                            '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                            '{%POINTS%}' => __('inpanel.mail.survey.points'),
                            '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                            '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                            '{%ENTER%}'    => __('inpanel.mail.survey.enter'),
                            '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                            '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                            '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                            '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                            '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                            '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                            '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                            '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
                            '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                            '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                            '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                            '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                            '{%REWARDS_POLICY%}' =>__('frontend.index.footer.links.reward_policy'),
                            '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                            '{%ROUTE_REWARD_P%}' =>route('frontend.cms.rewards_policy'),
                            '{%ROUTE_REFERRAL_P%}' =>route('frontend.cms.referral_policy'),
                            '{%REFERRAL_POLICY%}' =>__('frontend.index.footer.links.referral_policy'),
                            '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                            '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                            '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                            '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                            '{%ROUTE_F%}' => route('frontend.cms.faq'),
                            '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                            '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                            '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                            '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                            '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                            '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                            '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                            '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                            '{%YEAR%}' =>date("Y"),
                            '{%LOGO%}' => asset('img/frontend/logo.png'),
                            '{%IMAGE%}' => asset('img/img_email/survey1.png'),
                            '{%FACEBOOK%}' => asset('img/email_temp/fb.png'),
                            '{%INDEED%}' => asset('img/email_temp/ind.png'),
                            '{%LOGOLINK%}' => (env('APP_URL')),
                            '{%TWITTER%}' => asset('img/email_temp/twitter.png'),
                            '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                            '{%countrySymbol%}'=>__('inpanel.redeem.index.title_history_2'),
                        ];
                        $email_data = [
                            'email' => $value->user->email,
                            'from_name' => (!empty($dataArray['name']))?$dataArray['name']:'SJ Panel',
                            //'from_address' => (!empty($dataArray['email']))?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                            'from_address' => config('mail.from.donotreply_address'),
                            //'subject' => (!empty($dataArray['subject']))?$dataArray['subject']:__('inpanel.mail.survey.reminder_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            //'subject' => __('inpanel.mail.survey.reminder_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                            //'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' => round($project_data->cpi)] ),
                            'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' => number_format($pointsData/$countryPoints, 2)] ),
                        ];
                        
                        //if( $value->user->user_group == $value->project->project_type ){
                            $email = new SurveyTestInvite($email_data, $placehodlers);
                            Mail::send($email);

                            $updateMailSent = User::where('id','=',$value->user->id)
                                    ->update(['mail_sent_at' => date("Y-m-d h:i:s"),'count_mail_sent'=>1]);
                            $mailers[] = $value->user->uuid;

                        //}

                    /* InviteSentDetails::whereRaw('FIND_IN_SET("'.$value->user->id.'",user_ids)')
                        ->update([
                        'reminder'=> \DB::raw('reminder+1'), 
                        'updated_at' => Carbon::now()
                        ]);*/
                    
                    }else{

                        if(($value->user->email_ratio > 1) && ($value->user->count_mail_sent < $value->user->email_ratio)){

                            $project_data = $value->project;
                            $surveyid = $value->id;
                            $pointsConversionMetric = config('app.points.metric.conversion');
                            $surveyLiveLink = $this->getSurveyLink($value->user,$project_data,'live_url');
                            $surveyTestLink = $this->getSurveyLink($value->user,$project_data,'test_url');
                            $pointsData = round($project_data->cpi/$pointsConversionMetric);
                            $project_value = $project_data->cpi;
                            
                            /* Parshant Sharma [24-08-2024] STARTS */
                                $localeGet = app()->getLocale();

                                $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                                $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                                
                                $metricConversion = round(1/$countryPoints, 4);
                                $countrySymbol    = $countryPoint->currency_symbols;
                                
                            /* Parshant Sharma [24-08-2024] ENDS */      
                        
                            $placehodlers = [
                                '{%S_POINTS%}' => round($project_data->cpi/$pointsConversionMetric),
                                '{%S_CODE%}' => $project_data->apace_project_code,
                                '{%DEVICE%}' => $this->getProjectDeviceName($project_data),
                                '{%S_LOI%}' => $project_data->loi,
                                '{%S_SDATE%}' => $project_data->start_date,
                                //'{%VALUE%}'   =>   $project_data->cpi,
                                '{%VALUE%}'   => number_format(($pointsData/$countryPoints),2),
                                '{%S_EDATE%}' => $project_data->end_date,
                                '{%S_LINK%}' => (!empty($surveyLiveLink))?$surveyLiveLink.'&ch=2&points='.$pointsData:"test.com",
                                '{%S_TEST_LINK%}' => (!empty($surveyTestLink))?$surveyTestLink.'&ch=2&points='.$pointsData:"test.com",
                                '{%S_TOPIC%}' => __($project_data->project_topic_name),
                                '{%U_NAME%}' => $value->user->first_name,
                                '{%U_EMAIL%}' => $value->user->email,
                                '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                                '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                                '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project_data->cpi/$pointsConversionMetric),'loi' => $project_data->loi]),
                                '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                                '{%DETAILS_6%}' => __('inpanel.mail.survey.details_5'),
                                '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
                                '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
                                '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
                                '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
                                '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                                '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                                '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                                '{%POINTS%}' => __('inpanel.mail.survey.points'),
                                '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                                '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                                '{%LINE_TEXT%}' => __('inpanel.mail.survey.link_text'),
                                '{%FOOTER_1%}' => __("strings.emails.auth.confirmation.footer"),
                                '{%FOOTER_2%}' =>  __("strings.emails.auth.confirmation.footer_1"),
                                '{%FOOTER_3%}' => __("frontend.welcome_mail.team"),
                                '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
                                '{%FOOTER_DETAILS%}' =>__("strings.emails.auth.confirmation.details_3"),
                                '{%REGARDS%}' => __('inpanel.mail.survey.regards'),
                                '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                                '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                                '{%POLICY%}' => __("frontend.index.footer.links.privacy_policy"),
                                '{%SAFEGUARDS%}' =>__("strings.emails.auth.confirmation.safeguards"),
                                '{%COOKIE%}' =>__("strings.emails.auth.confirmation.cookie"),
                                '{%REWARDS_POLICY%}' =>__('frontend.index.footer.links.reward_policy'),
                                '{%T_CONDITION%}' =>__("frontend.index.footer.links.term_condition"),
                                '{%ROUTE_REWARD_P%}' =>route('frontend.cms.rewards_policy'),
                                '{%ROUTE_REFERRAL_P%}' =>route('frontend.cms.referral_policy'),
                                '{%REFERRAL_POLICY%}' =>__('frontend.index.footer.links.referral_policy'),
                                '{%ROUTE_TC%}' => route('frontend.cms.term_condition'),
                                '{%ROUTE_S%}' => route('frontend.cms.safeguard'),
                                '{%ROUTE_C%}' => route('frontend.cms.cookie'),
                                '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                                '{%ROUTE_F%}' => route('frontend.cms.faq'),
                                '{%FAQ%}' =>__("strings.emails.auth.confirmation.faq"),
                                '{%DISCLAIMER%}' => __("strings.frontend.disclaimer"),
                                '{%DISCLAIMER_1%}' => __("strings.frontend.disclaimer_1"),
                                '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $value->user->email]),
                                '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
                                '{%COPYRIGHT%}' =>__("strings.emails.auth.confirmation.copyright"),
                                '{%COPYRIGHT_COMPANY%}' =>__("strings.emails.auth.confirmation.copyrightcompany"),
                                '{%ALL_RIGHT%}' =>__("strings.emails.auth.confirmation.all_right"),
                                '{%YEAR%}' =>date("Y"),
                                '{%LOGO%}' => asset('img/frontend/logo.png'),
                                '{%IMAGE%}' => asset('img/inpanel/email-notification.png'),
                                '{%FACEBOOK%}' => asset('img/email_temp/fb.png'),
                                '{%INDEED%}' => asset('img/email_temp/ind.png'),
                                '{%TWITTER%}' => asset('img/email_temp/twitter.png'),
                                '{%LOGOLINK%}' => (env('APP_URL')),
                                '{%DETAILS_2%}' => __('inpanel.mail.survey.reminderdetails_1',['survey_num' => $project_data->apace_project_code]),
                                '{%device_before_content%}'=>__('inpanel.mail.invitation.device_before_content'),
                                '{%countrySymbol%}'=>__('inpanel.redeem.index.title_history_2'),
                            ];
                            $email_data = [
                                'email' => $value->user->email,
                                'from_name' => (!empty($dataArray['name']))?$dataArray['name']:'SJ Panel',
                                'from_address' => (!empty($dataArray['email']))?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                                //'subject' => (!empty($dataArray['subject']))?$dataArray['subject']:__('inpanel.mail.survey.reminder_subject',['points' => round($project_data->cpi/$pointsConversionMetric)]),
                                //'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' => round($project_data->cpi)]),

                                'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' =>number_format($pointsData/$countryPoints, 2)]),

                            ];
                            
                            //if( $value->user->user_group == $value->project->project_type ){
                                $email = new SurveyTestInvite($email_data, $placehodlers);
                                Mail::send($email);

                                    $counMail = 1+$value->user->count_mail_sent;
        
                                    $updateMailSent = User::where('id','=',$value->user->id)
                                    ->update(['count_mail_sent'=>$counMail]);
                                        
                                $mailers[] = $value->user->uuid;

                            //}

                        /* InviteSentDetails::whereRaw('FIND_IN_SET("'.$value->user->id.'",user_ids)')
                            ->update([
                            'reminder'=> \DB::raw('reminder+1'), 
                            'updated_at' => Carbon::now()
                            ]);*/
                        }

                    }
                }      
               
            }
            $task = "done";
            /* $testingIds = array_map('trim', explode(',', $testIds));
             $pointsConversionMetric = config('app.points.metric.conversion');
             $task = true;
             foreach ($testingIds as $email_id) {


                 if($dataArray['template_type'] && $dataArray['template_type']=="custom"){
                     $body = $dataArray['body'];
                     $placehodlers['{%BODY%}'] = strtr($body, $placehodlers);
                 }
                 if( $dataArray['template_type'] && $dataArray['template_type']=="custom" ){
                     $email = new SurveyCustomInvite($email_data, $placehodlers);
                 }else if( $dataArray['template_type'] && $dataArray['template_type'] == "predefined" ){
                     $email = new SurveyTestInvite($email_data, $placehodlers);
                 }
                 $task = "done";
                 Mail::send($email);
             }*/
        }
        $mailsCount = count($mailers);
        return response()->json(['sent' => $mailsCount, 'ids' => $mailers], 200);
    }

    public function surveyResponse()
    {
        $invite_sent_details = \DB::table('invite_sent_details')->select(\DB::raw('SUM(invitecnt) as icnt'),\DB::raw('SUM(surveycnt) as scnt'))->where('created_at',">=",now()->subDays(30)->endOfDay())->get();
        //echo "<pre>";print_r($invite_sent_details);die;

        return response()->json($invite_sent_details);
    }


    // This function insert survey start count by cron
    public function insertSurveyStartCount()
    {
        
        $fromDate = now()->subDays(2)->endOfDay();
        $toDate  = now()->subDays(1)->endOfDay();

        
        $is_exit = SurveyStartCount::whereDate('createdOn',Carbon::now()->startOfDay())->count();

        if($is_exit == 0){
            $resultData = Traffic::where('source_code','SJPL')
            ->where('channel_id',1)
            ->where('created_at', '>', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();

                $count_data = count($resultData);
                if($count_data>0){
                    $add_data =array(
                        'start_count' => $count_data,
                        'start_date'  => $toDate
                    );
                    SurveyStartCount::create($add_data); 
                }

                return response()->json('data insert', 200);
        }else{
                return response()->json('Not duplicate entry', 200);
        }

    }

    public function updateResponseRate()
    {
        $fromLastDays = config('app.update_response_rate.days');

        $fromDate = now()->subDays($fromLastDays)->endOfDay();
        $toDate   = now()->subDays(1)->endOfDay();

        $resultData = SurveyStartCount::selectRaw('SUM(start_count) as startCount')
                                    ->where('start_date', '>', $fromDate)
                                    ->where('start_date', '<=', $toDate)
                                    ->first();
        $invite_sent_details = \DB::table('invite_sent_details')
                                ->select(\DB::raw('SUM(reminder) as rcnt'),\DB::raw('SUM(invitecnt) as icnt'),\DB::raw('SUM(surveycnt) as scnt'))
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->orWhereBetween('updated_at', [$fromDate, $toDate])->first();

        $totalStart  = $resultData->startCount;
        $totalInvite =  ($invite_sent_details->icnt)?$invite_sent_details->icnt:0;

        //return response()->json(['totalInvite' => $totalInvite, 'totalStart' => $totalStart], 200); 
       if($totalInvite > 0){
            $resposeRate = round(($totalStart/$totalInvite)*100);
            $update_data =array(
                'response_rate' => $resposeRate,
                'updateOn'      => $toDate
            ); 
            SjpanelResponserates::where('id',1)->update($update_data);

            return response()->json(['response_rate' => $resposeRate, 'updated_date' => Carbon::parse($toDate)], 200);
        }else{
            return response()->json(['response_rate' => 0, 'updated_date' => ''], 200); 
        }

        
    }

    private function getSurveyLink($user,$project,$url_type_column)
    {

        $client_var = [config('app.vvars.user_id')];
        $client_redirect_link = $project->$url_type_column;
        $parameters = explode('&',$client_redirect_link);
        
        foreach ($parameters as $key=>$value){
            $param = explode('=',$value);
            foreach($param as $param_var){
                if(in_array($param_var,$client_var)){
                    unset($parameters[$key]);
                    $new_pid = $param_var.'='.$user->uuid.'_'.$project->code;
                    $new_parameter = array_push($parameters,$new_pid);
                }
            }
        }
        $client_redirect_new_link = implode('&',$parameters);
        //print_r($client_redirect_new_link);
        //die;
        return $client_redirect_new_link;
    }

    public function ReminderAfter24AlreadyPulldone($apace_project_code){

          $code = $apace_project_code;
          $reminderTime = Setting::where('key','REMINDER_INVITE_TIME')->first();
          $time = $reminderTime->value;
            $users = DB::table('user_projects')
                    ->where('user_projects.apace_project_code', '=',$code)
                    ->select('users.*','user_projects.*','projects.*','project_quotas.apace_quota_id as apace_p_quota_id','user_projects.project_quota_id as apace_project_quota_id')
                    ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                    ->join('users', 'users.id', '=', 'user_projects.user_id')
                    ->join('project_quotas', 'project_quotas.project_id', '=', 'user_projects.project_id')
                    // ->where('users.id','=',2042)
                    ->where('projects.survey_status_code', '=', 'LIVE')
                    ->whereNull('user_projects.status')
                    ->whereDate('user_projects.created_at', '<', now()->subHours($time))
                    ->orderBy('projects.cpi', 'desc')
                    ->get();

          $users_invited = DB::table('invite_sent_details')
                          ->where('invite_sent_details.apace_project_code', '=',$code )
                          ->whereDate('invite_sent_details.created_at', '<', now()->subHours($time))
                          ->join('projects', 'projects.id', '=', 'invite_sent_details.project_id')
                          ->where('projects.survey_status_code', '=', 'LIVE')

                          ->where('invite_sent_details.reminder','=',0)

                          ->get();
            
         if (isset($users_invited) && !empty($users_invited)) {
               $user_invite_reminder_id = [];
               $user_invite_reminder_uuids = [];
                        
               foreach ($users_invited as $user_invite) {
                    $user_invite_reminder_id[] = $user_invite->id;
                    $invite_detail = explode(',', $user_invite->user_ids);
                    $user_invite_reminder_uuids = array_merge($user_invite_reminder_uuids, $invite_detail);
                }
            }
                        
           

            $dataArray=['template_type'=>'predefined','from_name'=>'sjpanel','from_email'=>'rameshk@samplejunction','name'=>'sjpanel'];
            $pointsConversionMetric = config('app.points.metric.conversion');

            if(isset($users) && !empty($users)){
                $invite_email_count = 0;
                $fresh_invite_uuids =[];
                $project_id ='';
                $project_quota_id ='';
                $apace_project_code ='';
                $apace_project_quota_id ='';
                foreach($users as $user){
                    try {

                        if (!in_array($user->uuid, $user_invite_reminder_uuids)) {
                            $fresh_invite_uuids[] = $user->uuid;
                            $invite_email_count += 1;
                        }

                        $locale=$user->locale;
                        app()->setLocale($locale);
                        
                        /* Parshant Sharma [24-08-2024] STARTS */
                            $localeGet = app()->getLocale();

                            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($localeGet);      
                            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
                            
                            $metricConversion = 1/$countryPoints;
                            $countrySymbol    = $countryPoint->currency_symbols;
                            
                            $placehodlers = [
                                    'conversion' => number_format($metricConversion,2),
                                    'COUNTRYSYMBOL'=>__('inpanel.redeem.index.title_history_2'),
                                    'countryPoints'=> $countryPoints,
                                ];  
                         
                        /* Parshant Sharma [24-08-2024] ENDS */
                        
                        $project_id = $user->project_id;
                        $project_quota_id = $user->project_quota_id;
                        $apace_project_code = $user->apace_project_code;
                        $apace_project_quota_id = $user->apace_p_quota_id;
                        $device = $this->getProjectDeviceName($user);    
                        $email_data = [
                            'email' => decrypt( $user->email),
                             //'email' => 'amarjitm@samplejunction.com',
                            'from_name' => (!empty($dataArray['name']))?$dataArray['name']:'SJ Panel',
                            'from_address' => (!empty($dataArray['email']))?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                            'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' => number_format($user->cpi, 2)]),
                        ];
                    
                        $email = new autReminderSurveyMail($email_data, $user,$device, $placehodlers);
                        Mail::send($email);
                
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                if($invite_email_count !=0){
                    $dates = Carbon::now();
                    $invite_sent_datas = [
                        "project_id" => $project_id,
                        "project_quota_id" => $project_quota_id,
                        "apace_project_code" => $apace_project_code,
                        "apace_project_quota_id" => $apace_project_quota_id,
                        "user_ids" => implode(',',$fresh_invite_uuids),
                        "created_at" => $dates,
                        'invitecnt' => $invite_email_count,
                        'reminder' => 0,
                        'surveycnt' => 0
                    ];
                    
                   $this->updatereminderSurveyMail($user_invite_reminder_id,$invite_sent_datas);
                }
            }
            return response()->json(['reminder_mail','successfully sent']);
           
    }

    /*
    Function for Updating sent details in invite_sent_details table
    */
    public function updatereminderSurveyMail($user_invite_reminder_id = null, $invite_sent_datas = null)
    {
        if ($user_invite_reminder_id !== null && is_array($user_invite_reminder_id)) {
            InviteSentDetails::whereIn('id', $user_invite_reminder_id)
                ->update([
                    'reminder' => \DB::raw('reminder + 1'),
                    'updated_at' => Carbon::now()
                ]);
        }
    
        if ($invite_sent_datas !== null && is_array($invite_sent_datas)) {
            InviteSentDetails::create($invite_sent_datas);
        }
    }    
  
    /*
    Function to send mail to panelist rejected reconsilation
    * */
    public function sendMailRejectedReconcilation($user, $project = null){
 
        $subject =__('inpanel.activity_log.rejection_mail_subject');
        $new_project = Project::where('apace_project_code','=',$project->apace_project_code)->first();
        $topic_name = $new_project->project_topic_name;
        $loi =$new_project->loi;

        if ($user && $project) {
                $email = new ReconcilationRejectedMail($user,$project,$topic_name,$loi);
                Mail::send($email); 
                $datas = [
                    'c_type' => 'Rejection',
                    'panelist_id' => $user->panellist_id, 
                    'campaign_subject' => $subject,
                    'survey_code' => $project->apace_project_code,
                    'campaign_amount'=>$project->cpi,
                    'project_id'=>$project->project_id,
                    'survey_loi'=>$loi,
                    'survey_topic'=>$topic_name
                ];
    
                $update = campaign_history::create($datas);
               // \Log::info('Successfully Mail delivered to panelist'.' '.$user->panellist_id);
            
        } else {
           // \Log::info('Required Data not found');
        }
    }

  
}
