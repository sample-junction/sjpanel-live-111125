@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Crypt;

@endphp
@extends('backend.layouts.app')

@section('title', app_name() . ' | Award Templates')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@php
$test_mode_txt = ($test_mode_settings['test_mode'] == 1)? 'ON':'OFF';
$test_mode_emails = $test_mode_settings['test_emails'] ;
@endphp

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="card-title mb-0">
                        Award <small class="text-muted">Templates</small>
                    </h4>
                </div>

                <!-- <div>
                                    <h5 class="mb-0">
                                        <strong>Total Amount Spent:</strong>
                                        <span id="total_amount_spent">$0.00</span>
                                    </h5>
                                </div> -->

                <!-- Button trigger modal -->
                {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#staticBackdrop"> --}}
                <button type="button" class="btn {{ ($test_mode_txt=='ON')?'btn-warning':'btn-success' }} " data-toggle="modal" data-target="#staticBackdrop">
                    Test Mode: <strong>{{ $test_mode_txt }}</strong>
                </button>

                <div class="col-sm-2 pull-right">
                    <div class="form-group">
                        <a class="btn btn-primary" href="{{ route('admin.auth.reward.template.add') }}">Create New
                            Template</a>
                    </div>
                </div>
            </div>

            <hr>

        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive p-3" style="overflow-x: auto;">
                    <table class="table w-100 nowrap" id="user_management">
                        <thead>
                            <tr>
                                <!-- <th>Panellist Id</th> -->
                                <th>Template Name</th>
                                <th>Template Subject</th>
                                <th>Created at</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($award_templates as $result)
                                <tr>
                                    <td>{{ $result->template_name }}</td>
                                    <td>{{ $result->email_subject }}</td>
                                    <td>{{ $result->created_at }}</td>

                                    <td>
                                        <a href="{{ route('admin.auth.reward.template.delete', $result->id) }}"
                                            class="mr-2"
                                            onclick="return confirm('Are you sure you want to delete this reward?');"><i
                                                class='fa fa-trash' title="Delete"></i></a>
                                        <!-- <a href="{{ route('admin.auth.reward.template.edit', $result->id) }}" class="mr-2"><i class='fa fa-edit' title="Edit"></i></a> -->
                                        <a href="{{ route('admin.auth.reward.template.edit', $result->id) }}"
                                            class="mr-2"><i class="fas fa-eye preview_eye"
                                                style="color: #17a2b8; cursor: pointer;"></i></a>
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

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.auth.reward.template.test_mode.post') }}">
                        @csrf

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Test Email Ids</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="test_emails"
                                placeholder="test1@mail.com, test2@mail.com" rows="3">{{ $test_mode_emails }}</textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="test_mode" {{ ($test_mode_txt=='ON')?'checked':'' }} value="1" id="defaultCheck1">
                            <label class="form-check-label" for="defaultCheck1">
                                Test mode
                            </label>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div> --}}
            </div>
        </div>
    </div>

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
    <script type="text/javascript" language="javascript"
        src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
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
                // order: [
                //     [4, 'desc']
                // ],
                columnDefs: [{
                    orderable: false,
                    targets: [2]
                }],
                // buttons: ['excel', 'csv'],
                buttons: [],
            });
            $(".dataTables_wrapper").css("width", "100%");

        });
    </script>
@endpush
