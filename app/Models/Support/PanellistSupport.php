<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used storing all the Panellist Support created and for fetching them.
 *
 * Class PanellistSupport
 * @author Vikash Yadav
 * @access public
 * @package  App\Models\Support\PanellistSupport
 */

class PanellistSupport extends Model
{
    /**
     * @var array $fillable
     */
 protected $fillable = [
     'id',
     'ticket_id',
     'user_id',
     'project_code',
     'subject',
     'status',
     'message',
     'file_name',
     'created_at',
     'updated_at'
 ];

    protected function user()
    {
        return $this->belongsTo('App\Models\Auth\User', 'user_id', 'id');
    }

 
}
