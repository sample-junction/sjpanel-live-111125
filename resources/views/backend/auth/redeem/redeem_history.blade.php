@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <label>
                <h4>
                    {{__('Redeem Points History')}}
                </h4>
            </label>
        </div>

        {{html()->form('post',route('admin.auth.approve.all_selected'))->open()}}
        <div class="card-body">
            <div class="row">
               
                
            </div>
 
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="redeem-request" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>@lang('labels.backend.access.reports.table.uuid')</th>
                        <th>User Panelist ID</th>
                        <th>Available Points</th>
                        <th>Requested Points</th>
                        <th>Value</th>
                        <!-- <th>Redemption Method</th> -->
                        <th>Redemption Requested</th>
                        <th>Redemption Approved</th>
                        <th>Payment Requested to Rybbon</th>
                        <th style="width: 101px;">Coupon Sent by Rybbon</th>
                        <th>Coupon Redeemed</th>
                        <th>Status</th>
                        <th>Platform</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($redeem_data as $redeem)
                            {{-- @php
                                $panelist_id =  User::getPanelistsId($redeem->user_uuid);
                                // dd($panelist_id);
                            @endphp --}}
                               @php
                                 /*Priyanka : 04-sep-2024*/
                                   $panellist_id =  $redeem->panellist_id;
                                   if (!empty($panellist_id)) {
                                       if($redeem->points) {
                                          $symbol = ($redeem->currency_symbols == 'CAD') ? $redeem->currency_symbols.' ' : $redeem->currency_symbols;
                                          $points = $redeem->points;
                                          $value = round($redeem->redeem_points / $points, 2);
                                      } else {
                                           $symbol = '$';
                                           $points = config('app.points.metric.conversion');
                                           $value = round($redeem->redeem_points * $points, 2);
                                      }
                                   }else{
                                       $symbol = '$';
                                       $points = config('app.points.metric.conversion');
                                       $value = round($redeem->redeem_points * $points, 2);
                                   }
                                /*Priyanka : 04-sep-2024*/
                               if ($panellist_id === null) {
                                   Log::error('Panelist ID is null for user_uuid: ' . $redeem->user_uuid);
                               }
                               @endphp
                            <tr id="tr_{{$redeem->id}}" data-request_id="{{$redeem->id}}">
                                <td class="datatable_checkbox select-checkbox" data-request_id="{{$redeem->id}}" >{{$redeem->id}}</td>
                                <td>{{$redeem->user_uuid}}</td>
                                <!--Priyanka : 04-sep-2024-->
                                <!--<td>
                                    @if($redeem->user)
                                        {{$redeem->user->panellist_id}}
                                    @else
                                        N/A
                                    @endif
                                </td>-->
                                <td>{{$panellist_id}}</td>
                                <!--Priyanka : 04-sep-2024-->
                                
                                <td>@if($redeem->total_points){{$redeem->total_points}}@else 0 @endif</td>
                                <td>@if($redeem->redeem_points){{$redeem->redeem_points}}@else 0 @endif</td>
                                <!--Priyanka : 04-sep-2024-->
                                    <!--<td></td>-->
                                    <td>{{  $symbol }}{{ $value}}</td>
                                <!--Priyanka : 04-sep-2024-->
                                <td>@if($redeem->approve){{$redeem->approve}}@else '--' @endif</td>
                                <td>@if($redeem->coupon_sent){{$redeem->coupon_sent}}@else '--' @endif</td>
                                <td>@if($redeem->ribbon_notified){{$redeem->ribbon_notified}}@else '--' @endif</td>
                                <td>@if($redeem->coupon_redeemed){{$redeem->coupon_redeemed}}@else '--' @endif</td>
                                <td>@if($redeem->created_at){{$redeem->created_at}}@else '--' @endif</td>
                                <td class="capitalize">{{$redeem->status}}</td>
                                <td>    
                                    @php
                                        $device = strtolower($redeem->device_type);
                                    @endphp

                                    @if($device === 'android' || $device === 'ios')
                                        App ({{ $device }})
                                    @elseif($device === 'web')
                                        Web
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
        {{html()->form()->close()}}
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">


    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script>
       $(document).ready(function() {
    new ClipboardJS('.btn-copy');
    /* $('#redeem-request').DataTable({
        "responsive": true, 
        dom: 'lBfrtip',
        paging: true,
        "buttons": [ "csv", "excel"],
        serverSide: true,
        destroy: true,
        'processing': true,
        ajax: "{{ route('admin.auth.redeem.history.dataTableRedeemHistory') }}",
        columns: [
            {
                name: 'id',
                'orderable': true,
                searchable: false
            },
            { name: 'user_uuid', orderable:false},
            { name: 'user.panellist_id', orderable:false},
            { name: 'total_points' },
            { name: 'redeem_points' },
            { name: 'value', orderable: false, searchable:false,
                render: function(data,type,row){
                    if(row[4]*@json(config('app.points.metric.conversion')) < 1){ 
                        return toFixedTrunc(row[4]*@json(config('app.points.metric.conversion'))*100,2)+'cents';
                    }else{
                    if(row[4] % 1000 == 0){
                            return '$'+toFixedTrunc(row[4]*@json(config('app.points.metric.conversion')),2);
                        }else{
                            return '$'+ toFixedTrunc(row[4]*@json(config('app.points.metric.conversion')),2);
                        }                            
                    }
                } 
            },
            { name: 'created_at', orderable: true, searchable: true }, // Enable searching by date
            { name: 'approve' , orderable: false, searchable:false ,defaultContent: '--'},
            { name: 'ribbon_notified' , orderable: false, searchable:false,defaultContent: '--' },
            { name: 'coupon_sent' , orderable: false, searchable:false ,defaultContent: '--'},
            { name: 'coupon_redeemed' , orderable: false, searchable:false,defaultContent: '--' },
            { name: 'show_status' },
        ],
        'columnDefs': [{
            'targets': 11,
            'className': 'capitalize'
        }]
    }).buttons().container().appendTo('#redeem-request .col-md-6:eq(0)'); */
	
	$('#redeem-request').DataTable({
        scrollX: true,
        dom: 'lBfrtip', // Add button UI
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Export CSV',
                titleAttr: 'Export as CSV',
                className: 'btn btn-sm btn-outline-primary'
            },
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                titleAttr: 'Export as Excel',
                className: 'btn btn-sm btn-outline-success'
            }
        ],
        language: {
            buttons: {
                csv: 'CSV',
                excel: 'Excel'
            }
        },
        order: [[0, 'desc']]
    }); // Priyanka 04-09-2024
	
    $(".dataTables_wrapper").css("width","100%");
});

function toFixedTrunc(x, n) {
    const v = (typeof x === 'string' ? x : x.toString()).split('.');
    if (n <= 0) return v[0];
    let f = v[1] || '';
    if (f.length > n) return `${v[0]}.${f.substr(0,n)}`;
    while (f.length < n) f += '0';
    return `${v[0]}.${f}`
}

			
    </script>
    <style type="text/css">
        .capitalize{
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
@endpush
