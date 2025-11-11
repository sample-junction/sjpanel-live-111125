<?php

namespace App\Http\Requests\Inpanel\RedeemPoints;

use Illuminate\Foundation\Http\FormRequest;

/**
 * This request class is used checking elements from the redeem request page.
 *
 * Class RedeemRequest
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Requests\Inpanel\RedeemPoints\RedeemRequest
 */

class RedeemRequest extends FormRequest
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
            'redeem_points' => 'sometimes|required_if:section,points,custom',
        ];
    }
}
