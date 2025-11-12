<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Carbon\Carbon;
use App\Mail\Inpanel\UserProject\NewSurveyAssignedMail as AssignPanelistSurveyMail;

class NewSurveyAssignedMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:new-assign-survey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send survey assigned email to panelist';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countryMap = $this->getCountryTimezoneMap();
        $countryNameMap = $this->getCountryNameMap();

        foreach ($countryMap as $countryCode => $timezone) {
            $now = Carbon::now($timezone);
            $slots = ['slot_1', 'slot_2', 'slot_3'];
            $currentSlot = $this->getCurrentSlot($now);

            if (!$currentSlot) continue;

            // Get all LIVE user-projects for today
            $userProjects = DB::table('user_projects as up')
                ->join('projects as p', 'up.project_id', '=', 'p.id')
                ->join('users', 'users.id', '=', 'up.user_id')
                ->select('up.user_id', 'up.project_id')
                ->where('p.survey_status_code', '=', 'LIVE')
                ->where('users.country_code', $countryCode)
                ->whereNull('up.status')
                ->whereDate('up.created_at', $now->toDateString())

                 ->wherein('up.user_id', [16048,15618,4548])

                ->get()
                ->groupBy('user_id');

            foreach ($userProjects as $userId => $projects) {
                $usedSlots = DB::table('user_email_logs')
                    ->where('user_id', $userId)
                    ->where('date', $now->toDateString())
                    ->pluck('slot')
                    ->toArray();

                $finalSlot = $currentSlot;

                if (in_array($finalSlot, $usedSlots)) continue;

                $user = User::find($userId);
                if (!$user) continue;

                try {
                    Mail::to($user->email)->send(new AssignPanelistSurveyMail($user, $projects));

                    DB::table('user_email_logs')->insert([
                        'user_id' => $userId,
                        'slot' => $finalSlot,
                        'project_id' => null,
                        'date' => $now->toDateString(),
                        'sent_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    \Log::error("Error sending mail to user ID {$userId}: " . $e->getMessage());
                }
            }
        }
    }

    protected function getCountryTimezoneMap(): array
    {
        return [
            'IN' => 'Asia/Kolkata',
            'US' => 'America/New_York',
            'UK' => 'Europe/London',
            'CA' => 'America/Toronto',
            'AU' => 'Australia/Sydney',
        ];
    }

    protected function getCountryNameMap(): array
    {
        return [
            'IN' => 'India',
            'US' => 'United States',
            'UK' => 'United Kingdom',
            'CA' => 'Canada',
            'AU' => 'Australia',
        ];
    }

    protected function getCurrentSlot(Carbon $now): ?string
    {
        $hour = $now->hour;

        if ($hour >= 9 && $hour < 13) return 'slot_1';
        if ($hour >= 13 && $hour < 17) return 'slot_2';
        if ($hour >= 17 && $hour < 21) return 'slot_3';

        return null;
    }

}
