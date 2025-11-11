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
                    Panelist <small class="text-muted"> Survey Report</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <form action="{{route('admin.auth.reports.survey')}}" method="get" id="filterdata">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>From Date</span>
                        <input type="date" name="fromDate" id="fromdatefield" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>To Date</span>
                        <input type="date" name="toDate" id="todatefield" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-3">
                <div class="form-group">
                    <span>Time Period</span>
                    <select name="timeperiod" id="timeperiod" class="form-control">
                        <option value="">Select Time Period</option>
                        <option value="30" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '30') selected @endif>last 30 days</option>
                        <option value="60" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '60') selected @endif>last 60 days</option>
                        <option value="90" @if( isset($_GET['timeperiod']) && $_GET['timeperiod'] == '90') selected @endif>last 90 days</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table" id="survey_report_table">
                        <thead>
                        <tr>
                            <th>@lang('labels.backend.access.users.table.uuid')</th> 
                            <th>@lang('labels.backend.access.users.table.panelistid')</th>
                            <th>Total Assign</th>
                            <th>Start</th>
                            <th>Complete</th>
                            <th>Terminate</th>
                            <th>Quotafull</th>
                            <th>Quality Terminate</th>
                            <th>Abandon</th>
                            <th>Rejected</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endpush

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            // Date range validation function
            function setupDateValidation() {
                const startDateInput = document.getElementById('fromdatefield');
                const endDateInput = document.getElementById('todatefield');
                
                // Get today's date in YYYY-MM-DD format
                const today = new Date();
                const dd = String(today.getDate()).padStart(2, '0');
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const yyyy = today.getFullYear();
                const todayFormatted = yyyy + '-' + mm + '-' + dd;

                // Set the max attribute for both date inputs to today's date
                startDateInput.setAttribute('max', todayFormatted);
                endDateInput.setAttribute('max', todayFormatted);
                
                // Function to get query parameter by name
                function getQueryParameter(name) {
                    const urlParams = new URLSearchParams(window.location.search);
                    return urlParams.get(name);
                }

                // Set initial values from URL parameters if they exist
                const urlFromDate = getQueryParameter('fromDate');
                const urlToDate = getQueryParameter('toDate');
                
                if (urlFromDate) {
                    startDateInput.value = urlFromDate;
                }
                
                if (urlToDate) {
                    endDateInput.value = urlToDate;
                    // Set min date for end date input if fromDate exists
                    if (urlFromDate) {
                        endDateInput.setAttribute('min', urlFromDate);
                    }
                }

                // Handle date changes
                startDateInput.addEventListener('change', function() {
                    const startDate = startDateInput.value;
                    if (startDate) {
                        endDateInput.setAttribute('min', startDate);
                        // If end date is before new min date, clear it
                        if (endDateInput.value && endDateInput.value < startDate) {
                            endDateInput.value = '';
                        }
                    } else {
                        endDateInput.removeAttribute('min');
                    }
                    table.ajax.reload(); // Reload data when date changes
                });

                endDateInput.addEventListener('change', function() {
                    table.ajax.reload(); // Reload data when date changes
                });
            }

            // Initialize DataTable with AJAX
            var table = $('#survey_report_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.auth.reports.survey') }}",
                    type: "GET",
                    data: function(d) {
                        d.fromDate = $('#fromdatefield').val();
                        d.toDate = $('#todatefield').val();
                        d.timeperiod = $('#timeperiod').val();
                    }
                },
                dom: 'Bfrtip',
                order: [[0, 'asc']], // Default sort by UUID
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, 'All'],
                ],
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-sm btn-info',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-sm btn-info',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                columns: [
                    { data: 'uuid', name: 'uuid' },
                    { data: 'panelist_id', name: 'panelist_id' },
                    { data: 'assignCount', name: 'assignCount' },
                    { data: 'startCount', name: 'startCount' },
                    { data: 'completesCount', name: 'completesCount' },
                    { data: 'terminatesCount', name: 'terminatesCount' },
                    { data: 'quotafullCount', name: 'quotafullCount' },
                    { data: 'quality_terminateCount', name: 'quality_terminateCount' },
                    { data: 'abandonsCount', name: 'abandonsCount' },
                    { data: 'rejectCount', name: 'rejectCount' },
                    { 
                        data: 'action', 
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                initComplete: function() {
                    setupDateValidation();
                }
            });

            // Handle filter form submission
            $('#filterdata').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // Handle time period change
            $('#timeperiod').change(function() {
                // Clear date inputs when time period is selected
                $('#fromdatefield').val('');
                $('#todatefield').val('');
                $('#todatefield').removeAttr('min');
                table.ajax.reload();
            });

            // Additional validation when form is submitted
            document.getElementById('filterdata').addEventListener('submit', function(e) {
                const startDate = $('#fromdatefield').val();
                const endDate = $('#todatefield').val();
                
                if (startDate && endDate && startDate > endDate) {
                    console.log('End date cannot be before start date');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
@endpush