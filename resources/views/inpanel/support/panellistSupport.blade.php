@extends('inpanel.layouts.app')

@section('content')
@push('after-styles')
<style>
     .arrowpopup {
position: relative;
display: inline-block;
cursor: pointer;
}
.arrowpopup .tooltiptext {
display: none;
width: 450px;
background-color: #1080d0;
color: white;
/*text-align: center;*/
border-radius: 4px;
padding: 10px ;
position: absolute;
bottom: 80%;
left: 0%;
margin-left: -62px;
margin-top: 100px;
}
.arrowpopup .tooltiptext::after {
/*content: "33";*/
position: absolute;
top: 100%;
left: 50%;
margin-left: -5px;
border-width: 5px;
border-style: solid;
border-color: #1080d0 transparent transparent transparent;
}
.arrowpopup .show {
visibility: visible;
}
.arrowpopup1 {
position: relative;
display: inline-block;
cursor: pointer;
}
.arrowpopup1 .tooltiptext1 {
display: none;
width: 450px;
background-color: #1080d0;
color: white;
/*text-align: center;*/
border-radius: 4px;
padding: 10px ;
position: absolute;
bottom: 80%;
left: 0%;
margin-left: -62px;
margin-top: 100px;
}
.arrowpopup1 .tooltiptext1::after {
/*content: "33";*/
position: absolute;
top: 100%;
left: 50%;
margin-left: -5px;
border-width: 5px;
border-style: solid;
border-color: #1080d0 transparent transparent transparent;
}
.arrowpopup1 .show {
visibility: visible;
}
.field-icon {
  float: left;
  margin-left: 303px;
  margin-top: -23px;
  position: relative;
  z-index: 2;
}
    </style>
@endpush
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content animated fadeInUp">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{__('inpanel.user.support.heading')}}</h5>
                    
                </div>
                
                <div class="ibox-content">
                <span>{{__('inpanel.user.support.details')}}</span>
                <hr>
                    <!-- <form action="{{route('inpanel.user.post.support')}}" method="post"> -->
                    {{html()->form('post',route('inpanel.user.post.support'))->acceptsFiles()->open()}}
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.subject')}}&nbsp;<div class="arrowpopup"><i class="fa fa-info-circle" style="color:#1080d0;"></i><span id="tooltipdemo" class="tooltiptext" style="text-align:left"><p style="padding-left: 3px;">{{__('inpanel.user.support.subjecttooltip')}}</p>
                                              
                                        </span></div>&nbsp;:</label>
                                    <input type="text" class="form-control" name="title" placeholder="{{__('inpanel.user.support.subject')}}" required>
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.support_type')}}</label>
                                    <select class="form-control" name="support_type">
                                        <option value="My Account">{{__('inpanel.Panelist_Support.my_account')}}</option>
                                        <option value="Profiling Surveys">{{__('inpanel.Panelist_Support.profiling_surveys')}}</option>
                                        <option value="Live Surveys" selected>{{__('inpanel.Panelist_Support.live_surveys')}}</option>
                                        <option value="Referral Program">{{__('inpanel.Panelist_Support.referral_program')}}</option>
                                        <option value="Incentive Points">{{__('inpanel.Panelist_Support.incentive_points')}}</option>
                                        <option value="Incentive Points Redemption">{{__('inpanel.Panelist_Support.incentive_redemption')}}</option>
                                    </select>
                                    {{--<input type="text" class="form-control" name="support_type" placeholder="Support Type" required>--}}
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.attachment')}}</label>
                                    <input type="file" name="attachment" id="attachment" class="form-control" accept="image/png,image/jpeg,image/jpg" >
                                    
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">{{__('inpanel.user.support.support_message')}}&nbsp;<div class="arrowpopup1"><i class="fa fa-info-circle" style="color:#1080d0;"></i><span id="tooltipdemo1" class="tooltiptext1" style="text-align:left"><p style="padding-left: 3px;">{{__('inpanel.user.support.support_message_tooltip')}}.</p>
                                              
                                        </span></div>&nbsp;:</label>
                                    <textarea name="message" id="message" class="form-control" cols="10" rows="5" placeholder="{{__('inpanel.user.support.support_message')}}" required></textarea>
                                    
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <button type="submit" class="btn btn-info">{{__('inpanel.user.support.support_btn')}}</button>
                                </div> 
                            </div>
                        </div>
                    {{html()->form()->close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
<script>
    $(document).on('mouseover','.arrowpopup',function(){
         var tt = document.getElementById("tooltipdemo");
       // tt.classList.toggle("show");

    });
    $(".arrowpopup").hover(
  function () {
    
    $("#tooltipdemo").show();
  }, 
  function () {
    $("#tooltipdemo").hide();
    
  }
);
    $(".arrowpopup1").hover(
  function () {
    
    $("#tooltipdemo1").show();
  }, 
  function () {
    $("#tooltipdemo1").hide();
    
  }
);
</script>
@endpush
@endsection