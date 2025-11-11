<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Mail\Frontend\UserConfirm\UserTestMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use App\Repositories\Inpanel\General\GeneralRepository;
use Illuminate\Http\Request;
use App\Models\Campaign\new_template;
use Carbon\Carbon;
use App\Models\Setting\Setting;

use App\Repositories\Backend\Auth\UserRepository;
use App\Models\Project\expenseRecord;
use App\Models\Project\surveyGallery;
use App\Mail\Frontend\CustomEmail;
//===== added by Pushpendra ========\\
use App\Models\Campaign\campaign_history;
//===== added by Pushpendra ========\\
use App\Services\RewardService;

/**
 * 
 *
 * Class RewardsController
 */

class RewardsController extends Controller
{
    



/**
     * This method is use to redirect the User to Home.
     *
     * @return \Illuminate\View\View
     */

    protected $generalRepository,$userRepository, $rewardService;

	public function __construct(  GeneralRepository $generalRepository, UserRepository $userRepository,RewardService $rewardService)
	{ 
		$this->userRepository = $userRepository;
		$this->generalRepository = $generalRepository;
		$this->rewardService = $rewardService;

	}

    public function rewards(Request $request)
    {
    	 
		$topPanelists = $this->userRepository->getTopPanelists();
		
		//dd($topPanelists->toArray());
		$currentDate = now();
		$currentMonth = now()->format('m'); // Get current month in two digits (e.g., "01" for January)
        $currentYear = now()->format('Y'); // Get current year in four digits (e.g., "2024")

		
		



/*$expenseRecordsIds = expenseRecord::where('type', 'Survey Reward')
						->whereYear('created_at', $currentYear) // Matches records with the year 2024
						->whereMonth('created_at',$currentMonth)    // Matches records with the month of March
						->orderBy('created_at', 'asc')
						->pluck('user_id')
						->toArray();*/
		
		//dd($expenseRecordsIds);
		
		return view('frontend.rewards')
		   ->with('currentDate',$currentDate)
		   //->with('expenseRecordsIds',$expenseRecordsIds)
		   ->with('topPanelists',$topPanelists); 

    }
	
	public function spinner(Request $request)
    {
		
		
		return view('frontend.spinner'); 

    }

    public function showUploadForm(Request $request)
    {
    	//===== Added by Pushpendra ========\\
    	/* This code is used set code value in session & this session value is used to update the campaign status value to track link is clicked or not*/
    	if($request->has('code')){
            session()->put('code_id',$request->get('code'));         
        }
        //===== Added by Pushpendra ========\\

		$currentUrl = request()->url();
        return view('frontend.upload', compact('currentUrl'));
    }
 
    public function upload(Request $request)
    {
		$panelistId = $request->uid; // Replace 1 with the desired product ID
		$panelistDetails = User::select('first_name', 'middle_name','last_name')->where('panellist_id', $panelistId)->get();
 
		//dd($panelistDetails->toArray());
		$firstName = '';
		$lastName = '';
		foreach ($panelistDetails as $user) {
			$firstName = $user['first_name'];
			$lastName  = $user['last_name'];
		}
		$request->validate([
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2060', // Max file size is 2MB (2048 KB)
            'image' => 'required|mimes:jpeg,png,jpg,gif,mp4|max:100000', // Max file size is 2MB (2048 KB)
        ]);
 
        if ($request->file('image')->isValid()) {
			$customFileName = $firstName.'_'.$lastName.'_'.$request->uid . '_'.time().'.'. $request->file('image')->getClientOriginalExtension();
			//$path = $request->file('image')->storeAs('videos', $customFileName, 'public');
			//$path = $request->file('image')->storeAs('uploads', $customFileName, 'public_uploads');
			$image = $request->file('image');
			$path = public_path('uploads');
			$destinationPath = public_path('uploads');
            $image->move($destinationPath, $customFileName); 

			/* Save Image path and name in DB[28-03-2024] START */
			$surveyGallery = new surveyGallery();
			$surveyGallery->path = 'uploads/'.$customFileName;
			$surveyGallery->panelist_id = $panelistId;
			$surveyGallery->firstname = $firstName;
			$result = $surveyGallery->save();
			/* Save Image path and name in DB[28-03-2024] END */
			/* send Mail [29-03-2024] */
 
			$data = [
				'name' => $firstName,
				'panelist_id' => $panelistId,
				'pageLink' => url('/admin/auth/panelistUpload')
			];
			$subject = 'File Uploaded by panelist';
			Mail::to('amarjitm@samplejunction.com')->send(new CustomEmail($data,$subject));

            //===== Added by Pushpendra ========\\
            /* This code is used to update the campaign status value to track the link is clicked or not */
			if(session()->has('code_id')){
                $code = session()->get('code_id');
                $campaign = campaign_history::where('campaign_code', $code)->first();
                if($campaign){
                    $campaign->status = 1;
                    $campaign->link_status_date = now()->toDateTimeString();
                    $campaign->save();   
                }
            }
            //===== Added by Pushpendra ========\\

            // You may save the file path in the database or perform any other necessary operations
            return redirect()->back()->with('success', 'Thank you! Your Document has been uploaded successfully.');
        }
 
        return redirect()->back()->with('error', 'Failed to upload file.');		
 
    }

	
/* Anil [10-12-2024] */

