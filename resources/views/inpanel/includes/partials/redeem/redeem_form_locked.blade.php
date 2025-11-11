
<div class="row">

<p class="ms-3 mt-4" style="font-weight:600; font-size:14px">{{__('inpanel.redeem.index.custom_input')}} :</p>
@php
    $amount = 0;
@endphp

@if($user_available_points*$metricConversion < 1)
    @php
        $currency = ($user_available_points*$metricConversion > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
        $amount = number_format($user_available_points*$metricConversion,2);
    @endphp
@else
    @php
        $amount = number_format($user_available_points*$metricConversion,2);
    @endphp
@endif

{{html()->form('POST',route('inpanel.redeem.post.redeem.request'))->id("redeem_form")->open()}}

<div class="row border ms-3 me-3 pt-4 pb-4 rounded" style="background: #F4F4F4;">

    <div class="col border-end">

        <p class="mb-1" style="font-weight:600; font-size:12px">{{__('inpanel.redeem.index.points')}}</p>
        
        <!-- <input type="number" class="rounded" value="" id="enterPoints" style="width: 100%; border: 1px solid #dee2e6; outline: none;" onkeyup="calPoints()"> -->
        @if($redeem_requests)
        <input type="text" id="custom" max="{{$amount}}" value="{{--$userPoints['completed']--}}" style="width: 100%; border: 1px solid #dee2e6; outline: none;" name="redeem_points" class="rounded" readonly>
        @else
        <input type="text" id="custom" max="{{$amount}}" value="{{$amount}}" style="width: 100%; border: 1px solid #dee2e6; outline: none;" onkeyup="calPoints({{$countryPoints}})" class="rounded" readonly>
        @endif
        <input type="hidden" id="request_points" name="request_points" value="">
        <input type="hidden" id="action_id" name="action_id" value="0">

    </div>

    <div class="col">

        <p class="mb-1" style="font-weight:600; font-size:12px">{{__('inpanel.redeem.index.you_get')}}</p>

        <input type="text" class="rounded" value="" id="getPoints" style="background: white; width: 100%; border: 1px solid #dee2e6; outline: none;" disabled>

    </div>

</div>

<div class="row mb-4">

    <div class="col  ms-3 me-3 mt-3">

    <!-- <button class="btn" style="width:100%; background: #F4F4F4; border: none;" disabled>Redeem Now</button> -->
    @if($redeem_requests)
    
    <input type="button" data-redeem_max="{{$amount}}" class="btn btn-primary btn-block" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:100%; background: #F4F4F4; border: none; color:gray" disabled>
        
    @else
    <input type="button" id="review" data-redeem_max="{{$amount}}" class="btn btn-primary btn-block" value="{{__('inpanel.redeem.index.review')}}" name="Submit" style="width:100%; border: none;" disabled>
    @endif

    </div>

</div>

{{html()->form()->close()}}