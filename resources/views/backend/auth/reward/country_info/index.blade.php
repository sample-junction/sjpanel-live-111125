@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Countries Info')

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{ __('Countries Info') }}
                        </h4>
                    </label>
                </div>
                <div class="col-sm-2 pull-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="{{ route('admin.auth.reward.country_info.create') }}">Add Country
                            Info</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <table class="table table-striped table-hover" id="affiliate" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Country Name</th>
                            <th>Zoom Link</th>
                            <th>Zoom time</th>
                            <th>Status</th>
                            <th>Preview</th>
                            <th>Mail Template</th>
                            <th>Mail Scheduler</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries_info as $country)
                            <tr class="table-row" data-c_code="{{ $country->country_code }}">
                                <td></td>
                                <td>{{ $country->name }} </td>
                                <td>{{ $country->zoom_link }}</td>
                                <td>{{ $country->date_time }}</td>
                                <td>{{ $country->status == '1' ? 'Active' : 'Inactive' }}</td>
                                <td>
                                    @if (!empty($country->template_name) && $country->hasAward)
                                        <i class="fas fa-eye preview_eye"
                                            data-history_link="{{ route('admin.auth.reward.country_info.preview', ['country_id' => $country->id,'temp_id' => $country->award_mail_temp]) }}"
                                            style="color: #17a2b8; cursor: pointer;"></i>
                                    @endif
                                </td>
                                <td>{{ $country->template_name }}</td>
                                <td>
                                    <span
                                        class="badge {{ $country->active_cron_job == 1 ? 'bg-danger' : 'bg-success' }} px-3 py-2 fs-6">
                                        {{ $country->active_cron_job == '1' ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown" bis_skin_checked="1">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                            bis_skin_checked="1">
                                            <a class="dropdown-item"
                                                href="{{ route('admin.auth.reward.country_info.edit', ['id' => $country->id]) }}">Edit</a>
                                            <form
                                                action="{{ route('admin.auth.reward.country_info.delete', ['id' => $country->id]) }}"
                                                method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Delete</button>
                                            </form>
                                            @if (!empty($country->template_name) && $country->hasAward)
                                                <a class="dropdown-item participants_mail_btn"
                                                    href="javascript:void(0)">Send
                                                    Participants mail </a>
                                            @endif
                                            <a class="dropdown-item "
                                                href="{{ route('admin.auth.reward.blod.create', ['id' => $country->id]) }}">Post Blog </a>

                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
        </div><!--card-footer-->
    </div><!--card-->

    <!-- Modal -->
    <div class="modal fade" id="preview_template_Modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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


    {{-- <div class="modal fade" id="participants_mail_modal" tabindex="-1" aria-labelledby="mailModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mailModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="content">
                    <form action="{{ route('admin.auth.reward.country_info.send_participants_mail') }}" class="mail_form">

                        <input type="hidden" name="country_code" class="mail_c_code">

                        selet temp
                        <select name="" id="">
                            <option value="1">asda</option>
                            <option value="2">weeee</option>
                            <option value="3">fgdd</option>
                        </select>
                        <input type="button" value="send" class="submit_mail_form">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class="modal fade" id="participants_mail_modal" tabindex="-1" aria-labelledby="mailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="mailModalLabel">Send Mail to Participants</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.auth.reward.country_info.send_participants_mail') }}" class="mail_form"
                        method="post">
                        @csrf
                        <input type="hidden" name="country_code" class="mail_c_code">

                        <!-- Template Selection -->
                        <div class="mb-3">
                            <label for="mail_template" class="form-label fw-semibold">Select Template</label>
                            <select id="mail_template" class="form-select" name="template">
                                <option value="" selected disabled>-- Choose a template --</option>
                                @foreach ($templates as $temp_id => $temp)
                                    <option value="{{ $temp_id }}">{{ $temp }}</option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-primary submit_mail_form">Send Mail</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}">
@endpush

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this country?');
        }

        $(document).on('click', '.preview_eye', function() {
            $('#preview_template_Modal').modal('show')

            let history_link = $(this).attr('data-history_link');

            $.ajax({
                url: history_link,
                method: 'get',
                success: function(response) {
                    if (response.status && (response.content).length > 0) {
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
            $('#mailModalLabel').modal('hide')
        })

        $(document).on('click', '.participants_mail_btn', function() {
            if (confirm('Do you want to send the participants mail to all panellist of this country?')) {
                let c_code = $(this).closest('.table-row').attr('data-c_code');
                $('.mail_c_code').val(c_code)
                $('#participants_mail_modal').modal('show')
            }
        })

        $(document).on('click', '.submit_mail_form', function() {

            if (confirm('Final confirmation: send mail to all panellist of this country?')) {
                $('.mail_form').submit();
            }
        })

        $(document).on('click','.popup_mail_preview',function(){

        })
    </script>
@endpush
