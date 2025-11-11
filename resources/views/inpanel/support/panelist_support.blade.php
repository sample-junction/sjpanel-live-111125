@extends('inpanel.layouts.device')

@push('after-styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<style type="text/css">
	.active_color {
		color: #1080D0 !important;
		border-bottom: 3px solid;
		/* padding: 0px 0px 18px 0px; */
		padding-bottom: 18px !important;
		font-weight: 600 !important;
	}

	/* Remove sorting styles for the first column */
	#Support_history_table thead th:first-child {
		cursor: default !important;
		background: none !important;
		background-image: none !important;
	}

	#Support_history_table tbody tr td:nth-child(6) {
		cursor: default !important;
	}

	#Support_history_table th,
	#Support_history_table td {
		font-family: Roboto;
		font-size: 16px;
		font-weight: 400;
		line-height: 24px;
		letter-spacing: -0.02em;
		text-align: center;
	}

	#Support_history_table {
		border: 1px solid #FAFAFA;
		background: #F3F3F3;
		margin-top: 60px;
		/* 60% of the viewport height */
		width: 100%;
	}

	.my_details a {
		cursor: pointer;
	}

	.hid {
		display: none;
	}

	#subject_issue {
		display: none;
		width: 25%;
		font-size: 13px;
		background-color: white;
		padding: 13px 0px 1px 14px;
		transform: translate(55px, -112px);
		position: absolute;
		border-radius: 15px;
	}

	#subject_issue.es_US {
		width: 30%;
		font-size: 12px;
		background-color: white;
		padding: 13px 0px 1px 14px;
		transform: translate(47px, -109px);
		position: absolute;
		border-radius: 15px;
	}

	#subject_issue1 {
		display: none;
		width: 25%;
		background-color: white;
		font-size: 13px;
		padding: 13px 0px 1px 14px;
		transform: translate(82px, -229px);
		position: absolute;
		border-radius: 15px;
	}

	#subject_issue1.es_US {
		width: 30%;
		font-size: 12px;
	}

	#browse_button {
		float: right;
		/* transform: translate(2px, -39px); */
		border-top-left-radius: 0;
		border-bottom-left-radius: 0;
		/* margin-top: 60px;  */
		margin-left: 15px;
		font-size: 13px;
		padding: 9px 45px;
	}

	#table_sec {
		margin-top: 45px;
	}

	#Support_history_table_wrapper {
		margin-top: 20px;
	}

	#Support_history_table_length {
		margin-bottom: 27px;
		padding: 8px;
	}

	select#support_type {
		appearance: none;
		-webkit-appearance: none;
		-moz-appearance: none;
		background: url('images/arrow-bottom.png') no-repeat right 0.75rem center;
		background-size: 16px;
		padding-right: 2rem;
	}

	@media(min-width: 220px) and (max-width:767px) {

		#browse_button {
			padding: 9px 15px !important;
			border-top-left-radius: 6px;
			border-bottom-left-radius: 6px;
			margin-top: 10px;
		}

		#subject_issue {
			width: 56% !important;
			padding: 13px 0px 0px 14px !important;
			font-size: 13px !important
		}

		#subject_issue.es_US {
			width: 70% !important;
			padding: 13px 0px 0px 14px !important;
			transform: translate(47px, -94px) !important;
			font-size: 8px !important;
		}

		#subject_issue1 {
			width: 56% !important;
			padding: 13px 0px 1px 15px !important;
			font-size: 13px !important
		}

		#subject_issue1.es_US {
			width: 70% !important;
			padding: 13px 0px 0px 14px !important;
			transform: translate(47px, -210px) !important;
			font-size: 8px !important;
		}

		#Support_history_table th,
		#Support_history_table td {

			font-size: 14px !important;
			line-height: 16px;
			padding: 10px;

		}

		#sort_by {
			transform: translate(0px, -8px) !important;
		}

		table.dataTable thead th,
		table.dataTable tbody td {
			padding: 10px 6px;
		}

		table.dataTable thead .sorting_asc {
			padding-right: 14px;
		}

		table.dataTable thead .sorting {
			padding-right: 14px;
		}

		#Support_history_table td span {
			width: 40px;
			font-size: 10px;

		}

		#Support p,
		#Support label,
		#Support select,
		.support_tabs {
			font-size: 14px
		}

		#Support_history_table_length select {
			padding: 5px;
		}
	}

	@media(min-width: 768px) and (max-width:990px) {

		#subject_issue,
		#subject_issue1 {
			width: 56% !important;
		}

		#Support_history_table th,
		#Support_history_table td {
			font-size: 12px;
		}
	}

	@media(min-width: 250px) and (max-width:470px) {

		table.dataTable thead th,
		table.dataTable thead td {
			padding: 10px 7px;
			border-bottom: 1px solid #111;
		}

		table.dataTable thead th.es_US,
		table.dataTable thead td.es_US {
			padding: 10px 0px;
			border-bottom: 1px solid #111;
		}

		#Support_history_table {
			border: 1px solid #FAFAFA;
			background: #F3F3F3;
			margin-top: 10%;
			width: 114%;
		}

		#Support_history_table td span {
			width: 40px;
			font-size: 6px;
		}

		#Support_history_table th {

			font-size: 12px !important;

		}

		#Support_history_table th {
			font-family: Roboto;
			font-size: 16px;
			font-weight: 400;
			line-height: 12px;
			letter-spacing: -0.02em;
			text-align: center;
		}

		.text-primary {
			font-size: 12px;
		}
	}

	.dataTables_filter {

		margin-bottom: 20px;


	}

	@media (min-width: 260px) and (max-width: 284px) {
		table.dataTable thead .sorting {
			padding-right: 8px;
		}

		.my_details a {
			cursor: pointer;
			font-size: 10px;
		}

		table.dataTable thead th,
		table.dataTable thead td {
			padding: 10px 0px;
			border-bottom: 1px solid #111;
		}
	}
