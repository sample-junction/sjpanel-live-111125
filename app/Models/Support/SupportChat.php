<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used storing all the Panellist Support created and for fetching them.
 *
 * Class SupportChat
 * @author Vikash Yadav
 * @access public
 * @package  App\Models\Support\SupportChat
 */

class SupportChat extends Model
{
    /**
     * @var array $fillable
     */
 protected $fillable = [
     'id',
     'ticket_id',
     'user_id',
     'manager_id',
     'attach_file_name',
     'status',
     'content',
     'created_at',
     'updated_at'
 ];

 
}
