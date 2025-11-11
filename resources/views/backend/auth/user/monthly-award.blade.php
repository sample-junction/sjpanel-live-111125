@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')
@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.monthly_award'))
@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('labels.backend.access.reports.titles.monthly_award')
                </h4>
            </div>
            <!--col-->
        </div>
        <hr>
        <form action="{{ route('admin.auth.monthlyAward') }}" method="get" id="filterdata">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Time Period</span>
                        <select name="timeperiod" id="timeperiod" class="form-control">
                            <option value="">Select Time Period</option>
                            <option value="15" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '15'){ selected } @endif>last 15 days</option>
                            <option value="30" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '30'){ selected } @endif>last 30 days</option>
                            <option value="60" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '60'){ selected } @endif>last 60 days</option>
                            <option value="90" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '90'){ selected } @endif>last 90 days</option>
                            <option value="365" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '365'){ selected } @endif>last 365 days</option>
                            <option value="custom" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == 'custom'){ selected } @endif>Custom</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="fromdatefield" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>To Date</span>
                       <input type="date" name="toDate" id="todatefield" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;" id="filter" disabled>Filter</button>
                        @if(!empty($_GET))
                            <a style="margin-top: 24px;" href="{{ route('admin.auth.monthlyAward') }}" class="btn btn-sm btn-secondary" id="resetFilter">Reset Filter</a>
                        @endif                      
                    </div>
                </div>                
        </form>
        <div style="margin: 0 auto"><div class="alert alert-danger error" style="display: none;"></div></div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.table.panelistid')</th>
                                <th>@lang('labels.backend.access.users.table.uuid')</th>
                                <th>@lang('labels.backend.access.users.table.first_name')</th>
                                <th>@lang('labels.backend.access.users.table.last_name')</th>
                                <th>@lang('labels.backend.access.users.table.age')</th>
                                <th>@lang('labels.backend.access.users.table.gender')</th>
                                <th>@lang('labels.backend.access.users.table.zipcode')</th>
                                <th>@lang('labels.backend.access.users.table.city_state')</th>
                                <th>@lang('labels.backend.access.users.table.Last_login')</th>
                                <th>@lang('labels.backend.access.users.table.no_of_profile_filled')</th>
                                <th>@lang('labels.backend.access.users.table.total_no_of_survey_attempted')</th>
                                <th>@lang('labels.backend.access.users.table.last_survey_status')</th>
                                <th>@lang('labels.backend.access.users.table.channel')</th>
                                <th>@lang('labels.backend.access.users.table.total_no_of_survey_complete')</th>
                                <th>@lang('labels.backend.access.users.table.unsubscribed')</th>
                                <!--<th>@lang('labels.backend.access.users.table.deactivated')</th>-->
                                <th>@lang('labels.backend.access.users.table.SOI')</th>
                                <th>@lang('labels.backend.access.users.table.DOI')</th>
                                <th>DOI Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                            @php
                            if(isset($user->survey_status)){
                            if($user->survey_status == 0){
                            $survey_status = "inpanel.activity_log.abandon";
                            } elseif($user->survey_status == 1){
                            $survey_status = "inpanel.activity_log.completed";
                            }elseif($user->survey_status == 2){
                            $survey_status = "inpanel.activity_log.terminate";
                            }elseif($user->survey_status == 3){
                            $survey_status = "inpanel.activity_log.Quota_full";
                            }elseif($user->survey_status == 4){
                            $survey_status = "inpanel.activity_log.Quality_terminate";
                            }elseif($user->survey_status == 5){
                            $survey_status = "inpanel.activity_log.rejected";
                            }elseif($user->survey_status == 50){
                            $survey_status = "inpanel.activity_log.approved";
                            }else{
                            $survey_status = "";
                            }
                            }else{
                            $survey_status = $user->survey_status;
                            }
                            if(isset($user->channel_id)){
                                if($user->channel_id == '1'){
                                $channel_name = "Dashboard";
                                }elseif($user->channel_id == '2'){
                                $channel_name = "Email";
                                }else{
                                $channel_name = "";
                                }
                            }else{
                            $channel_name = "";
                            }
                            $deactivate_at =  \Carbon\Carbon::parse($user->deactivate_at)->format('Y-m-d');
                            if (!isset($user->deactivated_date)) {
                                $deactivate_at = "";
                            } else {
                                // Parse and format deactivated_date using Carbon
                                $deactivate_at = \Carbon\Carbon::parse($user->deactivated_date)->format('Y-m-d');
                            }
                             if (!isset($user->unsubscribed_on)) {
                                $unsubscribed_on = "";
                            } else {
                                // Parse and format deactivated_date using Carbon
                                $unsubscribed_on = \Carbon\Carbon::parse($user->unsubscribed_on)->format('Y-m-d');
                            }                            
                            @endphp
                            <tr>
                                <td>{{ $user->panellist_id }}</td>
                                <td>{{ $user->uuid }}</td>
                                <td class="td-th-hide">{{$user->first_name}}</td>
                                <td class="td-th-hide">{{$user->last_name}}</td>
                                <td>{{$user->age }}</td>
                                <td>
                                    <!--{{$user->gender }} -->                                
                                    @if( strtolower($user->gender) == 'homme' || strtolower($user->gender) == 'masculino' || strtolower($user->gender) == 'male')
                                    {{ 'Male' }}
                                    @elseif( strtolower($user->gender) == 'femme' || strtolower($user->gender) == 'femenina' || strtolower($user->gender) == 'female' || strtolower($user->gender) == 'hembra')
                                    {{ 'Female' }} 
                                    @else   
                                    {{ $user->gender }} 
                                    @endif                                
                                </td>
                                <td>{{$user->zipcode}}</td>
                                 <td>@if(isset($usersData[0][$user->panellist_id]['city'])){{ $usersData[0][$user->panellist_id]['city'] }},@endif @if(isset($usersData[0][$user->panellist_id]['state'])){{ $usersData[0][$user->panellist_id]['state'] }}@endif</td>
                                <td>{!! optional($user->last_login ? \Carbon\Carbon::parse($user->last_login) : null)->diffForHumans() !!}
                                </td>
                                
                                <td>{{ $user->profile_filled}}</td>
                                <td>{!!$user->Total_survey_taken!!}</td>
                                <td>{{__($survey_status)}}</td>
                                <td>{{__($channel_name)}}</td>
                                <td>{!!$user->Total_survey_completed!!}</td>
                                <!--<td>
                                    @if($user->unsubscribed == 1)
                                    <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                    @else
                                    <span class="badge badge-danger" style="padding: 5px;">No</span>
                                    @endif
                                </td>-->
                                <td>
                                    @if(request()->has('fromDate') && request()->has('toDate'))
                                       @if($user->unsubscribed_on >= request()->input('fromDate') && $user->unsubscribed_on <= request()->input('toDate'))
                                            <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                        @else
                                            <span class="badge badge-danger" style="padding: 5px;">No</span>
                                        @endif
                                    @else
                                        @if($user->unsubscribed == 1)
                                            <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                        @else
                                        <span class="badge badge-danger" style="padding: 5px;">No</span>
                                        @endif
                                    @endif
                                </td>
                                <!--<td>
                                    @if(!empty($user->deactivate_at))
                                    <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                    @else
                                    <span class="badge badge-danger" style="padding: 5px;">No</span>
                                    @endif
                                </td>-->
                                <!--<td>{{$deactivate_at}}
                                    @if(request()->has('fromDate') && request()->has('toDate'))
                                        @if(isset($deactivate_at))
                                            @if(($deactivate_at >= request()->input('fromDate') && $deactivate_at <= request()->input('toDate')) || $user->active == '0')
                                                <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                            @else
                                                <span class="badge badge-danger" style="padding: 5px;">No</span>
                                            @endif
                                        @else
                                           <span class="badge badge-danger" style="padding: 5px;">No</span>
                                        @endif
                                    @else
                                        @if($user->active == '0')
                                            <span class="badge badge-success" style="padding: 5px;">Yes</span>
                                        @else
                                        <span class="badge badge-danger" style="padding: 5px;">No</span>
                                        @endif
                                    @endif
                                </td>-->
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}</td>
                                <td>@if(!is_null($user->confirm_at)){{ \Carbon\Carbon::parse($user->confirm_at)->format('d-m-Y') }}@endif</td>
                                <td>{!! $user->confirmed_label !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
    </div>
    <!--card-body-->
</div>
<!--card-->
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
<script>
    $(document).ready(function() {
        $('#user_management').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100,'All'],
            ],
            buttons: [
                'excel', 'csv'
            ],
        });
        $(".dataTables_wrapper").css("width","100%");
    });


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

    $('#fromdatefield, #todatefield').on('keydown', function(e) {
         e.preventDefault();
    });


    $('#timeperiod').change(function() {
        var timeperiod = $(this).val();
        console.log('timeperiod => ',timeperiod);
        if (timeperiod) { 
            if(timeperiod != 'custom'){
                var today = new Date();
                var startDate = new Date();
                startDate.setDate(today.getDate() - timeperiod);
                var todayFormatted = formatDate(today);
                var startDateFormatted = formatDate(startDate);
                console.log("Today's date: " + todayFormatted);
                console.log("Start date ("+timeperiod+" days ago): " + startDateFormatted)
                $('#fromdatefield').val(startDateFormatted);
                $('#todatefield').val(todayFormatted);
                $('#fromdatefield').prop('readonly', true);
                $('#todatefield').prop('readonly', true);          
                $('#filterdata').submit(); 
            }else{
                    $('#fromdatefield').val('');
                    $('#todatefield').val('');
                    $('#fromdatefield').prop('readonly', false);
                    $('#todatefield').prop('readonly', false); 
                }
        }else{
            $('#fromdatefield').val('');
            $('#todatefield').val('');
            $('#fromdatefield').prop('readonly', false);
            $('#todatefield').prop('readonly', false); 
        }
    }); 
    function formatDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        
        // Add leading zeros if needed
        if (day < 10) {
            day = '0' + day;
        }
        if (month < 10) {
            month = '0' + month;
        }
        
        //return day + '/' + month + '/' + year; // Adjust the format as needed
        return year + '-' + month + '-' + day; // Adjust the format to YYYY-MM-DD
    }

    $('#todatefield').on('change', function() {
            var toDateValue = $(this).val();
            
            // Enable or disable the filter button based on toDate selection
            if (toDateValue) {
                $('#filter').prop('disabled', false);
            } else {
                $('#filter').prop('disabled', true);
            }
        });
</script>
@endpush