</style>
@endpush

@section('panelistSupport_select','cst-active')
@section('content')

<div class="row mt-4 mb-2">
	<div class="col">
		<p class="h4 ms-2" style="font-weight: 600;">{{__('inpanel.Panelist_Support.title')}}</p>
	</div>
</div>

<div class="p-3 rounded">
	<div class="row rounded shadow mt-1  p-3 bg-white" style="border-radius: 10px;" id="top_user_info">
		@php

		if (isset($_GET['ticket'])){
		$ticket = $_GET['ticket'];
		}

		@endphp
		<div class="col-12 mt-4 mb-2">
			<div class="row d-block my_details" style="margin-top: -20px;">
				<a class="text-secondary support_tabs @php if(isset($ticket)){ if($ticket == 'created'){echo '';}else{echo'active_color';} }else{echo'active_color';} @endphp" id="support_tab" style="text-decoration: none;" onclick="myFun1()">{{__('inpanel.Panelist_Support.support')}}</a>
				<a class="text-secondary support_tabs @php if(isset($ticket)){ if($ticket == 'created'){echo 'active_color';}else{echo'';} }else{echo'';} @endphp" style="text-decoration: none;" id="support_history_tab" onclick="myFun2()">{{__('inpanel.Panelist_Support.support_history')}}</a>

			</div>
			<hr>
		</div>

		<div class="@php if(isset($ticket)){ if($ticket == 'created'){echo 'hid';}else{echo'';} }else{echo'';} @endphp" id="Support">
			<p class="fw-bold">{{__('inpanel.Panelist_Support.suport_para')}}</p>
			{{html()->form('post',route('inpanel.user.post.support'))->acceptsFiles()->open()}}
			<div>
				<label>{{__('inpanel.Panelist_Support.subject')}}</label><i class="fa fa-info-circle mx-2 iconn" style="color: cornflowerblue;font-size: 14px;"></i><br>
				<input class="form-control" type="text" name="subject">

				<span id="subject_issue" class="tooltiptext" style="text-align: left; display: none;">
					<p style="padding-left: 3px;">{{__('inpanel.user.support.subjecttooltip')}}</p>
				</span>
			</div>
			<div class="mt-3 form-group">
				<label for="support_type">{{__('inpanel.Panelist_Support.support_type')}}</label><br>
				<!-- <input class="form-control" type="text" name="support_type"> -->
				<select class="form-control" name="support_type" id="support_type">
					<option value="My Account">{{__('inpanel.Panelist_Support.my_account')}}</option>
					<option value="Profiling Surveys">{{__('inpanel.Panelist_Support.profiling_surveys')}}</option>
					<option value="Live Surveys" selected>{{__('inpanel.Panelist_Support.live_surveys')}}</option>
					<option value="Referral Program">{{__('inpanel.Panelist_Support.referral_program')}}</option>
					<option value="Incentive Points">{{__('inpanel.Panelist_Support.incentive_points')}}</option>
					<option value="Incentive Points Redemption">{{__('inpanel.Panelist_Support.incentive_redemption')}}</option>
				</select>

			</div>
			<div class="mt-3">
				<label>{{__('inpanel.Panelist_Support.attachment')}}</label><br>
				<input type="file" id="file_input" name="attachment" accept="image/*" style="display:none;">
				<div class="row g-0">
					<div class="col-12 col-md-10 mb-2">
						<button type="button" id="btn-upload" class="form-control photo_upload" style="height:40px;"></button>
					</div>
					<div class="col-12 col-md-2 d-flex flex-column align-items-start">
						<button class="btn btn-primary rounded" style="width:92%" type="button" id="browse_button">{{__('inpanel.Panelist_Support.browse')}}</button>
						<span id="images_err" style="color:red;"></span>
					</div>
				</div>

				<!-- <div style="display:flex;max-height:40px;">
                            
							
						</div>
						<br> -->

			</div>


			<div class="mt-3">
				<!-- <i class="fa fa-regular fa-circle-exclamation iconn mx-2" style="color: blue;"></i> -->
				<label>{{__('inpanel.Panelist_Support.your_query')}}</label><i class="fa fa-info-circle icon mx-2" style="color: cornflowerblue;font-size: 14px;"></i><br>
				<textarea class="form-control" name="your_query" rows="6"></textarea>

				<span id="subject_issue1" class="tooltiptext" style="text-align: left; display: none;">
					<p style="padding-left: 3px;">{{__('inpanel.user.support.support_message_tooltip')}}</p>
				</span>
			</div>
			<button type="submit" class="btn btn-primary  mt-4 px-lg-5 w-sm-100">{{__('inpanel.Panelist_Support.submit')}}</button>
			{{html()->form()->close()}}
		</div>

		<section class="@php if(isset($ticket)){ if($ticket == 'created'){echo '';}else{echo'hid';} }else{echo'hid';} @endphp" id="Support_history" style="overflow-x: auto;">
			<div>
				<p class="fw-bold">{{__('inpanel.Panelist_Support.ticket_history')}}</p>
				<!-- <div id="table_sec">

				    <p class="left float-start">Showing 10 results</p>

				    <div class="float-end" id="sort_by">
				    <p class="right  border rounded px-2 pt-2 pb-2"><span class="me-5">Sort By</span> 
				    	<i class="fa fa-solid fa-arrow-right fa-rotate-90" style="font-size: 12px;"></i>
				    	</p>
				    </div>
				</div> -->
			</div>
			@php
			$status_arr = [
			"My Account"=>__('inpanel.Panelist_Support.my_account'),
			"Profiling Surveys"=>__('inpanel.Panelist_Support.profiling_surveys'),
			"Live Surveys" =>__('inpanel.Panelist_Support.live_surveys'),
			"Referral Program"=>__('inpanel.Panelist_Support.referral_program'),
			"Incentive Points"=>__('inpanel.Panelist_Support.incentive_points'),
			"Incentive Points Redemption"=>__('inpanel.Panelist_Support.incentive_redemption'),

			];

			@endphp

			<div class="table-responsive">
				<table class="table" id="Support_history_table" style="width: 100%;">
					<thead>
						<tr>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.ticket_id')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.subject')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.support_type')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.message')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.submitted')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.last_update')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.status')}}</th>
							<th class="text-primary ">{{__('inpanel.Panelist_Support.action')}}</th>

						</tr>

					</thead>
					<tbody>
						@forelse($supportHistory as $result)
						@php

						$createdDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->created_at)->setTimezone($userTimezone)->format('d M Y H:i:s');
						if($result->updated_at){
						$updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->updated_at)->setTimezone($userTimezone)->format('d M Y H:i:s');
						}else{
						$updatedDate = '';
						}


						@endphp
						<tr>
							<td>
								<a href="{{route('inpanel.user.support.chatshow',$result->id)}}"><u>{{$result->id}}</u></a>
							</td>

							<td class="project-status">
								<a href="{{route('inpanel.user.support.chatshow',$result->id)}}">{{ \Illuminate\Support\Str::limit($result->project_code, 10, '...') }}</a>
							</td>
							<td>
								{{--$result->project_code--}}
								@if(app()->getLocale() == 'es_US')
								{{$status_arr[$result->subject]}}
								@elseif(app()->getLocale() == 'en_US')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'en_UK')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'en_CA')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'fr_CA')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'en_IN')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'en_AU')
								{{$result->subject}}
								@elseif(app()->getLocale() == 'hi_IN')
								@switch($result->subject)
								@case('My Account')
								{{ __('inpanel.Panelist_Support.my_account') }}
								@break
								@case('Profiling Surveys')
								{{ __('inpanel.Panelist_Support.profiling_surveys') }}
								@break
								@case('Live Surveys')
								{{ __('inpanel.Panelist_Support.live_surveys') }}
								@break
								@case('Referral Program')
								{{ __('inpanel.Panelist_Support.referral_program') }}
								@break
								@case('Incentive Points')
								{{ __('inpanel.Panelist_Support.incentive_points') }}
								@break
								@case('Incentive Points Redemption')
								{{ __('inpanel.Panelist_Support.incentive_redemption') }}
								@break
								@default
								{{ $result->subject }}
								@endswitch
								@endif
							</td>
							<td>
								<!-- code added by Parshant SHrma [20-05-2024] -->
								@php
								$max_characters = 100; // Maximum characters to display before "Read More"
								@endphp

								@if(strlen($result->message) > $max_characters)
								{{-- If content length exceeds the maximum characters --}}
								@php
								$trimmed_content = substr($result->message, 0, 10);
								$first_50_characters_with_dots = $trimmed_content . '...';
								@endphp
								{{ $first_50_characters_with_dots }}
								@else
								{{-- If content length is within the limit, display the full content --}}
								{{ $result->message }}
								@endif
							</td>
							<td>
								{{$createdDate}}
							</td>
							<td>
								{{$updatedDate}}

							</td>
							<td>@if($result->status==0)<span class="btn btn-sm btn-success" style="cursor:default;">{{__('inpanel.user.support.button1')}}</span>@else<span style="cursor:default;" class="btn btn-sm btn-danger">{{__('inpanel.user.support.button2')}}</span>@endif</td>
							<td>@if($result->status==1 || $result->status==3)<span class="btn btn-sm btn-success" style="cursor:pointer;" onclick="changeStatus('{{$result->id}}',0)">{{__('inpanel.user.support.button3')}}</span>@else <span></span> @endif</td>
						</tr>
						@empty
						{{__('inpanel.user.support.no_history')}}
						@endforelse
					</tbody>

				</table>
			</div>
		</section>

	</div>

