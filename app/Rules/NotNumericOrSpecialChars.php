<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NotNumericOrSpecialChars implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
       // Check if the value contains at least one alphabetic character
       return preg_match('/[a-zA-Z]/', $value);
    }

    public function message()
    {
        
        return 'The :attribute must contain at least one alphabetic character.';
    }
}
