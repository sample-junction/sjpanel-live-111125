<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Auth\User;
use App\Mail\Frontend\UserConfirm\ProfilePromptMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendScheduledMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profileMail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a mail for filling profile surveys';

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
        //
        $users = User::where('confirmed',1)

                    ->where('confirm_at','<=', Carbon::now()->subHours(24))
                    ->where('confirm_at','>=', Carbon::now()->subHours(36))
                    ->where('detailed_profile_filled',0)->get();  
        \Log::info("Mailscheduled ".count($users));
        // $recipients = ['captainrdj7@gmail.com'];
        foreach($users as $user){
            \Log::info("Mail ".$user->email);
            Mail::to($user->email)->locale($user->locale)->send(new ProfilePromptMail($user));
        }
        // $this->info('Scheduled Mail sent to '. count($recipients) . ' recipients');
    }
}
