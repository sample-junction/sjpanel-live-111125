<?php

namespace App\Http\Controllers\Backend\Auth\Survey_campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Campaign\campaign_history;
use App\Models\Campaign\campaign;
use App\Models\Campaign\new_template;
use App\Models\Campaign\template_gallery;
use App\Models\Campaign\dummy_template;
use App\Models\Setting\Setting;
use DB;
use App\Helpers\MailHelper;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Auth\User;
use App\Models\Project\UserProject;
use App\Models\Project\expenseRecord;
use App\Models\Auth\UserUnsubscribe;

class surveyCampaignController extends Controller
{
  
    /*
     Showing the master page of survey reminder page
     */
    public function showSurveyInvite(){
        $datas = new_template::where('template_type', 2)->where('template_status',1)->orderBy('updated_at','DESC')->get();
        $datas2 = campaign::where('type','Survey')->orderBy('updated_at','DESC')->get();
        return view('backend.auth.survey_campaign.index')
              ->with('datas',$datas)
              ->with('datas2',$datas2);
    }

    public function panelBonusshow(){
        // $users = User::all();

      $users =  User::with(['roles' => function ($q) {
            $q->where('role_id', 4);}], 'permissions', 'providers')
            ->where('active',1)->where('confirmed',1)
            ->get();

       $userPoints = [];
      if(isset($users)){
        foreach($users as $user){
            $userPoints[] = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        }
      }

        // echo '<pre>';
        // print_r($userPoints);die;
        
        $joining_bonus = Setting::whereIn('key',['PANEL_AUTOMOTIVE_POINTS','PANEL_MY_PROFILE_POINTS','PANEL_BASIC_PROFILE_POINTS',
        'PANEL_EMPLOYMENT_POINTS','PANEL_FAMILY_POINTS','PANEL_HEALTH_FOOD_POINTS','PANEL_TECHNOLOGY_POINTS','PANEL_TRAVEL_LEISURE_POINTS'])->sum('value');
        // dd($users);
        
        return view('backend.auth.survey_campaign.panel_bonus_show')
        ->with('users',$users)
        ->with('joining_bonus',$joining_bonus)
        ->with('userPoints',$userPoints);
            //   ->with('datas',$datas)
            //   ->with('datas2',$datas2);
    }


    /*
    showing Create Template Page
    */
    public function showSurveyTemp(){
        $datas = template_gallery::where('status','active')->get();
        return view('backend.auth.survey_campaign.new_survey_template')
               ->with('datas',$datas);
    }


    /*
    Storing the new created survey mail template
    */
    public function createSurveyTemp(Request $request){
        $request->validate([
            'template_type' => 'required',
            'template_name' =>'required|unique:new_templates',
            'template_content' => 'required',
            'email_subject' => 'required'
        ]);
        
        $datas = [
            'template_type' => $request->input('template_type'),
            'template_name' => $request->input('template_name'),
            'template_content' => $request->input('template_content'),
            'email_subject' => $request->input('email_subject'),
            'user_id' => $request->input('user_id')
        ];
        $save = new_template::create($datas);
        if($save){
            return back()->with('success','successfull');
        }else{
            return back()->with('fail','Failed');
        }
        
    }

    /*
    Displaying all the new created survey mail template created in table
    */
    public function showSurveyTempDetail(){
        $datas = DB::table('new_templates')
                ->select('new_templates.*', 'users.first_name as firstname', 'users.last_name as lastname')
                ->where('template_type','=', 2)
                ->leftJoin('users', 'users.id', '=', 'new_templates.user_id')
                ->orderBy('updated_at','DESC')
                ->get();  
        return view('backend.auth.survey_campaign.survey_details')->with('datas',$datas);
    }

