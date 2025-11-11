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
                    Listing <small class="text-muted">Panelist Live Surveys Details</small>
                </h4>
            </div><!--col-->
        </div>
        <hr>
        <div class="col-sm-1"></div>

    </div><!--row-->

    <form action="{{route('admin.auth.reports.panelist_survey_history')}}" method="get" id="filterdata">
        <div class="row">
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
            <div class="col-sm-6 d-flex align-items-center" style="gap: 10px;">
                <button id="filterBtn" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.auth.reports.panelist_survey_history') }}" id="clearFilterBtn" class="btn btn-secondary">Clear Filter</a>
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table" id="SurveysTable">
                    <thead>
                        <tr>
                            <th>PM</th>
                            <th>Panelist ID</th>
                            <th>Surveys</th>
                            <th>Survey Status</th>
                            <th>Invite Sent Status</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
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
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#SurveysTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.auth.reports.panelist_survey_history') }}",
                type: "GET",
                data: function(d) {
                    d.fromDate = $('#fromdatefield').val();
                    d.toDate = $('#todatefield').val();
                }
            },
            dom: 'Bfrtip',
            order: [
                [5, 'desc']
            ],
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            buttons: [{
                    extend: 'excel',
                    text: 'Excel',
                    className: 'btn btn-sm btn-info',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    className: 'btn btn-sm btn-info',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            columns: [{
                    data: 'pmName',
                    name: "pmName"
                },
                {
                    data: 'panelist_id',
                    name: "panelist_id"
                },
                {
                    data: 'survey',
                    name: "survey"
                },
                {
                    data: 'survey_status_code',
                    name: "survey_status_code"
                },
                {
                    data: 'invite_sent_count',
                    name: 'invite_sent_count',
                    render: function(data) {
                        return data > 0 ?
                            '<span class="badge badge-success">Yes</span>' :
                            '<span class="badge badge-danger">No</span>';
                    }
                }, {
                    data: 'created_at',
                    name: "created_at",
                    render: function(data) {
                        return data ? moment(data).format('YYYY MMM DD HH:mm:ss') : '';
                    }

                }
            ],
        });
        $('#clearFilterBtn').on('click', function(e) {
            e.preventDefault();
            $('#fromdatefield').val('');
            $('#todatefield').val('');
            var table = $('#SurveysTable').DataTable();
            table.search('');
            table.draw();
        });

    });
</script>

@endpush