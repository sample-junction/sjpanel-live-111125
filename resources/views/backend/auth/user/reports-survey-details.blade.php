@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.survey_details'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

           <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Panelist <small class="text-muted">Survey Details</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <div class="row">
            <div class="col-sm-3">
                <h5 class="text-muted">User panelist Id : <b>{{$panelist_id}}</b></h5>
            </div>
            <div class="col-sm-6">
                <h5 class="text-muted">User uuid : <b>{{$uuid}}</b></h5>
            </div>
            <div class="col-sm-3">
                <h5 class="text-muted">Total Survey : <b>{{count($surveyData)}}</b></h5>
            </div><!--col-->
        </div><hr>
        <!-- <form action="{{route('admin.auth.reports.survey')}}" method="get" id="filterdata">
            <div class="row">
           
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>To Date</span>
                        <input type="date" name="toDate" id="" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                    </div>
                </div>
        </form>
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Time Period</span>
                        <select name="timeperiod" id="timeperiod" class="form-control">
                            <option value="">Select Time Period</option>
                            <option value="30" selected>last 30 days</option>
                            <option value="60" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '60'){ selected } @endif>last 60 days</option>
                            <option value="90" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '90'){ selected } @endif>last 90 days</option>
                            
                        </select>
                    </div>
                </div>
        </div> -->
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <!-- <th>@lang('labels.backend.access.users.table.uuid')</th> -->
                            <!-- <th>@lang('labels.backend.access.users.table.panelistid')</th> -->
                            <th>Respid</th>
                            <th>Status</th>
                            <th>Respstus</th> 
                            <th>Survey Taken Channel</th> 
                            <th>Survey Code</th> 
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                            <th>Start IP</th>
                            <th>End IP</th>
                            <th>Traffic Flag</th>
                            <th>Client Survey Link</th>
                            <th>Client End Page</th>
                            <th>Vendor Link</th>
                            <th>Vendor End Page</th>
                            <th>Platform</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($surveyData as $result) 
                            @php

                                if($result['started_at']){
                                    $startDate = date('d M Y H:i:s', strtotime($result['started_at']));
                                }else{
                                    $startDate = '---';
                                }
                                if($result['ended_at']){
                                    $endDate = date('d M Y H:i:s', strtotime($result['ended_at']));
                                }else{
                                    $endDate = '---';
                                }

                                if($result['channel_id']==1 || $result['channel_id']==0){
                                    $channel = "Dashboard";
                                }elseif($result['channel_id']==2){
                                    $channel = "Email";
                                }else{
                                    $channel = "---"; 
                                }
                            @endphp
                            <tr>
                                <td>{{ $result['RespID'] }}</td>
                                <td>{{ ucfirst($result['status_name']) ?: 'Abandon' }}</td>
                                <td>{{ ucfirst($result['resp_status_name']) ?: 'Abandon'  }}</td>
                                <td>{{ $channel }}</td>
                                <td>{{ $result['project_code'] }}</td>
                                <!-- <td>{{ ($result['reject_reason'])?$result['reject_reason']:'---' }}</td> -->
                                <td>{{ $startDate }}</td>
                                <td>{{ $endDate }}</td>
                                <td>{{ gmdate("H:i:s", $result['duration']) }}</td>
                                <td>{{ $result['start_ip_address'] }}</td>
                                <td>{{ $result['end_ip_address'] }}</td>
                                <td>{{ $result['traffic_flag'] }}</td>
                                <td>{{ $result['client_survey_link'] }}</td>
                                <td>{{ $result['client_end_link'] }}</td>
                                <td>{{ $result['vendor_start_link'] }}</td>
                                <td>{{ $result['vendor_end_link'] }}</td>
                                <td>{{ $result['device_type'] }}</td>                   
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
    <script>
        $(document).ready(function() {
            var panellistid = '{{$panelist_id}}';
            $('#user_management').DataTable({
                serverSide: false,
                stateSave: true,
                destroy: true,
                scrollX: true,
                'processing': true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
                buttons: [
                    { extend: 'excel', title : '', messageTop :'Survey Details Of '+panellistid, filename: 'Survey-'+panellistid},
                    { extend: 'csv', title : '', messageTop :'Survey Details Of '+panellistid, filename: 'Survey-'+panellistid}
                ],
                columns: [
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "120px" },
                    { "width": "90px" },
                    { "width": "90px" },
                    { "width": "120px" }
                ],
            });
            
        } );


        $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
    </script>
@endpush
