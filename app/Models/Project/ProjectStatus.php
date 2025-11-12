<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing Project Status and retrieving it from table.
 *
 * Class ProjectStatus
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Project\ProjectStatus
 */

class ProjectStatus extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'status',
        'order',
    ];
    public $timestamps = false;
}
