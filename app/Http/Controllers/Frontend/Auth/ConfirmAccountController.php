<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use App\Mail\Frontend\UserConfirm\WelcomeMail;
use App\Mail\Frontend\UserConfirm\NotificationMail;
use App\Mail\Frontend\UserConfirm\ProfilePromptMail;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Auth\User;
use Carbon\Carbon;
use App\Helpers\Auth\Auth;
use App\Helpers\MailHelper;
use Illuminate\Http\Request;
use App\Models\Project\expenseRecord;
use App\Models\Auth\UserUnsubscribe;
use App\Models\Affiliate\AffiliateCampaignData;
/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ConfirmAccountController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param $token
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    
     public function confirm(Request $request, $token)
     {
        $recipients = ['amarjitm@samplejunction.com','rameshk@samplejunction.com','rajann@samplejunction.com'];
         $data = [];
         if($this->user->confirm($token)){
            //Code Added By ramesh for Affiliate Campaign//
            $check_affiliate_cookie = $this->user->checkAffiliateCookie();
            //End Here//
            // $val1 = Setting::where('key', '=', 'PANEL_AUTOMOTIVE_POINTS')->first();
            // $point1_val = (int)$val1->value;
            // $val2 = Setting::where('key', '=', 'PANEL_MY_PROFILE_POINTS')->first();
            // $point2_val = (int)$val2->value;
            // $val3 = Setting::where('key', '=', 'PANEL_BASIC_PROFILE_POINTS')->first();
            // $point3_val = (int)$val3->value;
            // $val4 = Setting::where('key', '=', 'PANEL_EMPLOYMENT_POINTS')->first();
            // $point4_val = (int)$val4->value;
            // $val5 = Setting::where('key', '=', 'PANEL_FAMILY_POINTS')->first();
            // $point5_val = (int)$val5->value;
            // $val6 = Setting::where('key', '=', 'PANEL_HEALTH_FOOD_POINTS')->first();
            // $point6_val = (int)$val6->value;
            // $val7 = Setting::where('key', '=', 'PANEL_TECHNOLOGY_POINTS')->first();
            // $point7_val = (int)$val7->value;
            // $val8 = Setting::where('key', '=', 'PANEL_TRAVEL_LEISURE_POINTS')->first();
            // $point8_val = (int)$val8->value;
            $ref_points = Setting::whereIn('key',['PANEL_AUTOMOTIVE_POINTS','PANEL_MY_PROFILE_POINTS','PANEL_BASIC_PROFILE_POINTS',
            'PANEL_EMPLOYMENT_POINTS','PANEL_FAMILY_POINTS','PANEL_HEALTH_FOOD_POINTS','PANEL_TECHNOLOGY_POINTS','PANEL_TRAVEL_LEISURE_POINTS'])->sum('value');

             
            // $point1_val + $point2_val + $point3_val + $point4_val + $point5_val  + $point6_val + $point7 +$point8_val;


            // $point1 = Setting::where('key', '=', 'PANEL_SIGNUP_POINTS')->first();
            // $point1_value = (int)$point1->value;
            // $point2 = Setting::where('key', '=', 'PANEL_ACCOUNT_ACTIVATION_POINTS')->first();
            // $point2_value = (int)$point2->value;
            // $point3 = Setting::where('key', '=', 'PANEL_BASIC_PROFILE_POINTS')->first();
            // $point3_value = (int)$point3->value;

            // $get_reffer_point = $point1_value + $point2_value + $point3_value;
    /** NEED TO ADD POINTS FOR CAMPAIGN IN WELCOME MAIL */
            if($request->is_campaign == 1){
                $get_reffer_point = Setting::whereIn('key',['PANEL_SIGNUP_POINTS','PANEL_ACCOUNT_ACTIVATION_POINTS','PANEL_BASIC_PROFILE_POINTS','PANEL_CAMPAIGN_INCENTIVE'])->sum('value');


               // Add by obhi
                $incentivePoint = Setting::where('key', 'PANEL_CAMPAIGN_INCENTIVE')->value('value');

                // Get the currently authenticated user
                $user = auth()->user();

                // Prepare the data to be inserted
                $incentiveData = [
                    'user_id' => $user->id,
                    'source' => 'Email Invitation',
                    'type' => 'Camp_Invt_NW_JN',
                    'point' => $incentivePoint
                ];

                // Insert the record into the expenseRecord table
                $expenseInsert = expenseRecord::create($incentiveData);

                // Check if the insertion was successful
                if ($expenseInsert) {
                    \Log::info('Successfully inserted incentive record');
                } else {
                    \Log::info('Failed to insert incentive record');
                }
                // End
                

            }else{
                $get_reffer_point = Setting::whereIn('key',['PANEL_SIGNUP_POINTS','PANEL_ACCOUNT_ACTIVATION_POINTS','PANEL_BASIC_PROFILE_POINTS'])->sum('value');
            } 
            // Return to the intended url or default to the class property
             $email = new WelcomeMail(auth()->user(),$get_reffer_point,$ref_points);
             // $promptMail = new ProfilePromptMail(auth()->user());
             MailHelper::sendCustomMail(auth()->user(),$recipients,'New registration alert',$data,$get_reffer_point,$ref_points);
             // $notification_email = new NotificationMail(auth()->user());
             Mail::send($email);
             // Mail::to(auth()->user()->email)->send($promptMail);
             // Mail::to($recipients)->send($notification_email);
  
             session()->put('last_active', time());
            
             if($request->is_social == 1){
                 session()->put('is_social', '1');
             }
             // $v = (route(home_route()));
            
             // echo '<pre>';
             // print_r($v);die();
             if(!empty($check_affiliate_cookie) ) {

                $user=auth()->user();
                $cookie_data = json_decode($check_affiliate_cookie);
                $source = $cookie_data->utm_source;
                $campaign = $cookie_data->utm_campaign;
                $cid=isset($cookie_data->cid) ? $cookie_data->cid : '';
                $varsData['aff_sub1']=isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
                $varsData['cid']=isset($cookie_data->cid) ? $cookie_data->cid : '';
                $varsData['utm_source']=$cookie_data->utm_source;
                $affiliate_campaign_data = [
                'user_id' => $user->id,
                'aff_camp_id' => 2,
                'source_id' => 1,
                'medium'=>$cookie_data->utm_source,
                'aff_vars' => json_encode($varsData),
            ];


            AffiliateCampaignData::create($affiliate_campaign_data);
            if($source=='PANT')
            {
                
                        $PostBackURl='https://www.bigcattracks.com/aff_lsr?adv_sub='.$user->panellist_id.'&transaction_id='.$cookie_data->cid.'&security_token=2ca8400b0bcbe8bb738ddc578995d04c';


                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(

                    array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars

                );
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }
            if($source=='NEGM'){
                $geodata = geoip(request()->ip());
                $ipcountryCode = $geodata->getAttribute('iso_code');
                if($ipcountryCode=='US'){
                  $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFV?transaction_id='.$cookie_data->cid;  
                }else if($ipcountryCode=='CA'){
                    $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFW?transaction_id='.$cookie_data->cid;  
                }else{
                    $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFK?transaction_id='.$cookie_data->cid;  

                
                }
                

                $geodata = geoip(request()->ip());
                $ipcountryCode = $geodata->getAttribute('iso_code');
                if($ipcountryCode=='US'){
                  $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFV?transaction_id='.$cookie_data->cid;  
                }else if($ipcountryCode=='CA'){
                    $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFW?transaction_id='.$cookie_data->cid;  
                }else{
                    $PostBackURl='http://negmediaconsulting.go2cloud.org/SPFK?transaction_id='.$cookie_data->cid;  

                
                }

                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(

                    array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars

                );
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }

            if($source=='LESC'){
                
                $PostBackURl='http://gao.go2cloud.org/SP2YU?transaction_id='.$cookie_data->cid;
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(

                    array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars );
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }

			if($source=='PAPL'){
               
                $PostBackURl='https://panelsights.o18.link/p?m=16447&tid='.$cookie_data->cid;
                        $this->sendIndirectHit($PostBackURl);

               $PostbackIndiaURL='https://postback.blog/acquisition?clickid='.$cookie_data->cid.'&event=regiydsbn&security_token=z6zpiku5i09xlv5e7c';
               $this->sendIndirectHit($PostbackIndiaURL);


                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(

                    array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars );
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }

            if($source=='MONE'){
                
                //$PostBackURl='https://monetisetrk.co.uk/p.ashx?a=1285&e=1507&f=pb&r='.$cookie_data->utm_campaign.'&t='.$cookie_data->cid;
				$PostBackURl='https://monetisetrk.co.uk/p.ashx?a=1285&e=1507&f=pb&r='.$cookie_data->cid;
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);

            			
            }
             if($source=='ANTK'){
                
                //$PostBackURl='https://monetisetrk.co.uk/p.ashx?a=1285&e=1507&f=pb&r='.$cookie_data->utm_campaign.'&t='.$cookie_data->cid;
                $PostBackURl='https://in.o18.click/p?m=1612&auth_token=09b245786e&tid='.$cookie_data->cid;
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            } 
            if($source=='PFMS'){
                
               
                $PostBackURl='https://postback.proformics.com/acquisition?click_id='.$cookie_data->cid.'&security_token=fb57d08eb1564510022f';
                //$PostBackURl='https://proformics.vnative.net/click?campaign_id=1591219&pub_id=64&p1='.$cookie_data->cid.'&gaid=232&idfa=23&app_name=PANEL_FAMILY_POINTS&app_id=333&source=SJPANEL';
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);

            } 
            if($source=='PSOS'){
                $PostBackURl='https://offers-gungho.affise.com/postback?clickid='.$cookie_data->cid.'&secure=538031aaa8328edb9cbc90fa096eeb3c';
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }
            if($source=='FRKM'){
                $PostBackURl='https://postback.woost.io/acquisition?click_id='.$cookie_data->cid.'&security_token=546c8f4ccb6b1731fc73';
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }
            if($source=='LFDM'){
                $PostBackURl='https://xyzmedia.online/publisher/secure-postback/admin_postback.php?token=dR8lsghhsV6yT0bdvsfshhsZ7jB2KxdbhshsE4nQw3uA5pH9sGbshhssbs&event=Registration&tid='.$cookie_data->cid;
                        $this->sendIndirectHit($PostBackURl);
                        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);
            }
            if($source=='DSCN'){
				
					$geodata = geoip(request()->ip());
					$ipcountryCode = $geodata->getAttribute('iso_code');
					
					if($ipcountryCode=='US'){
						$PostBackURl='https://glp8.net/t/?ci=19565&ti='.$cookie_data->cid.'&dci='.$cookie_data->cid;
					}else if($ipcountryCode=='CA'){
						$PostBackURl='https://glp8.net/t/?ci=20268&ti='.$cookie_data->cid.'&dci='.$cookie_data->cid;
					}else{
						$PostBackURl='https://glp8.net/t/?ci=20267&ti='.$cookie_data->cid.'&dci='.$cookie_data->cid;
					}	

					$this->sendIndirectHit($PostBackURl);
					$aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                    ->with('affiliate', 'campaign')
                    ->first();
                    $aff_vars = json_decode($aff_camp_data->aff_vars, true);
                    $aff_vars = array_combine(array_map(function($key){ return '{'.$key.'}'; }, array_keys($aff_vars)),$aff_vars);
                        $endUrl = $aff_camp_data->affiliate->c_link;
                        $finalUrl = strtr($endUrl, $aff_vars);
                        $this->backgroundVendorUrlHit($finalUrl);
                        AffiliateCampaignData::where('id','=',$aff_camp_data->id)->update(['status'=>'sent']);

            }				

			
            //Need to send the S2S Request at Samppoints//
            //$finalUrl='https://test17.samppoint.com/end?sjid='.$cookie_data->aff_sub1.'&status=1';
            //return redirect()->to($finalUrl);
            //End Here//
                return redirect()->intended(route(home_route()))->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
            }else{

                 if ($request->is_mobileLink == 1) {

                    return redirect()->route('frontend.auth.moblieConfirmationView')/* ->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success')) */;
                }else{
                    return redirect()->intended(route(home_route()))->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
                }
             //return redirect()->intended(route(home_route()))->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
            }
            
            
         }
         return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.success'));
     }
