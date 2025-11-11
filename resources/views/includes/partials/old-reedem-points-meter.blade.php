@php
        $user_point = isset($user_point) ? $user_point : 0;
        $redeem_points = session()->has('redeem_requests_points') ? session()->get('redeem_requests_points') : 0; 
        $redeem_points = isset($redeem_points) ? $redeem_points : 0;
        $remaining_points = $user_point - $redeem_points;


        $timeZone = 'Asia/Kolkata';
        $hasRewardData = (auth()->user()->country_code == 'IN');
        $zoomDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2025-04-25 01:00:00', $timeZone);

        $zoomLink = 'https://us04web.zoom.us/j/77489295734?pwd=nBLtm3KF1hQvoMXvTnMgayBd1SWgFO.1';

        $bannerDate = $zoomDateTime->format('d F, Y');
        $bannerTime = $zoomDateTime->format('h:i A'); 


        $rewardMonth = new DateTime('2025-04-01');
        $rewardMonth = strtoupper($rewardMonth->format('F, Y'));
        
   
        $currentDateTime = \Carbon\Carbon::now()->setTimezone($timeZone);
        $dateTime = $zoomDateTime->copy()->addMinutes(30);
        $hasValidTimeForBanner = ($currentDateTime < $dateTime);
        
        

    @endphp


<style>
  .redemption_point_sec {
/*    border: 2px solid black !important;*/
    height: 14px;
    width: 83%;
    margin-left: 9%;
    display: flex;
    align-items: center;
    /*border-left: 1px solid black;*/
  /*border-right: 1px solid black;*/
/*    margin-top: 3%;*/
  }


  .red_fill {
    display: none;
  }

.add_weight{
  font-weight:600;
}

  .red_unfill {
    display: none;
  }

  .redeem_filled_sec {
    height: 100%;
    width: calc((@php echo isset($remaining_points ) ? min($remaining_points , $user_point) : 0 @endphp) / 5000 * 100%);
    text-align: center;
    background-color: #25A76E;
    border-radius: 5px 5px 5px 5px;
    /* box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; */
/*    border-radius: 22px 0 0 22px;*/
/*    border: 1px solid #ECECEC;*/
    border-bottom: 1px solid #ECECEC;;
    border-top: 1px solid #ECECEC;;
    border-right: none !important;
/*    border-bottom: none !important;*/
/*    transition: width 1.5s ease-in-out;*/
transition: all 1s ease;
/*    border-right: 2px solid black; */
    color: #fff;
  }

  .redeem_unfilled_sec {
    text-align: center;
    height: 100%;
    color: blue;
    border-radius: 0px 5px 5px 0px;
/*    border-radius: 0 22px 22px 0;*/
    /* box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; */
    border-left: none !important;
    border-right: none !important;
    border: 1px solid #ECECEC;
    background: #D9D9D9;
    width: calc(100% - calc((@php echo isset($remaining_points ) ? min($remaining_points , $user_point) : 0 @endphp) / 5000 * 100%));;
  }

  .red_fill , .red_unfill{
    font-size: 12px !important;
    color: black;
  }

  .redem_head{
    position: relative;
    font-weight: 600;
  }

.points_scale {
  display: flex;
  justify-content: space-between;
  padding: 10px;
}

.point_tick {
  flex-basis: calc(100% / 6); 
  position: relative;
}

.point_ticks::before {
    content: "";
    position: absolute;
    top: 35px;
    right: 50%;
    width: 1px;
    height: 97%;
    background-color: black;
    /*flex-grow: 1;*/
}

.earn_head{
    font-size: 16px;
}

.blue-box {
    width: 20px;
    height: 20px;
    background-color: #25A76E;
    display: inline-block;
    margin-right: 10px; 
    position: relative;
    top: 4px;
    /* box-shadow: 0px 1px 5px 0px #888888; */
}

.white-box {
    width: 20px;
    height: 20px;
    background-color: #D9D9D9;
    /* box-shadow: 0px 1px 5px 0px #888888; */
    border: 1px solid #ECECEC; 
    display: inline-block;
    margin-right: 10px;
    position: relative;
    top: 4px;
}

.point_indicator{
    margin-top: 2%;
}

.point_redeem_head{
  font-size: 16px;
  text-align: center;
  font-weight: 600;
  margin-top: 2%;
  margin-bottom: 0;
}

.point_redeem_image{
  position: relative;
    width: 30px;
    scale: 2;
}

.redemption_point_sec .partit{
  
    /*width: 182.6px !important;*/
    height: 14px;

}

.filled_portion, .unfilled_portion{
  font-weight:700;
  color:#005A9A;
}


