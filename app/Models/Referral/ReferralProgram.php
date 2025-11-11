<?php

namespace App\Models\Referral;

use Illuminate\Database\Eloquent\Model;


/**
 * This modal class is used for storing the referral programs and retrieving it during creating referral link.
 *
 * Class ReferralProgram
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Referral\ReferralProgram
 */

class ReferralProgram extends Model
{
    protected $fillable = ['code','name','points', 'uri', 'lifetime_minutes'];
}
