<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * This modal class is used for storing data of Social Login User.
 *
 * Class SocialAccount
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Models\Auth\SocialAccount
 */

class SocialAccount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'social_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'provider', 'provider_id', 'token', 'avatar'];
}
