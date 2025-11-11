<?php

namespace App\Models\Referral;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;


/**
 * This modal class is used for making referral relationship as the Referral
 * register by clicking on invite link or invite button from invite email.
 *
 * Class ReferralRelationship
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Referral\ReferralRelationship
 */

class ReferralRelationship extends Model
{
    protected $fillable = ['referral_link_id', 'user_id','ref_code','ref_method'];

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
