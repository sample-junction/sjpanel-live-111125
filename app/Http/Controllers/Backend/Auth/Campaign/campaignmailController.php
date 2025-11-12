<?php

namespace App\Http\Controllers\Backend\Auth\Campaign;

use Illuminate\Http\Request;
use App\Models\Auth\User;
use App\Http\Controllers\Controller;
use App\Models\Campaign\campaign_history;
use App\Models\Campaign\campaign;
use App\Models\Campaign\new_template;
use App\Models\Campaign\template_gallery;
// use App\Models\Campaign\dummy_template;
use App\Mail\Backend\Campaign\CampaignTest;
use Illuminate\Support\Facades\Mail;
use DB;

class campaignmailController extends Controller
{
    public function showCampaign(){
        $datas = Campaign::select('campaigns.*', 
                DB::raw('count(campaign_histories.panelist_id) as panelist_count'))
                ->leftJoin('campaign_histories', 'campaigns.id', '=', 'campaign_histories.campaign_id')
                ->groupBy('campaigns.id')
                ->orderBy('updated_at','DESC')
                ->get();
        return view('backend.auth.campaign.campaign')->with('datas',$datas);
    }

    public function showCampaignHistory(Request $request){
        $c_type = $request->get('c_type');
        $datas = campaign_history::where('campaign_id',$request->get('id'))
                ->select('campaign_histories.*', 
                DB::raw('campaigns.campaign_name as campaign_name'))
                ->leftJoin('campaigns', 'campaigns.id', '=', 'campaign_histories.campaign_id')
                ->orderBy('updated_at','DESC')
                ->get();
        if($c_type != 2){
            return view('backend.auth.campaign.index')->with('datas',$datas);
        }else{
            return view('backend.auth.survey_campaign.survey_history')->with('datas',$datas);
        }
    }

    public function sendCampaign(){
        $datas = campaign::where('type','!=','Survey')->where('campaign_status',1)->get();
        return view('backend.auth.support.campaign_send')->with('datas',$datas);
    }

    public function editGallery(){
        $datas = template_gallery::all();
        return view('backend.auth.campaign.gallery_page')->with('datas',$datas);
    }

    public function getCampaigndetail(Request $request){
        $id = $request->campaign_id;
        $datas = campaign::where('id',$id)->get();
        if($datas){
            return response()->json(['status'=>1,'datas'=>$datas]);
        }else{
            return response()->json(['status'=>2,'message'=>"record Not Found"]);
        }
    }

    public function campaignTemplate(){
        $datas = template_gallery::where('status','active')->orderBy('updated_at','DESC')->get();
        return view('backend.auth.campaign.new_campaign_template')
                ->with('datas',$datas);
    }

    public function newCampaignTemplate(Request $request){
        // return $request->all();
        // die();
        $request->validate([
            'template_type'=>'required',
            'template_name'=>'required',
            'template_content'=>'required',
            'url'=> 'required',
            'email_subject'=>'required',
            'user_id'=>'required'
        ]);

        $data=[
            'template_type'=>$request->input('template_type'),
            'template_name'=>$request->input('template_name'),
            'template_content'=>$request->input('template_content'),
            'url'=> $request->input('url'),
            'email_subject'=> $request->input('email_subject'),
            'user_id'=>$request->input('user_id')
        ];

        $template = new new_template();
        $template->fill($data);
        $save = $template->save();
        if($save){
            return back()->with('success','Successfully Saved');
        }else{
            return back()->with('fail','Failed');
        }
    }

    public function templateDetail(){
        $datas = DB::table('new_templates')
                ->select('new_templates.*', 'users.first_name as firstname', 'users.last_name as lastname')
                ->where('template_type','!=',2)
                ->join('users', 'users.id', '=', 'new_templates.user_id','inner')
                ->orderBy('updated_at','DESC')
                ->get();  
        return view('backend.auth.campaign.template_details')->with('datas',$datas);
    }

