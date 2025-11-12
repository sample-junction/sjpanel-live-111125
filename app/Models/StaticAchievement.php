<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing all the achievements data with their points user_joined,
 * basic_profile points, profile_pic_upload points and detailed_profile_points .
 *
 * Class StaticAchievement
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\StaticAchievement
 */

class StaticAchievement extends Model
{
    protected $fillable = [
        'code','name', 'description','points','order',
    ];
}
