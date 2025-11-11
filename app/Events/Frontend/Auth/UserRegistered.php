<?php

namespace App\Events\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserRegistered.
 */
class UserRegistered
{
    use SerializesModels;

    /**
     * @var
     */
    public $user, $userInputData;

    /**
     * @param $user
     */
    public function __construct(User $user, $user_input_data)
    {
        $this->user = $user;
        $this->userInputData = $user_input_data;
    }
}
