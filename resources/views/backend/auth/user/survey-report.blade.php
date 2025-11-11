@php
use App\Models\Auth\User;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.survey'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

           <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    <small class="text-muted"> Survey Report</small>
                </h4>
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
            $('#user_management').DataTable({
                serverSide: false,
                stateSave: true,
                destroy: true,
                'processing': true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100,'All'],
                ],
                buttons: [
                    'excel', 'csv'
                ],
            });
            $(".dataTables_wrapper").css("width","100%");
        } );


        $('#timeperiod').change(function() {
        $('#filterdata').submit();
       });  
    </script>
@endpush
