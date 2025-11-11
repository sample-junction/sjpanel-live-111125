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
}