.day-tag, .hr-tag, .min-tag, .sec-tag{
    position: relative;
}

        .day-tag::after{
            content:'DAYS';
            color:#f8f5fa;
            position: absolute;
            bottom:0;
            left: 50%;
            transform: translate(-50%, 20px);
            font-size:10px;
        }

        .hr-tag::after{
            content:'HOURS';
            color:#f8f5fa;
            position: absolute;
            bottom:0;
            left: 50%;
            transform: translate(-50%, 20px);
            font-size:10px;
        }

        .min-tag::after{
            content:'MINUTES';
            color:#f8f5fa;
            position: absolute;
            bottom:0;
            left: 50%;
            transform: translate(-50%, 20px);
            font-size:10px;
        }

        .sec-tag::after{
            content:'SECONDS';
            color:#f8f5fa;
            position: absolute;
            bottom:0;
            left: 50%;
            transform: translate(-50%, 20px);
            font-size:10px;
        }

  @media(min-width: 220px) and (max-width:768px){

    .add_weight{
      font-weight:600;
      font-size:12px;
    }

    .redeem_filled_sec{
      font-size: 12px !important;
    }
    .redeem_unfilled_sec{
      font-size: 12px !important;
    }
    .redem_head{
      top: 1rem !important;
  }

    .points_scale{
        font-size: 13px;
    }
    .filled_portion{
        font-size: 13px;
    }
    .unfilled_portion{
        font-size: 13px;
    }
    .blue-box{

    }
    .white-box{
        
    }

    .res-size{
      font-size: 13px;
    }
    .point_redeem_head{
        font-size: 13px;
        margin-top: 7%;
        margin-bottom: 0;
    }
  }

  @media(min-width: 350px) and (max-width:380px){
    .point_ticks::after{
        top: 50px;
        height: 56%;
    }
  }

  @media(min-width: 381px) and (max-width:768px){
    .point_ticks::after{
        top: 31px;
        height: 110%;
    }
  }

  @media(min-width: 768px) and (max-width:990px){

  }
</style>


<body>

<div class="row p-lg-3">


@if(trim($__env->yieldContent('dashboard_select')))


<div class="p-3 rounded">

    <div class="row rounded mt-1 mt-lg-1 p-3 bg-white" style="border-radius: 10px;" id="top_user_info">

        <div class="col-12 col-md-4 text-center text-md-start">
    
            {{--<img @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif  class="img-fluid me-3 mb-1" alt="img" style="height:45px;width:45px;object-fit:cover;scale:1.3; border-radius:32px!important;"> --}}
            <img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />
                            
             <span class="lead d-none d-md-inline-block">{{__('inpanel.dashboard.user.name')}}</span>  <span class="lead fw-bold d-none d-md-inline-block" style="text-transform: capitalize;" id="user_first_name_tab">{{ Auth::user()->first_name }} !</span>
    
            <p class="lead d-sm-none mt-2 mb-1">{{__('inpanel.dashboard.user.name')}} <span class="fw-bold">{{ Auth::user()->first_name }}!</span> </p>

        </div>
    
         
        <div class="col-12 col-md-8 text-center text-md-end mt-1"> 
    
            <span class="d-none d-md-inline-block"><small>{{__('inpanel.dashboard.user.panId')}} </small><span class="fw-bold">{{ Auth::user()->panellist_id }}</span> <span class="ms-2 me-2">|</span> <span class="fw-bold">{{ Auth::user()->country}}</span>  <span class="ms-2 me-2">|</span></span>
    
            <p class="d-sm-none m-1">{{__('inpanel.dashboard.user.panId')}}. <span class="fw-bold">{{ Auth::user()->panellist_id }} | {{ Auth::user()->country}}</span></p>
             
                                
            <span class="text-primary"> <a href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif">{{__('inpanel.dashboard.user.pro_completed')}} @if(isset($profilePercent)){{$profilePercent}}@else{{0}}@endif%</a> </span>
            
        </div>
    
    </div>

</div>

