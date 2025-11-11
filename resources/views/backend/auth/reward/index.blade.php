@extends('backend.layouts.app')

@push('after-styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<!-- DataTables + Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .toast-error {
        background-color: red !important;
    }

    .toast-success {
        background-color: #28a745 !important;
    }

    .input_error {
        border-color: red;
    }

    .selected-row {
        background-color: #b5b5b5ff !important;
        /* highlight */
        opacity: 0.8;
        /* halka sa disable feel dene ke liye */
    }
</style>
@endpush

@section('title', __('labels.backend.access.users.management') . ' | ' . __('Award Data Automation'))

@section('breadcrumb-links')
@include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session('success')}}</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        Award Data Automation
                    </h4>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-12 mt-2 mb-2">
                <div class="card">

                    <div class="card-body">
                        <form action="{{route('admin.auth.reward.process_rewards_automation')}}" method="POST" id="renrate_reward_form">
                            @csrf

                            <div class="form-group">
                                <label for="">Country</label>
                                <select name="reward_country[]" id="reward_country" class="form-select multiple_select" multiple="multiple" required>
                                    @if(!empty($countries))
                                    @foreach($countries as $country)
                                    <option value="{{$country->country_code}}" selected>{{$country->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Award Type</label>
                                <select name="award_type[]" id="award_type" class="form-select multiple_select" multiple="multiple" aria-label="Default select example" required>
                                    @if(!empty($award_type))
                                    @foreach($award_type as $award)
                                    <option value="{{$award->id}}" selected>{{$award->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Select Month</label>
                                <input type="month" class="form-control" name="month_year" id="month_year" value="{{ now()->subMonth()->format('Y-m') }}" required min="{{ now()->subYears(2)->format('Y-m') }}" max="{{ now()->subMonth()->format('Y-m') }}">
                            </div>

                            <button class="btn btn-primary submit_form" type="button">
                                Generate Data
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            </button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2 mb-2">
                <div class="card">


                    <div class="alert alert-success success_section d-none" role="alert">
                        <h5 class="alert-heading">✅ Reward Saved Successfully</h5>
                        <ul class="mb-0 success_section_list">

                            <!-- <li><strong>panellist_id</strong>: point_err</li> -->

                        </ul>
                    </div>



                    <div class="alert alert-danger error_section d-none" role="alert">
                        <h5 class="alert-heading">❌ Failed to Save Reward</h5>
                        <ul class="mb-0 error_section_list">
                            <!-- <li><strong>panellist_id</strong>: point_err</li> -->
                        </ul>
                    </div>


                </div>
            </div>
            <div class="col-12">
                <!-- <div style="overflow-x: auto;"> -->
                <table class="table table-striped table-hover" id="survey_table" style="width:100%">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="select_all" class="select_all"> </th>
                            <th>Panellist ID </th>
                            <th>Full Name </th>
                            <th>City and State</th>
                            <th>Zip</th>
                            <th>Country</th>
                            <th>Award Type</th>
                            <th>DOI</th>
                            <th>Deactivated</th>
                            <th>Unsubscribe</th>
                            <th>Last Login</th>
                            <th>Average Survey Duration</th>
                            <th>Number of Filled Profiles</th>
                            <th>Total No. of Surveys Attempted</th>
                            <th>Total No. of Surveys Completed</th>
                            <th>Total No. of Profiles Filled</th>
                            {{-- <th>Action
                            </th> --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!-- </div> -->
            </div>

        </div>
    </div>
</div><!--card-->

<!-- Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="margin-left:15%;">
                <div class="content">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@endsection

@push('after-scripts')
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

<!-- Buttons + JSZip for CSV Export -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- Select2 -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    var allAwardsArr = @json($allAwardsArr);

    var winners_data = {};
    var table = null;
    $(document).ready(function() {

        // var allAward = 

        $('.multiple_select').select2();

        $('.select_all').on('click', function() {
            $('.row_checkbox').prop('checked', this.checked);

            if (this.checked) {
                // $('.approve_selected').show()
                $('.approve_selected').removeClass('d-none')
            } else {
                // $('.approve_selected').hide()
                $('.approve_selected').addClass('d-none')
            }
        })

        $(document).on('click', '.row_checkbox', function() {
            if (!this.checked) {
                $('.select_all').prop('checked', false);
            }

            if ($('.row_checkbox:checked').length === $('.row_checkbox').length) {
                $('.select_all').prop('checked', true);
            }

            if ($('.row_checkbox:checked').length > 0) {
                // $('.approve_selected').show();
                $('.approve_selected').removeClass('d-none')
            } else {
                // $('.approve_selected').hide();
                $('.approve_selected').addClass('d-none')
            }
        });


        table = $('#survey_table').DataTable({
            processing: true,
            ordering: false,
            scrollX: true,
            autoWidth: false,
            searching: true,
            dom: 'Bfrtip',
            // buttons: ['csv'],
            buttons: [{
                    extend: 'csv',
                    className: 'btn btn-secondary btn-sm',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                var $input = $('input', node);
                                if ($input.length > 0) {
                                    if ($input.attr('type') === 'checkbox') {
                                        return '';
                                    }
                                    return $input.val();
                                }

                                var $btn = $('button', node);
                                if ($btn.length > 0) {
                                    return '';
                                }

                                return $(node).text().trim();
                            }
                        }
                    }
                },
                {
                    text: 'Approve Selected',
                    className: 'btn btn-warning btn-sm d-none approve_selected',
                    init: function(api, node, config) {
                        $(node).attr('data-row_key', 'approve_selected');
                    }
                }
            ],
            columnDefs: [{
                    targets: [4],
                    searchable: true
                },
                {
                    targets: "_all",
                    className: "dt-nowrap"
                }
            ]
        });



        $('.submit_form').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            table.clear().draw();
            $('.spinner-border').removeClass('d-none');

            let selected_month = $('#month_year').val();

            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: $(form).serialize(),
                success: function(response) {

                    if (response.panellists.length > 0) {
                        response.panellists.forEach(function(row) {
                            let row_key = `${row.panellist_id}_${row.award_id}`;


                            winners_data[row_key] = {
                                'panellist_id': row.panellist_id,
                                'country_code': row.country_code,
                                'award_type': row.award_id,
                                'award_month': selected_month,
                                'city_state': (row.location) ? row.location : ''
                            };

                            var newRow = [
                                (row.is_selected) ? '' : `<input type="checkbox" name="select_winners[]" class="row_checkbox" value="${row_key}" >`,
                                row.panellist_id,
                                row.first_name + ' ' + row.last_name,
                                `<input type="text" value="${(row.location)?row.location:'' }" class="form-control city_state_input location_${row_key}" data-row_key="${row_key}" ${(row.is_selected)?'disabled':''} > `,
                                row.zipcode,
                                row.country_code,
                                allAwardsArr[row.award_id],
                                (row.confirmed == '1') ? 'Yes' : 'No',
                                (row.active != '1') ? 'Yes' : 'No',
                                (row.unsubscribed == '1') ? 'Yes' : 'No',
                                row.last_login_at,
                                row.t_avg_survey_dur,
                                row.monthly_profiles_filled,
                                row.surveys_attempted,
                                row.surveys_completed,
                                row.profiles_filled
                                //`<button type="submit" class="btn btn-primary btn-sm approve_btn" data-row_key="${row_key}" >Approve</button>`
                            ];

                            let addedRow = table.row.add(newRow).draw().node();

                            if (row.is_selected) {
                                $(addedRow).addClass('selected-row');
                            }
                        });

                    } else {
                        // No data available in table

                    }

                },
                complete: function(xhr, status) {
                    $('.spinner-border').addClass('d-none');
                    $('.submit_form').prop('disabled', false);
                }

            });
        });

        $(document).on('click', '.approve_btn , .approve_selected', function(e) {

            let finalArr = [];
            let row_key = $(this).attr('data-row_key');
            if (row_key == 'approve_selected') {

                let hasErorr = false;
                $('.row_checkbox:checked').each((i, e) => {
                    let data = winners_data[$(e).val()]
                    finalArr[i] = data;
                    if ((data.city_state).length <= 0) {
                        hasErorr = true;
                        $(`.location_${$(e).val()}`).addClass('input_error');
                    }
                });

                if (hasErorr) {
                    alert('City state is required');
                    return false;
                }

            } else {
                if ((winners_data[row_key].city_state).length <= 0) {
                    $(`.location_${row_key}`).addClass('input_error');
                    alert('City state is required');
                    return false;
                }
                finalArr[0] = winners_data[row_key];
            }

            if (finalArr.length > 0) {
                saveAwardWinners(finalArr)
            }


            // let city_state_input =$(this).closest('tr').find('.city_state_input');
            // if(($(city_state_input).val()).length<=0){
            //     $(city_state_input).addClass('input_error');
            //     alert('City state is required');

            //     return false;
            // }

            // if(hasWinner){
            //     if(!confirm('The winner has already been selected. Do you want to continue?')){
            //         e.preventDefault();
            //         return false
            //     }
            // }

        })

    });

    function saveAwardWinners(winners) {

        $('.approve_selected').append(' <span class="spinner-border spinner-border-sm approve_selected_spinn" role="status" aria-hidden="true"></span>')
        $('.success_section_list').html('');
        $('.success_section').addClass('d-none');

        $('.error_section_list').html('');
        $('.error_section').addClass('d-none');

        $.ajax({
            url: "{{route('admin.auth.reward.save')}}",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                data: winners
            },
            success: function(response) {

                if (response.successArr.length != 0) {
                    $('.success_section').removeClass('d-none');
                    $.each(response.successArr, function(panellist_id, message) {
                        $('.success_section_list').append(
                            '<li><strong>' + panellist_id + '</strong>: ' + message + '</li>'
                        );
                    });
                } else {
                    $('.success_section').addClass('d-none');
                }

                if (response.errorArr.length != 0) {
                    $('.error_section').removeClass('d-none');
                    $.each(response.errorArr, function(panellist_id, message) {
                        $('.error_section_list').append(
                            '<li><strong>' + panellist_id + '</strong>: ' + message + '</li>'
                        );
                    });
                } else {
                    $('.error_section').addClass('d-none');
                }

                $('.approve_selected_spinn').remove();

                setTimeout(() => {
                    $('.approve_selected').addClass('d-none');
                    $('.select_all').prop('checked', false);


                    if (table) {
                        table.clear().draw();
                    }

                }, 2000);


            }

        });
    }


    $(document).on('keyup', '.city_state_input', function() {
        let city_state = $(this).val();
        let row_key = $(this).attr('data-row_key');

        winners_data[row_key].city_state = city_state;

        $('.input_error').removeClass('input_error');
        // $(this).closest('tr').find('.hidden_city_state').val(city_state);
    })
</script>
@endpush