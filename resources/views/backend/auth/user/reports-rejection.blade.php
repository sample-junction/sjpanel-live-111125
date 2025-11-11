@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.rejection'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    Reports <small class="text-muted">Rejection (Last 30 days)</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <form action="{{route('admin.auth.reports.rejection')}}" method="get" id="filterdata">
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
            </div><!--row-->
        </form>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.reports.table.uuid')</th>
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th>@lang('labels.backend.access.reports.table.project_code')</th>
                            <th>@lang('labels.backend.access.reports.table.status')</th>
                            <th>Reject Reason</th> 
                            <th>Created Date</th>                           
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($trafficRejectionData as $result)
                        @php

                        //$uuids = explode('_',$result->vvars['sjpid']);
                        //print_r($uuids[0]);
                       
                        $panelist_id =  User::getPanelistsId($result->uuid);
                            
                        @endphp    
                        <tr>
                                <td>{{ $result->uuid }}</td>
                                <td>{{ $panelist_id }}</td>
                                <td>{{ $result->project_code }}</td>
                                <td>{{ $result->status_name }}</td>
                                <td>{{ $result->reject_reason }}</td>
                                <td>{{ date('d M Y h:i a', strtotime($result->createdOn)) }}</td>
                             
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
            $('#user_management').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'csv'
                ],
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
               
            });
            $(".dataTables_wrapper").css("width","100%");
        } );
    </script>
    <script>
       $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
    </script>
@endpush
