<?php

namespace App\Http\Controllers\Backend\Auth\Reward;

use App\Http\Controllers\Controller;
use App\Models\Reward\Award;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\RewardService;
use App\Models\Reward\RewordCountryInfo;
use App\Models\Reward\CountryAwardPoint;
use DB;
use App\Models\Reward\SJPanelMonthlyAward;
use App\Models\Auth\User;



/**
 * Class PointSystemController.
 */
class PointSystemController extends Controller
{
    /**
     * @var RewardService
     */
    protected $rewardService;

    /**
     * PointSystemController constructor.
     *
     * @param RewardService $rewardService
     */
    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    public function index()
    {

        $country_award_points = CountryAwardPoint::join('awards', 'awards.id', '=', 'country_award_points.award_id')
            ->leftJoin('countries', DB::raw("CONVERT(countries.country_code USING utf8mb4)"), '=', DB::raw("CONVERT(country_award_points.country_code USING utf8mb4) COLLATE utf8mb4_unicode_ci"))
            ->select('country_award_points.*', 'awards.name as award_name', 'countries.name as country_name')
            ->get();


        return view('backend.auth.reward.point_system.index')->with([
            'countries' => $this->rewardService->getAllCountriesInfo(),
            'award_type' => Award::get(),
            'country_award_points' => $country_award_points
        ]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'country' => 'required',
            'award_id' => 'required',
            'points' => 'required|numeric',
            'award_amount' => 'required',
        ]);

        $saveCountryInfo = [
            'country_code' => $request->country,
            'award_id' => $request->award_id,
            'award_point' => $request->points,
            'award_amount' => $request->award_amount,
            'created_by' => auth()->id(),
        ];
        $countryAwardPoint = CountryAwardPoint::updateOrCreate(
            [
                'country_code' => $request->country,
                'award_id' => $request->award_id,
            ],
            $saveCountryInfo
        );

