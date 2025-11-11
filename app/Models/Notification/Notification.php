<?php

namespace App\Models\Notification;

use App\Models\Auth\User;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $fillable = [
        'user_uuid',
        'notification_type',
        'new_notification_type',
        'type_id',
        'notification_text',
        'seen_status',
        
       
    ];
   
    /**
     * This function is ussed for making relationship with user_uuid of Notification and uuid of User Models
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

}
