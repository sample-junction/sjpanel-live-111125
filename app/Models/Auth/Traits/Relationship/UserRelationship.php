<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Profiler\UserAdditionalData;
use App\Models\System\Session;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\PasswordHistory;
use App\Models\UserPoint;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function userAchievements(){
        /*return $this->hasMany(UserAchievement::class);*/
    }

    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }
    public function point()
    {
        $user_points = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
        if (!empty($user_points) && !empty($user_points->user_points)) {
            return $user_points->user_points;
        }
        return null;
    }
}
