<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestCronMail extends Command

{

   /**

    * The name and signature of the console command.

    *

    * @var string

    */

   protected $signature = 'everyminute:email_send';



   /**

    * The console command description.

    *

    * @var string

    */

   protected $description = 'Send an Every one minute email to the users';



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

    Mail::raw("This is automatically generated every minute Update on test3 server", function($message) 
    {
        $message->from('vikash@optimumlogic.com');
        $message->to('vikash@optimumlogic.com')->subject('Every minutes Update');
    });
    $this->info('Every minutes Email has been send successfully on test3 server');

   }

}