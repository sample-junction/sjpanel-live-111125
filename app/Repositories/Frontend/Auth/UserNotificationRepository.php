<?php

namespace App\Repositories\Frontend\Auth;

use App\Models\Notification\Notification;
use App\Models\Auth\User;
use App\Repositories\BaseRepository;

/**
 * This repository class is used for handling all the functionality related to the Notificationa .
 *
 * Class UserNotificationRepository
 * @author Rakesh A Srivastava
 * @access public
 * @package App\Repositories\Frontend\Auth\UserNotificationRepository
 */

class UserNotificationRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    public function getNotification($user_uuid){

        $notifications = Notification::where(['user_uuid' => $user_uuid, 'seen_status' => '0'])->orderBy('created_at','desc')->limit(20)->get();

        return $notifications;
    }

    public function updateNotificationSeenStatus($notification_id){
        $update = Notification::where('id',$notification_id)->update(['seen_status' => '1']);
        return $update;
    } 

    public function createNotification($user_uuid,$notification_type,$type_id,$msg='',$new_notification_type='')
    {
        $notification_data['user_uuid'] = $user_uuid;
        $notification_data['notification_type']    = $notification_type;
        $notification_data['type_id']    = $type_id;
        $notification_data['new_notification_type']    = $new_notification_type;
        $notification_data['notification_text']  = $msg;
        $create = Notification::create($notification_data);
        return $create;
    }
}

