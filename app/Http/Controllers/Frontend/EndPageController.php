<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Frontend\Traits\Source\VendorReplyURL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\RespondentTraffics;
use App\Mail\Frontend\UserConfirm\UserTestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Models\Report\SurveyReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\URL;
use App\Repositories\Inpanel\Project\ProjectRepository;
use App\Events\Inpanel\Project\ProfileSurveyComplete;
use App\Mail\Inpanel\Invite\UserInviteSurveyComplete;
use App\Mail\Inpanel\UserProject\survey_completed_mail;
use App\Models\Setting\Setting;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Models\Project\Project;
use App\Models\Project\UserProject;
/**
 * This class is used to redirect user to home page of the website.
 *
 * Class HomeController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Controllers\Frontend\HomeController
 */
//https://test50.samppoint.com/end?sjid=61bbb80b-c162-4a12-b2bc-a107f32abdc7&respstatus=36&status=2&internal=1&hmac=e172792f9c17b4cd2a1b833bfb93b9f7813e312d
class EndPageController extends Controller
{
     public $status, $respstatus, $panelist_id, $project, $clientreplyurl,$debugData, $panelistId,$end_ip_address,$internalChecksum,$internalRedirect,$projectRepo,$notificationRepo;

    public function __construct(ProjectRepository $projectRepo, UserNotificationRepository $notificationRepo)
    {
        $this->projectRepo = $projectRepo;
        $this->notificationRepo = $notificationRepo;
    }
    /**
     * This method is use to redirect the User to Home.
     *
     * @return \Illuminate\View\View
     */
    public function surveyend(Request $request)
    {
    
        $currentURL = URL::previous();
        $this->request  = $request;
        $this->status=$request->get('status');

        //Added by RAS on 05.09.23 for creating notifications for referral survey completion

        if (! auth()->user()) {

            return redirect()->route('frontend.auth.login');
        }
        $user = auth()->user();
        $user_id = $user->id;
        $nextSurvey = $this->projectRepo->getNextSurvey($user_id);
        if(!empty($nextSurvey)){
           /* $sjpid = $nextSurvey->uuid.'_'.$nextSurvey->code;
            $user_live_link = $nextSurvey->user_live_link;
            $modified_link = str_replace('[%sjpid%]', $sjpid, $user_live_link);
            $next_survey_url = $modified_link;*/
            $survey_id = $nextSurvey->id;
            $user_project_details = $this->projectRepo->getProjectDetails($survey_id,$user);
            // code added by Anil Sharma
            if (empty($user_project_details)) {
                // $this->userRepository->storePlatForm($user->uuid, 'web', 'survey_participation', $user_project_details->apace_project_code);
                return redirect()->route(home_route())->withErrors('You have already attempted the survey. Please refresh the page.');
            } 
            // code added by Anil Sharma end

            $client_new_redirect_link = $this->projectRepo->getRedirectClientLink($user,$user_project_details);
            $next_survey_url = $client_new_redirect_link;
        }else{
            $next_survey_url = url('dashboard');
        }
        if($this->status == '1'){
            $user = auth()->user();
			if ($user) {
				$completed_projects = DB::table('user_projects')
										->where('user_id',$user->id)
										->where('status','1')
										->get();
	  
				if(count($completed_projects) <= 1){

					$referral_user = User::where('id',$user->id)->first();
					$referred_name = $user->first_name.' '.$user->last_name;

					$referred_first_name = $user->first_name;


					$ref_req_id = DB::table('referral_relationships')
							  ->where('user_id',$user->id)->first();
							  
					if(!empty($ref_req_id)){
						$referee = DB::table('users')
									->join('referral_links','referral_links.user_id','=','users.id','left')
									->where('referral_links.id',$ref_req_id->referral_link_id)
									->select('users.*')->first();
						}
					$orig_locale = app()->getLocale();
					//Refer Check Here By Ramesh Kamboj//
					if(!empty($referee)){
						app()->setLocale($referee->locale);
						$msg = __('frontend.notification_txt.referral_rqst_registration_1'). $user->first_name .__('frontend.notification_txt.referral_rqst_survey_completion');
					
						$this->notificationRepo->createNotification($referee->uuid,'Referral Request',$ref_req_id->referral_link_id,$msg);
						app()->setLocale($orig_locale);
									
									
						$ref_mail = decrypt($referee->email);
						// echo '<pre>';
						//             print_r($ref_mail); die();
						$get_referal_point = Setting::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();

							   
						$email = new UserInviteSurveyComplete($referee, $referred_name,$get_referal_point->value,  $referred_first_name);

						Mail::to($ref_mail)->locale($referee->locale)->send($email);

						}//End Check of Referee//
				} 
			}
            
            
        }

        if (strpos($currentURL, 'survey.sjpanel.com') !== false) {
            Session::put('status',$request->get('status'));
            
        }
        if(!empty(Session::get('status'))){
         $status=Session::get('status');
        }else{
          $status= $this->status; 
        }

        $redirectTime = config('settings.redirectsurveydashboard.set_time');
        
        //$PageStatus=RespondentTraffics::select('status')->where('panelistId',$panelistId)->limit(1)->get();
        $TemplateArr=['1'=>'SURVEY COMPLETED','2'=>'TERMINATED','3'=>'QUOTAFULL','4'=>'QUALITY TERMINATE','10'=>'UNASSIGN','11'=>'POINTSUPDATE'];
        $title="Sjpanel :-".@$TemplateArr[$status];
        $viewName = 'survey.v2.end.end';
        return View($viewName)
        ->with('status',$status)
        ->with('redirectTime',$redirectTime)
        ->with('title',$title)
        ->with('next_survey_url',$next_survey_url);
        
    }
    public function transactioncompletion(Request $request){
        $filename=time()."_".$request->get('uuid').".txt";
        $string=$request->get('RespID');
        Storage::disk('local')->put($filename, $string);
        $project_code=$request->get('project_code');

        $arr = explode('_',$request->get('uuid'));
        $uuid = $arr[0];
        $surveyCode = $arr[1];
        $status = $request->get('surveyStatus');    
        /**
         * Change By vikash date 25-Nov-2022
         * Update in user project table and related event
         */
        $user = $this->projectRepo->getUserDetails($uuid);
        $project = $this->projectRepo->getProject($surveyCode);

        if($user && $project){
            $get_user_project = $this->projectRepo->getUserProject($user,$project);
            if($get_user_project){
                if($status == 1){
                     /*$checkedUserAssign = UserProject::where('user_id','=',$user->id)->where('project_id','=',$project->id)->where('status','=',50)->get();
                    if(count($checkedUserAssign)==0){
                        $duration = 60;
                        $date= date("Y-m-d H:i:s", strtotime("+$duration sec"));
                        $update_data=[
                            'status'=>50,
                            'updated_at'=>$date,
                        ];
            
                        $changeStatus = UserProject::where('id','=',$get_user_project->id)
                        ->update($update_data);
                    $this->projectRepo->updateUserAchievements($user,$get_user_project);
                     //event(new ProfileSurveyComplete($user)); 

                    //Add by obhi for sending internal mail
                    $this->sendMailAfterSurveyCompletion($user,$get_user_project->apace_project_code,$get_user_project->points,$request->get('RespID'));
                    //End
                }else{
                    //return response()->json(['status'=>0,'msg'=>'Already Paid','uuid'=>$uuid]);

                }*/

                $this->projectRepo->changeStatusComplete($get_user_project);
                //Add by obhi for sending internal mail

                    $this->sendMailAfterSurveyCompletion($user,$get_user_project->apace_project_code,$get_user_project->points,$request->get('RespID'));
                    //End

                } elseif ($status == 2){
                    $this->projectRepo->changeStatusTerminate($get_user_project);
                } elseif($status == 3){
                    $this->projectRepo->changeStatusQuotaFull($get_user_project);
                } elseif($status == 4){
                    $this->projectRepo->changeStatusQualityTerminate($get_user_project);
                }
            }
        
			/*******End change status in user project******/
		   
			$CheckTrafficData=SurveyReport::select('id')->where('RespID',$request->get('RespID'))->limit(1)->get();
		   
			if(count($CheckTrafficData)==0){
				$SurveyReport = new SurveyReport;
				$SurveyReport->uuid=$uuid;
				if($status!=1){
				  $SurveyReport->status=$request->get('surveyStatus');
				$SurveyReport->resp_status=$request->get('surveyRespStatus'); 
					$SurveyReport->status_name=$request->get('status_name');
					$SurveyReport->resp_status_name=$request->get('resp_status_name'); 
				}else{
					$SurveyReport->status='1';
				 $SurveyReport->resp_status='1';
					$SurveyReport->status_name='Complete';
					$SurveyReport->resp_status_name='cComplete';  
			 }
				//$SurveyReport->status=$request->get('surveyStatus');

				//$SurveyReport->resp_status=$request->get('surveyRespStatus');

				$SurveyReport->project_code=$request->get('project_code');
				$SurveyReport->survey_code=$surveyCode;
				$SurveyReport->source_code=$request->get('source_code');
				$SurveyReport->country_code=$request->get('country_code');
				$SurveyReport->language_code=$request->get('language_code');
				$SurveyReport->cpi=$request->get('cpi');
				$SurveyReport->traffic_flag=$request->get('traffic_flag');
				$SurveyReport->reject_reason=$request->get('reject_reason');
				$SurveyReport->duration=$request->get('duration');
				$SurveyReport->start_ip_address=$request->get('start_ip_address');
				$SurveyReport->end_ip_address=$request->get('end_ip_address');
				$SurveyReport->client_survey_link=$request->get('client_survey_link');
				$SurveyReport->vendor_start_link=$request->get('vendor_start_link');
				$SurveyReport->client_end_link=$request->get('client_end_link');
				$SurveyReport->vendor_end_link=$request->get('vendor_end_link');
				$SurveyReport->started_at=$request->get('started_at');
				$SurveyReport->ended_at=$request->get('ended_at');
				$SurveyReport->channel_id=$request->get('channel_id');
				$SurveyReport->RespID=$request->get('RespID'); 
				$SurveyReport->save();  
			}else if($CheckTrafficData[0]->status==0){
				$id=$CheckTrafficData[0]->id;
				$data=[
						'status'=>$request->get('surveyStatus'),
						'resp_status'=>$request->get('surveyRespStatus'),
						'cpi'=>$request->get('cpi'),
						'status_name'=>$request->get('status_name'),
						'resp_status_name'=>$request->get('resp_status_name'),
						'start_ip_address'=>$request->get('start_ip_address'),
						'end_ip_address'=>$request->get('end_ip_address'),
						'client_end_link'=>$request->get('client_end_link'),
						'vendor_end_link'=>$request->get('vendor_end_link'),
						'started_at'=>$request->get('started_at'),
						'channel_id'=>$request->get('channel_id'),
						'ended_at'=>$request->get('ended_at')


				];

				DB::table('survey_reports')
				->where('id', $id)
				->update($data);

			}
		}   
        
    }

