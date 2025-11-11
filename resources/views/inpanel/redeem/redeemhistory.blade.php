@extends('inpanel.layouts.app')
@php

/* Parshant Sharma [22-08-2024] STARTS */

//$metricConversion = round(1/$countryPoints, 4);
$metricConversion = 1/$countryPoints;
//dd($metricConversion);
					
@endphp
@section('content')
      
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" />
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.redeem.index.redeem_points_status')}}</h5>
                    </div>
                    <div class="ibox-content">
                        
                        <div class="project-list referral_details">
                            <div class="table-responsive">
                            <table class="table" id="redeem-request1">
                                <thead>
                                    <tr>
                                    <th>{{__('inpanel.redeem.index.id')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_1')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_2')}}</th>
                                    <!-- <th>Redemption Method</th> -->
                                    <th>{{__('inpanel.redeem.index.title_history_3')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_4')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_5')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_6')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_9')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_7')}}</th>
                                    <th>{{__('inpanel.redeem.index.title_history_8')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($redeem_requests as $redeem)
                                @php
                                    $user=\Auth::user();
                                    
                                if($redeem->approve!=''){    
                              $approve = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->approve)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                             }
                             if($redeem->coupon_sent!=''){    
                              $coupon_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->coupon_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                             }
                             if($redeem->ribbon_notified!=''){    
                              $ribbon_notified = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->ribbon_notified)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                             }
                             if($redeem->coupon_redeemed!=''){    
                              $coupon_redeemed = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->coupon_redeemed)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                             }
                             if($redeem->reminder_sent!=''){
                                $reminder_sent = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', @$redeem->reminder_sent)->setTimezone($user->timezone)->format('Y-m-d H:i:s');
                             }

                                    @endphp
                                    @if($redeem->status == 'completed')
                                    <tr id="tr_{{$redeem->id}}" data-request_id="{{$redeem->id}}">
                                        <td class="datatable_checkbox select-checkbox" data-request_id="{{$redeem->id}}" >{{$redeem->id}}</td>
                                        <td>
                                            {{$redeem->redeem_points}}
                                        </td>
                                        <!--<td>
                                            @if(($redeem->redeem_points/1000) < 1)
                                            {{($redeem->redeem_points/1000)*100}} {{__('inpanel.dashboard.cents')}}
                                            @else
                                            {{$redeem->redeem_points/1000}}
                                            @endif
                                        </td>-->
										
										<td>
                                            @if(($redeem->redeem_points*$metricConversion) < 1)
												@php
													$currency = ($redeem->redeem_points*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
												@endphp
                                            {{number_format($redeem->redeem_points*$metricConversion*100,2)}} {{__($currency)}}
                                            @else
                                            {{number_format($redeem->redeem_points*$metricConversion,2)}}
                                            @endif
                                        </td>
                                        <!-- <td>{{$redeem->redeem_method}}</td> -->
                                        <td> @if($redeem->created_at) {{--$redeem->created_at--}}{{$redeem->created_at->setTimezone(auth()->user()->timezone)->format('m/d/Y H:i:s') }} @else '--' @endif </td>
                                        <td> @if($redeem->approve) {{$approve}} {{--$redeem->approve--}} @else '--' @endif </td>
                                        <td> @if($redeem->ribbon_notified) {{$ribbon_notified}} {{--$redeem->ribbon_notified--}} @else '--' @endif </td>
                                        <td> @if($redeem->coupon_sent){{$coupon_sent}} {{--$redeem->coupon_sent--}} @else '--' @endif </td>
                                        <td> @if($redeem->reminder_sent){{$reminder_sent}}  @else '--' @endif </td>
                                        <td> @if($redeem->coupon_redeemed) {{$coupon_redeemed}}{{--$redeem->coupon_redeemed--}} @else '--' @endif </td>
                                        
                                        <td class="capitalize"> {{$redeem->status}}@if($redeem->reminder_count!='' && $redeem->status=='pending'){{$redeem->reminder_count}}{{__('inpanel.redeem.index.reminder_sent')}}@endif</td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >

@endpush

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@coreui/coreui/dist/js/coreui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://test3.sjpanel.com/vendor/js/plugins/toastr/toastr.min.js"></script>
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
            $('#redeem-request').DataTable({
                "responsive": true, 
                dom: 'lBfrtip',
                paging: true,
                "buttons": [ "csv", "excel"],
                serverSide: true,
                destroy: true,
                'processing': true,
                //ajax: "https://test3.sjpanel.com/redeem/dataTableRedeemHistory",
                ajax: "{{ route('inpanel.redeem.redeem.dataTableRedeemHistory') }}",
                columns: [
                    {
                        name: 'id',
                        'orderable': true,
                        searchable: false
                    },
                    { name: 'redeem_points' },
                    { name: 'value', orderable: false, searchable:false },
                   // { name: 'redeem_method' },
                    { name: 'created_at' , orderable: false, searchable:false,defaultContent: '--' },
                    { name: 'approve' , orderable: false, searchable:false ,defaultContent: '--'},
                    { name: 'ribbon_notified' , orderable: false, searchable:false,defaultContent: '--' },
                    { name: 'coupon_sent' , orderable: false, searchable:false ,defaultContent: '--'},
                    { name: 'coupon_redeemed' , orderable: false, searchable:false,defaultContent: '--' },
                    { name: 'show_status' },
                ],
                'columnDefs': [{
                    'targets': 8,
                    'className': 'capitalize'
                }]
            })
            

        } );
    </script>
    <style type="text/css">
        .capitalize{
            font-weight: bold;
            text-transform: capitalize;
        }
    </style>
@endpush
