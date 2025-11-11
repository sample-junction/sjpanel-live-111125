@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Awards List' )

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
                        {{__('Award List')}}
                    </h4>
                </label>
            </div>
            <div class="col-sm-2 pull-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="{{route('admin.auth.awards.list.create')}}">Create Awards</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <table class="table table-striped table-hover" id="affiliate" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Award Name</th>
                        <th>Status</th>
                        <th>Nomination Start No.</th>
                        <th>Nomination End No.</th>
                        <!-- <th>Preview</th> -->
                        <th>Mail Template</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($awards as $award)
                    <tr>
                        <td></td>
                        <td>{{$award->name}} </td>
                        <td>{{ $award->status == '1' ? 'Active' : 'Inactive' }}</td>
                        <td>{{$award->nomination_start}} </td>
                        <td>{{$award->nomination_end}} </td>
                        <!-- <td> <i class="fas fa-eye preview_eye" data-history_link="" style="color: #17a2b8; cursor: pointer;"></i> -->
                        </td>
                        <td>{{$award->temp_name}}</td>
                        <td>
                            <div class="dropdown" bis_skin_checked="1">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" bis_skin_checked="1">
                                    <a class="dropdown-item" href="{{ route('admin.auth.awards.list.edit', ['award_id' => $award->id]) }}">Edit</a>
                                    <!-- <form action="{{ route('admin.auth.awards.list.delete', ['award_id' => $award->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Delete</button>
                                    </form> -->
                                </div>
                            </div>
                        </td>

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
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">

@endpush

@push('after-scripts')
{{-- For DataTables --}}
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this award?');
    }

    $(document).ready(function() {
        /*
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
        */
    });
</script>
@endpush