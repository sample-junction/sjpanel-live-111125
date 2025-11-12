@extends('inpanel.layouts.app')

@push('after-styles')
    <style>
        /* for invite section */
        .custom-contact-box.center-version{
            border: 1px solid #e7eaec;
            padding: 0;
        }
        .custom-contact-box.center-version > a {
            display: block;
            background-color: #ffffff;
            padding: 20px 10px;
            text-align: center;
        }
        .custom-contact-box .contact-box-footer {
            text-align: center;
            background-color: #ffffff;
            border-top: 1px solid #e7eaec;
            padding: 15px 20px;
        }
        .gift_card_details{
            padding: 15px 20px;
        }
        .input-hidden {
            position: absolute;
            left: -9999px;
        }

        input[type=radio]:checked + label>img {
            border: 1px solid #fff;
            box-shadow: 0 0 3px 3px #090;
        }

        /* Stuff after this is only to make things more pretty */
        input[type=radio] + label>img {
            border: 1px dashed #444;
            width: 120px;
            height: 80px;
            transition: 500ms all;
        }

        #redeem-form-snap{
            width: 500px;
            height: 500px;
        }

        input[type=radio] + label:hover {
            cursor: pointer;
        }

        input[type=radio]:checked + label>img {
            transform:
                rotateZ(-10deg)
                rotateX(10deg);
        }
        .fixedContainer {
            height: 272px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .custom_input{
            display:none;
        }

        .review{
            display:none;
        }

        .overlay {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0, 0.9);
            overflow-x: hidden;
            transition: 0.5s;
        }
        .locked-form .overlay {
            opacity: 0.8;
        }
        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .3s ease;
            background-color: grey;
        }


        .icon {
            color: white;
            font-size: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }
        .ibox-content.locked-form{
            position: relative;
        }

        .redeem_unlock_detail{
            color: white;
            font-size: 15px;
            position: absolute;
            top: 70%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }
        .fa-lock:hover {
            color: #eee;
        }
        .overlay a {font-size: 20px;padding-bottom: 20px;}
        @media screen and (max-height: 450px) {
            .overlay a {font-size: 20px}
            .overlay .closebtn {
                font-size: 40px;
                top: 15px;
                right: 35px;
            }
        }

        .redeem_button{
            width:200px;
            position:relative;
            top:50%;
            left:100%;
        }

    </style>
@endpush

