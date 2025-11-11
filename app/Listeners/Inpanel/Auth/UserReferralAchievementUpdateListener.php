<?php

namespace App\Listeners\Inpanel\Auth;

use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Frontend\Auth\UserRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use MongoDB\BSON\UTCDateTime;
use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Models\Auth\User;
use Auth;


class UserReferralAchievementUpdateListener
{
    public $userRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Listener for handling the UserReferralAchievementUpdateListener for handling update the User Points Details in User Additional Data Collection.
     * Create by Vikash Yadav (29-11-2022)
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        $referral_user_id = $event->referral_user_id;
        $refered_user_id  = $event->refered_user_id;
        //print_r($referral_user_id);
        if($referral_user_id){
            $user = User::where('id',$referral_user_id)->first();
            $this->userReferralAchievmentUpdate($referral_user_id,$refered_user_id);
            event(new UserAchievementUpdate($user));  
        }
        // //print_r($refered_user_id);die;
        // if($refered_user_id){
        //     $this->userReferredAchievmentUpdate($refered_user_id,$referral_user_id);
        // }
        return;
        
    }
    public function userReferralAchievmentUpdate($referral_user_id,$refered_user_id)
    {
        $user_add_data = UserAdditionalData::where('u_id', '=', $referral_user_id )->first();

        $fetch_invite_achievement = array_column($user_add_data->user_achievement,'invite_achievement');
        //print_r($fetch_invite_achievement); 
        $check_basic_detail = isset($fetch_invite_achievement[0]) ? in_array($refered_user_id,array_column($fetch_invite_achievement[0],'referred_user_id')) : false;
        //print_r($check_basic_detail);die;
        $pending_point = 0;
        if($check_basic_detail){
            $data = [];
            foreach($user_add_data['user_achievement'] as $key=>$value){

                if(array_key_exists("invite_achievement",$value)){
                    foreach ($value as $profile_data){
                       
                        foreach ($profile_data as $key=>$pdata){
                            //print_r($key);
                            if($pdata['referred_user_id']==$refered_user_id){
                                $value['invite_achievement'][$key]['status']="completed";                            
                                $pending_point = $pdata['points'];        
                            }
                            
                        }
   
                    }
                }
                $data['user_achievement'][] = $value;
            } 
            UserAdditionalData::where('u_id', '=', $referral_user_id)->update($data);
            //$this->updateUserAchivement($user_add_data,$referral_user_id);
            activity("user_achievements")
                ->causedBy($referral_user_id)
                ->withProperties(['points'=>$pending_point])
                ->log('inpanel.activity_log.ainvite_points');

            // add by anshu 
            $user = Auth::user();
            $this->userRepository->thresoldAlert($user);
            // end
            
        }

    }

    // public function userReferredAchievmentUpdate($refered_user_id,$referral_user_id)
    // {
    //     $user_add_data = UserAdditionalData::where('u_id', '=', $refered_user_id )->first();

    //     $fetch_static_achievement = array_column($user_add_data->user_achievement,'referral_achievement');
    //     //print_r($fetch_static_achievement); 
    //     $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($referral_user_id,array_column($fetch_static_achievement[0],'referral_user_id')) : false;
    //     //print_r($check_basic_detail);die;
    //     $pending_point = 0;
    //     if($check_basic_detail){
    //         $data = [];
    //         foreach($user_add_data['user_achievement'] as $key=>$value){

    //             if(array_key_exists("referral_achievement",$value)){
    //                 foreach ($value as $profile_data){
                       
    //                     foreach ($profile_data as $key=>$pdata){
    //                         //print_r($key);
    //                         if($pdata['referral_user_id']==$referral_user_id){
    //                             $value['referral_achievement'][$key]['status']="completed";                            
    //                             $pending_point = $pdata['points'];        
    //                         }
                            
    //                     }
   
    //                 }
    //             }
    //             $data['user_achievement'][] = $value;
    //         } 
    //         UserAdditionalData::where('u_id', '=', $refered_user_id)->update($data);
    //         activity("user_achievements")
    //             ->causedBy($refered_user_id)
    //             ->withProperties(['points'=>$pending_point])
    //             ->log('inpanel.activity_log.areferral_points');
    //         $this->updateUserAchivement($user_add_data,$refered_user_id);
            
    //     }

    // }

    public function updateUserAchivement($user_add_data,$user_id){
        
        $completed = 0;
        $pending   = 0;
        $rejected  = 0;
        $redeem_points = 0;
        if($user_add_data->user_redeemed_points){
         foreach($user_add_data->user_redeemed_points as $redeem_data){
            foreach($redeem_data as $key=>$value ){
                if($key == "points"){
                    $redeem_points = $redeem_points + $value;
                }
            }
         }
        }

        //print_r($redeem_points);die;
        foreach ($user_add_data->user_achievement as $key=>$value){
            foreach($value as $achive_type => $data){
                foreach ($data as $points_data){
                    if($points_data['status']=="completed"){
                        $completed = ($completed+$points_data['points']);
                    } elseif($points_data['status']=="pending"){
                        $pending = $pending+$points_data['points'];
                    } elseif($points_data['status']=="rejected"){
                        $rejected = $rejected+ $points_data['points'];
                    }
                }
            }
        }
        $updateData = [
            'completed' => $completed - $redeem_points,
            'pending' => $pending,
            'rejected' => $rejected,
            'date_updated' => time(),
            'redeemed_points' => $redeem_points
        ];

        
        // add by anshu 
        $user = Auth::user();
        $this->userRepository->thresoldAlert($user);
        // end
        
        //dd($user_add_data);
        $user_add_data->user_points = $updateData;
        $user_add_data->save();

        Cache::put('users.'.$user_id.'.points', UserAdditionalData::select('user_points')->where('u_id','=',$user_id)
            ->first(), now()->addDay(1));

    }
}
