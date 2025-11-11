<?php

namespace App\Http\Requests\Inpanel;

use App\Models\Country;
use App\Models\CountryTrans;
use Illuminate\Foundation\Http\FormRequest;

class BasicProfileRequest extends FormRequest
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
        $postedCountryCode = false;
        if($this->request->has('country')){
            $postedCountry = $this->request->get('country');
            $min_age = CountryTrans::where('country_code','=',$postedCountry)->pluck('min_age')->first();
            $olderThanDate = date('Y-m-d', strtotime('-'.$min_age.'years'));
            if(config('access.registration_geo_ip_check')) {
                $geodata = geoip(request()->ip());
                $ipcountryCode = $geodata->getAttribute('iso_code');
                $postedCountryCode = CountryTrans::where('country_code','=',$postedCountry)->pluck('country_code')->first();
                if ($postedCountryCode == $ipcountryCode) {
                    $checkCountry = $postedCountry;
                }
            }else{
                $checkCountry = $postedCountry;
                $postedCountryCode = $postedCountry;
            }
        } else {
            $user = auth()->user();
            $userCountry = $user->country;
            $postedCountryCode = CountryTrans::where("country_code","=",$userCountry)->pluck('country_code')->first();
            $min_age = CountryTrans::where('country_code','=',$postedCountryCode)->pluck('min_age')->first();
            $olderThanDate = date('Y-m-d', strtotime('-'.$min_age.'years'));
        }
        $checkZipcode = false;
        if($this->request->has('zipcode')){
            $posted_postcode = $this->request->get('zipcode');
            if(config('access.basic_details_zip_country_check') && $postedCountryCode && $postedCountryCode!="CN") {
                if($postedCountryCode == "UK"){
                    $postedCountryCode = "GB";
                }
                
                //$postcodeData = check_supplied_postcode($posted_postcode, $postedCountryCode);
                
                if ($posted_postcode) {
                    $checkZipcode = $posted_postcode;
                }
            }else{
                $checkZipcode = $posted_postcode;
            }
        }
        return [
            'first_name'    => 'sometimes|required|max:191',
            'last_name'     => 'sometimes|required|max:191',
            'gender'        => 'sometimes|required|in:male,female',
            'email'         => 'sometimes|required|email|max:191',
            'timezone'      => 'sometimes|required|max:191',
            'avatar_location' => 'sometimes|image|max:191',
            'dob'           => 'sometimes|required|before:'.$olderThanDate,
            'zipcode'       => 'sometimes|required|in:'.$checkZipcode,
            'locale'        => 'sometimes|required',
            //'country'    => 'sometimes|required|integer|exists:countries,id',
            'country'       => 'sometimes|required|string|in:'.$checkCountry,
            'language'      => 'sometimes|required',
        ];

    }
    public function messages()
    {
        return [
            'country.in' => __('This is not your current country! Invalid Country'),
            'dob.before' => __('your age must be greater then 16 yrs! Invalid Date'),
            'dob.date' => __('Invalid Date format'),
            'dob.required' => __('Your age is required'),
            'zipcode.in' => __('Country and zipcode do not matchs'),
        ];
    }
}
