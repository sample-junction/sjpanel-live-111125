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
                            Survey Reconcilation Rejection History
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
                        <th>@lang('inpanel.nav.label.ID')</th>
                        <th>Survey Number</th>
                        <th>@lang('inpanel.nav.label.panelist_id')</th>
                        <th>Subject</th>
                        <th>Survey Points</th>
                        <th>Survey CPI</th>
                        <th>Survey Loi</th>
                        <th>Survey Topic</th>
                        <th>Date of Rejection</th>
                    </tr>
                    </thead>
                    <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$data->survey_code}}</td>
                                    <td>{{$data->panelist_id}}</td>
                                    <td>{{$data->campaign_subject}}</td>
                                    <td>{{ ($data->campaign_amount * 1000) }} points</td>
                                    <td>{{ $data->campaign_amount }}</td>
                                    <td> @if(isset($data->survey_loi))
                                            {{$data->survey_loi}} Minutes
                                        @endif
                                    </td>
                                    <td>{{$data->survey_topic}}</td>
                                    <td>{{$data->created_at}}</td>
                                </tr>

                                @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--card-->
    @include('backend.auth.campaign.campaign_history_model')
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .th-td-hide{
            display:none;
        }
    </style>

@endpush
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:eq(6))'
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':not(:eq(6))'
                    }
                }
            ],
            "ordering": false,
        });
        $(".dataTables_wrapper").css("width","100%");

        $('.camp_temp').on('click',function(){
            var body_content=$(this).data('content');
            $('#content').html(body_content);
            var button=$(this).data('button');
            $('#button_text_p').html(button);
        });
    });
    
</script>
    
@endpush
