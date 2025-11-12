<?php

namespace App\Http\Controllers\Backend\Auth\Invite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Auth\User;
use App\Models\InviteCampaign\InviteCampaign;
use App\Models\InviteCampaign\UnverifyEmail;
use App\Models\InviteCampaign\ReminderMailSend;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\MailHelper;
use App\Mail\Frontend\UserConfirm\FreshMail;
use App\Mail\Frontend\UserConfirm\ReminderMail;

use Carbon\Carbon;

class InviteCampaignController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    public function index(Request $request)
    {   
         $user=DB::table('users')->select('gender','dob','zipcode','panellist_id')
        ->whereNotNull('gender')
        ->whereIn('panellist_id',[231130100001, 
240207250009, 
240213010002, 
240220000004, 
240220180001, 
240220200010, 
240229570010, 
240315180008
])->get();
        
        $data=[];
        foreach($user as $users){
            
            $gender=\Crypt::decrypt($users->gender);
            $dob=Carbon::parse($users->dob)->age;
            $zipcode=\Crypt::decrypt($users->zipcode);
            $data[$users->panellist_id]=$gender."-".$dob."-".$zipcode;

        }
        
        return view('backend.auth.invites.index');
    }

    public function uploadRequest(Request $request)
    {
        $user = auth()->user();
        if($request->hasFile('csv_file')){
            $file = $request->file('csv_file');
            $temp = fopen($file->getRealPath(),'r');
           
            if($temp !== false){
                $seenEmails = [];
                $duplicateEmails = [];
                $new_data = [];
                $headers = fgetcsv($temp);
                $db_data = InviteCampaign::all()->pluck('email')->toArray();
                array_map('strtolower', $db_data);
                // if(in_array('ositogrunon@gmail.com',$db_data)){
                // echo '<pre>';
                // print_r('$db_data');die();
                // }
                // while(($data = fgetcsv($temp,1000,",")) !== false){
                //     $new_data[] = $data;
                // }
                // echo '<pre>';
                // print_r($new_data);die();
                while(($data = fgetcsv($temp,1000,",")) !== false){

                    //$emailToCheck = strtolower($data[1]);
                    $emailToCheck = strtolower($data[0]);
                    if(!in_array($emailToCheck , $seenEmails) && !in_array($emailToCheck,$db_data) && $emailToCheck ){
                        $seenEmails[] = $emailToCheck;
                        $email_validator_token = config('settings.EMAIL_QUALITY_SCORE_TOKENS');
                        $rndIndex = mt_rand(0, count($email_validator_token) - 1);
                        $key = $email_validator_token[$rndIndex];
                        $resultValidation = $this->emailExist($emailToCheck,$key);

                        if(array_key_exists('error',$resultValidation)){
                            $email_verified = 0;
                            $email_status = null;
                            $validation_response = null;
                            $error_log = $resultValidation['error'];
                        }else{
                            $result = $resultValidation['success'];
                            $validation_response = $result;
                            $error_log = null;
                            if(isset($result['success']) && $result['success'] === true){
                                $email_verified = 1;
                                if($result['recent_abuse'] === false && ($result['valid'] === true || $result['timed_out'] === true && $result['disposable'] === false && $result['dns_valid'] === true))
                                {
                                    $email_status = 0;
                                } else {
                                    $email_status = 2;
                                }
                            }else{
                                $email_verified = 0;
                                $email_status = null;
                            }
                            
                        }
                        $current_time = now();
                        $new_data[] = [
                            'first_name' => $data[1],
                            'last_name' => $data[2],
                            'email' => $emailToCheck,
                            'ipquality_token' => $key,
                            'email_verified' => $email_verified,
                            'email_status' => $email_status,
                            'validation_response' => json_encode($validation_response),
                            'error_log' => $error_log,
                            'created_at' => $current_time,
                            'updated_at' => $current_time,
                        ];
                        
                    }else{
                        $duplicateEmails[] = [
                            'first_name' => $data[1],
                            'last_name' => $data[1],
                            'email' => $emailToCheck,
                            'mob' => isset($data[3]) ? $data[3] : null,
                        ];
                    }
                }
                fclose($temp);
                // echo '<pre>';
                // print_r(($duplicateEmails));die();
                if($new_data){
                    InviteCampaign::insert($new_data);
                }
                
                return \Redirect::back()->with(['flashSuccess' => 'File has been Successfully Uploaded', 'duplicateEmails' => $duplicateEmails]);
                    
            }else{
                return \Redirect::back()
                    ->withFlashDanger("Failed to open file: " . $file->getRealPath());
            }
            
        }else{
            return \Redirect::back()
                ->withFlashDanger("Some Error Occurred");
        }
    }

    public function sendBulkMail(Request $request)
    {

        $mail_limit_min = $request->mail_limit_min;
        $mail_limit_max = $request->mail_limit_max;
        if($request->is_reminder){
            // $subject = 'Reminder: Survey Consensus Has Merged with SJ Panel.';
            /**subject for incentive reminder */
            $subject = 'Discover SJ Panel: Earn Rewards with Surveys';
            $mail_list = DB::table('invite_campaigns')

            //$mail_list = DB::table('inv_camp_copy_for_mail_test_purpose')
                    ->where('has_visited','=',0)
                     ->whereNull('reminder_count')
                    ->where('email_sent','=',1)
                    //->where('reminder_count','=',0)
                    ->whereNotIn('id',[88,206,136,1093,2409,3096,3771,5215,11800])
                    ->limit($mail_limit_max)//->toSql(); echo '<pre>';print_r($mail_list);die();
                    ->get();
        }else{
            //$subject = 'Important: Survey Consensus Has Merged with SJ Panel.';
            $subject = 'Discover SJ Panel: Earn Rewards with Surveys';
            $mail_list = DB::table('invite_campaigns')
             //$mail_list = DB::table('inv_camp_copy_for_mail_test_purpose')
                    ->where('email_sent','=',0)
                    ->whereNotIn('id',[88,206,136,1093,2409,3096,3771,5215,11800])
                    ->limit($mail_limit_max)//->toSql(); echo '<pre>';print_r($mail_list);die();
                    ->get();
        }
        $success = [];
        $fail = [];
        foreach($mail_list as $record){
            if($record->email_sent === 0 || $request->is_reminder){
                try{
                    $recipients = [$record->email];
                    $sending_time = now();
                    $campaign_code = md5(uniqid(mt_rand(), true));
                    MailHelper::sendBulkMail($record,$recipients,$subject,$campaign_code);
                    if($request->is_reminder){
                        if($record->reminder_count){
                            $reminder_count = $record->reminder_count + 1;
                        }else{
                            $reminder_count = 1;
                        }
                        $updated = DB::table('invite_campaigns')
                         //$updated = DB::table('inv_camp_copy_for_mail_test_purpose')
                            ->where('id',$record->id)
                            ->update(['reminder_count' => $reminder_count, 'reminder_sent_at' => $sending_time, 'reminder_code' => $campaign_code]);
                    }else{
                        $updated = DB::table('invite_campaigns')
                         //$updated = DB::table('inv_camp_copy_for_mail_test_purpose')
                            ->where('id',$record->id)
                            ->update(['email_sent' => 1, 'email_sent_at' => $sending_time, 'campaign_code' => $campaign_code]);
                    }
                    
                    if($updated > 0){
                        $success[] = [
                            'Mail' => $record->email,
                            'Sent_At' => $sending_time,
                            'source' => 'Email Invitation'
                        ];
                    }else{
                        $fail[] = [
                            'Mail' => $record->email,
                            'Error' => 'Mail sent but db update failed',
                            'source' => 'Email Invitation'
                        ] ;
                    }
                    
                }catch(Exception $e){
                    \Log::error('Mail sending failed : ' .$e->getMessage());
                    $fail[] = [
                        'Mail' => $record->email,
                        'Error' => 'Mail sending failed : ' .$e->getMessage(),
                        'source' => 'Survey Consensus'
                    ] ;
                }
            }
        }
        // echo '<pre>';  
        // print_r($mail_list);die();
        return \Redirect::back()->with(['flashSuccess' => 'Operation completed', 'successEmails' => $success, 'failedEmails' => $fail]);
    }

    public function exportData(Request $request)
    {
        $flag = 0;
        $success_flag = 0;
        $date = date("d-m-Y");
        if($request->has('faulty_data')){
            $dataList = json_decode($request->input('faulty_data'),true);
            $name = 'Invite Campaign faulty data ';
          
        }elseif ($request->has('success_email_data')) {
            
            $dataList = json_decode($request->input('success_email_data'),true);
            $name = 'Bulk Email Success data ';
            $success_flag = 1;
        }elseif ($request->has('fail_email_data')) {
          
           $dataList = json_decode($request->input('fail_email_data'),true);
           $name = 'Bulk Email Fail data ';
        }else{
            // $dataList = InviteCampaign::all()->toArray();
            $dataList = InviteCampaign::where('id','>',5063)->where('email_verified', 1)->where('email_sent','!=',1)->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->toArray();
            $name = 'Validated Campaign Data ';
            $flag = 1;
        }
        
        $file_name = $name.$date;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$file_name}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        
        $callback = function() use ($dataList,$flag,$success_flag){
            $file = fopen('php://output', 'w');
            if(isset($dataList[0])){
                fputcsv($file, array_keys($dataList[0]));
            }
            foreach($dataList as $row){
                if($flag){
                    $row['validation_response'] = json_encode($row['validation_response']);
                }
                if($success_flag){
                    $row['Sent_At'] = json_encode($row['Sent_At']);
                }
                fputcsv($file,$row);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    private function emailExist($email,$key)
    {
        $EMAIL_QUALITY_URL=config('settings.EMAIL_QUALITY_URL');
        //code Added By Ramesh Kamboj//
        /*
        * Set the maximum number of seconds to wait for a reply
        * from an email service provider. If speed is not a concern 
        * or you want higher accuracy we recommend setting this in 
        * the 20 - 40 second range in some cases. Any results which 
        * experience a connection timeout will return the "timed_out" 
        * variable as true. Default value is 7 seconds.
        */
        $timeout = 1;

        /*
            * If speed is your major concern set this to true, 
            * but results will be less accurate.
            */
        $fast = 'false';
        /*
        * Adjusts abusive email patterns and detection rates
        * higher levels may cause false-positives (0-2)
        */
        $abuse_strictness = 0;
       
        $parameters = array(
                'timeout' => $timeout,
                'fast' => $fast,
                'abuse_strictness' => $abuse_strictness
            );
            // Format our parameters.
        $formatted_parameters = http_build_query($parameters);
        $url = sprintf(
                $EMAIL_QUALITY_URL.'/%s/%s?%s', 
                $key,
                urlencode($email),
                $formatted_parameters
            );
        
        $curl = curl_init();
            
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $json = curl_exec($curl);
        curl_close($curl);

        if($json === false){
            $err_number = curl_errno($curl);
            $err_msg = curl_error($curl);
            return ['error' => 'Error No.- ' . $err_number . ' : Error- ' . $err_msg];
        }else{
            return ['success' => json_decode($json,true)];
        }
    }                                                               
	
	/* parshant sharma [25-06-2024] */
	public function sendInvitation(){

		return view('backend.auth.invites.sendInvitation');
	}// sendInvitation
	
	/* parshant sharma [24-06-2024] */
	public function invitation(){
		
		$recentEmailsSent = InviteCampaign::selectRaw('batch_number, email_sent_at, COUNT(*) as count')
            ->where('email_sent', 1)
            ->whereNotNull('batch_number')
            ->groupBy('batch_number')
            ->get();
			
		return view('backend.auth.invites.invitation', compact('recentEmailsSent'));
	}// invitation
	
	/* parshant sharma [25-06-2024] */
	public function inviteFreshUpload(Request $request){
		//dd($request->all());
		$user = auth()->user();
        //$batchNumber = $request->input('batch_number'); 		
        $batchNumber = 'B' . date('ymdHi');	
		//dd($batchNumber);
		
		if ($request->hasFile('csv_file')) {
            $file = $request->file('csv_file');
            $temp = fopen($file->getRealPath(), 'r');
    
            if ($temp !== false) {
                // $batchNumber = uniqid();
                $seenEmails = [];
                $rejectedEmails = [];
                $new_data = [];
                $headers = fgetcsv($temp);
				//dd($headers);
				
    
                while (($data = fgetcsv($temp, 1000, ",")) !== false) {
					//dd($data);
                    if (isset($data[0])) {
                        $emailToCheck = strtolower($data[0]);
                        $nameToCheck = strtolower($data[1]);
						//$seenEmails[] = $nameToCheck;
                        
						if (!in_array($emailToCheck, $seenEmails) && $emailToCheck) {
							
                            $seenEmails[] = $emailToCheck;
							
							/* we will check whether the email is already sent or not */
							
							$mail_sent = DB::table('invite_campaigns')
										->where('has_visited','=',0)
										->where('email_sent','=',0)
										->where('email','=',$emailToCheck)
										//->limit(1)//->toSql(); echo '<pre>';print_r($mail_sent);die();
										->first();
										
							if($mail_sent){
								
								$current_time = now();									
								$new_data[] = [
												'first_name' => $data[1],
												'last_name' => $data[2],
												'email' => $emailToCheck,
												'created_at' => $current_time,
												'updated_at' => $current_time,
												'batch_number' => $batchNumber,
											];
								
							}else{
								$rejectedEmails[] = [
										'first_name' => $data[1],
										'last_name' => $data[2],
										'email' => $emailToCheck,
										'mobile' => isset($data[3]) ? $data[3] : null,
										'branch_name' => $batchNumber,
										'reason' => 'Email already sent' 
									];
							}									
							
                        } else {
                            $rejectedEmails[] = [
                                'first_name' => $data[1],
                                'last_name' => $data[2],
                                'email' => $emailToCheck,
                                'mobile' => isset($data[3]) ? $data[3] : null,
                                'branch_name' => $batchNumber,
                                'reason' => 'Duplicate Email'
                            ];
                        }
                    }
					
                }
                fclose($temp);
				if (!empty($rejectedEmails)) {
                    UnverifyEmail::insert($rejectedEmails);
                }
				//print_r($new_data);

               //exit;

                if ($new_data) {
					
                    /* InviteCampaign::insert($new_data); */
                
                    foreach ($new_data as $userData) {
                        try {
                            $subject = "Discover SJ Panel: Earn Rewards with Surveys";
                            $campaign_code = md5(uniqid(mt_rand(), true));
                            $token = $campaign_code;
                            $link = route('frontend.auth.register', ['token' => $campaign_code, 'is_campaign' => 1]);
                            Mail::to($userData['email'])->send(new FreshMail($userData, $subject, $link, $token));
							
                            /* $recipients = [$userData['email']];
                            MailHelper::sendBulkMail($userData,$recipients,$subject,$token); */
                            InviteCampaign::where('email', $userData['email'])->update([
                                'batch_number' => $batchNumber,
                                'email_sent' => 1,
                                'email_sent_at' => now(),
                                'campaign_code' => $token
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('Error sending email to ' . $userData['email'] . ': ' . $e->getMessage());
                        }
                    }
                    return redirect()->back()->with('success', 'Emails sent successfully.');					
                } else {
                    return redirect()->back()->with('error', 'Fresh Invite not sent.');
                }		
				
			}
		}
		
	}// inviteFreshUpload
	
	/* parshant sharma [28-06-2024] */
	public function allFreshInvites(Request $request, $batch){
		$fresh_records = InviteCampaign::where('batch_number', trim(decrypt($batch)))->orderBy('id', 'desc')->get();
        return view('backend.auth.invites.viewFresh', compact('fresh_records'));
	}
	
	/* Pushpendra Singh [28-06-2024] */
	public function viewReminder($batch){
        $reminder_records = ReminderMailSend::where('batch_number', trim(decrypt($batch)))->orderBy('id', 'desc')->get();										
        return view('backend.auth.invites.viewReminder', compact('reminder_records'));
    }
	
	/* Pushpendra Singh [28-06-2024] */
	public function inviteReminder(request $request){
        $check_email_exist_or_not = InviteCampaign::where('batch_number',$request->batch_number)->where('email_sent',1)->get();
        $getLastRecordBasedOnBatchFromInviteCampaign = InviteCampaign::where('batch_number',$request->batch_number)->first();
        $checkVisited = 0;
        foreach($check_email_exist_or_not as $value){
            $subject = 'Start Earning with SJPanel - Sign-Up Today!';
            $recipients = [$value->email];

            $campaign_code = md5(uniqid(mt_rand(), true));
            $token = $campaign_code;
            $link = route('frontend.auth.register', ['token' => $campaign_code, 'is_campaign' => 1]);
            
            if($value->has_visited == 0){
                //MailHelper::sendBulkMail($value,$recipients,$subject,$link);
                Mail::to($value['email'])->send(new ReminderMail($value, $subject, $link, $token));
				
				/* save Reminder in reminder_mail_sends Table [28-06-2024] */
                $insertReminder = new ReminderMailSend();
                $insertReminder->reminder_count = $getLastRecordBasedOnBatchFromInviteCampaign->reminder_count + 1;
                $insertReminder->batch_number = $request->batch_number;
                $insertReminder->reminder_code = $campaign_code;
                $insertReminder->email = $value->email;
                $insertReminder->save();
                $checkVisited = 1;
                InviteCampaign::where('email',$value->email)->update(['reminder_code'=>$campaign_code]);
            }
        }
        if($checkVisited == 1){
            InviteCampaign::where('batch_number',$request->batch_number)->update(['reminder_count'=>$getLastRecordBasedOnBatchFromInviteCampaign->reminder_count + 1]);
			
			 return response()->json([
				'status'  => true,
				'message' => 'Reminder Email Sent Successfully'
			]);
        }
        return response()->json([
            'status'  => false,
            'message' => 'All panelist have visited the links.'
        ]);
    }
    public function downloadsampleCSV()
    {
        $data = [
            ['Email','First Name','Last Name','Phone Number'],
            ['johnss@gmail.com','John','Doe','700-211-2000'],
        ];

        $csvContent = '';
        foreach ($data as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="sample.csv"')
            ->header('Pragma','no-cache')
            ->header('Cache-Control','must-revalidate, post-check=0, pre-check=0')
            ->header('Pragma','no-cache')
            ->header('Expires','0');

    }
}

