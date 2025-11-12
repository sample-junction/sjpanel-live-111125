<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Contact\SendContact;
use App\Http\Requests\Frontend\Contact\SendContactRequest;
use Illuminate\Http\Request;
/**
 * Class ContactController.
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.contact');
    }

    /**
     * @param SendContactRequest $request
     *
     * @return mixed
     */
    /* public function send(SendContactRequest $request)
    {
        Mail::send(new SendContact($request));

        return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }*/

    public function sendContactUsEmail(ContactRequest $request){
        $name = $request->input('name', false);
        $email = $request->input('email', false);
        $message = $request->input('messages', false);
        $emailVaild = $this->CheckInviteEmail($email);
        $msg = $email.' '.__('inpanel.activity_log.invalid_email');
        if($emailVaild == "2"){
            return redirect()->back()->withFlashDanger($msg); 
        }
        Mail::send(new SendContact($request));
        return \Redirect::back()
            ->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }

    public function landingPage(){
        return view('frontend.landing-page');
    }
    public function landingcontact(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'messages' => 'required|string',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('messages');
        Mail::send(new SendContact($request));
        return \Redirect::back()
            ->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }

    public function CheckInviteEmail($email){
        $key=config('settings.EMAIL_QUALITY_SCORE');
        $EMAIL_QUALITY_URL=config('settings.EMAIL_QUALITY_URL');
        $timeout = 1;
        $fast = 'false';
        $abuse_strictness = 0;
        // Create parameters array.
            $parameters = array(
                'timeout' => $timeout,
                'fast' => $fast,
                'abuse_strictness' => $abuse_strictness
            );
            // Format our parameters.
            $formatted_parameters = http_build_query($parameters);
            $url = sprintf(
            $EMAIL_QUALITY_URL.'/%s/%s?%s', 
            $key,
            urlencode($email),
            $formatted_parameters
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

            $json = curl_exec($curl);
            curl_close($curl);

            // Decode the result into an array.
            $result = json_decode($json, true);
           
            if(isset($result['success']) && $result['success'] === true){
                if($result['recent_abuse'] === false && ($result['valid'] === true || $result['timed_out'] === true && $result['disposable'] === false && $result['dns_valid'] === true))
                {
                    return  "0";
                } else {
                return  "2";
                }
            }
    }
}

