<?php

/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 30-01-2019
 * Time: 04:26 PM
 */

namespace App\Repositories\Inpanel\Traffic;

use App\Models\Traffics\Traffic;
use App\Models\Report\SurveyReport;
use App\Models\Report\SurveyStartCount;
use App\Repositories\BaseMongoRepository;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
//use function foo\func;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;
use App\Models\Auth\User;
use App\Models\Project\UserProject;
use Illuminate\Support\Facades\Cache;



class TrafficRepository extends BaseMongoRepository
{
    protected function getTrafficCollection()
    {
        return $this->getCollection('traffics');
    }

    public function getTrafficsStatsByDateRange($fromDate, $toDate)
    {
        /*$data = Traffic::where('source_code','SJPL')
                       ->where('created_at', '>=', Carbon::parse($fromDate))
                       ->where('created_at', '<=', Carbon::parse($toDate))
                       ->get();*/
        $data = SurveyStartCount::selectRaw('SUM(start_count) as startCount')
            ->where('start_date', '>=', Carbon::parse($fromDate))
            ->where('start_date', '<=', Carbon::parse($toDate))
            ->first();
        return $data;
    }

    public function getTrafficsStats($fromLastDays, $projectid = null)
    {
        //$project_ids = $projectid->pluck('id')->toArray();

        /* $project_ids = array($projectid);
        //$dt = Carbon::now()->startOfMonth();
        $data = Traffic::where('source_code','SJPL')->where('created_at', '>=',$fromLastDays)->get();
        return $data;*/

        $data = SurveyStartCount::selectRaw('SUM(start_count) as startCount')->where('start_date', '>=', $fromLastDays)->first();
        return $data;
    }

    public function getTrafficsStatsRejected($fromDate = null, $toDate = null)
    {
        if ($fromDate && $toDate) {
            /*$data = Traffic::where('source_code','SJPL')
                           ->where('status', 5)
                           ->where('created_at', '>=', Carbon::parse($fromDate))
                           ->where('created_at', '<=', Carbon::parse($toDate))
                           ->get();*/
            $data = SurveyReport::where('source_code', 'SJPL')
                ->where('status', 5)
                ->where('createdOn', '>=', Carbon::parse($fromDate))
                ->where('createdOn', '<=', Carbon::parse($toDate))
                ->get();
        } else {
            /*$data = Traffic::where('source_code','SJPL')
                          ->where('status', 5)
                          ->get();*/
            $data = SurveyReport::where('source_code', 'SJPL')
                ->where('status', 5)
                ->where('createdOn', '>=', now()->subDays(30)->endOfDay())
                ->get();
        }

        return $data;
    }

