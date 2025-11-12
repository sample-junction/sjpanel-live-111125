<?php

namespace App\Repositories\Backend\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Models\Auth\User;
use App\Models\Setting\CountriesCurrencies;
/**
 * Class UserRepository.
 */
class CountriesCurrenciesRepository extends BaseRepository
{
	/**
	 * @return string
	 */
	public function model()
	{
	    return CountriesCurrencies::class;
	}

	/**
	 * Function Name : create country point
	 * Created By : Priyanka Sharma(08-aug-2024)
	 * */
	public function create(array $data){
		$country = $data['country'];
		$country_language = $data['country_language'];
		$currency = $data['currency'];
		$points = $data['points'];
		$arr = [
	       'country' => $country,
	       'country_language' => $country_language,
	       'currency' => $currency,
	       'points' => $points,
	       'user_id' => auth()->user()->id,
	       'status' => 1, // Assuming 'status' is an integer field
	    ];
	 	$save = CountriesCurrencies::create($arr);
		if (!$save) {
		   throw new GeneralException(__('Failed to save country point'));
		}
		return $save;
	}
	
	/***
	 * Function Name : get all Questions
	 * Created By : Priyanka Sharma(09-aug-2024)
	 * */
	public function getCountriesPoints(){
	    $points = CountriesCurrencies::where('status','1')->get();
	    return $points;
	}

	/***
     * Function Name : get  detail
     * Created By : Priyanka Sharma(09-aug-2024)
     * */
    public function getDetail($id){
        $detail = CountriesCurrencies::where('id', $id)->first();
        return $detail;
    }

     /***
     * Function Name : soft delete 
     * Created By : Priyanka Sharma(09-aug-2024)
     * */
    public function deletePoint($id)
    {
    	$detail = CountriesCurrencies::findOrFail($id);
	      $detail->update([
	         'status' => '0', // Assuming 'status' is an integer field
	         'updated_at' => now()
	      ]);
	    if($detail){
		   return $detail;
		}else{
		   throw new GeneralException(__('exceptions.backend.access.users.update_error'));
		}
    }


    /***
    * Function Name : update
    * Created By : Priyanka Sharma(09-aug-2024)
    * */
    public function update(array $data,$id)
    {
		$country = $data['country'];
		$country_language = $data['country_language'];
		$currency = $data['currency'];
		$points = $data['points'];
		$arr = [
	       'country' => $country,
	       'country_language' => $country_language,
	       'currency' => $currency,
	       'points' => $points,
	       'updated_at' => now()
	    ];
	    $detail = CountriesCurrencies::findOrFail($id);
	    $detail->update($arr);
        if($detail){
    	   return $detail;
    	}else{
    	   throw new GeneralException(__('exceptions.backend.access.users.update_error'));
    	}
    }
	
	 /***
     * Function Name : get  currency points by language
     * Created By : Parshant Sharma(16-Aug-2024)
     * */
    public function getPointsDetail($lang){
        $detail = CountriesCurrencies::where('country_language', $lang)->first();
        return $detail;
    }
	
}