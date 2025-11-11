<?php

namespace App\Listeners\Inpanel\Project\Status\After;

use App\Events\Inpanel\Project\AfterStatusChanged;
use App\Events\Inpanel\Project\UserAssignProject;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Project\Project;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Models\Project\ProjectQuota;
use App\Models\Project\ProjectTopic;
use App\Models\Project\UserProject;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Project\InviteSentDetails;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;
use Illuminate\Support\Facades\Mail;
use App\Helpers\FirebaseHelper;
use App\Models\mobileAPI\UserToken;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use DB;
use App\Models\Traffics\Traffic;
use Carbon\Carbon;
class LiveListener
{
    public $statusCode, $project, $sourceAPIService,$countriesCurrenciesRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */


    public function __construct(UserNotificationRepository $notificationRepo,CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->statusCode = 'LIVE';
       $this->notificationRepo = $notificationRepo;
       $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;

    }
    
     
    

    

    /**
     * Listener for handling the Event AfterStatusChanged for changing the status of Project To Live and assigning the project to the eligible Users
     *
     * @param  AfterStatusChanged  $event
     * @return void
     */
    public function handle(AfterStatusChanged $event)
    {
        
        //\Log::info("ABC TESTING LIVE".$currentStatusObject->code."--".$this->statusCode);
        $currentStatusObject = $event->currentStatusObject;
        if( empty($currentStatusObject) || $currentStatusObject->code !== $this->statusCode){
            return;
        }
        $project = $event->project;
        $apaceProject=\DB::connection('mysql_apace')->table('projects')->select('client_code','id','ir')->where('code',$project->apace_project_code)->first();
        $project_quotas = ProjectQuota::where('project_id','=', $project->id)->get();
        $project_id = $project->id;
        $apace_project_code = $project->apace_project_code;
        $QuotaLimit=$project->quota;
         \Log::info("ABC TESTING LIVE".$apaceProject->id."-".$apace_project_code);
        /**
         * Change Date 11feb2023 and 14feb2023
         * change by vikash for device preference
         * */
         //Code Added By Ramesh Kamboj//
            $lang=$project->language_code;
            $con=$project->country_code;
            //END HERE//
             $locale=strtolower($lang).'_'.$con;
              //\Log::info($locale."--".$project->apace_project_code);
        if(!empty($project->device_options)){

           // $activeUsers=[];
            $projectDevice = explode(',',$project->device_options);

            // Device Count may be 1,2,3 and value may be 2=>DESKTOP,3=>PHONE,4=>TABLET
            $countProjectDevice = count($projectDevice);

                if($countProjectDevice==1){
                    $result = User::inviteAble()
                                        ->inCountry($project->country_code)
                                        ->where('locale',$locale)
                                        ->where([
                        ['is_blacklist',0],
                        ['confirmed',1],
                        ['active',1],
                    ])->whereIn('unsubscribed',[0])
                                        ->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        // ->map(function($item) {
                                        //     return [
                                        //         'uuid' => $item->uuid,
                                        //         'role_id' => $item->role_id,
                                        //     ];
                                        // });
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                } 
                if($countProjectDevice==2){
                    $result = User::inviteAble()
                                        ->inCountry($project->country_code)
                                        ->where('locale',$locale)
                                        ->where([
                        ['is_blacklist',0],
                        ['confirmed',1],
                        ['active',1],
                    ])->whereIn('unsubscribed',[0])
                                        ->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                        ->orWhereRaw('FIND_IN_SET("'.$projectDevice[1].'",device_preference)')
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        // ->map(function($item) {
                                        //     return [
                                        //         'uuid' => $item->uuid,
                                        //         'role_id' => $item->role_id,
                                        //     ];
                                        // });
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                }
                if($countProjectDevice==3){
                    $result = User::inviteAble()
                                        ->inCountry($project->country_code)
                                        ->where('locale',$locale)
                                        ->where([
                        ['is_blacklist',0],
                        ['confirmed',1],
                        ['active',1],
                    ])->whereIn('unsubscribed',[0])
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        // ->map(function($item) {
                                        //     return [
                                        //         'uuid' => $item->uuid,
                                        //         'role_id' => $item->role_id,
                                        //     ];
                                        // });
                                        //->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                       // ->orWhereRaw('FIND_IN_SET("'.$projectDevice[1].'",device_preference)')
                                       // ->orWhereRaw('FIND_IN_SET("'.$projectDevice[2].'",device_preference)')
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                }
                
           
        }else{
            $result = User::inviteAble()
                ->inCountry($project->country_code)
                ->where('locale',$locale)
                ->where([
                        ['is_blacklist',0],
                        ['confirmed',1],
                        ['active',1],
                    ])->whereIn('unsubscribed',[0])
                ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                ->get();
                // ->map(function($item) {
                //     return [
                //         'uuid' => $item->uuid,
                //         'role_id' => $item->role_id,
                //     ];
                // });
                // ->get(['uuid'])
                // ->pluck('uuid');
        }

        // $activeUsers = User::inviteAble()
        //     ->inCountry($project->country_code)
        //     ->where('is_blacklist','0')
        //     ->get(['uuid'])
        //     ->pluck('uuid');

        
        $activeUsers_roles = $result->pluck('role_id')->toArray();
        $activeUsers = $result->pluck('uuid');
        $GLOBALINCOME=['STANDARD_HHI_US'=>'US','STANDARD_HHI_INT_UK'=>'UK','STANDARD_HHI_INT_CA'=>'CA','STANDARD_HHI_IN'=>'IN'];
       $profileArr=['REGION '=>'division','STANDARD_EDUCATION'=>'GLOBAL_EDUCATION','ETHNICITY'=>'GLOBAL_ETHNICITY','GLOBAL_INCOME'=>'GLOBAL_INCOME','STATE'=>'state','DMA'=>'dma','DMA_NAME'=>'dma_name','DIVISON'=>'divison','REGION'=>'region',"STANDARD_INDUSTRIES"=>'STANDARD_INDUSTRY','STANDARD_SUFFERER_AILMENTS_II_CA'=>'STANDARD_SUFFERER_AILMENTS_I_CA','STANDARD_HH_SUFFERER_AILMENTS_II_CA'=>'STANDARD_HH_SUFFERER_AILMENTS_I_CA','STANDARD_DIAGNOSED_AILMENTS_II'=>'STANDARD_DIAGNOSED_AILMENTS_I','STANDARD_HH_DIAGNOSD_AILMENTS_II'=>'STANDARD_HH_DIAGNOSED_AILMENTS_I','STANDARD_DIAGNOSED_AILMENTS_II_UK'=>'STANDARD_DIAGNOSED_AILMENTS_I_UK','STANDARD_HH_DIAGNOSD_AILMENTS_II_UK'=>'STANDARD_HH_DIAGNOSED_AILMENTS_I_UK','PROVINCE'=>'province','STANDARD_HHI_IN'=>'STANDARD_HHI_INT_IN_IN'];
        $userRepo = new UserRepository();
        $usersAdditionalData_info = $userRepo->getUserAnswersByUserIds($activeUsers->toArray());
//        $TotalAvailable=$usersAdditionalData_info->count();
        $countPanelist=count($activeUsers);
        // \Log::info("Number of Panelist".$countPanelist);
        $NumberofPanelist=0;
        $IR=$apaceProject->ir;
        $QLImit=$QuotaLimit*100/$IR;
        $SLimit=$QLImit*100/7;
        
        //$activeUsers = $result->pluck('uuid')->take($NumberofPanelist);
        $countPanelist=count($activeUsers);
        // \Log::info("Number of Panelist after Condition".$countPanelist);
        $userRepo = new UserRepository();
        $usersAdditionalData_info = $userRepo->getUserAnswersByUserIds($activeUsers->toArray());
//        $TotalAvailable=$usersAdditionalData_info->count();
        $countPanelist=count($activeUsers);
         \Log::info("Number of Panelist".$countPanelist);
        $NumberofPanelist=0;
        $IR=$apaceProject->ir;
        $QLImit=$QuotaLimit*100/$IR;
        $SLimit=$QLImit*100/7;
        
        //$activeUsers = $result->pluck('uuid')->take($NumberofPanelist);
        $countPanelist=count($activeUsers);
         \Log::info("Number of Panelist after Condition".$countPanelist);
        $userRepo = new UserRepository();
        $usersAdditionalData = $userRepo->getUserAnswersByUserIds($activeUsers->toArray());
        
        if (!$usersAdditionalData || $usersAdditionalData->isEmpty() ) {
            dd('No User Answers found');
        }
        $AvailablePanel=$usersAdditionalData->count();
        $matchingUsers = [];
        $apace_project_quota_id ='';
        $project_quota_id ='';
        $mailers=[];
       // \Log::info("Number of Panelist after Condition".json_encode($usersAdditionalData));
        foreach ($usersAdditionalData as $userData) {
            $userAnswers = collect($userData->user_answers);
            $matchFlag = true;
            foreach ($project_quotas as $quota) {
                $apace_project_quota_id = $quota->apace_quota_id;
                $project_quota_id = $quota->id;
                $matched_question_code = [];
                $quota_specs_details = json_decode( $quota->formatted_quota_spec,true);
                $question_ids = array_column($quota_specs_details ,'PreCodes','QuestionID');

                foreach ($question_ids as $question_id => $answerValues) {

              //  if( !in_array($question_id,$matched_question_code) ){ //no need
                     //if($question_id!='GLOBAL_ZIP'){

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
                        
                       /**********New code (04-01-2023)**************/
                        if(!$result || $result->isEmpty() ){
                       $countArr[]=$userData->uuid;
                        $matchFlag = false;
                        break 1;
                        
                    }
                       /***********New code (04-01-2023) *************/      
                      //  $matched_question_code[] = $question_id; //no need
                //    }
                   } //End Global
                    
                }

                //check matchflag and add user to array

               // \Log::info("matchFlag".$matchFlag."--".$userData->uuid);

                if ($matchFlag) {
                    $matchingUsers[$userData->uuid] = $quota->id;
                }
            }
        }
        $TotalAvailable=count($matchingUsers);
         \Log::info("Number of Total Matched Panelists".count($matchingUsers));
         \Log::info("Number of Suggests Panelists".$SLimit);
        if($TotalAvailable>$SLimit){
            $LimitRecords=$SLimit;
        }else{
            $LimitRecords=$TotalAvailable;
        }
         \Log::info("Number of Suggests Panelists".$LimitRecords);
        $matchingUsers = collect($matchingUsers)->take($LimitRecords);
        $chk_users = $activeUsers->toArray();
        foreach ($matchingUsers as $uuid => $quotaId) {
             $tmp_user_role = User::where('uuid', $uuid)->first()->roles->pluck('id')->first();
            //$index = array_search($uuid,$chk_users);
            //$tmp_user_role = $activeUsers_roles[$index];
            $study_type = $project->study_type_id;
            
            if (($study_type != 12 && $tmp_user_role == '4') || ($study_type == 12 && $tmp_user_role == '8')) {
                \Log::info('Study -' . $study_type . ':: Role -' . $tmp_user_role . ':: Id - ' .$uuid.":: Project".$project->apace_project_code);
               $projectCode= $this->saveUserProject($uuid, $project, $quotaId,$apaceProject->client_code);
               if($projectCode){
                $mailers[] = $uuid;
                
               }
           }
        }
        if($apaceProject->client_code!='RSDA' && $apaceProject->client_code!='TESIP'  && $apaceProject->client_code!='SAGA')
            {
                    $ProjectQuotainfo=\DB::connection('mysql_apace')->table('project_quotas')->where('project_id',$apaceProject->id)->first();
                    $project_quotasinfo = ProjectQuota::where('project_id','=', $project->id)->first();
                    $dates =date("Y-m-d");
                                $inviteDetails = [
                                    "project_id" =>$project->id,
                                    "project_quota_id" => $project_quotasinfo->id,
                                    "apace_project_code" => $project->apace_project_code,
                                    "apace_project_quota_id" =>$ProjectQuotainfo->id,
                                    "user_ids" => implode(',',@$mailers),
                                    "created_at" =>$dates,
                                    'invitecnt' =>count(@$mailers),
                                    'reminder' => 0,
                                    'surveycnt' => 0
                                ];            
                                //var_dump($inviteDetails); 
                                    $createInviteId = InviteSentDetails::create($inviteDetails)->id;
                    //$ProjectQuotainfo=\DB::connection('mysql_apace')->table('project_quotas')->where('project_id',$apaceProject->id)->first();
                    $availableCount=$TotalAvailable-count(@$mailers);
                     \Log::info("Number of Invited Panelists".count(@$mailers));
                    $PullInvite=['project_id'=>$apaceProject->id,'project_quota_id'=>$ProjectQuotainfo->id,'user_ids'=>implode(',',@$mailers),'invitecnt' => count(@$mailers),'reminder' => 0,'sjpanelinvitesentid' => $createInviteId,'availablecount'=>$availableCount,'created_at'=>date('Y-m-d h:i:s')];
                     \Log::info("APACE".json_encode($PullInvite));
                    \DB::connection('mysql_apace')->table('invite_sent_details')->insert($PullInvite);
                }

        
                    $ProjectQuotainfo=\DB::connection('mysql_apace')->table('project_quotas')->where('project_id',$apaceProject->id)->first();
                    $project_quotasinfo = ProjectQuota::where('project_id','=', $project->id)->first();
                    $dates =date("Y-m-d");
                                $inviteDetails = [
                                    "project_id" =>$project->id,
                                    "project_quota_id" => $project_quotasinfo->id,
                                    "apace_project_code" => $project->apace_project_code,
                                    "apace_project_quota_id" =>$ProjectQuotainfo->id,
                                    "user_ids" => implode(',',@$mailers),
                                    "created_at" =>$dates,
                                    'invitecnt' =>count(@$mailers),
                                    'reminder' => 0,
                                    'surveycnt' => 0
                                ];            
                                //var_dump($inviteDetails); 
                                    $createInviteId = InviteSentDetails::create($inviteDetails)->id;
                if($apaceProject->client_code!='RSDA' && $apaceProject->client_code!='TESIP'  && $apaceProject->client_code!='SAGA' )

