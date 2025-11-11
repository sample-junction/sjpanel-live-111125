<?php

namespace App\Listeners\Inpanel\Project\Status\After;

use App\Events\Inpanel\Project\AfterStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Repositories\Frontend\Auth\UserNotificationRepository;




use DB;

class ClosedListener
{
    public $statusCode, $project;
    /**
     * Create the event listener.
     *
     * @return void
     */


    public function __construct(UserNotificationRepository $notificationRepo)
    {
        $this->statusCode = 'CLOSED';
       $this->notificationRepo = $notificationRepo;
    }

    /**
     * Listener for handling the Event AfterStatusChanged for changing the status of Project To Close
     *
     * @param  AfterStatusChanged  $event
     * @return void
     */
    public function handle(AfterStatusChanged $event)
    {
        \Log::info('status changed to closed - msg from closedListener');
        \Log::info($event->project);
        $currentStatusObject = $event->currentStatusObject;
        if( empty($currentStatusObject) || $currentStatusObject->code !== $this->statusCode){
            return;
        }
        $project = $event->project->apace_project_code;
        $users_assigned = DB::table('users')
                        ->join('user_projects','user_projects.user_id','=','users.id')
                        ->where('user_projects.apace_project_code',$project)
                        ->select('users.uuid')->get();
        \Log::info($users_assigned);
        $users = json_decode($users_assigned);
        foreach($users as $user){

           

           $survey_closed_notification = $this->notificationRepo->createNotification($user->uuid,'Survey',$project,'Expired');

        

        }
        \Log::info($users[0]->uuid);
            
        
        
        /*$project = $event->project;
        $previousStatusObject = $event->previousStatusObject;
        event(SourceAPIEvents::PROJECT_CLOSED, new SourceAPIEvents($project));*/

        return;
    }
}
