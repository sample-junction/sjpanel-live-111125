@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.incentive_distribution'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

           <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Reports <small class="text-muted">Incentive Distribution</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-7">
                <a href="{{route('admin.auth.reports.incentive')}}" class="btn btn-info" style="float: right;margin-left: 10px;">Reset</a>&nbsp;&nbsp;
                <button type="button" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#bulkSearch">Bulk Search</button>
            </div>
        </div><hr>
        <!--<form action="{{route('admin.auth.reports.incentive')}}" method="get" id="filterdata">
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
            </div><!--row
        </form>-->
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.users.table.uuid')</th>
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th>@lang('labels.backend.access.reports.table.total_earned')</th>
                            <th>Total Redeem</th>
                            <th>Current Balance</th>
                            <th>Currency/Value</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                           
                        @foreach($get_redeem_data as $result)
                        @php 
                            $panellist_id =  User::getPanelistsId($result->uuid);

                            $user_points = $result->user_points ?? ['redeemed_points' => 0, 'completed' => 0];

                            $redeemed = $user_points['redeemed_points'] ?? 0;
                            $completed = $user_points['completed'] ?? 0;

                            $total_earned = $redeemed + $completed;

                            if(($completed / 1000) < 1){
                                $converted_value = ($completed / 1000) * 100;
                                $currencywithvalue = $converted_value.' cents';
                            } else {
                                $converted_value = ($completed / 1000);
                                $currencywithvalue = '$'.$converted_value;
                            }

                        @endphp
                        @if($total_earned!=0 && $panellist_id!="")
                            <tr>
                                 <td>{{ $result->uuid }}</td>
                                 <td>{{ $panellist_id }}</td>
                                 <td>{{ $total_earned }}</td>
                                 <td>{{ $result->user_points['redeemed_points'] }}</td>
                                 <td>{{ $result->user_points['completed'] }}</td>
                                 <td>{{ $currencywithvalue }}</td>
                               
                            </tr>
                        @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->


<div class="modal fade in bulkSearch" tabindex="-1" role="dialog" id="bulkSearch" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{route('admin.auth.reports.incentive')}}" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Search Type</span>
                                <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">Select Search Type</option>
                                    <option value="uuid" selected>UUID</option>
                                    <!-- <option value="panelists_id">Panelists Id</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Insert Data For Search</span>
                                <textarea name="userids" class="form-control" placeholder="Enter Data (ex-1,2,3,4)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" class="btn btn-primary" style="margin-right: 20px;">Apply</button>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal-->
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
    </script>
@endpush
