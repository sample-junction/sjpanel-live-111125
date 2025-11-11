<?php

/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 12:46 AM
 */

namespace App\Repositories\Inpanel\Redeem;


use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Redeem\RequestRedeem;
use App\Models\UserPlatformAction;
use App\Mail\Backend\RedeemApprove\UserRedeemRibbonNotified;
use App\Mail\Backend\RedeemApprove\UserRedeemCouponSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Redeem\RedeemBankRequest;

/**
 * This repository class is used to create redeem request, approve redeem request, coupon sent, ribbon notified, coupon redeem
 *
 * Class RedeemRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\Redeem\RedeemRepository
 */

class RedeemRepository
{

    /**
     * This action is used for creating the Redeem Request row for the requested User.
     *
     * @param $user_uuid
     * @param $total_points
     * @param $redeem_data
     * @return mixed
     */
    public function createRedeemRequest($user_uuid, $total_points, $redeem_data)
    {
        $redeem_data['total_points'] = $total_points;
        $redeem_data['user_uuid']    = $user_uuid;
        $redeem_data['show_status']  = config('settings.redemption_status.redeem_request');
        $create = RequestRedeem::create($redeem_data);
        return $create;
    }

    /**
     * This action ios used for deleting the Redeem Request
     * @added by RAS
     * @param $user_uuid
     */
    public function deleteRedeemRequest($user_uuid)
    {
        $request = RequestRedeem::where('user_uuid', $user_uuid)->orderBy('created_at', 'desc')->first();

        // Platform Tracking code added by Vikas(Code Starting)
        $platform = UserPlatformAction::where('user_uuid', $user_uuid)->where('action_id', $request->id)->first();
        // Platform Tracking (Code Ending)
        if ($platform) {
            $platform->delete();
        }
        if ($request) {
            $request->delete();
        }
    }

    /**
     * This action ios used for getting the User Details
     *
     * @param $user_uuid
     * @return mixed
     */
    public function getUser($user_uuid)
    {
        $get_user = User::where('uuid', '=', $user_uuid)->first();
        return $get_user;
    }

    /**
     * This action is used for approving the redeem points
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */
    public function approveRedeemPoints($user, $redeem_request_id)
    {
        $get_user_redeem_request = $this->getRedeemRequestDetails($redeem_request_id);
        if (!$get_user_redeem_request->approve) {
            $update_approve_request = RequestRedeem::where('id', '=', $redeem_request_id)
                ->where('user_uuid', '=', $user->uuid)
                ->update(['approve' => date('Y-m-d H:i:s'), 'show_status' => config('settings.redemption_status.redeem_approved')]);
            return true;
        }
        return false;
    }

    /**
     * This action is used for getting the value of metric Conversion of Requested Redeem Points
     *
     * @param $redeem_id
     * @return float|int
     */
    public static function getValueByRedeemId_OLD($redeem_id)
    {
        $pointsConversionMetric = config('app.points.metric.conversion');
        $redeem_request_details = RequestRedeem::where('id', '=', $redeem_id)->first();
        $current_value = $redeem_request_details->redeem_points * $pointsConversionMetric;
        return $current_value;
    }

    /**
     * Function Name : getredeemRequest
     * Created By : Priyanka(04-sep-2024)
     * */
    public static function getValueByRedeemId($redeem_id)
    {
        // Get the points conversion metric from config
        $pointsConversionMetric = config('app.points.metric.conversion');

        // Fetch redeem request details
        $redeem_request_details = RequestRedeem::where('id', $redeem_id)->first();

        // Handle case where redeem request is not found
        if (!$redeem_request_details) {
            return null; // Or handle error appropriately
        }

        // Fetch country point details
        $country_point = User::select('country_points.currency_symbols', 'country_points.points')
            ->leftJoin('request_redeems', 'request_redeems.user_uuid', '=', 'users.uuid')
            ->leftJoin('country_points', DB::raw('CONVERT(country_points.country_language USING utf8mb4)'), '=', DB::raw('CONVERT(users.locale USING utf8mb4)'))
            ->where('users.uuid', $redeem_request_details->user_uuid)
            ->first();

        if (!empty($country_point)) {
            // Determine the currency symbol
            $symbol = ($country_point->currency_symbols == 'CAD') ? $country_point->currency_symbols . ' ' : $country_point->currency_symbols;

            // Calculate value
            $points = $country_point->points;
            $value = round($redeem_request_details->redeem_points / $points, 2);
            $current_value = $value;
        } else {
            // Fallback calculation if country_point data is not available
            $current_value = $redeem_request_details->redeem_points * $pointsConversionMetric;
        }

        return $current_value;
    }

