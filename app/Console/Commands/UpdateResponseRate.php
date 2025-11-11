<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Report\SurveyStartCount;
use App\Models\Project\SjpanelResponserates;
use App\Models\Traffics\Traffic;
use Carbon\Carbon;

class UpdateResponseRate extends Command

{

   /**

    * The name and signature of the console command.

    *

    * @var string

    */

   protected $signature = 'sjpanelresponserate:daily_update';



   /**

    * The console command description.

    *

    * @var string

    */

   protected $description = 'Update respose rate in sjpanel daily';



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

        $fromLastDays = config('app.update_response_rate.days');

        $fromDate = now()->subDays($fromLastDays)->endOfDay();
        $toDate   = now()->subDays(1)->endOfDay();

        $resultData = SurveyStartCount::selectRaw('SUM(start_count) as startCount')
                                    ->where('start_date', '>', $fromDate)
                                    ->where('start_date', '<=', $toDate)
                                    ->first();
        $invite_sent_details = \DB::table('invite_sent_details')
                                ->select(\DB::raw('SUM(reminder) as rcnt'),\DB::raw('SUM(invitecnt) as icnt'),\DB::raw('SUM(surveycnt) as scnt'))
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->orWhereBetween('updated_at', [$fromDate, $toDate])->first();

        $totalStart  = $resultData->startCount;
        $totalInvite =  ($invite_sent_details->icnt)?$invite_sent_details->icnt:0;

        //return response()->json(['totalInvite' => $totalInvite, 'totalStart' => $totalStart], 200); 
       if($totalInvite > 0){
            $resposeRate = round(($totalStart/$totalInvite)*100);
            $update_data =array(
                'response_rate' => $resposeRate,
                'updateOn'      => $toDate
            ); 
            SjpanelResponserates::where('id',1)->update($update_data);

            $this->info('Response rate update successfully');
        }else{
            $this->info('Response rate not update');
        }        

    }

}