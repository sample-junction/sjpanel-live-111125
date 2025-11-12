@php
		/* Himanshu Code [24-04-2025] */
/*

		$countryConfigs = [
              'IN' => [
                  'timeZone' => 'Asia/Kolkata',
                  'zoomDateTime' => '2025-05-16 20:00:00',
                  'zoomLink' => 'https://us04web.zoom.us/j/3392102555?pwd=WHlhVlMzaFdSVG9KTmtmUUJWVEUwdz09',
                  'timeZoneCode'=>'IST'
              ],
              'US' => [
                  'timeZone' => 'America/New_York',
                  'zoomDateTime' => '2025-05-15 02:30:00',
                  'zoomLink' => 'https://us04web.zoom.us/j/3392102555?pwd=WHlhVlMzaFdSVG9KTmtmUUJWVEUwdz09',
                  'timeZoneCode'=>'EST'
              ],
              'UK' => [
                  'timeZone' => 'Europe/London',
                  'zoomDateTime' => '2025-05-14 21:30:00',
                  'zoomLink' => 'https://us04web.zoom.us/j/3392102555?pwd=WHlhVlMzaFdSVG9KTmtmUUJWVEUwdz09',
                  'timeZoneCode'=>'GMT'
              ],
              'CA' => [
                  'timeZone' => 'America/Toronto',
                  'zoomDateTime' => '2025-05-16 02:30:00',
                  'zoomLink' => 'https://us04web.zoom.us/j/3392102555?pwd=WHlhVlMzaFdSVG9KTmtmUUJWVEUwdz09',
                  'timeZoneCode'=>'EST'
              ],
          ];
		  
          $user_country=auth()->user()->country_code;
          $hasRewardData=in_array($user_country,['IN','US','UK','CA']) && isset($countryConfigs[$user_country]);
 
          $data = ($hasRewardData)? $countryConfigs[$user_country]:$countryConfigs['IN'];
          $timeZoneCode = $data['timeZoneCode'];
 
          $timeZone = $data['timeZone'];
          $zoomDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data['zoomDateTime'], 'Asia/Kolkata');
          $zoomDateTime = $zoomDateTime->setTimezone($timeZone);
 
          $zoomLink = $data['zoomLink'];
 
          $bannerDate = $zoomDateTime->format('d F, Y');
          $bannerTime = $zoomDateTime->format('h:i A');
 
 
          $rewardMonth = \Carbon\Carbon::now()->subMonth()->format('F, Y');
          $rewardMonth= strtoupper($rewardMonth);
 
 
          $currentDateTime = \Carbon\Carbon::now()->setTimezone($timeZone);
          $dateTime = $zoomDateTime->copy()->addMinutes(30);
          $hasValidTimeForBanner = ($currentDateTime < $dateTime);
          */
        $timeZone = 'Asia/Kolkata';
        $zoomDateTime = '';
        $zoomLink = '';
        $timeZoneCode = 'IST';
        $hasValidTimeForBanner=false;
        $hasRewardData=false;
        $user_country=auth()->user()->country_code;

        $userRewardData = getLoggedInUserRewardData();

        if(!empty($userRewardData)){

          
          $timeZone = $userRewardData['timeZone'];
          $timeZoneCode = $userRewardData['timeZoneCode'];
          // $hasRewardData = (auth()->user()->country_code == 'IN');
          $hasRewardData = (!empty($userRewardData) && isset($userRewardData['status']) && $userRewardData['status']==1);
          
          // zoom start time
          $zoomDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $userRewardData['date_time'], 'Asia/Kolkata');
          $zoomDateTime = $zoomDateTime->setTimezone($timeZone);
          
          // zoom link
          // $zoomLink = 'https://us04web.zoom.us/j/77489295734?pwd=nBLtm3KF1hQvoMXvTnMgayBd1SWgFO.1';
          $zoomLink = (!empty($userRewardData))? $userRewardData['zoom_link']:'';
          
          $bannerDate = $zoomDateTime->format('d F, Y');
          $bannerTime = $zoomDateTime->format('h:i A'); 
          
          
          $rewardMonth = \Carbon\Carbon::now()->subMonth()->format('F, Y');
          $rewardMonth= strtoupper($rewardMonth);
          
   
          $currentDateTime = \Carbon\Carbon::now()->setTimezone($timeZone);
          $dateTime = $zoomDateTime->copy()->addMinutes(30);
          $hasValidTimeForBanner = ($currentDateTime < $dateTime);        
        }

		/* Himanshu Code [24-04-2025] */
@endphp

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
                                <p class="fw-bold text-light">{{ $rewardMonth }} AWARD ANNOUNCEMENT</p>
                            </div>

                            <div class="col-12 col-lg-4 text-center">
                               
                                <p class="text-light ps-4 pe-4 ps-lg-0 pe-lg-0">Click the button below to join the live award session on {{ $bannerDate }} at {{ $bannerTime }} {{ $timeZoneCode }}</p>
                                <a href="javascript:void(0);"  class="links" title="This link will start working 10 minutes priori to schedule time"><button class="btn btn-light" disabled>Click Here</button></a>
                            </div>
                            
                            <div class="col-12 col-lg-4 text-center mt-5">

                                <p class="text-light fw-bold lead m-0 count_down_section"> 
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
				$('.btn-light').prop('disabled',false);
				$('.links').attr('title','').attr('target','_blank').attr('href',ZoomLink);
                $('.count_down_section').html('Award session is ongoing');

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
        var targetDateUS = new Date("{{ $zoomDateTime }}");
        // Set the time zone offset for EST (in minutes)
        var timeZoneOffsetUS = targetDateUS.getTimezoneOffset();

        // Set the target date and time for IST (India)
        var targetDateIndia = new Date("2024-03-12T14:00:00");

        // Update countdown for EST (US)
        //updateCountdown(targetDateUS, "bannerReward", timeZoneOffsetUS); 
		
		
    </script>
	


@endpush