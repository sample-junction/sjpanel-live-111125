<?php

namespace App\Services;

use DB;
use App\Models\Reward\Award;
use App\Models\Reward\RewordCountryInfo;
use App\Models\Reward\SJPanelMonthlyAward;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Models\Auth\User;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use Spatie\Activitylog\Models\Activity;
use App\Models\Setting\Setting;
use App\Models\Reward\CountryAwardPoint;
use Illuminate\Support\Facades\Mail;
use App\Mail\Backend\Award\AwardInvitation;
use App\Models\Reward\AwardsMailHistory;


class RewardService
{
    public $userAddRepo;

    public function __construct(UserAdditionalDataRepository $userAddRepo)
    {
        $this->userAddRepo = $userAddRepo;
    }

    public function getActiveAwards()
    {
        return Award::where('status', 1)->get();
    }

    public function getCountryForRewards($getAll = false)
    {
        $countries = DB::table('countries');
        if (!$getAll) {
            $countryCodes = ['us', 'uk', 'ca', 'in'];
            $countries->whereIn('country_code', $countryCodes);
        }
        return    $countries->get();
    }

    public function getAllCountriesInfo()
    {
        return DB::table('reword_country_info')
            ->leftJoin('countries', 'reword_country_info.country_code', '=', 'countries.country_code')
            ->leftJoin('awards_mail_template', 'reword_country_info.award_mail_temp', '=', 'awards_mail_template.id')
            ->select(['reword_country_info.*', 'countries.name as name', 'awards_mail_template.template_name'])
            ->get();
    }
    public function getActiveCountriesCode()
    {
        return DB::table('reword_country_info')
            ->where('reword_country_info.status', '1')
            ->pluck('country_code')->toArray();
    }

