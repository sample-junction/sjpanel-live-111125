<?php

namespace App\Http\Controllers\Backend\Auth\Reward;

use App\Http\Controllers\Controller;
use App\Models\Reward\Award;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\RewardService;
use App\Models\Reward\RewordCountryInfo;
use App\Models\Reward\AwardsMailTemplate;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Backend\Award\AwardInvitation;
use App\Models\Reward\AwardsMailHistory;
use Ramsey\Uuid\Uuid;
use App\Models\Reward\SJPanelMonthlyAward;

/**
 * Class CountryInfoController.
 */
class CountryInfoController extends Controller
{
    /**
     * @var RewardService
     */
    protected $rewardService;

    /**
     * CountryInfoController constructor.
     *
     * @param RewardService $rewardService
     */
    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    public function index()
    {
        $data = $this->rewardService->getAllCountriesInfo();
        $month_obj = Carbon::now()->subMonth();
        $award_month = $month_obj->format('Y-m');

        foreach ($data as &$country) {
            $awardHtml = $this->rewardService->getAwardWinnerMailHtml($award_month, $country->country_code);
            $country->hasAward = (!empty($awardHtml));
        }

        $templates = AwardsMailTemplate::orderBy('id', 'desc')->pluck('template_name', 'id')->toArray();

        return view('backend.auth.reward.country_info/index')->with([
            'countries_info' => $data,
            'templates' => $templates,
        ]);
    }

    public function createCountryInfo()
    {
        $templates = AwardsMailTemplate::orderBy('id', 'desc')->pluck('template_name', 'id')->toArray();

        return view('backend.auth.reward.country_info/create')->with([
            'countries' => $this->rewardService->getCountryForRewards(true),
            'mail_templates' => $templates
        ]);
    }

