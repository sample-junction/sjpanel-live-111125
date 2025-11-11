@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('campaign_history'))

@section('breadcrumb-links')
    @include('backend.auth.redeem.includes.breadcrumb-links')
@endsection

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        Panel Bonus Show
                    </h4>
                </label>
            </div>
        </div>
    </div>
    <div class="card-body">
        
        <div class="row">
            <div class="col-12">
                <table class="table table-striped table-hover" id="survey_table" style="width:100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>user_points</th>
                            <th>user_joined</th>
                            <th>total point</th>
                            <th>detail_filled_profile</th>
                            <th>basic_details_filled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ optional($userPoints[$loop->index])->user_joined }}</td>
                            <td>Quick_Test_Bonus</td> 
                            <td>Survey_Campaign_Bonus</td>
                            <td>{{ $joining_bonus }}</td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!--card-->

@endsection

@push('after-styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .toast-error {
            background-color: red!important;
        }
    </style>
@endpush

@push('after-scripts')
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#survey_table').DataTable();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