protected function sendIndirectHit($vendorurl){
        //$curl = curl_init($vendorurl);
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //$panellist_id = curl_exec($curl);
        //curl_close($curl);
        \Log::info('S2S Start Of PANT'.json_encode($vendorurl));
        $cmd = "curl -X GET -H 'Content-Type: text/html'";
        $cmd.= " -d '' " . "'" . $vendorurl . "'";
        $cmd .= " > /dev/null 2>&1 &";
        exec($cmd, $output, $exit);
        $data = ['cmd' => $cmd, 'output' => $output, 'exit' => $exit.date('Y-m-d'),"date"=>date('Y-m-d')];
        file_put_contents( __DIR__.DIRECTORY_SEPARATOR.'S2SbackgroundVendorUrlHit.txt', print_r($data, true), FILE_APPEND);
        \Log::info('S2S END Of PANT'.json_encode($vendorurl));
        return $exit == 0;
         file_put_contents( __DIR__.DIRECTORY_SEPARATOR.'S2SbackgroundVendorUrlHit.txt', print_r($panellist_id, true), FILE_APPEND);
    }
public function backgroundVendorUrlHit($vendorurl){
        $cmd = "curl -X GET -H 'Content-Type: text/html'";
        $cmd.= " -d '' " . "'" . $vendorurl . "'";
        $cmd .= " > /dev/null 2>&1 &";
        exec($cmd, $output, $exit);
        $data = ['cmd' => $cmd, 'output' => $output, 'exit' => $exit.date('Y-m-d'),"date"=>date('Y-m-d')];
        file_put_contents( __DIR__.DIRECTORY_SEPARATOR.'S2SbackgroundVendorUrlHit.txt', print_r($data, true), FILE_APPEND);
        return $exit == 0;
    }
    /**
     * @param $uuid
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function sendConfirmationEmail($uuid)
    {
        $user = $this->user->findByUuid($uuid);
        if ($user->isConfirmed()) {
            return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }

        $user->notify(new UserNeedsConfirmation($user->confirmation_code));

        return redirect()->route('frontend.auth.login')->withFlashSuccess(__('exceptions.frontend.auth.confirmation.resent'));
    }

    /**
     * @param $token
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function confirmdelete($token)
    {
        //print_r('account deactivate');die;
        $usersdetails = $this->user->findByConfirmationCode($token);
        /*echo'<pre>';
        print_r($usersdetails);die;*/
        if ($usersdetails->isActive()) {
            /*$user = UserAdditionalData::where('uuid','=',$usersdetails->uuid)->first();
            echo "<pre>";print_r($usersdetails);echo $usersdetails->uuid;die;
            $user->delete();*/
            $users = $this->user->getById($usersdetails->id);
            $user  = $users->toArray();
            $userdata   = $user;
            //$users->delete();
            $users->active=0;
            $users->deactivate_at = now();
            $users->save();
            
            $address    = config('mail.from.donotreply_address');
            $name       = config('mail.from.name');

            
            Mail::send('frontend.mail.welcome_delete_mail', $user, function($message) use ($user,$userdata, $address, $name) {
                $message->to($userdata['email'], $userdata['first_name'])->subject(__('exceptions.frontend.auth.confirmation.deletewelcome'));
                $message->from($address, $name);
            });

            auth()->logout(); 
            return redirect()->route('frontend.index')->withFlashSuccess(__('frontend.messages.deactivate_account'));
        }else{
            return redirect()->route('frontend.index')->withErrors(__('frontend.messages.deactivate_error')); 
        }

        
    }

    public function userinfoconfirmdelete($token)
    {
      //  print_r($token);die;
        $usersdetails = $this->user->findByConfirmationCode($token);
       
        if ($usersdetails->isActive()) {
            $user = UserAdditionalData::where('uuid','=',$usersdetails->uuid)->first();
            $ans = [];
            foreach($user->user_answers as $answers){
                if($answers['profile_section_code']=='HIDDEN' || $answers['profile_section_code']=='BASIC'){
                    $ans[] = $answers;
                }
            }

             
            $user->user_answers = $ans;
            $user->user_filled_profiles = [];
            $user->save();

            $users = $this->user->getById($usersdetails->id);
            $user  = $users->toArray();
            $userdata   = $user;
            
            /**
             * Update blank fileds of users tables
             */
            $update_data = array(
                "email"        => "",
                "password"     =>  "",
                "first_name"   => "",
                "middle_name"  => "",
                "last_name"    => "",
                "gender"       => "",
                "dob"          => NULL,
                "zipcode"      => "",
                "locale"       => "",
                "country"      => NULL,
                "country_code" => NULL,
                "fb"           => NULL,
                "twitter"      => NULL,
                "linkdin"      => NULL,
                "deleted_at"   => now()
            );
            User::where('id',$userdata['id'])->update($update_data);
            
            $address    = config('mail.from.privacy_address');
            $name       = config('mail.from.name');

            
            Mail::send('frontend.mail.userinfo_delete_mail', $user, function($message) use ($user,$userdata, $address, $name) {
                $message->to($userdata['email'], $userdata['first_name'])->subject(__('exceptions.frontend.auth.confirmation.userinfodeletewelcome'));
                $message->from($address, $name);
             });

           // return redirect()->route('inpanel.dashboard')->withFlashSuccess(__('Personal Info Deletion Successfully Done!'));
           return redirect()->route('frontend.index')->withFlashSuccess(__('frontend.messages.delete_account_info'));
        }

        
    }
    public function userDeactivate(Request $request) {
        $email = $request->email;
        $hashed_email = hash('sha1', $email);
    
        $user = User::where('email_hash', $hashed_email)->first();
    
        if (empty($user)) {
            return response()->json(['error' => 'User not found for email: ' . $hashed_email], 404);
        } else {
            $reason = 'Unsubscribe from SJ Panel'; 
            UserUnsubscribe::create([
                'email' => $email,
                'reason' => $reason,
            ]);
    
            $user->deactivate_at = Carbon::now();
            $user->active = 0; 
            $user->save();
    
            $response = ['message' => 'User deactivated successfully'];
            return response()->json($response, 200);
        }
    }
    

    public function welcome_dashboard($id){
        $user = User::find($id);
        if($user) {
            Auth()->login($user, true);
            return redirect()->route('inpanel.dashboard');
        } 
    }

// user deactivate with reason
    public function userDeactivateReason(Request $request)
    {
        $email = $request->email;
        $reason = $request->reason;
        $hashed_email = hash('sha1', $email);

        $user = User::where('email_hash', $hashed_email)->first();
        if (empty($user)) {
            return response()->json(['error' => 'User not found for email: ' . $hashed_email], 404);
        } else {
            UserUnsubscribe::create([
                'email' => $email,
                'reason' => $reason,
            ]);
            $user->deactivate_at = Carbon::now();
            $user->active = 0;
            $user->unsubscribed = 1;
            $user->save();

            $response = ['message' => __('inpanel.user.profile.preferences.preferences_menu.unsubscribe_email_success')];
            return response()->json($response, 200);
        }
    }

}
