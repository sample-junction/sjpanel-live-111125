@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.response_rate_title'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    Reports <small class="text-muted">Panelist Response Rate</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <form action="{{route('admin.auth.reports.response')}}" method="get" id="filterdata">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="fromDate" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>To Date</span>
                        <input type="date" name="toDate" id="toDate" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                    <span>Select Country</span>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected disabled>Select Country</option>
                        <option value="IN" {{ (isset($_GET['country']) && $_GET['country'] == 'IN') ? 'selected' : '' }}>India</option>
                        <option value="US" {{ (isset($_GET['country']) && $_GET['country'] == 'US') ? 'selected' : '' }}>United States of America</option>
                        <option value="CA" {{ (isset($_GET['country']) && $_GET['country'] == 'CA') ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ (isset($_GET['country']) && $_GET['country'] == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                    </select>
                </div>
            </div>
                <div class="col-sm-2">
                    <div class="row">
                    <div class="col-sm-4 form-group">
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                    </div>
                    <div class="col-sm-7 form-group">
                        <button type="button" class="btn btn-sm btn-info" id="btn-clear-filter" style="margin-top: 24px;">Clear Filter</button>
                    </div>
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
            
            </div><!--row-->
        

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.reports.table.total_invite_sent')</th>
                            <th>@lang('labels.backend.access.reports.table.total_click_start')</th>
                            <th>@lang('labels.backend.access.reports.table.response_rate')</th>                            
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>{{ $totalInvite }}</td>
                                <td>{{ $totalStart }}</td>
                                <td>{{ $resposeRate }}</td>
                               

                               

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        {{--<div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $users->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->--}}
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user_management').DataTable({
                // dom: 'Bfrtip',
                // buttons: [
                //     'excel', 'csv'
                // ]
            });
            $(".dataTables_wrapper").css("width","100%");
        } );
    </script>
    <script>
       $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
        document.getElementById('btn-clear-filter').addEventListener('click', function () {
            document.getElementById('country').value = '';
            document.getElementById('fromDate').value = '';
            document.getElementById('toDate').value = '';
        });

    </script>
@endpush
