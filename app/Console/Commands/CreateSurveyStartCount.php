<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Report\SurveyStartCount;
use App\Models\Traffics\Traffic;
use Carbon\Carbon;

class CreateSurveyStartCount extends Command

{

   /**

    * The name and signature of the console command.

    *

    * @var string

    */

   protected $signature = 'surveystartcount:create';



   /**

    * The console command description.

    *

    * @var string

    */

   protected $description = 'Create survey start count from traffic';



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

        $fromDate = now()->subDays(2)->endOfDay();
        $toDate   = now()->subDays(1)->endOfDay();

        
        $is_exit = SurveyStartCount::whereDate('createdOn',Carbon::now()->startOfDay())->count();

        if($is_exit == 0){
            $resultData = Traffic::where('source_code','SJPL')
            ->where('channel_id',1)
            ->where('created_at', '>', $fromDate)
            ->where('created_at', '<=', $toDate)
            ->get();

                $count_data = count($resultData);
                if($count_data>0){
                    $add_data =array(
                        'start_count' => $count_data,
                        'start_date'  => $toDate
                    );
                    SurveyStartCount::create($add_data); 
                }

                $this->info('Survey start count insert successfully');
        }else{
                $this->info('Not duplicate entry');
        }
        

    }

}