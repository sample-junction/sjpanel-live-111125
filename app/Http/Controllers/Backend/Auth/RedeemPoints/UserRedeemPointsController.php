<?php

namespace App\Http\Controllers\Backend\Auth\RedeemPoints;

use App\Events\Backend\Auth\User\AfterRedeemApprove;
use App\Events\Backend\Auth\User\BulkUserRedeemStatusChange;
use App\Events\Backend\Auth\User\UserRedeemRequestControl;
use App\Models\Redeem\RequestRedeem;
use App\Repositories\Inpanel\Redeem\RedeemRepository;

use App\Repositories\Frontend\Auth\UserNotificationRepository;


use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Repositories\Backend\Auth\UserRepository;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use Illuminate\Support\Facades\Response;
use App\Mail\Backend\RedeemApprove\UserRedeemRibbonNotified;
use App\Mail\Backend\RedeemApprove\UserRedeemCouponSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Mail\Frontend\UserConfirm\NotificationMail;
use App\Helpers\MailHelper;
use App\Helpers\FirebaseHelper;
use App\Models\mobileAPI\UserToken;

use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserRedeemPointsController extends Controller
{
    /**
     * @var $redeemRepo
     * @var RedeemRepository
     */
    public  $redeemRepo, $countriesCurrenciesRepository;

    /**
     * UserRedeemPointsController constructor.
     * @param RedeemRepository $redeemRepo
     */
    public function __construct(RedeemRepository $redeemRepo, UserNotificationRepository $notificationRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->redeemRepo = $redeemRepo;
        $this->notificationRepo = $notificationRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }

    /**
     * Action for showing the all the list of Redeem Points Requests
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function redeemRequest(Request $request)
    {
        $showSearchData = 0;
        $redeemRequestData = array();
        if (!empty($request->input('email'))) {
            $email = sha1($request->input('email'));

            /* $redeemRequestData = RequestRedeem::select('request_redeems.*','users.id as userid')->leftJoin("users", "users.uuid","=","request_redeems.user_uuid")
                                            ->where("users.email_hash","=",$email)
                                            ->get();*/
            /*Priyanka : 04-sep-2024*/
            $redeemRequestData = $this->redeemRepo->getredeemRequest(null, $email);
            /*Priyanka : 04-sep-2024*/
            $showSearchData = 1;
        }
        // echo '<pre>';
        // print_r($redeemRequestData);die;
        //print_r($showSearchData);
        if ($request->get('date') == 1) {
            //$get_redeem_data = RequestRedeem::where('status','=','pending')->get();
            /*Priyanka : 04-sep-2024*/
            $status = ['pending'];
            $get_redeem_data = $this->redeemRepo->getredeemRequest($status);
            /*Priyanka : 04-sep-2024*/
            $dataIds = [];
            foreach ($get_redeem_data as $ids) {
                $dataIds[] = $ids->id;
            }
            $updateUsers = RequestRedeem::whereIn('id', $dataIds)
                ->update(['status' => 'read', 'updated_at' => Carbon::now()]);
        } else {
            $status = ['pending', 'read'];

            /*Priyanka : 04-sep-2024*/
            //$get_redeem_data = RequestRedeem::whereIn('status',array('pending','read'))->get();
            $get_redeem_data = $this->redeemRepo->getredeemRequest($status);
            /*Priyanka : 04-sep-2024*/
        }
