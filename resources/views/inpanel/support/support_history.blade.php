@extends('inpanel.layouts.app')

@section('content')
<div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.user.support.history_heading')}}</h5>
                    </div>
                    <div class="ibox-content">
                        
                        <div class="project-list referral_details">
                            <div class="table-responsive">
                            <table class="table" id="tableData">
                                <thead>
                                    <tr>
                                        <th>{{__('inpanel.user.support.support_history_title1')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title2')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title3')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title4')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title5')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title6')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title7')}}</th>
                                        <th>{{__('inpanel.user.support.support_history_title8')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @forelse($supportHistory as $result)
                                @php
                                
                                $createdDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->created_at)->setTimezone($userTimezone)->format('d M Y H:i:s'); 
                                if($result->updated_at){
                                    $updatedDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result->updated_at)->setTimezone($userTimezone)->format('d M Y H:i:s');
                                }else{
                                    $updatedDate = '';
                                }
                                
                               
                                @endphp
                                    <tr>
                                        <td>
                                            <a href="{{route('inpanel.user.support.chatshow',$result->id)}}"><u>{{$result->id}}</u></a>
                                        </td>
                                        
                                        <td class="project-status">
                                        <a href="{{route('inpanel.user.support.chatshow',$result->id)}}">{{$result->project_code}} </a>
                                        </td>
                                        <td> 
                                            {{--$result->project_code--}}
                                            {{$result->subject}}
                                        </td>
                                        <td> 
                                            {{$result->message}}
                                        </td>
                                        <td> 
                                            {{$createdDate}}
                                        </td>
                                        <td> 
                                            {{$updatedDate}}
                                            
                                        </td>
                                        <td>@if($result->status==0)<span class="btn-sm btn-success" style="cursor:pointer;">{{__('inpanel.user.support.button1')}}</span>@else<span style="cursor:pointer;" class="btn-sm btn-danger">{{__('inpanel.user.support.button2')}}</span>@endif</td>
                                        <td >@if($result->status==1 || $result->status==3)<span class="btn-sm btn-success" style="cursor:pointer;" onclick="changeStatus('{{$result->id}}',0)">{{__('inpanel.user.support.button3')}}</span>@else <span></span> @endif</td>
                                    </tr>
                                    @empty
                                         {{__('inpanel.user.support.no_history')}}
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

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
            $('#tableData').DataTable({
                ordering: false,
               // serverSide: false,
               // stateSave: true,
               // destroy: true,
                //'processing': true,
               // dom: 'Bfrtip',
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],

                 "oLanguage": {
                "sEmptyTable": "{{__('inpanel.invite.myreferrals.index.no_referrals')}}",
                "sLengthMenu":    "{{__('inpanel.invite.myreferrals.index.InfoEmpty1')}}",
                "sInfo":          "{{__('inpanel.invite.myreferrals.index.InfoEmpty')}}",
                "sInfoEmpty":     "{{__('inpanel.invite.myreferrals.index.InfoEmpty')}}",
             "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
             "sZeroRecords":   "No se encontraron resultados",
                "sSearch":        "{{__('inpanel.invite.myreferrals.index.search')}}:",
                "oPaginate": {
            "sFirst":    "{{__('inpanel.invite.myreferrals.index.sFirst')}}",
            "sLast":    "{{__('inpanel.invite.myreferrals.index.sLast')}}",
            "sNext":    "{{__('inpanel.invite.myreferrals.index.sNext')}}",
            "sPrevious": "{{__('inpanel.invite.myreferrals.index.sPrevious')}}"
            },
                },
            
                // buttons: [
                //     'excel', 'csv'
                // ],
            });
        });

    function changeStatus(supportId,statusData){
        //alert(supportId);
        $.ajax({
            /* the route pointing to the post function */
            url: "{{route('inpanel.user.support.changeStatus')}}",
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: "{{ csrf_token() }}", supportId : supportId ,statusData:statusData},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (response) { 
                console.log(response.status);
                try{
                    if (response.status === 200) {
                        // swal('Fraud action successfully');

                        // swal({title: "Good job", text: "Fraud action successfully", type: "success"}).then(function(){ location.reload();});
                        location.reload();
                    }
                }catch(error){
                    swal({text: "Some error occure!", type: "error"});
                } 
            }
        });
    }
    </script>
    
@endpush
@endsection