    private function getPanellistIdFromRequest()
    {
        $request = $this->request;
        $params = $request->keys();
        $possibleParams = config('settings.END_PAGE_CUSTOM_VARS');

        $intersectedParams = array_intersect($params, $possibleParams);
        if (!empty($intersectedParams)) {
            return reset($intersectedParams);
        }
        return 'sjid';
    }

    protected function returnEndpageView()
    {
        $project            = ( !empty($this->project) )?$this->project:false;
        $trafficRow         = ( !empty($this->trafficRow) )?$this->trafficRow:false;
        $status             = ( !empty($this->status) )?$this->status:0;
        $respstatus         = ( !empty($this->respstatus) )?$this->respstatus:0;
        $finalRedirectUrl   = false;

        if($trafficRow === false)
            die('Something went wrong - Unable to render End page!');

        CustomLogger::logTrackingMessage('s2s_redirection', $this->project, $this->panelist_id, '9.1| V2Controller - Inside returnEndpageView');


        if( in_array($this->status, [1, 2, 3, 4]) && !empty($trafficRow) && strpos($this->trafficRow->vendorsourceurl, 'autoclose=1') !== false){
            //dd($this->trafficRow->vendorsourceurl);
            $redirectBaseUrl = config('settings.APACE_V2_URL');
            $reviewPath = 'project/edit/'.$this->trafficRow->project_id.'/review-launch';
            $redirectParams = 'sjid='.$this->trafficRow->id.'&test_id='.implode(',', $this->trafficRow->vvars)."&respstatus=".$respstatus;

            $finalRedirectUrl = $redirectBaseUrl.'/'.$reviewPath.'?'.$redirectParams;
        }

        $arrResponse = [
            'status' => $status,
            'respstatus' => $respstatus,
            'finalRedirectUrl' => $finalRedirectUrl,
        ];

        CustomLogger::logTrackingMessage('s2s_redirection', $this->project, $this->panelist_id, '9.2| returnEndpageView - Response received from client - '.json_encode($arrResponse));
        CustomLogger::logTrackingMessage('s2s_redirection', $this->project, $this->panelist_id, '10.0| Survey Completed | project_code: '.$trafficRow->project_code . ', survey_code: '.$trafficRow->survey_code);
  
       return Response::view('survey.end.end', [
            'status' => $status,
            'respstatus' => $respstatus,
            'project' => $project,
            'trafficRow' => $trafficRow,
            'finalRedirectUrl' => $finalRedirectUrl,
        ]);
    }


    public function sendMailAfterSurveyCompletion($user,$survey_code=null,$point=null,$respId=null){
                $checkRealPanelist =User::with(['roles' => function ($q) {
                    $q->where('role_id', 4);}], 'permissions', 'providers')
                    ->where('id',$user->id)
                    ->first();
                    if(isset($checkRealPanelist) && !empty($checkRealPanelist)) {
                        $roles = $checkRealPanelist->roles;
                        if(!empty($roles) && isset($roles[0]) && $roles[0]->id == 4) {
                                $email = new survey_completed_mail($user, $survey_code, $point,$respId);
                                Mail::send($email);
                                \Log::info('Survey Completion Email Sent Successfully');
                        } else {
                            \Log::info('User is not a real panelist');
                        }            
                    } else {
                        return 'No Rocord found';
                    }
    }

    
}
