@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | Award Template History')

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="card-title mb-0">
                    Award <small class="text-muted">Template History</small>
                </h4>
            </div>


        </div>
        <!-- <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#preview_template_Modal">Preview</span> -->
        <hr>

        <!-- <form method="get" id="filterdata">
            @csrf -->
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <span>Reward Invitation Templates</span>
                    <select name="templates_id" id="templates_id" class="form-control">
                        <option value="" selected>Select Template</option>
                        @foreach($templates as $tempId => $tempName)
                        <option value="{{ $tempId }}">{{ $tempName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <span>Country</span>
                    <select name="country_code" id="country_code" class="form-control">
                        <option value="" selected>Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->country_code }}">{{ $country->country_code }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <span>Start Date</span>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <span>End Date</span>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
            </div>

            <!-- <div class="col-sm-3">
                    <div class="form-group">
                        <span>Award Month</span>
                        <input type="month" name="award_month" id="" value="{{(isset($_GET['award_month']))?$_GET['award_month']:''}}" class="form-control">
                    </div>
                </div> -->
            <div class="col-sm-2">
                <div class="form-group">
                    <!-- @if(!empty($_GET))
                        <span class="btn btn-sm btn-light clear_filter" style="margin-top: 24px;">Clear</span>
                        @endif -->
                    <span class="btn btn-sm btn-light clear_filter" style="margin-top: 24px;display:none;">Clear</span>
                    <button type="button" class="btn btn-sm btn-info apply_filer" style="margin-top: 24px;">Filter</button>
                </div>
            </div>
        </div>
        <!-- </form> -->

        <div class="col-sm-1"></div>
        <?php /*
        <div class="col-sm-3">
            <div class="form-group">
                <span>Time Period</span>
                <select name="timeperiod" id="timeperiod" class="form-control">
                    <option value="">Select Time Period</option>
                    <option value="30" selected>last 30 days</option>
                    <option value="60" @if( isset($_GET['timeperiod']) && $_GET['timeperiod']=='60' ){ selected } @endif>last 60 days</option>
                    <option value="90" @if( isset($_GET['timeperiod']) && $_GET['timeperiod']=='90' ){ selected } @endif>last 90 days</option>

                </select>
            </div>
        </div>
        */ ?>
    </div>
    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive p-3" style="overflow-x: auto;">
                <table class="table w-100 nowrap" id="user_management">
                    <thead>
                        <tr>
                            <th>Panellist Id</th>
                            <th>Template Name</th>
                            <th>Country</th>
                            <th>Preview</th>
                            <th>Send At</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div><!--col-->
    </div><!--row-->
</div><!--card-body-->
</div><!--card-->
@endsection



<!-- Modal -->
<div class="modal fade" id="preview_template_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="content preview_body">

                </div>
            </div>
        </div>
    </div>
</div>


@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
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
    localStorage.clear();
    var table = $('#user_management').DataTable({
        processing: true,
        serverSide: true,
        ajax: {

            url: "{{ route('admin.auth.reward.template_history.dtable') }}",
            data: function(d) {
                d.templates_id = $('#templates_id').val();
                d.country_code = $('#country_code').val();
                d.start_date = $('#start_date').val();
                d.end_date = $('#end_date').val();
            }
        },
        columns: [{
                data: 'panellist_id',
                name: 'panellist_id'
            },
            {
                data: 'template_name',
                name: 'template_name'
            },
            {
                data: 'country_code',
                name: 'country_code'
            },
            {
                data: 'preview',
                name: 'preview',
                orderable: false,
                searchable: false
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ],
        order: [
            [4, 'desc']
        ], // Sort by date
        dom: 'frtip',
        pageLength: 20,
        // buttons: ['excel', 'csv'],
        scrollX: true,
    });
    $(document).ready(function() {
        $(".dataTables_wrapper").css("width", "100%");
    })



    // $('#timeperiod').change(function() {
    //     $('#filterdata').submit();
    // });

    $(document).on('click', '.clear_filter', function() {
        $location = window.location;
        window.location.href = $location.origin + $location.pathname;
    });

    // $(document).on('focus', '.city_state_input', function() {
    //     $('.city_state_btn').addClass('d-none');
    //     $(this).closest('form').find('.city_state_btn').removeClass('d-none')
    // })

    $(document).on('click', '.preview_eye', function() {
        $('#preview_template_Modal').modal('show')

        let history_link = $(this).attr('data-history_link');

        $.ajax({
            url: history_link,
            method: 'get',
            success: function(response) {
                if ((response.content).length > 0) {
                    $('#exampleModalLabel').html(response.subject)
                    $('.preview_body').html(response.content)
                } else {
                    $('#preview_template_Modal').modal('hide')
                }
            }
        })

    })

    $(document).on('click', '.btn-close', function() {
        $('#preview_template_Modal').modal('hide')
    })

    $(document).on('click', '.apply_filer', function() {
        $('.clear_filter').show()
        table.ajax.reload();
    })

    $(document).on('click','#export_csv',function() {
        let templates_id = $('#templates_id').val();
        let country_code = $('#country_code').val();
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let search = $('#user_management_filter input').val();

        let url = "{{ route('admin.auth.reward.template_history.dtable') }}" +
            `?templates_id=${templates_id}&country_code=${country_code}` +
            `&start_date=${start_date}&end_date=${end_date}&search=${search}&export=1`;

        window.location.href = url;
    });
</script>
@endpush