	public function rewardsUS(){
		$topPanelists = $this->userRepository->getTopPanelists();
		$currentDate = now();
		$currentMonth = now()->format('m'); 
        $currentYear = now()->format('Y');
		return view('frontend.rewardsUS')
		   ->with('currentDate',$currentDate)
		   ->with('topPanelists',$topPanelists);
	}
	public function rewardsUK(){
		$topPanelists = $this->userRepository->getTopPanelists();
		$currentDate = now();
		$currentMonth = now()->format('m'); 
        $currentYear = now()->format('Y');
		return view('frontend.rewardsUK')
		   ->with('currentDate',$currentDate)
		   ->with('topPanelists',$topPanelists);
	}
	public function rewardsCA(){
		$topPanelists = $this->userRepository->getTopPanelists();
		$currentDate = now();
		$currentMonth = now()->format('m'); 
        $currentYear = now()->format('Y');
		return view('frontend.rewardsCA')
		   ->with('currentDate',$currentDate)
		   ->with('topPanelists',$topPanelists);
	}
	
public function rewardsIN(){
		$currentDate = now();
		$currentMonth = now()->format('m'); 
        $currentYear = now()->format('Y');
		return view('frontend.rewardsIN')
		   ->with('currentDate',$currentDate);
	}


	public function rewardsByCountry($country_code = 'US'){
		if(!in_array($country_code, $this->rewardService->getActiveCountriesCode())){
			abort(404);
		}

		$now = Carbon::now();
		$thisMonth = Carbon::now()->subMonth();
		$previousMonth = Carbon::now()->subMonth(2);

		$thisMonthWinners=$this->rewardService->getTopPanelistsByCountry($country_code,$thisMonth->format('Y-m'));
		$previousMonthWinners = $this->rewardService->getTopPanelistsByCountry($country_code,$previousMonth->format('Y-m'));

		// echo '<pre>';
		// print_r($thisMonthWinners);
		// die;
		// $countriesFlagArr = [
		// 	'US' => asset('img/US_Flag.png'),
		// 	'UK' => asset('img/UK_Flag.png'),
		// 	'CA' => asset('img/CA_Flag.png'),
		// 	'IN' => asset('img/IN_Flag.png'),
		// ];
		$countriesFlagImg='img/'.$country_code.'_Flag.png';

		$bannerName="img/countryRewardPageBanner.png";

		$awardTypeBadge=[
			'1'=>asset('img/bronzebadge.png'),
			'2'=>asset('img/silverbadge.png'),
			'3'=>asset('img/goldbadge.png'),
		];

		return view('frontend.rewardsByCountry')->with([
			'country_code'=>$country_code,
			'thisMonthWinners'=>$thisMonthWinners,
			'previousMonthWinners'=>$previousMonthWinners,
			'thisMonthName' => $thisMonth->format('F'),
			'thisYear' => $thisMonth->format('Y'),
			'previousMonthName' => $previousMonth->format('F'),
			// 'countriesFlag'=>$countriesFlagArr[$country_code],
			'countriesFlag'=>asset($countriesFlagImg),
			'bannerImage'=>asset($bannerName),
			'awardTypeBadge'=>$awardTypeBadge,
			'thresholdPoints'=>$this->rewardService->getCountryThresholdPoints($country_code)
		]);
	}

	// public function rewardsIN(){
	// 	return view('frontend.rewardsIN');
	// }


}