@endif
 

	<!-- 
		# PARSHANT SHARMA [12-03-2024]
		Countdown timer for survey reward START
	-->

  @if($hasRewardData && $hasValidTimeForBanner)
		
      <div class="row p-0 m-0" id="reward_banner_inpanel">
            <div class="col p-0 p-lg-2 border bg-primary pt-lg-3">
                <div class="row">
                    <div class="col-12 p-4 d-lg-none" style="background-image: url('img/bg-counter.png'); background-size: cover;">
                    </div>

                    <div class="col-1 pt-2 d-none d-lg-block">

                        <img src="{{asset('img/gift.png')}}" alt="icon" class="img-fluid mt-4" width="200px" style="scale:1.5">

                    </div>

                    <div class="col-12 col-lg-10 text-center">

                        <div class="row">

                            <div class="col-12 col-lg-4 text-center mt-4" style="font-size: 25px;">
                                <p class="fw-bold text-light">MARCH, 2025 AWARD ANNOUNCEMENT</p>
                            </div>

                            <div class="col-12 col-lg-4 text-center">
                                <!-- <p class="text-light ps-4 pe-4 ps-lg-0 pe-lg-0">Click the button below to join the live award session on 15th May, 2024 at 7:00 PM EST</p> -->
                                <p class="text-light ps-4 pe-4 ps-lg-0 pe-lg-0">Click the button below to join the live award session on {{ $bannerDate }} at {{ $bannerTime }} IST</p>
                                <a href="javascript:void(0);"  class="links" title="This link will start working 10 minutes priori to schedule time"><button class="btn btn-light" disabled>Click Here</button></a>
                            </div>
                            
                            <div class="col-12 col-lg-4 text-center mt-5">

                                <p class="text-light fw-bold lead m-0"> 
                                    <span class="lead text-light fw-bold p-2 day-tag" style="background: rgb(208 226 243 / 53%);" id="days">00</span> :
                                    <span class="lead text-light fw-bold p-2 hr-tag" style="background: rgb(208 226 243 / 53%);" id="hours">00</span> :
                                    <span class="lead text-light fw-bold p-2 min-tag" style="background: rgb(208 226 243 / 53%);" id="minutes" >00</span> :
                                    <span class="lead text-light fw-bold p-2 sec-tag" style="background: rgb(208 226 243 / 53%);" id="seconds">0</span>
                                </p>

                            </div>

                        </div>

                        <div class="row mt-2">

                            <p class="text-light d-none d-lg-block" style="font-size:18px"><strong>CATEGORIES:</strong> MOST ACTIVE PANELIST || SURVEY SUPERSTAR || PROFILE PRODIGY</p>

                            <div class="col-12 mt-4 d-lg-none">
                                <p class="mb-1 lead fw-bold text-light">CATEGORIES :</p>
                                <p class="lead m-0 text-light">MOST ACTIVE PANELIST</p>
                                <p class="lead m-0 text-light">SURVEY SUPERSTAR</p>
                                <p class="lead m-0 text-light">PROFILE PRODIGY</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-1 text-end d-none d-lg-block">

                        <img src="{{asset('img/trophy.png')}}" alt="icon" class="img-fluid mt-4" width="200px" style="scale:1.5">

                    </div>

                    <div class="col-12 p-4 d-lg-none mt-3" style="background-image: url('img/bg-counter.png'); background-size: cover;">
                        
                    </div>


                </div>

            </div>

        </div>
        @endif
		
<!-- 
	Countdown timer for survey reward END
-->		


  <div class="col bg-white rounded pb-4 mt-4 ms-2 me-2 ms-lg-0 me-lg-0">

      <div class="row">


    <div class="col-12 mb-2">
      <h4 class="redem_head mt-3 ms-2" style="font-size:24px">{{__('inpanel.activity_log.redem_meter')}}</h4>
    </div>

    <div class="points_scale text-center row">
      <div class="col add_weight"><span class="ps-3 pe-3 pe-md-0 add_weight">0</span> ($0)</div>
      <div class="col add_weight">1000 ($1)</div>
      <div class="col add_weight">2000 ($2)</div>
      <div class="col add_weight">3000 ($3)</div>
      <div class="col add_weight">4000 ($4)</div>
      <div class="col add_weight">5000 ($5)</div>  
    </div>

    <div class="redemption_point_sec" style="transform: translate(12px,14px);">
        <div class="row" style="width: 100%">
          <div class="col partit" style="border-right: 1px solid white"></div>
          <div class="col partit" style="border-right: 1px solid white;"></div>
          <div class="col partit" style="border-right: 1px solid white;"></div>
          <div class="col partit" style="border-right: 1px solid white;"></div>
          <div class="col partit"></div>
        </div>
    </div>  



    <div class="redemption_point_sec">
  <div class="redeem_filled_sec"><span class="red_fill">{{__('inpanel.dashboard.user.earn')}} - @if( isset($user_point)) {{$user_point}}@else{{'0'}}@endif points(@if( isset($user_point)) 
                                    @if(($user_point/1000) < 1)
                                        {{($user_point/1000)*100}} {{__('inpanel.dashboard.cents')}}
                                    @else
                                     ${{$user_point/1000}}
                                    @endif
                                @else{{'0'}}
                                @endif) </span></div>
  <div class="redeem_unfilled_sec"> <span class="red_unfill">{{__('inpanel.activity_log.remaining_hit')}} -
      @php
      $remainingPoints = 5000 - (isset($user_point) ? $user_point : 0);
      $remainingAmount = $remainingPoints / 1000;
      @endphp
      {{$remainingPoints}} points (
    @if($remainingAmount < 1)
      {{($remainingAmount)*100}} {{__('inpanel.dashboard.cents')}}
    @else
      ${{$remainingAmount}}
    @endif)
    </span></div>
