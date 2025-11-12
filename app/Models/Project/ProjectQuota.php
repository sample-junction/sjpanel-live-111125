<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used storing the project quotas and fetching them from the table.
 *
 * Class ProjectQuota
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Project\ProjectQuota
 */

class ProjectQuota extends Model
{
    protected $fillable = [
        'id',
        'project_id',
        'name',
        'description',
        'cpi',
        'count',
        'formatted_quota_spec',
        'type',
        'status',
        'apace_quota_id',
    ];

    public $timestamps = false;
}