    public function templateEdit(Request $request){
        $datas = new_template::where('id',$request->get('id'))->get();
        $gallery = template_gallery::where('status','active')->get();
        return view('backend.auth.campaign.edit_template')->with('datas',$datas)->with('gallery',$gallery);
    }


    public function sendTestEmail(Request $request)
    {
        $template = new_template::findOrFail($request->get('id'));
        
        if (empty($template)) {
            return back()->with('error', 'Template content not found');
        }
        
        $userEmails = ['rajann@samplejunction.com','amarjitm@samplejunction.com']; 
        // $userEmails = ['rakeshs@samplejunction.com'];       
                  
        foreach ($userEmails as $userEmail) {
            if($userEmail == 'rajann@samplejunction.com'){
                 $approver = 1;
                 $reject = 1;
            }elseif($userEmail == 'amarjitm@samplejunction.com'){
                $approver = 2;
                $reject = 2;
            }else{
                $approver = 0;
                $reject = 0;
            }
            Mail::to($userEmail)->send(new CampaignTest($template,$approver,$reject));
        }
    
        return back()->with('success', 'Test email sent successfully');
    }

    public function approveTemplate(Request $request)
    {
        $approvalStatus = $request->get('approval_status');
        $templateId = $request->get('template_id');
        $template = new_template::find($templateId);
    
        if ($template) {
            $template->template_status = $approvalStatus;
            $template->save();
        } else {
            $request->session()->flash('error', 'Template not found');
        }
    }
    
    public function templateUpdate(Request $request){
        
        $request->validate([
            'template_type'=>'required',
            'template_name'=>'required',
            'template_content'=>'required',
            'url'=> 'required',
            'email_subject'=>'required',
            'user_id'=>'required'
        ]);

        $id= $request->input('temp_id');
        $template = new_template::find($id);
        if($template){
        $template->template_name= $request->input('template_name');
        $template->template_content = $request->input('template_content');
        $template->url = $request->input('url');
        $template->user_id = $request->input('user_id');
        $template->template_type = $request->input('template_type');
        $template->email_subject = $request->input('email_subject');
        $save = $template->save();
        if($save){
            return back()->with('success','Successfully Updated');
        }else{
            return back()->with('fail','Failed');
        }
        }else{
            return back()->with('fail','Failed');
        }

    }

    public function templateDel(Request $request){
        $id = $request->get('id');
        $data = new_template::find($id);
        if (!$data) {
            return back()->with('fail', 'Template not found');
        }
        $data->delete();
        return back()->with('success', 'Template successfully deleted');
    }

    public function getTemplate(Request $request){
          
          $id = $request->get('id');
          $datas = new_template::where('id',$id)->get();
          return response()->json([
            'data'=>$datas
          ]);

    }

    public function createCampaign(Request $request){
        // return $request->all();
        $request->validate([
            'campaign_name'=> 'required|unique:campaigns', 
            'campaign_subject'=> 'required',
            'template_type' => 'required',
            'template_id' => 'required',
            'template_name' => 'required',
            'campaign_content'=> 'required',
            'campaign_amount' => 'required',
            'type'=> 'required',
            'campaign_link'=> 'required',
            'campaign_start_date'=> 'required'
        ]);
        $datas = [
            'campaign_name'=> $request->input('campaign_name'),
            'campaign_subject'=>$request->input('campaign_subject'),
            'template_type' => $request->input('template_type'),
            'template_id' => $request->input('template_id'),
            'template_name' => $request->input('template_name'),
            'campaign_content'=>$request->input('campaign_content'),
            'campaign_amount' =>$request->input('campaign_amount'),
            'type'=>$request->input('type'),
            'campaign_link'=>$request->input('campaign_link'),
            'campaign_start_date'=>$request->input('campaign_start_date'),
        ];
        $campaign = new campaign();
        $campaign->fill($datas);
        $confirm = $campaign->save();
        if($confirm){
            return back()->with('success',"Successfully Saved!");
        }else{
            return back()->with('fail',"Failed!");
        }

    }
    public function editCampaign(Request $request){
        $id = $request->get('id');
        $gallery = template_gallery::all();
        $datas = campaign::where('id',$id)->get();
        return view('backend.auth.campaign.edit_campaign')->with('datas',$datas)->with('gallery',$gallery);

    }

