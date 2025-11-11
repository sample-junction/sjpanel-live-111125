<?php

namespace App\Listeners\Inpanel\Project\Status\After;

use App\Events\Inpanel\Project\AfterStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Project\UserProject;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use DB;

class PauseListener
{
    public $statusCode, $project;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserNotificationRepository $notificationRepo)
    {
        $this->statusCode = 'PAUSE';
        $this->notificationRepo = $notificationRepo;
    }

    /**
     * Listener for handling the Event AfterStatusChanged for changing the status of Project To Pause
     *
     * @param  AfterStatusChanged  $event
     * @return void
     */
    public function handle(AfterStatusChanged $event)
    {

        \Log::info('status changed to hold - msg from pauseListener'.$event->project->apace_project_code."status".$event->currentStatusObject);

        $currentStatusObject = $event->currentStatusObject;
        if( empty($currentStatusObject) || $currentStatusObject->code !== $this->statusCode){
            return;
        }
     
        // $project = $event->project;
        // if($project->survey_status_code=="PAUSE"){

        //     $deleteUserProject = UserProject::where('project_id', '=', $project->id)->whereNull('status')->delete();

        // }
        $project = $event->project->apace_project_code;
        $users_assigned = DB::table('users')
                        ->join('user_projects','user_projects.user_id','=','users.id')
                        ->where('user_projects.apace_project_code',$project)
                        ->select('users.uuid')->get();
        $users = json_decode($users_assigned);
        foreach($users as $user){
            $survey_closed_notification = $this->notificationRepo->createNotification($user->uuid,'Survey',$project,'Expired');
         }
        return;
    }
}
