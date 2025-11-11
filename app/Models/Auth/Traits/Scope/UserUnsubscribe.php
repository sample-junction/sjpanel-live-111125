<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 4/19/2019
 * Time: 4:08 PM
 */

namespace App\Models\Auth\Traits\Scope;


trait UserUnsubscribe
{

   public function checkUnsubscribedEmail($email)
   {
       $data = \App\Models\Auth\UserUnsubscribe::where('email','=',$email)
           ->first();
       return $data;
   }
}
