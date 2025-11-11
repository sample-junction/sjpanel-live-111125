@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('inpanel.user.support.history_heading'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">{{__('inpanel.user.support.history_heading')}}
                
                </h4>
            </div><!--col-->
            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                        <tr>
                            <th>Ticket Id</th>
                            <th>Panelist Id</th>
                            <th>Subject</th>
                            <th>Support Type</th>
                            <th>Message</th>
                            <th>Submitted</th>
                            <th>Last Update</th>
                            <th>Platform</th>
                            <th>Status</th>
                            <th width="200px" style="text-align: center;">Action</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($supportHistory as $result)
                        @php
                                $userData = User::where('id',$result->user_id)->first();
                                //print_r($userData);
                            $createdDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->created_at)->setTimezone($userData['timezone'])->format('d M Y H:i:s'); 
                            if($result->updated_at){
                                $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->updated_at)->setTimezone($userData['timezone'])->format('d M Y H:i:s');
                            }else{
                                $updatedDate = '';
                            }
                            
                            
                        @endphp
                            <tr>
                                <td>
                                    <a href="{{route('admin.auth.support.chatshow',$result->id)}}"><u>{{$result->id}}</u></a>
                                </td>
                                 <td> 
                                    {{$userData['panellist_id']}}
                                </td>
                                <td class="project-status">
                                <a href="{{route('admin.auth.support.chatshow',$result->id)}}">{{$result->project_code}}</a> 
                                </td>
                                <td> 
                                    {{$result->subject}}
                                    
                                </td>
                               
                                <td> 
                                    {{substr($result->message, 0, 6)}}...
                                </td>
                                <td> 
                                    {{$createdDate}}
                                </td>
                                <td> 
                                    {{$updatedDate}}
                                    
                                </td>
                                <td>    
                                    @php
                                        $device = strtolower($result->device_type);
                                    @endphp

                                    @if($device === 'android' || $device === 'ios')
                                        App ({{ $device }})
                                    @elseif($device === 'web')
                                        Web
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>@if($result->status==0)<span class="btn-sm btn-success">Open</span>@else<span class="btn-sm btn-danger">Closed</span>@endif</td>
                                <td> 
                                    <select class="form-control change-status" onchange="changeStatus('{{$result->id}}', this.value)">
                                        <option>Select Status</option>
                                        @if($result->status == 0)
                                            <option value="1">Closed</option>
                                        @elseif($result->status == 1 || $result->status == 3)
                                            <option value="0">Reopen</option>
                                        @endif
                                    </select>
                                </td>
                                
                            </tr>
                        @empty
                            {{__('inpanel.user.support.no_history')}}
                        @endforelse
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
    {{--<script>
    @if($tour_taken == 0)
@include('inpanel.includes.partials.php-js.referral_page')
        @endif
    </script>--}}

    <script>
$(document).ready(function() {
    var table = $('#tableData').DataTable({
        ordering: false,
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, 'All'],
        ],
        columnDefs: [
            {
                targets: [8], // Index of the "Status" column
                searchable: true, // Enable searching on this column
            }
        ],
    });

    // Append select dropdown for filtering by status
    $('#tableData_wrapper .dataTables_filter').append('<select id="status_filter" class="form-control" style="margin-left:7px;display:inline !important;width:18% !important;"><option value="">All</option><option value="Open">Open</option><option value="Closed">Closed</option></select><select id="select_panelist" class="form-control" style="margin-left:7px;display:inline !important;width:25% !important;"><option value="" @if($role == "all") selected @endif>All</option><option value="Real" @if($role == 4) selected @endif>Real Panelist</option><option value="Test" @if($role == 8) selected @endif>Test Panelist</option></select>');

    // Event listener for status filter change
    $('#status_filter').on('change', function() {
        var status = $(this).val();

        // Apply filter based on selected status
        if (status === '') {
            table.column(7)
                .search('', true, false)
                .draw();
        } else {
            table.column(7)
                .search(status === 'Open' ? '^Open$' : '^Closed$', true, false)
                .draw();
        }
    });

    $('.change-status').change(function() {
        var supportId = $(this).closest('tr').find('td:first-child').text().trim();
        var statusData = $(this).val();
        
        $.ajax({
            url: "{{ route('admin.auth.support.changeStatus') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                supportId: supportId,
                statusData: statusData
            },
            dataType: 'JSON',
            success: function(response) {
                console.log('Response:', response);
                try {
                    if (response.status === 200) {
                        console.log('Status updated successfully');
                        location.reload();
                    }
                } catch(error) {
                    swal({ text: "Some error occurred!", type: "error" });
                }
            },
        });
    });
    
    ///// ======= this code add by Pushpendra ======= \\\\\
    $('#select_panelist').on('change', function() {
        var select_panelist = $(this).val();
        let role_value = "";
        if (select_panelist === '') {
            role_value = "all";
            window.location.href = "{{ route('admin.auth.support.history') }}/"+role_value;
        }else if(select_panelist === 'Test'){
            role_value = 8;
            window.location.href = "{{ route('admin.auth.support.history') }}/"+role_value;
        }else{
            window.location.href = "{{ route('admin.auth.support.history') }}";
        }
    });
    ///// ======= this code add by Pushpendra ======= \\\\\
});




    </script>
   
@endpush
