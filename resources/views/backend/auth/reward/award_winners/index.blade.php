@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

$total_amount_spend = 0;
@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | Award History')

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="card-title mb-0">
                    Award <small class="text-muted">History</small>
                </h4>
            </div>

            <div>
                <h5 class="mb-0">
                    <strong>Total Amount Spent:</strong>
                    <span id="total_amount_spent">$0.00</span>
                </h5>
            </div>
        </div>

        <hr>

        <form method="get" id="filterdata">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Country</span>
                        <select name="reward_country" id="reward_country" class="form-control">
                            <option value="" selected>Select Country</option>
                            @if(!empty($countries))
                            @foreach($countries as $country)
                            <option value="{{$country->country_code}}" {{ isset($_GET['reward_country']) && $_GET['reward_country'] == $country->country_code ? 'selected' : '' }}>{{$country->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group">
                        <span>Award Month</span>
                        <input type="month" name="award_month" id="" value="{{(isset($_GET['award_month']))?$_GET['award_month']:''}}" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        @if(!empty($_GET))
                        <span class="btn btn-sm btn-light clear_filter" style="margin-top: 24px;">Clear</span>
                        @endif
                        <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                    </div>
                </div>
            </div>
        </form>

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
                            <th>Name</th>
                            <th>Country</th>
                            <th>Award Name</th>
                            <th>Award Month</th>
                            <th>Nominations</th>
                            <th>Points</th>
                            <th>Amount</th>
                            <th>Dollar Value</th>
                            <th>City & State</th>
                            <th>Zip</th>
                            {{-- <th>DOI</th>
                            <th>Unsubscribe</th> --}}
                            <th>Redemption status</th>
                            <th>Redemption Date</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach($winners_list as $result)
                        @php
                        $userName='';
                        if(!empty($result->first_name)) $userName = \Crypt::decrypt($result->first_name).' ';
                        if(!empty($result->middle_name)) $userName .=\Crypt::decrypt($result->middle_name).' ';
                        if(!empty($result->last_name)) $userName .=\Crypt::decrypt($result->last_name);
                        $zipcode='';
                        if(!empty($result->zipcode)) $zipcode =\Crypt::decrypt($result->zipcode);

                        $dollar_amount = (!empty($result->dollar_amount) ? $result->dollar_amount : 0);
                        $total_amount_spend += $dollar_amount;

                        @endphp

                        <tr>
                            <td>{{ $result->panellist_id }}</td>
                            <td>{{ $userName }}</td>
                            <td>{{ $result->country_name }}</td>
                            <td>{{ $result->award_name }}</td>
                            <td>{{ $result->award_month }}</td>
                            <td>{{ $result->nominations }}</td>
                            <td>{{ $result->points }}</td>
                            <td>{{ $result->amount }}</td>
                            <td> {{ $dollar_amount }} </td>
                            <td>

                                <form action="{{ route('admin.auth.reward.history.city_state.post',$result->id) }}" method="POST" class="d-flex flex-column gap-1">
                                    @csrf
                                    <input type="text" name="city_state" value="{{($result->city_state)?$result->city_state:'' }}" class="form-control city_state_input">
                                    <input type="submit" class="btn btn-sm btn-info d-none city_state_btn" name="apply" value="Apply">
                                </form>

                            </td>
                            <td>{{ $zipcode }}</td>
                            {{-- <td>{{ ($result->confirmed=='1')?'Yes':'No' }}</td>
                            <td>{{ ($result->active=='1')?'Yes':'No' }}</td>
                            <td>{{ ($result->unsubscribed=='1')?'No':'Yes' }}</td> --}}
                            <td>{{ $result->redemption_status }}</td>
                            <td>{{ $result->redemption_at }}</td>

                            <td>
                                <a href="{{route('admin.auth.reward.history.delete', $result->id)}}" class="mr-2" onclick="return confirm('Are you sure you want to delete this reward?');"><i class='fa fa-trash' title="Delete"></i></a>
                                <a href="{{route('admin.auth.reward.history.edit', $result->id)}}" class="mr-2"><i class='fa fa-edit' title="Edit"></i></a>
                                @if(empty($dollar_amount))
                                <a href="{{route('admin.auth.reward.point_system.credit', $result->id)}}" onclick="return confirm('Do you want to credit the panalist points for {{ $result->panellist_id }} ?');"><i class="fas fa-credit-card" title="Card" style="color:#007bff;"></i></a>
                                @endif
                            </td>


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
    $(document).ready(function() {
        $('#user_management').DataTable({
            serverSide: false,
            stateSave: true,
            destroy: true,
            scrollX: true,
            autoWidth: true,
            responsive: false,
            'processing': true,
            dom: 'Bfrtip',
            // lengthMenu: [
            //     [25, 50, 100, -1],
            //     [25, 50, 100, 'All'],
            // ],
            pageLength: 8,
            order: [
                [4, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [12]
            }],
            buttons: ['excel', 'csv'],
        });
        $(".dataTables_wrapper").css("width", "100%");

        $('#total_amount_spent').html('${{ $total_amount_spend }}');
    });


    $('#timeperiod').change(function() {
        $('#filterdata').submit();
    });

    $(document).on('click', '.clear_filter', function() {
        $location = window.location;
        window.location.href = $location.origin + $location.pathname;
    });

    $(document).on('focus', '.city_state_input', function() {
        $('.city_state_btn').addClass('d-none');
        $(this).closest('form').find('.city_state_btn').removeClass('d-none')
    })
</script>
@endpush