@section('content')

    <div class="wrapper wrapper-content animated fadeInRight"> 

        @if($user->is_blacklist==0)

        @if(!empty($userPoints) && ($userPoints['completed']!=$threshold_point && $userPoints['completed']<$threshold_point))

            <div class="row redeem_info">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content text-center">

                            @if(!empty($userPoints) && ($userPoints['completed']!=$threshold_point || $userPoints['completed']<$threshold_point))
                                @php
                                    $userCompletedPoints = $userPoints['completed'];
                                    $remainPoint = $threshold_point - $userCompletedPoints;
                                    $pointPercent = ($userCompletedPoints/$threshold_point) * 100;
                                    $edit_flag = false;
                                @endphp
                                <h5 class="text-left">{{__('inpanel.redeem.index.details', ['points_remain' => $remainPoint])}}</h5>
                                <div class="progress progress-striped active">
                                    <div style="width: {{$pointPercent}}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-primary progress_bar">

                                    </div>
                                </div>
                            @else
                                <div class="progress progress-striped active">
                                    {{$threshold_point.__('inpanel.redeem.index.details')}}
                                </div>
                            @endif
                            <div class="row">
                                <p>
                                    {{__('inpanel.redeem.index.threshold_message', ['threshold_limit' => $threshold_point])}}
                                </p>
                                {{--<img src="{{asset('storage/redeem-options/img/redeem-form-snap/redeem_form.png')}}" id="redeem-form-snap"/>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
            <!-- <div class="ibox-content m-b-sm border-bottom">
                <div class="p-xs">
                    <div class="pull-left m-r-md">
                        <i class="fa fa-globe text-navy mid-icon"></i>
                    </div>
                    <h2>{{__('inpanel.redeem.index.title')}}</h2>
                </div>
            </div> -->
           
            <div class="row redeem-form">
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{__('inpanel.redeem.index.title')}}</h5>
                        </div>
                        <div class="ibox-content" style="display: block;">
                                @if( $userPoints['completed'] == $threshold_point || $userPoints['completed']>$threshold_point )
                                   
                                        @include('inpanel.includes.partials.redeem.redeem_form_unlocked')   
                                   
                                @else                                
                                 
                                  @include('inpanel.includes.partials.redeem.redeem_form_locked')
                                @endif

                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                   <div class="ibox float-e-margins">
                       <div class="ibox-content">
                            <p>{{__('inpanel.redeem.index.redeem_title')}}</p>
                            <p>{!!__('inpanel.redeem.index.read_more')!!}</p>                                            
                            <p>{{__('inpanel.redeem.index.paypal')}}</p>
                        </div>
                    </div>
                    
                </div>
        
                <!-- <div class="col-sm-4 review" style="display:none;">
                    {{html()->form('POST',route('inpanel.redeem.post.redeem.request'))->id("redeem_form")->open()}}
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{__('inpanel.redeem.index.review_title')}}</h5>
                        </div>
                    </div>
                    <div class="ibox-content redeem" style="display: block;">
                        <input type="hidden" id="request_points" name="request_points" value="">
                        <input type="hidden" id="redeem_methods" name="redeem_method" value="">
                    </div>
                    {{html()->form()->close()}}
                </div> -->

            </div>
            @else
            <div class="row redeem-form">
                <div class="col-md-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>{{__('inpanel.redeem.index.title')}}</h5>
                        </div>
                        <div class="ibox-content">
                            <p style="text-align:center;font-weight:800">You are not allowed to generate redeem request since your account has been blacklisted.</p>
                        </div>
                    </div>
                </div>
            </div>
                
            @endif
        @if($redeem_requests)
        <div class="row redeem-form">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <!-----Modified code (05-01-2023) by vikash------>
                    <div class="ibox-content" id="ibox-content">
                        <div class="project-list referral_details">
                            <div class="table-responsive">
                                <table class="table" id="redeem-request">
                                    <thead>
                                        <tr>
                                            <!-- <th>ID</th>
                                            <th>Requested Points</th>
                                            <th>Value($)</th>
                                            <th>Redemption Requested</th>
                                            <th>Redemption Approved</th>
                                            <th>Payment Requested to Rybbon</th>
                                            <th>Coupon Sent by Rybbon</th>
                                            <th>Coupon Redeemed</th>
                                            <th>Status</th> -->
                                            <th>{{__('inpanel.redeem.index.id')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_1')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_2')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_3')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_4')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_5')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_6')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_9')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_7')}}</th>
                                            <th>{{__('inpanel.redeem.index.title_history_8')}}</th>
                                            @if($redeem_requests->show_status === 'Redemption Requested')
											<th>{{__('inpanel.redeem.index.title_history_10')}}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tr_{{$redeem_requests->id}}" data-request_id="{{$redeem_requests->id}}">
                                            <td class="datatable_checkbox select-checkbox" data-request_id="{{$redeem_requests->id}}" >{{$redeem_requests->id}}</td>
                                            <td><span id="r_points">{{$redeem_requests->redeem_points}}</span>
                                            <input type="text" id="r_points_edit" max="{{$userPoints['completed']}}" value="{{$userPoints['completed']}}" style="width: 121px;display:inline!important;display:none;" name="r_points_edit" class="form-control" >
                
                                            </td>
                                            @php
                                    $user=\Auth::user();
                                    
                                       $reminder_count = '';
                                      $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->created_at)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                      if($redeem_requests->approve!=''){
                                        $approve = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->approve)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                      }
                                      if($redeem_requests->ribbon_notified!=''){
                                        $ribbon_notified = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->ribbon_notified)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                      }
                                      if($redeem_requests->coupon_sent!=''){
                                        $coupon_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->coupon_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                      }
                                      if($redeem_requests->coupon_redeemed!=''){
                                        $coupon_redeemed = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $redeem_requests->coupon_redeemed)->setTimezone($user->timezone)->format('Y-m-d H:i:s'); 
                                      }
                                      if($redeem_requests->reminder_sent!=''){
                                        $reminder_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem_requests->reminder_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                                      }
                                      if($redeem_requests->reminder_count == 1){
                                        $reminder_count = 'First';
                                      }else if($redeem_requests->reminder_count == 2){
                                        $reminder_count = 'Second';
                                      }else if($redeem_requests->reminder_count == 3){
                                        $reminder_count = 'Third';
                                      }
                                    @endphp
                                            <td>
                                                @if($redeemValue < 1)
												@php
													$currency = ($redeemValue*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
												@endphp
                                                {{$redeemValue*100}} {{__($currency)}}
                                                @else
                                                {{$redeemValue}} 
                                                @endif
                                            </td>
                                            <td> @if($redeem_requests->created_at) {{--$redeem_requests->created_at--}}{{$updatedDate}} {{-- $redeem_requests->created_at--}} @else -- @endif </td>
                                            <td> @if($redeem_requests->approve) {{$approve}}{{--$redeem_requests->approve--}} @else -- @endif </td>
                                            <td> @if($redeem_requests->ribbon_notified) {{$ribbon_notified}}{{--$redeem_requests->ribbon_notified--}} @else -- @endif </td>
                                            
                                            <td> @if($redeem_requests->coupon_sent) {{$coupon_sent}}{{--$redeem_requests->coupon_sent--}} @else -- @endif </td>
																																										   
                                            <td> @if($redeem_requests->reminder_sent){{$reminder_sent}}  @else -- @endif </td>
                                            <td> @if($redeem_requests->coupon_redeemed) {{--$redeem_requests->coupon_redeemed--}}{{$coupon_redeemed}} @else -- @endif </td>
                                            <td class="capitalize"> {{strip_tags($redeem_requests->show_status)}}@if($redeem_requests->reminder_count!='' && $redeem_requests->status=='pending') {{$reminder_count}} {{__('inpanel.redeem.index.reminder_sent')}}@endif</td>
											@if($redeem_requests->show_status === 'Redemption Requested')
                
                                            <td>
												<input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-warning btn-block" value="{{__('inpanel.redeem.index.modify')}}" id="modifyId" name="modifyId" style="width:106px;">
												<input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-danger btn-block" value="{{__('inpanel.redeem.index.cancel')}}" id="cancel" name="cancel" style="width:106px;">
												<input type="button" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-block" id="review" value="{{__('inpanel.redeem.index.review')}}" name="save" style="width:106px;margin-left:70px;display:none">
				
											</td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>            
                        </div>
                        <p style="text-align:center;font-weight:800;">You may check history of redeemed points in <a href="{{ route('inpanel.redeem.redeem.history') }}">Redemption Status</a> Section.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@push('after-scripts')
    <script>

        var mod = document.getElementById('modifyId');
		var cnclBtn = document.getElementById('cancel');
        var sbtBtn = document.getElementById('review');
		var action = document.getElementById('action_id');
        var r_points = document.getElementById('r_points');
        var r_points_edit = document.getElementById('r_points_edit');
        if(mod){
            mod.addEventListener('click', () => {

            var cstBox = document.getElementById('custom');

            mod.style.display = 'none';
            cnclBtn.style.display = 'none';
            action.value = "1";
            sbtBtn.style.display = 'block';
            r_points.style.display = 'none';
            r_points_edit.style.display = 'block';
            //cstBox.removeAttribute('readonly');
            });
            cnclBtn.addEventListener('click',()=>{
                action.value = "2";
                var request_points = document.getElementById('custom');
                request_points.value = '{{ $threshold_point > $multiplypoint ? $threshold_point : $multiplypoint }}';
                sbtBtn.click();
            });
        }
        
		
    </script>
    {{--<script>
        @if($tour_taken == 0 && ($userPoints['completed']!==$threshold_point && $userPoints['completed']<$threshold_point))
            @include('inpanel.includes.partials.php-js.redeem_points')
        @endif
        </script>--}}
    <script>
        $(document).ready(function(){
            $(":reset");
        });
        jQuery('.redemptionRequest_btn').on('click', function(e){
            if(jQuery(this).attr('disabled')){
                return false;
            }
            swal('Your redemption request submitted');
        });

        $('input:radio').on('change',function (e) {
            var val = $(this).val();
            console.log(val);
            if(val==='custom'){
                console.log('hiii');
                $('.custom_input').show();
                $('.custom_input').removeAttr("disabled");
            } else{
                console.log('hello');
                $('.custom_input').hide().attr("disabled","disabled");
            }
        });
        $('#review').click(function(){
            if($('#r_points_edit').length){
                if($('#r_points_edit').is(':visible')){
                    var request_points = parseInt($('#r_points_edit').val(), 10);
                }else{
                    var request_points = parseInt($('#custom').val(), 10);
                }
            }else{
                var request_points = parseInt($('#custom').val(), 10);
            }
            var minRedeemedPoint = '{{ $threshold_point }}';
            var multiplepoint ='{{ $multiplypoint }}';
            //alert(request_points);
           // alert(minRedeemedPoint);
            if(request_points >= minRedeemedPoint){
            
                if(request_points%multiplepoint==0){

                    // if($('input[name="points"]:checked').val()==='custom'){
                    //     var request_points = $('#custom').val();
                    // } else{
                    //     var request_points = $('input[name="points"]:checked').val();
                    // }
                    
                //var request_gift_card = $('input[name="giftcard"]:checked').val();

                //     $('.review').show();
                //     var redeem = $('.redeem');
                //     var row = $('<div class="row">')
                //     redeem.append('<div class="row"><div class="form-group"><div class="col-sm-10"><label class="control-label">{{__('inpanel.redeem.index.request_points')}}:</label></div><div class="pull-right">'+request_points+'</div></div></div>');
                //     // redeem.append('<div class="row"><div class="form-group"><div class="col-sm-8"><label class="control-label">{{__('inpanel.redeem.index.request_gift_card')}}:</label></div><div class="pull-right">'+request_gift_card+'</div></div></div><hr>');
                //     redeem.append('<hr><div class="row"><div class="form-group"><div class="col-lg-offset-2 col-lg-10"><input type="submit" id="submit" data-redeem_max="{{$userPoints['completed']}}" class="btn btn-primary btn-lg" value="{{__('inpanel.redeem.index.submit')}}" name="Submit"></div></div>');
                //     /* row.append(submit);*/
                //     $('input[name="request_points"]').val(request_points);
                // //$('input[name="redeem_method"]').val(request_gift_card);
                //     $('#review').attr('disabled','disabled');
                $('input[name="request_points"]').val(request_points);
                $('#redeem_form').submit();

                }else{
                    swal('The requested points need to be in multiple of '+multiplepoint);
                }

            }else{
                $('#custom').val(request_points);
                swal('The requested points cannot be less than '+ minRedeemedPoint);
            }
        })

    </script>
@endpush

