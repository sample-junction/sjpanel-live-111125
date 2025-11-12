<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing all the unsubscribe email id.
 *
 * Class UserUnsubscribe
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Auth\UserUnsubscribe
 */

class UserUnsubscribe extends Model
{
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'email',
        'reason',
        'otherReason',
    ];

}
