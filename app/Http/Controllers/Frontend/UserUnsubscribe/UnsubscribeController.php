<?php

namespace App\Http\Controllers\Frontend\UserUnsubscribe;

use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\ReferralProgram\ReferralProgramRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Repositories\Inpanel\General\GeneralRepository;



/**
 * This class is used to Unsubscribe the mail id.
 *
 * Class SocialLoginController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Frontend\Auth\SocialLoginController
 */
class UnsubscribeController extends Controller
{

    /**
     * @var $userRepository, $referralRepository.
     * @var UserRepository
     */
    protected $userRepository, $referralRepository, $generalRepository;

    /**
     * UnsubscribeController constructor.
     * @param UserRepository $userRepository
     * @param ReferralProgramRepository $referralRepository
     */



    public function __construct(UserRepository $userRepository, ReferralProgramRepository $referralRepository,  GeneralRepository $generalRepository)
    {
        $this->userRepository = $userRepository;
        $this->referralRepository = $referralRepository;
        $this->generalRepository = $generalRepository;
    }
    

    /**
     * Action for Unsubscribe the Mail Id.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribeMail(Request $request)
    {
        $flag=str_replace('_','-',strtoupper($request->session()->get('locale'))); 
        // $countries = $this->generalRepository->getActiveCountries();
        $ip= request()->ip();
        // $uuid = Str::uuid()->toString();
        $geodata = geoip(request()->ip());
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $country=$geodata->getAttribute('country');
        // '<pre>';
        // print_r($ipcountryCode);die;
        
        if($ipcountryCode!='US'){
            if(!empty($request->session()->get('locale'))){
                $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
            }else{
              app()->setLocale('EN-'.$ipcountryCode);
              $flag='EN-'.$ipcountryCode;  
            }
            
        }else{
            $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
        }

        $DFIQ=config('settings.dfiq.status');
        if (! $request->hasValidSignature()) {
           // abort(401);
        }
        $email_id = $request->input('email',false);
        return view('frontend.auth.unsubscribe_confirmation')
        ->with('email',$email_id)
        ->with('ip',str_replace('.','-',request()->ip()))
        ->with('country_code',$ipcountryCode)
        ->with('countryCode', $ipcountryCode)
         ->with('country_name',strtoupper($country))
         ->with('flags',$flag)
         ->with('dfiq',$DFIQ);
    }
    public function unsubscribeEmailPost(Request $request)
    {

        $uuid = Str::uuid()->toString();
        $ip= request()->ip();
        $DFIQ=config('settings.dfiq.status');
        $geodata = geoip(request()->ip());
        $countries = $this->generalRepository->getActiveCountries();
        $country=$geodata->getAttribute('country');
        $ipcountryCode = $geodata->getAttribute('iso_code');
       
       if($ipcountryCode!='US'){
           if(!empty($request->session()->get('locale'))){
               $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
           }else{
             app()->setLocale('EN-'.$ipcountryCode);
             $flag='EN-'.$ipcountryCode;  
           }
           
       }else{
           $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
       }


    // $DFIQ=config('settings.dfiq.status');
    // if (! $request->hasValidSignature()) {
    //     abort(401);
    // }
//  dd($ipcountryCode, $flag, $country, $DFIQ, $countries);
           
        $email_id = $request->email;
        $insertdata = [
            'email' => $email_id,
            'reason' => $request->input('reason'),
            'otherReason' => $request->input('otherReason')
        ];

        if($request->method() == 'POST'){

            $moveEmailToUnsubscribe = $this->userRepository->emailUnsubscribe($insertdata);
            $check_user_details = $this->userRepository->getUserDetailsByEmail($email_id);
            if ($check_user_details ) {
                $update_user_table = $this->userRepository->updateUserTableData($check_user_details->id);
            }

        }
        
       
        return view('frontend.auth.unsubscribed')
        ->with('country_code',$ipcountryCode)
        ->with('ip',str_replace('.','-',request()->ip()))
        ->with('flags',$flag)
        // ->with('uuid',$uuid)
        // ->with('prompt',$prompt)
        ->with('countryCode', $ipcountryCode)
        ->with('country_name',strtoupper($country))
        ->with('dfiq',$DFIQ)
        ->withCountries($countries);
    }

    
    
}
