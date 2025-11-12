<?php

namespace App\Http\Controllers\Backend\Auth\Reward;

use App\Http\Controllers\Controller;
use App\Models\Reward\Award;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\RewardService;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use DB;
use App\Models\Reward\SJPanelMonthlyAward;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\Backend\Award\AwardInvitation;
use App\Models\Reward\AwardsMailTemplate;
use Ramsey\Uuid\Uuid;

/**
 * Class RewardController.
 */
class RewardController extends Controller
{
    /**
     * @var RewardService
     */
    protected $rewardService;
    public $userAddRepo;

    /**
     * RewardController constructor.
     *
     * @param RewardService $rewardService
     */
    public function __construct(RewardService $rewardService, UserAdditionalDataRepository $userAddRepo)
    {
        $this->rewardService = $rewardService;
        $this->userAddRepo = $userAddRepo;
    }


    public function rewardsAutomation()
    {

        // $data =DB::connection('mysql_additional')->table('canvas_posts')
        //             ->where('site_info', '=', '1')
        //             ->get();
        //     dd($data);




        $allAwards = Award::pluck('name', 'id')->toArray();

        return view('backend.auth.reward.index')->with([
            'countries' => $this->rewardService->getAllCountriesInfo(),
            'award_type' => $this->rewardService->getActiveAwards(),
            'allAwardsArr' => $allAwards
        ]);
    }
    public function processRewardsAutomation(Request $request)
    {
        $this->validate($request, [
            'reward_country' => 'required',
            'award_type' => 'required',
            'month_year' => 'required',
            // 'points' => 'required',
        ]);

        $country_code = $request->reward_country;
        $award_type = $request->award_type;
        $yearMonth = $request->month_year;
        $startDate = Carbon::parse($yearMonth . '-01')->startOfMonth();
        $endDate = Carbon::parse($yearMonth . '-01')->endOfMonth();

        $panellists = [];

        /*
        // test process start
        $command = '/usr/bin/php '.base_path('artisan').' custom:send-award-invitation-emails';
        $output = shell_exec($command);
        
        $out= nl2br($output);
        echo $out;
        die;
        
        // $this->rewardService->sendInvitationMail('CA');
        // dd('send');
        // test process end

        */


        // $hasWinner = $this->rewardService->isCountryWinnerSelected($country_code,$request->award_type,$yearMonth);
        $hasWinner = false;
        $panellists = $this->rewardService->getFilteredAwardWinners($startDate, $endDate, $country_code, $award_type);

        return response()->json(['panellists' => array_values($panellists), 'hasWinner' => $hasWinner]);
    }

    public function awardsList()
    {
        $awards = Award::leftJoin('awards_mail_template', 'awards_mail_template.id', '=', 'awards.mail_template_id')
            ->select(['awards.*', 'awards_mail_template.template_name as temp_name'])
            ->get();
        return view('backend.auth.reward.awards_list', compact('awards'));
    }

    public function createAward()
    {
        $templates = AwardsMailTemplate::orderBy('id', 'desc')->pluck('template_name', 'id')->toArray();

        return view('backend.auth.reward.award_create')->with([
            'mail_templates' => $templates
        ]);
    }

