@extends('inpanel.layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content animated fadeInUp">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{__('inpanel.invite.myreferrals.index.heading')}}</h5>
                    </div>
                    <div class="ibox-title">
                        <span style="font-size: 15px;font-weight: 500;"><strong>{{__('inpanel.invite.myreferrals.index.content_title_1')}}</strong> {{__('inpanel.invite.myreferrals.index.content_title_2')}}</span>

                    </div>
                    <div class="ibox-content">
                        <!-- <div class="row m-b-sm m-t-sm search_referral">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fas fa-sync"></i> {{__('inpanel.invite.myreferrals.index.refresh')}}</button>
                            </div>
                            <div class="col-md-11">
                                <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                <button type="button" class="btn btn-sm btn-primary"> {{__('inpanel.invite.myreferrals.index.button_go')}}</button> </span></div>
                            </div>
                        </div> -->
                        <div class="project-list referral_details">
                            <div class="table-responsive">
                            <table class="table" id="tableData">
                                <thead>
                                    <tr>
                                        <th>{{__('inpanel.invite.myreferrals.index.heading_name')}}</th>
                                        <th>{{__('inpanel.invite.myreferrals.index.heading_email')}}</th>
                                        <th>{{__('inpanel.invite.myreferrals.index.heading_status')}}</th>
                                        {{--<th>Points</th>--}}
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($myreferrals as $referral)
                                @php
                                $user=Auth::user();
                                // $user->timezone;
                                //date_default_timezone_set("America/New_York", 'UTC'));
                                 $here = \Carbon\Carbon::parse($referral['created_at']);
                                
                                $there = \Carbon\Carbon::now($user->timezone);
                                 $newDate= date('m/d/Y H:i:s',strtotime("$here UTC"));
                                $result = \Carbon\Carbon::createFromFormat('m/d/Y H:i:s', $newDate)->diffForHumans();
                               //echo $newDate->diffForHumans();
                               //echo $here . PHP_EOL;
                               // echo $there . PHP_EOL;

                                $here->subSeconds($here->offset - $there->offset);
                                //echo $here->diffForHumans() . PHP_EOL;
                                @endphp
                                    <tr>
                                        <td class="project-title">
                                            <a href="javascript:void(0);">{{$referral['name']}}</a>
                                            <br/>
                                            <small>{{__('inpanel.invite.myreferrals.index.joined')}} 
                                                {{-- $referral['created_at']->diffForHumans() --}}
                                                {{$result}}

                                            </small>
                                        </td>
                                        <td>{{$referral['email']}}</td>
                                        @if($referral['status']=='pending')
                                        <td class="project-status">
                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="User hasn't filled at least one survey yet. You can expect {{$referral['points']}} points out of this">{{$referral['status']}}</button>
                                        </td>
                                        @else
                                        <td class="project-status">
                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="User has completed at least one survey yet. out of this you got {{$referral['points']}} Points">{{$referral['status']}}</button>
                                        </td>
                                        @endif
                                        {{--<td> <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" >{{$referral['points']}} {{__('inpanel.invite.index.points')}}</button>
                                       </td>--}}
                                    </tr>
                                    @empty
                                        {{--__('inpanel.invite.myreferrals.index.no_referrals')--}}
                                    @endforelse
                                </tbody>
                            </table>
                            </div>
                            <!-- <table class="table table-hover" id="tableData">
                                <tbody>
                                @forelse($myreferrals as $referral)
                                    <tr>
                                        <td class="project-title">
                                            <a href="javascript:void(0);">{{$referral['name']}}</a>
                                            <br/>
                                            <small>{{__('inpanel.invite.myreferrals.index.joined')}} {{ $referral['created_at']->diffForHumans() }}</small>
                                        </td>
                                        <td class="project-status">
                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="User hasn't filled at least one survey yet. You can expect 100 points out of this">{{__('inpanel.invite.myreferrals.index.button_pending')}}</button>
                                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="User hasn't filled at least one survey yet. You can expect 100 points out of this">{{$referral['points']}} {{__('inpanel.invite.index.points')}}</button>
                                        </td>
                                    </tr>
                                @empty
                                    {{--__('inpanel.invite.myreferrals.index.no_referrals')--}}
                                @endforelse
                                </tbody>
                            </table> -->
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
                serverSide: false,
                stateSave: true,
                destroy: true,
                'processing': true,
               // dom: 'Bfrtip',
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
                "oLanguage": {
                "sEmptyTable": "{{__('inpanel.invite.myreferrals.index.no_referrals')}}",
                "sLengthMenu":    "{{__('inpanel.invite.myreferrals.index.InfoEmpty1')}}",
                "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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
    </script>
@endpush
