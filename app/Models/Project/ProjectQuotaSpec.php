<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used project quota specs as we specify quota to the particular project_id.
 *
 * Class ProjectQuotaSpec
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Project\ProjectQuotaSpec
 */

class ProjectQuotaSpec extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'project_quota_id',
        'is_global',
        'question_general_name',
        'question_id',
        'type',
        'values',
        'raw_spec',
    ];

    public $timestamps = false;
}
