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
                    {{__('Request for Redeem Points')}}
                </h4>
            </label>
        </div>

        <form id="csvForm" method="post" action="{{route('admin.auth.redeem.upload')}}" enctype="multipart/form-data">
                   @csrf
				   <input type='file' id='csv_file' style="display: none;" name='csv_file' />
        </form>

        {{html()->form('post',route('admin.auth.approve.all_selected'))->open()}}
        <div class="card-body">
            
            <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label"><h6>Change Status:</h6></label><br>
                    <span>
                            <select class="form-control form-control-sm" style="width: 200px" name="change_status">
                                <option value="approve">Approve</option>
                                <option value="ribbon_notified">Rybbon Notified</option>
                                <option value="coupon_send">Coupon Send</option>
                                <option value="coupon_redeem">Coupon Redeem</option>
                            </select>
                        </span>
                </div>
                
                <!-- {{ route('admin.auth.redeem.export-data') }} -->
            </div>
                <div class="col-md-3"><div class="form-group">
                    <label class="control-label"><h6><a class="selected_rybbon_csv" href="javascript:void(0);" id="downloadRybbonCsv">Download Rybbon CSV</a></h6></label><br>
                </div> 
                
            </div>
            <div class="col-md-2">

                    <button type="button" id='btn-upload' class="form-control photo_upload">Upload CSV{{--__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')--}}</button>
                    <button type="button" id='btn-upload_save' class="form-control photo_upload" style="display:none;">Submit{{--__('inpanel.user.profile.preferences.preferences_menu.upload_photo1')--}}</button>
                    
            </div>
        <div class="col-md-4">
        <button type="button" class="btn btn-info" style="float: right;color:white;" data-toggle="modal" data-target="#bulkSearch">Search by email</button>
        <a href="{{ route('admin.auth.redeem_points') }}" class="btn btn-info" style="float: right;margin-right: 9px;color:white;">Reset</a>&nbsp;&nbsp;
        </div>
        </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit" value="Update All Selected">
            </div>
        
            <hr>
            @if($showSearchData==0)
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
                        <th>Request Status<br>
                            <span>(Approve,Notified,Sent,Redeem)</span>
                        </th>
                        <th>Platform</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($redeem_data as $redeem)
                    @php
                    $panelist_id =  User::getPanelistsId($redeem->user_uuid);
					/*Priyanka : 04-sep-2024*/
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
					} else {
						$symbol = '$';
						$points = config('app.points.metric.conversion');
						$value = round($redeem->redeem_points * $points, 2);
					}				
					/*Priyanka : 04-sep-2024*/					
                    @endphp
                        <tr id="tr_{{$redeem->id}}" data-request_id="{{$redeem->id}}">
                            <td class="datatable_checkbox select-checkbox" data-request_id="{{$redeem->id}}" >({{$redeem->id}})</td>

                            <td>
                            {{$redeem->user_uuid}} ({{$redeem->id}})
                            </td>
                            <td>
                            {{$panelist_id}}
                            </td>
                            <td> @if($redeem->total_points) {{$redeem->total_points}} @else 0 @endif </td>
                            <td> @if($redeem->redeem_points) {{$redeem->redeem_points}} @else 0 @endif </td>
                            <!--Priyanka : 04-sep-2024-->
                            <td>{{ $symbol }}{{ $value }}</td>
                            <!--Priyanka : 04-sep-2024-->
                            <!-- <td>{{$redeem->redeem_method}}</td> -->
                            <td></td>
                            <td>    
                                @php
                                    $device = strtolower($redeem->device_type ?? '');
                                @endphp

                                @if(empty($device) || $device === 'web')
                                    Web
                                @elseif($device === 'android' || $device === 'ios')
                                    {{ ucfirst($device) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td> {{$redeem->status}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @elseif($showSearchData==1)
            <div class="row">
                <table class="table table-striped table-hover" id="redeem-request-search" style="width:100%">
                    <thead>
                    <tr>
                        <th><input type='checkbox' class='select-checkbox' name='select-all' id='select-all-search'/></th>
                        <th>ID</th>
                        <th>@lang('labels.backend.access.reports.table.uuid')</th>
                        <th>User Panelist ID</th>
                        <th>Available Points</th>
                        <th>Requested Points</th>
                        <th>Value($)</th>
                        <!-- <th>Redemption Method</th> -->
                        <th>Request Status<br>
                            <span>(Approve,Notified,Sent,Redeem)</span>
                        </th>
                        <th>Platform</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($redeemRequestData) && count($redeemRequestData) > 0)
                        @foreach($redeemRequestData as $redeem)
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

                                $result = '';
                                $result .= ( !empty($redeem->approve) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
                                $result.='&nbsp;&nbsp;';
                                $result .= ( !empty($redeem->ribbon_notified) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
                                $result.='&nbsp;&nbsp;';
                                $result .= ( !empty($redeem->coupon_sent) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';
                                $result.='&nbsp;&nbsp;';
                                $result .= ( !empty($redeem->coupon_redeemed) )?'<i class="fas fa-check"></i>':'<i class="fas fa-times"></i>';

                            @endphp
                            <tr>
                                <td><input type="checkbox" class="redeem_checkbox select-checkbox" name="id[]" value="{{$redeem->id}}"></td>
                                <td>{{$redeem->id}}</td>
                                <td>{{$redeem->user_uuid}}</td>
                                <td>{{$panellist_id}}</td>
                                <td> @if($redeem->total_points) {{$redeem->total_points}} @else 0 @endif </td>
                                <td> @if($redeem->redeem_points) {{$redeem->redeem_points}} @else 0 @endif </td>
                                <!--Priyanka : 04-sep-2024-->
                                    <!--<td>@if($redeem->redeem_points) 

                                            {{$redeem->redeem_points*$conversion_metric}} hello
        
                                        @else 0 @endif</td>-->
                                    <td>{{  $symbol }}{{ $value}}</td>
                                <!--Priyanka : 04-sep-2024-->
                                <!-- <td>{{$redeem->redeem_method}}</td> -->
                                <td>{!!$result!!} </td>
                                <td>    
                                    @php
                                        $device = strtolower($redeem->device_type);
                                    @endphp

                                    @if($device === 'android' || $device === 'ios')
                                        {{ ucfirst($device) }}
                                    @elseif($device === 'web')
                                        Web
                                    @else
                                        -
                                    @endif
                                </td>
                                <td> {!!$redeem->show_status!!}</td>
                                <td><div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @if(empty($redeem->approve))
                                        <a class="dropdown-item" href="{{route('admin.auth.approve.redeem_points',[$redeem->user_uuid,$redeem->id])}}" >Approve</a>
                                        @elseif(empty($redeem->ribbon_notified))
                                        <!-- <a class="dropdown-item" href="{{route('admin.auth.ribbon_notified.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Rybbon Notified</a> -->
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="clickdata('    {{route('admin.auth.ribbon_notified.redeem_points',[$redeem->user_uuid,$redeem->id])}}')">Rybbon Notified</a>
                                        @elseif(empty($redeem->coupon_sent))
                                        <a class="dropdown-item" href="{{route('admin.auth.coupon_sent.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Coupon Send</a>
                                        @elseif(empty($redeem->coupon_redeemed))

                                        <a class="dropdown-item" href="{{route('admin.auth.coupon_redeem.redeem_points',[$redeem->user_uuid,$redeem->id])}}">Coupon Redeem</a>

                                        <a class="dropdown-item" href="{{route('admin.auth.coupon_elapsed',[$redeem->user_uuid,$redeem->id])}}">Coupon Lapsed</a>
                                        @endif
                                    </div>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="10" class="text-center">No matching records found</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        {{html()->form()->close()}}
        <div class="card-footer">
        </div><!--card-footer-->
    </div><!--card-->
    <div class="modal fade in bulkSearch" tabindex="-1" role="dialog" id="bulkSearch" aria-labelledby="inviteSetting-1" aria-hidden="true">
    <div class="modal-dialog modal-lg invite_setting_modal link_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Search By Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> <h3 class="modal-title"></h3>
            </div>
            <form action="{{ route('admin.auth.redeem_points') }}" method="post">
                @csrf
                <div class="modal-body invite_setting">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <span>Email Id</span>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email Id" required>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <button type ="submit" id="searchEmails" class="btn btn-primary" style="margin-right: 20px;" >Apply</button>
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

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <!-- For upload csv -->
    <script>
        $(document).ready(function(){
            $('#btn-upload').click(function(e){
                // e.preventDefault();
                // e.stopImmediatePropagation();
                // setTimeout(() => {
                //     $('#csv_file').focus();
                // }, 0);
                $('#csv_file').click();
            });
            $('#csv_file').on('change', function(){
                $('#btn-upload').hide();
                $('#btn-upload_save').show();


                $('#btn-upload_save').on('click', function(){
                
                if(($('#csv_file').val().slice((($('#csv_file').val().lastIndexOf(".") -1) >>> 0) + 2)).toLowerCase() === 'csv'){
                    $('#csvForm').submit();
					// alert('hi');
                }else{
                    swal('Only .csv files allowed ');
                    $('#btn-upload_save').hide();
                    $('#btn-upload').show();
                    
                }
            });

            });

        });
    </script>

    <script>
        $(document).ready(function() {
            new ClipboardJS('.btn-copy');
            var table = $('#redeem-request').DataTable({
                scrollX: true,
                serverSide: true,
                destroy: true,
                'processing': true,
                ajax: "{{ route('admin.auth.redeem.request.datatable') }}",
                columns: [
                    {
                        name: 'id',
                        'orderable': false,
                        searchable: false
                    },

                    { name: 'user_uuid', orderable:false},
                    { name: 'user.panellist_id', orderable:false},
                    { name: 'total_points' },
                    { name: 'redeem_points' },
					{ name: 'value', orderable: false, searchable:false }, // Priyanka 04-09-2024
                    /* { name: 'value', orderable: false, searchable:false,
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
                    }, */// Priyanka 04-09-2024
                    // { name: 'redeem_method' },
                    { name: 'requestStatus' , orderable: false, searchable:false },
                    { name: 'device_type', orderable: false, searchable: false },
                    { name: 'show_status' },
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

                "rowCallback": function(row, data, index){
                    console.log("inside"+data[8]);
                  if (data[8] == 'Redemption Requested') {
                    // jQuery(row).css("background-color", "#000000");
                     jQuery(row).children('td').css("font-weight", "bolder");
                  }
               }
            });
            $("#searchEmail").keyup(function(){
               // alert();
                table.draw();
            });
            $(".dataTables_wrapper").css("width","100%");
            $(document).on('change', '#select-all', function(event) {
                $table_body = $(document).find('#redeem-request > tbody');
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

            $(document).on('change', '#select-all-search', function(event) {
                $table_body = $(document).find('#redeem-request-search > tbody');
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

        function toFixedTrunc(x, n) {
        const v = (typeof x === 'string' ? x : x.toString()).split('.');
        if (n <= 0) return v[0];
        let f = v[1] || '';
        if (f.length > n) return `${v[0]}.${f.substr(0,n)}`;
        while (f.length < n) f += '0';
        return `${v[0]}.${f}`
        }

        $('#downloadRybbonCsv').click(function(){
            var redeemIds = new Array();
            $("input[name='id[]']:checked").each(function() {
                redeemIds.push($(this).val());
            });
 
            if($.isEmptyObject(redeemIds)) {
               alert('Please select redeem request.');
            }else {
                window.location = "{{ route('admin.auth.redeem.export-data') }}"+'?exportIds='+redeemIds;
            }
           
        });
    </script>
    <!-- Sweet alert -->
    <script>
        function clickdata(redirectUrl){
                //alert();
            swal({
                title: "If you have sent mail to Rybbon?",
                // --------------^-- define html element with id
                width: '600px',
                customClass: 'swal-wide',
                //type: "error",
                showCancelButton: true,
                confirmButtonColor: "#1080d0",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                cancelButtonColor: "#ed5565",
                closeOnConfirm: false,
            })
                .then((result) => {
                    if (result.value) {
                        window.location = redirectUrl;
                        // For more information about handling dismissals please visit
                        // https://sweetalert2.github.io/#handling-dismissals
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        
                    }
                })
        }

    </script>
@endpush
