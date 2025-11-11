<?php

namespace App\Listeners\Inpanel\Auth;

use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Frontend\Auth\UserRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use MongoDB\BSON\UTCDateTime;
use Auth;


class UserAchievementUpdateListener
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
     * Listener for handling the UserAchievementUpdate for handling update the User Points Details in User Additional Data Collection.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user_add_data = UserAdditionalData::where( 'uuid', '=', $user->uuid )->first();
        $completed = 0;
        $pending = 0;
        $rejected = 0;
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
        if (!empty($user_add_data->user_achievement) && is_array($user_add_data->user_achievement)) {
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
        }
        $updateData = [
            'completed' => $completed - $redeem_points,
            'pending' => $pending,
            'rejected' => $rejected,
            'date_updated' => time(),
            'redeemed_points' => $redeem_points
        ];

        // add by anshu 
        $users = Auth::user();
        $this->userRepository->thresoldAlert($users);
        // end


        //dd($user_add_data);
        $user_add_data->user_points = $updateData;
        $user_add_data->save();

        Cache::put('users.'.$user->id.'.points', UserAdditionalData::select('user_points')->where('uuid','=',$user->uuid)
            ->first(), now()->addDay(1));

        return;
    }
}