</div>

@endsection

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
	$(document).on('mouseenter', '.iconn', function() {
		$("#subject_issue").show();
	});

	$(document).on('mouseleave', '.iconn', function() {
		$("#subject_issue").hide();
	});


	$(document).on('mouseenter', '.icon', function() {
		$("#subject_issue1").show();
	});

	$(document).on('mouseleave', '.icon', function() {
		$("#subject_issue1").hide();
	});

	function changeStatus(supportId, statusData) {
		//alert(supportId);
		// const selectedTab = $('#support_history_tab');
		$.ajax({
			/* the route pointing to the post function */
			url: "{{route('inpanel.user.support.changeStatus')}}",
			type: 'POST',
			/* send the csrf-token and the input to the controller */
			data: {
				_token: "{{ csrf_token() }}",
				supportId: supportId,
				statusData: statusData
			},
			dataType: 'JSON',
			/* remind that 'data' is the response of the AjaxController */
			success: function(response) {
				console.log(response.status);
				try {
					if (response.status === 200) {
						// swal('Fraud action successfully');
						localStorage.setItem('selectedTab', 'support_history_tab');
						// swal({title: "Good job", text: "Fraud action successfully", type: "success"}).then(function(){ location.reload();});
						location.reload();
						// myFun2();
					}
				} catch (error) {
					swal({
						text: "Some error occure!",
						type: "error"
					});
				}
			}
		});
	}

	function myFun1() {
		document.getElementById("Support").style.display = "block";
		document.getElementById("Support_history").style.display = "none";
		document.getElementById("support_history_tab").classList.remove("active_color");
		document.getElementById("support_tab").classList.add("active_color");
		var currentRoute = "{{ Route::currentRouteName() }}";
		var targetRoute = "inpanel.user.support";

		if (currentRoute !== targetRoute) {
			window.location.href = "{{ route('inpanel.user.support') }}";
		}
	}

	function myFun2() {
		document.getElementById("Support").style.display = "none";
		document.getElementById("Support_history").style.display = "block";
		document.getElementById("support_history_tab").classList.add("active_color");
		document.getElementById("support_tab").classList.remove("active_color");
	}
