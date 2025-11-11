<?php

namespace App\Models\Project;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing User Projects Data as the project is assigned to the User.
 *
 * Class UserProject
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Project\UserProject
 */

class UserProject extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'user_id',
        'project_id',
        'cpi',
        'points',
        'project_quota_id',
        'quota_invite_id',
        'user_live_link',
        'user_test_link',
        'mail_sent_counter',
        'mail_sent_at',
        'apace_project_code',
        'status',
        'order',
    ];

    public $timestamps = true;


    /**
     * This function is used for creating relationship with Project model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * This function is used for creating relationship with User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
