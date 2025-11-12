<?php

namespace App\Http\Controllers\Backend\Auth\Support;

use App\Models\Auth\User;
use App\Models\Support\PanellistSupport;
use App\Models\Support\SupportChat;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\Backend\Support\PanelistSupport;
use App\Mail\Backend\PanelistSupport\chatSupport;
use Illuminate\Support\Facades\Response;
use Auth;
use App\Helpers\MailHelper;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\Campaign\campaign_history;
use App\Models\Campaign\template_gallery;
use App\Models\Campaign\campaign;
use App\Models\Campaign\new_template;
use DB;
use App\Helpers\FirebaseHelper;
use App\Models\mobileAPI\UserToken;

/**
 * Class SupportController.
 */
class SupportController extends Controller
{

    public $notificationRepo;

    public function __construct(UserNotificationRepository $notificationRepo)
    {

        $this->notificationRepo = $notificationRepo;
    }

    public function supportHistory(Request $request, $role = 4)
    {
        ///// ======= this code add by Pushpendra ======= \\\\\
        //if($role != "all"){
        
        $validate_role = 0;

            if($role == "all"){
                $role = 4;
                $validate_role = 1;
            }
            $users = User::whereHas('roles',function($query) use ($role){$query->where('id',$role);})->where('active', 1)->get();
        
            $userIds = $users->pluck('id')->toArray(); 
            if($request->get('date') != 1){
                $supportHistory = PanellistSupport::whereIn('panellist_supports.user_id', $userIds)
                    ->leftJoin('users', 'users.id', '=', 'panellist_supports.user_id')
                    ->leftJoin('user_platform_actions', function ($join) {
                        $join->on('user_platform_actions.user_uuid', '=', 'users.uuid')
                            ->on('user_platform_actions.action_id', '=', 'panellist_supports.id')
                            ->where('user_platform_actions.action_type', 'support_ticket');
                    })
                    ->select('panellist_supports.*', 'user_platform_actions.platform as device_type')
                    ->orderBy('panellist_supports.orderByUpdate', 'desc')
                    ->orderBy('panellist_supports.created_at', 'desc')
                    ->get();
            } else {
                $supportHistory = PanellistSupport::whereIn('panellist_supports.user_id', $userIds)
                    ->where('panellist_supports.status', 0)
                    ->leftJoin('users', 'users.id', '=', 'panellist_supports.user_id')
                    ->leftJoin('user_platform_actions', function ($join) {
                        $join->on('user_platform_actions.user_uuid', '=', 'users.uuid')
                            ->on('user_platform_actions.action_id', '=', 'panellist_supports.id')
                            ->where('user_platform_actions.action_type', 'support_ticket');
                    })
                    ->select('panellist_supports.*', 'user_platform_actions.platform as device_type')
                    ->orderBy('panellist_supports.orderByUpdate', 'desc')
                    ->orderBy('panellist_supports.created_at', 'desc')
                    ->get();
            }
            if($validate_role == 1){
                $role = "all";
            }

        //} 
        // else {
        //     if($request->get('date')!=1){
        //         $supportHistory = PanellistSupport::orderBy('orderByUpdate','desc')->orderBy('created_at', 'desc')->get();
        //     }else{
        //         $supportHistory = PanellistSupport::where('status',0)->orderBy('orderByUpdate','desc')->orderBy('created_at', 'desc')->get();
        //     }
        // }
        ///// ======= this code add by Pushpendra ======= \\\\\

        //$supportHistory = PanellistSupport::select("panellist_supports.*","users.timezone as userTimezone","users.panellist_id","users.email")->leftJoin('users','users.id','=','panellist_supports.user_id')->orderBy('panellist_supports.orderByUpdate','desc')->get();


        ///// ======= this code comment by Pushpendra ======= \\\\\
        // if($request->get('date')!=1){
        //   $supportHistory = PanellistSupport::orderBy('orderByUpdate','desc')->orderBy('created_at', 'desc')->get();
        // }else{
        //   $supportHistory = PanellistSupport::where('status',0)->orderBy('orderByUpdate','desc')->orderBy('created_at', 'desc')->get();
        // }
        ///// ======= this code comment by Pushpendra ======= \\\\\

        //  echo '<pre>';
        //  print_r($supportHistory);   die;    //print_r(\Crypt::decrypt('eyJpdiI6ImNpUUlYMjZmb2FKZDZJTzhWcWt6dGc9PSIsInZhbHVlIjoiUUhpaCtmeVpZMHUwa2ZONjdYNmFZYkNHdFNyck0zbjhodjU3MDRmU0Y5eEE5MGdZNjVzdW8rOWZGMU41bnR3TyIsIm1hYyI6IjU3Zjc3ZmM0ZGNjOWI2ZDBjNTM0MjM0ZDkyZTMzZjgxMzY5MmJlM2ZmYWY3N2Y3YWM3NWQ4ODVhNjNjYzkwMzkifQ=='));die;
        return view('backend.auth.support.support_history', compact('role'))
            ->with('supportHistory', $supportHistory);
    }