    /**
     * This action for sending the coupon to Ribbon
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */
    public function couponSend($user, $redeem_request_id)
    {
        $redeem_request_details = $this->getRedeemRequestDetails($redeem_request_id);
        $get_user_redeem_request = RequestRedeem::select('ribbon_notified', 'approve')->where('id', '=', $redeem_request_id)->first();
        if (!$redeem_request_details->coupon_sent) {
            if ($get_user_redeem_request->ribbon_notified && $get_user_redeem_request->approve) {
                $update_status_request = RequestRedeem::where('id', '=', $redeem_request_id)
                    ->where('user_uuid', '=', $user->uuid)
                    ->update(['coupon_sent' => date('Y-m-d H:i:s'), 'show_status' => config('settings.redemption_status.redeem_sent')]);

                /**
                 * Email send user
                 *
                 * $email = new UserRedeemCouponSend($user);
                 * Mail::send($email);
                 */
                return true;
            }
        }
        return false;
    }

    /**
     * This action for Notifying the Ribbon for the Gift Card Approval.
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */
    public function ribbonNotified($user, $redeem_request_id)
    {
        $redeem_request_details = $this->getRedeemRequestDetails($redeem_request_id);
        if (!$redeem_request_details->ribbon_notified) {
            $get_user_redeem_request = RequestRedeem::select('approve', 'redeem_points')->where('id', '=', $redeem_request_id)->first();
            $redeem_points = $get_user_redeem_request->redeem_points;
            // echo "<pre>";
            // print_r($get_user_redeem_request->redeem_points);
            // die();
            if ($get_user_redeem_request->approve) {
                $update_status_request = RequestRedeem::where('id', '=', $redeem_request_id)
                    ->where('user_uuid', '=', $user->uuid)
                    ->update(['ribbon_notified' => date('Y-m-d H:i:s'), 'show_status' => config('settings.redemption_status.redeem_notified')]);

                /**
                 * Email send user
                 **/
                try {
                    $email = new UserRedeemRibbonNotified($user, $redeem_points);
                    Mail::send($email);
                } catch (\Exception $e) {
                    // 
                }


                return true;
            }
        }
        return false;
    }

    /**
     * This action for Redeem the Gift Card Requested by the User.
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */
    public function couponRedeem($user, $redeem_request_id)
    {
        $redeem_request_details = $this->getRedeemRequestDetails($redeem_request_id);

        if (!$redeem_request_details->coupon_redeemed) {
            $get_user_redeem_request = RequestRedeem::select('approve', 'ribbon_notified', 'coupon_sent')->where('id', '=', $redeem_request_id)->first();
            if ($get_user_redeem_request->approve && $get_user_redeem_request->ribbon_notified && $get_user_redeem_request->coupon_sent) {
                $update_data = [
                    'coupon_redeemed' => date('Y-m-d H:i:s'),
                    'status' => 'completed',
                    'show_status' => config('settings.redemption_status.redeem_coupon')
                ];
                $update_status_request = RequestRedeem::where('id', '=', $redeem_request_id)
                    ->where('user_uuid', '=', $user->uuid)
                    ->update($update_data);
                return true;
            }
        }
        return false;
    }
    /**
     * This action for Redeem the Gift Card Requested by the User.
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */
    public function couponLapsed($user, $redeem_request_id)
    {
        $redeem_request_details = $this->getRedeemRequestDetails($redeem_request_id);

        if (!$redeem_request_details->coupon_redeemed) {
            $get_user_redeem_request = RequestRedeem::select('approve', 'ribbon_notified', 'coupon_sent')->where('id', '=', $redeem_request_id)->first();
            if ($get_user_redeem_request->approve && $get_user_redeem_request->ribbon_notified && $get_user_redeem_request->coupon_sent) {
                $update_data = [
                    'coupon_redeemed' => date('Y-m-d H:i:s'),
                    'status' => 'lapsed',
                    'show_status' => 'Coupon has been lapsed!'
                ];
                $update_status_request = RequestRedeem::where('id', '=', $redeem_request_id)
                    ->where('user_uuid', '=', $user->uuid)
                    ->update($update_data);
                return true;
            }
        }
        return false;
    }