$pointsConversionMetric = config('app.points.metric.conversion');
        return view('backend.auth.redeem.redeem_points')
            ->with('redeem_data', $get_redeem_data)
            ->with('conversion_metric', $pointsConversionMetric)
            ->with('showSearchData', $showSearchData)
            ->with('redeemRequestData', $redeemRequestData);
    }
    public function redeemHistory()
    {
        /* $get_redeem_data = RequestRedeem::select('request_redeems.*', 'users.panellist_id')
            ->leftJoin('users', 'users.uuid', '=', 'request_redeems.user_uuid')
            ->where('request_redeems.status', '=', 'completed')
            ->get();*/
        /*Priyanka : 04-sep-2024*/
        $status = ['completed', 'lapsed'];
        $get_redeem_data = $this->redeemRepo->getredeemRequest($status);
        /*Priyanka : 04-sep-2024*/

        // dd($get_redeem_data);
        // echo '<pre>';
        // print_r($get_redeem_data);die;
        $pointsConversionMetric = config('app.points.metric.conversion');

        return view('backend.auth.redeem.redeem_history')
            ->with('redeem_data', $get_redeem_data)
            ->with('conversion_metric', $pointsConversionMetric);
    }



    /**
     * Action for Uploading Csv and updating status based on csv file and adding to notification.
     * @param Request $request
     * @created by RAS
     */
    public function uploadRequest(Request $request)
    {

        // echo '<pre>';
        // print_r($request->all()); die();

        $email = [];
        $status = [];
        $remindersent = [];
        $reminderdate = [];
        $campaign_name = [];
        $claim_date = [];
        $sent_date = [];
        //Reward Claimed
        $total_redeemed_points = 0;
        $redeemed_count = 0;
        //Email Delivered
        $total_requested_points = 0;
        $requested_count = 0;
        //Email Bounce
        $total_bounced_points = 0;
        $bounced_count = 0;
        //Email Opened
        $total_opened_points = 0;
        $opened_count = 0;
        //Reward Canceled
        $total_cancelled_points = 0;
        $cancelled_count = 0;
        //Reward Expired
        $total_expireded_points = 0;
        $expired_count = 0;

        $icount = 0;
        $file_columns = [];
        $user = auth()->user();

        if ($request->hasFile('csv_file')) {
            // $request -> validate([
            // 	'csv_file' => 'max:10240|required|mimes:csv',
            // ]);

            $file = $request->file('csv_file');
            $path = 'csv-files';
            $fileName = $file->getClientOriginalName();
            Storage::putFileAs($path, $file, $fileName);
            $temp = fopen($file->getRealPath(), 'r');
            while (($data = fgetcsv($temp, 1000, ",")) !== false) {
                // if($icount == 0){
                //     for($x = 0; $x < 26; $x++){
                //         $file_columns[$x] = $data[$x];
                //     }
                // }
                // echo '<pre>';
                // print_r($file_columns);die();
                $email[$icount] = $data[13];
                $status[$icount] = $data[18];
                if ($data[18] == 'Reward Claimed') {
                    $total_redeemed_points += $data[27];
                    $redeemed_count++;
                }
                if ($data[18] == 'Email Delivered') {
                    $total_requested_points += $data[27];
                    $requested_count++;
                }
                if ($data[18] == 'Email Bounce') {
                    $total_bounced_points += $data[27];
                    $bounced_count++;
                }
                if ($data[18] == 'Email Opened') {
                    $total_opened_points += $data[27];
                    $opened_count++;
                }
                if ($data[18] == 'Reward Canceled') {
                    $total_cancelled_points += $data[27];
                    $cancelled_count++;
                }
                if ($data[18] == 'Reward Expired') {
                    $total_expireded_points += $data[27];
                    $expired_count++;
                }
                $remindersent[$icount] = $data[21];
                $reminderdate[$icount] = $data[22];
                $campaign_name[$icount] = $data[15];
                $claim_date[$icount] = $data[20];
                $sent_date[$icount] = $data[1];
                $icount++;
            }
            fclose($temp);
            $data = [];
            $count_entries = count($email) - 1;
            $data[0] = 'An incentive file has been uploaded with';
            $data[1] = 'Total Records: ' . $count_entries;
            $data[2] = 'Reward Claimed: ' . $redeemed_count . '. Amount: ' . $total_redeemed_points;
            $data[3] = 'Email Delivered: ' . $requested_count . '. Amount: ' . $total_requested_points;
            $data[4] = 'Email Bounce: ' . $bounced_count . '. Amount: ' . $total_bounced_points;
            $data[5] = 'Email Opened: ' . $opened_count . '. Amount: ' . $total_opened_points;
            $data[6] = 'Reward Canceled: ' . $cancelled_count . '. Amount: ' . $total_cancelled_points;
            $data[7] = 'Reward Expired: ' . $expired_count . '. Amount: ' . $total_expireded_points;
            $recipients = ['amarjitm@samplejunction.com', 'rajann@samplejunction.com', 'adityam@samplejunction.com'];
            // $recipients = ['anshum@samplejunction.com'];	

            // echo '<pre>';
            // print_r($email);die();
            MailHelper::sendCustomMail($user, $recipients, 'Upload Success', $data);

            $i = 0;
            foreach ($email as $mail) {

                if ($i > 0) {
                    $temp_mail = sha1($mail);

                    $req_data = DB::table('request_redeems')->join('users', 'users.uuid', '=', 'request_redeems.user_uuid')
                        ->where('users.email_hash', $temp_mail)
                        ->where('request_redeems.status', 'pending')
                        ->select('request_redeems.*')
                        ->first();

                    // $user = DB::table('users')->where('uuid',$req_data->user_uuid)->first();
                    if ($req_data) {
                        $user = $this->redeemRepo->getUser($req_data->user_uuid);
                        if ($req_data->status == "pending") {

                            if ($status[$i] == 'Email Delivered') {
                                if ($req_data->coupon_sent == "") {
                                    $date = Carbon::parse($sent_date[$i]);
                                    $formatted_date = $date->format('Y-m-d H:i:s');
                                    $update_stat = DB::table('request_redeems')->where('id', '=', $req_data->id)
                                        ->update([
                                            'coupon_sent' => $formatted_date,
                                            'show_status' => config('settings.redemption_status.redeem_sent')
                                        ]);
                                    if ($update_stat) {

                                        $update = $this->redeemRepo->couponSend($user, $req_data->id);

                                        $redeem_request_points = $this->redeemRepo->getValueByRedeemId($req_data->id);
                                        $original_locale = app()->getLocale();
                                        app()->setlocale($user->locale);

                                        /* Parshant Sharma [29-08-2024] START */

                                        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
                                        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

                                        // Initialize an empty array
                                        $currencies = array();

                                        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                                            $cntry = explode('_', $countryPoint->country_language);

                                            $currencies = array(
                                                'currency_logo'  => $countryPoint->currency_symbols,
                                                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                                                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                                                'lang' => $cntry[1],
                                            );
                                        }

                                        if ($currencies['lang'] != 'UK') {
                                            $redeem_request_points = $redeem_request_points;
                                        } else {

                                            $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
                                        }

                                        if ($redeem_request_points < 1) {
                                            $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                            //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                                            $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
                                        } else {
                                            //$red_rqst_val = $redeem_request_points .' $';
                                            //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                                            $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
                                        }


                                        /* Parshant Sharma [29-08-2024] END */


                                        $msg = __('frontend.notification_txt.redeem_rqst_coupon_sent_1') . $red_rqst_val . __('frontend.notification_txt.redeem_rqst_coupon_sent_2');






                                        $coupon_sent = $this->notificationRepo->createNotification($req_data->user_uuid, 'Redeem Request', $req_data->id, $msg);


                                        app()->setlocale($original_locale);
                                    }
                                } else {

                                    if ($reminderdate[$i] != '' && $remindersent[$i] != '') {
                                        if ($remindersent[$i] != $req_data->reminder_count) {
                                            $rem_date = Carbon::parse($reminderdate[$i]);
                                            $formatted__rem_date = $rem_date->format('Y-m-d H:i:s');

                                            $update_reminder = DB::table('request_redeems')->where('id', '=', $req_data->id)
                                                ->update([
                                                    'reminder_sent' => $formatted__rem_date,
                                                    'reminder_count' => $remindersent[$i]
                                                ]);
                                            if ($update_reminder) {
                                                $original_locale = app()->getLocale();
                                                app()->setlocale($user->locale);
                                                if ($remindersent[$i] == '1') {
                                                    $reminder_count = '1<sup>st</sup>';
                                                } else if ($remindersent[$i] == '2') {
                                                    $reminder_count = '2<sup>nd</sup>';
                                                } else if ($remindersent[$i] == '3') {
                                                    $reminder_count = '3<sup>rd</sup>';
                                                }
                                                $redeem_request_points = $this->redeemRepo->getValueByRedeemId($req_data->id);

                                                /* Parshant Sharma [29-08-2024] START */


                                                $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
                                                $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

                                                // Initialize an empty array
                                                $currencies = array();

                                                if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                                                    $cntry = explode('_', $countryPoint->country_language);

                                                    $currencies = array(
                                                        'currency_logo'  => $countryPoint->currency_symbols,
                                                        'currency_denom_singular' => $countryPoint->currency_denom_singular,
                                                        'currency_denom_plural' => $countryPoint->currency_denom_plural,
                                                        'lang' => $cntry[1],
                                                    );
                                                }

                                                // if ($currencies['lang'] != 'UK') {
                                                //     $redeem_request_points = $redeem_request_points;
                                                // } else {

                                                //     $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
                                                // }
                                                $redeem_request_points = $redeem_request_points;

                                                if ($redeem_request_points < 1) {
                                                    $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                                    //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                                                    $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
                                                } else {
                                                    //$red_rqst_val = $redeem_request_points .' $';
                                                    //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                                                    $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
                                                }

                                                /*  $redeem_request_points = $this->redeemRepo->getValueByRedeemId($req_data->id);
													if($redeem_request_points < 1){
														$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents');
													}else{
														$red_rqst_val = $redeem_request_points .' $';
													} */

                                                /* Parshant Sharma [29-08-2024] END */

                                                if ($user->locale == 'hi_IN') {
                                                    $reminder_value = '';
                                                    if ($remindersent[$i] == '1') {
                                                        $reminder_value = 'frontend.notification_txt.first';
                                                    } elseif ($remindersent[$i] == '2') {
                                                        $reminder_value = 'frontend.notification_txt.second';
                                                    } elseif ($remindersent[$i] == '3') {
                                                        $reminder_value = 'frontend.notification_txt.third';
                                                    }

                                                    // Define translation keys for Hindi message
                                                    $msg_keys = [
                                                        'start' => 'frontend.notification_txt.redeem_rqst_reminder_1',
                                                        'mid'   => $reminder_value,
                                                        'end'   => 'frontend.notification_txt.redeem_rqst_reminder_2',
                                                    ];

                                                    $notificationData = [
                                                        'keys' => $msg_keys,
                                                        'red_rqst_val' => $red_rqst_val,
                                                    ];
                                                } else {
                                                    // Define translation keys for English message
                                                    $reminder_value = '';
                                                    if ($remindersent[$i] == '1') {
                                                        $reminder_value = 'frontend.notification_txt.first';
                                                    } elseif ($remindersent[$i] == '2') {
                                                        $reminder_value = 'frontend.notification_txt.second';
                                                    } elseif ($remindersent[$i] == '3') {
                                                        $reminder_value = 'frontend.notification_txt.third';
                                                    }
                                                    $msg_keys = [
                                                        'start' => 'frontend.notification_txt.redeem_rqst_reminder_1',
                                                        'mid'   => $reminder_value,
                                                        'end'   => 'frontend.notification_txt.redeem_rqst_reminder_2',
                                                    ];

                                                    $notificationData = [
                                                        'keys' => $msg_keys,
                                                        'red_rqst_val' => $red_rqst_val,
                                                        'reminderCount' => $reminder_count,
                                                    ];
                                                }

                                                $reminder_sent = $this->notificationRepo->createNotification($req_data->user_uuid, 'Redeem Request', $req_data->id, json_encode($notificationData), 'Redeem Reminder');

                                                app()->setlocale($original_locale);
                                                if ($user->locale == 'hi_IN') {
                                                    $reminder_value = '';
                                                    if ($remindersent[$i] == '1') {
                                                        $reminder_value = __("frontend.notification_txt.first");
                                                    } elseif ($remindersent[$i] == '2') {
                                                        $reminder_value = __("frontend.notification_txt.second");
                                                    } elseif ($remindersent[$i] == '3') {
                                                        $reminder_value = __("frontend.notification_txt.third");
                                                    }
                                                    $msg = $red_rqst_val . __('frontend.notification_txt.redeem_rqst_reminder_1') . $reminder_value . __('frontend.notification_txt.redeem_rqst_reminder_2');
                                                } else {
                                                    $msg = $reminder_count . __('frontend.notification_txt.redeem_rqst_reminder_1') . $red_rqst_val . __('frontend.notification_txt.redeem_rqst_reminder_2');
                                                }
                                                $userToken = UserToken::where('user_id', $user->id)->value('device_token');
                                                $title = "SJ Panel";
                                                $body = strip_tags($msg);
                                                if (!empty($userToken)) {
                                                    FirebaseHelper::sendNotification(
                                                        $userToken,
                                                        $title,
                                                        $body,
                                                        [
                                                            'type' => 'Redeem Reminder'
                                                        ]
                                                    );
                                                }
                                            }
                                        }
                                    }
                                }
                            } else if ($status[$i] == 'Reward Claimed') {

                                $date = Carbon::parse($sent_date[$i]);
                                $formatted_date = $date->format('Y-m-d H:i:s');

                                $completed_QR =  DB::table('request_redeems')->where('id', '=', $req_data->id)
                                    ->update([
                                        'coupon_redeemed' => $formatted_date,
                                        'status' => 'completed',
                                        'show_status' => config('settings.redemption_status.redeem_coupon')
                                    ]);

                                if ($completed_QR) {
                                    //     $user = $this->redeemRepo->getUser($req_data->user_uuid);
                                    //     $update =  $this->redeemRepo->couponRedeem($user,$req_data->id);
                                    //         echo '<pre>';
                                    // print_r($update);die();
                                    // if($update){
                                    $redeem_request_points = $this->redeemRepo->getValueByRedeemId($req_data->id);
                                    $original_locale = app()->getLocale();
                                    app()->setlocale($user->locale);

                                    /* Parshant Sharma [29-08-2024] START */

                                    $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
                                    $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

                                    // Initialize an empty array
                                    $currencies = array();

                                    if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                                        $cntry = explode('_', $countryPoint->country_language);

                                        $currencies = array(
                                            'currency_logo'  => $countryPoint->currency_symbols,
                                            'currency_denom_singular' => $countryPoint->currency_denom_singular,
                                            'currency_denom_plural' => $countryPoint->currency_denom_plural,
                                            'lang' => $cntry[1],
                                        );
                                    }

                                    if ($currencies['lang'] != 'UK') {
                                        $redeem_request_points = $redeem_request_points;
                                    } else {

                                        $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
                                    }

                                    if ($redeem_request_points < 1) {
                                        $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                                        //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                                        $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
                                    } else {
                                        //$red_rqst_val = $redeem_request_points .' $';
                                        $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
                                    }

                                    /* if($redeem_request_points < 1){
												$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents');
											}else{
												$red_rqst_val = $redeem_request_points .' $';
											} */

                                    /* Parshant Sharma [29-08-2024] END */


                                    $msg = $red_rqst_val . '' . __('frontend.notification_txt.redeem_rqst_coupon_redeem_1');





                                    $this->notificationRepo->createNotification($req_data->user_uuid, 'Redeem Request', $req_data->id, $msg, 'Coupon Redeemed');


                                    app()->setlocale($original_locale);
                                    // }
                                    $userToken = UserToken::where('user_id', $user->id)->value('device_token');
                                    $title = "SJ Panel";
                                    $body = strip_tags($msg);
                                    if (!empty($userToken)) {
                                        FirebaseHelper::sendNotification(
                                            $userToken,
                                            $title,
                                            $body,
                                            [
                                                'type' => 'Coupon Redeemed'
                                            ]
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                $i++;
            }



            // echo '<pre>';
            // print_r($req_data); die();

            return \Redirect::back()
                ->withFlashSuccess("File has been Successfully Uploaded");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Some Error Occurred");
        }
    }
    /**
     * Action for Approving the Redeem Request.
     * @param Request $request
     * @return mixed
     */
    public function approveRequest(Request $request)
    {
        $redeem_request_id = $request->redeem_id;
        $user_uuid = $request->user_uuid;

        $user = $this->redeemRepo->getUser($user_uuid);
        //dd($user);
        $update = $this->redeemRepo->approveRedeemPoints($user, $redeem_request_id);
        /*event(new UserRedeemRequestControl($user, $redeem_request_id));*/
        /* event(new AfterRedeemApprove($user));*/
        if ($update) {
            //update notification table
            //Your redeem request for 200 Points (20 redeem_rqst_cents) has been approved 
            $original_locale = app()->getLocale();
            app()->setlocale($user->locale);
            $redeem_request_points = $this->redeemRepo->getValueByRedeemId($redeem_request_id);
            // $red_rqst_pts = $redeem_request_points * 1000;

            /* Parshant Sharma [29-08-2024] START */

            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
            /* Anil Sharma [29-10-2024]*/


            // Initialize an empty array
            $currencies = array();

            if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                $cntry = explode('_', $countryPoint->country_language);

                $currencies = array(
                    'currency_logo'  => $countryPoint->currency_symbols,
                    'currency_denom_singular' => $countryPoint->currency_denom_singular,
                    'currency_denom_plural' => $countryPoint->currency_denom_plural,
                    'lang' => $cntry[1],
                );
            }
            if ($currencies['lang'] == 'IN') {
                $red_rqst_pts = $redeem_request_points * $countryPoints;
            } elseif ($currencies['lang'] == 'AU') {
                $result = $redeem_request_points * $countryPoints;
                $red_rqst_pts = floor($result / 1000) * 1000;
            } elseif ($currencies['lang'] == 'CA') {
                $result = $redeem_request_points * $countryPoints;
                $red_rqst_pts = floor($result / 1000) * 1000;
            } elseif ($currencies['lang'] == 'UK') {
                $result = $redeem_request_points * $countryPoints;
                $red_rqst_pts = round($result, -3);
            } else {
                $red_rqst_pts = $redeem_request_points * 1000;
            }
            $redeem_request_points = $redeem_request_points;

            if ($redeem_request_points < 1) {
                $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
            } else {
                //$red_rqst_val = $redeem_request_points .' $';
                //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
            }

            /* if($redeem_request_points < 1){
					$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
				}else{
					$red_rqst_val = $redeem_request_points .' $';
				} */

            /* Parshant Sharma [29-08-2024] END */

            // $msg = __('frontend.notification_txt.redeem_rqst_approve_1').$red_rqst_pts. __('frontend.notification_txt.redeem_rqst_point').'('.$red_rqst_val.')'. __('frontend.notification_txt.redeem_rqst_approve_2');
            $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_approve_2');
            // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
            $msg_keys = [
                'single' => 'frontend.notification_txt.redeem_rqst_approve_2'
            ];
            $update_notification = $this->notificationRepo->createNotification($user_uuid, 'Redeem Request', $redeem_request_id, json_encode([
                'keys' => $msg_keys,
                'red_rqst_val' => $red_rqst_val
            ]), 'Redemption Approved');
            // Ending Vikas

            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Redemption Approved'
                    ]
                );
            }

            app()->setlocale($original_locale);
            return \Redirect::back()
                ->withFlashSuccess("Redeem Request has been Successfully Accepted");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Some Error Occurred");
        }
    }


    /**
     * Action for displaying all the Redeem Points Request by Data Table.
     * @return array
     */
    public function dataTable()
    {


        $statuses = ['pending', 'read'];
        try {
            return Laratables::recordsOf(RequestRedeem::class, function ($query) use ($statuses) {
                return $query->select(
                    'users.uuid',
                    'users.panellist_id',
                    'users.locale',
                    'request_redeems.*',
                    'country_points.currency_symbols',
                    'country_points.points',
                    // Join Added by Vikas for tracking Platform(Code Starting)
                    DB::raw("
                            CASE
                                WHEN user_platform_actions.platform IS NULL OR user_platform_actions.platform = ''
                                THEN '-'
                                ELSE CONCAT(UPPER(LEFT(user_platform_actions.platform, 1)), LOWER(SUBSTRING(user_platform_actions.platform, 2)))
                            END as device_type
                        ")
                    // Code Ending
                )

                    ->leftJoin('users', 'users.uuid', '=', 'request_redeems.user_uuid')
                    ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                    ->leftJoin('country_points', DB::raw('CONVERT(country_points.country_language USING utf8mb4)'), '=', DB::raw('CONVERT(users.locale USING utf8mb4)'))
                    // Join Added by Vikas for tracking Platform(Code Starting)
                    ->leftJoin('user_platform_actions', function ($join) {
                        $join->on('users.uuid', '=', 'user_platform_actions.user_uuid')
                            ->where('user_platform_actions.action_type', '=', 'redemption_request')
                            ->whereColumn('request_redeems.id', 'user_platform_actions.action_id');
                    })
                    // Code Ending
                    ->where('model_has_roles.model_type', 'App\Models\Auth\User')
                    ->where('model_has_roles.role_id', '4')
                    ->whereIn('request_redeems.status', $statuses)
                    ->orderBy('request_redeems.created_at', 'DESC');
            });
        } catch (\Exception $e) {
            \Log::error('Redeem DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * 7 july 2022 by dushyant dogra for redeem history
     * Action for displaying all the Redeem history Request by Data Table.
     * @return array
     */
    public function dataTableRedeemHistory()
    {
        return Laratables::recordsOf(RequestRedeem::class, function ($query) {
            return $query->whereIn('status', ['completed', 'lapsed'])->orderBy('created_at', 'DESC');
        });
    }

    /**
     * Action for Ribbon Notifying the redeem request.
     * @param Request $request
     * @return mixed
     */
    public function ribbonNotified(Request $request)
    {
        // $val = \Crypt::encrypt('virenk@samplejunction.com');
        // dd($val);
        $redeem_request_id = $request->redeem_id;
        $user_uuid = $request->user_uuid;
        $user = $this->redeemRepo->getUser($user_uuid);
        $update =   $this->redeemRepo->ribbonNotified($user, $redeem_request_id);
        if ($update) {
            /**
             * Email send user
             *  $email = new UserRedeemRibbonNotified($user);Mail::send($email);
             */
            $original_locale = app()->getLocale();
            app()->setlocale($user->locale);
            $redeem_request_points = $this->redeemRepo->getValueByRedeemId($redeem_request_id);

            /* Parshant Sharma [29-08-2024] START */

            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

            // Initialize an empty array
            $currencies = array();

            if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                $cntry = explode('_', $countryPoint->country_language);

                $currencies = array(
                    'currency_logo'  => $countryPoint->currency_symbols,
                    'currency_denom_singular' => $countryPoint->currency_denom_singular,
                    'currency_denom_plural' => $countryPoint->currency_denom_plural,
                    'lang' => $cntry[1],
                );
            }

            // if ($currencies['lang'] != 'UK') {
            //     $redeem_request_points = $redeem_request_points;
            // } else {

            //     $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
            // }
            $redeem_request_points = $redeem_request_points;

            if ($redeem_request_points < 1) {
                $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
            } else {
                //$red_rqst_val = $redeem_request_points .' $';
                //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
            }

            /* if($redeem_request_points < 1){
                $red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents');
            }else{
                $red_rqst_val = $redeem_request_points .' $';
            } */

            /* Parshant Sharma [29-08-2024] END */


            // $msg = __('frontend.notification_txt.redeem_rqst_sent_to_rybbon_1').$red_rqst_val . __('frontend.notification_txt.redeem_rqst_sent_to_rybbon_2');
            $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_sent_to_rybbon_2');

            // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
            $msg_keys = [
                'single' => 'frontend.notification_txt.redeem_rqst_sent_to_rybbon_2'
            ];
            $rybbon_notified = $this->notificationRepo->createNotification($user_uuid, 'Redeem Request', $redeem_request_id, json_encode([
                'keys' => $msg_keys,
                'red_rqst_val' => $red_rqst_val
            ]), 'Redeem Status');
            // Ending Vikas

            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Redeem Status'
                    ]
                );
            }
            app()->setlocale($original_locale);
            return \Redirect::back()
                ->withFlashSuccess("Ribbon  has been notified");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Request is not yet Approved");
        }
    }

    /**
     * Action for Coupon Sending to Ribbon.
     * @param Request $request
     * @return mixed
     */
    public function couponSend(Request $request)
    {
        $redeem_request_id = $request->redeem_id;
        $user_uuid = $request->user_uuid;
        $user = $this->redeemRepo->getUser($user_uuid);
        $update = $this->redeemRepo->couponSend($user, $redeem_request_id);
        if ($update) {
            /**
             * Email send user
             *  $email = new UserRedeemCouponSend($user);Mail::send($email);
             *  
             */
            $original_locale = app()->getLocale();
            app()->setlocale($user->locale);
            $redeem_request_points = $this->redeemRepo->getValueByRedeemId($redeem_request_id);

            /* Parshant Sharma [29-08-2024] START */


            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

            // Initialize an empty array
            $currencies = array();

            if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                $cntry = explode('_', $countryPoint->country_language);
                $currencies = array(
                    'currency_logo'  => $countryPoint->currency_symbols,
                    'currency_denom_singular' => $countryPoint->currency_denom_singular,
                    'currency_denom_plural' => $countryPoint->currency_denom_plural,
                    'lang' => $cntry[1],
                );
            }

            // if ($currencies['lang'] != 'UK') {
            //     $redeem_request_points = $redeem_request_points;
            // } else {

            //     $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
            // }
            $redeem_request_points = $redeem_request_points;

            if ($redeem_request_points < 1) {
                $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
            } else {
                //$red_rqst_val = $redeem_request_points .' $';
                //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
            };
            /*	if($redeem_request_points < 1){
					$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
				}else{
					$red_rqst_val = $redeem_request_points .' $';
				} */

            /* Parshant Sharma [29-08-2024] END */

            // $msg = __('frontend.notification_txt.redeem_rqst_coupon_sent_1').$red_rqst_val . __('frontend.notification_txt.redeem_rqst_coupon_sent_2');
            $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_coupon_sent_2');

            // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
            $msg_keys = [
                'single' => 'frontend.notification_txt.redeem_rqst_coupon_sent_2'
            ];
            $coupon_sent = $this->notificationRepo->createNotification($user_uuid, 'Redeem Request', $redeem_request_id, json_encode([
                'keys' => $msg_keys,
                'red_rqst_val' => $red_rqst_val
            ]), 'Redeem Status');
            // Ending Vikas

            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Redeem Status'
                    ]
                );
            }
            app()->setlocale($original_locale);
            return \Redirect::back()
                ->withFlashSuccess("“Coupon sent” Status has been updated");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Request is not yet Approved");
        }
    }

    /**
     * Action for Coupon Redeem Points
     * @param Request $request
     * @return mixed
     */
    public function couponRedeem(Request $request)
    {
        $redeem_request_id = $request->redeem_id;
        $user_uuid = $request->user_uuid;
        $user = $this->redeemRepo->getUser($user_uuid);
        $update =  $this->redeemRepo->couponRedeem($user, $redeem_request_id);
        if ($update) {
            event(new UserRedeemRequestControl($user, $redeem_request_id));
            $original_locale = app()->getLocale();
            app()->setlocale($user->locale);
            $redeem_request_points = $this->redeemRepo->getValueByRedeemId($redeem_request_id);

            /* Parshant Sharma [29-08-2024] START */

            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

            // Initialize an empty array
            $currencies = array();

            if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                $cntry = explode('_', $countryPoint->country_language);

                $currencies = array(
                    'currency_logo'  => $countryPoint->currency_symbols,
                    'currency_denom_singular' => $countryPoint->currency_denom_singular,
                    'currency_denom_plural' => $countryPoint->currency_denom_plural,
                    'lang' => $cntry[1],
                );
            }

            // if ($currencies['lang'] != 'UK') {
            //     $redeem_request_points = $redeem_request_points;
            // } else {

            //     $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
            // }
            $redeem_request_points = $redeem_request_points;

            if ($redeem_request_points < 1) {
                $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
            } else {
                //$red_rqst_val = $redeem_request_points .' $';
                //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
            }
            /* if($redeem_request_points < 1){
					$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents');
				}else{
					$red_rqst_val = $redeem_request_points .' $';
				} */

            /* Parshant Sharma [29-08-2024] END */
            /* Anil Sharma [29-10-2024] Start */
            if ($currencies['lang'] == 'IN') {
                $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_coupon_redeem_1');
            } else {
                $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_coupon_redeem_1');
            }
            /* Anil Sharma [29-10-2024] End */

            // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
            $msg_keys = [
                'single' => 'frontend.notification_txt.redeem_rqst_coupon_redeem_1'
            ];
            $coupon_redeemed = $this->notificationRepo->createNotification($user_uuid, 'Redeem Request', $redeem_request_id, json_encode([
                'keys' => $msg_keys,
                'red_rqst_val' => $red_rqst_val
            ]), 'Coupon Redeemed');
            // Ending Vikas


            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            // if (!empty($userToken)) {
            //     FirebaseHelper::sendNotification(
            //         $userToken,
            //         $title,
            //         $body,
            //         [
            //             'type' => 'Coupon Redeemed'
            //         ]
            //     );
            // }

            app()->setlocale($original_locale);
            //event(new AfterRedeemApprove($user,$redeem_request));
            return \Redirect::back()
                ->withFlashSuccess("Coupon has been redeemed");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Request is not yet Approved");
        }
    }

    public function approveAllSelected(Request $request)
    {
        $id = $request->input('id', false);
        $change_status = $request->input('change_status', false);
        $pointsConversionMetric = config('app.points.metric.conversion');

        // echo '<pre>';
        // print_r(__('frontend.notification_txt.redeem_rqst_sent_to_rybbon_1'));die();
        if (!empty($id)) {
            $count = count($id);

            for ($i = 0; $i < $count; $i++) {

                event(new BulkUserRedeemStatusChange($id[$i], $change_status));

                // echo '<pre>';
                // print_r($change_status);die();
                $redeem_request_details = $this->redeemRepo->getRedeemRequestDetails($id[$i]);
                $user_rq = DB::table('users')->where('uuid', $redeem_request_details->user_uuid)->first();
                // echo '<pre>';
                // print_r($user_rq);die();
                $original_locale = app()->getLocale();
                app()->setlocale($user_rq->locale);
                $redeem_request_points = $redeem_request_details->redeem_points * $pointsConversionMetric;
                $red_rqst_pts = $redeem_request_points * 1000;

                /* Parshant Sharma [29-08-2024] START */
                $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user_rq->locale);
                $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

                // Initialize an empty array
                $currencies = array();

                if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                    $cntry = explode('_', $countryPoint->country_language);

                    $currencies = array(
                        'currency_logo'  => $countryPoint->currency_symbols,
                        'currency_denom_singular' => $countryPoint->currency_denom_singular,
                        'currency_denom_plural' => $countryPoint->currency_denom_plural,
                        'lang' => $cntry[1],
                    );
                }

                if ($currencies['lang'] != 'UK') {
                    $redeem_request_points = $redeem_request_points;
                } else {

                    $redeem_request_points = ($redeem_request_points * 1000) / $countryPoints;
                }

                if ($redeem_request_points < 1) {
                    $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                    //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                    $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
                } else {
                    //$red_rqst_val = $redeem_request_points .' $';
                    //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                    $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
                }
                /* if($redeem_request_points < 1){
						$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
					}else{
						$red_rqst_val = $redeem_request_points .' $';
					} */

                /* Parshant Sharma [29-08-2024] END */


                // $msg = __('frontend.notification_txt.redeem_rqst_coupon_redeem_1').$red_rqst_val . '.';

                if ($change_status == 'approve') {
                    $msg = __('frontend.notification_txt.redeem_rqst_approve_1') . $red_rqst_pts . __('frontend.notification_txt.redeem_rqst_point') . '(' . $red_rqst_val . ')' . __('frontend.notification_txt.redeem_rqst_approve_2');
                } else if ($change_status == 'ribbon_notified') {
                    $msg = __('frontend.notification_txt.redeem_rqst_sent_to_rybbon_1') . $red_rqst_val . __('frontend.notification_txt.redeem_rqst_sent_to_rybbon_2');
                } else if ($change_status == 'coupon_send') {
                    $msg = __('frontend.notification_txt.redeem_rqst_coupon_sent_1') . $red_rqst_val . __('frontend.notification_txt.redeem_rqst_coupon_sent_2');
                } else if ($change_status == 'coupon_redeem') {
                    $msg = __('frontend.notification_txt.redeem_rqst_coupon_redeem_1') . $red_rqst_val . '.';
                }




                $this->notificationRepo->createNotification($redeem_request_details->user_uuid, 'Redeem Request', $id[$i], $msg);


                app()->setlocale($original_locale);
            }

            return \Redirect::back()
                ->withFlashSuccess("Status has been Changed");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Request not selectd");
        }
    }

    /****
     * Export Request Redeem Data
     **/
    public function exportReedemRequest(Request $request)
    {

        //echo "<pre>";
        $redeemIds = explode(',', $request->get('exportIds'));

        /*print_r($redeemIds);
        $redeemRequests = RequestRedeem::whereIn('id',$redeemIds)->with('user')->get();
        print_r($redeemRequests);
        exit;*/
        $date = date("d-m-Y");

        $file_name = 'SJ Panel Reedem Request ' . $date;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$file_name}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $redeemRequests = RequestRedeem::whereIn('id', $redeemIds)->whereNotNull('approve')->whereNull('coupon_sent')->whereNull('ribbon_notified')->whereNull('coupon_redeemed')->with('user')->get();
        //$redeemRequests = RequestRedeem::with('user')->get();
        // echo '<pre>';
        // print_r($redeemRequests[0]->user['panellist_id']);die;
        //$redeemRequests = RequestRedeem::where('status','=','pending')->get();
        //$columns = array('User Id', 'Panellist Id', 'First Name', 'Last Name','Email' ,'Value($)','Requested Date','Download Date');

        if (count($redeemRequests) != count($redeemIds)) {
            return \Redirect::back()
                ->withFlashDanger("Please remove already downloaded entry and retry");
        }

        $columns = array('First Name', 'Last Name', 'Email', 'Company', 'Value');

        $callback = function () use ($redeemRequests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($redeemRequests as $row) {
                $dataValue = array(
                    // $row->user_uuid, 
                    // $row->user['panellist_id'], 
                    $row->user['first_name'],
                    $row->user['last_name'],
                    $row->user['email'],
                    "",
                    //$row->redeem_points*config('app.points.metric.conversion') 
                    number_format(($row->redeem_points / $row->country_points), 2)

                    // $row->created_at,
                    // date("d-m-Y")
                );

                fputcsv($file, $dataValue);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Action for Coupon Lapsed Points
     * @param Request $request
     * @return mixed
     */
    public function couponLapsed(Request $request)
    {
        $redeem_request_id = $request->redeem_id;
        $user_uuid = $request->user_uuid;
        $user = $this->redeemRepo->getUser($user_uuid);
        $update =  $this->redeemRepo->couponLapsed($user, $redeem_request_id);
        if ($update) {
            event(new UserRedeemRequestControl($user, $redeem_request_id));
            $original_locale = app()->getLocale();
            app()->setlocale($user->locale);
            $redeem_request_points = $this->redeemRepo->getValueByRedeemId($redeem_request_id);

            /* Parshant Sharma [29-08-2024] START */

            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

            // Initialize an empty array
            $currencies = array();

            if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

                $cntry = explode('_', $countryPoint->country_language);

                $currencies = array(
                    'currency_logo'  => $countryPoint->currency_symbols,
                    'currency_denom_singular' => $countryPoint->currency_denom_singular,
                    'currency_denom_plural' => $countryPoint->currency_denom_plural,
                    'lang' => $cntry[1],
                );
            }

            /* Code Commented by Vikas[29-03-2025] START */
            // if($currencies['lang'] != 'UK'){
            $redeem_request_points = $redeem_request_points;
            // }else{

            //     $redeem_request_points = ($redeem_request_points*1000)/$countryPoints;
            // }
            /* Vikas[29-03-2025] END */

            if ($redeem_request_points < 1) {
                $currency = (($redeem_request_points * 100) > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                //$red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents'); 
                $red_rqst_val = $redeem_request_points * 100 . ' ' . __($currency);
            } else {
                //$red_rqst_val = $redeem_request_points .' $';
                //$red_rqst_val = $redeem_request_points .' '.$currencies['currency_logo'];
                $red_rqst_val = $currencies['currency_logo'] . number_format($redeem_request_points, 2);
            }
            /* if($redeem_request_points < 1){
                    $red_rqst_val = $redeem_request_points*100 .' '.__('frontend.notification_txt.redeem_rqst_cents');
                }else{
                    $red_rqst_val = $redeem_request_points .' $';
                } */
            /* Parshant Sharma [29-08-2024] END */
            /* Anil Sharma [29-10-2024] Start */

            if ($currencies['lang'] == 'IN') {
                // $msg = __('frontend.notification_txt.redeem_rqst_coupon_redeem_1') . ' ' . $red_rqst_val;
                $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_coupon_lapsed');
            } else {
                // $msg = __('frontend.notification_txt.redeem_rqst_coupon_redeem_1').$red_rqst_val . '.';
                $msg = $red_rqst_val . ' ' . __('frontend.notification_txt.redeem_rqst_coupon_lapsed');
            }

            /* Anil Sharma [29-10-2024] End */

            // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
            $msg_keys = [
                'single' => 'frontend.notification_txt.redeem_rqst_coupon_lapsed'
            ];
            
            $coupon_redeemed = $this->notificationRepo->createNotification($user_uuid, 'Redeem Request', $redeem_request_id, json_encode([
                'keys' => $msg_keys,
                'red_rqst_val' => $red_rqst_val
            ]), 'Coupon lapsed');
            // Ending Vikas


            $userToken = UserToken::where('user_id', $user->id)->value('device_token');
            $title = "SJ Panel";
            $body = strip_tags($msg);
            if (!empty($userToken)) {
                FirebaseHelper::sendNotification(
                    $userToken,
                    $title,
                    $body,
                    [
                        'type' => 'Coupon lapsed'
                    ]
                );
            }

            app()->setlocale($original_locale);
            //event(new AfterRedeemApprove($user,$redeem_request));
            return \Redirect::back()
                ->withFlashSuccess("Coupon has been redeemed");
        } else {
            return \Redirect::back()
                ->withFlashDanger("Request is not yet Approved");
        }
    }
}
