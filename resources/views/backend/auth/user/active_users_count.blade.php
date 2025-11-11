@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | Active Panellist Count list ')

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                Active Panellist Count
                </h4>
            </div><!--col-->
        </div>
        <hr>
        <form method="get" id="" action="">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Country</span>
                        <select name="countries[]" id="countries" multiple="multiple"  class="form-control">
                            @if(!empty($countries))
                            @foreach($countries as $c_key => $c_name)
                            <option value="{{$c_key}}" {{ (isset($_GET['countries']) && in_array($c_key,$_GET['countries']))?'selected':'' }} >{{$c_key}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Months</span>
                        <select name="month" id="award" class="form-control">
                            <option value="" >Select Month</option>
                            @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ (isset($_GET['month']) && $i == $_GET['month'])?'selected':'' }}>{{ $i}} Months</option>
                            @endfor
                        </select>
                    </div>
                </div>


                <div class="col-sm-2">
                    <div class="form-group">
                        
                        <div class="add_btn">
                            <span class="btn btn-sm btn-light clear_filter" style="margin-top: 24px;">Clear</span>
                            <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;"> Apply </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

        <div class="col-sm-1"></div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive m-3" style="width: 98%;">
                <table class="table " id="user_management">
                    <thead>
                        <tr>
                            <th>Countries</th>
                            <th>Active panelists {{ !empty($_GET['month'])?"in last ".$_GET['month']." Months":'Count' }} </th>
                            
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($count_by_country as $country_code => $count)

                        <tr >
                            <td class="row_country_code" data-value="" >{{ $country_code }}</td>
                            <td class="row_award" >{{ $count }}</td>
                            
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!--card-body-->
</div><!--card-->
@endsection


@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .error{
        border: 1px solid red;
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    localStorage.clear();
    $(document).ready(function() {
        $('#user_management').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            'processing': true,
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            pageLength: 8,
            order: [
                [1, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0]
            }],
            buttons: ['excel', 'csv'],
        });
        $(".dataTables_wrapper").css("width", "100%");
    });


    $(document).on('click', '.clear_filter', function(){
        let url = window.location.origin + window.location.pathname;
        window.location.href = url;

    })

    $(document).ready(function() {
      $('#countries').select2({
        placeholder: 'Select countries',   
        allowClear: true,                 
        width: 'resolve'                 
      });
    });



</script>
@endpush