    public function supportChat(Request $request, $ticket_id)
    {

        $user = auth()->user();
        if ($request->all()) {

            // Validate the request
            $this->validate($request, [
                'attachment' => 'file|mimes:jpeg,png,jpg,csv,xlsx,xls|max:2048',
                'message'    => 'required'
            ]);

            // Handle file attachment
            $filename = null;
            if ($request->hasFile('attachment')) {
                $image = $request->file('attachment');
                $filename = 'chat-' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/support_attachment');
                $image->move($destinationPath, $filename);
            }

            // Retrieve panelist details
            $user_tkt = DB::table('users')
                ->join('panellist_supports', 'panellist_supports.user_id', '=', 'users.id')
                ->where('panellist_supports.id', $ticket_id)
                ->select('users.*')
                ->first();
            // Check if panelist details are retrieved successfully
            // Check if panelist details are retrieved successfully
            if (!$user_tkt) {
                return redirect()->route('admin.auth.support.chatshow', $ticket_id)->withErrors(['error' => 'Panelist not found']);
            }

            // Create support chat entry
            SupportChat::create([
                'ticket_id'        => $ticket_id,
                'manager_id'       => $user->id,
                'content'          => $request->input('message'),
                'attach_file_name' => $filename
            ]);

            if (!empty($user_tkt->email)) {
                try {
                    app()->setLocale($user_tkt->locale);
                    $decryptedEmail = decrypt($user_tkt->email);
                    $msg = '';
                    // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
                    if ($user_tkt->locale == 'hi_IN') {
                        $msg = __('frontend.notification_txt.support_rqst') . $ticket_id . __('frontend.notification_txt.support_rqst2');
                        $msg_keys = [
                            'start' => 'frontend.notification_txt.support_rqst',
                            'end'   => 'frontend.notification_txt.support_rqst2'
                        ];
                        $this->notificationRepo->createNotification($user_tkt->uuid, 'Support Request', $ticket_id, json_encode([
                            'keys' => $msg_keys,
                            'ticket_id' => $ticket_id
                        ]), 'Support Status');
                    } else {
                        // $msg = __('frontend.notification_txt.support_rqst') . $ticket_id;
                        $msg = __('frontend.notification_txt.support_rqst');
                        $msg_keys = [
                            'single' => 'frontend.notification_txt.support_rqst'
                        ];
                        $this->notificationRepo->createNotification($user_tkt->uuid, 'Support Request', $ticket_id, json_encode([
                            'keys' => $msg_keys
                        ]), 'Support Status');
                    }
                    // Ending Vikas
                    PanellistSupport::where('id', $ticket_id)->update(['updated_at' => Carbon::now()]);

                    Mail::to($decryptedEmail)->send(new chatSupport($user_tkt, $ticket_id));
                    $userToken = UserToken::where('user_id', $user_tkt->id)->value('device_token');
                    $title = "SJ Panel";
                    $body = strip_tags($msg);
                    if (!empty($userToken)) {
                        FirebaseHelper::sendNotification(
                            $userToken,
                            $title,
                            $body,
                            [
                                'type' => 'Support Status'
                            ]
                        );
                    }
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            } else {
                return redirect()->route('admin.auth.support.chatshow', $ticket_id)->withErrors(['error' => 'User email is empty']);
            }

            return redirect()->route('admin.auth.support.chatshow', $ticket_id);
        }

        // Fetch support history and all chats
        $supportHistory = PanellistSupport::where('id', $ticket_id)->first();
        if (!$supportHistory) {
            return redirect()->back()->with('error', 'Support ticket not found');
        }

        $allChatsById = SupportChat::where('ticket_id', $ticket_id)->get();


        return view('backend.auth.support.support_chats')
            ->with('supportHistory', $supportHistory)
            ->with('allChatsById', $allChatsById)
            ->with('error', 'Some error occurred. Please try again later.'); // Display error message if any
    }
    public function changeSupportStatus(Request $request)
    {
        $supportId    = $request->input('supportId');
        $changeStatus = $request->input('statusData');

        $updateUsers = PanellistSupport::where('id', '=', $supportId)
            ->update(['status' => $changeStatus, 'updated_at' => Carbon::now()]);
        $user_tkt = DB::table('users')
            ->join('panellist_supports', 'panellist_supports.user_id', '=', 'users.id')
            ->where('panellist_supports.id', $supportId)
            ->select('users.*')->first();

        $original_locale = app()->getLocale();
        app()->setlocale($user_tkt->locale);
        // Code updated by Vikas For multi language notifications(Starting 5/11/2025)
        if ($changeStatus == 0) {
            $msg =  __('frontend.notification_txt.support_rqst_status_3') . $supportId . __('frontend.notification_txt.support_rqst_status_4');
            $msg_keys = [
                'start' => 'frontend.notification_txt.support_rqst_status_3',
                'end'   => 'frontend.notification_txt.support_rqst_status_4'
            ];
            $support_request = $this->notificationRepo->createNotification($user_tkt->uuid, 'Support Request', $supportId, json_encode([
                'keys' => $msg_keys,
                'supportId' => $supportId
            ]), 'Support Status');
        } else {
            $msg =  __('frontend.notification_txt.support_rqst_status_1') . $supportId . __('frontend.notification_txt.support_rqst_status_2');
            $msg_keys = [
                'start' => 'frontend.notification_txt.support_rqst_status_1',
                'end'   => 'frontend.notification_txt.support_rqst_status_2'
            ];
            $support_request = $this->notificationRepo->createNotification($user_tkt->uuid, 'Support Request', $supportId, json_encode([
                'keys' => $msg_keys,
                'supportId' => $supportId
            ]), 'Support Status');
        }
        // Ending Vikas
        // $support_request = $this->notificationRepo->createNotification($user_tkt->uuid, 'Support Request', $supportId, $msg, 'Support Status');
        app()->setlocale($original_locale);
        return response()->json(['status' => 200], 200);

        //         $supportId = $request->input('supportId');
        // $changeStatus = $request->input('statusData');

        // $message = $request->input('message');
        // $attachment = $request->file('attachment');

        // $status = (!empty($message) || !empty($attachment)) ? 3 : 0;

        // $updateUsers = PanellistSupport::where('id', '=', 'ticket_id')
        //     ->update(['status' => $status, 'updated_at' => Carbon::now()]);

        // return response()->json(['status' => 200], 200);

    }

    public function panelistBirthdayMail()
    {

        $datas = new_template::where('template_type', '!=', 2)->where('template_status', 1)->orderBy('created_at', 'DESC')->get();
        $datas_campaign = campaign::where('type', '!=', 'Survey')->orderBy('created_at', 'DESC')->get();
        return view('backend.auth.support.panelistBday_mailSent')
            ->with('datas', $datas)
            ->with('datas_campaign', $datas_campaign);
    }

    public function panelistBirthdayMailsent(Request $request)
    {
        // $compaign = campaign::pluck('campaign_name', 'id');
        // dd($compaign);


        $request->validate([
            'panelist_id' => 'required',
            // 'subject_line' => 'required',
            // 'email_content' => 'required',
            'template' => 'required',
        ]);

        $export = array_map('trim', explode(",", $request->input('panelist_id')));
        $subjectLine = $request->input('subject_line');
        $emailContent = $request->input('email_content');
        $template = $request->input('template');
        $notFoundUsers = [];
        $submittedPanelistIds = [];



        try {
            foreach ($export as $exports) {
                $panelist = User::where('panellist_id', $exports)->first();


                if (in_array($exports, $submittedPanelistIds)) {
                    return response()->json(['success' => false, 'error' => 'Duplicate panelist ID: ' . $exports]);
                }

                $submittedPanelistIds[] = $exports;

                if ($panelist) {
                    MailHelper::sendBirthdayMail($panelist, $panelist->email, $subjectLine, $emailContent, $headers, $status_link_new);
                } else {
                    $notFoundUsers[] = $exports;
                }
            }

            if (!empty($notFoundUsers)) {
                return response()->json(['success' => false, 'error' => 'Panelist not found for IDs: ' . implode(', ', $notFoundUsers)]);
            }

            return response()->json(['success' => true, 'redirect' => route('admin.auth.support.birthdaysent')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function campaignMail(Request $request)
    {

        $request->validate([
            'subject_line' => 'required',
            'email_content' => 'required',
            'campaign_id' => 'required',
            // 'c_type_id'=> 'required',
            'campaign_amount' => 'required',
            'campaign_start_date' => 'required',
            'status_link' => 'required',
            'campaign_status' => 'required'
        ]);

        $file = $request->file('importfile');
        if ($file) {
            $customerArr = $this->csvToArray($file);
            if ($customerArr) {
                $export = [];
                $i = 0;
                foreach ($customerArr as $row) {
                    $export[$i] = $row['panellist_id'];
                    $i++;
                }
            } else {
                return back()->with('fail', 'Failed');
            }
        } else {
            $export = array_map('trim', explode(",", $request->input('panelist_id')));
        }

        // echo "<pre>";
        // print_r($export);
        // die();


        // $export = array_map('trim', explode(",", $request->input('panelist_id')));
        $subjectLine = $request->input('subject_line');
        $emailContent = $request->input('email_content');
        $campaign_id = $request->input('campaign_id');
        $c_type =  $request->input('c_type_name');
        $campaign_amount = $request->input('campaign_amount');
        $status_link = $request->input('status_link');
        $campaign_start_date = $request->input('campaign_start_date');
        $campaign_status = $request->input('campaign_status');

        foreach ($export as $exports) {
            $panelist = User::where('panellist_id', $exports)->first();
            // print_r($panelist);
            // die;

            if ($panelist) {

                if (str_contains($status_link, 'upload')) {
                    $campaign_code  = md5(uniqid(mt_rand(), true));
                    $url = $request->input('url_campaign');
                    $logo_url = url('/');
                    $updated_status_link = str_replace([':pid'], [$panelist->panellist_id], $status_link);
                    $status_link_new = $updated_status_link . '?code=' . $campaign_code;
                    //$Content = str_replace([':link', ':userFristName',':logo_url'], [$updated_status_link, $panelist->first_name,$logo_url], $emailContent);
                    $Content = str_replace([':link', ':userFristName', ':logo_url'], [$status_link_new, $panelist->first_name, $logo_url], $emailContent);
                } else {
                    $campaign_code  = md5(uniqid(mt_rand(), true));
                    $url = $request->input('url_campaign');
                    $logo_url = url('/');
                    $status_link_new = $url . '?code=' . $campaign_code;

                    $Content = str_replace([':link', ':userFristName', ':logo_url'], [$status_link_new, $panelist->first_name, $logo_url], $emailContent);
                    $updated_status_link = $status_link;
                }

                //$Content = str_replace([':link', ':userFristName',':logo_url'], [$status_link_new, $panelist->first_name,$logo_url], $emailContent);
                //$updated_status_link = str_replace([':pid'], [$panelist->panellist_id], $status_link);
                // return $content;

                // die;
                $datas = [
                    'campaign_id' => $campaign_id,
                    'c_type' => $c_type,
                    'panelist_id' => $panelist->panellist_id,
                    'campaign_subject' => $subjectLine,
                    'campaign_content' => $Content,
                    'campaign_amount' => $campaign_amount,
                    'campaign_code' => $campaign_code,
                    'status_link' => $updated_status_link,
                    'campaign_start_date' => $campaign_start_date,
                    'campaign_status' => $campaign_status,
                ];
                $campaign = new campaign_history();
                $campaign->fill($datas);
                $result = $campaign->save();


                if ($result) {
                    MailHelper::sendBirthdayMail($panelist, $panelist->email, $subjectLine, $Content);
                }
            }
        }
        return back()->with('success', 'Successfully sent');
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // print_r($row);die;
                if (!$header)
                    // $header = $row;
                    $header = array('panellist_id');
                else
                    if (count($header) != count($row)) {
                    return 'not_matched';
                } else {

                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }



    public function templateGallary(Request $request)
    {
        // echo '<pre>';
        // print_r($request['name_img']);
        // die();

        $request->validate([
            // 'image_name' => 'required',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $img_alias_name = $request['name_img'];
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('gallery');
            $image->move($destinationPath, $imageName);
            // $image->resize('50', '50');
            $status = $request->status;
            // print_r("good") ; die();
            // die();
        } else {
            // return response()->json(['error' => 'No image uploaded'], 400);
            return "bad";
        }

        $templateGallary = new template_gallery();
        $templateGallary->image_name = $img_alias_name;
        $templateGallary->path = 'gallery/' . $imageName;
        $templateGallary->status = $status;
        $result = $templateGallary->save();

        // return $result;
        // die();
        // if ($result) {
        //     // return response()->json(['success' => 1], 200);
        //     return "good";
        // } else {
        //     return "very Bad";
        //     // return response()->json(['success' => 0], 200);
        // }

        return \Redirect::back();
    }





    public function templateGallarySingle(Request $request)
    {
        $itemId = $request->input('id');
        $item = template_gallery::find($itemId);

        if (!$item) {
            return back()->with('fail', 'No Image Found');
        }

        $item->delete();

        return back()->with('success', 'Item deleted successfully');
    }


    public function updateTemplateGallery(Request $request)
    {
        $galleryItemId = $request->get('id');
        $galleryItem = template_gallery::find($galleryItemId);
        if (!$galleryItem) {
            return response()->json(['error' => 'Gallery item not found'], 404);
        }

        $galleryItem->image_name = $request->input('edit_name_img');

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('gallery');
            $image->move($destinationPath, $imageName);
            $galleryItem->path = 'gallery/' . $imageName;
        }

        if ($request->has('status')) {
            $galleryItem->status = $request->input('status');
        }
        $galleryItem->save();

        return redirect()->back()->with('success', 'Gallery item updated successfully');
    }
}
