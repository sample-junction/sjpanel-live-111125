@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection


<style>
    .dataTables_wrapper .paginate_button {
        cursor: pointer; /* Change cursor to pointer */
    }

    .dataTables_wrapper .paginate_button {
        padding: 0.5rem 0.75rem; /* Add padding to the pagination buttons */
        margin: 0 2px; /* Add margin to the pagination buttons */
        background-color: #f8f9fa; /* Change background color */
        border: 1px solid #dee2e6; /* Add border */
        border-radius: 0.25rem; /* Add border radius */
    }

    .dataTables_wrapper .paginate_button:hover {
        background-color: #e9ecef; /* Change background color on hover */
    }

    .dataTables_wrapper .paginate_button.current {
        background-color: #007bff; /* Change background color of the current page button */
        color: #fff; /* Change text color of the current page button */
    }

    .dataTables_wrapper .pagination {
        margin-top: 0.75rem; /* Add some space above the pagination */
    }
</style>

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.users.management') }} <small class="text-muted">{{ __('labels.backend.access.users.active') }}</small>
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.auth.user.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="user_management">
                        <thead>
                            <tr>
                                <th>@lang('labels.backend.access.users.table.last_name')</th>
                                <th>@lang('labels.backend.access.users.table.first_name')</th>
                                <th>panelist</th>

                                @if(auth()->user()->roles[0]->name == 'super_administrator')
                                <th>@lang('labels.backend.access.users.table.email')</th>
                                @else
                                <th class="td-th-hide" style=" display:none;">@lang('labels.backend.access.users.table.email')</th>
                                @endif

                                <th>@lang('labels.backend.access.users.table.country')</th>
                                <!-- Modified by obhi -->
                                <th>@lang('labels.backend.access.users.table.locale')</th>
                                <!-- Modified by obhi -->
                                <th>@lang('labels.backend.access.users.table.doi')</th>
                                <th>@lang('labels.backend.access.users.table.roles')</th>
                                <th>@lang('labels.backend.access.users.table.other_permissions')</th>
                                <th>@lang('labels.backend.access.users.table.social')</th>
                                <th>@lang('labels.backend.access.users.table.last_updated')</th>
                                <th>Source</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($users as $user)
                            
                            <tr>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>

                                <td>{{ $user->panellist_id }}</td>

                                @if(auth()->user()->roles[0]->name== 'super_administrator')
                                <td>{{ $user->email }}</td>
                                @else
                                <td class="td-th-hide" style="display:none;">{{ $user->email }}</td>
                                @endif


                                <td>{{ $user->country }}</td>

                                <!-- Modified by obhi -->
                                @php
                                $lang = $user->locale;
                                $langParts = preg_split('/[_-]/', $lang);
                                $final_lang = '';
                                if (count($langParts) >= 1) {
                                    $final_lang = ucfirst($langParts[0]);
                                }
                                
                                @endphp
                                <td>{{$final_lang }}</td>
                                <!-- Modified by obhi -->

                                <td>{!! $user->confirmed_label !!}</td>
        

                                <td>{!! $user->roles_label !!}</td>
                                <td>{!! $user->permissions_label !!}</td>
                                <td>{!! $user->social_buttons !!}</td>

                                <td>{!! optional($user->updated_at)->diffForHumans() !!}</td>
                                <td>@if(!empty(@$affiliate[$user->id]))
                                	 {{$affiliate[$user->id]}}
                                 @elseif(in_array(strtolower($user->email),$invite_emails)) Survey Consensus @else   @endif</td>

                                <td>{!! $user->action_buttons !!}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                     {{ $users->links() }}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection

@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
@endpush

@push('after-scripts')
{{-- For DataTables --}}
{{-- <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script> --}}
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

<script>
    // data table

    $(document)
        .ready(function () {
            $('#user_management').DataTable({
                "paging": false, // Enable pagination
                "lengthChange": true, // Allow users to change the number of records displayed per page
                "searching": true, // Enable search functionality
                "ordering": true, // Enable column sorting
                "info": true, // Display table information summary
                "autoWidth": false, // Disable automatic column width calculation
                "responsive": true, // Enable responsive design for the table
                "language": {
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    },
                    "search": "Search:",
                    "lengthMenu": "Display _MENU_ records per page",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "zeroRecords": "No matching records found"
                }
            });
        });

</script>

@endpush
