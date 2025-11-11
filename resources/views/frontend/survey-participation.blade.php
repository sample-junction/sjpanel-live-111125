@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.survey'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

           <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Survey <small class="text-muted"> Participation</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <form action="{{route('admin.auth.reports.survey_participation')}}" method="get" id="filterdata">
            <div class="row">
           
                <div class="col-sm-2">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="fromdatefield" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <span>To Date</span>
                        <input type="date" name="toDate" id="todatefield" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                    <span>Select Country</span>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected disabled>Select Country</option>
                        <option value="IN" {{ (isset($country) && $country == 'IN') ? 'selected' : '' }}>India</option>
                        <option value="US" {{ (isset($country) && $country == 'US') ? 'selected' : '' }}>United States of America</option>
                        <option value="CA" {{ (isset($country) && $country == 'CA') ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ (isset($country) && $country == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                    </select>
                </div>
                <div class="col-sm-4 d-flex align-items-end" style="gap: 10px; margin-top: 24px;">
                    <button type="submit" class="btn btn-sm btn-info">Filter</button>
                    <a href="{{ route('admin.auth.reports.survey_participation') }}" class="btn btn-sm btn-secondary px-1 py-1" style="min-width: 80px;">Clear Filter</a>
                </div>
            </div>
        </form>
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Time Period</span>
                        <select name="timeperiod" id="timeperiod" class="form-control">
                            <option value="">Select Time Period</option>
                            <option value="30" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '30'){ selected } @endif>last 30 days</option>
                            <option value="60" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '60'){ selected } @endif>last 60 days</option>
                            <option value="90" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '90'){ selected } @endif>last 90 days</option>
                            
                        </select>
                    </div>
                </div>
        </div>		  
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th>First Name</th> 
                            <th>Panelist ID</th>
                            <th>Survey ID</th>
                            <th>Respondent ID</th>
                            <th>Channel Name</th>
                            <th>Survey Status</th>
                            <th>Respondent Status</th>
                            <th>Approved Status</th>
                            <th>Survey Attempted Date</th>
                            <th>Survey Incentive Amount</th>
                            <th>Incenvite credit date</th>                  
                            <th>Unsubscribed</th>      
                            <th>Blacklisted</th>             
                            <th>Deactivated</th>               
                            <th>Deleted</th>             
                        </tr>
                        </thead>
                        <tbody>
						@php		
							$points = 0;
						@endphp
                        
                        @foreach($trafficStats as $result)

                            @php
                                $startDate = $result->started_at ? date('Y M d', strtotime($result->started_at)) : '';
                                $startDateTime = $result->started_at ? date('Y M d h:i:s', strtotime($result->started_at)) : '';
                                $points = $result->proj_cpi ? $result->proj_cpi * 1000 : 0;

                                $approvedStatus = '-';
                            
                                if ($result->approval_status == 50 && $result->status == 1) {
                                    $approvedStatus = 'Approved';
                                } elseif ($result->approval_status == 5 && in_array($result->status, [1, 5])) {
                                    $approvedStatus = 'Rejected';
                                } elseif ($result->status == 1) {
                                    $approvedStatus = 'Pending';
                                }
                            @endphp
                            <tr>
                                <td>{{ $result->first_name }}</td>
                                <td>{{ $result->panelist_id }}</td>
                                <td>{{ $result->project_code }}</td>
                                <td>{{ $result->RespID }}</td>
                                <td>
                                    @if($result->channel_id == 1 || $result->channel_id == 0) Dashboard
                                    @elseif($result->channel_id == 2) Email
                                    @endif
                                </td>
                                <td>{{ $result->status_name ? ucfirst($result->status_name) : "Abandon" }}</td>
                                <td>{{ $result->resp_status_name ? ucfirst($result->resp_status_name) : "Abandon" }}</td>
                                <td>{{ $approvedStatus }}</td>
                                <td>{{ $startDateTime }}</td>
                                <td>{{ $points }}</td>
                                <td>{{ $result->approval_status == 50 ? $startDate : '' }}</td>
                                <td>
                                    {{ $result->panelist_id == '' ? '' : ($result->unsubscribed == 1 ? 'Yes' : 'No') }}
                                </td>
                                <td>
                                    {{ $result->panelist_id == '' ? '' : ($result->is_blacklist == 1 ? 'Yes' : 'No') }}
                                </td>
                                <td>
                                    {{ $result->panelist_id == '' ? '' : ($result->deactivate == 0 ? 'Yes' : 'No') }}
                                </td>
                                <td>{{ ($result->deleted_at || $result->panelist_id == '') ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
@endpush
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
			
			 // Define custom sorting function

            $.fn.dataTable.ext.type.order['date-format-pre'] = function(d) {
               // return moment(d, 'YYYY-MM-DD').unix();
            };

			
            $('#user_management').DataTable({
                serverSide: false,				
                stateSave: true,
                destroy: true,
                'processing': true,
                dom: 'Bfrtip',
				order: [[5, 'desc']],
				columnDefs: [
					{ type: 'date-format', targets: 5 }
				],
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
                buttons: [
                    'excel', 'csv'
                ],
            });
            $(".dataTables_wrapper").css("width","100%");
        } );


        $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
	   
	   
		/* we will set MAX date to current date for toDate [17-06-2024] */

		/* var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		 if(dd<10){
				dd='0'+dd
			} 
			if(mm<10){
				mm='0'+mm
			} 

		today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("fromdatefield").setAttribute("max", today);
		document.getElementById("todatefield").setAttribute("max", today); */
		
		
		/* set min and max Value in TO and FROM date [17-06-2024] */
		
		
		document.addEventListener('DOMContentLoaded', function() {
			const startDateInput = document.getElementById('fromdatefield');
			const endDateInput = document.getElementById('todatefield');
			
			// Get today's date in YYYY-MM-DD format
			const today = new Date().toISOString().split('T')[0];

			// Set the max attribute for both start and end date inputs to today's date
			startDateInput.max = today;
			//endDateInput.max = today;
			
			// Function to get query parameter by name
			function getQueryParameter(name) {
				const urlParams = new URLSearchParams(window.location.search);
				return urlParams.get(name);
			}

			// Get min date from URL
			const minDate = getQueryParameter('toDate');

			// Set the min attribute for start date input from URL parameter if it exists
			if (minDate) {
				endDateInput.min = minDate;
			}			

			startDateInput.addEventListener('change', function() {
				const startDate = startDateInput.value;
				if (startDate) {
					endDateInput.min = startDate;
				} else {
					endDateInput.removeAttribute('min');
				}
			});
		});
    </script>
@endpush
