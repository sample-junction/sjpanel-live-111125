@php
 use Carbon\Carbon;
 $useragent = $_SERVER['HTTP_USER_AGENT']; 

$iPod = stripos($useragent, "iPod"); 
$iPad = stripos($useragent, "iPad"); 
$iPhone = stripos($useragent, "iPhone");
$Android = stripos($useragent, "Android"); 
$iOS = stripos($useragent, "iOS");
//-- You can add billion devices 

 $DEVICE = ($iPod||$iPad||$iPhone||$Android||$iOS);
 
/* Parshant Sharma [23-08-2024] STARTS */

	//dd($countryPoints);
	//$metricConversion = round(1/$countryPoints, 4);
	$metricConversion = 1/$countryPoints;
	
	//dd($metricConversion);
	
/* Parshant Sharma [23-08-2024] ENDS */
$locale = session()->get('locale');
$language = explode('_', $locale)[0];

 @endphp
 @push('after-styles')  
 <style type="text/css">
    .not-li-size{
        font-size:12px;
    }

 @media (min-width: 220px) and (max-width: 767px){
    .not-li-size{
        font-size:10px;
    }

.cst-sec .cst-sec-anch {
    display: block !important;
    width: 100px;
    position: absolute;
    top: 8px;
    left: 55px;
}
.cst-sec .cst-sec-image{
    height:20px ;
}

#use_div{
    display: none !important;
}
.notify-icon{
    position: relative;
    right: 25px;
}
/*#user_img{
    display: block !important;
}*/
#user_pro_sec{
    transform:translate(-90%,5%) !important;
}
.user_Name{
    display: none !important;
}
#nav_log{
        /* margin-left: 30px; */
    display: block !important;
    position: absolute;
    top: 20px;
    left: 35px;
    margin-left: 10px;
    width: 89px;
    padding-left: -26px !important;
    height: -12px !important;
}
}
@media(min-width:768px){
    #user_img{
        display: none !important;
    }
}
@media(min-width:768px) and (max-width:982px){
/*    #searchBar{
    width: 142px !important;
    border: 1px solid #F4F4F4;
    display: inline-flex;
    display: inline-block !important;
    }*/
}
@media(min-width:990px){
    #hamB{
        pointer-events: none;
    }
}
.user_modal{
	transform: translate(-83%,5%);
}
@media(min-width:768px) and (max-width:1100px)  {
	.user_modal{
		transform: translate(-55%,5%);
	}
}

</style>

