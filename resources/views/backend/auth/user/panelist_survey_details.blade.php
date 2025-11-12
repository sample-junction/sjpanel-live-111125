@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.reports.titles.response_rate_title'))

@section('breadcrumb-links')
@include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    Listing <small class="text-muted">Panelist Live Surveys Details</small>
                </h4>
            </div><!--col-->
        </div>
        <hr>
        <div class="col-sm-1"></div>
        <div class="mb-3">
            <button class="btn btn-primary" id="bulkSendInvite">Send Reminder</button>
        </div>
    </div><!--row-->


    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table" id="SurveysTable">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>@lang('labels.surveys_details.panelistid')</th>
                            <th>@lang('labels.surveys_details.Surveys')</th>
                            <th>@lang('labels.surveys_details.Surveys_status')</th>
                            <th>@lang('labels.surveys_details.attempted')</th>
                            <th>@lang('labels.surveys_details.invite_status')</th>
                            <th>@lang('labels.surveys_details.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($surveys as $survey)
                        <tr>
                            <td><input type="checkbox" class="survey_checkbox" name="project_id[]" value="{{ $survey->id }}" {{ !is_null($survey->status) ? 'disabled' : '' }}></td>
                            <td>{{$panelistId}}</td>
                            <td>{{$survey->survey}}</td>
                            <td>{{$survey->survey_status_code}}</td>
                            <td>
                                @if(is_null($survey->status))
                                <span class="badge badge-danger">No</span>
                                @else
                                <span class="badge badge-success">Yes</span>
                                @endif
                            </td>
                            <td>
                                @if(is_null($survey->invite_sent_count))
                                <span class="badge badge-danger">No</span>
                                @else
                                <span class="badge badge-success">Yes</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" {{ !is_null($survey->status) ? 'disabled' : '' }}>
                                        Actions
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item send_pull_invite" href="#" data-project_id="{{$survey->id}}">Send Reminder</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <input type="hidden" name="" id="user_id" value="{{$user_id}}">
                </table>
            </div>
        </div><!--col-->
    </div><!--row-->
    {{--<div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
</div>
</div><!--col-->

<div class="col-5">
    <div class="float-right">
        {!! $users->render() !!}
    </div>
</div><!--col-->
</div><!--row-->--}}
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
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#SurveysTable').DataTable({
            // dom: 'Bfrtip',
            // buttons: [
            //     'excel', 'csv'
            // ]
        });
        $(".dataTables_wrapper").css("width", "100%");

        $('.send_pull_invite').on('click', function() {
            let projectId = $(this).attr('data-project_id');
            let user_id = $('#user_id').val();
            $.ajax({
                url: "{{ route('admin.auth.sendPullInvite') }}",
                type: 'POST',
                data: {
                    project_id: projectId,
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {
                        toastr.error(response.message);
                    }
                }
            })
        });
        $(document).on('click', '#bulkSendInvite', function(e) {
            e.preventDefault();
            let selected = [];
            let user_id = $('#user_id').val();
            $(".survey_checkbox:checked").each(function() {
                selected.push($(this).val());
            });

            if (selected.length === 0) {
                alert("Please select at least one project.");
                return;
            }

            $.ajax({
                url: "{{ route('admin.auth.sendPullInvite') }}",
                method: "POST",
                data: {
                    project_id: selected,
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });

        $('.send_reminder').on('click', function() {
            let projectId = $(this).attr('data-project_id');
            let user_id = $('#user_id').val();
            $.ajax({
                url: "{{ route('admin.auth.sendReminderInvite') }}",
                type: 'POST',
                data: {
                    project_id: projectId,
                    user_id: user_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {

                }
            })
        });

    });
</script>

@endpush