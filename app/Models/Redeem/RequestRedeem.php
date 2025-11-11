<?php

namespace App\Models\Redeem;

use App\Models\Auth\User;
use App\Repositories\Inpanel\Redeem\RedeemRepository;
use Illuminate\Database\Eloquent\Model;


/**
 * This modal class is used to store the redeem request data as the User Post the request for redeeming points
 * and also update as the admin change status of the requests.
 *
 * Class RequestRedeem
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Redeem\RequestRedeem
 */

class RequestRedeem extends Model
{
    protected $fillable = [
        'user_uuid',
        'total_points',
        'redeem_points',
        'country_points',
        'redeem_method',
        'approve',
        'coupon_sent',
        'ribbon_notified',
        'coupon_redeemed',
        'status',
        'show_status'
    ];
    protected $dates = ['timestamp','approve','coupon_sent','ribbon_notified','coupon_redeemed'];

    /**
     * This function is ussed for making relationship with user_uuid of RequestRedeem and uuid of User Models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    /**
     * This function is used for creating custom action for dropdown Acton button in view of redeem/includes/index_action.blade.php
     * @param $redeem
     * @return string
     * @throws \Throwable
     */
    public static function laratablesCustomAction($redeem)
    {
        return view('backend.auth.redeem.includes.index_action')
            ->with('redeem',$redeem)
            ->render();
    }

	/**
     * This function is used to return points conversion metrics for the points requested to redeem
     * @param $redeem
     * @return float|int
     */
    public static function laratablesCustomValue($redeem)
    {
        /*Priyanka : 04-sep-2024*/
            //return RedeemRepository::getValueByRedeemId($redeem->id);
            return RedeemRepository::getValueByRedeemIdDisplay($redeem->id);
        /*Priyanka : 04-sep-2024*/
    }

    /**This function is used to return additional Columns use in Datatables display.
     *
     * @return array
     */
    public static function laratablesAdditionalColumns()
    {
        return ['approve', 'ribbon_notified', 'coupon_sent','coupon_redeemed'];
    }

    /**
     * This function is used for return Request status in form of icon.
     *
     * @param $redeem
     * @return string
     */
    public static function laratablesCustomRequestStatus($redeem)
    {
        $result = '';
        $result .= ( !empty($redeem->approve) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        $result.='&nbsp;&nbsp;';
        $result .= ( !empty($redeem->ribbon_notified) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        $result.='&nbsp;&nbsp;';
        $result .= ( !empty($redeem->coupon_sent) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        $result.='&nbsp;&nbsp;';
        $result .= ( !empty($redeem->coupon_redeemed) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
        return $result;
    }

    public static function laratablesCustomUserUuid($redeem)
    {
        return $redeem->user_uuid;
    }

    public static function laratablesSearchUserUuid($query, $searchValue)
    {
        return $query->where('request_redeems.user_uuid', 'like', "%{$searchValue}%");
    }
}