    /*
     * This action is used for updating the Redeem Request in User ADDITIONAL Data
     * and updating the User Points Data in user Additional Data.
     *
     * @param $user
     * @param $redeem_request_id
     * @return bool
     */

    public function updateUserAddData($user, $redeem_request_id)
    {
        $user_add = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        if (!empty($user_add)) {
            $redeem_points_data = RequestRedeem::where('user_uuid', '=', $user->uuid)
                ->where('id', '=', $redeem_request_id)
                ->first();
            $redeem_points = $redeem_points_data->redeem_points;
            $total_users_points = $redeem_points_data->total_points;
            $user_redeem_points[] = [
                'date_requested' => $redeem_points_data->created_at,
                'approved_at' => time(),
                'points' => $redeem_points,
            ];
            if (!$user_add->user_redeemed_points) {
                $update = UserAdditionalData::where('uuid', '=', $user->uuid)->push('user_redeemed_points', $user_redeem_points);
                event(new UserAchievementUpdate($user));
                activity("user_redeem_points")
                    ->causedBy($user)
                    ->withProperties(['points' => $redeem_points])
                    ->log(__('inpanel.activity_log.redeem_points'));
                return true;
            }
            $update = UserAdditionalData::where('uuid', '=', $user->uuid)->push('user_redeemed_points', $user_redeem_points);
            activity("user_redeem_points")
                ->causedBy($user)
                ->withProperties(['points' => $redeem_points])
                ->log(__('inpanel.activity_log.redeem_points'));
            event(new UserAchievementUpdate($user));
            activity("user_redeem_points")
                ->causedBy($user)
                ->withProperties(['points' => $redeem_points])
                ->log(__('inpanel.activity_log.redeem_points'));
            return true;
        }
        return false;
    }

    /**
     * This action for getting the redeem request details for the user.
     *
     * @param $redeem_request_id
     * @return mixed
     */
    public function getRedeemRequestDetails($redeem_request_id)
    {
        $get_user_redeem_request = RequestRedeem::where('id', '=', $redeem_request_id)->first();
        return $get_user_redeem_request;
    }

    /**
     * Function Name : getredeemRequest
     * Created By : Priyanka(04-sep-2024)
     * */
    public function getredeemRequest($status = null, $email = null)
    {
        // Subquery to get the latest device_type per user
        // $latestDeviceHistory = DB::table('device_histories as dh1')
        //     ->select('dh1.user_id', 'dh1.device_type')
        //     ->whereRaw('dh1.id = (
        //         SELECT dh2.id FROM device_histories dh2
        //         WHERE dh2.user_id = dh1.user_id
        //         ORDER BY dh2.created_at DESC
        //         LIMIT 1
        //     )');

        $redeemRequest = User::whereHas('roles', function ($query) {
            $query->where('id', 4);
        })
            ->select(
                'users.uuid',
                'users.panellist_id',
                'users.locale',
                'request_redeems.*',
                'country_points.currency_symbols',
                'country_points.points',
                'user_platform_actions.platform as device_type'
            )
            ->leftJoin('request_redeems', 'request_redeems.user_uuid', '=', 'users.uuid')
            // Join Added by Vikas for tracking Platform(Code Starting)
            ->leftJoin('user_platform_actions', function ($join) {
                $join->on('users.uuid', '=', 'user_platform_actions.user_uuid')
                    ->where('user_platform_actions.action_type', '=', 'redemption_request')
                    ->whereColumn('request_redeems.id', 'user_platform_actions.action_id');
            })
            // Code Ending
            ->leftJoin('country_points', DB::raw('CONVERT(country_points.country_language USING utf8mb4)'), '=', DB::raw('CONVERT(users.locale USING utf8mb4)'))
            ->active()
            ->confirmed();

        if ($status) {
            $redeemRequest->whereIn('request_redeems.status', $status);
        }

        if ($email) {
            $redeemRequest->where('users.email_hash', '=', $email);
        }
        return $redeemRequest->distinct()->get();
    }


