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
                    Survey <small class="text-muted"> Participation</small>
                </h4>
            </div><!--col-->
        </div><hr>
        <form action="{{route('admin.auth.reports.survey_participation')}}" method="get" id="filterdata">
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
                    <span>Select Country</span>
                    <select name="country" id="country" class="form-control">
                        <option value="" selected disabled>Select Country</option>
                        <option value="all" {{ (isset($country) && $country == 'all') ? 'selected' : '' }}>All Countries</option>
                        <option value="IN" {{ (isset($country) && $country == 'IN') ? 'selected' : '' }}>India</option>
                        <option value="US" {{ (isset($country) && $country == 'US') ? 'selected' : '' }}>United States of America</option>
                        <option value="CA" {{ (isset($country) && $country == 'CA') ? 'selected' : '' }}>Canada</option>
                        <option value="UK" {{ (isset($country) && $country == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                    </select>
                    </div>
                </div>
                <div class="col-sm-4 d-flex align-items-end" style="gap: 10px; margin-top: 24px;">
                    <button id="filterBtn" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.auth.reports.survey_participation') }}" id="clearFilterBtn" class="btn btn-secondary">Clear Filter</a>
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
                    <table class="table" id="survey_participation_table">
                        <thead>
                        <tr>
                            <th>First Name</th> 
                            <th>Panelist ID</th>
                            <th>Survey ID</th>
                            <th>Respondent ID</th>
                            <th>Channel Name</th>
                            <th>Survey Status</th> 
                            <th>Respondent Status</th>
                            <th>Approved Status</th>
                            <th>Survey Attempted Date</th>
                            <th>Survey Incentive Amount</th> 
                            <th>Incenvite credit date</th>                            
                            <th>Unsubscribed</th>                            
                            <th>Blacklisted</th>                            
                            <th>Deactivated</th>                            
                            <th>Deleted</th>                             
                            <th>Platform</th>                             
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
            var table = $('#survey_participation_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.auth.reports.survey_participation') }}",
                    type: "GET",
                    data: function(d) {
                        d.fromDate = $('#fromdatefield').val();
                        d.toDate = $('#todatefield').val();
                        d.timeperiod = $('#timeperiod').val();
                        d.country = $('#country').val();
                        if (d.export) {
                            d.length = -1; // Get all records
                        }
                    }
                },
                dom: 'Bfrtip',
                order: [[7, 'desc']], // Sort by Survey Attempted Date by default
                lengthMenu: [
                    [25, 50, 100, -1],
                    [25, 50, 100, 'All'],
                ],
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn btn-sm btn-info',
                        action: function(e, dt, button, config) {
                            let table = $('#survey_participation_table').DataTable();
                            let order = table.order();
                            
                            // Get current filter values
                            let fromDate = $('#fromdatefield').val();
                            let toDate = $('#todatefield').val();
                            let timeperiod = $('#timeperiod').val();
                            let country = $('#country').val();
                            let search = table.search();
                            let orderColumn = order[0][0];
                            let orderDir = order[0][1];
                            
                            // Build export URL with all parameters
                            let url = "{{ route('admin.auth.reports.survey_participation.export') }}";
                            url += `?fromDate=${fromDate}&toDate=${toDate}&timeperiod=${timeperiod}&country=${country}`;
                            url += `&search=${encodeURIComponent(search)}`;
                            url += `&order_column=${orderColumn}&order_dir=${orderDir}`;
                            url += `&format=excel`;
                            
                            window.location.href = url;
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn btn-sm btn-info',
                        action: function(e, dt, button, config) {
                            let table = $('#survey_participation_table').DataTable();
                            let order = table.order();
                            
                            // Get current filter values
                            let fromDate = $('#fromdatefield').val();
                            let toDate = $('#todatefield').val();
                            let timeperiod = $('#timeperiod').val();
                            let country = $('#country').val();
                            let search = table.search();
                            let orderColumn = order[0][0];
                            let orderDir = order[0][1];
                            
                            // Build export URL with all parameters
                            let url = "{{ route('admin.auth.reports.survey_participation.export') }}";
                            url += `?fromDate=${fromDate}&toDate=${toDate}&timeperiod=${timeperiod}&country=${country}`;
                            url += `&search=${encodeURIComponent(search)}`;
                            url += `&order_column=${orderColumn}&order_dir=${orderDir}`;
                            
                            window.location.href = url;
                        }
                    }
                ],
                columns: [
                    { data: 'first_name', name: 'first_name' },
                    { data: 'panelist_id', name: 'panelist_id' },
                    { data: 'project_code', name: 'project_code' },
                    { data: 'RespID', name: 'RespID' },
                    { 
                        data: 'channel_id', 
                        name: 'channel_id',
                        render: function(data) {
                            return data == 1 || data == 0 ? 'Dashboard' : (data == 2 ? 'Email' : '');
                        }
                    },
                    { 
                        data: 'status_name', 
                        name: 'status_name',
                        render: function(data) {
                            return data ? data.charAt(0).toUpperCase() + data.slice(1).toLowerCase() : 'Abandon';
                        }
                    },
                    { 
                        data: 'resp_status_name', 
                        name: 'resp_status_name',
                        render: function(data) {
                            return data ? data.charAt(0).toUpperCase() + data.slice(1).toLowerCase() : 'Abandon';
                        }
                    },
                    {
                        data: 'approval_status',
                        name: 'approval_status',
                        render: function(data, type, row) {
                            let approvedStatus = '-';

                            if (row.approval_status == 50) {
                                approvedStatus = 'Approved';
                            } else if (row.approval_status == 5) {
                                approvedStatus = 'Rejected';
                            } else {
                                approvedStatus = 'Pending';
                            }

                            return approvedStatus;
                        }
                    },
                    { 
                        data: 'started_at', 
                        name: 'started_at',
                        render: function(data) {
                            return data ? moment(data).format('YYYY MMM DD HH:mm:ss') : '';
                        }
                    },
                    { 
                        data: 'cpi', 
                        name: 'cpi',
                        render: function(data, type, row) {
                            return row.proj_cpi ? (row.proj_cpi * 1000) : (data ? (data * 1000) : 0);
                        }
                    },
                    { 
                        data: 'started_at', 
                        name: 'credit_date',
                        render: function(data, type, row) {
                            if (row.approval_status == 50) {
                                return data ? moment(data).format('YYYY MMM DD') : '';
                            }
                            return '';
                        }
                    },
                    {
                        data: 'unsubscribed',
                        name: 'unsubscribed'
                    },
                    {
                        data: 'is_blacklist',
                        name: 'is_blacklist'
                    },
                    {
                        data: 'deactivate',
                        name: 'deactivate'
                    },
                    {
                        data: 'deleted_at',
                        name: 'deleted_at'
                    },
                    { data: 'device_type', name: 'device_type' },
                ],
                initComplete: function() {
                    setupDateValidation();
                }
            });
        // Filter button
        $('#filterBtn').on('click', function () {
            table.ajax.reload();
        });

        // Clear Filter
        $('#clearFilterBtn').on('click', function (e) {
            e.preventDefault();
            $('#fromdatefield').val('');
            $('#todatefield').val('');
            $('#timeperiod').val('');
            $('#country').val('');
            
            // Reload the full page
            location.reload();
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
                    alert('End date cannot be before start date');
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
@endpush