</div>

{{-- @php
$user_point = 5000; 
@endphp --}} 
<!-- Display message when user has 5000 or more points -->
            @if(isset($remaining_points) && $remaining_points >= 5000)
                <style type="text/css">
                  .point_indicator{
                    margin-top: 0 !important;
                  }
                </style>
                <p class="point_redeem_head d-sm-none">{{__('inpanel.activity_log.min_for_redemption')}}</p>
                <div class="row mt-0 mt-md-4">
                  <div class="col text-center mb-4">
                  <span class="fw-bold d-none d-md-inline-block me-2">{{__('inpanel.activity_log.min_for_redemption')}}</span><a href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif" class="fw-bold res-size">{{__('inpanel.activity_log.click_here')}}</a> <span class="fw-bold res-size">{{__('inpanel.activity_log.to_redeem')}}</span><img src="{{asset('images/Redemption-meter.gif')}}" class="point_redeem_image">
                  </div>
                </div>
                
            @endif
<!-- end -->

@php 
    $redeem_points = session()->has('redeem_requests_points') ? session()->get('redeem_requests_points') : 0; 
@endphp
<div class="container point_indicator">
    <div class="row text-center">
        <div class="col-12 col-md-6  mb-2 mb-md-0">
            <div class="box blue-box rounded"></div> <span class="filled_portion">
            {{ __('inpanel.dashboard.user.earn') }} - 
            @php
                $user_point = isset($user_point) ? $user_point : 0;
                $redeem_points = isset($redeem_points) ? $redeem_points : 0;
                $remaining_points = $user_point - $redeem_points;
            @endphp

            {{ $remaining_points }} points (
            
            @if ($remaining_points *config('app.points.metric.conversion') < 1)
                {{ ($remaining_points *config('app.points.metric.conversion')) * 100 }} {{ __('inpanel.dashboard.cents') }}
            @else
                ${{ $remaining_points *config('app.points.metric.conversion') }}
            @endif
            )
        </span>

        </div>
        <div class="col-12 col-md-6">
            <div class="box white-box rounded"></div> <span class="unfilled_portion"> {{__('inpanel.activity_log.remaining_hit')}} -
            @php
            if ($remaining_points >= 5000) 
            {
                $remainingPoints = 0;
            } 
            else 
            {
                $remainingPoints = 5000 - (isset($remaining_points) ? $remaining_points : 0);
            }
            $remainingAmount = $remainingPoints *config('app.points.metric.conversion');
            @endphp
            {{$remainingPoints}} points (
            @if($remainingAmount < 1)
                {{($remainingAmount)*100}} {{__('inpanel.dashboard.cents')}}
            @else
                ${{$remainingAmount}}
            @endif) </span>
            
        </div>
    </div>
    <!-- Your point tick rows here -->
</div>





      </div>

  </div>

</div>







</body>


@push('after-scripts')

    <script>

function getCurrentTimeInTimezone(timeZone) {
  const now = new Date();

  const formatter = new Intl.DateTimeFormat('en-GB', {
    timeZone,
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  });

  const parts = formatter.formatToParts(now);
  const dateParts = {};

  parts.forEach(({ type, value }) => {
    if (type !== 'literal') {
      dateParts[type] = value;
    }
  });

  const dateString = `${dateParts.year}-${dateParts.month}-${dateParts.day}T${dateParts.hour}:${dateParts.minute}:${dateParts.second}`;
  return new Date(dateString); 
}

function getTimeRemaining(endtimeStr, timeZone) {
  const now = getCurrentTimeInTimezone(timeZone);
  const endtime = new Date(endtimeStr);

  const total = endtime - now;
  const seconds = Math.floor((total / 1000) % 60);
  const minutes = Math.floor((total / 1000 / 60) % 60);
  const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
  const days = Math.floor(total / (1000 * 60 * 60 * 24));

  return {
    total,
    days,
    hours,
    minutes,
    seconds
  };
}