            {
                    //$ProjectQuotainfo=\DB::connection('mysql_apace')->table('project_quotas')->where('project_id',$apaceProject->id)->first();
                    $availableCount=$TotalAvailable-count(@$mailers);
                     \Log::info("Number of Invited Panelists".count(@$mailers));
                    $PullInvite=['project_id'=>$apaceProject->id,'project_quota_id'=>$ProjectQuotainfo->id,'user_ids'=>implode(',',@$mailers),'invitecnt' => count(@$mailers),'reminder' => 0,'sjpanelinvitesentid' => $createInviteId,'availablecount'=>$availableCount,'created_at'=>date('Y-m-d h:i:s')];
                     \Log::info("APACE".json_encode($PullInvite));
                    \DB::connection('mysql_apace')->table('invite_sent_details')->insert($PullInvite);
                }

    }
    private function saveUserProject($uuid,$project,$project_quota_id,$client_code)
    {
        
        $user = User::where('uuid','=',$uuid)->first();
        $pointsConversionMetric = config('app.points.metric.conversion');
        $add_project = [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'cpi' => $project->cpi,
            'points' => round($project->cpi/$pointsConversionMetric),
            'project_quota_id' => $project_quota_id,
            'user_live_link' => $project->live_url,
            'user_test_link' => $project->test_url,
            'apace_project_code' => $project->apace_project_code,
        ];
        // $check_project_exist = UserProject::where('user_id', '=', $user->id)
        //     ->where('project_id', '=', $project->id)
        //     ->first();
        $check_project_exist = UserProject::where('user_id', '=', $user->id)
            ->where('apace_project_code', '=', $project->apace_project_code)
            ->first();
        if(!$check_project_exist){
            $update_user_project = UserProject::create($add_project);
            $project = Project::where('id','=',$project->id)->first();
            if( $project->project_type !== $user->user_group ){
                return false;
            }
            $survey_notification = $this->notificationRepo->createNotification($uuid,'New Survey',$project->apace_project_code,'Assigned','Survey Assigned');
            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $extraData = [
                'type' => 'Survey Assigned',
            ];
            $title = "Sj Panel";
            $msg = __('frontend.notification_txt.survey_assigned_new');
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    $extraData,
                    [
                        'type' => 'Survey Assigned'
                    ]
                );
            }
            // Mail Send To Each User Code Added By Ramesh Kamboj [05-09-2025]//
            $value=$user;
            $time_dif=0;
            if($client_code!='RSDA' && $client_code!='TESIP' && $client_code!='SAGA' )
            {
                if($user->is_blacklist == 0){
                    //if(!$user->mail_sent_at || $user->mail_sent_at < Carbon::now()->subHours($time_dif)->toDateTimeString()){
                                $project_data = $project;
                                $surveyid = $user->id."?sid=".$createInviteId=1;
                                //print_r($project_data);die;
                                $pointsConversionMetric = config('app.points.metric.conversion');
                                $surveyLiveLink = $this->getSurveyLink($user,$project_data,'live_url');
                                $surveyTestLink = $this->getSurveyLink($user,$project_data,'test_url');
                                // $project_value = Project::where('key','cpi')->first();    
                                $pointsData = round($project_data->cpi/$pointsConversionMetric);

                                $locale=$user->locale;
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
                                    '{%U_NAME%}' => $user->first_name,
                                    '{%U_EMAIL%}' => $user->email,
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
                                    '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $user->email]),
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
                                    'email' => $user->email,
                                    'from_name' => (@$dataArray['name'])?@$dataArray['name']:'SJ Panel',
                                    'from_address' => config('mail.from.donotreply_address'),
                                    'subject' => __('inpanel.mail.survey.survey_subject_new',['survey_points' => number_format($pointsData/$countryPoints, 2)]),
                                
                                ];
                               
                                    $email = new SurveyTestInvite($email_data, $placehodlers);
                                    //\Log::info("If 2".$user->email);
                                    Mail::send($email);
                                    //\Log::info("Mail Sent".$user->email);
                                        $updateMailSent = User::where('id','=',$user->id)
                                        ->update(['mail_sent_at' => date("Y-m-d h:i:s"),'count_mail_sent'=>1]);
                                        $mailers[] = $user->uuid;
                                        
                                        
                                    } 
                            //}  
                }
            //End Here//

            return $update_user_project;
        }
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
}
