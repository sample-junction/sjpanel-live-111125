<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 07-08-2018
 * Time: 07:14 PM
 */

namespace App\Repositories\Inpanel\ReferralProgram;

use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Referral\ReferralLink;
use App\Models\Referral\ReferralProgram;
use App\Models\Referral\ReferralRelationship;
use App\Models\Setting\Setting as settings;
use function GuzzleHttp\Promise\queue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inpanel\Invite\UserInviteSurveyComplete;

/**
 * This repository is used for handling all the functionality of Invite Part.
 *
 * Class ReferralProgramRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\ReferralProgram\ReferralProgramRepository
 */
class ReferralProgramRepository
{

    /**
     * This action for getting User Referral Link for sending Invite.
     *
     * @param $user
     * @return mixed
     */
    public function getUserReferralLink($user)
    {
        $program = $this->getDefaultProgram();
        
        $link = ReferralLink::getReferral($user, $program);
        // echo '<pre>';
        // print_r($link);die();
        return $link;
    }

    /**
     * This action is used to get the Default Referral Program by the User.
     *
     * @return mixed
     */
    public function getDefaultProgram()
    {
        $program = ReferralProgram::where('name','=','Invite')->first();
        $PANEL_FRIEND_REFERRAL_POINTS = settings::where('key','=','PANEL_FRIEND_REFERRAL_POINTS')->first();
        $points = $PANEL_FRIEND_REFERRAL_POINTS->value;
        if (!$program) {
            return ReferralProgram::create(['name' => 'Invite', 'code' => 'Invite','points'=> $points,'uri' => 'register']);
        }
        return $program;
    }


    /*******************Need to recheck the method if it is in use or not***************************************/
    public function findByReferralId($referralId)
    {
        $referral = ReferralLink::find($referralId);
        if (is_null($referral)) {
            return false;
        }
        return $referral;
    }
    /*******************Need to recheck the method if it is in use or not***************************************/

    public function createReferralRelationship(ReferralLink $referral, User $user)
    {        
        return ReferralRelationship::updateOrCreate([
            'referral_link_id' => $referral->id,
            'user_id' => $user->id
        ]);
    }

    /**
     * This action is used for retrieving all the referrals of the User.
     *
     * @return array
     */
    public function getMyReferrals()
    {
        $user = auth()->user();
        /*$myReferrals =ReferralLink::getReferral($user, $this->getDefaultProgram())->with(['relationships', 'relationships.referredUser'])->first();*/
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->orderBy('created_at', 'desc')->first();
        $getuser_achievement = isset($get_user_add_data->user_achievement) ? $get_user_add_data->user_achievement: [];


        
        $invite_data = array_column($getuser_achievement,'invite_achievement');
        $referral_data = [];

        // echo'<pre>';
        // print_r($invite_data); die();

        if($invite_data){
            foreach ($invite_data[0] as  $invite){
                $referred_user_id = $invite['referred_user_id'];

                $referred_user_details = User::where('id','=',$referred_user_id)->first();

                // $referred_user_details = DB::table('users')->where('id','=',$referred_user_id)->first();

                $check_survey_taken =  DB::table('users')->join('user_projects','users.id','=','user_projects.user_id')
                                                                ->where('users.id','=',$referred_user_id)    
                                                                ->where('user_projects.status','=',1)    
                                                                ->select('user_projects.id','user_projects.status')
                                                                ->first();

                                $check_survey_achievements =  DB::table('users')->join('user_projects','users.id','=','user_projects.user_id')
                                                                ->where('users.id','=',$referred_user_id)    
                                                                ->where('user_projects.status','=',50)    
                                                                ->select('user_projects.id','user_projects.status')
                                                                ->first();  
                                                                
                                                                $check_survey_rejection =  DB::table('users')->join('user_projects','users.id','=','user_projects.user_id')
                                                                ->where('users.id','=',$referred_user_id)    
                                                                ->where('user_projects.status','=',5)    
                                                                ->select('user_projects.id','user_projects.status')
                                                                ->first();                                                 

                    // echo '<pre>';
                    // print_r($check_survey_achievements);die();

                if(!empty($referred_user_details)){
                    $referred_user_name = $referred_user_details->first_name." ".$referred_user_details->last_name;
                    $referral_points  = $invite['points'];
                    $referral_status  = $invite['status'];

                    if($check_survey_taken){
                        if($referral_status == 'pending' && $check_survey_taken->status == 1){
                            $referral_status = 'completed';
                        }   
                    }


                    if($check_survey_rejection){
                        if($referral_status == 'pending' && $check_survey_rejection->status == 5){
                            $referral_status = 'Response Rejected';
                        }   
                    }

                    if($check_survey_achievements){
                        if($referral_status == 'completed' && $check_survey_achievements->status == 50){
                            $referral_status = 'points credited';
                        }
                    }

                    $referred_user_creation = $referred_user_details->created_at;
                    /* $referral_data[] = [
                        'name' => $referred_user_name,
                        'email' => $referred_user_details->email,
                        'points' => $referral_points,
                        'status' => $referral_status,
                        'referred_user_id' => $referred_user_id,
                        'created_at' => $referred_user_creation,
                    ]; */
					
					/* Parshant [08-10-2024] */
					
					if(array_search($referred_user_details->email, array_column($referral_data, 'email')) !== false) {

						continue;
					}
					else {
						$referral_data[] = [
							'name' => $referred_user_name,
							'email' => $referred_user_details->email,
							'points' => $referral_points,
							'status' => $referral_status,
							'referred_user_id' => $referred_user_id,
							'created_at' => $referred_user_creation,
						];	

					} 

                }
                
            }
        }
        return $referral_data;
    }
}
