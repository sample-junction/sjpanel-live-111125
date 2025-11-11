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
                    Reports <small class="text-muted">Survey Status Report</small>
                </h4>
            </div><!--col-->
        </div>
        {{--<form action="{{route('admin.auth.reports.survey')}}" method="get" id="filterdata">
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
        </div>--}}
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            {{--<th>@lang('labels.backend.access.users.table.uuid')</th> 
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th>Total Assign</th>
                            <th>Start</th>
                            <th>Complete</th>
                            <th>Terminate</th>
                            <th>Quotafull</th>
                            <th>Quality Terminate</th>
                            <th>Abandon</th>
                            <th>Rejected</th>
                            <th>Action</th>--}}
                            
                            
                        </tr>
                        </thead>
                        <tbody>
                           
                            
                        <tr>
                            <td colspan="3">

                        <a class="btn btn-primary" href="https://apace.sjhost.net/project/work_flow" target="_blank">Survey Workflow page</a>
                   
                        <a class="btn btn-primary" href="https://apace.sjhost.net/report/survey_master" target="_blank">Survey Master</a>
                   
                </td>

                                 {{--<td>{{ $result['uuid'] }}</td>
                                 <td>{{ $panelist_id }}</td>
                                 <td>{{ $result['assignCount'] }}</td>
                                 <td>{{ $result['startCount'] }}</td>
                                 <td>{{ $result['completesCount'] }}</td>
                                 <td>{{ $result['terminatesCount'] }}</td>
                                 <td>{{ $result['quotafullCount'] }}</td>
                                 <td>{{ $result['quality_terminateCount'] }}</td>
                                 <td>{{ $result['abandonsCount'] }}</td>
                                 <td>{{ $result['rejectCount'] }}</td>
                                 <td><a href="{{route('admin.auth.reports.survey_details', $result['uuid'])}}"><i class='fa fa-eye' title="View"></i></a></td>--}}
                               
                            </tr>
                      
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
        } );


        $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
    </script>
@endpush
