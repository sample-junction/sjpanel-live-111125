<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\CountryTrans;
use Illuminate\Validation\Rule;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest.
 */
class PromoRegisterRequest extends FormRequest
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
        $checkCountry = '';
        if($this->request->has('country')){
            $postedCountry = $this->request->get('country');
            if(config('access.registration_geo_ip_check')){
                $geodata = geoip(request()->ip());
                $ipcountryCode = $geodata->getAttribute('iso_code');
                $selectedCountry = CountryTrans::where("country_code","=",$postedCountry)->pluck('country_code')->first();
                if($selectedCountry == $ipcountryCode){
                    $checkCountry = $postedCountry;
                }
            }else{
                $checkCountry = $postedCountry;
            }
        }
        return [
            'first_name'           => ['required', 'string', 'max:191'],
            'last_name'            => ['required', 'string', 'max:191'],
            'consent'                => 'accepted',
            'email'                => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password'             => ['required', 'string', 'min:6', 'confirmed'],
            'country'              => 'required|string|in:'.$checkCountry,
            'g-recaptcha-response' => ['required', 'captcha'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'g-recaptcha-response.required' => trans('validation.required', ['attribute' => 'Captcha']),
            'g-recaptcha-response.captcha' => trans('validation.required', ['attribute' => 'Captcha']),
        ];
    }
}
