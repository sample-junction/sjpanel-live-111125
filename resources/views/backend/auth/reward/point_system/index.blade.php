@php
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | Award Points System')

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                Award <small class="text-muted"> Points System</small>
                </h4>
            </div><!--col-->
        </div>
        <hr>

        <form method="post" id="" action="{{ route('admin.auth.reward.point_system.add') }}">
            @csrf
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Country</span>
                        <select name="country" id="country" class="form-control">
                            <option value="" selected>Select Country</option>
                            @if(!empty($countries))
                            @foreach($countries as $country)
                            <option value="{{$country->country_code}}" >{{$country->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Awards</span>
                        <select name="award_id" id="award" class="form-control">
                            <option value="" selected>Select Awards</option>
                            @if(!empty($award_type))
                            @foreach($award_type as $award)
                            <option value="{{$award->id}}" >{{$award->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Points</span>
                        <input type="text" name="points" id="points" value="" placeholder="Eg. 10000" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">
                        <span>Amount</span>
                        <input type="text" name="award_amount" id="amount" value="" placeholder="Eg. $35" class="form-control">
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group">

                        <div class="update_btn d-none">
                            <span class="btn btn-sm btn-light clear_filter" style="margin-top: 24px;">Cancel</span>
                            <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Update Points</button>
                        </div>

                        <div class="add_btn">
                            <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;"> Add Points </button>
                        </div>
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
            <div class="table-responsive">
                <table class="table" id="user_management">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Award Name</th>
                            <th>Points</th>
                            <th>Amount</th>
                            {{-- <th></th> --}}
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>

                        @foreach($country_award_points as $result)

                        <tr data-row_data="{{ $result->toJson() }}">
                            <td class="row_country_code" data-value="" >{{ $result->country_name }}</td>
                            <td class="row_award" >{{ $result->award_name }}</td>
                            <td class="row_award_points" >{{ $result->award_point }}</td>
                            <td class="row_amount" >{{ $result->award_amount }}</td>
                            
                            <td>
                                <a href="javascript:void(0);" class="mr-2 edit_btn"><i class='fa fa-edit' title="Edit"></i></a>
                                <a href="{{route('admin.auth.reward.point_system.delete', $result->id)}}" onclick="return confirm('Are you sure you want to delete this record?');"><i class='fa fa-trash' title="Delete"></i></a>
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
                [0, 'desc']
            ],
            columnDefs: [{
                orderable: false,
                targets: [0]
            }],
            buttons: ['excel', 'csv'],
        });
        $(".dataTables_wrapper").css("width", "100%");
    });


    // $(document).on('click', '.clear_filter', function() {
    //     $location = window.location;
    //     window.location.href = $location.origin + $location.pathname;
    // });

    // $(document).on('focus','.city_state_input',function(){
    //     $('.city_state_btn').addClass('d-none');
    //     $(this).closest('form').find('.city_state_btn').removeClass('d-none')
    // })

    $(document).on('click', '.edit_btn', function(){
        let row_data=$(this).closest('tr').attr('data-row_data');
        if(row_data){
            row_data=JSON.parse(row_data);
            $('#country').val(row_data.country_code);
            $('#award').val(row_data.award_id);
            $('#points').val(row_data.award_point);
            $('#amount').val(row_data.award_amount);
            $('#id').val(row_data.id);

            $('.add_btn').addClass('d-none');
            $('.update_btn').removeClass('d-none');
        }
    })
    $(document).on('click', '.clear_filter', function(){
        $('#country').val('');
        $('#award').val('');
        $('#points').val('');
        $('#amount').val('');
        $('#id').val('');

        $('.add_btn').removeClass('d-none');
        $('.update_btn').addClass('d-none');
    })

    $(document).on('keyup','#points',function(){
        calculated_ponts_amount();       
    })
    $(document).on('change','#country',function(){
        calculated_ponts_amount();       
    })

    let calculate_amount_ajax=null;
    function calculated_ponts_amount(){
        $('.calculated_amount').html('')
        let points = $('#points').val();
        let reward_country = $('#country').val();
        let _token = $('meta[name="csrf-token"]').attr('content');

        if(!reward_country){
            $('#country').addClass('error');
        }else{
            $('#country').removeClass('error');
        }

        if(!points ||  points <0 || !reward_country) return false;

        if(calculate_amount_ajax){
            calculate_amount_ajax.abort();
        }

        
        calculate_amount_ajax = $.ajax({
            url: '/admin/auth/reward/calculate_amount', 
            method: 'POST', 
            data: {points,reward_country,_token}, 
            success: function(response) {
                $('#amount').val(response.amount)                
            },

        });
    }



</script>
@endpush