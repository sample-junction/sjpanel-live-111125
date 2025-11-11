<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use App\Models\Auth\User;

class DoiRemainderAllEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $confirmationCode;
    protected $points;
    protected $type;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $confirmationCode, $points, $type = 1)
    {
        $this->user = $user;
        $this->confirmationCode = $confirmationCode;
        $this->points = $points;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(
            new UserConfirmation($this->user, $this->confirmationCode, $this->points, $this->type)
        );
    }
}
