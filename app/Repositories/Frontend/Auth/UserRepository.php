<?php

namespace App\Repositories\Frontend\Auth;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserRegistered;
use App\Models\Setting\Setting;
use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use App\Mail\Inpanel\Invite\UserInviteSignupMail;
use App\Mail\Inpanel\UserProject\SurveyAssaigned;
use App\Models\Affiliate\AffiliateCampaign;
use App\Models\Affiliate\AffiliateCampaignData;
use App\Models\Affiliate\AffiliateList;
use App\Models\Auth\UserUnsubscribe;
use App\Models\Country;
use App\Events\Frontend\Auth\UserUpdated;
use App\Models\CountryTrans;
use App\Models\Profiler\GlobalProfileQuestion;
use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Project\UserProject;
use App\Models\Referral\ReferralLink;
use App\Models\Referral\ReferralProgram;
use App\Models\Referral\ReferralRelationship;
use App\Models\StaticAchievement;
use Carbon\Carbon;
use App\Models\Auth\User;
use Illuminate\Http\UploadedFile;
use App\Models\Auth\SocialAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Frontend\Auth\UserProviderRegistered;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Inpanel\Traffic\TrafficStatuses;
use  App\Mail\Backend\RedeemApprove\ThresoldCompMail;
use App\Models\Notification\Notification;
use App\Models\UserPlatformAction;
use App\Helpers\FirebaseHelper;
use App\Models\mobileAPI\UserToken;



/**
 * This repository class is used for handling all the functionality related to the User like
 * registration, getting all the data of a user for export data,update basic profile details,confirming account .
 *
 * Class UserRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Frontend\Auth\UserRepository
 */

class UserRepository extends BaseRepository
{
    use TrafficStatuses;

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * This function is used for getting the user details by password reset token.
     *
     * @param $token
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function findByPasswordResetToken($token)
    {
        foreach (DB::table(config('auth.passwords.users.table'))->get() as $row) {
            if (password_verify($token, $row->token)) {
                return $this->getByColumn(sha1($row->email), 'email_hash');
            }
        }

        return false;
    }

    /**
     * This action is used for getting the User's Data by UUID.
     * @param $uuid
     *
     * @return mixed
     * @throws GeneralException if user not found.
     */
    public function findByUuid($uuid)
    {
        $user = $this->model
            ->uuid($uuid)
            ->first();

        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }

    /**
     * This action is used for getting the User's information by confirmation code
     *
     * @param $code
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findByConfirmationCode($code)
    {
       $model = $this->model;
        $user = $this->model
             ->where('confirmation_code', $code)
            ->first();
        if ($user instanceof $this->model) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.not_found'));
    }


    /**
     * This action is used for retrieve records added on current day
     *
     * @return mixed
     * @throws GeneralException
     */
    public function getRecordsCountForCurrentDay()
    {
        return DB::table('users')->whereDate('created_at', Carbon::today())->count();
        /*if ($user instanceof $this->model) {
            return $user;
        }*/
    }

    /**
     * Action for creating new row for the new user after register.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|mixed
     * @throws \Exception
     * @throws \Throwable
     */

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $RecordCnt = $this->getRecordsCountForCurrentDay();
            //print_r($RecordCnt);die;
            //$panId =  date('ymd').str_pad($RecordCnt+1, 4, "0", STR_PAD_LEFT); 
            if(strlen($RecordCnt)>=4 && $RecordCnt>=9999){
                $RCnt = $RecordCnt + 1;
                $panId = date('ymds').$RCnt;
            }else{
                $panId =  date('ymds').str_pad($RecordCnt+1, 4, "0", STR_PAD_LEFT); 
            }
           // print_r($panId);die;
            $data['panellist_id'] = $panId;
            