function initializeClock(endtime) {
  let timeinterval;
  let intervalId;
  const timeZone= "{{ $timeZone }}";
  function updateClock() {
    const t = getTimeRemaining(endtime,timeZone);

    /* document.getElementById('countdown').innerHTML = `
      <div>${t.days} days</div>
      <div>${('0' + t.hours).slice(-2)} hours</div>
      <div>${('0' + t.minutes).slice(-2)} minutes</div>
      <div>${('0' + t.seconds).slice(-2)} seconds</div>
    `; */

	
	// Format the time components with leading zeros if needed
	days = ("0" + t.days).slice(-2);
	hours = ("0" + t.hours).slice(-2);
	minutes = ("0" + t.minutes).slice(-2);
	seconds = ("0" + t.seconds).slice(-2);

    
	if(days=='00' && hours=='00' && minutes<='15'){
       
        $('.btn-light').prop('disabled',false);
        $('.links').attr('title','').attr('target','_blank').attr('href',ZoomLink);

    }		
	// Update the text content of the divs for days, hours, minutes, and seconds
	// console.log(days + ' -594');
	document.getElementById("days").textContent = (t.days > 0) ? days : '00';
	document.getElementById("hours").textContent = (t.hours > 0) ? hours : '00';
	document.getElementById("minutes").textContent = (t.minutes > 0) ? minutes : '00';
	document.getElementById("seconds").textContent = (t.seconds > 0) ? seconds : '00';	

    if (t.total <= 0) {
      if(typeof(timeinterval) !== 'undefined'){
        clearInterval(timeinterval);
      }
    }
  }

  function checkAndHideSection() {
  const now = getCurrentTimeInTimezone(timeZone);
  const endTime = new Date(endtime);
  const graceEndTime = new Date(endTime.getTime() + 30 * 60000);
  
  if (now >= graceEndTime) {
    clearInterval(intervalId);
    const section = document.getElementById('reward_banner_inpanel');
    section.style.display = "none";

  }
}
  checkAndHideSection()

  intervalId = setInterval(checkAndHideSection, 1000);
  

  updateClock();
  timeinterval = setInterval(updateClock, 1000);
}
console.log(new Date())

// Set the deadline for April 15, 2024, 7:00 PM Eastern Time
const deadline = new Date("{{ $zoomDateTime }}"); // Eastern Daylight Time (EDT)
const ZoomLink="{{ $zoomLink }}";
initializeClock(deadline);


	
	
		 // Function to format time components with leading zeros
        function formatTime(time) {
            return time < 10 ? "0" + time : time;
        }
		
        // Function to update countdown for a specific time zone
        function updateCountdown(targetDate, outputElementId, timeZoneOffset) {
            // Convert target date to local time zone
            var localTargetDate = new Date(targetDate.getTime() + (timeZoneOffset * 60 * 1000));

            // Update the countdown every second
            var timer = setInterval(function() {
                // Get the current date and time
                var currentDate = new Date();

                // Calculate the time difference between the target date and the current date
                var timeDifference = localTargetDate - currentDate;

                // Calculate days, hours, minutes, and seconds remaining
                var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
				
				// Format the time components with leading zeros if needed
				days = ("0" + days).slice(-2);
				hours = ("0" + hours).slice(-2);
				minutes = ("0" + minutes).slice(-2);
				seconds = ("0" + seconds).slice(-2);

				// Update the text content of the divs for days, hours, minutes, and seconds
				document.getElementById("days").textContent = days;
				document.getElementById("hours").textContent = hours;
				document.getElementById("minutes").textContent = minutes;
				document.getElementById("seconds").textContent = seconds;				

                // Display the countdown timer
               // document.getElementById(outputElementId).innerHTML = "Time remaining: " + days + " days, " + formatTime(hours) + " hours, " + formatTime(minutes) + " minutes, " + formatTime(seconds) + " seconds";

                // If the countdown is over, stop the timer
                if (timeDifference <= 0) {
                    clearInterval(timer);
                    document.getElementById(outputElementId).innerHTML = "Countdown expired";
                }
            }, 1000);
        }
	

        // Set the target date and time for EST (US)
        // var targetDateUS = new Date("2024-03-15T15:00:00-04:00");
        var targetDateUS = new Date("{{ $zoomDateTime }}");
        // Set the time zone offset for EST (in minutes)
        var timeZoneOffsetUS = targetDateUS.getTimezoneOffset();

        // Set the target date and time for IST (India)
        var targetDateIndia = new Date("2024-03-12T14:00:00");

        // Update countdown for EST (US)
        // updateCountdown(targetDateUS, "bannerReward", timeZoneOffsetUS); 
		
		
    </script>
	


@endpush

