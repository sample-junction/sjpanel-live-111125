<?php

namespace App\Listeners\Inpanel;

use App\Events\Inpanel\Auth\UserUpdated;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Profiler\UserAdditionalData;
use App\Models\UserPoint;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\StaticAchievement;

class UpdateUserAchievements implements ShouldQueue
{
    use InteractsWithQueue; 
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
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle($event)
    {
        $user_id = $event->user;
        $get_user_confirm_points = StaticAchievement::where('code','=','user_joined')->first();
        $points = $get_user_confirm_points->points;
        $type = "static_achievement";
        $type_code = $get_user_confirm_points->code;
        $type_id = $get_user_confirm_points->id;
        $this->createUserAchievement($event,$points,$type,$type_id,$type_code);
    }

    private function createUserAchievement($event,$points,$type,$type_id,$type_code)
    {
        $user = $event->user;
        if($points){
            $update_user_points_data = [
                'user_id' => $user->id,
                'approved_points' => $points,
            ];
            $update_user_points = UserPoint::updateOrCreate($update_user_points_data);
            $get_add_user_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
            $user_achivement_data['user_achievement'] = [
                $type => [
                    $type_code => $points,
                ],
            ];

            if(empty($get_add_user_data)){
                $newdata = [
                    'uuid' => $user->uuid,
                    'u_id' => $user->id,
                    'user_answers' => [],
                ];
                $create_add_data = UserAdditionalData::create($newdata);
                UserAdditionalData::where('uuid','=',$create_add_data->uuid)->push($user_achivement_data);

                // add by anshu 
                //$this->userRepo->thresoldAlert($user);
                // end

                return true;
                
            } else{
                if($get_add_user_data->$type){
                    UserAdditionalData::where('uuid','=',$user->uuid)->update($user_achivement_data);
                    
                // add by anshu 
                //$this->userRepo->thresoldAlert($user);
                // end

                }
            }
            /*$update_add_user_data = UserAdditionalData::where('uuid','=',$user->uuid)                         ->updateOrCreate($user_achivement_data);*/
        }
    }
}
