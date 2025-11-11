@extends('backend.layouts.app')

@push('after-styles')
<style type="text/css">
    .btn-group .btn-info{
        display: none !important;
    }
    .btn-group .btn-primary{
        display: none !important;
    }
    /*.btn-group .show .dropdown-item{
        display: none !important;
    }*/
    .btn-group .dropdown-menu a.dropdown-item:nth-child(2),
    .btn-group .dropdown-menu a.dropdown-item:nth-child(3),
    .btn-group .dropdown-menu a.dropdown-item:nth-child(4) {
        display: none !important;
    }
    .frau_use_email{
        display: none !important;
    }
    .td-th-hide{
        display:none;
    }
    
/*    .dataTables_filter{
        display: block !important;
    }*/
</style>
@endpush

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.panelist_management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')

@if(session('message'))
    {{ session('message') }}
@endif

<div class="card mt-2">
    <div class="card-header">
        Feasibility
    </div>
    <div class="card-body">
      <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-header bg-primary">
                   Get Feasibility Info
                </div>
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-2">
                            <label for="">Quota ID</label>
                           <div class="form group">
                            <input type="text" class="form-control">
                           </div>

                        </div>
                        <div class="col-3">
                           <label for="">Country</label>
                           <div class="form group">
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                           </div>
                        </div>
                        <div class="col-2">
                        <label for="">Language</label>
                           <div class="form group">
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                           </div>
                        </div>
                        <div class="col-2">
                        <label for="">Device</label>
                        <div class="form group">
                            <select name="" id="" class="form-control">
                                <option value="">1</option>
                                <option value="">1</option>
                            </select>
                           </div>
                        </div>
                        <div class="col-3">
                            <label for="" class="mt-2"></label>
                            <div class="form-group" style="margin-top:12px;">
                            <span class="btn btn-success">Criteria</span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary">Check Feasibility</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
      </div>
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
    

@endpush
