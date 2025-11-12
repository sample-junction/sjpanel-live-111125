<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RewardService;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Cache;

class AwardInvitationScheduledMail extends Command
{
    protected $signature = 'custom:send-award-invitation-emails';
    protected $description = 'Send emails to panellist for award session at 10 AM in their timezone';

    protected $rewardService;

    public function __construct(RewardService $rewardService)
    {
        parent::__construct();
        $this->rewardService = $rewardService;
    }

    public function handle()
    {
        // dd('test');
        $countries = $this->getAwardCountries();
        // dd($countries);
        if (!empty($countries)) {
            foreach ($countries as $c_code => $c_time) {
                $isValid = $this->isValidTime($c_code, $c_time);
                if ($isValid) {
                    $this->sendMailForCountry($c_code);
                }
            }
        }
    }

    public function getAwardCountries()
    {
        return DB::table('reword_country_info')
            ->where('status', '1')
            ->where('active_cron_job', 1)
            ->pluck('date_time', 'country_code')
            ->toArray();
    }

    public function sendMailForCountry($c_code)
    {
        $key = "daily_mail_sent_{$c_code}_" . now()->toDateString();
        // dd($key);

        // $response = $this->rewardService->sendInvitationMail($c_code);
        // dd($response , 'Please remove this dd after testing');

        if (!Cache::has($key)) {
            $this->info("Start sending reward invitations for country code: {$c_code}");
            $response = $this->rewardService->sendInvitationMail($c_code);
            // dd($response);
            $this->info($response['message']);

            Cache::put($key, true, now()->endOfDay());
        } else {
            $this->info("Reward invitations already send for country code: {$c_code}");
        }
    }

    public function isValidTime($c_code, $c_time)
    {
        $timeZone = $this->rewardService->getCountryTimeZone($c_code);

        if (!$timeZone || empty($timeZone['timeZone'])) return false;
        $countryTZ = $timeZone['timeZone'];

        $eventIST = Carbon::createFromFormat('Y-m-d H:i:s', $c_time, 'Asia/Kolkata');

        $eventLocal = $eventIST->copy()->setTimezone($countryTZ);

        $dailySendTime = $eventLocal->copy()->subHours(2);

        $now = Carbon::now($countryTZ);

        // checking date
        if ($now->toDateString() <= $eventLocal->toDateString()) {

            // checking time
            $starTime = $dailySendTime->copy()->subMinutes(5)->format('H:i:s');
            $endTime  = $dailySendTime->copy()->addMinutes(5)->format('H:i:s');
            $nowTime = $now->format('H:i:s');

            return ($nowTime >= $starTime && $nowTime <= $endTime);
        }
        return false;
    }
}
