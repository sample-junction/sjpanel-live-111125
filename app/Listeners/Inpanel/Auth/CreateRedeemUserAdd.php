<?php

namespace App\Listeners\Inpanel\Auth;

use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Redeem\RequestRedeem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;


class CreateRedeemUserAdd
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       $user = $event->user;
       $user_add = UserAdditionalData::where('uuid','=',$user->uuid)->first();
       $redeem_points_data = RequestRedeem::where('user_uuid','=',$user->uuid)->orderBy('id', 'desc')->first();
       $redeem_points = $redeem_points_data->redeem_points;
       $total_users_points = $redeem_points_data->total_points;
        $user_redeem_points[] = [
        'date_requested' =>$redeem_points_data->created_at,
        'approved_at' =>'',
        'points' => $redeem_points,
        ];
      if(empty($user_add->user_redeem_points)){
          $update = UserAdditionalData::where('uuid','=',$user->uuid)->push('user_redeem_points',$user_redeem_points);
          event(new UserAchievementUpdate($user));
          activity("user_achievements")
              ->causedBy($this)
              ->withProperties(['points'=>$redeem_points])
              ->log('inpanel.activity_log.redeem_points.request');
    
                // add by anshu
                $user = Auth::user(); 
                $this->userRepo->thresoldAlert($user);
                // end
      }
        $redeem_data = array_column($user_add->user_redeem_points,"user_redeem_points");
        $user_achieve_present_code =in_array($profile_code,array_column($achievements[0], 'code'));
    }
}