            $user = parent::create([
                'panellist_id'      => $data['panellist_id'],
                'first_name'        => $data['first_name'],
                'last_name'         => $data['last_name'],
                'middle_name'       => $data['middle_name'],
                'email'             => $data['email'],
                'email_hash'        => $data['email_hash'],
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'active'            => 1,
                'password'          => $data['password'],
                'dob'               => (!empty($data['dob']))?$data['dob']:null,
                'gender'            => (!empty($data['gender']))?$data['gender']:null,
                'country'           => $data['country'],
                'locale'            => (!empty($data['locale']))?$data['locale']:'en_US',
                'user_group'        => (!empty($data['user_group']))?$data['user_group']:1,
                'ip_registered_with'=> request()->ip(),
                'profile_updatetoken'=>0,
                // If users require approval or needs to confirm email
                'confirmed'         => config('access.users.requires_approval') || config('access.users.confirm_email') ? 0 : 1,
            ]);
            if ($user) {
                /*
                 * Add the default site role to the new user
                 */
                 /**modified by obhi**/
                 if (isset($data['email']) && !empty($data['email'])) {
                    // Split the email address by @
                    $emailParts = explode('@', $data['email']);
                    
                    
                    if (strtolower($emailParts[1]) === 'samplejunction.com') {
                            $user->assignRole(config('access.users.test_penalist_role'));
                        }else{
                            $user->assignRole(config('access.users.default_role'));
                        }                 
                }
                /**modified by obhi**/
                //$user->assignRole(config('access.users.default_role'));
                
            }
            /*
             * If users have to confirm their email and this is not a social account,
             * and the account does not require admin approval
             * send the confirmation email
             *
             * If this is a social account they are confirmed through the social provider by default
             */
            if (config('access.users.confirm_email')) {
                // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                $get_unsubscribe_details = $user->checkUnsubscribedEmail($user->email);
                if(!$get_unsubscribe_details){
                    
                    /**Query modified by RAS 08/01/24 */
                    $get_reffer_point = Setting::whereIn('key',['PANEL_SIGNUP_POINTS','PANEL_ACCOUNT_ACTIVATION_POINTS','PANEL_BASIC_PROFILE_POINTS'])->sum('value');
                
                    $email = new UserConfirmation($user,$user->confirmation_code,$get_reffer_point,0);
                    Mail::send($email);                    
                }
                /* $user->notify(new UserNeedsConfirmation($user->confirmation_code));*/
            }
            /*
             * Return the user object
             */
            return $user;
        });
    }

    /**
     * @param       $id
     * @param array $input
     * @param bool|UploadedFile  $image
     *
     * @return array|bool
     * @throws GeneralException
     */


    /*******************Need to recheck the method if it is in use or not***************************************/
    public function redirectClientLink($source)
    {
        return redirect()->to($source->c_link);
    }

    /**
     * This action for retrieving Invite Cookie during registration of new user.
     *
     * @return mixed
     */
    public function checkInviteCookieCode()
    {
        $code = \Cookie::get('SJ_SECURE_CHECK_CODE');
        return $code;
    }

    /**
     * This action for checking the Affiliate Data is present or not during the registration
     * of user from Promo Link.
     *
     * @return mixed
     */
    public function checkAffiliateCookie()
    {
        $data = \Cookie::get('affiliate_data');
        if($data && $data != '[]'){
            return $data;
        }
        return false;
    }

    /**
     * This action is used for creating Affiliate Campaign Data if the affiliate cookie is not found.
     *
     * @param $affiliate_data
     * @param $user
     * @return void
     */
    public function createAffiliateCampData($affiliate_data, $user)
    {
        // Ensure we have required values
        if (empty($affiliate_data->utm_source) || empty($affiliate_data->utm_campaign)) {
            return; // stop execution
        }
        $varsData = [];
        // Get source and campaign
        $source = $affiliate_data->utm_source;
        $campaign = $affiliate_data->utm_campaign;
        if (empty($affiliate_data->utm_source) || empty($affiliate_data->utm_campaign)) {
            return; // stop execution
        }
        $source_data = AffiliateList::where('code','=',$source)->first();
        if (empty($affiliate_data->utm_source) || empty($affiliate_data->utm_campaign)) {
            return; // stop execution
        }
        $aff_vars = explode(',', $source_data->aff_vars);
        foreach($aff_vars as $var){
            if(!empty($affiliate_data->$var)){

                $varsData[$var] = $affiliate_data->$var;
            }
        }
        // Fetch campaign data
        $campaign_data = AffiliateCampaign::where('name', '=', $campaign)->first();
        // Create campaign data
        $affiliate_campaign_data = [
            'user_id'   => $user->id,
            'aff_camp_id' => $campaign_data->id,
            'source_id'   => $source_data->id,
            'aff_vars'    => json_encode($varsData),
        ];

        AffiliateCampaignData::create($affiliate_campaign_data);
    }


    /**
     * This action for giving the User Invite Points ans saving the data
     * of invite points in user additional data of user who had referred
     *
     * @param $referral_link_id
     * @param $referred_user
     * @return bool
     */
    public function giveUserInvitePoints($referral_link_id,$referred_user,$refer_code,$method_type)
    {
        $referral_link = ReferralLink::where('id','=',$referral_link_id)->first();
        
        $referral_program_id = $referral_link->referral_program_id;
        $referral_program = ReferralProgram::where('id','=',$referral_program_id)->first();
        $user_id = $referral_link->user_id;
        $points = $referral_program->points;
        $code= $referral_program->code;
        $referred_user_uuid = $referred_user->uuid;
        $get_referral_user= User::where('id','=',$user_id)->first();
        if (!$get_referral_user) {
            \Log::error("Referral user not found for user_id: $user_id");
            return false;
        }
        // echo '<pre>';
        // print_r($referral_link->user_id); die();
        $user_add_data = UserAdditionalData::where('uuid', '=', $get_referral_user->uuid)->first();
        $fetch_user_achievement = $user_add_data->user_achievement;
        $achievement = [];
        if(!$fetch_user_achievement){
            $achievement['user_achievement'][] = [];
            UserAdditionalData::where('uuid','=',$get_referral_user->uuid)->push($achievement);
        }
        if(empty(array_column($fetch_user_achievement,"invite_achievement"))) {
            $points_data["code"] = $code;
            $points_data["points"] = $points;
            $points_data["referred_user_uuid"] = $referred_user_uuid;
            $points_data["referred_user_id"] = $referred_user->id;
            $points_data["status"] = "pending";
            $user_achievement['invite_achievement'][] = $points_data;
            $user_add_data->push("user_achievement", $user_achievement);
            event(new UserAchievementUpdate($get_referral_user));
            $this->updateReferralRelationship($referral_link_id, $referred_user,$refer_code,$method_type);


            // Added by RAS for notification on 01/09/23 $referred_user->first_name
            $orig_locale = app()->getLocale();
            app()->setLocale($this->model->find($referral_link->user_id)->locale);
            $msg = __('frontend.notification_txt.referral_rqst_registration_1'). $referred_user->first_name .__('frontend.notification_txt.referral_rqst_registration_2');

            // Code updated by Vikas for multi language notification(Starting 5/11/2025)
            $msg_keys = [
                'start' => 'frontend.notification_txt.referral_rqst_registration_1',
                'end'   => 'frontend.notification_txt.referral_rqst_registration_2'
            ];
            $jsonDynamicText = json_encode([
                                    'keys' => $msg_keys,
                                    'first_name' => $referred_user->first_name
                                ]);
            $notification_data = [
                'user_uuid' => $this->model->find($referral_link->user_id)->uuid,
                'notification_type' => 'Referral Request',
                'type_id' => $referral_link_id,
                'notification_text' => $jsonDynamicText,
                'new_notification_type' => 'Referral Status'
            ];
            Notification::create($notification_data);
            // Ending Vikas
            
            app()->setLocale($orig_locale);
            activity("user_achievements")
                ->causedBy($user_id)
                ->withProperties(['points'=>$points,'user_id'=>$referred_user->id])
                ->log('inpanel.activity_log.invite_points');
                $userToken = UserToken::where('user_id', $user_id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Refferal Bonus'
                    ]
                );
            }
            return true;
        }
        $achievements = array_column($fetch_user_achievement,"invite_achievement");
        $user_achieve_present_code =in_array($referred_user_uuid,array_column($achievements[0], 'referral_user_uuid'));
        if($user_achieve_present_code==false){
            $points_data["code"] = $code;
            $points_data["points"] = $points;
            $points_data["referred_user_uuid"] = $referred_user_uuid;
            $points_data["referred_user_id"] = $referred_user->id;
            $points_data["status"] = "pending";
            $data = [];
            foreach($user_add_data['user_achievement'] as $key=>$value){
                if(array_key_exists("invite_achievement",$value)){
                    foreach ($value as $profile_data){
                        $value['invite_achievement'][] = $points_data;
                    }
                }
                $data['user_achievement'][] = $value;
            }
            UserAdditionalData::where('uuid', '=', $get_referral_user->uuid)
                ->update($data);
            $this->updateReferralRelationship($referral_link_id, $referred_user,$refer_code,$method_type);

             // Added by RAS for notification on 01/09/23
             $orig_locale = app()->getLocale();
            app()->setLocale($this->model->find($referral_link->user_id)->locale);
             $msg = __('frontend.notification_txt.referral_rqst_registration_1'). $referred_user->first_name .__('frontend.notification_txt.referral_rqst_registration_2');
            
            // Code updated by Vikas for multi language notification(Starting 5/11/2025)
            $msg_keys = [
                'start' => 'frontend.notification_txt.referral_rqst_registration_1',
                'end'   => 'frontend.notification_txt.referral_rqst_registration_2'
            ];
            $jsonDynamicText = json_encode([
                                    'keys' => $msg_keys,
                                    'first_name' => $referred_user->first_name
                                ]);
             $notification_data = [
                'user_uuid' => $this->model->find($referral_link->user_id)->uuid,
                'notification_type' => 'Referral Request',
                'type_id' => $referral_link_id,
                'notification_text' => $jsonDynamicText,
                'new_notification_type'=>'Referral Status'

             ];
             Notification::create($notification_data);
            // Ending Vikas
             app()->setLocale($orig_locale);
            event(new UserAchievementUpdate($get_referral_user));
            activity("user_achievements")
                ->causedBy($user_id)
                ->withProperties(['points'=>$points,'user_id'=>$referred_user->id])
                ->log('inpanel.activity_log.invite_points');

                 $userToken = UserToken::where('user_id', $user_id)->value('device_token');

            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Refferal Bonus'
                    ]
                );
            }
            return true;
        }
    }

    /**
     * This action for giving the User Referral Points and saving the data
     * of Referral points in user additional data of user who had referred
     *
     * @param $referral_link_id
     * @param $referred_user
     * @return bool
     * Code add by Vikash Yadav (29-11-2022)
     */
    public function giveUserReferralPoints($referral_link_id,$referred_user,$refer_code,$method_type)
    {
        $referral_link = ReferralLink::where('id','=',$referral_link_id)->first();
        $referral_program_id = $referral_link->referral_program_id;
        $referral_program = ReferralProgram::where('id','=',$referral_program_id)->first();
        $referral_id = $referral_link->user_id;
        $points = $referral_program->points;
        $code= $referral_program->code;
        $referred_user_uuid = $referred_user->uuid;
        $referred_user_id = $referred_user->id;
        $get_referral_user= User::where('id','=',$referral_id)->first();
        if (!$get_referral_user) {
           // \Log::error("Referral user not found for user_id: $user_id");
            return false;
        }
        $user_add_data = UserAdditionalData::where('uuid', '=', $referred_user_uuid)->first();
        $fetch_user_achievement = $user_add_data->user_achievement;
        $achievement = [];
        if(!$fetch_user_achievement){
            $achievement['user_achievement'][] = [];
            UserAdditionalData::where('uuid','=',$referred_user_uuid)->push($achievement);
        }
        if(empty(array_column($fetch_user_achievement,"referral_achievement"))) {
            $points_data["code"]   = 'Referral';
            $points_data["points"] = $points;
            $points_data["referral_user_uuid"] = $get_referral_user->uuid;
            $points_data["referral_user_id"] = $get_referral_user->id;
            $points_data["status"] = "pending";
            $user_achievement['referral_achievement'][] = $points_data;
            $user_add_data->push("user_achievement", $user_achievement);
            event(new UserAchievementUpdate($referred_user));
            //$this->updateReferralRelationship($referral_link_id, $referred_user);

            //send email for referred user
            $referred_name = $referred_user->first_name.' '.$referred_user->last_name;
            $referred_first_name = $referred_user->first_name;
            $email = new UserInviteSignupMail($get_referral_user,$referred_name,$points,$referred_first_name);
            Mail::send($email); 

            activity("user_achievements")
                ->causedBy($referred_user_id)
                ->withProperties(['points'=>$points])
                ->log('inpanel.activity_log.referral_points');
            return true;
        }
        $achievements = array_column($fetch_user_achievement,"referral_achievement");
        $user_achieve_present_code =in_array($get_referral_user->uuid,array_column($achievements[0], 'referral_user_uuid'));
        if($user_achieve_present_code==false){
            $points_data["code"] = 'Referral';
            $points_data["points"] = $points;
            $points_data["referral_user_uuid"] = $get_referral_user->uuid;
            $points_data["referral_user_id"] = $get_referral_user->id;
            $points_data["status"] = "pending";
            $data = [];
            foreach($user_add_data['user_achievement'] as $key=>$value){
                if(array_key_exists("referral_achievement",$value)){
                    foreach ($value as $profile_data){
                        $value['referral_achievement'][] = $points_data;
                    }
                }
                $data['user_achievement'][] = $value;
            }
            UserAdditionalData::where('uuid', '=', $referred_user->uuid)
                ->update($data);
            //$this->updateReferralRelationship($referral_link_id, $referred_user);
            event(new UserAchievementUpdate($referred_user));

            //send email for referred user
            $referred_name = $referred_user->first_name.' '.$referred_user->last_name;
            $referred_first_name = $referred_user->first_name;
            $email = new UserInviteSignupMail($get_referral_user,$referred_name,$points,$referred_first_name);
            Mail::send($email); 
            
            activity("user_achievements")
                ->causedBy($referred_user_id)
                ->withProperties(['points'=>$points])
                ->log('inpanel.activity_log.referral_points');
            return true;
        }
    }


    /**
     * This action is used for updating Referral Relationship the referral accept the invite.
     *
     * @param $referral_link_id
     * @param $referred_user
     */
    private function updateReferralRelationship($referral_link_id,$referred_user,$ref_code,$ref_method)
    {


         $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
         $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');
		 
		 /* Parshant [04-10-2024] */
		 
		 $wheree = [['referral_link_id','=',$referral_link_id],['user_id','=',$referred_user->id],['ref_code','=',$REFER_CODE],['ref_method','=',$METHOD_TYPE]];
		 
		 $referralRelationship = ReferralRelationship::where($wheree)->first();
		 
		 //dd($referralRelationship->id);
		 
        /* $data = [


            'referral_link_id' => $referral_link_id,
            'user_id' => $referred_user->id,
            'ref_code' => $REFER_CODE,
            'ref_method' => $METHOD_TYPE,
            
        ];
        ReferralRelationship::create($data); */

		/* Parshant [08-10-2024] */
		 
		$wheree = [['referral_link_id','=',$referral_link_id],['user_id','=',$referred_user->id],['ref_code','=',$REFER_CODE],['ref_method','=',$METHOD_TYPE]];

		$referralRelationship = ReferralRelationship::where($wheree)->first();

		if(empty($referralRelationship->id)){

			$data = [
				'referral_link_id' => $referral_link_id,
				'user_id' => $referred_user->id,
				'ref_code' => $REFER_CODE,
				'ref_method' => $METHOD_TYPE,
				
			];
			ReferralRelationship::create($data);			
		}

		
		/* Parshant [08-10-2024] */		

    }

    /**
     * This action used for updating the User's Basic Profile Data and also updating it in user additional data.
     *
     * @param $id
     * @param array $input
     * @param bool $image
     * @return array
     */
    public function update($id, array $input, $image = false)
    {
        // echo '<pre>';print_r($id);die();
        $user = $this->getById($id);
		/*if (isset($input['dob'])) {
            $input['dob'] = Carbon::createFromFormat('m-d-Y', $input['dob'])->format('Y-m-d');
        }
        Don't need it any more as already added this in Basic Details and registration
        todo:need to figure out sync between registration and basic details
        */
        if(array_key_exists('two_fact_auth',$input) && $input['two_fact_auth']==0){
            $user->google2fa_secret = null;
            $user->save();
        }
        $updated = $user->update($input);
        
		event(new UserUpdated($user));
        return [
            'success' => $updated,
            'email_changed' => false,
        ];
        /*if ($user->canChangeEmail()) {
            //Address is not current address so they need to reconfirm
            if ($user->email != $input['email']) {
                //Emails have to be unique
                if ($this->getByColumn($input['email'], 'email')) {
                    throw new GeneralException(__('exceptions.frontend.auth.email_taken'));
                }

                // Force the user to re-verify his email address if config is set
                if (config('access.users.confirm_email')) {
                    $user->confirmation_code = md5(uniqid(mt_rand(), true));
                    $user->confirmed = 0;
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }
                $user->email = $input['email'];


                $return['email_changed'] = true;
                // Send the new confirmation e-mail

                return [
                    'success' => $updated,
                    'email_changed' => true,
                ];
            }
        }*/

    }

    /**
     * This action is used for updating the User's Password with the help of old Password.
     *
     * @param      $input
     * @param bool $expired
     *
     * @return bool
     * @throws GeneralException
     */
    public function updatePassword($input, $expired = false)
    {
        $user = $this->getById(auth()->id());

        if (Hash::check($input['old_password'], $user->password)) {
            if ($expired) {
                $user->password_changed_at = Carbon::now()->toDateTimeString();
            }

            return $user->update(['password' => $input['password']]);
        }

        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
    }

    /**
     * This action for Confirming the Account and giving Confirmation Points and adding it to the Activity Log
     *
     * @param $code
     *
     * @return bool
     * @throws GeneralException
     */
    public function confirm($code)
    {
        $user = $this->findByConfirmationCode($code);
        if ($user->confirmed == 1) {
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.already_confirmed'));
        }
        if ($user->confirmation_code == $code) {
            $user->confirmed = 1;
            $user->confirm_at = now();
            event(new UserConfirmed($user));
            activity()
                ->causedBy($user)
                ->log('inpanel.activity_log.user_confirm');
            // User has been successfully created or already exists

            auth()->login($user, true);
            event(new UserLoggedIn(auth()->user()));

            return  $user->save();
        }
        throw new GeneralException(__('exceptions.frontend.auth.confirmation.mismatch'));
    }
    /**
     * This action is used for creating the social login data of the User as the User successfully login his social account.
     *
     * @param $data
     * @param $provider
     *
     * @return mixed
     * @throws GeneralException
     */
    public function findOrCreateProvider($data, $provider)
    {

        // echo $data->getName();
       //  print_r($data->user['firstName']['preferredLocale']);
       // die;
        
        // User email may not provided.
         $user_email = $data->email ?: "{$data->id}@{$provider}.com";
        // echo $user_email;//= \Crypt::encrypt($user_email);
        // Check to see if there is a user with this email first.
        //exit;
          $user_email_hash=sha1(trim($user_email));
		  
         
         // exit;
        $user = $this->getByColumn($user_email_hash, 'email_hash');
        $geodata = geoip(request()->ip());
        
         $ipcountryCode = $geodata->getAttribute('iso_code');
         $country=$geodata->getAttribute('country');
        //  $x = [
        //     // 'panellist_id'  => $panId,
        //     // 'first_name'  => $nameParts['first_name'],
        //     // 'last_name'  => $nameParts['last_name'],
        //     'email' => $user_email,
        //     'social_email' => $user_email,
        //     'email_hash' => $user_email_hash,
        //     // 'active' => 1,
        //     // 'locale'=>'en_US',
        //     // 'confirmed' => 0,
        //     // 'password' => null,
        //     // 'locale'=>'en_US',
        //     // 'avatar_type' => $provider,
        //     // 'is_social' => 1,
        //     // 'country'=> $ipcountryCode,
        //     // 'country_code'=>$ipcountryCode,
        // ];
        // echo '<pre>';
        // print_r($x);die();
        /*
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (! $user) {
            // Registration is not enabled
            if (! config('access.registration')) {
                throw new GeneralException(__('exceptions.frontend.auth.registration_disabled'));
            }

            // Get users first name and last name from their full name
            $nameParts = $this->getNameParts($data->getName());
          
            $check_affiliate_cookie = $this->checkAffiliateCookie();
            if( !empty($check_affiliate_cookie) ) {
                $cookie_data = json_decode($check_affiliate_cookie);
                $this->createAffiliateCampData($cookie_data, $user);
            }
            $locale='';

            $RecordCnt = $this->getRecordsCountForCurrentDay();
            //$panId =  date('ymd').str_pad($RecordCnt+1, 4, "0", STR_PAD_LEFT); 
            if(strlen($RecordCnt)>=4 && $RecordCnt>=9999){
                $RCnt = $RecordCnt + 1;
                $panId = date('ymds').$RCnt;
            }else{
                $panId =  date('ymds').str_pad($RecordCnt+1, 4, "0", STR_PAD_LEFT); 
            }
            if($ipcountryCode=='US'){
                $locale="en_US";
            }
            if($ipcountryCode=='CA'){
                $locale="en_CA";
            }
            if($ipcountryCode=='UK' || $ipcountryCode=='GB'){
                $locale="en_UK";
                $ipcountryCode='UK';
            }
            $user = parent::create([
                'panellist_id'  => $panId,
                'first_name'  => $nameParts['first_name'],
                'last_name'  => $nameParts['last_name'],
                'email' => $user_email,
                'social_email' => $user_email,
                'email_hash' => $user_email_hash,
                'active' => 1,
                'locale'=>@$locale?@$locale:'en_US',
                'confirmed' => 0,
                'password' => null,
                'locale'=>$locale,
                'avatar_type' => $provider,
                'is_social' => 1,
                'country'=> $ipcountryCode,
                'country_code'=>$ipcountryCode,
            ]);
            if ($user) {
                    // /**modified by obhi**/
                    // if (isset($user_email) && !empty( $user_email)) {
                    //     // Split the email address by @
                    //     $emailParts = explode('@',$user_email);
                        
                    //     // Check if the array has two parts (username and domain)
                    //     if (count($emailParts) === 2) {
                    //         // Get the domain part and convert to lowercase
                    //         $domain = strtolower($emailParts[1]);
                            
                    //         // Check if the domain is in the array of allowed domains
                    //         $allowedDomains = ['samplejunction.com'];
                    //         if (in_array($domain, $allowedDomains)) {
                    //             // Assign a specific role to the user
                    //             $user->assignRole(config('access.users.test_penalist_role'));
                    //         }else{
                    //             $user->assignRole(config('access.users.default_role'));
                    //         }
                    //     }
                    // }
                    // /**modified by obhi**/
                $user->assignRole(config('access.users.default_role'));
            }
            event(new UserProviderRegistered($user));
            event(new UserConfirmed($user));
            activity()
                ->causedBy($user)
                ->log('inpanel.activity_log.user_confirm');
        }

        // See if the user has logged in with this social account before
        if (! $user->hasProvider($provider)) {
            // Gather the provider data for saving and associate it with the user
            // ghg
            $user->providers()->save(new SocialAccount([
                'provider'    => $provider,
                'provider_id' => $data->id,
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]));
        } else {
            // Update the users information, token and avatar can be updated.
            $user->providers()->update([
                'token'       => $data->token,
                'avatar'      => $data->avatar,
            ]);

            $user->avatar_type = $provider;
            $user->update();
        }
        \Log::info("here we are : " . $user->social_email);
        // Return the user object
        return $user;
    }

    /**
     * This action is used for Getting User First Name and last Name
     *
     * @param $fullName
     *
     * @return array
     */


    protected function getNameParts($fullName)
    {
        $parts = array_values(array_filter(explode(' ', $fullName)));
        $size = count($parts);
        $result = [];

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (! empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (! empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }

    /**
     * This action is used for soft delete the User Account
     * @return bool|null
     * @throws \Exception
     */
    public function deleteUser()
    {
        $user = $this->getById(auth()->id());

        return $user->delete();
    }

    /**
     * This action is used for Updating the Password.
     *
     * @param $input
     * @param bool $expired
     * @return bool
     * @throws GeneralException
     */
    public function updatePasswordWithoutOld($input, $expired = false)
    {
        $user = $this->getById(auth()->id());
        if ( ($input['old_password'] === $user->password)) {
            if ($expired) {
                $user->password_changed_at = Carbon::now()->toDateTimeString();
            }
            return $user->update(['password' => $input['password']]);
        }
        throw new GeneralException(__('exceptions.frontend.auth.password.change_mismatch'));
    }


    /**
     * This action is used for getting all the details of the User for exporting the User Data.
     *
     * @return array
     */
    public function getUseCompleteData($userid=null)
    {
        $exportData = array();
        if($userid){
            $user = $this->getById($userid);
        }else{
            $user = $this->getById(auth()->id());
        }
        
        $basicFields = $user->getUserBasicFields();
        $get_user_Add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        $user_answer = $get_user_Add_data->user_answers;
        $locale = Config::get('app.locale');
        $question_text = [];
        foreach($user_answer as $key=>$value){
            $profile_section_code = $value['profile_section_code'];
            $question_code= $value['profile_question_code'];
            
             if($profile_section_code=="HIDDEN"){
                continue;
            }
            if(is_array($value['selected_answer'])){
                $selectedAnswer = $value['selected_answer'];
            }else{
                $selectedAnswer = explode(" ",$value['selected_answer']); 
            }

            $question_text[] = $this->getQuestionText($profile_section_code,$question_code,$locale,$selectedAnswer);
        }
        $exportData['Basic Profile']= [];
        foreach($question_text  as $data){
            foreach ($data as $key=>$value){
                $basicFields[$key] = $value;
            }
        }
        foreach( $basicFields as $key => $value ){
            if($key == 'dob'){
                $exportData['Basic Profile'][$value] = Carbon::parse($user->$key)->format('m-d-Y');
            }/*else if ( $key == 'country' ){
                $exportData['Basic Profile'][$value] = Country::find($user->$key)->translate(app()->getLocale(), true)->name;
            }*/else{
                if($user->$key){
                    $exportData['Basic Profile'][$value] = $user->$key;
                }else{
                    $exportData['Basic Profile'][$key] = $value;
                }
            }

        }
        $exportData['Detailed Profile'] = [];
        /*Todo Details profile has to be added*/
        /* $userAnswers = UserAnswer::whereUserId($user->id)->with('question')->get();
         foreach ($userAnswers as $userAnswer) {
             $question = $userAnswer->question;

             $answer = DetailedProfileRepository::getAnswerforQuestion($question, $userAnswer->user_answer);

             $exportData['Detailed Profile'][$question->display_name] = $answer;
         }*/
        return $exportData;
    }

    /**
     * This action is used for getting the User Question Details with their Answers.
     *
     * @param $fullName
     *
     * @return array
     */

    private function getQuestionText($profile_section_code,$question_code,$locale,$selected_answer)
    {
        $locale =explode('_',$locale);
        $country = $locale[1];
        $language = $locale[0];
        $sectionProjection = ProfileSection::getProjectionArray($country, strtoupper($language));
        $questionsProjection = ProfilerQuestions::getProjectionArray($country,strtoupper($language));
        $profile = ProfileSection::where('general_name', '=', $profile_section_code)->project($sectionProjection)->first();
        if($profile_section_code!=="BASIC" && $profile_section_code!=="HIDDEN"){
            $profileQuestion = ProfilerQuestions::where('profile_section_code', '=',$profile_section_code)
                ->where('general_name','=',$question_code)
                ->project($questionsProjection)
                ->first();

               
            $profile->questions = $profileQuestion;            
            $question_data = [];
            if(!empty($profileQuestion->translated)){
                foreach($profileQuestion->translated as $question){
                    $question_text = $question['text'];
                    $answer_text = [];
                    foreach($question['answers'] as $key=>$value){
                        if(in_array($value['precode'],$selected_answer)){
                            $answer_text[] = $value['display_name'];
                        }
                    }

                    $question_data[$question_text] = implode('|',$answer_text);
                }
            }
            
           // print_r($question_data);die;
           
        }elseif($profile_section_code=="BASIC"&& $profile_section_code!=="HIDDEN") {
            $profileQuestion = GlobalProfileQuestion::where('general_name','=',$question_code)
                ->project($questionsProjection)
                ->first();
            $profile->questions = $profileQuestion;
            
            $question_data = [];
            if(!empty($profileQuestion->translated)){
                foreach($profileQuestion->translated as $question){
                    $question_text = $question['text'];
                    $answer_text = [];
                    if($question['answers']) {
                        foreach ($question['answers'] as $key => $value) {
                            if (in_array($value['precode'], $selected_answer)) {
                                $answer_text[] = $value['display_name'];
                            }
                        }
                    } else {
                        $answer_text = $selected_answer;
                    }
                    $question_data[$question_text] = implode('|',$answer_text);
                }
            }
           
        } else {
            $question_text = $question_code;
            $answer_text[] = $selected_answer;
            $question_data[$question_text] = implode('|',$selected_answer);
        }
      // print_r($question_data);//die;
        return $question_data;
    }



    /*****************Need to re-check and than remove this function as this function is no longer in use.*****************************************************/
    public function find_users_with_pending_additional_data()
    {
        $users = User::whereDoesntHave('additionalData')->get();
        return $users;
    }

    public function fillUserAdditionalData(User $user)
    {
        $country_id = $user->country;
        $country = Country::find($country_id);

        if($country->country_code == 'US'){
            $this->fillAdditionalDataForUS($user);
        }else if ($country->country_code == 'CA') {
            $this->fillAdditionalDataForCA($user);
        }else if ($country->country_code == 'UK') {
            $this->fillAdditionalDataForUK($user);
        }else if ($country->country_code == 'FR') {
            $this->fillAdditionalDataForFR($user);
        }

    }

    private function fillAdditionalDataForUS($user)
    {

        $fillables = [
            'STATE' => "state",
            'DMA' => "dma_code",
            'DMA_NAME' => "dma_name",
            'DIVISON' => "division",
            'REGION' => "region",
            'MASTER_ID' => 'id',
        ];

        $zipcode = $user->zipcode;
        $zipData = UsZipData::where('zip', '=', $zipcode)->first();
        if (empty($zipcode) || empty($zipData)) {
            return false;
        }

        $insertData = [];
        foreach ($fillables as $key => $column_name) {
            $insertData[] = [
                'user_id' => $user->id,
                'additional_data_key' => $key,
                'data_value' => (!empty($zipData->$column_name))?$zipData->$column_name:null,
                'country_code' => 'US',
            ];
        }
        UserAdditionalData::insert($insertData);
        return true;


    }

    private function fillAdditionalDataForCA($user)
    {

        $fillables = CAZipData::$quota_master_mapping;

        $zipcode = $user->zipcode;
        $fsa = substr($zipcode, 0, 3);
        $fsaData = CAZipData::where('postcode', '=', $fsa)->first();
        if (empty($fsa) || empty($fsaData)) {
            return false;
        }

        $insertData = [];
        foreach ($fillables as $key => $column_name) {
            $insertData[] = [
                'user_id' => $user->id,
                'additional_data_key' => $key,
                'data_value' => (!empty($fsaData->$column_name))?$fsaData->$column_name:null,
                'country_code' => 'CA',
            ];
        }
        UserAdditionalData::insert($insertData);
        return true;


    }

    private function fillAdditionalDataForFR($user)
    {
        $fillables = FrMasterTable::$quota_master_mapping;

        $zipcode = $user->zipcode;
        if(empty($zipcode)){
            return false;
        }

        /*$zipData = UkZipData::where('zip', '=', $zipcode)->first();
        if (empty($zipcode) || empty($zipData)) {
            return false;
        }*/

        $insertData = [];
        $action = 'communes';
        $parameters = '';

        $queryArray = [
            'codePostal' => $zipcode,
            'fields' => 'nom,code,departement,region',
            'format' => 'json',
            'geometry' => 'centre',
        ];
        $response = $this->executeAPIForFrancePostcode($action, $parameters, $queryArray);
        if( $response->getStatusCode() == 200 ){
            $postcodeDetail = json_decode($response->getBody()->getContents());
            if ( !empty($postcodeDetail) ) {
                $result = $postcodeDetail[0];
                $department = $result->departement->nom;
                $masterData = FrMasterTable::where('department', '=', $department)->first();
                $insertData = [];
                foreach ($fillables as $keyname => $attr) {
                    $insertData[] = [
                        'user_id' => $user->id,
                        'additional_data_key' => $keyname,
                        'data_value' => $masterData->$attr,
                        'country_code' => 'FR',
                    ];
                }
                UserAdditionalData::insert($insertData);
            }

            // json_last_error();
        }else{
            //dd('In Else',$response);
            return false;
        }
        return false;
    }

    private function fillAdditionalDataForUK($user)
    {
        $fillables = [
            'REGION' => "european_electoral_region",
            'COUNTY' => "nuts",
            //'MASTER_ID' => 'id',
        ];

        $zipcode = $user->zipcode;
        if(empty($zipcode)){
            return false;
        }

        /*$zipData = UkZipData::where('zip', '=', $zipcode)->first();
        if (empty($zipcode) || empty($zipData)) {
            return false;
        }*/

        $insertData = [];
        $action = 'postcodes';
        $parameters = $zipcode;
        $response = $this->executeAPIForPostcodesIO($action, $parameters);
        if( $response->getStatusCode() == 200 ){
            $postcodeDetail = json_decode($response->getBody()->getContents());
            if ($postcodeDetail->status == '200') {
                $result = $postcodeDetail->result;
                $insertData = [];
                foreach ($fillables as $keyname => $attr) {
                    $insertData[] = [
                        'user_id' => $user->id,
                        'additional_data_key' => $keyname,
                        'data_value' => $result->$attr,
                        'country_code' => 'UK',
                    ];
                }

                $zipdata = UkZipData::firstOrNew([
                    'county' => $result->nuts,
                    'region' => $result->european_electoral_region,
                ]);
                $zipdata->save();

                UserAdditionalData::insert($insertData);
            }

            // json_last_error();
        }else{
            //dd('In Else',$response);
            return false;
        }
        return false;
    }

    private function executeAPIForPostcodesIO($action, $parameters)
    {

        $client = new Client(['base_uri' => 'https://api.postcodes.io/']);
        try {
            $response = $client->request('GET', "$action" . "/" . "$parameters", [
                'query' => [],
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'X-Foo' => ['Bar', 'Baz']
                ],
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }
        return $response;
    }

    private function executeAPIForFrancePostcode($action, $parameters, $queryArray = [])
    {

        $client = new Client(['base_uri' => 'https://geo.api.gouv.fr/']);
        try {
            $response = $client->request('GET', "$action" . "/" . "$parameters", [
                'query' => $queryArray,
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'X-Foo' => ['Bar', 'Baz']
                ],
            ]);
        } catch (ServerException $e) {
            $response = $e->getResponse();
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            $response = $e->getResponse();
        }
        return $response;
    }


    /**
     * This action is used for getting User Points from the cookie saved in user's end.
     *
     * @param $user
     * @return mixed
     */
    public function getUserPoints($user)
    {
		return UserAdditionalData::select('user_points')->where('uuid','=',$user->uuid)
                ->first();
        //return Cache::remember('users.'.$user->id.'.points', now()->addDay(1) ,function () use ($user) {
            //return UserAdditionalData::select('user_points')->where('uuid','=',$user->uuid)
              //  ->first();
        //});
    }


    /**
     * This action is used for giving User the profile_photo_upload points and saving the data in user_additional_data.
     *
     * @param $user
     * @return bool
     */
    public function giveProfilePicUploadPoints($user)
    {
        // print_r($user);exit();
        $user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        // echo $user->uuid;exit;

        if(empty($user_add_data )){
            $newdata = [
                'uuid' => $user->uuid,
                'u_id' => $user->id,
                'user_answers' => [],
            ];
            $user_achivement_data['user_achievement'] = [];

            $create_add_data = UserAdditionalData::create($newdata);
            UserAdditionalData::where('uuid','=',$create_add_data->uuid)->push($user_achivement_data);
            return true;
        }
        /*Todo implement check for user_achievement*/
        $get_points_details = Setting::where('key', 'PANEL_PROFILE_IMAGE_POINTS')->first();
        $fetch_user_achievement = $user_add_data->user_achievement;
        // echo "<pre>";
        // print_r($fetch_user_achievement);exit();
        $user_achievement = [];
        $points_data = [];

        if (empty(array_column($fetch_user_achievement, "profile_pic_upload"))) {
            $points_data["code"] = 'profile_pic_upload';
            // print_r($fetch_user_achievement);exit();
            $points_data["points"] = $get_points_details->value; // Assuming the value is stored in the 'value' column
            $points_data["status"] = "completed";
            $user_achievement['profile_pic_upload'][] = $points_data;
            $user_add_data->push("user_achievement", $user_achievement);
            activity("user_achievements")
                    ->causedBy($user)
                    ->withProperties(['points'=>$get_points_details->value])
                    ->log('inpanel.activity_log.profile_pic_points');
            event(new UserAchievementUpdate($user));
            return true;
        }

    }

    /**
     * This action is used for updating the Tour Taken Data In UserAddData
     *
     * @param $user
     * @param $tour_section
     * @return bool
     */
    public function updateTourTaken($user,$tour_section)
    {
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        if(empty($get_user_add_data)){
            $newdata = [
                'uuid' => $user->uuid,
                'u_id' => $user->id,
                'user_answers' => [],
            ];
            $user_achivement_data['user_achievement'] = [];
            $create_add_data = UserAdditionalData::create($newdata);
            UserAdditionalData::where('uuid','=',$create_add_data->uuid)->push($user_achivement_data);
            return true;
        }
        $fetch_user_tour = $get_user_add_data->user_tour_taken;
        $user_tour = [];
        $tour_data = [];
        if(empty($fetch_user_tour)) {
            $tour_data["section"] = $tour_section;
            $tour_data["taken"] = true;
            $get_user_add_data->push('user_tour_taken',$tour_data);
            return true;
        }
        $data = [];
        $tour_data["section"] = $tour_section;
        $tour_data["taken"] = true;
        UserAdditionalData::where('uuid', '=', $user->uuid)
            ->push('user_tour_taken',$tour_data);
        return true;
    }

    /**
     * This action is used for getting User Assign Project.
     *
     * @param $user
     * @return mixed
     */
	 
    public function getUserAssignProject($user)
    {
        $user = auth()->user();
        $userRole = $user->roles->pluck('name')->toArray();
        $getLang = explode('_', $user->locale);
   
        if ($userRole[0] != 'panelist') {
            $query = DB::table('user_projects as up')
                ->join('projects as p', 'up.project_id', '=', 'p.id')
                ->select('up.*', 'p.survey_name', 'p.apace_project_code', 'p.loi', 'p.cpi', 'p.ir', 'p.id as pid')
                ->where('p.survey_status_code', '=', 'LIVE')
                ->where('p.study_type_id','=',12)
                ->where('up.status', '=', null)
                ->where('up.user_id', '=', $user->id)
                ->where('p.country_code', '=', $getLang[1])
                ->where('p.language_code', '=', strtoupper($getLang[0]));
        } else {
            $query = DB::table('user_projects as up')
                ->join('projects as p', 'up.project_id', '=', 'p.id')
                ->select('up.*', 'p.survey_name', 'p.apace_project_code', 'p.loi', 'p.cpi', 'p.ir', 'p.id as pid')
                ->where('p.survey_status_code', '=', 'LIVE')
                ->where('p.study_type_id','!=',12)
                ->where('up.status', '=', null)
                ->where('up.user_id', '=', $user->id)
                ->where('p.country_code', '=', $getLang[1])
                ->where('p.language_code', '=', strtoupper($getLang[0]));
        }
 
        $irProjects = (clone $query)
            ->orderBy('p.ir','desc')
            ->limit(6)
            ->get();
        $cpiProjects = (clone $query)
            ->whereNotIn('p.id', $irProjects->pluck('pid'))
            ->orderBy('p.cpi','desc')
            ->limit(6)
            ->get();
        $projects = $irProjects->merge($cpiProjects);
       
        return $projects;
    }
    /**
     * This action is used for getting User Assign Project Count.
     *
     * @param $user
     * @return mixed
     */
    public function getUserAssignProjectCount($user)
    {
        //$getLang = explode('_', $user->locale);
        $project = UserProject::where('user_id','=',$user->id)
                                ->get();
        

              

        // echo "<pre>";
        // print_r($project->count());exit();
        return $project;
    }


    /**
     * This action for getting All the complete Mark Project
     *
     * @param $user
     * @return mixed
     */
    public function getUserCompletedProject($user)
    {
        $project = UserProject::where('user_id','=',$user->id)
            ->where('status','=',$this->getCompleteStatus())
            ->get();
        return $project;
    }

    public function getUserAttemptedProject($user)
    {
        $project = UserProject::where('user_id','=',$user->id)
            ->whereNotNull('status')
            ->get();
        return $project;
    }
    /**
     * This action is used for getting all the active surveys of the User
     *
     * @param $user
     * @return mixed
     */
    public function getUserActiveSurveys($user)
    {

        // $user_project_count = DB::table('user_projects as up')
        //     ->join('projects as p', 'up.project_id', '=', 'p.id')
        //     ->select('up.*','p.survey_name','p.apace_project_code','p.loi')
        //     ->where('p.survey_status_code', '=', 'LIVE')
        //     ->where('up.user_id', '=', $user->id)
        //     ->where('up.status', '=', null)
        //     ->where('up.created_at', '>', now()->subDay()) // Check for projects created within the last day
        //     ->get();

        // if (count($user_project_count) > 0) {
        //     $email = new SurveyAssaigned($user, $user_project_count);
        //     Mail::send($email);
        // }
 //         echo "<pre>"
 // print_r($user_project_count->count());exit();
 
 /* Parshant [27-09-2024] Start */
  
	$userAuth = auth()->user();

	$getLang = explode('_',$userAuth->locale);

 /* Parshant [27-09-2024] Start */

        $project = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->select('up.*','p.survey_name','p.loi','p.apace_project_code','p.code')
            ->where('p.survey_status_code', '=', 'LIVE')
            ->where('up.user_id','=',$user->id)
            ->where('up.status','=',null)
			->where('p.language_code', '=', strtoupper($getLang[0]))
            // ->where(function ($query){
            //     $query->where('up.status','=',null)
            //         ->orWhere('up.status','=',$this->getStartedStatus());
            // })
            ->get();
        return $project;
    }

    /**
     * This action is used for getting all the Expired surveys of the User
     *
     * @param $user
     * @return mixed
     */
    public function getUserExpireSurveys($user)
    {
        $project = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->select('up.*','p.survey_name','p.loi','p.apace_project_code','p.survey_status_code')
            ->wherein('p.survey_status_code',  ['CLOSED','PAUSE'])            
            ->where('up.user_id','=',$user->id)
            ->where('up.status','=',null)
            ->get();
        return $project;
    }


    /******************Have to update the email unsubscribe*****************************************/
    public function emailUnsubscribe($insertdata)
    {
        // $data = [
        //     'email' => $email_id,
        // ];
  
        $create_unsubscribe = UserUnsubscribe::updateOrCreate($insertdata);
        return $create_unsubscribe;
    }


    public function getUserDetails($user_id)
    {
        $user = User::where('id','=',$user_id)
            ->first();
        return $user;
    }

    /**
     * Action for getting details of User By email id
     * @param $email_id
     * @return mixed
     */
    public function getUserDetailsByEmail($email_id)
    {
        // $data = User::where('email', '=', $email_id)->first();
        // return $data;
        $data = User::where('email_hash', '=', sha1($email_id))->first();
        return $data;
    }

    /**
     * Action for update of User Unsubscribe column in User's Table
     * @param $user_id
     * @return mixed
     */
    public function updateUserTableData($user_id)
    {
        $update = User::where('id','=',$user_id)->update(['unsubscribed' => 1]);
        return $update;
    }

    /**
     * Action for getting the User's Answers from User Additional Data
     * @param $userIdsArray
     * @return mixed
     */

    public function getUserAnswersByUserIds($userIdsArray)
    {
        $userAnswers = UserAdditionalData::whereIn('uuid', $userIdsArray)->project([
            'uuid' => true,
            'u_id' => true,
            'user_answers' => true,

        ])->get();
        return $userAnswers;
    }

    public function getCountry($country_code)
    {
        $lang = [];
        $country_data = CountryTrans::where('country_code','=',$country_code)->first();
        if($country_data){
            $con_lang = array_column($country_data['translation'], 'con-lang');
            foreach ($country_data['translation'] as $trans){
                $lang_data = explode('-', $trans['con-lang']);
                $lang[$lang_data[1]] = $trans['language_name'];
            }
        }
        return $lang;
    }

    public function checkEmail($email)
    {
        $data = User::where('email', '=', $email)->whereNull('deleted_at')->count();  
        return $data;
    }

    public function thresoldAlert()  {
        return false;
            $users = User::with(['roles' => function ($q) {
                $q->where('role_id', 4);
            }], 'permissions', 'providers')
            ->where('active', 1)
            ->where('confirmed', 1)
            ->get();   

            foreach ($users as $user) {
            $userPoints = UserAdditionalData::where('uuid', $user->uuid)->first();
            $getThresholdValue = Setting::where('key', 'PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->first();
            
            $mailSend = [
                    'amarjitm@samplejunction.com',
                    'rameshk@samplejunction.com',
                    'rohinic@samplejunction.com'
            ];
            
            if ($userPoints && $getThresholdValue) {
                $userPointsValue = $userPoints->user_points['completed'];
                $thresholdValue = $getThresholdValue->value;
            
                if ($userPointsValue >= $thresholdValue) {
                    foreach ($mailSend as $emailAddress) {
                        $email = new ThresoldCompMail($user, $userPointsValue, $emailAddress);
                        Mail::send($email);
                        \Log::info('Mail sent successfully to email: '.$emailAddress);
                    }
                }
            }
        }
    }
    
    // Platform Tracking code added by Vikas(Code Starting)
    public function storePlatForm($userUuid,$platform,$actionType,$actionId = null){
        return UserPlatformAction::updateOrCreate(
            [
                'user_uuid'   => $userUuid,
                'action_type' => $actionType,
                'action_id'   => $actionId,
            ],
            [
                'platform'    => $platform,
                'action_time' => now(),
            ]
        );
    }
    // Platform Tracking (Code Ending)
}