</script>
<script>
	$(document).ready(function() {
		@if(isset($history))
		let redirect_arr = @json($history);
		if (redirect_arr.length > 0) {
			myFun2();
		}
		@endif
	});

	// $(document).ready(function () {
	//     $(".icon").mouseenter(function () {
	//         $("#subject_issue1").show();
	//     });

	//     $("#subject_issue1").mouseleave(function () {
	//         $("#subject_issue1").hide();
	//     });
	// });

	// $(document).ready(function () {      
	//     $(".icon").hover(function () {
	//         $("#subject_issue1").toggle();
	//     });
	// });

	$(document).ready(function() {
		$("#browse_button").click(function() {
			$("#file_input").click();
		});
	});

	//This is for datatable
	$(document).ready(function() {
		$('#btn-upload').click(function(e) {
			e.preventDefault();

		});

		$('#file_input').on('change', function() {
			var file = this.files[0];
			var fileType = file.type.split('/')[0];

			if (fileType !== 'image') {
				$('#file_input').val('');
				$('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.image_error')}}");
			} else {
				$('#images_err').html('');
				$('#btn-upload').text(file.name);
			}
			var maxSize = 10 * 1024 * 1024;
			if (file.size > maxSize) {
				$('#file_input').val('');
				$('#btn-upload').text('');
				$('#images_err').html("{{__('inpanel.user.profile.preferences.preferences_menu.file_size_error')}}");
			}

		});
		$('#browse_button').on('blur', function() {
			$('#images_err').html('');
		});
	});


	//Added this code for datatable spanish translation 
	var cl_locale = @php echo json_encode($country_lang);
	@endphp;
	console.log('cl_locale--' + cl_locale);

	if (cl_locale == "en_US") {
		var url_lang = '';
	} else if (cl_locale == "fr_CA") {
		var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json';;
	} else if (cl_locale == "es_US") {
		var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json';;
	} else {
		var url_lang = '//cdn.datatables.net/plug-ins/1.13.6/i18n/en-CA.json';
	}


	$(document).ready(function() {
		const selectedTab = localStorage.getItem('selectedTab');
		if (selectedTab == 'support_history_tab') {
			myFun2();
			localStorage.setItem('selectedTab', '');
		}
		$('#Support_history_table')
			.DataTable({
				"language": {
					"url": `${url_lang}`,
					lengthMenu: "{{ __('inpanel.dataTable.lengthMenu') }}",
					zeroRecords: "{{ __('inpanel.dataTable.zeroRecords') }}",
					info: "{{ __('inpanel.dataTable.info') }}",
					infoEmpty: "{{ __('inpanel.dataTable.infoEmpty') }}",
					infoFiltered: "{{ __('inpanel.dataTable.infoFiltered') }}",
					search: "{{ __('inpanel.dataTable.search') }}",
					paginate: {
						first: "{{ __('inpanel.dataTable.paginate.first') }}",
						last: "{{ __('inpanel.dataTable.paginate.last') }}",
						next: "{{ __('inpanel.dataTable.paginate.next') }}",
						previous: "{{ __('inpanel.dataTable.paginate.previous') }}"
					}

				},
				"columnDefs": [{
					"targets": "_all",
					"orderable": false
				}]
			});
			$('#Support_history_table').on('page.dt', function() {
				$('html, body').animate({
					scrollTop: $("#Support_history_table").offset().top - 300
				}, 400);
			});
		// $('#Support_history_table').DataTable().column(7).nodes().to$().css('cursor','default');
	});

	document.getElementById("file_input").addEventListener("change", function() {
		const imagePathInput = document.getElementById("imagePathInput");
		if (this.files.length > 0) {
			imagePathInput.value = this.files[0].name;
		} else {
			imagePathInput.value = "";
		}
	});

	// function loadSupportHistory() {
	//     $.get('/support-history', function (data) {
	//         $('#Support_history').html(data);
	//     });
	// }
	/* * Code added by Anil
	 * Date: 27=08-2025
	 */
		document.addEventListener("DOMContentLoaded", () => {
		const urlParams = new URLSearchParams(window.location.search);
		if (urlParams.get("tab") === "support_history") {
			myFun2();
		}
	});
</script>

@endpush