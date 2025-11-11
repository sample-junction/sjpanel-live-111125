@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('campaign_history'))

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
                            Campaign Master
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="row">
                <table class="table table-striped table-hover" id="campaign_history" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Campaign Name</th>
                        <th>Type</th>
                        <th>Campaign Start Date</th>
                        <th>Campaign Status</th>
                        <th>No Of Panelist</th>
                        <th>Panelist Details</th>
                    </tr>
                    </thead>
                    <tbody>
                               @foreach($datas as $data)
                                @php 
                                    if($data->campaign_status == 1){
                                        $campaign_status = "Active";
                                     }elseif($data->campaign_status == 0){
                                        $campaign_status = "Deactive";
                                     }else{
                                        $campaign_status = "";
                                     }
                                @endphp
                               <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->campaign_name}}</td>
                                    <td>{{$data->type}}</td>
                                    <td>{{$data->campaign_start_date}}</td>
                                    <td>{{$campaign_status}}</td>
                                    <td>{{$data->panelist_count}}</td>
                                    <td><a href="{{ route('admin.auth.show-campaign-history',['id'=>$data->id,'c_type'=>$data->template_type]) }}"><i class="fa fa-eye" style="font-size:25px;"></i></a></td>
                                </tr>
                               @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--card-->

@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
    <style>
        .th-td-hide{
            display:none;
        }
    </style>

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

    <script>
    $(document).ready(function() {
        $('#campaign_history').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            search: {
                regex: true,
                caseInsensitive: false
            },
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            buttons: [
                'excel', 'csv'
            ],
            "ordering": false,
        });
        $(".dataTables_wrapper").css("width","100%");
    });
</script>
    
@endpush