    /*
    Redirecting to the edit survey Template page
    */
    public function editSurveyTemp(Request $request){
        $id = $request->get('temp_id');
        $datas = new_template::where('id',$id)->get();
        $gallery = template_gallery::where('status','active')->get();
        return view('backend.auth.survey_campaign.edit_survey_template')
              ->with('datas', $datas)
              ->with('gallery',$gallery);
    }

    
    /*
    Storing the edited survey templates
    */
    public function updateSurveytemp(Request $request){
        $request->validate([
            'template_type' => 'required',
            'template_name' =>'required',
            'template_content' => 'required',
            'email_subject' => 'required'
        ]);
        $id = $request->get('template_id');
        $datas = [
            'template_type' => $request->input('template_type'),
            'template_name' => $request->input('template_name'),
            'template_content' => $request->input('template_content'),
            'email_subject' => $request->input('email_subject'),
            'user_id' => $request->input('user_id')
        ];
        $template = new_template::find($id); 
        if (!$template) {
            return back()->with('fail', 'Template not found');
        }

        $template->fill($datas); 
        $save = $template->save(); 
        if($save){
            return back()->with('success','successfull');
        }else{
            return back()->with('fail','Failed to update template');
        }
        
    }


    public function getSurveyTempbyid(Request $request){
        $id = $request->get('id');
        $datas = new_template::where('id',$id)->get();
        if($datas){
            return response()->json(['datas'=>$datas,'status'=>200]);
        }else{
            return response()->json(['datas'=>'Failed','status'=>0]);
        }
        
    }
    
    public function surveyReminderCreate(Request $request){
        // return $request->all();
        // die();
        $request->validate([
            'campaign_name'=>'required|unique:campaigns',
            'template_id'=>'required',
            'campaign_subject'=>'required',
            'template_content'=>'required',
            'template_name'=>'required',
            'template_type'=>'required',
            'type'=>'required',
        ]);

        $datas = [
          'campaign_name' => $request->input('campaign_name'),
          'template_id' => $request->input('template_id'),
          'campaign_subject' => $request->input('campaign_subject'),
          'campaign_content' => $request->input('template_content'),
          'template_name' => $request->input('template_name'),
          'template_type'=> $request->input('template_type'),
          'type'=> $request->input('type')
        ];

        $save = campaign::create($datas);
        if($save){
            return back()->with('success','succesfully created');
        }else{
            return back()->with('fail','Failed to create');
        }

    }

    public function deleteSurveytemp(Request $request){
        $id = $request->get('temp_id');
         $template = new_template::find($id);
        if(!$template) {
            return back()->with('fail', 'Template not found');
        }
        $template->delete();
        return back()->with('success', 'Successfully deleted');
    }

    public function delSurveyReminder(Request $request){
        $id = $request->get('id');
        $survey_reminder = campaign::find($id);
       if(!$survey_reminder) {
           return back()->with('fail', 'Template not found');
       }
       $survey_reminder->delete();
       return back()->with('success', 'Successfully deleted');
    }

    public function editSurveyReminder(Request $request){
        $id = $request->get('id');
        $gallery = template_gallery::where('status','active')->get();
        $datas = campaign::where('id',$id)->get();
        return view('backend.auth.survey_campaign.edit_survey_reminder')->with('datas',$datas)->with('gallery',$gallery);

    }

    public function updateSurveyReminder(Request $request){
        $request->validate([
            'campaign_name' => 'required',
            'template_id' => 'required',
            'campaign_subject' => 'required',
            'campaign_content' => 'required',
            'template_name' => 'required',
            'template_type' => 'required',
            'type' => 'required',
        ]);
        
        $id = $request->input('id');
        $survey_reminder = Campaign::find($id);
        
        if(!$survey_reminder) {
            return back()->with('fail', 'Campaign not found');
        }
        
        $survey_reminder->campaign_name = $request->input('campaign_name');
        $survey_reminder->template_id = $request->input('template_id');
        $survey_reminder->campaign_subject = $request->input('campaign_subject');
        $survey_reminder->campaign_content = $request->input('campaign_content');
        $survey_reminder->template_name = $request->input('template_name');
        $survey_reminder->template_type = $request->input('template_type');
        $survey_reminder->type = $request->input('type');
        
        $save = $survey_reminder->save();
        
        if ($save) {
            return redirect('admin/auth/show-survey-invite')->with('success', 'Successfully updated');
        } else {
            return back()->with('fail', 'Failed to update');
        }
        
    }

    public function showCloneSurveyreminder(Request $request){
        $id = $request->get('id');
        $datas = campaign::where('id',$id)->get();
        $datas2 = template_gallery::where('status','active')->get();
        return view('backend.auth.survey_campaign.clone-survey_reminder')->with('datas',$datas)->with('datas2',$datas2);
    }

