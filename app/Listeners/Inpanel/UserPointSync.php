<?php

namespace App\Listeners\Inpanel;

use App\Events\Inpanel\Auth\UserUpdated;
use App\Models\Auth\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPointSync //implements ShouldQueue
{
    use InteractsWithQueue;

    protected $user;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle($event)
    {
        \Log::info('User UserPointSync');

        $user = $event->user;
        $this->user = $user;

       /* $points = [
            'approved_points' => $this->getApprovedPoints($user),
            'pending_points' => $this->getPendingPoints($user),
            'rejected_points' => $this->getRejectedPoints($user),
        ];
        $user->point()->updateOrCreate([], $points);*/
    }

    /**
     * Handle a job failure.
     *
     * @param  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed($event, $exception)
    {
        \Log::error('USER POINT SYNC ERROR: ',[$exception]);
        try{
            \Log::error('USER POINT SYNC MESSAGE: ',$exception->getTrace());
        }catch(\Exception $e){
            \Log::error('ANOTHER EXCEP: ',$e);
        }

    }

    public function getApprovedPoints(User $user){
        $achievements = $user->userAchievements()->with('achievable')->get();
        $approvedPoints = 0;
        foreach($achievements as $item){
            $achievementObject = $item->achievable;
            $approvedPoints += $achievementObject->points;
        }

        return $approvedPoints;
    }

    public function getPendingPoints(User $user){

        $pendingPoints = 0;
        return $pendingPoints;
    }

    public function getRejectedPoints(User $user){

        $rejectedPoints = 0;
        return $rejectedPoints;
    }
}
