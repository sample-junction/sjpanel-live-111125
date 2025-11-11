<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Report\SurveyReport;
use App\Models\Traffics\Traffic;
use Carbon\Carbon;
use MongoDB\BSON\UTCDateTime;
use Illuminate\Support\Facades\Log;

class CreateSurveyReport extends Command

{

   /**

    * The name and signature of the console command.

    *

    * @var string

    */

   protected $signature = 'surveyreport:create';



   /**

    * The console command description.

    *

    * @var string

    */

   protected $description = 'Create survey report from traffic every 15 minutes';



   /**

    * Create a new command instance.

    *

    * @return void

    */

   public function __construct()

   {

       parent::__construct();

   }



   /**

    * Execute the console command.

    *

    * @return mixed

    */

    public function handle()
    {
         //echo Carbon::now()->startOfDay()."<br>";
         //echo Carbon::now()->subMinute(300)."<br>";
         //exit;

         $resultData = Traffic::where('source_code','SJPL')
                    ->where('status',0)
                    ->where(function ($qry){
                        $qry -> where('study_type_id','!=',12);
                    })
                    //->whereBetween('updated_at', [Carbon::now()->startOfDay(), Carbon::now()->subMinute(0)])
                    ->get();
                    //Log::info('Fetched Result Data:', $resultData->toArray());
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


                $is_row = SurveyReport::where('RespID',$row->id)->get()->count();

                print_r($row->id." "); 

                if($is_row >0){
                    // SurveyReport::where('RespID',$row->id)->update($array_data);
                }else{
                    SurveyReport::create($array_data); 
                }
            }
        }
    
        $this->info('Survey report insert successfully');
    }

}