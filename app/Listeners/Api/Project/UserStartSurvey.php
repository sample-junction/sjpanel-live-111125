<?php

namespace App\Listeners\Api\Project;

use App\Models\Project\UserProject;
use App\Repositories\Inpanel\Project\ProjectRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Inpanel\Traffic\TrafficStatuses;

class UserStartSurvey
{
    use TrafficStatuses;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $projectRepo;
    public function __construct(ProjectRepository $projectRepo)
    {
        $this->projectRepo = $projectRepo;
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
        $user_project = $event->project;
        $this->projectRepo->redirectClientLink($user,$user_project);
    }
}
