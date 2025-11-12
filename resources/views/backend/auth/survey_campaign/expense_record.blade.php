@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('Expenses Record History'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 mb-5">
                <h4 class="card-title mb-0">{{__('Expenses Record History')}}
                
                </h4>
            </div><!--col-->
            
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table  table-striped table-hover" id="expense_table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>User_id</th>
                            <th>Source</th>
                            <th>Type</th>
                            <th>Bonus Points</th>
                            <th>Date</th>                           
                        </tr>
                        </thead>
                        <tbody>
                           @if(isset($datas))
                           @foreach($datas as $data)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                 <td>{{$data->user_id}}</td> 
                                 <td>{{$data->source}}</td>
                                <td>{{$data->type}}</td>
                                <td>{{$data->point}}</td>
                                <td>{{$data->created_at}}</td>       
                            </tr>
                            @endforeach
                            @endif                           
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
    
    <script>
    $(document).ready(function() {
        $('#expense_table').DataTable({
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
            buttons:[
            {
                extend: 'excel'
                
            },
            {
                extend: 'csv'

            }
        ],
            "ordering": true,
        });
        $(".dataTables_wrapper").css("width","100%");
    });
</script>
   
@endpush
