<?php

namespace App\Http\Controllers\Api\Cron;

use App\Events\Inpanel\Project\AfterStatusChanged;
use App\Events\Inpanel\Project\ProjectQuotaUpdate;
use App\Http\Controllers\Api\BaseController;
use App\Mail\Inpanel\UserProject\SurveyCustomInvite;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;
use App\Mail\Inpanel\UserProject\UserProjectCreated;
use App\Models\Auth\User;
use App\Models\Project\Project;
use App\Models\Project\InviteSentDetails;
use App\Models\Project\ProjectQuota;
use App\Models\Project\UserProject;
use App\Models\Project\SjpanelResponserates;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\Project\ProjectQuotaRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Api\Project\ProjectRepository;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Inpanel\Traffic\TrafficRepository;
use App\Models\Traffics\Traffic;
use App\Models\Report\SurveyStartCount;
use App\Models\Report\SurveyReport;
use MongoDB\BSON\UTCDateTime;

/**
 * This class handle all the functionality of creating a new cron, updating it,
 *
 * Class CronController
 * @author Vikash Kumar
 * @access public
 * @package App\Http\Controllers\Api\Cron\CronController
 */
class CronController extends BaseController
{
    /**
     * @var ProjectRepository
     * @param $projectRepo
     * @param $projectQuotaRepository
     */
    public $projectRepo, $projectQuotaRepository;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepo
     * @param ProjectQuotaRepository $projectQuotaRepository
     */

    public function __construct(ProjectRepository $projectRepo, ProjectQuotaRepository $projectQuotaRepository,TrafficRepository $trafficRepo)
    {
        $this->projectRepo = $projectRepo;
        $this->projectQuotaRepository = $projectQuotaRepository;
        $this->trafficRepo = $trafficRepo;
    }

    /**
     * This action is used for creating new project as this api is hit by apace.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUpadteSurveyReport(Request $request)
    {

        /*print_r(Carbon::now()->startOfDay());
        print_r(Carbon::now()->subMinute(180000));//die;*/
        
        $resultData = Traffic::where('source_code','SJPL')
                    ->where('status',0)
                    ->whereBetween('updated_at', [Carbon::now()->startOfDay(), Carbon::now()->subMinute(60)])
                    ->get();

       

        $count_data = count($resultData);
        if($count_data>0){

            foreach($resultData as $row){
                $start_date = $row->started_at;
                if($start_date!=''){
                    if (is_string($start_date)) {
                        $start_date = new UTCDateTime( strtotime($start_date) * 1000 );
                    }
                    $startedDateTime = $start_date->toDateTime()->format('Y-m-d H:i:s');
                }else{
                    $startedDateTime = NULL;
                }
                $end_date = $row->ended_at;
                if($end_date!=''){
                    if (is_string($end_date)) {
                        $end_date = new UTCDateTime( strtotime($end_date) * 1000 );
                    }
                    $endedDateTime = $end_date->toDateTime()->format('Y-m-d H:i:s');
                }else{
                    $endedDateTime = NULL;
                }
                if($startedDateTime && $endedDateTime){
                    $secondsDifference = strtotime($endedDateTime)-strtotime($startedDateTime);
                }else{
                    $secondsDifference = 0;
                }
                

                $array_data =array(
                    'RespID'             => $row->id,
                    'uuid'               => explode('_',$row->vvars['sjpid'])[0],
                    'project_code'       => $row->project_code,
                    'source_code'        => $row->source_code,
                    'country_code'       => $row->country_code,
                    'language_code'      => $row->language_code,
                    'cpi'                => $row->cpi,
                    'status'             => $row->status,
                    'status_name'        => $row->status_name,
                    'resp_status'        => $row->resp_status,
                    'resp_status_name'   => $row->resp_status_name,
                    'reject_reason'      => '',
                    //'duration'         => $row->duration,
                    'duration'           => $secondsDifference,
                    'start_ip_address'   => $row->start_ip_address,
                    'end_ip_address'     => $row->start_ip_address,
                    'traffic_flag'       => $row->flag,
                    'client_survey_link' => $row->clientsourceurl,
                    'client_end_link'    => $row->clientreplyurl,
                    'vendor_start_link'  => $row->vendorsourceurl,
                    'vendor_end_link'    => $row->vendorreplyurl,
                    'channel_id'         => $row->channel_id,
                    'started_at'         => $startedDateTime,
                    'ended_at'           => $endedDateTime,
                );

                //print_r($array_data);die;

                $is_row = SurveyReport::where('RespID',$row->id)->get()->count();

               // print_r($is_row); die;

                if($is_row >0){
                    //SurveyReport::where('RespID',$row->id)->update($array_data);
                }else{
                    SurveyReport::create($array_data); 
                }
            
                // print_r($array_data);
                // SurveyReport::create($array_data);
                 //die;
            }
                
                //SurveyReport::create($add_data); 
        }

        return response()->json('data insert', 200);
    }


}