    // optemized "getTrafficsStatsAllUsers" by Hiamnshu [12-08-2025] start
    public function getTrafficsStatsAllUsers($fromDate = null, $toDate = null, $datePeriod = null)
    {
        $query = UserProject::query()
            // ->whereNotNull('user_projects.status')
            ->select(
                'user_projects.user_id',
                'user_projects.status',
                'latest_devices.device_type',
                'users.uuid'
            )
            ->leftJoin('users', 'users.id', '=', 'user_projects.user_id');

        if ($fromDate && $toDate) {
            $latestDevices = DB::table('device_histories as dh1')
                ->select('dh1.user_id', 'dh1.device_type')
                ->whereRaw('dh1.updated_at = (
                    SELECT MAX(dh2.updated_at)
                    FROM device_histories as dh2
                    WHERE dh2.user_id = dh1.user_id
                )');

            $query->whereBetween('user_projects.updated_at', [$fromDate, $toDate]);
        } elseif ($datePeriod) {

            $latestTimestamps = DB::table('device_histories')
                ->select('user_id', DB::raw('MAX(updated_at) as latest_updated_at'))
                ->groupBy('user_id');

            $latestDevices = DB::table('device_histories as dh')
                ->joinSub($latestTimestamps, 'lt', function ($join) {
                    $join->on('dh.user_id', '=', 'lt.user_id')
                        ->on('dh.updated_at', '=', 'lt.latest_updated_at');
                })
                ->select('dh.user_id', 'dh.device_type');

            $query->where('user_projects.updated_at', '>=', $datePeriod);
        }

        $query->leftJoinSub($latestDevices, 'latest_devices', function ($join) {
            $join->on('user_projects.user_id', '=', 'latest_devices.user_id');
        });

        $newArray = array();
        $query->chunk(1000, function ($trafficData) use (&$newArray) {
            foreach ($trafficData as $traffic) {
                // $traffic = $traffic->toArray();

                if ($traffic->user_id == '' || empty($traffic->uuid)) {
                    continue;
                }

                // $userUuid = \DB::table('users')->where('id', $traffic['user_id'])->first(['uuid']);
                $userUuid = $traffic->uuid;
                $key = $traffic->user_id;
                $deviceType = $traffic->device_type ?? 'Web';
                $status = $traffic->status;

                if (!isset($newArray[$key])) {
                    $newArray[$key] = [
                        'device_type' => $deviceType,
                        'completesCount' => 0,
                        'terminatesCount' => 0,
                        'quotafullCount' => 0,
                        'quality_terminateCount' => 0,
                        'abandonsCount' => 0,
                        'rejectCount' => 0,
                        'startCount' => 0,
                        'assignCount' => 0,
                        'uuid' => $traffic->uuid,
                        'user_id' => $key
                    ];
                }

                if ($status === 0) {
                    $newArray[$key]['abandonsCount'] += 1;
                } else {
                    $newArray[$key]['completesCount']         += ($status == 1 || $status == 50) ? 1 : 0;
                    $newArray[$key]['terminatesCount']        += ($status == 2) ? 1 : 0;
                    $newArray[$key]['quotafullCount']         += ($status == 3) ? 1 : 0;
                    $newArray[$key]['quality_terminateCount'] += ($status == 4) ? 1 : 0;
                    $newArray[$key]['rejectCount']            += ($status == 5) ? 1 : 0;
                }
                $newArray[$key]['startCount'] += (!is_null($status) && $status !== '' && strtolower($status) !== 'null') ? 1 : 0;

                $newArray[$key]['assignCount']++;

                /*
                if (isset($newArray[$key])) {
                    $newArray[$key]['device_type'] = $deviceType;

                    if ($newArray[$key]['user_id'] === $traffic['user_id']) {

                        if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                            $newArray[$key]['completesCount'] += 1;
                        } elseif ($traffic['status'] == 2) {

                            $newArray[$key]['terminatesCount'] += 1;
                        } elseif ($traffic['status'] == 3) {

                            $newArray[$key]['quotafullCount'] += 1;
                        } elseif ($traffic['status'] == 4) {

                            $newArray[$key]['quality_terminateCount'] += 1;
                        } elseif ($traffic['status'] == 0 || $traffic['status'] != "") {

                            $newArray[$key]['abandonsCount'] += 1;
                        } elseif ($traffic['status'] == 5) {

                            $newArray[$key]['rejectCount'] += 1;
                        }

                        if (!empty($traffic['status'])) {

                            $newArray[$key]['startCount'] += 1;
                        }

                        $newArray[$key]['assignCount'] += 1;
                        $newArray[$key]['uuid']         = $userUuid;
                    }
                } else {
                    $newArray[$key]['device_type'] = $deviceType;
                    if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                        $newArray[$key]['completesCount']         = 1;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 0;
                        // $newArray[$key]['startCount']             = 1 ;

                    } else if ($traffic['status'] == 2) {

                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 1;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 0;
                        // $newArray[$key]['startCount']             = 1 ;

                    } else if ($traffic['status'] == 3) {

                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 1;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 0;
                        // $newArray[$key]['startCount']             = 1 ;

                    } else if ($traffic['status'] == 4) {

                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 1;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 0;
                        // $newArray[$key]['startCount']             = 1 ;

                    } else if ($traffic['status'] == 0 || $traffic['status'] != "") {

                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 1;
                        $newArray[$key]['rejectCount']            = 0;
                        // $newArray[$key]['startCount']             = 1 ;

                    } else if ($traffic['status'] == 5) {

                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 1;
                        //$newArray[$key]['startCount']             = 1 ;

                    } else {
                        $newArray[$key]['completesCount']         = 0;
                        $newArray[$key]['terminatesCount']        = 0;
                        $newArray[$key]['quotafullCount']         = 0;
                        $newArray[$key]['quality_terminateCount'] = 0;
                        $newArray[$key]['abandonsCount']          = 0;
                        $newArray[$key]['rejectCount']            = 0;
                    }

                    if (!empty($traffic['status'])) {

                        $newArray[$key]['startCount'] = 1;
                    } else {
                        $newArray[$key]['startCount'] = 0;
                    }

                    $newArray[$key]['assignCount'] = 1;
                    $newArray[$key]['uuid']         = $userUuid;
                    $newArray[$key]['user_id']      = $key;
                }*/
            }
        });
        return $newArray;
    }
    // end changes

