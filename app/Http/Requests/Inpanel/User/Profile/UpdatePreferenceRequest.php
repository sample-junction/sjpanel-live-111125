<?php

namespace App\Http\Requests\Inpanel\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Validation\Rule;

/**
 * This request class is used to check the element receive from updatePreference method.
 *
 * Class UpdatePreferenceRequest
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Requests\Inpanel\User\Profile\UpdatePreferenceRequest
 */

class UpdatePreferenceRequest extends FormRequest
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
            'first_name'  => 'sometimes|required_if:section,basic-profile|max:191|min:2',
            'last_name'  => 'sometimes|required_if:section,basic-profile|max:191|min:2',
           /* 'gender'  => 'sometimes|required_if:section,basic-profile|in:male,female',
            'email' => 'sometimes|required_if:section,basic-profile|email|max:191',
            'timezone' => 'sometimes|required_if:section,basic-profile|max:191',
            'avatar_type' => ['sometimes', 'required_if:section,basic-profile', 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()))],
            'avatar_location' => 'sometimes|image|max:191',
            'dob'=> 'sometimes|required_if:section,basic-profile|date_format:m-d-Y',
            'zipcode'=> 'sometimes|required_if:section,basic-profile',
            'locale'=> 'sometimes|required_if:section,basic-profile',
            'country'=> 'sometimes|required_if:section,basic-profile|string|max:2',
            'password' => 'required_if:section,password|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/|confirmed',
            'delete_confirmation' => 'required_if:section,delete-account',
            'delete_personalinfo' => 'required_if:section,delete-personinfo',*/
        ];
    }
}