    public function saveCountryInfo(array $countryData)
    {
        try {
            RewordCountryInfo::updateOrCreate(
                ['country_code' => $countryData['country_code']],
                $countryData
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getFilteredAwardWinners($startDate, $endDate, $countryCodeArr, $awardTypeArr = [])
    {

        $panellists = DB::table('user_projects')
            ->leftJoin('users', 'user_projects.user_id', '=', 'users.id')
            ->leftJoin('panellist_address', 'user_projects.user_id', '=', 'panellist_address.user_id')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->select(
                'users.panellist_id',
                'users.first_name',
                'users.email',
                'users.last_name',
                'users.zipcode',
                'users.confirmed',
                'users.active',
                'users.unsubscribed',
                'users.country_code',
                'users.last_login_at',
                'users.uuid',
                'user_projects.status',
                DB::raw('CONCAT(panellist_address.city,", ",panellist_address.state)  as location'),
                DB::raw("(SELECT count(*) FROM user_projects WHERE user_projects.user_id = users.id AND user_projects.status IS NOT NULL AND user_projects.updated_at BETWEEN '{$startDate}' AND '{$endDate}') as surveys_attempted"),
                DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IN (1,50) AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') as surveys_completed"),
                DB::raw("(SELECT count(*) FROM activity_log WHERE causer_id = users.id AND log_name='default' AND description like '%inpanel.activity_log.profile%' AND updated_at BETWEEN '{$startDate}' AND '{$endDate}' ) as monthly_profiles_filled")
            )
            ->whereIn('users.country_code', $countryCodeArr)
            ->where([
                'model_has_roles.role_id' => 4,
                'users.unsubscribed' => '0',
                'users.confirmed' => 1,
                'users.active' => 1
            ])
            ->whereBetween('user_projects.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.first_name', 'users.last_name', 'users.panellist_id', 'users.zipcode', 'users.active')
            ->orderByDesc('surveys_completed')
            ->get()->toArray();

        $panellistsByCountry = [];

        // dd($panellists);

        $pastWinners =  $this->getPastAwardWinners($startDate);

        $selectedWinners = [];
        $sameEmailGroups = [];
        // dd('ss');
        foreach ($panellists as $p) {
            $p = (array) $p;

            $id     = $p['panellist_id'];
            $cc     = $p['country_code'];
            $login  = $p['last_login_at'];

            // Skip past winners
            if (isset($pastWinners[$id])) continue;

            // Skip if no login date
            if (empty($login)) continue;

            // Decrypt + normalize email once
            $email = strtolower(decrypt($p['email']));

            // Group by email + country
            $sameEmailGroups[$email][]   = $p;
            $panellistsByCountry[$cc][$id] = $p;
        }

        // filter for remove dublicate email accounts
        $removeids = [];
        foreach ($sameEmailGroups as $panellists) {
            if (count($panellists) > 1) {
                $removeids = array_merge($removeids, $this->filterFailedPanelistIds($panellists));
            }
        }
        $removeids = array_values(array_unique($removeids));
        // end here


        $allProfilesCompletedPanelists = $this->getAllCompletedProfilesPanelists($startDate, $endDate, $countryCodeArr);

        $awardsByCountry = [];
        foreach ($panellistsByCountry as $country => $country_panelists) {
            $filteredWinners = $removeids;
            $selected = isset($selectedWinners[$country]) ? $selectedWinners[$country] : [];

            $profileProdigyId = 1;
            if (in_array($profileProdigyId, $awardTypeArr)) {
                $award_1_selectd = false;
                $profileProdigy = [];

                if (isset($selected[$profileProdigyId]) && !empty($selected[$profileProdigyId])) {
                    $profileProdigy[] = $selected[$profileProdigyId];
                    $award_1_selectd = true;
                } else {
                    $profileProdigyData = $this->filterCompletedProfiles($country_panelists, $allProfilesCompletedPanelists);
                    $profileProdigy = $this->filterPanellistsByMaxCount($profileProdigyData, $profileProdigyId, $filteredWinners);
                }

                $profileProdigyWinner = $this->commanFiltersForAwards($profileProdigy, $startDate);
                if (!empty($profileProdigyWinner) && isset($profileProdigyWinner['panellist_id'])) {
                    $profileProdigyWinner['award_id'] = $profileProdigyId;
                    $profileProdigyWinner['is_selected'] = $award_1_selectd;
                    $awardsByCountry[] = $profileProdigyWinner;
                    $filteredWinners[] = $profileProdigyWinner['panellist_id'];
                }
            }

            $serveySuperId = 2;
            if (in_array($serveySuperId, $awardTypeArr)) {
                $award_2_selectd = false;
                $serveySuperStar = [];

                if (isset($selected[$serveySuperId]) && !empty($selected[$serveySuperId])) {
                    $serveySuperStar[] = $selected[$serveySuperId];
                    $award_2_selectd = true;
                } else {
                    $serveySuperStar = $this->filterPanellistsByMaxCount($country_panelists, $serveySuperId, $filteredWinners);
                }

                $serveySuperStarWinner = $this->commanFiltersForAwards($serveySuperStar, $startDate);
                if (!empty($serveySuperStarWinner) && isset($serveySuperStarWinner['panellist_id'])) {
                    $serveySuperStarWinner['award_id'] = $serveySuperId;
                    $serveySuperStarWinner['is_selected'] = $award_2_selectd;
                    $awardsByCountry[] = $serveySuperStarWinner;
                    $filteredWinners[] = $serveySuperStarWinner['panellist_id'];
                }
            }

            $mostActiveId = 3;
            if (in_array($mostActiveId, $awardTypeArr)) {
                $award_3_selectd = false;
                $mostActiveUser = [];

                if (isset($selected[$mostActiveId]) && !empty($selected[$mostActiveId])) {
                    $mostActiveUser[] = $selected[$mostActiveId];
                    $award_3_selectd = true;
                } else {
                    $mostActiveUser = $this->filterPanellistsByMaxCount($country_panelists, $mostActiveId, $filteredWinners);
                }

                $mostActiveUserWinner = $this->commanFiltersForAwards($mostActiveUser, $startDate);
                if (!empty($mostActiveUserWinner) && isset($mostActiveUserWinner['panellist_id'])) {
                    $mostActiveUserWinner['award_id'] = $mostActiveId;
                    $mostActiveUserWinner['is_selected'] = $award_3_selectd;
                    $awardsByCountry[] = $mostActiveUserWinner;
                    $filteredWinners[] = $mostActiveUserWinner['panellist_id'];
                }
            }

            if (in_array($serveySuperId, $awardTypeArr) && empty($serveySuperStar)) {
                // if no serveySuperstar found
                // $serveySuperStar = $this->ifNoServeySuperStarFound($country_panelists, $filteredWinners);
                $mostActiveUser = $this->filterPanellistsByMaxCount($country_panelists, $mostActiveId, $filteredWinners);

                $serveySuperStarWinner = $this->commanFiltersForAwards($mostActiveUser, $startDate);
                if (!empty($serveySuperStarWinner) && isset($serveySuperStarWinner['panellist_id'])) {
                    $serveySuperStarWinner['award_id'] = $serveySuperId;
                    $serveySuperStarWinner['is_selected'] = $award_2_selectd;
                    $awardsByCountry[] = $serveySuperStarWinner;
                    $filteredWinners[] = $serveySuperStarWinner['panellist_id'];
                }
            }
        }

        // dd( $awardsByCountry);
        return $awardsByCountry;
    }

    public function filterFailedPanelistIds($panellists)
    {
        if (empty($panellists)) {
            return [];
        }

        $finalArr = [];
        $groupedData = [];

        foreach ($panellists as $p) {
            $id = $p['panellist_id'];
            $attempts = $p['surveys_attempted'];
            $completed = $p['surveys_completed'];

            $finalArr[$id] = true;
            $groupedData[$attempts][$completed][] = $id;
        }

        // Find group with max attempts → max completed
        $maxAttempts = max(array_keys($groupedData));
        $maxCompleted = max(array_keys($groupedData[$maxAttempts]));
        $winnerId = reset($groupedData[$maxAttempts][$maxCompleted]);

        // Remove winner
        unset($finalArr[$winnerId]);

        // Return sorted list of failed IDs
        $failedIds = array_keys($finalArr);

        return $failedIds;
    }


    public function commanFiltersForAwards($panellists, $date)
    {

        if (count($panellists) > 1) {
            $panellists = $this->filterByLastLogin($panellists);
        }

        $panellists = $this->addSurveyDurations($panellists, $date);

        if (count($panellists) > 1) {
            $panellists = $this->filterBySurveyDuration($panellists);
        }


        $panellist = (count($panellists) > 0 && isset($panellists[0])) ? $panellists[0] : [];

        if (isset($panellist['panellist_id'])) {

            $panellist['first_name'] = decrypt($panellist['first_name']);
            $panellist['last_name'] = decrypt($panellist['last_name']);
            $panellist['zipcode'] = decrypt($panellist['zipcode']);

            $panellist['profiles_filled'] = $this->getFilledProfiles((object) $panellist);
            // $panellist['profiles_filled'] = 'commented';

            $panellist['last_login_at'] = Carbon::parse($panellist['last_login_at'])->diffForHumans();

            if (isset($panellist['avg_survey_dur']) && !empty($panellist['avg_survey_dur'])) {
                $panellist['avg_survey_dur'] = \Carbon\CarbonInterval::seconds($panellist['avg_survey_dur'])->cascade()->forHumans();
            } else {
                $panellist['avg_survey_dur'] = '0 sec';
            }

            if (isset($panellist['t_avg_survey_dur']) && !empty($panellist['t_avg_survey_dur'])) {
                $panellist['t_avg_survey_dur'] = \Carbon\CarbonInterval::seconds($panellist['t_avg_survey_dur'])->cascade()->forHumans();
            } else {
                $panellist['t_avg_survey_dur'] = '0 sec';
            }
        }

        return $panellist;

        // return (count($panellists) > 0 && isset($panellists[0])) ? $panellists[0] : [];
    }

    public function filterCompletedProfiles($panellistData, $compleatedProfiles)
    {
        $groupData = [];
        foreach ($panellistData as $panellist) {
            if (in_array($panellist['panellist_id'], $compleatedProfiles)) {
                $groupData[] = $panellist;
            }
        }
        return $groupData;
    }

    public function addSurveyDurations($panellistData, $date = null)
    {
        if (empty($panellistData)) return [];
        $panellistIds = array_column($panellistData, 'panellist_id');

        $startDate = ($date) ? Carbon::parse($date)->startOfMonth() : '';
        $endDate = ($date) ? Carbon::parse($date)->endOfMonth() : '';

        $user_surveys = DB::table('survey_reports')
            ->leftJoin('users', function ($join) {
                $join->on(DB::raw("users.uuid COLLATE utf8mb4_unicode_ci"), '=', DB::raw("survey_reports.uuid COLLATE utf8mb4_unicode_ci"));
            })
            ->whereIn('users.panellist_id', $panellistIds);
        if (!empty($date)) {
            $user_surveys->whereBetween('survey_reports.createdOn', [$startDate, $endDate]);
        }

        $user_surveys = $user_surveys->select('survey_reports.duration', 'users.panellist_id')->get();

        $panellist_durations = [];
        foreach ($user_surveys as $servey) {
            $panellist_durations[$servey->panellist_id][] = $servey->duration;
        }


        $finalData = [];
        foreach ($panellistData as $panellist) {
            $panellist = (array) $panellist;

            $totalDuration = 0;
            $averageDuration = 0;

            if (isset($panellist_durations[$panellist['panellist_id']])) {
                $totalDuration = array_sum($panellist_durations[$panellist['panellist_id']]);
                $surveyCount = count($panellist_durations[$panellist['panellist_id']]);
                $averageDuration = round($totalDuration / $surveyCount);
            }

            $panellist['avg_survey_dur'] = $averageDuration;
            $panellist['t_avg_survey_dur'] = $totalDuration;

            $finalData[] = $panellist;
        }
        return $finalData;
    }

    public function getAllCompletedProfilesPanelists($startDate, $endDate, $countryCodeArr)
    {

        $userFilledProfilesInMonth = DB::table('activity_log')
            ->leftJoin('users', 'activity_log.causer_id', '=', 'users.id')
            ->where('activity_log.log_name', 'default')
            ->whereIn('users.country', $countryCodeArr)
            ->whereBetween('activity_log.updated_at', [$startDate, $endDate])
            ->where('activity_log.description', 'like', '%inpanel.activity_log.profile%')
            ->groupBy('activity_log.causer_id')
            ->orderByDesc('activity_log.causer_id')
            ->select('users.uuid', 'users.panellist_id')->get();


        if ($userFilledProfilesInMonth->count() <= 0) {
            return [];
        }

        $panellistsCompletedAllProfile = [];
        foreach ($userFilledProfilesInMonth as $user) {
            if ($this->getFilledProfiles($user) >= 8) {
                $panellistsCompletedAllProfile[] = $user->panellist_id;
            }
        }

        return $panellistsCompletedAllProfile;
    }

    public function saveMonthlyReward(array $winnerData)
    {
        // $award = Award::whereId($winnerData['award_type'])->first();
        $award = Award::leftJoin('awards_mail_template as a_temp', 'a_temp.id', '=', 'awards.mail_template_id')
            ->where('awards.id', $winnerData['award_type'])
            ->select([
                'awards.*',
                'a_temp.template_content',
                'a_temp.email_subject'
            ])->first();


        try {
            if (isset($winnerData['id']) && !empty($winnerData['id'])) {
                $award = SJPanelMonthlyAward::find($winnerData['id']);
                if ($award) {
                    $award->update($winnerData);
                    return true;
                }
            }

            // SJPanelMonthlyAward::create($winnerData);

            $record = SJPanelMonthlyAward::updateOrCreate(
                [
                    'country_code' => $winnerData['country_code'],
                    'award_month' => $winnerData['award_month'],
                    'award_type' => $winnerData['award_type']
                ],
                $winnerData
            );

            // $record->wasRecentlyCreated
            // send mail start
            if ($award->template_content) {
                // $this->sendMailToAwardWinner($winnerData['panellist_id'], $winnerData['country_code'], $winnerData['award_type']);
            }
            // send mail end 

            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            return false;
        }
    }

    public function sendMailToAwardWinner($panellist_id, $country_code, $award_id)
    {
        $user = User::where('panellist_id', $panellist_id)->first();
        if (!$user) {
            return ['status' => false, 'message' => 'User not forund, panellist id: ' . $panellist_id];
        }

        $award = Award::leftJoin('awards_mail_template as a_temp', 'a_temp.id', '=', 'awards.mail_template_id')
            ->where('awards.id', $award_id)
            ->select([
                'awards.*',
                'a_temp.template_content',
                'a_temp.email_subject'
            ])->first();

        if (!$award || empty($award->template_content)) {
            return ['status' => false, 'message' => "Award mail template is not selected or empty for '$award->name' "];
        }

        try {

            $hasError = '';

            $mailValues = $this->getAwardMailVariablesValue(false, $country_code, $panellist_id, $hasError);
            if (!empty($hasError) && $award_id != 5) {
                return ['status' => false, 'message' => $hasError];
            }

            $mail_subject = str_replace(array_keys($mailValues), array_values($mailValues), $award->email_subject);
            $mail_content = str_replace(array_keys($mailValues), array_values($mailValues), $award->template_content);

            $this->sendMail($user->email, $mail_subject, $mail_content);

            $historyData = [
                'panellist_id' => $panellist_id,
                'mail_template' => $award->mail_template_id,
                'mail_data' => json_encode($mailValues),
                'country_code' => $country_code,
            ];

            AwardsMailHistory::create($historyData);

            return ['status' => true, 'message' => "Mail send Successfully."];
        } catch (\Exception $e) {
            // error
        }
        return ['status' => false, 'message' => "Something went wrong."];
    }

    public function getFilledProfiles($user)
    {
        $count = 0;

        if ($user && isset($user->uuid)) {
            $count = $this->userAddRepo->getFilledProfilesCount($user);
        }

        return $count;
    }

    public function filterPanellistsByMaxCount($panellistData, $award_type, $removePanellist = [])
    {
        if (empty($panellistData)) return [];
        $filterKey = ($award_type == 3) ? "surveys_attempted" : 'surveys_completed';
        $innerFilterKey = (!$award_type == 3) ? "surveys_attempted" : 'surveys_completed';

        $groupedData = [];
        foreach ($panellistData as $panellist) {
            $panellist = (array) $panellist;

            // if ($award_type == 2  && !in_array($panellist['status'], [1, 50])) continue;
            // if ($award_type == 3  && $panellist['status'] === null) continue;

            if ($award_type == 2  && empty($panellist['surveys_completed'])) continue;
            if ($award_type == 3  && empty($panellist['surveys_attempted'])) continue;

            if (in_array($panellist['panellist_id'], $removePanellist)) continue;  // remove already selected panellist

            $mainFilterCount = $panellist[$filterKey];
            $innerFilterCount = $panellist[$innerFilterKey];

            $groupedData[$mainFilterCount][$innerFilterCount][] = $panellist;
        }

        if (!$groupedData) return [];

        $topMainGroup = $groupedData[max(array_keys($groupedData))] ?? [];
        if (!$topMainGroup) return [];

        $topInnerGroup = $topMainGroup[max(array_keys($topMainGroup))] ?? [];
        return $topInnerGroup;
    }

    public function filterBySurveyDuration($panellistData, $date = null)
    {
        if (count($panellistData) && empty($date)) {
            usort($panellistData, function ($a, $b) {
                return ($b['avg_survey_dur'] > $a['avg_survey_dur']) ? 1 : -1;
            });
        }

        return $panellistData;
    }

    public function filterByLastLogin($panellistData)
    {
        if (empty($panellistData)) return [];

        $groupedData = [];
        foreach ($panellistData as $panellist) {
            $panellist = (array) $panellist;

            $timestamp = strtotime($panellist['last_login_at']);
            if ($timestamp === false) continue;

            $groupedData[$timestamp][] = $panellist;
        }

        if (empty($groupedData)) return [];
        return $groupedData[max(array_keys($groupedData))];
    }

    public function getPastAwardWinners($date)
    {
        if (empty($date)) return [];
        $pastHistoryMonths = Carbon::parse($date)->subMonth(2)->format('Y-m');
        $pastWinners = SJPanelMonthlyAward::where('award_month', '>=', $pastHistoryMonths)
            ->where('award_type', '!=', '5')
            ->pluck('award_type', 'panellist_id')
            ->toArray();

        return $pastWinners;
    }

    public function calculateAmountFromPoints($points, $country, $withCurrency = true)
    {
        if (empty($points) || empty($country)) return '';
        $countryPoints = DB::table('country_points')
            ->where('country_language', 'like', '%' . $country)
            ->first();

        if (!$countryPoints) return '';
        $rate = $countryPoints->points;
        $currency = trim($countryPoints->currency_symbols);

        if (in_array($currency, ['CAD'])) {
            // $currency = '$';
            $currency = 'CAD';
        }

        $points = (int) $points;
        $amount = $points / $rate;

        if ($withCurrency) {
            return $currency . number_format($amount, 2);
        } else {
            return  number_format($amount, 2);
        }
    }

    public function getNominationsCount($awardType)
    {
        if (!$awardType || empty($awardType)) return 0;
        $award = Award::whereId($awardType)->first();
        $randomNumber = 0;
        if ($award && !empty($award->nomination_start) && !empty($award->nomination_end)) {
            $randomNumber = rand($award->nomination_start, $award->nomination_end);
        }
        return $randomNumber;
    }

    public function getTopPanelistsByCountry($country_code = 'US', $awardsMonth = null)
    {
        if (empty($awardsMonth)) {
            return [];
        }

        $panellistData = SJPanelMonthlyAward::leftJoin('users', 'SJPanel_Monthly_award.panellist_id', '=', 'users.panellist_id')
            ->leftJoin('awards', 'SJPanel_Monthly_award.award_type', '=', 'awards.id')
            ->leftJoin('panellist_address', 'users.id', '=', 'panellist_address.user_id')
            ->select(
                'SJPanel_Monthly_award.*',
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'awards.name as award_name',
                'SJPanel_Monthly_award.city_state as location'
            )
            ->where('SJPanel_Monthly_award.award_month', $awardsMonth)
            ->where('awards.status', 1)
            ->where('SJPanel_Monthly_award.country_code', $country_code)
            ->orderBy('SJPanel_Monthly_award.award_type', 'asc')
            ->get();

        if ($panellistData->count() <= 0) {
            return [];
        }

        $data = [];
        foreach ($panellistData as $panellist) {
            $panellist = $panellist->toArray();

            $panellist['first_name'] = (!empty($panellist['first_name'])) ? \Crypt::decrypt($panellist['first_name']) : '';
            $panellist['middle_name'] = (!empty($panellist['middle_name'])) ? \Crypt::decrypt($panellist['middle_name']) : '';
            $panellist['last_name'] = (!empty($panellist['first_name'])) ? \Crypt::decrypt($panellist['last_name']) : '';

            $panellist['full_name'] = implode(' ', [$panellist['first_name'], $panellist['middle_name'], $panellist['last_name']]);

            if (empty($panellist['amount'])) {
                $panellist['amount'] = $this->calculateAmountFromPoints($panellist['points'], $country_code);
            }

            $panellist['redemption_txt'] = "Yet to be redeemed";
            if (!empty($panellist['redemption_status']) && trim($panellist['redemption_status']) == 'Redeemed' && !empty($panellist['redemption_at'])) {
                $panellist['redemption_txt'] = 'Redeemed on ' . (Carbon::parse($panellist['redemption_at'])->format('m/d/Y'));
            }
            $data[] = $panellist;
        }


        return $data;
    }

    public function getUserReward()
    {
        $user = auth()->user();

        if (!$user || !in_array($user->country_code, $this->getActiveCountriesCode())) {
            return [];
        }

        if ($user && !empty($user->country_code)) {

            $data = DB::table('reword_country_info')
                ->where('country_code', $user->country_code)
                ->where('status', '1')
                ->first();


            if ($data) {
                $userRewadData = (array) $data;

                // get award for this month start
                $award_month = Carbon::parse($userRewadData['date_time'])->subMonth()->format('Y-m');
                $pastWinners = SJPanelMonthlyAward::leftJoin('awards', 'SJPanel_Monthly_award.award_type', '=', 'awards.id')
                    ->where('SJPanel_Monthly_award.award_month', '=', $award_month)
                    ->where('awards.status', '=', 1)
                    ->where('SJPanel_Monthly_award.country_code', $user->country_code)
                    ->pluck('awards.name')->toArray();

                if (!empty($pastWinners)) {
                    $userRewadData['awards_name'] = $pastWinners;
                } else {
                    $userRewadData['awards_name'] = ['Most Active Panelist', 'Survey Superstar'];
                }
                // get award for this month end

                $timeZone = 'Asia/Kolkata';
                $timeZoneCode = 'IST';

                $countryTimeZone  = $this->getCountryTimeZone($user->country_code);
                if ($countryTimeZone) {
                    $timeZone = $countryTimeZone['timeZone'];
                    $timeZoneCode = $countryTimeZone['timeZoneCode'];
                }


                $userRewadData['timeZone'] = $timeZone;
                $userRewadData['timeZoneCode'] = $timeZoneCode;

                return $userRewadData;
            }
        }
        return [];
    }

    function getCountryTimeZone($country_code)
    {
        if (empty($country_code)) return false;

        $countryConfigs = [
            'IN' => [
                'timeZone' => 'Asia/Kolkata',
                'timeZoneCode' => 'IST'
            ],
            'US' => [
                'timeZone' => 'America/New_York',
                'timeZoneCode' => 'EST'
            ],
            'UK' => [
                'timeZone' => 'Europe/London',
                'timeZoneCode' => 'GMT'
            ],
            'CA' => [
                'timeZone' => 'America/Toronto',
                'timeZoneCode' => 'EST'
            ],
        ];

        $timeZone = 'Asia/Kolkata';
        $timeZoneCode = 'IST';

        if (isset($countryConfigs[$country_code])) {

            $timeZone = $countryConfigs[$country_code]['timeZone'];
            $timeZoneCode = $countryConfigs[$country_code]['timeZoneCode'];
        } else {

            try {
                $zones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
                if (empty($zones)) {
                    return null;
                }

                $primaryZone = $zones[0];
                $dt = new \DateTime('now', new \DateTimeZone($primaryZone));
                $abbreviation = $dt->format('T');

                $timeZone = $primaryZone;
                $timeZoneCode = $abbreviation;
            } catch (\Exception $e) {
                // return null;
            }
        }

        return ['timeZone' => $timeZone, 'timeZoneCode' => $timeZoneCode];
    }

    // function getCountryTimeZoneAndAbbreviation($countryCode)
    // {
    //     try {
    //         $zones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
    //         if (empty($zones)) {
    //             return null;
    //         }

    //         $primaryZone = $zones[0];
    //         $dt = new \DateTime('now', new \DateTimeZone($primaryZone));
    //         $abbreviation = $dt->format('T');

    //         return [
    //             'country' => $countryCode,
    //             'timezone' => $primaryZone,
    //             'abbreviation' => $abbreviation
    //         ];
    //     } catch (\Exception $e) {
    //         return null;
    //     }
    // }

    public function isCountryWinnerSelected($country_code, $award_type, $month)
    {
        if (empty($country_code) || empty($month) || empty($award_type)) return false;
        try {
            $pastWinners = SJPanelMonthlyAward::where('award_month', '=', $month)
                ->where('country_code', $country_code)
                ->where('award_type', $award_type)
                ->get();

            if ($pastWinners->count() > 0) {
                return true;
            }
        } catch (\Exception $e) {
        }
        return false;
    }

    public function creditPanelistPoints($panellistId, $points, $awardType, $awardMonth)
    {
        try {
            $user = User::where('panellist_id', $panellistId)->first();
            if (!$user) {
                return ['status' => false, 'message' => 'User Not Found'];
            }

            $awardKeyArr = [
                '1' => 'inpanel.award_point.profile_prodigy',
                '2' => 'inpanel.award_point.survey_superstar',
                '3' => 'inpanel.award_point.most_active_panelist',
                '5' => 'inpanel.joining_bonus',
            ];

            $log = $awardKeyArr[$awardType];
            $date = $awardMonth->format('Y-m-d');
            $achievementCode = ($awardType == 5) ? 'joining_point' : 'award_credit';
            $filterLog = ($awardType == 5) ? $log : "inpanel.award_point";


            if (!empty($log)) {
                $hasActivityLog = DB::table('activity_log')
                    ->where('description', 'like', '%' . $filterLog . '%')
                    ->where('properties', 'like', '%' . $date . '%')
                    ->where('causer_id', $user->id)
                    ->first();

                if ($hasActivityLog) {
                    return ['status' => false, 'message' => 'Points already credit to this account.'];
                }
            } else {
                return ['status' => false, 'message' => 'Please Select Valid Award Type'];
            }

            $winnerPnellist = null;
            $country_code = $user->country_code;
            if ($achievementCode == "award_credit") {
                $winnerPnellist = SJPanelMonthlyAward::where('award_month', '=', $awardMonth->format('Y-m'))
                    ->where('panellist_id', $panellistId)
                    ->first();

                if (!$winnerPnellist) {
                    return ['status' => false, 'message' => 'Invalid winner for ' . $awardMonth->format('F,Y')];
                }
                $country_code = $winnerPnellist->country_code;
            }

            $mongoUserAdditonalData = UserAdditionalData::where('uuid', '=', $user->uuid)
                ->select('user_achievement', 'user_points')
                ->first();

            $updateData = [];

            if ($mongoUserAdditonalData) {
                $user_achievement = $mongoUserAdditonalData->user_achievement;
                foreach ($user_achievement as &$val) {
                    if (isset($val['static_achievement'])) {
                        $val['static_achievement'][] = [
                            'code' => $achievementCode,
                            'points' => (int) $points,
                            'status' => 'completed',
                        ];;
                    }
                }

                $user_points = $mongoUserAdditonalData->user_points;
                $user_points['completed'] += $points;

                $updateData = [
                    'user_achievement' => $user_achievement,
                    'user_points' => $user_points
                ];
            }

            if ($user && !empty($updateData)) {

                if ($winnerPnellist && !empty($winnerPnellist)) {
                    $winnerPnellist->dollar_amount = $this->getDollarValue($winnerPnellist->points, $country_code);
                    $winnerPnellist->amount_credited_date = now()->format('Y-m-d H:i:s');
                    $winnerPnellist->save();
                }

                UserAdditionalData::where('uuid', '=', $user->uuid)->update($updateData);

                activity("user_achievements")
                    ->causedBy($user->id)
                    ->withProperties(['points' => $points, 'date' => $date])
                    ->log($log);

                if($achievementCode == "award_credit"){
                    // send mail on point creadit
                    $mailsend = $this->sendMailToAwardWinner($panellistId, $country_code, $awardType);
                    
                    if (!$mailsend['status']) {
                        // status is true becouse we dont want to stop the program for mail  
                        return  ['status' => true, 'message' => $mailsend['message']];
                    }
                }
                
                return  ['status' => true, 'message' => 'Points Credited Successfully'];
            }
        } catch (\Exception $e) {
            // print_r($e->getMessage());
            return  ['status' => false, 'message' => $e->getMessage()];
        }
        return  ['status' => false, 'message' => 'Failed to Credit Points'];
    }

    public function getCountryThresholdPoints($country = null)
    {
        if (empty($country)) return null;
        $key = 'PANEL_REDEEMPTIOM_THRESHOLD_POINTS_' . strtoupper($country);

        $setting_val = Setting::where('key', $key)->pluck('value');
        if ($setting_val->count() > 0) {
            return $setting_val[0];
        }
        return null;
    }

    public function getCountryAwardPoints($country_code, $award_id)
    {
        if (!empty($country_code) && !empty($award_id)) {

            $countryAwardPoint = CountryAwardPoint::where('country_code', $country_code)
                ->where('award_id', $award_id)
                ->first();

            if ($countryAwardPoint) {
                return $countryAwardPoint;
            }
        }
        return null;
    }

    public function getDollarValue($points, $country)
    {
        if (empty($points) || empty($country)) return '';

        $countryPoints = DB::table('country_points')
            ->where('country_language', 'like', '%' . $country)
            ->first();

        if (!$countryPoints) return '';

        $rate = $countryPoints->points;
        $currency = trim($countryPoints->currency);

        $points = (int) $points;
        $amount = $points / $rate;
        $currency_value = $this->getUSDExchangeRate($countryPoints->currency);

        // dollar value
        return  number_format($amount / $currency_value, 2);
    }

    public function getUSDExchangeRate($another_currency)
    {
        $url = "https://open.er-api.com/v6/latest/USD";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return $data['rates'][$another_currency] ?? null;
    }


    public function sendInvitationMail($country_code)
    {
        if (!$country_code) {
            return ['status' => false, 'message' => 'country_code is empty'];
        }

        $month_obj = Carbon::now()->subMonth();
        $award_month = $month_obj->format('Y-m');

        $mail_subject = '';
        $mail_content = '';

        $country =  DB::table('reword_country_info as rc')
            ->leftJoin('awards_mail_template as temp', 'rc.award_mail_temp', '=', 'temp.id')
            ->where('rc.status', '1')
            ->where('rc.country_code', $country_code)
            ->select('rc.*', 'temp.id as template_id', 'temp.email_subject', 'temp.template_content')
            ->get()->first();

        if (!$country) {
            return ['status' => false, 'message' => 'country info not found for country code ' . $country_code];
        }

        if (!$country->template_id) {
            return ['status' => false, 'message' => 'Mail Template not found for country code ' . $country_code];
        }
        $mail_subject = $country->email_subject;
        $mail_content = $country->template_content;

        /*

        $awardData = $this->getAwardWinnerMailHtml($award_month, $country_code);
        if (!$awardData || empty($awardData)) {
            return ['status' => false, 'message' => 'winners not found for country code ' . $country_code . ' , award month ' . $award_month];
        }

        $pastWinners = SJPanelMonthlyAward::leftJoin('awards', 'awards.id', '=', 'SJPanel_Monthly_award.award_type')
            ->where('SJPanel_Monthly_award.award_month', '=', $award_month)
            ->where('SJPanel_Monthly_award.country_code', $country_code)
            ->whereIn('SJPanel_Monthly_award.award_type', [1, 2, 3])
            ->select('SJPanel_Monthly_award.points', 'SJPanel_Monthly_award.amount', 'awards.name')
            ->get()->toArray();

        if (!$pastWinners) {
            return ['status' => false, 'message' => 'winners not found for country code ' . $country_code . ' , award month ' . $award_month];
        }

        $awardData = [];
        foreach ($pastWinners as $i => $winners) {
            $ele = '<p><strong>';
            $ele .= ($i + 1) . '. ' . $winners['name'] . ' (' . number_format($winners['points']) . ' points = ' . $winners['amount'] . ')';
            $ele .= '</strong></p>';

            $awardData[] = $ele;
        }


        $joiningAmount = DB::table('country_award_points')->where('country_code', $country_code)
            ->where('award_id', 5)->pluck('award_amount')->first();

        if (!$joiningAmount) {
            return ['status' => false, 'message' => 'joining amount not found for country code ' . $country_code];
        }


        $countryTimeZone = $this->getCountryTimeZone($country_code);
        if (!$countryTimeZone) {
            return ['status' => false, 'message' => 'winners not found for country code ' . $country_code . ' , award month ' . $award_month];
        }

        $eventIST = Carbon::createFromFormat('Y-m-d H:i:s', $country->date_time, 'Asia/Kolkata');
        $eventLocal = $eventIST->copy()->setTimezone($countryTimeZone['timeZone']);


        $finalData = [
            // ':userFristName' => '',
            ':awardMonth' => $month_obj->format('F Y'),
            ':awarData' => implode(' ', $awardData),
            ':sessionDate' => $eventLocal->format('F j, Y'),
            ':sessionTime' => $eventLocal->format('g.i A'),
            ':timeZoneCode' => $countryTimeZone['timeZoneCode'],
            ':joiningAmount' => $joiningAmount,
            ':joiningLink' => $country->zoom_link
        ];
        */


        $err = '';
        $finalData = $this->getAwardMailVariablesValue(false, $country_code, null, $err);

        if (!empty($err)) {
            return ['status' => false, 'message' => $err];
        }

        $users = DB::table('users')
            ->where('country_code', $country_code)
            ->where('active', 1)
            ->where('unsubscribed', '0')
            ->where('confirmed', 1)
            ->select('first_name', 'email', 'panellist_id')
            ->get();

        $awradSettings = $this->getAwardTestSettings();
        foreach ($users as $user) {

            // $finalData['panellistName'] = ucfirst(decrypt($user->first_name));
            $finalData[':userFristName'] = ucfirst(decrypt($user->first_name));

            $json_data = json_encode($finalData);

            $email = decrypt($user->email);

            $finalData['mail_subject'] = str_replace(array_keys($finalData), array_values($finalData), $mail_subject);
            $finalData['mail_content'] = str_replace(array_keys($finalData), array_values($finalData), $mail_content);

            try {
                if ($email) {
                    if($awradSettings['test_mode']==1){
                        $email = $awradSettings['test_emails_arr'];
                    }

                    // Mail::to($email)->send(new AwardInvitation($finalData));
                    Mail::to($email)->send(new AwardInvitation($finalData));
                }

                // for testing
                // Mail::to('himanshu.sjpl@gmail.com')->send(new AwardInvitation($finalData));
                // Mail::to('rohinitest001@gmail.com')->send(new AwardInvitation($finalData));

                $historyData = [
                    'panellist_id' => $user->panellist_id,
                    'mail_template' => $country->template_id,
                    'mail_data' => $json_data,
                    'country_code' => $country_code
                ];

                AwardsMailHistory::create($historyData);
            } catch (\Exception $e) {
                // error
            }

            if($awradSettings['test_mode']==1){
                break; // test 
            }
        }


        return ['status' => true, 'message' => 'All mails send successfully for country code: ' . $country_code];
    }

    /* public function getAwardMailTemplateVariables($getDemoValues = false)
    {
        // isko replace krna h with "getAwardMailVariablesValue"
        $demoData = [
            ':userFristName' => 'Test User',
            ':awardMonth' => 'May 2025',
            ':awarData' => '
                <p><strong>1. Most Active Panelist (17,500 points = ₹700)</strong></p>
                <p><strong>2. Survey Superstar&nbsp;(12,500 points = ₹500)</strong></p>
                <p><strong>3. Profile Prodigy&nbsp;(7,500 points = ₹300)</strong></p>
            ',
            ':sessionDate' => 'July 23, 2025',
            ':sessionTime' => '12.46 AM',
            ':timeZoneCode' => 'IST',
            ':joiningAmount' => '₹4.00',
            ':joiningLink' => 'test zoom link',
        ];

        if ($getDemoValues) {
            return $demoData;
        }
        return array_keys($demoData);
    }
    */

    public function getAwardMailVariablesValue($isForDemo = false, $country_code = null, $panellist_id = null, &$error = null)
    {
        if (!$isForDemo) {
            // get real value
            if (empty($country_code)) {
                $error = 'Country code is required ';
                return [];
            }

            $countryInfo = RewordCountryInfo::where('country_code', $country_code)->first();
            if (!$countryInfo) {
                $error = 'Country Info not found ';
                return [];
            }


            $user = null;
            $winnerPnellist = null;
            if (!empty($panellist_id)) {
                $user = User::where('panellist_id', $panellist_id)->first();
                if (!$user) {
                    $error = "User not found for Panellist id: $panellist_id";
                    return [];
                }

                $awardMonth = Carbon::now()->subMonth()->format('Y-m');
                $winnerPnellist = SJPanelMonthlyAward::leftJoin('awards', 'awards.id', '=', 'SJPanel_Monthly_award.award_type')
                    ->where('award_month', '=', $awardMonth)
                    ->where('panellist_id', $panellist_id)
                    ->select('awards.name as award_name')
                    ->first();
            }

            $joiningAmount = DB::table('country_award_points')->where('country_code', $countryInfo->country_code)
                ->where('award_id', 5)->pluck('award_amount')->first();
            if (!$joiningAmount) {
                $error = "joining amount not found for country code: $countryInfo->country_code";
            }

            $month_obj = Carbon::now()->subMonth();
            $award_month = $month_obj->format('Y-m');

            $awardHtml = $this->getAwardWinnerMailHtml($award_month, $countryInfo->country_code);

            if (!$awardHtml || empty($awardHtml)) {
                $error = "winners not found for country code: $countryInfo->country_code";
                $awardHtml = [];
            }

            $awardAddressHtml = $this->getAwardWinnerAddressMailHtml($award_month, $countryInfo->country_code);

            if (!$awardAddressHtml || empty($awardAddressHtml)) {
                $error = "winners not found for country code: $countryInfo->country_code";
                $awardAddressHtml = [];
            }

            $countryTimeZone = $this->getCountryTimeZone($countryInfo->country_code);
            if (!$countryTimeZone) {
                $error = "Timezone not found for country code: $countryInfo->country_code";
            }
            $eventIST = Carbon::createFromFormat('Y-m-d H:i:s', $countryInfo->date_time, 'Asia/Kolkata');
            $eventLocal = $eventIST->copy()->setTimezone($countryTimeZone['timeZone']);

            // dd($winnerPnellist);

            $finalData = [
                ':userFristName' => ($user) ? $user->first_name : 'User First Name',
                ':awardMonth' => $month_obj->format('F Y'),
                ':awarData' => implode(' ', $awardHtml),
                ':sessionDate' => $eventLocal->format('F j, Y'),
                ':sessionTime' => $eventLocal->format('g.i A'),
                ':timeZoneCode' => $countryTimeZone['timeZoneCode'],
                ':joiningAmount' => $joiningAmount,
                ':joiningLink' => $countryInfo->zoom_link,
                ':awarName' => (!empty($winnerPnellist) && $winnerPnellist->award_name) ? $winnerPnellist->award_name : '',
                ':winnersWithAddress' => implode(' ', $awardAddressHtml)
            ];
        } else {
            // get demo value
            // ye frontend pe show krvane ke kaam aata h. 
            // agr koi key add krni h usko please $finalData ke dono jgah update kro

            $finalData = [
                ':userFristName' => 'Demo User',
                ':awardMonth' => 'May 2025',
                ':awarData' => '
                    <p><strong>1. Most Active Panelist (17,500 points = ₹700)</strong></p>
                    <p><strong>2. Survey Superstar&nbsp;(12,500 points = ₹500)</strong></p>
                    <p><strong>3. Profile Prodigy&nbsp;(7,500 points = ₹300)</strong></p>
                    ',
                ':sessionDate' => 'July 23, 2025',
                ':sessionTime' => '12.46 AM',
                ':timeZoneCode' => 'IST',
                ':joiningAmount' => '₹4.00',
                ':joiningLink' => 'test zoom link here',
                ':awarName' => 'Most Active Panelist',
                ':winnersWithAddress' => '<p><strong>🏆 Most Active Panelist:</strong> Mayda Brandolino from Mississauga, ON</p>
                                <p><strong>🥈 Survey Superstar: </strong>Caleb Lynch from Montr&eacute;al, QC</p>
                                <p><strong>🥉 Profile Prodigy:</strong> Justen Dupont from Saint-Georges, QC&rsquo;</p>'
            ];
        }

        return $finalData;
    }

    public function getAwardWinnerMailHtml($award_month, $country_code)
    {
        $pastWinners = SJPanelMonthlyAward::leftJoin('awards', 'awards.id', '=', 'SJPanel_Monthly_award.award_type')
            ->where('SJPanel_Monthly_award.award_month', '=', $award_month)
            ->where('SJPanel_Monthly_award.country_code', $country_code)
            ->whereIn('SJPanel_Monthly_award.award_type', [1, 2, 3])
            ->select('SJPanel_Monthly_award.points', 'SJPanel_Monthly_award.amount', 'awards.name')
            ->get()->toArray();

        if (!$pastWinners) {
            return false;
        }

        $awardData = [];
        foreach ($pastWinners as $i => $winners) {
            $ele = '<p><strong>';
            $ele .= ($i + 1) . '. ' . $winners['name'] . ' (' . number_format($winners['points']) . ' points = ' . $winners['amount'] . ')';
            $ele .= '</strong></p>';
            $awardData[] = $ele;
        }
        return $awardData;
    }


    public function getAwardWinnerAddressMailHtml($award_month, $country_code)
    {
        $pastWinners = SJPanelMonthlyAward::leftJoin('awards', 'awards.id', '=', 'SJPanel_Monthly_award.award_type')
            ->leftJoin('users','users.panellist_id','=','SJPanel_Monthly_award.panellist_id')
            ->where('SJPanel_Monthly_award.award_month', '=', $award_month)
            ->where('SJPanel_Monthly_award.country_code', $country_code)
            ->whereIn('SJPanel_Monthly_award.award_type', [1, 2, 3])
            ->select('SJPanel_Monthly_award.city_state', 'users.first_name','users.last_name', 'awards.name as awards_name','SJPanel_Monthly_award.award_type')
            ->get()->toArray();

        if (!$pastWinners) {
            return false;
        }

        $awardData = [];
        foreach ($pastWinners as $i => $winners) {
            $name = '';
            if($winners['first_name']){
               $name .=  decrypt($winners['first_name']);
            }
            if($winners['last_name']){
               $name .= ' '. decrypt($winners['last_name']);
            }
            $location = $winners['city_state'];
            $award_name = $winners['awards_name'];
            $icons = [
                '1'=>'🥉',
                '2'=>'🥈',
                '3' =>'🏆'
            ];

            $icon = $icons[$winners['award_type']];

            $ele = "<p><strong>$icon $award_name :</strong> $name from $location  </p>";
            $awardData[$winners['award_type']] = $ele;
        }
        if(!empty($awardData)){
            krsort($awardData);
            $awardData = array_values($awardData);
        }
        return $awardData;
    }

    public function sendMail($to, $mail_subject, $mail_content)
    {
        $awradSettings = $this->getAwardTestSettings();
        if($awradSettings['test_mode']==1){
            // $to = 'himanshu.sjpl@gmail.com'; // for testing
            // $to = 'rohinitest001@gmail.com'; // for testing
            $to = $awradSettings['test_emails_arr'];
            
        }
        // $to = 'rohinitest001@gmail.com'; // for testing
        // dd($to);
        try {
            Mail::send([], [], function ($message) use ($to, $mail_subject, $mail_content) {
                $message->to($to)
                    ->subject($mail_subject)
                    ->setBody($mail_content, 'text/html');
            });

            return true;
        } catch (\Exception $e) {
            // \Log::error('Mail send failed: ' . $e->getMessage());
            return false;
        }
    }

    public function isWinnerPanellist($panellist_id, $awardMonth)
    {
        if (empty($panellist_id) || empty($awardMonth)) {
            return false;
        }

        $winner = SJPanelMonthlyAward::leftJoin('awards','SJPanel_Monthly_award.award_type','=','awards.id')
            ->select('SJPanel_Monthly_award.*','awards.name as award_name')
            ->where('SJPanel_Monthly_award.award_month', '=', $awardMonth)
            ->where('awards.status', '=', 1)
            ->where('SJPanel_Monthly_award.panellist_id', $panellist_id)
            ->first();

            if ($winner) {
            return $winner;
        }
        return false;
    }

    public function getAwardTestSettings()
    {
        static $data = null;

        if ($data === null) {
            $settings = Setting::whereIn('key', [
                'PANEL_AWARD_TEST_EMAIL_IDS',
                'PANEL_AWARD_TEST_MODE'
            ])->pluck('value', 'key');

            $emails_str = $settings['PANEL_AWARD_TEST_EMAIL_IDS'] ?? '';

            $emailArr = preg_split('/[\s,]+/', $emails_str);  // split by comma or any whitespace/newline
            $emailArr = array_filter(array_map('trim', $emailArr));

            $data = [
                'test_emails' => $emails_str,
                'test_mode' => $settings['PANEL_AWARD_TEST_MODE'] ?? 0,
                'test_emails_arr' => $emailArr,
            ];
        }

        return $data;
    }

}