    /* public function getTrafficsStatsAllUsers($fromDate = null, $toDate = null, $datePeriod = null)
    {

        // if($fromDate && $toDate){
        //     //$trafficData = Traffic::where('source_code','SJPL')
        //      //              ->where('created_at', '>=', Carbon::parse($fromDate))
        //     //               ->where('created_at', '<=', Carbon::parse($toDate))
        //      //              ->get();
        //     $trafficData = SurveyReport::where('source_code','SJPL')
        //                    ->where('createdOn', '>=', Carbon::parse($fromDate))
        //                    ->where('createdOn', '<=', Carbon::parse($toDate))
        //                    ->get()->toArray();
        // }else{
        //     //$trafficData = Traffic::where('source_code','SJPL')
        //      //               ->where('created_at', '>=',$datePeriod)
        //      //               ->get();
        //     $trafficData = SurveyReport::where('source_code','SJPL')
        //                     ->where('createdOn', '>=',$datePeriod)
        //                    ->get()->toArray();
        // }

        // Device history join added by Vikas
        if ($fromDate && $toDate) {

            $latestDeviceSubquery = DB::table('device_histories as dh1')
                ->select('dh1.user_id', 'dh1.device_type')
                ->whereRaw('dh1.updated_at = (
                    SELECT MAX(dh2.updated_at)
                    FROM device_histories as dh2
                    WHERE dh2.user_id = dh1.user_id
                )');

            $trafficData = UserProject::where('user_projects.updated_at', '>=', $fromDate)->whereNotNull('user_projects.status')
                ->where('user_projects.updated_at', '<=', $toDate)
                ->select('user_projects.*', 'latest_devices.device_type')
                ->leftJoinSub($latestDeviceSubquery, 'latest_devices', function ($join) {
                    $join->on('user_projects.user_id', '=', 'latest_devices.user_id');
                })
                ->get()
                ->toArray();
        } else {


            $latestTimestamps = DB::table('device_histories')

                ->select('user_id', DB::raw('MAX(updated_at) as latest_updated_at'))
                ->groupBy('user_id');

            $latestDevices = DB::table('device_histories as dh')
                ->joinSub($latestTimestamps, 'lt', function ($join) {
                    $join->on('dh.user_id', '=', 'lt.user_id')
                        ->on('dh.updated_at', '=', 'lt.latest_updated_at');
                })
                ->select('dh.user_id', 'dh.device_type');

            $trafficData = UserProject::where('user_projects.updated_at', '>=', $datePeriod)->whereNotNull('user_projects.status')
                ->select('user_projects.*', 'latest_devices.device_type')
                ->leftJoinSub($latestDevices, 'latest_devices', function ($join) {
                    $join->on('user_projects.user_id', '=', 'latest_devices.user_id');
                })

                //->limit(500)
                ->get()
                ->toArray();
        }




        //      $mappedcollection = $trafficData->map(function($traffic, $key) {									
        //         $uuid = explode('_',$traffic->vvars['sjpid']);
        //         return [
        //                 'project_code'     => $traffic->project_code,
        //                 'project_name'     => $traffic->project_name,
        //                 'source_code'      => $traffic->source_code,
        //                 'source_name'      => $traffic->source_name,
        //                 'status'           => $traffic->status,
        //                 'status_name'      => $traffic->status_name,
        //                 'resp_status'      => $traffic->resp_status,
        //                 'resp_status_name' => $traffic->resp_status_name,
        //                 'uuid'             => $uuid[0]
        //             ];
        //         });
        //    echo "<pre>";
        //     print_r($mappedcollection);//die;


        $newArray = array();

        foreach ($trafficData as $traffic) {
            if ($traffic['user_id'] == '') {
                continue;
            }
            $userUuid = \DB::table('users')->where('id', $traffic['user_id'])->first(['uuid']);

            $key = $traffic['user_id'];
            $deviceType = $traffic['device_type'] ?? 'Web';
            if (isset($newArray[$key])) {
                $newArray[$key]['device_type'] = $deviceType;

                if ($newArray[$key]['user_id'] === $traffic['user_id']) {

                    if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                        $newArray[$key]['completesCount'] += 1;
                    } elseif ($traffic['status'] == 2) {

                        $newArray[$key]['terminatesCount'] += 1;
                    } elseif ($traffic['status'] == 3) {

                        $newArray[$key]['quotafullCount'] += 1;
                    } elseif ($traffic['status'] == 4) {

                        $newArray[$key]['quality_terminateCount'] += 1;
                    } elseif ($traffic['status'] == 0 || $traffic['status'] != "") {

                        $newArray[$key]['abandonsCount'] += 1;
                    } elseif ($traffic['status'] == 5) {

                        $newArray[$key]['rejectCount'] += 1;
                    }

                    if (!empty($traffic['status'])) {

                        $newArray[$key]['startCount'] += 1;
                    }

                    $newArray[$key]['assignCount'] += 1;
                    if (isset($userUuid->uuid)) {
                        $newArray[$key]['uuid']         = $userUuid->uuid;
                    } else {
                        $newArray[$key]['uuid']         = $userUuid['uuid'];
                    }

                    // $newArray[$key]['project_code'] = $traffic['project_code'] ;
                }
            } else {
                $newArray[$key]['device_type'] = $deviceType;
                if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                    $newArray[$key]['completesCount']         = 1;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 2) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 1;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 3) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 1;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 4) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 1;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 0 || $traffic['status'] != "") {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 1;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 5) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 1;
                    //$newArray[$key]['startCount']             = 1 ;

                } else {
                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                }

                if (!empty($traffic['status'])) {

                    $newArray[$key]['startCount'] = 1;
                } else {
                    $newArray[$key]['startCount'] = 0;
                }

                $newArray[$key]['assignCount'] = 1;
                //$newArray[$key]['uuid']         = $userUuid->uuid ;
                if (isset($userUuid->uuid)) {
                    $newArray[$key]['uuid']         = $userUuid->uuid;
                } else {
                    $newArray[$key]['uuid']         = $userUuid['uuid'];
                }
                $newArray[$key]['user_id']      = $key;
                //  $newArray[$key]['project_code'] = $traffic['project_code'] ;
            }
        }

        return $newArray;
    }*/


