<?php

namespace App\Listeners\Frontend;

use App\Events\Inpanel\Project\UserAssignProject;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Project\Project;
use App\Models\Project\ProjectQuota;
use App\Models\Project\ProjectTopic;
use App\Models\Project\UserProject;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UserMatchProject
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
     * Listener for handling the Event User Update for Providing the matched Project
     * with the user basic profile details as soon as he provide Basic Profile data.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        
        if(!$user->active || $user->unsubscribed || $user->is_blacklist){
            return false;
        }

        $user_Add_data =  $userAnswers = UserAdditionalData::where('uuid','=',$user->uuid)->project([
            'uuid' => true,
            'u_id' => true,
            'user_answers' => true,

        ])->first();
        /**
         * Change Date 14feb2023
         * change by vikash for device preference
         * */
        $userDevicePreference = explode(',',$user->device_preference);
        $countUserDevice = count($userDevicePreference);
        //Code Added By Ramesh Kamboj//
        $UserLocale=str_replace('-','_',$user->locale);
        $locale=explode("_",$UserLocale);
        $lang=strtoupper($locale[0]);
        $role = DB::table('model_has_roles')->where('model_id',$user->id)->get()->pluck('role_id');//User::find($user->id)->pluck('role_id');
        if($role[0] == 8){
            $condition = '=';
            $param = 12;
            
        }else{
            $condition = '!=';
            $param = 12;
        }
        \Log::info($lang.'---');
        \Log::info($role.'***' );
        $tst_qry = Project::where('study_type_id',$condition,$param)->toSql();
        \Log::info($tst_qry);

        //End Here//
        if(in_array('1',$userDevicePreference)){
            $projects = Project::where('survey_status_code','=','LIVE')
                                ->where('country_code', '=', $user->country_code)
                                ->where('language_code','=',$lang)
                                ->where('study_type_id',$condition,$param)
                                ->get();
        }else{

            if($countUserDevice==1){
                $projects = Project::where('survey_status_code','=','LIVE')
                                ->where('country_code', '=', $user->country_code)
                                ->where('language_code','=',$lang)
                                ->where('study_type_id',$condition,$param)
                                ->whereRaw('FIND_IN_SET("'.$userDevicePreference[0].'",device_options)')
                                ->get();
            } 
            if($countUserDevice==2){
                $projects = Project::where('survey_status_code','=','LIVE')
                                ->where('country_code', '=', $user->country_code)
                                ->where('language_code','=',$lang)
                                ->where('study_type_id',$condition,$param)
                                //Code Add By Ramesh//
                                        ->where(function ($query) use ($userDevicePreference) {
                                        $query->whereRaw('FIND_IN_SET("'.$userDevicePreference[0].'",device_options)')
                                        ->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[1].'",device_options)');
                                         })
                                        //End Here//
                                //->whereRaw('FIND_IN_SET("'.$userDevicePreference[0].'",device_options)')

                                //->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[1].'",device_options)')

                                ->get();
            }
            if($countUserDevice==3 || $countUserDevice==4){
                $projects = Project::where('survey_status_code','=','LIVE')
                                ->where('country_code', '=', $user->country_code)
                                ->where('language_code','=',$lang)
                                ->where('study_type_id',$condition,$param)
                                 //Code Add By Ramesh//
                                        ->where(function ($query) use ($userDevicePreference) {
                                        $query->whereRaw('FIND_IN_SET("'.$userDevicePreference[0].'",device_options)')
                                        ->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[1].'",device_options)')
                                        ->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[2].'",device_options)');
                                    })
                                        //End Here
                                //->whereRaw('FIND_IN_SET("'.$userDevicePreference[0].'",device_options)')
                                //->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[1].'",device_options)')

                                //->orWhereRaw('FIND_IN_SET("'.$userDevicePreference[2].'",device_options)')

                                ->get();
            }
        }
        // $projects = Project::where('survey_status_code','=','LIVE')
        //     ->where('country_code', '=', $user->country_code)
        //     ->get();

        if($projects){
            foreach($projects as $project){
                \Log::info($project->apace_project_code . '-----' . $project->study_type_id);
                $check_project_already_assign = UserProject::where('apace_project_code', '=', $project->apace_project_code)->where('user_id', '=', $user->id)->first();
                
                if(!$check_project_already_assign){
                    $project_quotas = $this->getProjectQuota($project->id);
                    $matchFlag = true;
                    foreach ($project_quotas as $project_quota){
                        $matched_question_code = [];
                        $quota_specs = $project_quota->formatted_quota_spec;
                        $quota_specs_details = json_decode($quota_specs,true);
                        $question_id = array_column($quota_specs_details ,'PreCodes','QuestionID');
                        /*$this->matchSaveUserProject($project_matched,$matchFlag,$question_id,$user_Add_data,$project_quota,$project);*/
                        foreach ($question_id as $key => $value){
                           
                            //if(!in_array($key,$matched_question_code)){
                                $question_code = $key;
                                $userAnswers = collect($user_Add_data->user_answers);
                               // print_r($userAnswers);
                                $result = $userAnswers->where('profile_question_code', '=', $question_code )
                                    ->filter(function ($answer) use ($value) {
                                      /* echo'<pre>';
                                       print_r($value);
                                       print_r($answer['selected_answer']);
                                        print_r(array_intersect((array)$value, (array)$answer['selected_answer']));
                                        exit;*/
                                        //update by pramod 13sep22
                                        return !empty(array_intersect((array)$value, (array)$answer['selected_answer']));
                                    });
                                $checkProjectCodeInUserAnswer = $userAnswers
                                    ->where('profile_question_code', '=', $question_code)
                                    ->first();
                               /* dd($checkProjectCodeInUserAnswer);*/
                                // if( !empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() )){
                                //     $matchFlag = false;
                                //     break 1;
                                // } elseif ( empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() ) ){
                                //     $matched_question_code[] = $question_code;
                                //     break 1;
                                // }

                                /***********New code (05-01-2023) *************/
                                if( empty($checkProjectCodeInUserAnswer) || ( !$result || $result->isEmpty() )){
                                    $matchFlag = false;
                                    break 1;
                                }
                                /************New code (05-01-2023) ************/   
                                //$matched_question_code[] = $question_code;
                            //}
                        }
                        if ($matchFlag) {
                            $this->assignProjectUser($user_Add_data->uuid, $project, $project_quota->id);
                        }
                    }
                }
            }
        }
        //print_r("inside listener");die;
        return true;
    }

    /**
     * This action is used for getting the Project Quota of the Projects
     *
     * @param $project_id
     * @return mixed
     */
    private function getProjectQuota($project_id)
    {
        $project_quota = ProjectQuota::where('project_id','=',$project_id)->get();
        if($project_quota){
            return $project_quota;
        }
    }

    /**
     * This action is used for matching the eligible user for the Project.
     *
     * @param $matchFlag
     * @param $question_id
     * @param $user_Add_data
     * @param $project_quota
     * @param $project
     * @return bool
     */
    /*private function matchSaveUserProject($project_matched,$matchFlag,$question_id,$user_Add_data,$project_quota,$project)
    {
        foreach ($question_id as $key => $value){
            $question_code = $key;
            $userAnswers = collect($user_Add_data->user_answers);
            $result = $userAnswers->where('profile_question_code', '=', $key )
                ->filter(function ($answer) use ($value) {
                    return !empty(array_intersect($value, $answer['selected_answer']));
                });
            $checkProjectCodeInUserAnswer = $userAnswers
                ->where('profile_question_code', '=', $question_code)
                ->first();
            if(!empty($checkProjectCodeInUserAnswer) && ( !$result || $result->isEmpty() )){
                $matchFlag = false;
                break 1;
            }elseif (empty($checkProjectCodeInUserAnswer) && !$result || $result->isEmpty() ){
                break 1;
            }
        }
        dd($question_id,$matchFlag);
        if ($matchFlag) {
            $this->assignProjectUser($user_Add_data->uuid, $project, $project_quota->id);
        } else{
            return false;
        }
    }*/

    /**
     * This action is used for saving the project for the particular user in User project after matching the
     * quota with user information.
     *
     * @param $uuid
     * @param $project
     * @param $project_quota_id
     * @return mixed
     */
    private function assignProjectUser($uuid,$project,$project_quota_id)
    {
        $user = User::where('uuid','=',$uuid)->first();

        // $projectIds = Project::where('apace_project_code','=',$project->apace_project_code)->get()->pluck('id');

        // $user_project = UserProject::where('user_id','=',$user->id)->whereIn('project_id',$projectIds)->first();

        // if(!$user_project){

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
           /* $check_project_exist = UserProject::where('user_id', '=', $user->id)
                ->where('project_id', '=', $project->id)
                ->first();*/
            $check_project_exist = UserProject::where('user_id', '=', $user->id)
                    ->where('apace_project_code', '=', $project->apace_project_code)
                    ->first();
            if(!$check_project_exist){
                $update_user_project = UserProject::create($add_project);
                $project = Project::where('id','=',$project->id)->first();
                $project_topic  = ProjectTopic::where('id','=',$project->project_topic_id)->first();
                if( $project->project_type !== $user->user_group ){
                    return false;
                }
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
                       /* event(new UserAssignProject($user,$placeholders));*/
                    }
                }
                return $update_user_project;
            }
        //}
    }
}

