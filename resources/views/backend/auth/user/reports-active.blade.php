@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.active_panelists'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Reports <small class="text-muted">@lang('labels.backend.access.reports.titles.active_panelists')</small>
                </h4><br>
                <h5 class="text-muted">Total @lang('labels.backend.access.reports.titles.active_panelists') : <b>{{count($activeUsers)}}</b></h5>
            </div><!--col-->
            <div class="col-sm-7">
                <a href="{{route('admin.auth.reports.active')}}" class="btn btn-info" style="float: right;margin-left: 10px;">Reset</a>&nbsp;&nbsp;
                <button type="button" class="btn btn-info" style="float: right;" data-toggle="modal" data-target="#bulkSearch">Bulk Search</button>
            </div>
            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.users.table.uuid')</th>
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th data-name="age">@lang('labels.backend.access.users.table.age')</th>
                            <th>@lang('labels.backend.access.users.table.gender')</th>
                            <th>Last Login At</th>
                            <th>Last Survey Attempt At</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activeUsers as $user)
                        @php
                        //print_r(count($user->user_answers));
                        //echo '<pre>';
                        //print_r($user->user_answers);
                        @endphp
                            <tr>
                                <td>{{ $user->uuid }}</td>
                                <td>{{ $user->panellist_id }}</td>
                                <td>{{ $user->age}}</td>
                                <td>{{ ucfirst($user->gender) }}</td>
                                <td>{{ date('d M Y h:i a', strtotime($user->last_login_at)) }}</td>
                                <td>@php echo ($user->updated_at)? date('d M Y h:i a', strtotime($user->updated_at)):""; @endphp</td>

                            </tr>
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
            <form action="{{route('admin.auth.reports.active')}}" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <span>Search Type</span>
                                <select name="searchType" id="searchType" class="form-control" required>
                                    <option value="">Select Search Type</option>
                                    <option value="uuid">UUID</option>
                                    <option value="panelists_id">Panellists Id</option>
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
        processing: true,
        dom: 'Bfrtip',
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, 'All'],
        ],
        buttons: ['excel', 'csv'],
        columnDefs: [
            {
                targets: 'no-sort',
                orderable: false,
            },
        ],
        language: {
            search: '_INPUT_',
            searchPlaceholder: 'Search...',
        },
    });
    // Enable searching on the "Age" column
    // $('#user_management').DataTable().columns().every(function() {
    //     var column = this;
    //     if ($(column.header()).data('name') === 'age') {
    //         $(column.footer()).html('<input type="text" class="form-control form-control-sm" placeholder="Search Age" />');
    //         $('input', this.footer()).on('keyup change clear', function() {
    //             if (column.search() !== this.value) {
    //                 column.search(this.value).draw();
    //             }
    //         });
    //     }
    // });
});

    </script>
@endpush
