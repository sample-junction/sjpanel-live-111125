<?php

namespace App\Listeners\Inpanel;

use App\Models\Auth\User;
use App\Models\Project\Project;
use App\Events\Inpanel\Project\UserAssignProject;
use App\Models\Project\UserProject;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserProjectListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $project = $event->project;
        $quota  = $event->quota;
        /**
         * Change Date 11feb2023 and 14feb2023
         * change by vikash for device preference
         * */
        //Code Added By Ramesh Kamboj//
            $lang=$project->language_code;
            $con=$project->country_code;
             $locale=strtolower($lang).'_'.$con;
        if(!empty($project->device_options)){

            $projectDevice = explode(',',$project->device_options);
        
            //END HERE//
            // Device Count may be 1,2,3 and value may be 2=>DESKTOP,3=>PHONE,4=>TABLET
            $countProjectDevice = count($projectDevice);
 
                if($countProjectDevice==1){
                    $results = User::inviteAble()
                                        ->inCountry($project->country_code)
                                         ->where('locale',$locale)
                                        ->where('is_blacklist','0')
                                        ->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                } 
                if($countProjectDevice==2){
                    $results = User::inviteAble()
                                        ->inCountry($project->country_code)
                                         ->where('locale',$locale)
                                        ->where('is_blacklist','0')
                                        ->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                        ->orWhereRaw('FIND_IN_SET("'.$projectDevice[1].'",device_preference)')
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                }
                if($countProjectDevice==3){
                    $results = User::inviteAble()
                                        ->inCountry($project->country_code)
                                         ->where('locale',$locale)
                                        ->where('is_blacklist','0')
                                        ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                                        ->get();
                                        //->whereRaw('FIND_IN_SET("'.$projectDevice[0].'",device_preference)')
                                        //->orWhereRaw('FIND_IN_SET("'.$projectDevice[1].'",device_preference)')
                                        //->orWhereRaw('FIND_IN_SET("'.$projectDevice[2].'",device_preference)')
                                        // ->get(['uuid'])
                                        // ->pluck('uuid');
                }
                 
            
        }else{
            $results = User::inviteAble()
                ->inCountry($project->country_code)
                ->where('is_blacklist','0')
                ->leftJoin('model_has_roles','users.id','=','model_has_roles.model_id')
                ->get();
                // ->get(['uuid'])
                // ->pluck('uuid');
        }
 
        // $activeUsers = User::inviteAble()
        //     ->inCountry($project->country_code)
        //     ->where('is_blacklist','0')
        //     ->get(['uuid'])
        //     ->pluck('uuid');
        $activeUsers = $results->pluck('uuid');
        $activeUsers_roles = $results->pluck('role_id')->toArray();

        $userRepo = new UserRepository();
        $usersAdditionalData = $userRepo->getUserAnswersByUserIds($activeUsers->toArray());
        if (!$usersAdditionalData || $usersAdditionalData->isEmpty() ) {
            dd('No User Answers found');
        }
        $matchingUsers = [];
        $unmatchedUsers = [];
        foreach ($usersAdditionalData as $userData) {
            $userAnswers = collect($userData->user_answers);
            $matchFlag = true;
            $matched_question_code = [];
            $quota_specs_details = json_decode( $quota->formatted_quota_spec,true);
            $question_ids = array_column($quota_specs_details ,'PreCodes','QuestionID');
            foreach ($question_ids as $question_id => $answerValues) {
                //if( !in_array($question_id,$matched_question_code) ){
                    $result = $userAnswers->where('profile_question_code', '=', $question_id )
                        ->filter(function ($value) use ($answerValues) {
                            $userSelectedAnswer = $value['selected_answer'];
                            if($userSelectedAnswer && !is_array($userSelectedAnswer)){
                                $userSelectedAnswer = array($value['selected_answer']);
                            }
                            return !empty(array_intersect((array)$answerValues, (array)$userSelectedAnswer));
                            // return !empty(array_intersect($answerValues, $value['selected_answer']));
                        });
                    $checkProjectCodeInUserAnswer = $userAnswers
                        ->where('profile_question_code', '=', $question_id)
                        ->first();
                   /* if (!$result || $result->isEmpty() ) {
                        dd( !empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() ));
                    }*/
                    // if( !empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() )){
                    //     $matchFlag = false;
                    //     break 1;
                    // } elseif ( empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() ) ){
                    //     break 1;
                    // }
                    
                    /***********New code (05-01-2023) *************/
                    if( empty($checkProjectCodeInUserAnswer) || ( !$result || $result->isEmpty() )){
                        $matchFlag = false;
                        break 1;
                    }
                    /************New code (05-01-2023) ************/   
                   // $matched_question_code[] = $question_id;
                //}
            }
            if ($matchFlag) {
                $matchingUsers[$userData->uuid] = $quota->id;
            }else{
                $unmatchedUsers[$userData->uuid] = $quota->id;
            }
        }
        $chk_users = $activeUsers->toArray();
        if(!empty($matchingUsers) && count($matchingUsers) > 0){
            foreach ($matchingUsers as $uuid => $quotaId) {
                $index = array_search($uuid,$chk_users);
                $tmp_user_role = $activeUsers_roles[$index];
                $study_type = $project->study_type_id;
                // $this->saveUserProject($uuid, $project, $quotaId);

                if (($study_type != 12 && $tmp_user_role == '4') || ($study_type == 12 && $tmp_user_role == '8')) {
                    \Log::info('Study -' . $study_type . ':: Role -' . $tmp_user_role . ':: Id - ' .$uuid);
                    $this->saveUserProject($uuid, $project, $quotaId);
                }
            }
        }
        if(!empty($unmatchedUsers) && count($unmatchedUsers) > 0){
            foreach ($unmatchedUsers as $uuid => $quotaId) {
                $this->unassignUserProject($uuid, $project, $quotaId);
            }
        }
    }

    private function unassignUserProject($uuid, $project, $quotaId)
    {
        $user = User::where('uuid','=',$uuid)->first();
        $check_project_exist = UserProject::where('user_id', '=', $user->id)
            ->where('project_id', '=', $project->id)
            ->whereNull('status')
            ->first();
        if($check_project_exist){
            $deleteUserProject = UserProject::where('id', '=', $check_project_exist->id)
                ->delete();
            return $deleteUserProject;
        }
    }
    private function saveUserProject($uuid,$project,$project_quota_id)
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
         \Log::info($add_project);
        // $check_project_exist = UserProject::where('user_id', '=', $user->id)
        //     ->where('project_id', '=', $project->id)
        //     ->first();
        $check_project_exist = UserProject::where('user_id', '=', $user->id)
            ->where('apace_project_code', '=', $project->apace_project_code)
            ->first();
        if(!$check_project_exist){
            $update_user_project = UserProject::create($add_project);
            \Log::info($update_user_project);
            $project = Project::where('id','=',$project->id)->first();
            if( $project->project_type !== $user->user_group ){
                return false;
            }
            //$project_topic  = ProjectTopic::where('id','=',$project->project_topic_id)->first();
            if($update_user_project){
                $check_unsubscribe_details = $user->checkUnsubscribedEmail($user->email);
                if(!$check_unsubscribe_details){
                    $placeholders = [
                        '{%S_POINTS%}' => round($project->cpi/$pointsConversionMetric),
                        '{%S_ID%}' => $update_user_project->id,
                        '{%S_CODE%}' => $project->code,
                        '{%S_NAME%}' => $project->survey_name,
                        '{%S_LOI%}' => $project->loi,
                        '{%S_SDATE%}' => $project->start_date,
                        '{%S_EDATE%}' => $project->end_date,
                        '{%S_LINK%}' => $project->live_url,
                        '{%S_TEST_LINK%}' => $project->test_url,
                        '{%S_TOPIC%}' => $project->project_topic_name,
                        '{%U_NAME%}' => $user->first_name.' '.$user->last_name,
                        '{%U_EMAIL%}' => $user->email,
                        '{%DETAILS_1%}' => __('inpanel.mail.survey.salutation'),
                        '{%DETAILS_2%}' => __('inpanel.mail.survey.details_1'),
                        '{%DETAILS_3%}' => __('inpanel.mail.survey.details_2',['points' => round($project->cpi/$pointsConversionMetric)]),
                        '{%DETAILS_4%}' => __('inpanel.mail.survey.details_3',['points' => round($project->cpi/$pointsConversionMetric),'loi' => $project->loi]),
                        '{%DETAILS_5%}' => __('inpanel.mail.survey.details_4'),
                        '{%LABELS_1%}' => __('inpanel.mail.survey.label_1'),
                        '{%LABELS_2%}' => __('inpanel.mail.survey.label_2'),
                        '{%LABELS_3%}' => __('inpanel.mail.survey.label_3'),
                        '{%POINTS%}' => __('inpanel.mail.survey.points'),
                        '{%LABELS_4%}' => __('inpanel.mail.survey.label_4'),
                        '{%ROUTE_S%}' => route('inpanel.survey.execute.show',$update_user_project->id),
                        '{%BUTTON_S%}' => __('inpanel.mail.survey.button'),
                        '{%LINK%}' => route('inpanel.survey.execute.show',$update_user_project->id),
                        '{%LINK_TEXT%}' => __('inpanel.mail.survey.link_text'),
                        '{%FOOTER_1%}' => __('inpanel.mail.survey.footer_1'),
                        '{%FOOTER_2%}' => __('inpanel.mail.survey.footer_2'),
                        /*'{%REGARDS%}' => __('inpanel.mail.survey.regards'),*/
                        '{%ROUTE_R%}' => route('frontend.cms.rewards'),
                        '{%COPYRIGHT_DATE%}' => date('Y'),
                        '{%REWARDS%}' => __('strings.emails.auth.confirmation.rewards'),
                        '{%POLICY%}' => __('frontend.index.footer.links.privacy_policy'),
                        '{%ROUTE_P%}' => route('frontend.cms.privacy'),
                        '{%ROUTE_F%}' => route('frontend.cms.faq'),
                        '{%FAQ%}' => __('strings.emails.auth.confirmation.faq'),
                        '{%DISCLAIMER%}' => __('strings.frontend.disclaimer'),
                        '{%UNSUBSCRIBE%}' => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $user->email]),
                        '{%UNSUBSCRIBE_LABEL%}' => __('strings.emails.auth.confirmation.unsubscribe'),
                        '{%LOGO%}' => asset('img/frontend/logo.png'),
                        '{%IMAGE%}' => asset('img/inpanel/email-notification.png'),
                    ];
                     /*event(new UserAssignProject($user,$placeholders));*/
                }
            }
            return $update_user_project;
        }
    }
}