@endpush
 <header>

        <nav class="navbar fixed-top p-sm-2 p-md-2 border-bottom" style="background-color: white;">
            <div class="container-fluid">


                <div class="cst-sec">

                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation" style="border:none" id="hamB">

                    <img src="{{asset('img/Side bar hamburger Icon.png')}}" alt="" class="" width="30px">
                    </button>
    
                    <a class="navbar-brand d-none d-md-inline-block cst-sec-anch" id="nav_log" href="{{ env('APP_URL') }}">
                        <img src="{{asset('img/SJ Panel New LOGO without background.png')}}" alt="logo" width="150px" class="img-fluid ms-4 cst-sec-image">
                    </a>

                </div>

                
                <div class="cst-sec">

                    <span class="position-relative">
                        <img src="{{asset('img/search-icon.png')}}" alt="" width="10px" id="searchIcon" class="img-fluid position-absolute" style="left: 20px; top: calc(50% - 10px/2 - 1px); opacity: 0.7">
                        <input type="text" name="search" value="" placeholder="       {{__('inpanel.invite.myreferrals.index.search')}}" id="searchBar" class="d-none d-lg-inline-block p-2 rounded" style="width:400px; border: 1px solid #F4F4F4;">
                        
                        <div class="position-absolute border bg-white pt-2 ps-3 pe-2 pb-2 rounded" id="suggestionBox" style="width:100%; display:none; overflow-x:hidden">
                            <div class="row">
                                <div class="col-11 text-center">
                                    <p class="text-secondary text-start">{{__('inpanel.dashboard.suggestions')}}</p>
                                </div>

                                <div class="col-1 text-end"><img src="{{asset('images/642337_close_512x512.png')}}" alt="img" width="10px" class="sgst-close" style="cursor:pointer"></div>
                            </div>
                            <div class="row">
                                <div class="col text-start">
                                    <div class="search-suggestions"></div>
                                    <div class="method-suggestions"></div>
                                </div>
                            </div>
                        </div>

                    </span>
                    

                    <span class="dropdown">

                        <span class="notification" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                            @if(isset($user_notifications))
                                @if(count($user_notifications) > 0)
                                <img src="{{asset('img/Notification Icon With alert.png')}}" alt="" width="45px" class="ms-md-3 me-md-3 noti_Alert" >
                                @else
                                <img src="{{asset('img/notification img.png')}}" alt="" width="45px" class="ms-md-3 me-md-3 ">
                                @endif
                            @else
                            <img src="{{asset('img/notification img.png')}}" alt="" width="45px" class="ms-md-3 me-md-3 ">
                            @endif
                        </span>

                        <ul class="dropdown-menu shadow" style="transform:translate(-66%,3%); height:450px; overflow-y: scroll;width:250px;">
                        @if(isset($user_notifications))
                            @if(count($user_notifications) > 0)
                                @php
                                $url = '';
                                $count_live = 0;
                                $count_expired = 0;
                                $live_ids = [];
                                $expired_ids = []; 
                                $live_time = [];
                                $expired_time = [];  
                                @endphp
                                @foreach($user_notifications as $notification)
                                    @php
                                    if($notification->notification_type != 'New Survey' && $notification->notification_type != 'Survey'){
                                        if($notification->notification_type == 'Redeem Request'){
                                            if(strpos(strip_tags($notification->notification_text),__('frontend.notification_txt.redeem_rqst_coupon_redeem_1')) !== false){
                                                $url = route('inpanel.redeem.show', ['update' => true, 'notification_id' => $notification->id, 'history' => true]);
                                            }else{
                                                $url = route('inpanel.redeem.show', ['update' => true, 'notification_id' => $notification->id]);
                                            }
                                            
                                        }else if($notification->notification_type == 'Support Request'){
                                            $url = route('inpanel.user.support_history', ['update' => true, 'notification_id' => $notification->id]);
                                        }else if($notification->notification_type == 'Referral Request'){
                                            $url = route('inpanel.invite.show', ['update' => true, 'notification_id' => $notification->id]);
                                        }
                                                                        
                                    @endphp
                                    <!-- Code updated by Vikas For handling notification according to Languages(Starting 3/11/2025) -->

                                    <!-- <li class="border-bottom p-2"><a class="dropdown-item" href="{{$url}}">

                                            <span class="pe-2 not-li-size" style="font-size: 10px;"> {{--<img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif  alt="user" width="30px" class="img-fluid me-2">--}}{{--$notification->notification_type--}}{{--$notification->type_id--}} {{strip_tags($notification->notification_text)}}</span></br>
                                            <span class="mb-0 not-li-size" style="font-size: 10px; font-weight: 300; transform: translateX(-5px);">{{$notification->created_at->diffForHumans()}}</span>

                                    </a></li> -->
                                    <li class="border-bottom p-2">
                                        <a class="dropdown-item" href="{{ $url }}">
                                            <span class="pe-2 not-li-size" style="font-size: 10px;">
                                                @php
                                                    $notificationText = json_decode($notification->notification_text, true);
                                                @endphp

                                                @if(isset($notificationText['keys']))

                                                    @if(isset($notificationText['keys']['single']))

                                                        {{-- Single key notification --}}
                                                                @php
                                                                    // Prepare replacement variables
                                                                    $replaceVars = [];

                                                                    // Collect possible replacement values
                                                                    if(isset($notificationText['completion_points'])) {
                                                                        $replaceVars['completion_points'] = $notificationText['completion_points'];
                                                                    }
                                                                    if(isset($notificationText['completion_value'])) {
                                                                        $replaceVars['completion_value'] = $notificationText['completion_value'];
                                                                    }
                                                                    if(isset($notificationText['red_rqst_val'])) {
                                                                        $replaceVars['red_rqst_val'] = $notificationText['red_rqst_val'];
                                                                    }
                                                                    if(isset($notificationText['first_name'])) {
                                                                        $replaceVars['first_name'] = $notificationText['first_name'];
                                                                    }

                                                                    // Translate with replacements
                                                                    $translated = __($notificationText['keys']['single'], $replaceVars);
                                                                @endphp

                                                                {{ $translated }}
                                                    @elseif(isset($notificationText['keys']['start']) && isset($notificationText['keys']['mid']) && isset($notificationText['keys']['end']))
                                                
                                                        {{ $notificationText['red_rqst_val'] ?? '' }}
                                                        {{ __($notificationText['keys']['mid']) }}
                                                        {{ __($notificationText['keys']['start']) }}
                                                        {{ __($notificationText['keys']['end']) }}
                                                    @elseif(isset($notificationText['keys']['start']) && isset($notificationText['keys']['end']))
                                                        @if($language == 'hi')
                                                            {{-- Multi key notification (start + end) --}}
                                                            {{ $notificationText['supportId'] ?? $notificationText['redeem_request_id'] ?? $notificationText['first_name'] ?? $notificationText['red_rqst_val'] ?? '' }}
                                                            {{ __($notificationText['keys']['start']) }}
                                                            {{ __($notificationText['keys']['end']) }}
                                                        @else
                                                            {{ __($notificationText['keys']['start']) }}
                                                            {{ $notificationText['supportId'] ?? $notificationText['redeem_request_id'] ?? $notificationText['first_name'] ?? $notificationText['red_rqst_val'] ?? '' }}
                                                            {{ __($notificationText['keys']['end']) }}
                                                        @endif
                                                    @endif
                                                @else
                                                    {{ strip_tags($notification->notification_text) }}
                                                @endif
                                            </span>
                                            <br>
                                            <span class="mb-0 not-li-size" style="font-size: 10px; font-weight: 300; transform: translateX(-5px);">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </a>
                                    </li>
                                    <!-- Code updated by Vikas For handling notification according to Languages(Ending 3/11/2025) -->
                                    @php
                                    }else{
                                        if($notification->notification_type == 'New Survey'){
                                            array_push($live_ids,$notification->id);
                                            array_push($live_time,$notification->created_at);
                                            
                                            $count_live++;
                                        }elseif($notification->notification_type == 'Survey' && $notification->notification_text == 'Expired'){
                                            array_push($expired_ids,$notification->id);
                                            array_push($expired_time,$notification->created_at);
                                            
                                            $count_expired++;
                                        }
                                    }
                                @endphp
                                @endforeach
                                @if($count_live > 0)
                                    @php 
                                        $url = route('inpanel.survey.index', ['update' => true, 'notification_id' => $live_ids]); 
                                       $live_time_last = Carbon::parse($live_time[0]); 
                                    @endphp
                                    <li class="border-bottom p-2"><a class="dropdown-item" href="{{$url}}">

                                            <span class="pe-2 not-li-size" style="font-size: 10px;">{{-- <img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif  alt="user" width="30px" class="img-fluid me-2">--}}{{$count_live}}{{__('frontend.notification_txt.survey_assigned_new')}}</span></br>
                                            <span class="mb-0 not-li-size" style="font-size: 10px; font-weight: 300; transform: translateX(-5px);">{{$live_time_last->diffForHumans()}}</span>

                                    </a></li>
                                @endif
                                @if($count_expired > 0)
                                    @php 
                                        $url = route('inpanel.survey.index', ['update' => true, 'notification_id' => $expired_ids, 'history' => true]);
                                        $expired_time_last = Carbon::parse($expired_time[0]); 
                                    @endphp
                                    <li class="border-bottom p-2"><a class="dropdown-item" href="{{$url}}">

                                            <span class="pe-2 not-li-size" style="font-size: 10px;">{{-- <img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif  alt="user" width="30px" class="img-fluid me-2">--}}{{$count_expired}}{{__('frontend.notification_txt.survey_expired')}}</span></br>
                                            <span class="mb-0 not-li-size" style="font-size: 10px; font-weight: 300; transform: translateX(-5px);">{{$expired_time_last->diffForHumans()}}</span>

                                    </a></li>
                                @endif
                            @else
                            <li class="p-2"><a class="dropdown-item" href="#">

                                <span class="pe-4" style="font-size: 10px;"> {{__('frontend.notification_txt.no_notification')}}</span>
                                
                            </a></li>
                            @endif
                        @else
                            <li class="p-2"><a class="dropdown-item" href="#">

                                <span class="pe-4" style="font-size: 10px;"> {{__('frontend.notification_txt.no_notification')}}</span>
                                
                            </a></li>
                        @endif
                        </ul>

                    </span>



                    <span class="dropdown">

                        @if(!$DEVICE)
                        <div class="ps-4 pe-4 pt-2 pb-2 rounded ms-1 ms-md-0" style="display:inline-block; background-color: #F4F4F4;" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" id="user_pro_div"> 
                            {{--<img @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;"> --}}
                           <!--<img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />-->
                           <img id="profileImg" @if(Auth::user()->thumbnail_image_path) src="{{config('settings.centralize_server_image').(Auth::user()->thumbnail_image_path)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />
                            <span class="user_Name">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</span>
                        </div>
                        @else
                        <div class="ps-4 pe-4 pt-2 pb-2 rounded ms-1 ms-md-0" style="display:inline-block; background-color: #F4F4F4;" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" id="user_pro_div"> 
                            {{--<img @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user" class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" > --}}
                            <!--<img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user" class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" > -->
                            <img id="profileImg" @if(Auth::user()->thumbnail_image_path) src="{{config('settings.centralize_server_image').(Auth::user()->thumbnail_image_path)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />
                            
                        </div>
                        @endif
                        @if(!$DEVICE)
                        <ul class="dropdown-menu pt-4 ps-4 pe-4 shadow" style="transform:translate(-55%,5%)">
                        @else
							<ul class="dropdown-menu pt-4 ps-4 pe-4 shadow user_modal" style="transform:translate(-83%,5%)">
							
                        @endif

                            <div class="row">

                                <div class="col">
                                    <a href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}" class="cst-menu-user-li">{{__('inpanel.topbar.edit_profile')}}</a>
                                </div>

                                <div class="col text-end">
                                    <a href="{{ route('frontend.auth.logout') }}" class="cst-menu-user-li">{{__('inpanel.topbar.logout')}}</a>
                                </div>

                            </div>

                            <div class="row text-center mt-2">

                                <div class="col">
                                    {{--<img id="profileImg" @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:58px;width:58px;object-fit:cover;cursor:pointer;"> --}}
                                    <!--<img id="profileImg" @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:58px;width:58px;object-fit:cover;cursor:pointer;">-->
                                    <img id="profileImg" @if(Auth::user()->thumbnail_image_path) src="{{config('settings.centralize_server_image').(Auth::user()->thumbnail_image_path)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />
                                </div>
                                

                            </div>
                            <div class="row text-center mt-2">
                                <div class="" id="imgOptionContainer" >
                                       <form id="imgForm" method="post" action="{{route('inpanel.user.profile.preference.update','image-update')}}" enctype="multipart/form-data">
                                        @csrf
                                            <input type="file" id="imgUpload" name="imgUpload" accept="image/*" style="display:none;">
                                            <input type="hidden" id="section" name="section" value="image-update">
                                            <div class="col">
                                                <button id="changeImg" type="button" style="display:none;" class="btn btn-primary btn-sm mt-4 w-sm-100">{{__('inpanel.topbar.add_image')}}</button>
                                                <button id="saveImg" type="submit" style="display:none;" class="btn btn-primary btn-sm mt-4 w-sm-100">{{__('inpanel.topbar.save_image')}}</button>
                                                <button id="removeImg" type="button" style="display:none;" class="btn btn-primary btn-sm mt-4 w-sm-100">{{__('inpanel.topbar.remove_image')}}</button>
                                                    
                                            </div>
                                        </form>
                                        <span id="imgUpload_err" style="color:red;font-size:14px;"></span>
                                </div>
                                <div class="col">
                                <form id="remove_form" method="post" action="{{route('inpanel.user.profile.preference.update','image-delete')}}" >
                                    @csrf
                                    <input type="hidden" name="keyDelete" value="profile_picture">
                                    <input type="hidden" name="section" value="image-delete">
                                </form>
                                </div>
                            </div>
							@php
								if(@$detailed_profile_survey){
								$detailed_profile_count = 1;
								$detailedProfileComplete = 0;
								}else{
								$detailed_profile_count = 0;
								$detailedProfileComplete = 1;
								}
								$total_surveys  = count($allUserSurveys)+1;
								$active_surveys  = $active_user_count;
								$completed_surveys  = count($completedSurveys)+$detailedProfileComplete;
								$attemptedSurvey  = $user_count;
								$expiredSurvey  = count($userExpireSurveys);
                                $redeem_points = session()->has('redeem_requests_points') ? session()->get('redeem_requests_points') : 0;
							@endphp
                            
                            <div class="row text-center" style="width:300px">

                                <div class="col-12">  
                                    <p class="user-text-main mt-3">{{ Auth::user()->first_name }}&nbsp;{{ Auth::user()->last_name }}</p> 
								</div>

                                <div class="col-12">

                                    <span class="">{{str_replace('Your','',__('inpanel.dashboard.user.panId'))}} </span> 
                                    <span class="user-text-main">{{ Auth::user()->panellist_id }} | </span> 
                                    <span class="user-text-main">{{ Auth::user()->country}}</span> 

                                    

                                </div>

                            </div>


                            <div class="row mt-2 pt-2 pb-1 border-bottom border-top">

                                <div class="col pt-2"><p class="user-text">{{__('inpanel.topbar.survey_taken')}}</p></div>

                                <div class="col text-end"><span class="small fw-bold text-primary p-2 rounded text-end" style="background: #f6fbff;position: relative;top: 5px;left: 10px;display: inline-block;width: 63px;text-align: center;padding: 4px 0px !important;">@if( isset($allUserSurveys)){{($attemptedSurvey)}} @else{{0}}@endif</span></div>

                            </div>

                            <div class="row mt-2 pt-2 pb-1 border-bottom">

                                <div class="col"><p class="user-text">{{__('inpanel.topbar.points')}}</p></div>

                                <div class="col text-end"><span class="small fw-bold text-primary p-2 rounded text-end" style="background: #f6fbff;position: relative;top: 5px;left: 10px;display: inline-block;width: 63px;text-align: center;padding: 4px 0px !important;">@if( isset($user_point)) {{$user_point - $redeem_points}}@else{{'0'}}@endif</span></div>

                            </div>

                            <div class="row pt-2 mt-2">

                                <div class="col"><p class="user-text">{{__('inpanel.topbar.earning')}}</p></div>

                                <!--<div class="col text-end"><span class="small fw-bold text-primary p-2 rounded" style="background: #f6fbff;position: relative;top: 2px;left: 10px;display: inline-block;width: 63px;text-align: center;padding: 4px 0px !important;">
                                @if( isset($user_point)) 
                                    @if((($user_point - $redeem_points)/1000) < 1)
                                        {{(($user_point - $redeem_points)/1000)*100}} {{__('inpanel.dashboard.cents')}}
                                    @else
                                     ${{($user_point - $redeem_points)/1000}}
                                    @endif
                                @else{{'0'}}
                                @endif
                                </span></div>-->
								
								<!-- Parshant Sharma [23-08-2024] STARTS -->
								
								<div class="col text-end"><span class="small fw-bold text-primary p-2 rounded text-end" style="background: #f6fbff;position: relative;top: 2px;left: 10px;display: inline-block;width: 63px;text-align: center;padding: 4px 0px !important;">
                                @if( isset($user_point)) 
                                    @if((($user_point - $redeem_points)*$metricConversion) < 1)
									@php
										$currency = ((($user_point - $redeem_points)*$metricConversion)*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
									@endphp
                                        {{number_format((($user_point - $redeem_points)*$metricConversion)*100,2)}} {{__($currency)}}
                                    @else
                                     {{$currencies['currency_logo']}}{{number_format(($user_point - $redeem_points)*$metricConversion,2)}}
                                    @endif
                                @else{{'0'}}
                                @endif
                                </span></div>
								
								<!-- Parshant Sharma [23-08-2024] ENDS -->
								
                            </div>


                        </ul>


                    </span>
                    

                </div>





                @if($DEVICE)
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header border-bottom">

                        <a class="" href="{{ env('APP_URL') }}"><img src="{{asset('img/SJ Panel New LOGO without background.png')}}" alt="logo" width="150px" class="img-fluid"></a>

                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        
                    </div>

                                

                    <div class="offcanvas-body">

                    <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="{{__('inpanel.invite.myreferrals.index.search')}}" aria-label="Search" id="searchIdMob">
                            <!-- <button class="btn" type="submit" style="background: #006bde; color: white;">{{__('inpanel.invite.myreferrals.index.search')}}</button> -->
                    </form>            

                    <div class="position-absolute border bg-white pt-2 pb-2 rounded" id="suggestionBoxMob" style="width:90%; display:none; overflow-x:hidden; z-index:1;">
                            <div class="row m-0">
                                <div class="col-11 text-center">
                                    <p class="text-secondary text-start">{{__('inpanel.dashboard.suggestions')}}</p>
                                </div>

                                <div class="col-1 text-end"><img src="{{asset('images/642337_close_512x512.png')}}" alt="img" width="10px" class="sgst-close-mob" style="cursor:pointer"></div>
                            </div>
                            <div class="row">
                                <div class="col text-center">
                                    <div class="search-suggestions-mob"></div>
                                    <div class="method-suggestions-mob"></div>
                                </div>
                            </div>
                    </div>
                    
                        <ul class="navbar-nav p-3 justify-content-end flex-grow-1 pe-3">

                            <li class="nav-item mt-2 " >
                                <a class="nav-link side-menu-li-mob @yield('dashboard_select')" aria-current="page" href="{{ route('inpanel.dashboard') }}">
								<span>
								@if(trim($__env->yieldContent('dashboard_select')))
								<img src="{{asset('images/Dashboard  Bold Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
								@else
								<img src="{{asset('images/Dashboard Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
								@endif
								</span> {{__('inpanel.nav.dashboard')}}</a>
                            </li>

                            <li class="nav-item " >
                                <a class="nav-link side-menu-li-mob @yield('myAccount_select')" aria-current="page" href="{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}">
								<span>
								@if(trim($__env->yieldContent('myAccount_select')))
								<img src="{{asset('images/My Account Bolc Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
								@else
								<img src="{{asset('images/My Account Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
								@endif
								</span> {{__('inpanel.nav.my_account')}}</a>
                            </li>

                            <li> <hr class="cst-space"> </li>

                            
                            <li class="nav-item" id="detailed_Profile" >
                                <a class="nav-link side-menu-li-mob @yield('detailProfile_select')" href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif">
                                    <span>
                                    @if(trim($__env->yieldContent('detailProfile_select')))
                                        <img src="{{asset('images/Detailed Profile Bold icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    @else
                                        <img src="{{asset('images/Detailed Profile Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    @endif
                                    </span> {{__('inpanel.nav.detailed_profile')}}
                                </a>
                            </li>

                            @php




							if(@session()->get('surveys')!=0){

								$count_sr=1;
                                $num_live_sr = @session()->get('surveys');

							}else{

								 $count_sr=0;

							}




							@endphp
                            <li class="nav-item" id="survey_sec">
                                <a class="nav-link side-menu-li-mob" href="@if(Route::has('inpanel.survey.index')){{ route('inpanel.survey.index') }}@endif">
                                    <span>
                                        <img src="{{asset('images/Surveys Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    </span> {{__('inpanel.nav.surveys')}}
                                     @if($count_sr!=0)
                                     <span>
                                        <span class="text-primary small">({{$num_live_sr}})</span>
                                        <img src="{{asset('images/Ellipse 3.png')}}" alt="" style="transform:translateX(170px)">
                                    </span>
                                    @endif
                                </a>
                            </li>

                            <li> <hr class="cst-space"> </li>

                            
                            <li class="nav-item">
                                <a class="nav-link side-menu-li-mob  @yield('points_select')" href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif">
                                    <span>
                                    @if(trim($__env->yieldContent('points_select')))
                                        <img src="{{asset('images/My Points Bold Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                        @else
                                        <img src="{{asset('images/My Points Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    @endif    
                                    </span> {{__('inpanel.nav.label.reward_points')}}</a>
                            </li>
                            
                            
                            <!-- <li class="nav-item" id="Reedem_Points">
                                <a class="nav-link side-menu-li-mob" href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif">
                                    <span>
                                        <img src="{{asset('images/Points redemption Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    </span> {{__('inpanel.nav.label.redeem_points')}}</a>
                            </li> -->

                            
                            <li class="nav-item">
                                <a class="nav-link side-menu-li-mob @yield('invite_select')" href="@if(Route::has('inpanel.invite.show')){{ route('inpanel.invite.show') }}@endif">
                                    <span>
                                    @if(trim($__env->yieldContent('invite_select')))
                                    <img src="{{asset('images/refer bold icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    @else
                                    <img src="{{asset('images/Refer a friend Icon.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    @endif
                                </span> {{__('inpanel.nav.label.refer')}}</a>
                            </li>

                            <li> <hr class="cst-space"> </li>

                            
                            <li class="nav-item">
                                <a class="nav-link side-menu-li-mob @yield('panelistSupport_select')" href="{{route('inpanel.user.support')}}">
                                    <span>
                                    @if(trim($__env->yieldContent('panelistSupport_select')))
                                        <img src="{{asset('images\Panel Support Bold.png')}}" width="15px" class="img-fluid me-3" alt="">
                                    @else
                                        <img src="{{asset('images\Panelist Support Icon.png')}}" width="15px" class="img-fluid me-3" alt="">
                                    @endif
                                    </span> {{__('inpanel.nav.panelist_support')}}</a>
                            </li>

                            
                            <li class="nav-item">
                                <a class="nav-link side-menu-li-mob" href="{{route('frontend.cms.faq')}}">
                                    <span>
                                        <img src="{{asset('images/FAQ Icone.png')}}" width="15px" class="img-fluid me-2" alt="">
                                    </span> {{__('inpanel.nav.label.faq')}}</a>
                            </li>

 
                        </ul>

                    </div>
                </div>
                @endif
            </div>
        </nav>


    </header>
    @push('after-scripts')
    <script>
        var sb = document.getElementById("searchBar");
        var si = document.getElementById("searchIcon");
        var suggestionBox = document.querySelector('#suggestionBox');
        // var search_Results = document.querySelectorAll('.search-result');
        // console.log(search_Results);

        const searchMethods = [
        {method: "{{__('inpanel.dashboard.methods.m1')}}"},
        {method: "{{__('inpanel.dashboard.methods.m2')}}"},
        {method: "{{__('inpanel.dashboard.methods.m3')}}"},
        {method: "{{__('inpanel.dashboard.methods.m4')}}"},
        {method: "{{__('inpanel.dashboard.methods.m5')}}"},
        {method: "{{__('inpanel.dashboard.methods.m6')}}"},
        {method: "{{__('inpanel.dashboard.methods.m7')}}"},
        {method: "{{__('inpanel.dashboard.methods.m8')}}"},
        {method: "{{__('inpanel.dashboard.methods.m9')}}"},
        {method: "{{__('inpanel.dashboard.methods.m10')}}"},
        {method: "{{__('inpanel.dashboard.methods.m11')}}"},
        {method: "{{__('inpanel.dashboard.methods.m12')}}"},
        {method: "{{__('inpanel.dashboard.methods.m13')}}"},
        {method: "{{__('inpanel.dashboard.methods.m14')}}"},
        {method: "{{__('inpanel.dashboard.methods.m15')}}"},
        {method: "{{__('inpanel.dashboard.methods.m16')}}"},
        {method: "{{__('inpanel.dashboard.methods.m17')}}"},
        {method: "{{__('inpanel.dashboard.methods.m18')}}"},
        {method: "{{__('inpanel.dashboard.methods.m19')}}"},
        {method: "{{__('inpanel.dashboard.methods.m20')}}"},
        {method: "{{__('inpanel.dashboard.methods.m21')}}"},
        {method: "{{__('inpanel.dashboard.methods.m22')}}"},
        {method: "{{__('inpanel.dashboard.methods.m23')}}"},
        {method: "{{__('inpanel.dashboard.methods.m24')}}"},
        {method: "{{__('inpanel.dashboard.methods.m25')}}"},
        {method: "{{__('inpanel.dashboard.methods.m26')}}"}];


        const methodRoutes = [
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=basic"},
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=security"},
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=email"},
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=mydata"},
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=deactivate"},
            {route:"{{ route('inpanel.user.profile.preference.show', 'basic-profile') }}?tab=delete"},
            {route:"{{ route('inpanel.profiler.show') }}"},
            {route:"{{ route('inpanel.survey.index') }}?tab=live"},
            {route:"{{ route('inpanel.survey.index') }}?tab=history"},
            {route:"{{ route('inpanel.survey.index') }}?tab=expired"},
            {route:"{{ route('inpanel.redeem.show') }}"},
            {route:"{{ route('inpanel.redeem.show') }}"},
            {route:"{{ route('inpanel.redeem.show') }}"},
            {route:"{{ route('frontend.cms.rewards') }}"},
            {route:"{{route('inpanel.user.support')}}"},
            {route:"{{route('inpanel.user.support_history')}}"},
            {route:"{{route('frontend.cms.faq')}}"},
            {route:"{{route('frontend.cms.privacy')}}"},
            {route:"{{route('frontend.cms.cookie')}}"},
            {route:"{{route('frontend.cms.rewards_policy')}}"},
            {route:"{{route('frontend.cms.referral_policy')}}"},
            {route:"{{route('frontend.cms.safeguard')}}"},
            {route:"{{route('frontend.cms.term_condition')}}"},
            {route:"{{route('frontend.cms.help_support')}}"},
            {route:"{{ route('inpanel.invite.show') }}"},
            {route:"{{ route('inpanel.invite.show') }}"}];

            console.log(methodRoutes);
            

        sb.addEventListener("keyup", () => {

            if(sb.value !== ''){
                si.style.visibility = 'hidden';
                var searchText = '^'+sb.value;

                // console.log(searchMethods[0].method);
                var methodResult = [];
                var new_html_method = "";

                var rgxp = new RegExp(searchText, "gi");

                if(searchText[0] !== '$' || searchText[0] !== '£'){

                    for(let i = 0; i < searchMethods.length; i++){

                        if(searchMethods[i].method.match(rgxp) != null){

                            // methodResult.push(searchMethods[i].method);

                            new_html_method += `<div><a class="fw-bold" href="${methodRoutes[i].route}" style="text-decoration:none">${searchMethods[i].method}</a></div><hr class="line-hr" style="margin:5px">`;

                        }else{
                            document.querySelector(".method-suggestions").innerHTML = '';
                        }
                    }jQuery(".method-suggestions").append(new_html_method);

                                    // console.log(methodResult);
                }

                var new_html_search = "";

                $.ajax({
                        url: "{{route('inpanel.search')}}",
                        type: 'POST',
                        data: { query:sb.value, _token: '{{csrf_token()}}' },
                        dataType: 'JSON',

                        success: function (response) { 
                            console.log(response.data);
                            							
							let currencySign = response.currencies['currency_logo'];
							//let metricConversion = (1 / response.currencies['countryPoints']).toFixed(4);
							let metricConversion = 1 / response.currencies['countryPoints'];
							
							
                            document.querySelector(".search-suggestions").innerHTML = '';
                            var points = '{{__('inpanel.dashboard.points')}}';

                            if(response.data.length > 0){
                            
                                for(let i = 0; i < response.data.length; i++){
									
									

                                    var user_link_route = "{{ route('inpanel.survey.index') }}?tab=live";

                                    if(response.data[i].status == null){
                                        user_link_route = user_link_route;
                                    }else{
                                        user_link_route = "{{ route('inpanel.survey.index') }}?tab=history";
                                    }

                                    if(response.data[i].survey_status_code != "LIVE"){
                                        user_link_route = "{{ route('inpanel.survey.index') }}?tab=expired";
                                    }

                                        if(i < 10){
                                            new_html_search += `<div><a class="fw-bold" href="${user_link_route}&survey=${response.data[i].apace_project_code}" style="text-decoration:none">${response.data[i].apace_project_code} - ${response.data[i].points} ${points} - ${currencySign}${(response.data[i].points*metricConversion).toFixed(2)} - ${response.data[i].loi}min</a></div><hr class="line-hr" style="margin:5px">`;
                                        }
                                    }
                                    jQuery(".search-suggestions").append(new_html_search);

                            }else{
                                if(document.querySelector(".method-suggestions").innerHTML == ''){
                                    document.querySelector(".search-suggestions").innerHTML = '{{__('inpanel.dashboard.nothing')}}';
                                }
                            }

                        },
                        error: function (data, textStatus, errorThrown) {
                            console.log(data);
                        }
                }); 


            }else{
                si.style.visibility = 'visible';
            }

        });

        var suggestionB = document.getElementById("suggestionBox");

        sb.addEventListener('click', () => {

            suggestionB.style.display = "block";

        });


        var sgstc = document.querySelector('.sgst-close');
        sgstc.addEventListener('click', () => {

        suggestionB.style.display = "none";

        });

        document.addEventListener('click', function(event) {
        if (!searchBar.contains(event.target) && !suggestionB.contains(event.target)) 
        {
            suggestionB.style.display = 'none';
        }
    });
    </script>
    <script>
        $(document).ready(function(){
            $('#saveImg').hide();
            var profileImgSrc = $('#profileImg').attr('src');
            if(!profileImgSrc.includes('profile_default')){
                $('#removeImg').show();
                $('#changeImg').text("{{__('inpanel.topbar.change_image')}}");
            }
            $('#changeImg').show();
            $('#changeImg').click(function(){
                $('#imgUpload').click();
            });
        });
        $(document).ready(function(){
            $('#imgUpload').on('change',function(){
					
                    var file = this.files[0];
                    if(file.type.split('/')[0] !== 'image'){
                        // alert('Only image file allowed');
                        $('#imgUpload_err').html('{{__('inpanel.user.profile.preferences.preferences_menu.image_error')}}');
                        file.val('');
                    }else{
					    if(file){
                            $('#imgUpload_err').html('')
                            var reader = new FileReader();
                            reader.onload = function(e){
                                $('#profileImg').attr('src',e.target.result);
                                    $('#saveImg').show();
                                    $('#removeImg').hide();
                                }
                            reader.readAsDataURL(file);
                            
                        }
                    }
                });
                $('#removeImg').on('click',function(){
                    $('#remove_form').submit();
                });
        });


        //for mobile search

        var sbmob = document.getElementById("searchIdMob");
        var suggestionBoxMob = document.querySelector('#suggestionBoxMob');

        sbmob.addEventListener("keyup", () => {

        if(sbmob.value !== ''){

            var searchText = '^'+sbmob.value;
            var methodResult = [];
            var new_html_method = "";

            var rgxp = new RegExp(searchText, "gi");

            if(searchText[0] !== '$'){

                for(let i = 0; i < searchMethods.length; i++){

                    if(searchMethods[i].method.match(rgxp) != null){

                        // methodResult.push(searchMethods[i].method);

                        new_html_method += `<div><a class="fw-bold small" href="${methodRoutes[i].route}" style="text-decoration:none">${searchMethods[i].method}</a></div><hr class="line-hr" style="margin:5px">`;

                    }else{
                        document.querySelector(".method-suggestions-mob").innerHTML = '';
                    }
                }jQuery(".method-suggestions-mob").append(new_html_method);

                                // console.log(methodResult);
            }

            var new_html_search = "";

            $.ajax({
                    url: "{{route('inpanel.search')}}",
                    type: 'POST',
                    data: { query:sbmob.value, _token: '{{csrf_token()}}' },
                    dataType: 'JSON',

                    success: function (response) { 
                        console.log(response.data);

                        document.querySelector(".search-suggestions-mob").innerHTML = '';
                        var points = '{{__('inpanel.dashboard.points')}}';

                        if(response.data.length > 0){

                        
                            for(let i = 0; i < response.data.length; i++){

                                var user_link_route = "{{ route('inpanel.survey.index') }}?tab=live";

                                if(response.data[i].status == null){
                                    user_link_route = user_link_route;
                                }else{
                                    user_link_route = "{{ route('inpanel.survey.index') }}?tab=history";
                                }

                                if(response.data[i].survey_status_code != "LIVE"){
                                    user_link_route = "{{ route('inpanel.survey.index') }}?tab=expired";
                                }

                                    if(i < 10){
                                        new_html_search += `<div><a class="fw-bold small" href="${user_link_route}&survey=${response.data[i].apace_project_code}" style="text-decoration:none">${response.data[i].apace_project_code} - ${response.data[i].points} ${points} - $${response.data[i].points*0.001} - ${response.data[i].loi}min</a></div><hr class="line-hr" style="margin:5px">`;
                                    }
                                }
                                jQuery(".search-suggestions-mob").append(new_html_search);

                        }else{
                            if(document.querySelector(".method-suggestions-mob").innerHTML == ''){
                                document.querySelector(".search-suggestions-mob").innerHTML = '{{__('inpanel.dashboard.nothing')}}';
                            }
                        }

                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log(data);
                    }
            }); 


        }
        

        });


        sbmob.addEventListener('click', () => {

            suggestionBoxMob.style.display = "block";

        });


        var sgstcm = document.querySelector('.sgst-close-mob');
        sgstcm.addEventListener('click', () => {

            suggestionBoxMob.style.display = "none";

        });

        //
        
    </script>    
    @endpush