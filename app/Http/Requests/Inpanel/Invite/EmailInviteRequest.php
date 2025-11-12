<?php

namespace App\Http\Requests\Inpanel\Invite;

use Illuminate\Foundation\Http\FormRequest;


/**
 * This request class is used for checking the request get during inviting user by invite form.
 *
 * Class EmailInviteRequest
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Requests\Inpanel\Invite\EmailInviteRequest
 */

class EmailInviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:191|unique:users',
            'name'=> 'required|max:191',
        ];
    }
}