    public function updateCampaign(Request $request){
        $request->validate([
            'campaign_name'=> 'required', 
            'campaign_subject'=> 'required',
            'template_name' => 'required',
            'campaign_content'=> 'required',
            'campaign_amount' => 'required',
            'type'=> 'required',
            'campaign_link'=> 'required',
            'campaign_start_date'=> 'required'
        ]);
        $id = $request->input('camp_id');
        $campaign = campaign::where('id', $id)->first(); 
    
        $datas = [
            'campaign_name' => $request->input('campaign_name'),
            'campaign_subject' => $request->input('campaign_subject'),
            'template_name' => $request->input('template_name'),
            'campaign_content' => $request->input('campaign_content'),
            'campaign_amount' => $request->input('campaign_amount'),
            'type' => $request->input('type'),
            'campaign_link' => $request->input('campaign_link'),
            'campaign_start_date' => $request->input('campaign_start_date'),
        ];
    
        $confirm = $campaign->update($datas); 
    
        if($confirm){
            return redirect('admin/auth/support/birthdaysent')->with('success', "Successfully Saved!");
        } else {
            return back()->with('fail', "Failed!");
        }
    }

    public function delCampaign(Request $request){
        $id = $request->get('id');
        $data = campaign::find($id);
        if (!$data) {
            return back()->with('fail', 'Template not found');
        }
        $data->delete();
        return back()->with('success', 'Template successfully deleted');
    }

    public function activeOrdeactive(Request $request){
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

    public function showCloneCampaign(Request $request){
        $id = $request->get('id');
        $datas = campaign::where('id',$id)->get();
        $gallery = template_gallery::all();
        return view('backend.auth.campaign.clone_campaign')->with('datas',$datas)->with('gallery',$gallery);
    }

    public function createCloneCampaign(Request $request){
    //    return $request->all();
    //    die();
        $request->validate([
            'campaign_name'=> 'required|unique:campaigns', 
            'campaign_subject'=> 'required',
            'template_type' => 'required',
            'template_id' => 'required',
            'template_name' => 'required',
            'campaign_content'=> 'required',
            'campaign_amount' => 'required',
            'type'=> 'required',
            'campaign_link'=> 'required',
            'campaign_start_date'=> 'required'
        ]);
        $datas = [
            'campaign_name'=> $request->input('campaign_name'),
            'campaign_subject'=>$request->input('campaign_subject'),
            'template_type' => $request->input('template_type'),
            'template_id' => $request->input('template_id'),
            'template_name' => $request->input('template_name'),
            'campaign_content'=>$request->input('campaign_content'),
            'campaign_amount' =>$request->input('campaign_amount'),
            'type'=>$request->input('type'),
            'campaign_link'=>$request->input('campaign_link'),
            'campaign_start_date'=>$request->input('campaign_start_date'),
        ];
        $campaign = new campaign();
        $campaign->fill($datas);
        $confirm = $campaign->save();
        if($confirm){
            return back()->with('success',"Successfully Saved!");
        }else{
            return back()->with('fail',"Failed!");
        }
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
                    $header = $row;
                    // $header = array('panellist_id','project_id','reason');
                else
                    if (count($header) != count($row)) {
                        return 'not_matched';

                    }else{
                        $row['panellist_id'] = intval($row['panellist_id']);
                        $data[] = array_combine($header, $row);
                    }
                    
            }
            fclose($handle);
        }

        return $data;
    }
}
