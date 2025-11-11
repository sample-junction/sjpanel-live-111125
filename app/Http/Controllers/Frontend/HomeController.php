<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Mail\Frontend\UserConfirm\UserTestMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Auth\User;
use Illuminate\Support\Str;
use App\Repositories\Inpanel\General\GeneralRepository;
use App\Repositories\Inpanel\Redeem\RedeemRepository;
use Illuminate\Http\Request;
use App\Models\Campaign\new_template;
use Carbon\Carbon;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Log;
use Cache;

/**
 * This class is used to redirect user to home page of the website.
 *
 * Class HomeController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Controllers\Frontend\HomeController
 */

class HomeController extends Controller
{
    /**
     * This method is use to redirect the User to Home.
     *
     * @return \Illuminate\View\View
     */

     protected $generalRepository;
     public $redeemRepo;

    public function __construct( RedeemRepository $redeemRepo, GeneralRepository $generalRepository)
    {

        // $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
        $this->redeemRepo = $redeemRepo;
    }

    public function index(Request $request)
    {

        $uuid = Str::uuid()->toString();
        $ip= request()->ip();
        $DFIQ=config('settings.dfiq.status');
        $geodata = geoip(request()->ip());

        /*$countries = Cache::rememberForever('users', function () {
        return $this->generalRepository->getActiveCountries();
        });*/
        //$countries = $this->generalRepository->getActiveCountries();

        $country=$geodata->getAttribute('country');
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $locale = $request->session()->get('locale');
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

        $prompt=[];
        if($request->has('prompt_id')){
           array_push($prompt,true);
           // if($prompt){
           //     print_r('Testing');die();
           // }
           // else{
           //     print_r('Not Testing');die();
           // }
        }
        if($ipcountryCode == 'AU'){
           $thresholdCountry = 'PANEL_REDEEMPTIOM_THRESHOLD_POINTS_'.$ipcountryCode;
           $redeemptionThresholdPoints = Setting::where('key',$thresholdCountry)->first();
        }else{
            $redeemptionThresholdPoints = Setting::where('key','PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->first();
        }

        $status = [
            'draft','published'
        ];

        Cache::forget('data');

        if (Cache::has('data')){
            
            $data =Cache::get('data');
        }else{
           $data = [
                'posts' => DB::connection('mysql_additional')->table('canvas_posts')
                    ->whereIn('post_status', $status)
                    ->where('site_info', '=', '1')
                    ->where(function ($query) use ($ipcountryCode) {
                        $query->whereRaw('JSON_CONTAINS(JSON_UNQUOTE(REPLACE(countries, \'""\', \'\')), ?)', ['"'.$ipcountryCode.'"'])
                            ->orWhereNull('countries')
                            ->orWhere('countries', '[]')
                            ->orWhere('countries', '');
                    })
                    //->delete()
                    //->whereNull('deleted_at')
                    ->orderByDesc('published_at')
                    ->simplePaginate(3),
            
                //'topics' => DB::connection('mysql_additional')->table('canvas_topics')->get(['name', 'slug']),
                //'tags'   => DB::connection('mysql_additional')->table('canvas_tags')->get(['name', 'slug']),
            ]; 
            // change 3600*24 to 60 * 24 by himanshu 09-10-2025
            // Cache::put('data', $data, 3600*24);  
            Cache::put('data', $data, 60 * 24);  
        }
                
        $i = 0;
        $read_time = [];
        foreach($data['posts'] as $posts){
            $words = str_word_count(strip_tags($posts->body));
            $minutes = ceil($words / 250);
            $formattedDate = Carbon::parse($posts->published_at)->format('M-y');
            $read_time[$i] = $formattedDate .' '. $minutes.' ' .__('frontend.index.footer.links.minute').' '.__('frontend.index.footer.links.read_time');
            $i++;
        }

        $prompt=[];
        if($request->has('prompt_id')){
            array_push($prompt,true);
        }

        $approver_flag = 0;
        $approver = '';
        if ($request->has('approver_id')) {
            $approver_flag = 1;
            if ($request->approver_id === 1) {
                $approver = 'Rajan';
            } else {
                $approver = 'Amar';
            }
        } elseif ($request->has('rejecter_id')) {
            $approver_flag = 1;
            if ($request->rejecter_id === 1) {
                $approver = 'Rajan';
            } else {
                $approver = 'Amar';
            }
        } 
        if ($approver_flag) {

            $approvalStatus = $request->get('approval_status');
            $templateId = $request->get('template_id');
            $template = new_template::find($templateId);

            if ($template) {
                $template->template_status = $approvalStatus;
                $template->approval_email = $approver;
                $template->save();
            } 
        }
        
        $status = ['completed'];
        //Cache::forget('get_redeem_data');
         $get_redeem_data = Cache::rememberForever('get_redeem_data', function () use($status) {
        return $this->redeemRepo->getredeemForHomePage($status);
         });
        // foreach($get_redeem_data as $values){
        //     $stateData = $this->getStateFromZipCode($values->zipcode, $values->country, "", "");
        //     if (is_array($stateData) && count($stateData) > 0) {
        //         $values->city_state = implode(' ', $stateData);
        //     } else {
        //         $values->city_state = "";
        //     }
        // }
//    print_r($flag);die;
        return view('frontend.new_home')
        ->with('country_code',$ipcountryCode)
        ->with('countryName',$country)
        ->with('flags',$flag)
        ->with('ip',$ip)
        ->with('locale',$locale)
        ->with('uuid',$uuid)
        ->with('prompt',$prompt)
        ->with('dfiq',$DFIQ)
        // ->withCountries($countries) 
        ->with('data',$data)
        ->with('read_time',$read_time)
        ->with('get_redeem_data',$get_redeem_data)
        ->with('redeemptionThresholdPoints',$redeemptionThresholdPoints)
        ->with('country_name',strtoupper($country));
    }


    public function encryptData()
    {
        $all_users_data = DB::connection('mysql_global')
            ->table('users')
            ->select('*')
            ->get();
        foreach($all_users_data as $user){
            $user_data = (array)$user;
            $user_id = $user_data['id'];
            $unset_value = ['id','created_at','updated_at'];
            foreach($unset_value as $val){
                unset($user_data[$val]);
            }
            $new_email =  \Crypt::encrypt($user_data['email']);
            $new_first_name = \Crypt::encrypt($user_data['first_name']);
            $new_last_name = \Crypt::encrypt($user_data['last_name']);
            $user_data['email'] = $new_email;
            $user_data['first_name'] = $new_first_name;
            $user_data['last_name'] = $new_last_name;
            DB::connection('mysql_global')
                ->table('users')
                ->where('id','=',$user_id)
                ->update($user_data);
        }
        die("tada");
    }

    public function testingsendemail(){
        $user = User::where('email','vikash@optimumlogic.com')->first();
        $email = new UserTestMail($user,$user->confirmation_code);
        Mail::send($email);
        echo 'mail sent';
    }

     function getStateFromZipCode($zipcode,$country,$panellist_id,$stateToRegionMapping)
    {
        $country_code = "";
        switch ($country) {
            case "US":
                $country_code = "US";
                break;
            case "IN":
                $country_code = "IN";
                break;
            case "CA":
                $country_code = "CA";
                break;
            default:
                $country_code = "US"; // Default
        }
        
        $zipp = "08854";

        $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";
        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            // cURL request failed
            // echo "Error: " . curl_error($ch);
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            // HTTP request failed
            // echo "HTTP Error: " . $http_code;
            return null;
        }

        $data = json_decode($response, true);
        //dd($data);        
        if (isset($data["places"][0])) {
            $state = $data["places"][0]["state"];
            $city = $data["places"][0]["place name"];

            // Extract state abbreviation
            $stateAbbreviation = $data["places"][0]["state abbreviation"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $region, $stateAbbreviation];
        } else {
            // ZIP code not found
            return null;
        }

        curl_close($ch);
    }
    

