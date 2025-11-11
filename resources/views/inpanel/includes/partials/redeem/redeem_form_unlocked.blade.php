<div class="row">
    <!-- <div class="col-md-6">
            <div class="form-group">
                @php
                if(isset($redeem_requests)){
                    $user_available_points = $userPoints['completed'] - $redeem_requests->redeem_points;
                }else{
                    $user_available_points = $userPoints['completed'];
                }                   
                @endphp

                <h4>{{__('inpanel.redeem.index.form_main_heading',['max_points' => $user_available_points])}} 
                    @if($user_available_points*config('app.points.metric.conversion') < 1)
                    ({{$user_available_points*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})
                    @else
                    (${{$user_available_points*config('app.points.metric.conversion')}})
                    @endif
                </h4>
                <h4>{{__('inpanel.redeem.index.form_heading',['min_points' => $threshold_point])}}
                    @if($threshold_point*config('app.points.metric.conversion') < 1)
                    ({{$threshold_point*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})
                    @else
                    (${{$threshold_point*config('app.points.metric.conversion')}})
                    @endif
                </h4>
                <h4><b>{{__('inpanel.redeem.index.requested_points')}} {{$multiplypoint}}
                @if($threshold_point*config('app.points.metric.conversion') < 1)
                    ({{$multiplypoint*100*config('app.points.metric.conversion')}} {{__('inpanel.dashboard.cents')}})
                    @else
                    (${{$multiplypoint*config('app.points.metric.conversion')}})
                @endif
                </b></h4>
                <h4><b>{{__('inpanel.redeem.index.requested_points_one_time')}}</b></h4>
            </div>
        </div> -->

    <p class="ms-3 mt-4" style="font-weight:600; font-size:14px">{{__('inpanel.redeem.index.custom_input')}} :</p>

    {{html()->form('POST',route('inpanel.redeem.post.redeem.request'))->id("redeem_form")->open()}}

    <div class="row border ms-3 me-3 pt-4 pb-4 rounded" style="background: #F4F4F4;">

        <div class="col border-end">

            <p class="mb-1" style="font-weight:600; font-size:12px">{{__('inpanel.redeem.index.points')}}</p>
            <!-- <input type="number" class="rounded" value="" id="enterPoints" style="width: 100%; border: 1px solid #dee2e6; outline: none;" onkeyup="calPoints()"> -->

            <!-- Parshant Sharma [17-09-2024] Starts
					
                    @if($redeem_requests)
                    <input type="text" id="custom" max="{{$userPoints['completed']}}" value="{{--$userPoints['completed']--}}" style="width: 100%; border: 1px solid #dee2e6; outline: none;" name="redeem_points" class="rounded" readonly>
                    @else
                    <input type="number" id="custom" max="{{$userPoints['completed']}}" value="" style="width: 100%; border: 1px solid #dee2e6; outline: none;" onkeyup="calPoints({{$countryPoints}})" class="rounded" required>
                    @endif
					
					Parshant SHarma [17-09-2024] Ends -->
            <input type="text" class="rounded" value="" id="custom_curr" name="custom_curr" onkeypress="return isNumber(event)" />
            <input type="hidden" id="request_points" name="request_points" value="">
            <input type="hidden" id="action_id" name="action_id" value="0">
            <input type="hidden" name="payment_default_status" class="payment_default_status" value="{{$payment_method_default}}">
            <input type="hidden" name="is_default" class="is_default" value="{{$is_default}}">

        </div>

        <div class="col">

            <p class="mb-1" style="font-weight:600; font-size:12px">{{__('inpanel.redeem.index.you_get')}}</p>

            <input type="text" class="rounded" value="" id="getPoints" style="background: white; width: 100%; border: 1px solid #dee2e6; outline: none;" readonly>


        </div>

    </div>

    <div class="row mb-4">

        <div class="col  ms-3 me-3 mt-3">

            <!-- <button class="btn" style="width:100%; background: #F4F4F4; border: none;" disabled>Redeem Now</button> -->

            @if($redeem_requests)
            <input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block review-btn" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:100%; border: none;" disabled>
            @else
            <input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block review-btn" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:100%; border: none;">
            @endif
        </div>
    </div>
    {{html()->form()->close()}}


    <!-- {{html()->form('POST',route('inpanel.redeem.post.redeem.request'))->id("redeem_form")->open()}}
            <div class="form-group" style="float:right;">
                <label class="control-label" style="margin-top:10px;">{{__('inpanel.redeem.index.custom_input')}} :</label>&nbsp;
				@if($redeem_requests)
                <input type="text" id="custom" max="{{$userPoints['completed']}}" value="{{--$userPoints['completed']--}}" style="width: 121px;display:inline!important;" name="redeem_points" class="form-control" readonly>
                @else
                <input type="text" id="custom" max="{{$userPoints['completed']}}" value="{{$userPoints['completed']}}" style="width: 121px;display:inline!important;" name="redeem_points" class="form-control">
                @endif
                <input type="hidden" id="request_points" name="request_points" value="">
				<input type="hidden" id="action_id" name="action_id" value="0">
            </div>
            <div class="form-group" style="float:right;">
            @if($redeem_requests)
				
				<input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:106px;margin-left:70px;" disabled>
				
            @else
            <input type="button" id="review" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:106px;margin-left:70px;">
            @endif
          </div>
        </div>
        {{html()->form()->close()}} -->

    <!-- <div class="row">
        <div class="form-group">
            @php
                $n = 1;
                $user_points = $userPoints['completed'];
                $points_completed = $user_points;
                $total = 1;
                $redeem_points = 0;
                while( $n < strlen($userPoints['completed']) ){
                  $points_completed = ($points_completed%10);
                  $total = $total*10+$points_completed;
                  $n++;
                }
            @endphp
            <div class="col-lg-6">
                <label class="control-label">{{__('inpanel.redeem.index.form_input')}}:</label>&nbsp;
            </div>
            @php $redeem_points = $user_points;@endphp
            @for($i=0;$i<4;$i++)
                @php
                    $redeem_points = $redeem_points-$total;
                @endphp
                @if($redeem_points >= $threshold_point)
                    <input type="radio" name="points" value="{{$redeem_points}}">{{$redeem_points}}&nbsp&nbsp;
                @endif
            @endfor
            <input type="radio"  name="points" value="custom">{{__('inpanel.redeem.index.custom_select')}}<br>&nbsp;
        </div>
    </div> -->


    <!-- <div class="row">
        <div class="form-group">
            <div class="col-lg-6">
                <label class="control-label">{{__('inpanel.redeem.index.custom_input')}} :</label>&nbsp;
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" id="custom" max="{{$userPoints['completed']}}" value="{{$userPoints['completed']}}" name="redeem_points"><br>
                <span>{{__('inpanel.redeem.index.form_span')}} {{$userPoints['completed']}}<br><p>(It should be in round figure and multiple of 1000s)</p></span>
            </div>
        </div>
    </div> -->


    <!-- <div class="row">
        <div class="form-group">
            <div class="col-sm-6">
                <label class="control-label">{{__('inpanel.redeem.index.option_giftcard_heading')}}</label>
            </div>
        </div>
        <section>
       
           <div class="card-content col-sm-12 ">
                <div class="card-body">
                    <div class="row fixedContainer">
                        @php  $count = 0; @endphp
                        @foreach($gift_cards as $card)
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 gift_card_details">
                                @php
                                    $source = 'storage/redeem-options/img/'.$card->country_code.'/'.$card->image_uri;
                                    if($card->type == 'charity'){
                                        $source = 'storage/redeem-options/img/'.$card->country_code.'/charity/'.$card->image_uri;
                                    }
                                @endphp
                                <input
                                    type="radio"
                                    name="giftcard"
                                    id="{{snake_case($card->code)}}" value="{{$card->code}}" class="input-hidden" />
                                <label for="{{snake_case($card->code)}}">
                                    <img
                                        src="{{asset($source)}}"
                                        alt="{{$card->display_name}}" />
                                </label>
                                @php $count++;@endphp
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> 
        </section>
    </div> -->
    <!-- <hr/>
    <div class="row m-t-lg">
        <div class="form-group">
            <div class="col-sm-4">
                <a type="button" id="reset"  class="btn btn-primary" href="{{route('inpanel.redeem.show')}}">{{__('inpanel.redeem.index.reset')}}
                </a>
            </div>
            <div class="col-sm-4">
                <input type="button" id="review" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block" value="{{__('inpanel.redeem.index.review')}}" name="Submit">
            </div>

        </div>
    </div> -->