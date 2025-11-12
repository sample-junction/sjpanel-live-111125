@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Campaign Information')}}
                        </h4>
                    </label>
                </div>
                <div class="col-sm-2 pull-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="{{route('admin.auth.campaign.create')}}">Create Campaign</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="affiliate_campaign" style="width:100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Campaign Name</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Payout</th>
                        <th>C-Type</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($campaigns as $campaign)
                        <tr>
                            <td></td>
                            <td>{{$campaign->name}} </td>
                            <td>{{$campaign->code}} </td>
                            <td>{{$campaign->type}} </td>
                            <td>{{$campaign->payout}}</td>
                            <td>{{$campaign->c_type}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div><!--card-footer-->
    </div><!--card-->
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >

@endpush

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        $(document).ready(function() {
            new ClipboardJS('.btn-copy');
            $('#affiliate_campaign').DataTable({
                serverSide: true,
                destroy: true,
                'processing': true,
                ajax: "{{ route('admin.auth.affiliate.campaign.datatable') }}",
                columns: [
                    {
                        name: 'id',
                        'orderable': false,
                        searchable: false
                    },
                    { name: 'name' },
                    { name: 'code' },
                    { name: 'type' },
                    { name: 'payout'},
                    { name: 'c_type'},
                    { name: 'action', orderable: false, searchable: false }
                ],
                'columnDefs': [{
                    'targets': 0,
                    'orderable': false,
                    'searchable': false,
                    'className': 'dt-body-center',
                    "title": "<input type='checkbox' class='select-checkbox' name='select-all' id='select-all'/>",
                    'render': function (data, type, full, meta){
                        return '<input type="checkbox" class="redeem_checkbox select-checkbox" name="id[]" value="' + data + '">';
                    }
                }],
            });
            $(".dataTables_wrapper").css("width","100%");
            $(document).on('change', '#select-all', function(event) {
                $table_body = $(document).find('#affiliate_campaign > tbody');
                if($(this).is(":checked")) {
                    $table_body.find('input.redeem_checkbox ').each(function(key, element) {
                        $(element).prop('checked', true);
                    });
                } else {
                    $table_body.find('input.redeem_checkbox ').each(function(key, element) {
                        $(element).prop('checked', false);
                    });
                }
            });
        } );
    </script>
@endpush