    public function updateCloneSurveyreminder(Request $request){
        // return $request->all();
        $request->validate([
            'campaign_name'=>'required|unique:campaigns',
            'template_id'=>'required',
            'campaign_subject'=>'required',
            'campaign_content'=>'required',
            'template_name'=>'required',
            'template_type'=>'required',
            'type'=>'required',
        ]);

        $datas = [
          'campaign_name' => $request->input('campaign_name'),
          'template_id' => $request->input('template_id'),
          'campaign_subject' => $request->input('campaign_subject'),
          'campaign_content' => $request->input('campaign_content'),
          'template_name' => $request->input('template_name'),
          'template_type'=> $request->input('template_type'),
          'type'=> $request->input('type')
        ];

        $save = campaign::create($datas);
        if($save){
            return redirect('admin/auth/show-survey-invite')->with('success', 'Successfully updated');
        }else{
            return back()->with('fail','Failed to create');
        }

    }


    public function showSendSurveyReminder(){
        $datas = campaign::where('type','=','Survey')->where('campaign_status',1)->orderBy('updated_at','DESC')->get();
        return view('backend.auth.survey_campaign.send_survey_reminder')->with('datas',$datas);
    }

    public function SurveyReminderGetById(Request $request){
        $id = $request->get('id');
        $datas = campaign::where('id',$id)->where('type','=','Survey')->first();
        if($datas){
            return response()->json([
                'datas'=>$datas,
                'status'=>200
            ]);
        }else{
            return response()->json([
                'datas'=>'No Record Found!',
                'status'=>0
            ]);
        }
       
    }

    public function surveyDetailsByCode(Request $request){
        $code = $request->get('code');
        $datas = DB::table('user_projects')
                ->where('user_projects.apace_project_code', '=', $code)
                ->select('users.panellist_id', 'user_projects.user_id','user_projects.apace_project_code','projects.survey_status_code','user_projects.apace_project_code','user_projects.status','projects.test_url')
                ->whereNull('user_projects.status')
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->join('users', 'users.id', '=', 'user_projects.user_id')
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->orderBy('projects.created_at','DESC')
                ->orderBy('projects.cpi', 'desc')
                ->get();   
        return response()->json(['datas' => $datas]);
    }
    

