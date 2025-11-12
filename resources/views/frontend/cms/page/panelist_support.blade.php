@extends('inpanel.layouts.device')

@push('after-styles')
<style type="text/css">
	.active_color{
		color: #1080D0 !important;
	    border-bottom: 3px solid;
	    /* padding: 0px 0px 18px 0px; */
	    padding-bottom: 18px !important;
	    font-weight: 600 !important;
	}
	#Support_history_table th{
		font-family: Roboto;
	    font-size: 16px;
	    font-weight: 400;
	    line-height: 24px;
	    letter-spacing: -0.02em;
	    text-align: left;
	}
	#Support_history_table {
		border: 1px solid #FAFAFA;
    	background: #F3F3F3;
    	margin-top: 10%;
    	width: 100%
	}
	.my_details a{
		cursor: pointer;
	}
	#Support_history{
		display: none;
	}
	#subject_issue{
		display: none;
		width: 32%;
	    background-color: white;
	    padding: 13px 0px 1px 21px;
	    transform: translate(61px, -68px);
	    position: absolute;
	    border-radius: 15px;
	}
	#subject_issue1{
		display: none;
		width: 32%;
	    background-color: white;
	    padding: 13px 0px 1px 21px;
	    transform: translate(85px, -183px);
	    position: absolute;
	    border-radius: 15px;
	}
	#browse_button{
		float: right;
	    transform: translate(2px, -39px);
	    border-top-left-radius: 0;
	    border-bottom-left-radius: 0;
	    font-size: 13px;
    	padding: 9px 45px;
	}

</style>
@endpush

@section('content')

<div class="row mt-4 mb-2">
    <div class="col">
        <p class="h4 ms-2" style="font-weight: 600;">Panelist Support</p>
    </div>
</div>

<div class="p-3 rounded">
    <div class="row rounded shadow mt-1  p-3 bg-white" style="border-radius: 10px;" id="top_user_info">
    	
		    <div class="col-12 mt-4 mb-2">
		        <div class="row d-block my_details" style="margin-top: -20px;">
		            <a class="text-secondary support_tabs active_color" id="support_tab" style="text-decoration: none;" onclick="myFun1()">Support</a>
		            <a class="text-secondary support_tabs" style="text-decoration: none;"  id="support_history_tab" onclick="myFun2()">Support History</a>
		            
		        </div>
		        <hr>
		    </div>

		    <div class="" id="Support">
		    	<p class="fw-bold">Have a question? Please provide all details below to troubleshoot, and we’ll be in touch shortly.</p>
		    	<div>
		    		<label>Subject</label><i class="fa fa-info-circle mx-2 iconn" style="color: cornflowerblue;"></i><br>
		    		<input class="form-control" type="text" name="subject">
		    		<div class="shadow" id="subject_issue">
		    			<p>Please write subject of issue in short sentence.Please </br> include survey number, if any</p>
		    		</div>
		    	</div>
		    	<div class="mt-3">
		    		<label>Support Type</label><br>
		    		<input class="form-control" type="text" name="support">
		    	</div>
		    	<div class="mt-3">
		    		<label>Attachment</label><br>
		    		<input class="form-control" type="text" name="attachment"><button class="btn btn-primary" id="browse_button">Browse</button><input type="file" id="file_input" style="display: none;"></input>
		    	</div>
		    	<div class="mt-3">
		    		<!-- <i class="fa fa-regular fa-circle-exclamation iconn mx-2" style="color: blue;"></i> -->
		    		<label>Your Query</label><i class="fa fa-info-circle icon mx-2" style="color: cornflowerblue;"></i><br>
		    		<textarea class="form-control"  name="query" rows="6"></textarea> 
		    		<div class="shadow" id="subject_issue1">
		    			<p>Please write subject of issue in short sentence.Please </br> include survey number, if any</p>
		    		</div>
		    	</div>
		    	<button type="submit" class="btn btn-primary  mt-4 px-lg-5 w-sm-100">Submit</button>
		    </div>

		    <section class="" id="Support_history">
		    <div  >
		    	<p class="fw-bold">Ticket History</p>
		    	<div>
				    <p class="left float-start">Showing 10 results</p>
				    <div class="float-end">
				    <p class="right  border rounded px-2 pt-2 pb-2"><span class="me-5">Sort By</span> 
				    	<i class="fa fa-solid fa-arrow-right fa-rotate-90"></i>
				    	</p>
				    </div>
				</div>
		    </div>

		        <table id="Support_history_table">
			        <thead>
			            <tr>
			                <th class="text-primary">Ticket ID</th>
			                <th class="text-primary">Subject</th>
			                <th class="text-primary">Support Type</th>
			                <th class="text-primary">Message</th>
			                <th class="text-primary">Submitted</th>
			                <th class="text-primary">Last Update</th>
			                <th class="text-primary">Status</th>
			                <th class="text-primary">Action</th>
			                
			            </tr>
			        </thead>
			    </table>
			 </section>

    </div>
</div>

@endsection

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

        function myFun1(){
        	document.getElementById("Support").style.display ="block";
        	document.getElementById("Support_history").style.display = "none";
        	document.getElementById("support_history_tab").classList.remove("active_color");
        	document.getElementById("support_tab").classList.add("active_color");
        }

        function myFun2(){
        	document.getElementById("Support").style.display = "none";
        	document.getElementById("Support_history").style.display ="block";
        	document.getElementById("support_history_tab").classList.add("active_color");
        	document.getElementById("support_tab").classList.remove("active_color");
        }

		// $(document).ready(function () {
  //           $(".iconn").hover(function () {
  //               $("#subject_issue").css("display", "block");
  //           }, function () {
  //               $("#subject_issue").css("display", "none");
  //           });
  //       });


        $(document).ready(function () {
		    $(".iconn").mouseenter(function () {
		        $("#subject_issue").show();
		    });

		    $("#subject_issue").mouseleave(function () {
		        $("#subject_issue").hide();
		    });
		});

		$(document).ready(function () {
		    $(".icon").mouseenter(function () {
		        $("#subject_issue1").show();
		    });

		    $("#subject_issue1").mouseleave(function () {
		        $("#subject_issue1").hide();
		    });
		});

        // $(document).ready(function () {      
        //     $(".icon").hover(function () {
        //         $("#subject_issue1").toggle();
        //     });
        // });

        $(document).ready(function () {
		    $("#browse_button").click(function () {
		        $("#file_input").click();
		    });
		});
    </script>

@endpush