    public function multimail()
    {
        Mail::send([], [], function ($message) {
            $message->from('no-reply@mg.sjpanel.com', 'Default Mailer');
            $message->to('anils@samplejunction.com', 'Recipient 1')
                    ->subject('Default Mailgun Email')
                    ->setBody('This is a test email using the default Mailgun configuration.', 'text/html');
        });
    
        $privacyConfig = config('mail.mailers.mailgun_privacy');
        config()->set('mail.mailers.mailgun_privacy.domain', $privacyConfig['domain']);
        config()->set('mail.mailers.mailgun_privacy.secret', $privacyConfig['secret']);
    
        Mail::send([], [], function ($message) {
            $message->from('no-reply@mg.sjpanel.com', 'Privacy Mailer');
            $message->to('anil8c7@gmail.com', 'Recipient 2')
                    ->subject('Privacy Mailgun Email')
                    ->setBody('This is a test email using the privacy Mailgun configuration.', 'text/html');
        });
    }

   /* Vikas [13-02-2025] */
   public function frontendPage(Request $request)
    {
        $ip = request()->ip();
        $geodata = geoip($ip);
        $countryCode = $geodata->getAttribute('iso_code');
        $country = $geodata->getAttribute('country');
        $ipcountryCode = $geodata->getAttribute('iso_code');

        $locale = $request->session()->get('locale');

        if ($ipcountryCode != 'US') {
            if (!empty($locale)) {
                $flags = str_replace('_', '-', strtoupper($locale));
            } else {
                app()->setLocale('EN-' . $ipcountryCode);
                $flags = 'EN-' . $ipcountryCode;
            }
        } else {
            $flags = str_replace('_', '-', strtoupper($locale));
        }
        $categoryStories = DB::connection('mysql_additional')
            ->table('categories')
            ->join('web_stories', 'categories.id', '=', 'web_stories.category_id')
            ->join('web_story_galleries', 'web_stories.id', '=', 'web_story_galleries.web_story_id')
            ->where('categories.status', 1) // Active categories
            ->where('web_stories.webstory_status', 1) // Active web stories
            ->select(
                'web_stories.id as story_id',
                'web_stories.title as story_title',
                'web_stories.thumbnail_image',
                'web_stories.slug',
                'web_stories.redirect_link',
                'web_story_galleries.media_url',
                'web_story_galleries.caption',
                'web_story_galleries.image_title'
            )
            ->get()
            ->groupBy('story_id'); 
    
        $storyArray = [];
    
        foreach ($categoryStories as $categoryId => $stories) {
            foreach ($stories as $story) {
                // Pluck both media_url, caption, and redirect_link from the gallery
                $imageDetails = collect($stories)->map(function ($galleryItem) use ($story) {
                    return [
                        'url' => asset($galleryItem->media_url), // Convert to full URL
                        'caption' => $galleryItem->caption,     // Add caption
                        'image_title' => $galleryItem->image_title,
                        'redirect_link' => $story->redirect_link, // Ensure redirect_link is accessed from the parent $story
                    ];
                })->toArray();
    
                // Remove empty image arrays (excluding the thumbnail check)
                $filteredImages = array_filter($imageDetails, function ($item) {
                    return !empty($item['url']) || !empty($item['caption']) || !empty($item['image_title']);
                });
    
                // Only add if there are valid images (thumbnail alone does not count)
                if (count($filteredImages) > 0) {
                    $filteredImages['thumbnail'] = $story->thumbnail_image; // Add thumbnail without validation
                    $filteredImages['slug'] = $story->slug;
                    $storyArray[$story->story_title] = $filteredImages;
                }
            }
        }
        return view('frontend.web-stories.webstories', compact('storyArray', 'flags', 'countryCode', 'ipcountryCode', 'country', 'locale'));
    }

    
    public function showStory($storySlug, Request $request)

    {
        $categoryStories = DB::connection('mysql_additional')
            ->table('web_stories')
            ->join('web_story_galleries', 'web_stories.id', '=', 'web_story_galleries.web_story_id')
            ->where('web_stories.webstory_status', 1) // Active web stories
            ->where('web_stories.slug', $storySlug)
            ->select(
                'web_story_galleries.media_url',
                'web_story_galleries.caption',
                'web_story_galleries.image_title',
                'web_stories.redirect_link',
                'web_stories.meta_keyword',
                'web_stories.meta_description'
            )
            ->get();

        $metaCreds = $categoryStories->first();
        $metaData = [
            'meta_keyword' => $metaCreds->meta_keyword,
            'meta_description' => $metaCreds->meta_description
        ]; 

        $statuses = [];
              
        foreach ($categoryStories as $story) {
            $statuses[] = [
                'url' => asset($story->media_url), // Convert to full URL
                'caption' => $story->caption,
                'image_title' => $story->image_title,
                'redirect_link' => $story->redirect_link,
            ];
        }
    
        // Pass the statuses data to the view
        return view('frontend.web-stories.show', [
            'statuses' => $statuses,
            'metaData' => $metaData
        ]);
    }

}
