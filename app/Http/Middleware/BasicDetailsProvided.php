<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Auth;
use Illuminate\Session\Store;
use App\Models\Redeem\RequestRedeem;
use App\Repositories\Inpanel\Project\ProjectRepository;									
use DB;
/**
 * This middleware class is used to handle incoming request that user has given all the basic details or not.
 *
 * Class BasicDetailsProvided
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Middleware\BasicDetailsProvided
 */

class BasicDetailsProvided
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $session;
    protected $timeout = 3600;
    public function __construct(Store $session, ProjectRepository $projectRepo)
    {
        $this->session = $session;
		$this->projectRepo = $projectRepo;								  
    }
    public function handle($request, Closure $next)
    {
        /* 
        * Language Section Start
        * Discription:- Set Language and country for logged in user , so that on panel 
        * dashboard it wouldn't be change
        */
        
        $user = Auth::user();
      
		$getLang = explode('_',$user->locale);
        $countryCode = strtoupper(explode('_', @$user->locale)[1]);
        $user_id=@$user->id;
         $updateUser = ['last_login_at' => date('Y-m-d h:i:s')];
         DB::table('users')->where('users.id','=',$user_id)->update($updateUser);
         
        //  $project = DB::table('user_projects as up')
        //     ->join('projects as p', 'up.project_id', '=', 'p.id')
        //     ->select('up.*','p.apace_project_code','p.code','p.loi','p.end_date')
        //     ->where('p.survey_status_code', '=', 'LIVE')
        //     ->where('up.user_id','=',$user_id)
		// 	->where('p.language_code', '=', strtoupper($getLang[0]))	
        //     ->where('status','=',null);
       
        //   session()->put('surveys',$project->count());

        // Code Added by Vikas for getting count of panelist and test panelist differently (Starting)
        $baseQuery = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->where('p.survey_status_code', 'LIVE')
            ->where('up.user_id', $user_id)
            ->where('p.language_code', strtoupper($getLang[0]))
            ->where('p.country_code', strtoupper($getLang[1]))
           
            ->whereNull('up.status');

        $testsCount = (clone $baseQuery)
            ->where('p.study_type_id', 12)
            ->count();

        $surveysCount = (clone $baseQuery)
            ->where('p.study_type_id', '!=', 12)
            ->count();

        session()->put('testsurveys', $testsCount);
        session()->put('surveys', $surveysCount);
        // Ending (Vikas)
        
        //code added for modifying total points in nav/user window by RAS on 23-08-23
        $redeem_requests = RequestRedeem::where('user_uuid','=',$user->uuid)->where('status','=','pending')->first();
        if($redeem_requests){
            session()->put('redeem_requests_points',$redeem_requests->redeem_points);
        }else{
            session()->put('redeem_requests_points',0);
        }

        // echo '<pre>';
        // print_r(session()->get('redeem_requests_points'));die();
	//code added for displaying images from test5 on test17 by RAS on 24-08-23
	session()->put('server2_url','https://test5.sjpanel.com/img');
        //date_default_timezone_set($user->timezone);
        session()->put('locale', $request->user()->locale);
        app()->setLocale($request->user()->locale);
        setlocale(LC_TIME, $request->user()->locale);

        $current_locale = explode('_', $request->user()->locale);
        $current_lang = $current_locale[0];
        Carbon::setLocale($current_lang);
        /* Language Section Ends*/
         $is_logged_in = $request->path() != 'logout';
       //$user->update($updateUser)->where('users.id','=',$user_id);
        if(!session('last_active')) {
            $this->session->put('last_active', time());
            //auth()->logout();
           // return redirect()->route('frontend.auth.login');
            //return redirect()->route('inpanel.basic.show');
        } elseif(time() - $this->session->get('last_active') > $this->timeout) {
            
            $this->session->forget('last_active');
            
            $cookie = cookie('intend', $is_logged_in ? url()->current() : 'dashboard');
            
            auth()->logout();
            return redirect()->route('frontend.auth.login');
        }
        
        if(! is_null($request->user()) && !$request->user()->filled_basic_details) {
            
            return redirect()->route('inpanel.basic.show');
        }
        return $next($request);
    }
}