    public function getTrafficsStatsAllUsers_OLD($fromDate = null, $toDate = null, $datePeriod = null)
    {

        // if($fromDate && $toDate){
        //     /*$trafficData = Traffic::where('source_code','SJPL')
        //                    ->where('created_at', '>=', Carbon::parse($fromDate))
        //                    ->where('created_at', '<=', Carbon::parse($toDate))
        //                    ->get();*/
        //     $trafficData = SurveyReport::where('source_code','SJPL')
        //                    ->where('createdOn', '>=', Carbon::parse($fromDate))
        //                    ->where('createdOn', '<=', Carbon::parse($toDate))
        //                    ->get()->toArray();
        // }else{
        //     /*$trafficData = Traffic::where('source_code','SJPL')
        //                     ->where('created_at', '>=',$datePeriod)
        //                     ->get();*/
        //     $trafficData = SurveyReport::where('source_code','SJPL')
        //                     ->where('createdOn', '>=',$datePeriod)
        //                    ->get()->toArray();
        // }

        /* if($fromDate && $toDate){
           
            $latestDeviceSubquery = DB::table('device_histories as dh1')
                ->select('dh1.user_id', 'dh1.device_type')
                ->whereRaw('dh1.updated_at = (
                    SELECT MAX(dh2.updated_at)
                    FROM device_histories as dh2
                    WHERE dh2.user_id = dh1.user_id
                )');

            $trafficData = UserProject::where('user_projects.updated_at', '>=', $from)
                ->where('user_projects.updated_at', '<=', $to)
                ->select('user_projects.*', 'latest_devices.device_type')
                ->leftJoinSub($latestDeviceSubquery, 'latest_devices', function ($join) {
                    $join->on('user_projects.user_id', '=', 'latest_devices.user_id');
                })
                ->get()
                ->toArray();
        }else{

            $subquery = DB::table('device_histories as dh1')
                ->select('dh1.user_id', 'dh1.device_type')
                ->whereRaw('dh1.updated_at = (
                    SELECT MAX(dh2.updated_at)
                    FROM device_histories as dh2
                    WHERE dh2.user_id = dh1.user_id
                )');
            $trafficData = UserProject::where('user_projects.updated_at', '>=', $datePeriod)
                ->select('user_projects.*', 'latest_devices.device_type')
                ->leftJoinSub($subquery, 'latest_devices', function ($join) {
                    $join->on('user_projects.user_id', '=', 'latest_devices.user_id');
                })
                ->get()
                ->toArray();
                          
        }*/

        $query = UserProject::select('user_projects.*', 'users.uuid')
            ->leftJoin('users', 'users.id', '=', 'user_projects.user_id');

        if ($fromDate && $toDate) {
            $query->whereBetween('user_projects.updated_at', [
                Carbon::parse($fromDate),
                Carbon::parse($toDate)
            ]);
        } elseif ($datePeriod) {
            $query->where('user_projects.updated_at', '>=', $datePeriod);
        }

        $trafficData = $query->get()->toArray();




        /* $mappedcollection = $trafficData->map(function($traffic, $key) {									
            $uuid = explode('_',$traffic->vvars['sjpid']);
            return [
                    'project_code'     => $traffic->project_code,
                    'project_name'     => $traffic->project_name,
                    'source_code'      => $traffic->source_code,
                    'source_name'      => $traffic->source_name,
                    'status'           => $traffic->status,
                    'status_name'      => $traffic->status_name,
                    'resp_status'      => $traffic->resp_status,
                    'resp_status_name' => $traffic->resp_status_name,
                    'uuid'             => $uuid[0]
                ];
            });*/
        /*echo "<pre>";
        print_r($mappedcollection);//die;*/


        $newArray = array();

        foreach ($trafficData as $traffic) {
            if ($traffic['user_id'] == '') {
                continue;
            }
            // $userUuid = \DB::table('users')->where('id',$traffic['user_id'])->first(['uuid']);

            $key = $traffic['user_id'];
            $deviceType = $traffic['device_type'] ?? 'Web';
            if (isset($newArray[$key])) {
                $newArray[$key]['device_type'] = $deviceType;

                if ($newArray[$key]['user_id'] === $traffic['user_id']) {

                    if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                        $newArray[$key]['completesCount'] += 1;
                    } elseif ($traffic['status'] == 2) {

                        $newArray[$key]['terminatesCount'] += 1;
                    } elseif ($traffic['status'] == 3) {

                        $newArray[$key]['quotafullCount'] += 1;
                    } elseif ($traffic['status'] == 4) {

                        $newArray[$key]['quality_terminateCount'] += 1;
                    } elseif ($traffic['status'] == 0 || $traffic['status'] != "") {

                        $newArray[$key]['abandonsCount'] += 1;
                    } elseif ($traffic['status'] == 5) {

                        $newArray[$key]['rejectCount'] += 1;
                    }

                    if (!empty($traffic['status'])) {

                        $newArray[$key]['startCount'] += 1;
                    }

                    $newArray[$key]['assignCount'] += 1;
                    /*if(isset($userUuid->uuid)){
                        $newArray[$key]['uuid']         = $userUuid->uuid ;
                    }else{
                        $newArray[$key]['uuid']         = $userUuid['uuid'] ;
                    }*/
                    $newArray[$key]['uuid']         = $traffic['uuid'];

                    // $newArray[$key]['project_code'] = $traffic['project_code'] ;
                }
            } else {
                $newArray[$key]['device_type'] = $deviceType;
                if ($traffic['status'] == 1 || $traffic['status'] == 50) {

                    $newArray[$key]['completesCount']         = 1;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 2) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 1;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 3) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 1;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 4) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 1;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 0 || $traffic['status'] != "") {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 1;
                    $newArray[$key]['rejectCount']            = 0;
                    // $newArray[$key]['startCount']             = 1 ;

                } else if ($traffic['status'] == 5) {

                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 1;
                    //$newArray[$key]['startCount']             = 1 ;

                } else {
                    $newArray[$key]['completesCount']         = 0;
                    $newArray[$key]['terminatesCount']        = 0;
                    $newArray[$key]['quotafullCount']         = 0;
                    $newArray[$key]['quality_terminateCount'] = 0;
                    $newArray[$key]['abandonsCount']          = 0;
                    $newArray[$key]['rejectCount']            = 0;
                }

                if (!empty($traffic['status'])) {

                    $newArray[$key]['startCount'] = 1;
                } else {
                    $newArray[$key]['startCount'] = 0;
                }

                $newArray[$key]['assignCount'] = 1;
                //$newArray[$key]['uuid']         = $userUuid->uuid ;

                /*if(isset($userUuid->uuid)){
                    $newArray[$key]['uuid']         = $userUuid->uuid;
                }else{
                    $newArray[$key]['uuid']         = $userUuid['uuid'];
                }*/
                $newArray[$key]['uuid']         = $traffic['uuid'];



                $newArray[$key]['user_id']      = $key;
                //  $newArray[$key]['project_code'] = $traffic['project_code'] ;
            }
        }

        return $newArray;
        /*echo '<pre>';
    print_r($newArray);die;*/

        /* $duplicateuuid = array();
        foreach($mappedcollection as $result){
            print_r($result['project_code']);

        }
        die;

        $collection1 = collect($mappedcollection);

        $source_ids = ['SJPL'];

        $data = Traffic::raw(function($collection) use ($collection1) {

            return $collection1->aggregate([
                // [
                //     '$match' => [
                //         'source_code' => [
                //             '$in' => $source_ids
                //         ],
                //         'mode' => "1"
                //     ]
                // ],
                [
                    '$group' => [
                        '_id' => '$project_code',
                        'starts' => [
                            '$sum'=> 1
                        ],
                        'completes'=> [
                            '$sum' => [
                                '$cond' => [
                                    [ '$eq' => [ '$status', 1 ] ],1,0
                                ],
                            ]
                        ],
                        'terminates'=> [
                            '$sum' => [
                                '$cond' => [
                                    [ '$eq' => [ '$status', 2 ] ],1,0
                                ],
                            ]
                        ],
                        'quotafull'=> [
                            '$sum' => [
                                '$cond' => [
                                    [ '$eq' => [ '$status', 3 ] ],1,0
                                ],
                            ]
                        ],
                        'quality_terminate'=> [
                            '$sum' => [
                                '$cond' => [
                                    [ '$eq' => [ '$status', 4 ] ],1,0
                                ],
                            ]
                        ],
                        'abandons'=> [
                            '$sum' => [
                                '$cond' => [
                                    [ '$eq' => [ '$status', 0 ] ],1,0
                                ],
                            ]
                        ],
                    ],
                ],
                
            ]);
        });

        $finalObj = [];*/

        /*https://gist.github.com/pankaj-sj/3de8adc4c1ad14288ff362149554157d*/
        //dd($data);
        //return $data;
    }


    public function getTrafficsStatsAllUsers11()
    {

        // $trafficStats = Traffic::where('source_code','SJPL')
        // ->where('status',1)
        //->groupBy('vvars')
        //    ->get();

        // foreach($trafficStats as $trafficStat){
        //     $uuids = explode('_',$trafficStat->vvars['sjpid']);
        //     $trafficStat->uuid = $uuids[0];
        // }
        $project_ids = ['14721'];
        $data = Traffic::raw(function ($collection) use ($project_ids) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'project_id' => [
                            '$in' => $project_ids
                        ],
                        'mode' => "1"
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$project_id',
                        'durationTime' => [
                            '$push' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 1]],
                                    '$duration',
                                    0
                                ],
                            ],
                        ],
                        'starts' => [
                            '$sum' => 1
                        ],
                        'completes' => [
                            '$sum' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 1]],
                                    1,
                                    0
                                ],
                            ]
                        ],
                        'terminates' => [
                            '$sum' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 2]],
                                    1,
                                    0
                                ],
                            ]
                        ],
                        'quotafull' => [
                            '$sum' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 3]],
                                    1,
                                    0
                                ],
                            ]
                        ],
                        'quality_terminate' => [
                            '$sum' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 4]],
                                    1,
                                    0
                                ],
                            ]
                        ],
                        'abandons' => [
                            '$sum' => [
                                '$cond' => [
                                    ['$eq' => ['$status', 0]],
                                    1,
                                    0
                                ],
                            ]
                        ],
                    ],
                ],
                [
                    '$sort' => [
                        'duration' => 1,
                    ],
                ],

                [
                    '$project' => [
                        '_id' => 0,
                        'id' => '$_id',
                        'durationTime' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'size' => [
                            '$size' => ['$durationTime']
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'isEvenLength' => [
                            '$eq' => [['$mod' => ['$size', 2]], 0]
                        ],
                        'middlePoint' => [
                            '$trunc' => ['$divide' => ['$size', 2]]
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'isEvenLength' => 1,
                        'middlePoint' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'beginMiddle' => [
                            '$subtract' => ['$middlePoint', 1]
                        ],
                        'endMiddle' => '$middlePoint'
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'isEvenLength' => 1,
                        'middlePoint' => 1,
                        'endMiddle' => 1,
                        'beginMiddle' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'beginValue' => [
                            '$arrayElemAt' => ['$durationTime', '$beginMiddle']
                        ],
                        'endValue' => [
                            '$arrayElemAt' => ['$durationTime', '$beginMiddle']
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'isEvenLength' => 1,
                        'middlePoint' => 1,
                        'endMiddle' => 1,
                        'beginMiddle' => 1,
                        'beginValue' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'endValue' => 1,
                        'middleSum' => [
                            '$add' => ['$beginValue', '$endValue']
                        ]
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'isEvenLength' => 1,
                        'middlePoint' => 1,
                        'beginMiddle' => 1,
                        'endMiddle' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1,
                        'median' => [
                            '$cond' => [
                                'if' => '$isEvenLength',
                                'then' => ['$divide' => ['$middleSum', 2]],
                                'else' => ['$arrayElemAt' => ['$durationTime', '$middlePoint']]
                            ],
                        ],
                    ]
                ],
                [
                    '$project' => [
                        'id' => 1,
                        'durationTime' => 1,
                        'isEvenLength' => 1,
                        'middlePoint' => 1,
                        'beginMiddle' => 1,
                        'endMiddle' => 1,
                        'median' => 1,
                        'starts' => 1,
                        'quality_terminate' => 1,
                        'abandons' => 1,
                        'quotafull' => 1,
                        'terminates' => 1,
                        'completes' => 1
                    ]
                ]

            ]);
        });
    }
}