    public function postCreateAward(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            // 'nomination_start' => 'required',
            // 'nomination_end' => 'required',
        ]);

        $saveData = $request->only(['name', 'status', 'nomination_start', 'nomination_end', 'mail_template_id']);

        try {
            if (Award::where('name', $saveData['name'])->first()) {
                return redirect()->back()
                    ->with('flash_danger', 'Award with the same name already exists');
            }

            Award::create($saveData);

            return redirect()->route('admin.auth.awards.list')
                ->with('flash_success', 'New Award Created');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Award Not Created');
    }

    public function editAward($id)
    {
        $award = Award::find($id);
        $templates = AwardsMailTemplate::orderBy('id', 'desc')->pluck('template_name', 'id')->toArray();
        return view('backend.auth.reward.award_edit')->with([
            'award' => $award,
            'mail_templates' => $templates
        ]);
    }

    public function postEditAward(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
            // 'nomination_start' => 'required',
            // 'nomination_end' => 'required',
        ]);

        $saveData = $request->only(['name', 'status', 'nomination_start', 'nomination_end', 'mail_template_id']);

        try {
            if (Award::where('name', $saveData['name'])->where('id', '!=', $id)->first()) {
                return redirect()->back()
                    ->with('flash_danger', 'Award with the same name already exists');
            }

            Award::where('id', $id)->update($saveData);

            return redirect()->route('admin.auth.awards.list')
                ->with('flash_success', 'Award Updated');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Award Not Updated');
    }

    public function deleteAward($id)
    {
        try {
            Award::where('id', $id)->delete();
            return redirect()->back()
                ->with('flash_success', 'Award Deleted');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Award Not Deleted');
    }

    public function saveReward(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'data' => 'required',
        ]);

        $winnerData = $request->data;

        if (!$winnerData && !empty($winnerData)) {
            return response()->json(['successArr' => [], 'errorArr' => [], 'message' => 'Winner Data Not Found']);
        }

        $errorArr = [];
        $successArr = [];

        foreach ($winnerData as $winner) {
            $country_code = $winner['country_code'];
            if (!$winner['city_state']) {
                $errorArr[$winner['panellist_id']][] = 'City and State not found for panellist id: ' . $winner['panellist_id'];
                continue;
            }

            $countryAwardData = $this->rewardService->getCountryAwardPoints($country_code, $winner['award_type']);
            if (!$countryAwardData) {
                $errorArr[$winner['panellist_id']][] = 'Points not found for ' . $country_code;
                continue;
            }

            $points = $countryAwardData['award_point'];
            $amount = $countryAwardData['award_amount'];

            $nominations = $this->rewardService->getNominationsCount($winner['award_type']);
            if (!$nominations) {
                $errorArr[$winner['panellist_id']][] = 'Nominations not found for panellist id: ' . $winner['panellist_id'];
                continue;
            }

            $saveData = [
                'panellist_id' => $winner['panellist_id'],
                'country_code' => $country_code,
                'award_type' => $winner['award_type'],
                'award_month' => $winner['award_month'],
                'nominations' => $nominations,
                'city_state' => $winner['city_state'],
                'points' => $points,
                'amount' => $amount,
            ];

            // dd($saveData);
            if ($this->rewardService->saveMonthlyReward($saveData)) {
                $successArr[$winner['panellist_id']] = 'Reward Saved Successfully for ' . $winner['panellist_id'];
                // return redirect()->back()->with('flash_success', 'Reward Saved Successfully');
            }
        }

        return response()->json(['successArr' => $successArr, 'errorArr' => $errorArr, 'message' => '']);

        // return redirect()->back()->with('flash_danger', 'Failed to Save Reward');
    }

    public function rewardHistory(Request $request)
    {

        $country_code = '';
        $award_month = '';
        if ($request->has('reward_country')) {
            $country_code = $request->get('reward_country');
            $award_month = $request->get('award_month');
        }

        $winners_list = SJPanelMonthlyAward::leftJoin('users', 'SJPanel_Monthly_award.panellist_id', '=', 'users.panellist_id')
            ->leftJoin('countries', 'countries.country_code', '=', 'SJPanel_Monthly_award.country_code')
            ->leftJoin('awards', 'awards.id', '=', 'SJPanel_Monthly_award.award_type')
            ->leftJoin('panellist_address', 'users.id', '=', 'panellist_address.user_id')
            ->select(
                'SJPanel_Monthly_award.*',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.zipcode',
                'users.confirmed',
                'users.active',
                'users.unsubscribed',
                'awards.name as award_name',
                'countries.name as country_name'
                // DB::raw('CONCAT(panellist_address.city," ",panellist_address.state)  as location')
            );
        if (!empty($country_code)) {
            $winners_list->where('SJPanel_Monthly_award.country_code', $country_code);
        }
        if (!empty($award_month)) {
            $winners_list->where('SJPanel_Monthly_award.award_month', $award_month);
        }
        $winners_list = $winners_list->get();

        // echo '<pre>';
        // print_r($winners_list->toArray());
        // die;

        return view('backend.auth.reward.award_winners.index')->with([
            'winners_list' => $winners_list,
            'countries' => $this->rewardService->getAllCountriesInfo()
        ]);
    }

    public function deleteRewardHistory($id)
    {
        try {
            SJPanelMonthlyAward::where('id', $id)->delete();
            return redirect()->back()
                ->with('flash_success', 'Award History Deleted');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Award History Not Deleted');
    }

    public function editRewardHistory($id)
    {
        try {
            $awardData = SJPanelMonthlyAward::find($id);

            $redeemed_date = $redeemed_time = '';
            if (!empty($awardData->redemption_at)) {
                $redeemed_date = Carbon::parse($awardData->redemption_at)->format('Y-m-d');
                $redeemed_time = Carbon::parse($awardData->redemption_at)->format('H:i');
            }

            return view('backend.auth.reward.award_winners.edit')->with([
                'awardData' => $awardData,
                'redemption_date' => $redeemed_date,
                'redemption_time' => $redeemed_time
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('flash_danger', 'Award History Not Found');
        }
    }

    public function postEditRewardHistory(Request $request, $id)
    {

        $redemption_at = null;
        if (!empty($request->redemption_date)) {
            $redemption_at = Carbon::parse("{$request->redemption_date} {$request->redemption_time}");
        }

        $updateData = [
            'redemption_status' => $request->redemption_status ?? null,
            'redemption_at' => $redemption_at,
        ];

        try {
            SJPanelMonthlyAward::where('id', $id)->update($updateData);
            return redirect()->back()->with('flash_success', 'Award History Updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_danger', 'Award History Not Updated');
        }
    }

    public function calculatePointsAmount(Request $request)
    {
        $points = trim($request->points);
        $country_code = trim($request->reward_country);

        if (!empty($points) && !empty($country_code)) {
            $amount = $this->rewardService->calculateAmountFromPoints($points, $country_code);
            if (!empty($amount)) {
                return response()->json(['status' => true, 'amount' => $amount]);
            }
        }

        return response()->json(['status' => false, 'amount' => '']);
    }

    public function postCityStateRewardHistory(Request $request, $id)
    {
        $updateData = [
            'city_state' => $request->city_state ?? null,
        ];

        try {
            SJPanelMonthlyAward::where('id', $id)->update($updateData);
            return redirect()->back()->with('flash_success', 'Award History Updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_danger', 'Award History Not Updated');
        }
    }

    // public function listNominations()
    // {
    //     dd('welcome to nominations');
    // }

}
