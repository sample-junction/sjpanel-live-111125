@extends('backend.layouts.app')
@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="card-title mb-0">
                        Conversion <small class="text-muted"> Rate</small>
                    </h4>
                </div><!--col-->
            </div><hr>
            <form method="get" id="filterdata">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <span>From Date</span>
                            <input type="date" name="fromDate" id="fromDate" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <span>To Date</span>
                            <input type="date" name="toDate" id="toDate" value="{{(isset($_GET['toDate']))?$_GET['toDate']:''}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <span>Select Country</span>
                            <select name="country" id="country" class="form-control">
                                <option value="" selected disabled>Select Country</option>
                                <option value="IN" {{ (isset($_GET['country']) && $_GET['country'] == 'IN') ? 'selected' : '' }}>India</option>
                                <option value="US" {{ (isset($_GET['country']) && $_GET['country'] == 'US') ? 'selected' : '' }}>United States of America</option>
                                <option value="CA" {{ (isset($_GET['country']) && $_GET['country'] == 'CA') ? 'selected' : '' }}>Canada</option>
                                <option value="UK" {{ (isset($_GET['country']) && $_GET['country'] == 'UK') ? 'selected' : '' }}>United Kingdom</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                            </div>
                            <div class="col-sm-8 form-group">
                                <button type="button" class="btn btn-sm btn-info" id="btn-clear-filter" style="margin-top: 24px;">Clear Filter</button>
                            </div>
                        </div>
                    </div>     
                </form>
                <div class="col-sm-1"></div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Time Period</span>
                        <select name="timeperiod" id="timeperiod" class="form-control">
                            <option value="">Select Time Period</option>
                            <option value="30" @if( isset($timePeriod) && $timePeriod == '30'){ selected } @endif>last 30 days</option>
                            <option value="60" @if( isset($timePeriod) && $timePeriod == '60'){ selected } @endif>last 60 days</option>
                            <option value="90" @if( isset($timePeriod) && $timePeriod == '90'){ selected } @endif>last 90 days</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table" id="user_management">
                            <thead>
                            <tr>
                                <th>Completed Survey</th>
                                <th>Attempted Survey</th>
                                <th>Conversion Rate(%)</th>                            
                            </tr>
                            </thead>
                            @php
                                $CCR = ($trafficStats['totalAttemptedSurveys'] > 0) 
                                    ? ($trafficStats['totalCompletedSurveys'] / $trafficStats['totalAttemptedSurveys']) * 100 
                                    : 0;
                            @endphp
                            <tbody>
                                <tr>
                                    <td>{{ $trafficStats['totalCompletedSurveys'] }}</td>
                                    <td>{{ $trafficStats['totalAttemptedSurveys'] }}</td>
                                    <td>{{ number_format($CCR, 2) }}</td>
                                </tr>
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            let table = $('#user_management').DataTable(); // Initialize DataTable

            $(".dataTables_wrapper").css("width", "100%");

            let today = new Date().toISOString().split("T")[0]; 
            
            $("#fromDate, #toDate").attr("max", today);

            $("#fromDate").on("change", function () {
                let fromDate = $(this).val();
                $("#toDate").attr("min", fromDate); 
                
                if ($("#toDate").val() && $("#toDate").val() < fromDate) {
                    $("#toDate").val("").change();
                    $("#toDate").val(""); // Clear value
                    $("#toDate").attr("type", "text").attr("type", "date");
                }
            });

            // Filter form submit using AJAX
            $(document).off("submit", "#filterdata").on("submit", "#filterdata", function(e) {
                e.preventDefault(); // Prevent default form submission
                let formData = $(this).serialize(); // Get form data
                let filterBtn = $('button[type="submit"]');
                $.ajax({
                    url: "{{ route('admin.auth.reports.conversionRate') }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        console.log('response-->',response); // Debugging: Check what is returned

                        if (response.totalCompletedSurveys !== undefined) {
                            table.clear().destroy(); // Clear and destroy DataTable
                            $('#user_management tbody').html(`
                                <tr>
                                    <td>${response.totalCompletedSurveys}</td>
                                    <td>${response.totalAttemptedSurveys}</td>
                                    <td>${(response.totalAttemptedSurveys > 0) ? ((response.totalCompletedSurveys / response.totalAttemptedSurveys) * 100).toFixed(2) : 0}</td>
                                </tr>
                            `);
                            table = $('#user_management').DataTable(); // Reinitialize DataTable
                        } else {
                            console.log("No data found for selected date range.");
                        }
                    },
                    error: function() {
                        console.log("Something went wrong! Please try again.");
                    },
                    complete: function() {
                        filterBtn.prop('disabled', false); // Re-enable filter button after request completes
                    }
                });
            });

            // Time period change event
            $('#timeperiod').change(function() {
                $('#filterdata').submit();
            });

            // Clear Filter button functionality
            $('#btn-clear-filter').click(function() {
                window.location.reload(); // Reload the page to reset filters
            });
        });
    </script>

@endpush