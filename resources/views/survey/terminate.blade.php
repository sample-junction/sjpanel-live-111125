<style>
.btn-success {
    background-color: #1c84c6;
    border-color: #1c84c6;
    color: #FFFFFF;
    margin-left:200px;
    padding: 10px 20px;
    font-weight: 600;

}
.btn:not(:disabled):not(.disabled) {
    cursor: pointer;
}
.btn-primary:hover {
    color: #fff;
    background-color: #1b8eb7;
    border-color: #1985ac;
}
.btn-primary {
    color: #fff;
    background-color: #20a8d8;
    border-color: #20a8d8;
}
.btn:hover, .btn:focus {
    text-decoration: none;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
}
li{
    padding: 5px !important;
}
</style>
<div class="titlebox">
     Terminated
</div>
<div class="contentarea">
   <h3 style="font-size: 16px;text-align:center;">
   <strong>
    Unfortunately, you did not qualify the requirement of the survey! 
   </strong>
   </h3>
   <p style="padding-bottom:0px;">
      Some of the reasons for your rejection are listed below: 
   </p>
   <ul>
    <li><strong>Your profile did not match the requirement of the survey .</strong></li>
     <li><strong>The project may not be live now.</strong></li>
 </ul>
   
    <p style="padding-bottom:15px;">
        In order to receive more matching surveys, please ensure your profile is updated in member section. 
    </p>
    <!--<p style="text-align: center;"><a href="{{url('dashboard')}}" title="Take Another Survey"><button class="btn btn-primary">Take another survey</button></a></p>-->
    <p style="text-align: center;"><a href="{{ $next_survey_url }}" title="Take Another Survey"><button class="btn btn-primary">Take another survey</button></a></p>
    <p style="padding-bottom:15px; text-align:center">
	To report a problem or share feedback, please write to us at <a href="mailto:support@sjpanel.com">support@sjpanel.com</a> 

	</p>
    <div id="countdown" style="text-align:center;"></div>
</div>
