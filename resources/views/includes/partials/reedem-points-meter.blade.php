@php
        $user_point = isset($user_point) ? $user_point : 0;
        $redeem_points = session()->has('redeem_requests_points') ? session()->get('redeem_requests_points') : 0; 
        $redeem_points = isset($redeem_points) ? $redeem_points : 0;
        $remaining_points = $user_point - $redeem_points;
		//dd($redeem_points);
		

		
		/* Parshant Sharma [21-08-2024] STARTS */
		
			//dd($countryPoints);
			//dd($currencies['lang']);
			//$metricConversion = round(1/$countryPoints, 4);
			$metricConversion = 1 / $countryPoints;
			//dd($metricConversion);
			
			$calPoints = ( $currencies['lang'] == 'IN') ? ( $countryPoints * 5 * 40 ): $countryPoints * 5;
			//dd($calPoints);

			if($remaining_points == 0){
				$remaining_points = 1;
			}
		
		/* Parshant Sharma [21-08-2024] ENDS */	
		
		
        // code add by Pushpendra
			//$roundedNumber = ceil($remaining_points / 5000) * 5000;
			$roundedNumber = ceil($remaining_points / $calPoints) * $calPoints;		
			//dd($roundedNumber);
        // code add by Pushpendra

       /* Calculate the percentage of width : priyanka(31-july-2024 ) */
        $roundedNumber = isset($roundedNumber) ? $roundedNumber : 1; // Avoid division by zero
        $percentage = ($roundedNumber != 0) ? min($remaining_points, $user_point) / $roundedNumber * 100 : 0;

        /* Calculate the percentage of width : priyanka(31-july-2024 ) */
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
   /* this code "@php echo $roundedNumber @endphp" add by pushpendra by replace code 5000*/
  .redeem_filled_sec {
    height: 100%;
    width: calc((@php echo isset($remaining_points ) ? min($remaining_points , $user_point) : 0 @endphp) / @php echo $roundedNumber @endphp * 100%);
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

  /* this code "@php echo $roundedNumber @endphp" add by pushpendra by replace code 5000*/

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
    /*width: calc(100% - calc((@php echo isset($remaining_points ) ? min($remaining_points , $user_point) : 0 @endphp) / @php echo $roundedNumber @endphp * 100%));*/
    width: calc(100% - <?php echo $percentage; ?>%);
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

        <div class="col-12 col-md-6 text-center text-md-start d-flex align-items-center gap-2">
    
            {{--<img @if(Auth::user()->image_url) src="{{session()->get('server2_url')}}/{{Auth::user()->image_url}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif  class="img-fluid me-3 mb-1" alt="img" style="height:45px;width:45px;object-fit:cover;scale:1.3; border-radius:32px!important;"> --}}

           <!-- <img @if(Auth::user()->image_url) src="{{asset("img/".Auth::user()->image_url)}}" @else  src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user"  class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />-->
                <img @if(Auth::user()->thumbnail_image_path) src="{{config('settings.centralize_server_image').(Auth::user()->thumbnail_image_path)}}" @else src="{{asset("vendor/img/rewards/profile_default.png")}}" @endif alt="user" class="img-fluid rounded me-1" style="border-radius: 32px !important;border: 1px solid #eae6e6;height:35px;width:35px;object-fit:cover;" />
                       

             <span class="lead d-none d-md-inline-block">{{__('inpanel.dashboard.user.name')}}</span>  <span class="lead fw-bold d-none d-md-inline-block" style="text-transform: capitalize;" id="user_first_name_tab">{{ Auth::user()->first_name }} !</span>
    
            <p class="lead d-sm-none mt-2 mb-1">{{__('inpanel.dashboard.user.name')}} <span class="fw-bold">{{ Auth::user()->first_name }}!</span> </p>

        </div>
    
         
        <div class="col-12 col-md-6 text-center text-md-end d-flex align-items-center justify-content-end flex-wrap"> 
    
            <span class="d-none d-md-inline-block"><small>{{__('inpanel.dashboard.user.panId')}} </small><span class="fw-bold">{{ Auth::user()->panellist_id }}</span> <span class="ms-2 me-2">|</span> <span class="fw-bold">{{ Auth::user()->country}}</span>  <span class="ms-2 me-2">|</span></span>
    
            <p class="d-sm-none m-1">{{__('inpanel.dashboard.user.panId')}}. <span class="fw-bold">{{ Auth::user()->panellist_id }} | {{ Auth::user()->country}}</span></p>
             
                                
            <span class="text-primary"> <a href="@if(Route::has('inpanel.profiler.show')){{ route('inpanel.profiler.show') }}@endif">{{__('inpanel.dashboard.user.pro_completed')}} @if(isset($profilePercent)){{$profilePercent}}@else{{0}}@endif%</a> </span>
            
        </div>
    
    </div>

</div>

@endif

  {{-- Himanshu Include this file 26-06-2025 --}}
  @include('includes.partials.award-countdown-banner')
<div class="col bg-white rounded pb-4 mt-4 ms-2 me-2 ms-lg-0 me-lg-0">


      <div class="row">


    <div class="col-12 mb-2">
      <h4 class="redem_head mt-3 ms-2" style="font-size:24px">{{__('inpanel.activity_log.redem_meter')}}</h4>
    </div>

    <div class="points_scale text-center row">
      <div class="col add_weight"><span class="ps-3 pe-3 pe-md-0 add_weight">0</span> ({{$currencies['currency_logo']}}0)</div>

      <!-- code add by pushpendra -->
      @php
      $increment = $roundedNumber / 5;
      @endphp
      @for ($i = 1; $i <= 5; $i++)
      <div class="col add_weight">{{$increment * $i}} ({{$currencies['currency_logo']}}{{ ($increment * $i) / $countryPoints}})</div>
      @endfor
      <!-- code add by pushpendra -->

      <!-- code comment by pushpendra -->
      <!-- <div class="col add_weight">2000 ($2)</div>
      <div class="col add_weight">3000 ($3)</div>
      <div class="col add_weight">4000 ($4)</div>
      <div class="col add_weight">5000 ($5)</div>  --> 
      <!-- code comment by pushpendra -->
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
                                     {{$currencies['currency_logo']}}{{$user_point/1000}}
                                    @endif
                                @else{{'0'}}
                                @endif) </span></div>
  <div class="redeem_unfilled_sec"> <span class="red_unfill">{{__('inpanel.activity_log.remaining_hit')}} -
      @php
      $remainingPoints = $calPoints - (isset($user_point) ? $user_point : 0);
      $remainingAmount = $remainingPoints / $countryPoints;
      @endphp
      {{$remainingPoints}} points (
    @if($remainingAmount < 1)
      {{($remainingAmount)*100}} {{__('inpanel.dashboard.cents')}}
    @else
      {{$currencies['currency_logo']}}{{$remainingAmount}}
    @endif)
    </span></div>
</div>

{{-- @php
$user_point = 5000; 
@endphp --}} 
<!-- Display message when user has 5000 or more points -->
            @if(isset($remaining_points) && $remaining_points >= $calPoints)
                @php
                    $user_point = isset($user_point) ? $user_point : 0;
                    $redeem_points = isset($redeem_points) ? $redeem_points : 0;
                    $remaining_points = $user_point - $redeem_points;
										session()->put('threshhold_reached',1);

                @endphp

                <style type="text/css">
                  .point_indicator{
                    margin-top: 0 !important;
                  }
                </style>
                <p class="point_redeem_head d-sm-none">{{__('inpanel.activity_log.min_for_redemption')}}</p>
                <div class="row mt-0 mt-md-4">
                  <div class="col text-center mb-4">
                  <span class="fw-bold d-none d-md-inline-block me-1">
                    <!-- this code "<span class="fw-bold res-size">{{__('inpanel.activity_log.you_can_redeem')}} {{ $remaining_points }} {{__('inpanel.activity_log.points')}} (
                
                  @if ($remaining_points *config('app.points.metric.conversion') < 1)
                      {{ ($remaining_points *config('app.points.metric.conversion')) * 100 }} {{ __('inpanel.dashboard.cents') }}
                  @else
                      ${{ $remaining_points *config('app.points.metric.conversion') }}
                  @endif
                  )  </span>"  add by pushpendra -->
				  
				  
                  @php
                      $new_remaining_points = floor($remaining_points / $countryPoints) * $countryPoints;
                  @endphp
                  {{__('inpanel.activity_log.min_for_redemption')}}</span><span class="fw-bold res-size">{{__('inpanel.activity_log.you_can_redeem')}} {{ $new_remaining_points }} {{__('inpanel.activity_log.points')}} (
                
                  @if ($new_remaining_points *$metricConversion < 1)
					  @php
							$currency = ($new_remaining_points*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
					  @endphp
                      {{ number_format(($new_remaining_points *$metricConversion) * 100,2) }} {{ __($currency) }}
                  @else
                      {{$currencies['currency_logo']}}{{ number_format($new_remaining_points *$metricConversion,2) }}
                  @endif
                  ){{__('inpanel.activity_log.fullStop')}}</span><a href="@if(Route::has('inpanel.redeem.show')){{ route('inpanel.redeem.show') }}@endif" class="fw-bold res-size" style="font-size: calc(1rem + 2px);">{{__('inpanel.activity_log.click_here')}}</a> <span class="fw-bold res-size">{{__('inpanel.activity_log.to_redeem')}}</span>
                  <!-- <img src="{{asset('images/Redemption-meter.gif')}}" class="point_redeem_image"> -->
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
                 //   echo 'user_point => '.$user_point;

            @endphp

            <!--{{ $remaining_points }} points (
            
            @if ($remaining_points *config('app.points.metric.conversion') < 1)
                {{ ($remaining_points *config('app.points.metric.conversion')) * 100 }} {{ __('inpanel.dashboard.cents') }}
            @else
                ${{ $remaining_points *config('app.points.metric.conversion') }}
            @endif
            )-->
			
			<!-- Parshant Sharma [21-08-2024] STARTS -->
    @php
        $centsValue = round(($remaining_points * $metricConversion) * 100);
        $currency = ($centsValue > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
        // Merge value + currency and remove unwanted multiple spaces
        $centsString = preg_replace('/\s+/', ' ', trim($centsValue . ' ' . __($currency)));
    @endphp

    {{ $remaining_points }} {{ __('inpanel.activity_log.points') }}(@if($remaining_points * $metricConversion < 1){{ $centsString }}@else{{ $currencies['currency_logo'] }}{{ number_format($remaining_points * $metricConversion, 2) }}@endif)



			
			<!-- Parshant Sharma [21-08-2024] ENDS -->
        </span>

        </div>
        <div class="col-12 col-md-6">
          <!-- this code "@if($remaining_points >= 5000) d-none @endif" add by pushpendra on both div and span tag -->
            <!--[21-08-2024] <div class="box white-box rounded @if($remaining_points >= 5000) d-none @endif"></div> <span class="unfilled_portion @if($remaining_points >= 5000) d-none @endif"> {{__('inpanel.activity_log.remaining_hit')}} -
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
            @endif) </span> -->
            
			<!-- Parshant Sharma [21-08-2024] STARTS -->
			
			<div class="box white-box rounded @if($remaining_points >= $calPoints) d-none @endif"></div> <span class="unfilled_portion @if($remaining_points >= $calPoints) d-none @endif"> {{__('inpanel.activity_log.remaining_hit')}} -
                @php
                  if ($remaining_points >= $calPoints) {
                      $remainingPoints = 0;
                  } else {
                      $remainingPoints = $calPoints - (isset($remaining_points) ? $remaining_points : 0);
                  }

                  $remainingAmount = $remainingPoints * $metricConversion;

                  // If less than 1 → show cents
                  if ($remainingAmount < 1) {
                      $currency = ($remainingAmount * 100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
                      $centsString = preg_replace('/\s+/', ' ', trim(number_format(($remainingAmount) * 100, 2) . ' ' . __($currency)));
                  }
              @endphp

              {{ $remainingPoints }} {{ __('inpanel.activity_log.points') }} (@if($remainingAmount < 1){{ $centsString }}@else{{$currencies['currency_logo'] }}{{ number_format($remainingAmount, 2) }}@endif)
          </span>
			
			<!-- Parshant Sharma [21-08-2024] ENDS -->
        </div>
    </div>
    <!-- Your point tick rows here -->
</div>





      </div>

  </div>

</div>







</body>




