<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used storing all the projects created and for fetching them.
 *
 * Class Project
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Project\Project
 */

class Project extends Model
{
    /**
     * @var array $fillable
     */
 protected $fillable = [
     'code',
     'apace_project_code',
     'survey_status_code',
     'survey_priority',
     'survey_name',
     'language_code',
     'country_code',
     'industry_id',
     'client_cpi',
     'live_url',
     'test_url',
     'is_active',
     'quota',
     'loi',
     'ir',
     'ccr',
     'unique_pid',
     'unique_ip_address',
     'is_dedupe',
     'is_geoip',
     'cpi',
     'project_topic_id',
     'study_type_id',
     'project_topic_name',
     'device_options',
     'start_date',
     'end_date',
     'project_type'
 ];

 protected $dates = ['timestamp'];

    /**
     * This function is used for making relationship with survey_status_code of Project with code of ProjectStatus model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
 public function status()
 {
     return $this->belongsTo(ProjectStatus::class, 'survey_status_code','code');
 }
    /**
     * This function is used for making relationship with id of Project with project_id of UserProject model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
 public function userProject()
 {
     return $this->belongsTo(UserProject::class, 'id', 'project_id');
 }

    public function isLive()
    {
        if( $this->survey_status_code === 'LIVE' ){
            return true;
        }
        return false;
    }
}
