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
                            {{__('Affiliates Information')}}
                        </h4>
                    </label>
                </div>
                <div class="col-sm-2 pull-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="{{route('admin.auth.affiliate.list.create')}}">Create Affiliate</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="affiliate" style="width:100%">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Affiliate Name</th>
                        <th>Code</th>
                        <th>C-Link</th>
                        <th>Affiliate Vars</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($affiliate_lists as $affiliate)
                    <tr>
                        <td></td>
                        <td>{{$affiliate->name}} </td>
                        <td>{{$affiliate->code}} </td>
                        <td>{{$affiliate->c_link}} </td>
                        <td>{{$affiliate->aff_vars}}</td>
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
            $('#affiliate').DataTable({
                serverSide: true,
                destroy: true,
                'processing': true,
                ajax: "{{ route('admin.auth.affiliate.list.datable') }}",
                columns: [
                    {
                        name: 'id',
                        'orderable': false,
                        searchable: false
                    },
                    { name: 'name', orderable:false},
                    { name: 'code' },
                    { name: 'c_link' },
                    { name: 'aff_vars'},
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
                $table_body = $(document).find('#affiliate > tbody');
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
