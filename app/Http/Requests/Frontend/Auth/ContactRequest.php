<?php

namespace App\Http\Requests\Frontend\Auth;

use App\Rules\GoogleRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'g-recaptcha-response' => ['required_if:captcha_status,true', new GoogleRecaptcha()],
            'name' => 'required',
            'email' => 'required|email',
            'messages' => 'required',
            'consent' => 'accepted',
        ];
    }
}