    public function sendSurveyReminderMail(Request $request){

        $request->validate([
            'subject_line' =>'required',
            'email_content' =>'required',
            'campaign_id' =>'required',
            'type_name' =>'required',
            'campaign_status' =>'required',
            'survey_code'=>'required'
        ]);
        
        $subjectLine = $request->input('subject_line');
        $emailContent = $request->input('email_content');
        $campaign_id = $request->input('campaign_id');
        $c_type =  $request->input('type_name');  
        $status_link = $request->input('status_link'); 
        $campaign_status = $request->input('campaign_status');
        $survey_code = $request->input('survey_code');
        

        $file = $request->file('importfile');
        if($file){
            $customerArr = $this->csvToArray($file);
            if(isset($customerArr)){
                $panelist_ids=[];
                foreach($customerArr as $row){
                    $panelist_ids[] = $row['panellist_id'];        
                }
            }else{
                return back()->with('fail','Failed');
            }
        }else{
            $panelist_ids= $request->input('panelist_id');
        }

    
            if(!empty( $panelist_ids)){
                $survey = DB::table('user_projects')
                ->where('user_projects.apace_project_code', '=', $survey_code)
                ->select('users.*', 'users.panellist_id', 'users.email', 'users.uuid', 'user_projects.*', 'user_projects.id as user_pro_id', 'projects.id as pro_id','projects.*')
                ->whereNull('user_projects.status')
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->join('users', 'users.id', '=', 'user_projects.user_id')
                ->whereIn('users.panellist_id', $panelist_ids)
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->orderByDesc('projects.created_at')
                ->orderBy('projects.cpi', 'desc')
                ->get();
            }else{
                return back()->with('fail','Panelist ID not found');
            }
     
    
            $pointsConversionMetric = config('app.points.metric.conversion');
    
           if(isset($survey)){
            foreach ($survey as $sur) {
            
                try{
                $campaign_code = md5(uniqid(mt_rand(), true));
                $logo_url = url('/');
            
                $url = str_replace('[%sjpid%]', $sur->uuid . '_sjpid', $sur->user_live_link);
                $url_new = str_replace('test30', 'test17', $url);    
                $status_link_new = $url_new.'&code='.$campaign_code;
                $FirstName = decrypt($sur->first_name);
                $points = round($sur->cpi / $pointsConversionMetric);
                $topic = $sur->project_topic_name;
                $subject =str_replace(':dollor','$'.$sur->cpi,$subjectLine);
                $project_id =$sur->pro_id;
                $user_pro_id = $sur->user_pro_id;
                $survey_loi = $sur->loi;
                $survey_number = $sur->apace_project_code;
                $email=decrypt( $sur->email);
            
                $Content = str_replace(
                    [':link', ':userFristName', ':logo_url', ':Survey_code', ':survey_link', ':points', ':dollor', ':topic', ':min'],
                    [$status_link_new, $FirstName, $logo_url, $survey_number, $status_link_new, $points, $sur->cpi, $topic, $sur->loi],
                    $emailContent
                );
            
                $datas = [
                    'campaign_id' => $campaign_id,
                    'c_type' => $c_type,
                    'panelist_id' => $sur->panellist_id,
                    'campaign_subject' => $subject,
                    'campaign_content' => $Content,
                    'campaign_amount' => $sur->cpi,
                    'campaign_code' => $campaign_code,
                    'campaign_status' => $campaign_status,
                    'status_link' => $status_link_new,
                    'survey_loi'=>$survey_loi,
                    'survey_topic'=>$topic,
                    'survey_code'=>$survey_number,
                    'project_id'=>$project_id,
                    'user_pro_id'=>$user_pro_id,
                ];
                
                 $campaign = new campaign_history();
                 $campaign->fill($datas);
                 $result= $campaign->save();      
                 if($result){
                    MailHelper::sendBirthdayMail($sur,$email, $subject, $Content); 
                   // MailHelper::sendBirthdayMail($sur,'obhimainom@samplejunction.com', $subject, $Content); 
                  }

                } catch (\Exception $e) {
                    continue;
                }
            }

            return back()->with('success','Successfully sent');
           }else{
            return back()->with('fail','Data not found');
           }
    
        
    }


    public function activeOrdeactivesurvey(Request $request){
        $id = $request->get('id');
        $data = campaign::find($id);
        if($data){
            if($data->campaign_status == 0){
                $data->campaign_status = 1;
                
            }else{
                $data->campaign_status = 0;
            }
            $data->save();
        }
        return back();
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
               // print_r($row);die;
                if (!$header)
                    // $header = $row;
                    $header = array('panellist_id');
                else
                    if (count($header) != count($row)) {
                        return 'not_matched';

                    }else{

                        $data[] = array_combine($header, $row);
                    }
                    
            }
            fclose($handle);
        }

        return $data;
    }


    public function ReconcilationRejection(){
        $datas = campaign_history::where('c_type','=','Rejection')->orderBy('created_at','desc')->get();
        return view('backend.auth.survey_campaign.survey_rejection_history')->with('datas',$datas);
    }

    public function showUnsubscribe(Request $request)
    {
        $datas = UserUnsubscribe::all();
        $Unsubscribe = [];
        foreach ($datas as $data) {
            $emailHash = sha1($data->email);
            
            $userinfo = User::where('email_hash', $emailHash)->select('panellist_id')->first();
            $unsubscribeData = [];
            if(!empty($userinfo)){
            $unsubscribeData['panellist_id'] = $userinfo->panellist_id;
            $unsubscribeData['reason'] = $data->reason;
            $unsubscribeData['otherReason'] = $data->otherReason;
            $unsubscribeData['created_at'] = $data->created_at->format('d-m-Y');
            
            $Unsubscribe[] = $unsubscribeData;
          }
		  
        }
    
        return view('backend.auth.user.show_unsubscribe', compact('Unsubscribe'));
    }
    

    public function expenseRecord(){
        $datas = expenseRecord::orderBy('created_at', 'desc')->get();
        return view('backend.auth.survey_campaign.expense_record')
               ->with('datas',$datas);
    }

    
}
