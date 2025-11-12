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


class UserReferredAchievementUpdateListener
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
     * Listener for handling the UserReferredAchievementUpdateListener for handling update the User Points Details in User Additional Data Collection.
     * Create by Vikash Yadav (30-11-2022)
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        $referral_user_id = $event->referral_user_id;
        $refered_user_id  = $event->refered_user_id;

        //print_r($refered_user_id);die;
        if($refered_user_id){
            $user = User::where('id',$refered_user_id)->first();
            $this->userReferredAchievmentUpdate($refered_user_id,$referral_user_id);
            event(new UserAchievementUpdate($user));
        }
        return;
        
    }

    public function userReferredAchievmentUpdate($refered_user_id,$referral_user_id)
    {
        $user_add_data = UserAdditionalData::where('u_id', '=', $refered_user_id )->first();

        $fetch_static_achievement = array_column($user_add_data->user_achievement,'referral_achievement');
        //print_r($fetch_static_achievement); 
        $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($referral_user_id,array_column($fetch_static_achievement[0],'referral_user_id')) : false;
        //print_r($check_basic_detail);die;
        $pending_point = 0;
        if($check_basic_detail){
            $data = [];
            foreach($user_add_data['user_achievement'] as $key=>$value){

                if(array_key_exists("referral_achievement",$value)){
                    foreach ($value as $profile_data){
                       
                        foreach ($profile_data as $key=>$pdata){
                            //print_r($key);
                            if($pdata['referral_user_id']==$referral_user_id){
                                $value['referral_achievement'][$key]['status']="completed";                            
                                $pending_point = $pdata['points'];        
                            }
                            
                        }
   
                    }
                }
                $data['user_achievement'][] = $value;
            } 
            UserAdditionalData::where('u_id', '=', $refered_user_id)->update($data);
            activity("user_achievements")
                ->causedBy($refered_user_id)
                ->withProperties(['points'=>$pending_point])
                ->log('inpanel.activity_log.areferral_points');


                 // add by anshu
                 $user = Auth::user(); 
                 $this->userRepository->thresoldAlert($user);
                 // end

            
        }

    }
}