        if ($countryAwardPoint->wasRecentlyCreated) {
            return redirect()->back()
                ->with('flash_success', 'Countries Award Points Successfully Created');
        } else {
            return redirect()->back()
                ->with('flash_success', 'Countries Award Points Successfully Updated');
        }
    }

    public function delete($id)
    {
        try {
            CountryAwardPoint::where('id', $id)->delete();
            return redirect()->back()
                ->with('flash_success', 'Country Award Points Deleted');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()->with('flash_danger', 'Country Award Points Not Deleted');
    }


    public function creditJoiningPoints()
    {
        return view('/backend/auth/reward/panellist_points')->with([
            'countries' => $this->rewardService->getAllCountriesInfo(),
            'award_type' =>  Award::get(),
        ]);
    }

    public function postCreditJoiningPoints(Request $request)
    {
        $this->validate($request, [
            'month' => 'required',
        ]);

        /*$awardTemplate = Award::where('id','5')->value('mail_template_id');

        if(!$awardTemplate){
            return redirect()->back()
                    ->withErrors(['panellist_id' => 'Award mail template is not selected for Joining bonus.'])
                    ->withInput();
        }
        */

        if (!$request->filled('panellist_id') && !$request->hasFile('panellist_csv')) {
            return redirect()->back()
                ->withErrors(['panellist_id' => 'Please enter panellist IDs or upload a CSV.'])
                ->withInput();
        }

        $export = [];
        if ($request->hasFile('panellist_csv')) {
            $file = $request->file('panellist_csv');

            if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
                $i = 0;
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $i++;
                    if ($i == 1) {
                        continue;
                    }
                    if (!empty($row[0])) {
                        $export[] = $row[0];
                    }
                }
                fclose($handle);
            }

            if (empty($export)) {
                return redirect()->back()
                    ->withErrors(['panellist_id' => 'Uploaded CSV file is empty.'])
                    ->withInput();
            }
        } else {
            $export = array_map('trim', explode(",", $request->input('panellist_id')));
        }

        $awardType = 5;  // for joining bonus
        $awardMonth = Carbon::parse($request->month . '-01');

        $users = User::leftJoin('panellist_address', 'users.id', '=', 'panellist_address.user_id')
            ->whereIn('panellist_id', $export)
            ->select(
                'users.country_code',
                'users.panellist_id',
                'panellist_address.city',
                'panellist_address.state'
            )->get();

        $usersCountries = [];
        if ($users) {
            foreach ($users as $user) {
                $usersCountries[$user->panellist_id] = $user->toArray();
            }
        }

        $alreadyCreditUsers = SJPanelMonthlyAward::where('award_type', '5')->where('award_month', $request->month)->pluck('panellist_id')->toArray();

        $errorsArray = [];
        $successArray = [];
        if (!empty($export) && !empty($usersCountries)) {

            foreach ($export as $panellistId) {

                if (in_array($panellistId, $alreadyCreditUsers)) {
                    $errorsArray[$panellistId] = 'Points already creadit to account ' . $panellistId;
                    continue;
                }

                $userData = $usersCountries[$panellistId];
                $country_code = $userData['country_code'];
                $countryAwardData = $this->rewardService->getCountryAwardPoints($country_code, $awardType);
                if (!$countryAwardData) {
                    $errorsArray[$panellistId] = 'Points not found for country ' . $country_code;
                    continue;
                }

                $points = (int) $countryAwardData['award_point'];

                $response = $this->rewardService->creditPanelistPoints($panellistId, $points, $awardType, $awardMonth);
                                // dd($response);

                if (!$response['status']) {
                    $errorsArray[$panellistId] = $response['message'];
                } else {
                    $successArray[$panellistId] = $response['message'];

                    $amount = $this->rewardService->calculateAmountFromPoints($points, $country_code);
                    $saveData = [
                        'panellist_id' => $panellistId,
                        'country_code' => $country_code,
                        'award_type' => $awardType,
                        'award_month' => $request->month,
                        'nominations' => null,
                        'city_state' => ($userData['city']) ? $userData['city'] . ' ' . $userData['state'] : null,
                        'points' => $points,
                        'amount' => $amount,
                        'dollar_amount' => $this->rewardService->getDollarValue($points, $country_code)
                    ];


                    //$this->rewardService->saveMonthlyReward($saveData);

                    SJPanelMonthlyAward::create($saveData);
                }
            }
        }


        if (empty($errorsArray)) {
            return redirect()->back()->with('flash_success', 'Points Credited Successfully')->with('points_success', $successArray);
        } else {
            return redirect()->back()->with('flash_danger', 'Failed to Credit Points')->with('points_error', $errorsArray);
        }
    }


    /* public function getCountryAwardPoints(Request $request)
    {
        if(!$request->country_code || !$request->award_id){
            return response()->json(['status'=>false, 'data'=>'','message'=>'Country code and Award is required.']);
        }

        $points = $this->rewardService->getCountryAwardPoints($request->country_code, $request->award_id);

        if(!empty($points)){
            $response = ['status'=>true, 'data'=>$points,'message'=>''];
        }else{
            $response = ['status'=>false, 'data'=>'','message'=>'Points not found for this country and Award.'];
        }

        return response()->json($response);
    }*/

    public function creditPanellistPoints($id)
    {
        $panellist = SJPanelMonthlyAward::find($id);

        $errorMsg = '';
        if ($panellist) {
            if (empty($panellist->dollar_amount)) {
                $awardMonth = Carbon::parse($panellist->award_month . '-01');
                $response = $this->rewardService->creditPanelistPoints($panellist->panellist_id, $panellist->points, $panellist->award_type, $awardMonth);

                if ($response['status']) {
                    return redirect()->back()->with('flash_success', 'Points Credited Successfully');
                }

                $errorMsg = $response['message'];
            } else {
                $errorMsg = 'Points are alreday creadit to this account';
            }
        } else {
            $errorMsg = 'No data found';
        }
        return redirect()->back()->with('flash_danger', $errorMsg);
    }
}
