<?php

namespace App\Http\Controllers\Inpanel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use App\Repositories\Inpanel\Project\ProjectRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;

class SearchController extends Controller
{
	protected $countriesCurrenciesRepository; 
	
	public function __construct(CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
		$this->countriesCurrenciesRepository = $countriesCurrenciesRepository;        
    }

    public function search(Request $request){

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

        // $check_req = strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);

        $user = auth()->user();
        $languageCode = strtoupper(explode('_', $user->locale)[0]);
        $countryCode = strtoupper(explode('_', $user->locale)[1]);
      
        $searchWord = $request->input('query');
        $tempArr = [];
        $pointsSearch = "";

        $userRole = $user->roles->pluck('name')->toArray();
		/* Parshant Sharma [23-08-2024] STARTS */
		
		$locale = $user->locale;
		
		$countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);		
		$countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
		//dd($countryPoints);
		
		// Initialize an empty array
		$currencies = array();

		if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
			
			$cntry = explode('_',$countryPoint->country_language);
			
			$currencies = array(
				'currency_logo'  => $countryPoint->currency_symbols,
				'currency_denom_singular' => $countryPoint->currency_denom_singular,
				'currency_denom_plural' => $countryPoint->currency_denom_plural,
				'countryPoints' => $countryPoints
			);
		} 	
		//dd($currencies);
		/* Parshant Sharma [23-08-2024] ENDS */
		
        if($userRole[0] != 'panelist'){

        $query = DB::table('user_projects')->join('projects','projects.id','=','user_projects.project_id')
                                            ->where('user_projects.user_id','=',$user->id)
                                            ->where('projects.language_code', $languageCode)
                                            ->where('projects.country_code', $countryCode)
                                            ->where('projects.study_type_id','=',12);

        }else{

            $query = DB::table('user_projects')->join('projects','projects.id','=','user_projects.project_id')
            ->where('user_projects.user_id','=',$user->id)
            ->where('projects.language_code', $languageCode)
            ->where('projects.country_code', $countryCode)
            ->where('projects.study_type_id','!=',12);

        }                                    

        $query->where(function ($query) use ($searchWord) {
            // $columns = Schema::getColumnListing('user_projects');
            $columns = ['apace_project_code','points'];
            if($searchWord[0] == '$'){
                $searchWord = substr($searchWord,1);
                // $results = 'abcd';
                $query->orWhere('user_projects.cpi', 'LIKE', '%' . ltrim($searchWord) . '%');
            }elseif($searchWord[0] == '£'){				
                $searchWord = substr($searchWord,3);
                // $results = 'abcd';
                $query->orWhere('user_projects.cpi', 'LIKE', '%' . ltrim($searchWord) . '%');
            }elseif(substr(strtoupper($searchWord), 0, 3) == 'CAD'){	
                $searchWord = substr($searchWord,3);				
                // $results = 'abcd';
                $query->orWhere('user_projects.cpi', 'LIKE', '%' . ltrim($searchWord) . '%');
            }elseif($searchWord[0] == '₹'){				
                $searchWord = substr($searchWord,3);
                // $results = 'abcd';
                $query->orWhere('user_projects.cpi', 'LIKE', '%' . ltrim($searchWord) . '%');
            }else{
                foreach ($columns as $column) {
                $query->orWhere("user_projects.".$column, 'LIKE', '%' . $searchWord . '%');
                } 
            }});
            //dd($query->toSql(), $query->getBindings());

            
        $results = $query->select('user_projects.apace_project_code','user_projects.points','user_projects.status','projects.survey_status_code','projects.loi')->get();
        return response()->json(['data' => $results,'currencies'=>$currencies]);


    }

 } 
}
