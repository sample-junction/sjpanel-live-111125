<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/27/2019
 * Time: 8:15 PM
 */

namespace App\Repositories\Api\Project;


use App\Models\Project\Project;
use App\Models\Project\ProjectQuota;
use App\Models\Project\ProjectStatus;
use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use App\Models\Project\UserProject; // add by Himanshu 28-10-2025

class ProjectRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }

    public function createProject($projectArray)
    {
        if(isset($projectArray['apace_vendor_survey_code']) && $projectArray['apace_vendor_survey_code']!=''){
            $projectArray['code'] = $projectArray['apace_vendor_survey_code'];
        }else{
            $projectArray['code'] = $this->generateNewProjectCode($projectArray['country_code'], $projectArray['language_code'] );            
        }
        $project = Project::create($projectArray);
        return $project;
    }

    public function generateNewProjectCode($country_code, $language_code)
    {
        //$yearMonthDate = date("ymd");
        $yearMonthDate = date("ydm");
        $lastProjectCode = $this->getLastProject();
        $sycodelast = 1;
        if ($lastProjectCode) {
            $syyrmoDate = substr( $lastProjectCode->code,0,6);
            if ( $syyrmoDate == $yearMonthDate ){
                $sycodelast = (int) substr($lastProjectCode->code,6,3);
                $sycodelast = $sycodelast+1;
            }
        }
        $sycodelast = sprintf('%03d', $sycodelast);
        //$projectCode = $yearMonthDate . $sycodelast . $country_code.$language_code;
        $projectCode = $yearMonthDate . $sycodelast . "SJPL";
        return $projectCode;
    }
    private function getLastProject()
    {
        $project = DB::table('projects')
            ->orderBy('id', 'desc')
            ->first();
        return $project;
    }
    public function updateProjectStatus($project, $nextStatusObject )
    {
        $data = [
            'survey_status_code' => $nextStatusObject->code,
        ];

       $status = $project->update($data);
       
    //    if($project->apace_project_code){
    //     Project::where('apace_project_code','=',$project->apace_project_code)
    //         ->update($data);
    //    }     

       
        return ($status)?$project:false;
    }

    public function updateProject($survey_code,$input)
    {
        $update_project = Project::where('code','=',$survey_code)
            ->update($input);
        return $update_project;
    }

    public function addQuota($input,$survey_code)
    {
        $get_survey_id = Project::select('id')->where('code','=',$survey_code)->first();
        $input['project_id'] = $get_survey_id->id;
        $add_quota = ProjectQuota::create($input);
        return $add_quota;
    }

    public function updateQuota($survey_code,$quota_name,$data_update)
    {
        $project_id =  $get_survey_id = Project::select('id')->where('code','=',$survey_code)->first();
        $updateQuota = ProjectQuota::where('project_id','=',$project_id->id)
            ->where('name','=',$quota_name)
            ->update($data_update);
        return $updateQuota ;
    }

    public function updateQuotaStatus($status,$survey_code,$quota_name)
    {
        $project_id =  $get_survey_id = Project::select('id')->where('code','=',$survey_code)->first();
        $update_status = ProjectQuota::where('project_id','=',$project_id->id)
            ->where('name','=',$quota_name)
            ->update($status);
        return $update_status;
    }

    public function checkProject($survey_code)
    {
        $project = Project::where('survey_code','=',$survey_code)->first();
        return $project;
    }

    public function getCurrentStatus($project_code)
    {
        $project_status = Project::select('survey_status_code')->where('code','=',$project_code)->with('status')->first();
        return $project_status;
    }
    public function getProject($project_code)
    {
        //$project = Project::where('apace_project_code','=',$project_code)->first();
        $project = Project::where('code','=',$project_code)->first();
        return $project;
    }
    public function getNewStatus($new_status)
    {
        $project_status_details = ProjectStatus::where('code','=',$new_status)->first();
        return $project_status_details;
    }

    public function getLiveStatus()
    {
        $status = ProjectStatus::where('code', '=', 'LIVE')
            ->first();
        return $status;
    }

    // added getDedupeMatchedUsers by Himanshu 28-10-2025
    public function getDedupeMatchedUsers($dedupArr=[]){
        if(empty($dedupArr) || empty($dedupArr['dedupe_codes']) || empty($dedupArr['dedupe_status'])) return [];

        $projects = Project::whereIn('apace_project_code',$dedupArr['dedupe_codes'])->pluck('id');

        if($projects->count() <= 0) return [];

        $projects = $projects->toArray();
        $userProjectsQuery = UserProject::whereIn('project_id', (array) $projects);
        $dedupeStatus = $dedupArr['dedupe_status'] ?? null;

        if ($dedupeStatus === 'attempted') {
            $userProjectsQuery->whereNotNull('status');
        } elseif ($dedupeStatus === 'completed') {
            $userProjectsQuery->whereIn('status', [1, 50]);
        }

        $userProjects = $userProjectsQuery->pluck('user_id')->toArray();
        return $userProjects;
    }
}