    public function editCountryInfo($id)
    {
        $countryInfo = RewordCountryInfo::find($id);

        if (empty($countryInfo)) {
            return redirect()->back()
                ->with('flash_danger', 'Unable to edit Countries Info');
        }

        $templates = AwardsMailTemplate::orderBy('id', 'desc')->pluck('template_name', 'id')->toArray();

        return view('backend.auth.reward.country_info/edit')->with([
            'countryInfo' => $countryInfo,
            'countryInfoDate' => Carbon::parse($countryInfo->date_time)->toDateString(),
            'countryInfoTime' => Carbon::parse($countryInfo->date_time)->format('H:i'),
            'countries' => $this->rewardService->getCountryForRewards(true),
            'mail_templates' => $templates
        ]);
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'reward_country' => 'required',
            'country_zoom_link' => 'required',
            'zoom_link_date' => 'required',
        ]);

        $month_obj = Carbon::now()->subMonth();
        $award_month = $month_obj->format('Y-m');
        $awardHtml = $this->rewardService->getAwardWinnerMailHtml($award_month, $request->reward_country);

        if(!$awardHtml && $request->active_cron_job=='1' ){
            return redirect()->back()
            ->with('flash_danger', 'Select a winner for this country before activating the mail scheduler.');
        }

        $saveCountryInfo = [
            'country_code' => $request->reward_country,
            'zoom_link' => $request->country_zoom_link,
            'date_time' => $request->zoom_link_date . ' ' . $request->zoom_link_time . ':00',
            'status' => (int) $request->reward_status,
            'active_cron_job' => (int) $request->active_cron_job,
            'award_mail_temp' => (int) $request->mail_template,
        ];

        if ($this->rewardService->saveCountryInfo($saveCountryInfo)) {

            return redirect()->route('admin.auth.reward.country_info.list')
                ->with('flash_success', 'Countries Info Successfully Updated');
        }

        return redirect()->back()
            ->with('flash_danger', 'Countries Info Not updated');
    }

    public function deleteCountryInfo($id)
    {

        try {
            RewordCountryInfo::where('id', $id)->delete();
            return redirect()->back()
                ->with('flash_success', 'Countries Info Deleted');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Countries Info Not Deleted');
    }

    public function rewardBanner()
    {
        $bannerImg = asset("img/countryRewardPageBanner.png");

        return view('backend.auth.reward.banner')->with(['bannerImg' => $bannerImg]);
    }
    public function rewardBannerPost(Request $request)
    {

        if ($request->hasFile('reward_banner')) {
            $fileName = "countryRewardPageBanner.png";
            $hasFile = public_path('img/' . $fileName);

            if (file_exists($hasFile)) {
                unlink($hasFile);
            }

            $file = $request->file('reward_banner');
            $path = $file->move(public_path('img'), $fileName);
            return redirect()->back()->with('success', 'Banner uploaded successfully!');
        }

        return redirect()->back()
            ->with('flash_danger', 'Something Went Wrong.');
    }

    public function countryTempPreview($country_id, $temp_id = null)
    {
        // get country info
        $countryInfo = RewordCountryInfo::find($country_id);

        if (empty($countryInfo)) {
            return ['status' => false, 'message' => 'country not find.'];
        }
        $finalData = $this->rewardService->getAwardMailVariablesValue(false, $countryInfo->country_code);
        if (!$finalData) {
            return ['status' => false, 'message' => 'Something went wrong.'];
        }

        $template_id = empty($temp_id) ? $countryInfo->award_mail_temp : $temp_id;

        $templates = AwardsMailTemplate::where('id', $template_id)->first();
        if (!$templates) {
            return ['status' => false, 'message' => 'Mail template not found for country code ' . $countryInfo->country_code];
        }

        $html = str_replace(array_keys($finalData), array_values($finalData), $templates->template_content);

        return ['status' => true, 'message' => '', 'content' => $html];
    }

    public function send_participants_mail(Request $request)
    {

        $c_code = $request->country_code;
        $temp_id = $request->template;

        // dd($request->all());
        $countryInfo = RewordCountryInfo::where('country_code', $c_code)->first();

        if (!$countryInfo) {
            return redirect()->back()->with('flash_danger', 'country_code is required.');
        }

        $templates = AwardsMailTemplate::where('id', $temp_id)->first();

        if (!$templates) {
            return redirect()->back()->with('flash_danger', 'country_code is required.');
        }

        $users = DB::table('users')
            ->where('country_code', $c_code)
            ->where('active', 1)
            ->where('unsubscribed', '0')
            ->where('confirmed', 1)
            ->whereNull('deleted_at')  // Added this condition by Himanshu 05-11-2025
            ->where('is_blacklist', 0) // Added this condition by Himanshu 05-11-2025
            ->select('first_name', 'email', 'panellist_id')
            ->get();


        $hasError = '';
        $finalData = $this->rewardService->getAwardMailVariablesValue(false, $c_code, null, $hasError);
        // $finalData[':userFristName'] = 'your name';

        if (!empty($hasError)) {
            return redirect()->back()->with('flash_danger', 'Something went wrong.');
        }

        $awradSettings = $this->rewardService->getAwardTestSettings();
        foreach ($users as $user) {
            // return redirect()->back()->with('flash_danger', 'stoped for testing.');

            $finalData[':userFristName'] = ucfirst(decrypt($user->first_name));

            $json_data = json_encode($finalData);
            $email = decrypt($user->email);

            $finalData['mail_subject'] = str_replace(array_keys($finalData), array_values($finalData), $templates->email_subject);
            $finalData['mail_content'] = str_replace(array_keys($finalData), array_values($finalData), $templates->template_content);

            try {
                if ($email) {
                    if($awradSettings['test_mode']==1){
                        // $to = 'himanshu.sjpl@gmail.com'; // for testing
                        // $to = 'rohinitest001@gmail.com'; // for testing
                        $email = $awradSettings['test_emails_arr'];
                        
                    }
                    Mail::to($email)->send(new AwardInvitation($finalData));
                }

                // for testing
                // Mail::to('rohinitest001@gmail.com')->send(new AwardInvitation($finalData));

                $historyData = [
                    'panellist_id' => $user->panellist_id,
                    'mail_template' => $temp_id,
                    'mail_data' => $json_data,
                    'country_code' => $c_code,
                ];

                AwardsMailHistory::create($historyData);
                if($awradSettings['test_mode']==1){                    
                    break; // for testing only
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('flash_danger', 'Get error in mail send.');
                // error
            }
            //return redirect()->back()->with('flash_success', 'Mail send successfully .');
        }
        return redirect()->back()->with('flash_success', 'Mail send successfully .');
    }

    public function createBlog($id)
    {
        if (!$id) {
           return redirect()->back()
            ->with('flash_danger', 'Countries Info Id not found');
        }
        $monthObj = now()->subMonth();
        
        $countryInfo = RewordCountryInfo::leftJoin('countries','countries.country_code','=','reword_country_info.country_code')
                    ->where('reword_country_info.id', $id)->first();

        if (!$countryInfo) {
           return redirect()->back()
            ->with('flash_danger', 'Countries Info not found');
        }

        $winners = SJPanelMonthlyAward::where('SJPanel_Monthly_award.country_code', $countryInfo->country_code)
            ->leftJoin('users', 'users.panellist_id', '=', 'SJPanel_Monthly_award.panellist_id')
            ->where('SJPanel_Monthly_award.award_type', '!=', 5)
            ->where('SJPanel_Monthly_award.award_month', $monthObj->format('Y-m'))
            ->get();

        // dd($winners->count());

        if ($winners->count() == 0) {
            return redirect()->back()
            ->with('flash_danger', "Winners not found for {$countryInfo->country_code} ".$monthObj->format('Y-m'));
        }

        $images = $this->getImagesForPost($countryInfo->country_code);

        $month = $monthObj->format('F');
        $country = $countryInfo->name;


        $thumbnail_image = $images['thumb'];

        $id = Uuid::uuid4()->toString();
        $title = "SJ Panel {$month} Monthly Award Ceremony - {$country} ";
        $body = view('backend.auth.reward.country_info.blog_post')->with([
                'winners' => $winners,
                'banner_image' => $images['banner'],
                'month' => $month,
                'country'=>$country
            ])->render();
        $meta_title = "SJ Panel {$month} Monthly Award Ceremony – Celebrating Top Panelists in {$country} ";
        $meta_desc = "Discover the SJ Panel {$month} Monthly Award Winners in {$country}! Meet our Most Active Panelist, Survey Superstar, and Profile Prodigy. Congratulations to {winner} and all our amazing panelists who make surveys meaningful every day. ";
        $meta_key = "SJ Panel {$month} awards, SJ Panel {$country} winners, SJ Panel monthly award ceremony, SJ Panel survey rewards, SJ Panel top panelists {$month}, online survey awards {$country}, SJ Panel Survey Superstar, SJ Panel Most Active Panelist, SJ Panel Profile Prodigy ";

        $title = str_replace(' -','',$title);
        $slug = str_replace(' ', '-', strtolower(trim($title)));

        $country_code = ($countryInfo->country_code=='UK')?'GB':$countryInfo->country_code;

        $unique_slug = $this->generateUniqueSlug($slug);
        $dbObj = DB::connection('mysql_additional')->table('canvas_posts')->insert([
            'id'                     => $id,
            'slug'                   => $unique_slug,
            'title'                  => $title,
            'summary'                => 'This is a short summary',
            'body'                   => $body,
            'published_at'           => now(),
            'featured_image'         => null,
            'featured_image_caption' => null,
            'user_id'                => 5, // adjust this
            'meta'                   => json_encode([
                'og_title'            => null,
                'meta_title'          => $meta_title,
                'meta_keywords'       => $meta_key,
                'twitter_title'       => null,
                'canonical_link'      => null,
                'og_description'      => null,
                'meta_description'    => $meta_desc,
                'twitter_description' => null,
            ]),
            'created_at'             => now(),
            'updated_at'             => now(),
            'deleted_at'             => null,
            'thumbnail_image'        => $thumbnail_image,
            'thumbnail_image_caption' => null,
            'post_status'            => 'published',
            'meta_tags'              => json_encode([]),
            'site_info'              => 1,
            'category_id'            => 1,
            'sub_category_id'        => '',
            // 'countries'              => null,
            'countries'              => json_encode([$country_code]),
        ]);

        return redirect()->back()->with('flash_success', 'Blog created successfully .');
    }

    protected function generateUniqueSlug(string $slug): string
    {
        $base = $slug;
        $i = 1;

        while (
            DB::connection('mysql_additional')->table('canvas_posts')
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function getImagesForPost($c_code)
    {
        if (!$c_code) return null;
        $month = date('n');
        $imageIndex = (($month - 1) % 6) + 1;

        return [
            'banner'  => "/images/award_blog/{$c_code}/B{$imageIndex}.png",
            'thumb'  => "/images/award_blog/{$c_code}/T{$imageIndex}.png"
        ];
    }
}