    public function getredeemForHomePage($status = null, $email = null)
    {
        $redeemRequest = User::where('country_code', '!=', 'AU')->whereHas('roles', function ($query) {
            $query->where('id', 4);
        })
            ->select('users.uuid', 'users.panellist_id', 'users.locale', 'users.first_name', 'users.zipcode', 'users.country', 'request_redeems.*', 'country_points.currency_symbols', 'country_points.points')
            ->leftJoin('request_redeems', 'request_redeems.user_uuid', '=', 'users.uuid')
            ->leftJoin('country_points', DB::raw('CONVERT(country_points.country_language USING utf8mb4)'), '=', DB::raw('CONVERT(users.locale USING utf8mb4)'))
            ->active()
            ->confirmed();
        if ($status) {
            $redeemRequest->whereIn('request_redeems.status', $status);
        }
        if ($email) {
            $redeemRequest->where("users.email_hash", "=", $email);
        }
        //echo $redeemRequest->toSql();exit;
        $redeemRequest = $redeemRequest->latest()->take(15)->get();
        // foreach($redeemRequest as $values){
        //     $values->city_state = $this->getStateFromZipCode($redeemRequest->zipcode,$redeemRequest->country,"","");
        // }
        return $redeemRequest;
    }

    /**
     * Function Name : getredeemRequest
     * Created By : Priyanka(05-sep-2024)
     * */
    public static function getValueByRedeemIdDisplay($redeem_id)
    {
        // Get the points conversion metric from config
        $pointsConversionMetric = config('app.points.metric.conversion');

        // Fetch redeem request details
        $redeem_request_details = RequestRedeem::where('id', $redeem_id)->first();

        // Handle case where redeem request is not found
        if (!$redeem_request_details) {
            return null; // Or handle error appropriately
        }

        // Fetch country point details
        $country_point = User::select('country_points.currency_symbols', 'country_points.points')
            ->leftJoin('request_redeems', 'request_redeems.user_uuid', '=', 'users.uuid')
            ->leftJoin('country_points', DB::raw('CONVERT(country_points.country_language USING utf8mb4)'), '=', DB::raw('CONVERT(users.locale USING utf8mb4)'))
            ->where('users.uuid', $redeem_request_details->user_uuid)
            ->first();

        if (!empty($country_point->points)) {
            // Determine the currency symbol
            $symbol = ($country_point->currency_symbols == 'CAD') ? $country_point->currency_symbols . ' ' : $country_point->currency_symbols;

            // Calculate value
            $points = $country_point->points;
            //$points = 1000;
            $value = round($redeem_request_details->redeem_points / $points, 2);
            $current_value =  $symbol . $value;
        } else {
            // Fallback calculation if country_point data is not available
            $current_value = $redeem_request_details->redeem_points * $pointsConversionMetric;
        }

        return $current_value;
    }

    function getStateFromZipCode($zipcode, $country, $panellist_id, $stateToRegionMapping)
    {
        $country_code = "";
        switch ($country) {
            case "US":
                $country_code = "US";
                break;
            case "IN":
                $country_code = "IN";
                break;
            case "CA":
                $country_code = "CA";
                break;
            default:
                $country_code = "US"; // Default
        }

        $zipp = "08854";

        $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";
        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            // cURL request failed
            // echo "Error: " . curl_error($ch);
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            // HTTP request failed
            // echo "HTTP Error: " . $http_code;
            return null;
        }

        $data = json_decode($response, true);
        //dd($data);        
        if (isset($data["places"][0])) {
            $state = $data["places"][0]["state"];
            $city = $data["places"][0]["place name"];

            // Extract state abbreviation
            $stateAbbreviation = $data["places"][0]["state abbreviation"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $region, $stateAbbreviation];
        } else {
            // ZIP code not found
            return null;
        }

        curl_close($ch);
    }
 public function getredeemBankRequest()
{
    $pendingRequests = RedeemBankRequest::join('users', function ($join) {
            $join->on(
                DB::raw('users.uuid COLLATE utf8mb4_unicode_ci'),
                '=',
                DB::raw('redeem_bank_requests.user_uuid COLLATE utf8mb4_unicode_ci')
            );
        })
        ->where('redeem_bank_requests.status', 'pending')
        ->select(
            'redeem_bank_requests.*',
            'users.first_name',
            'users.last_name',
            'users.country'
        )
        ->get();

    return $pendingRequests;
}
public function getapprovedRedeemBankRequest()
{
    $approvedRequests = RedeemBankRequest::join('users', function ($join) {
            $join->on(
                DB::raw('users.uuid COLLATE utf8mb4_unicode_ci'),
                '=',
                DB::raw('redeem_bank_requests.user_uuid COLLATE utf8mb4_unicode_ci')
            );
        })
        ->where('redeem_bank_requests.status', 'approved')
        ->select(
            'redeem_bank_requests.*',
            'users.first_name',
            'users.last_name',
            'users.country',
            'users.panellist_id',
            'users.email'
        )
        ->get();

    return $approvedRequests;
}

}
