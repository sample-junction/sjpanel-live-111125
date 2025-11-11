@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Credit Panelist Points' )

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        {{__('Credit Joining Points')}}
                    </h4>
                </label>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.auth.reward.post_credit_panallist_points') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">
                            <h6>Panelist IDs:</h6>
                        </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div style="display: flex;justify-content: space-between;">
                            Choose CSV
                            <a href="{{asset('img/email_temp/demo_file.csv')}}" download="">Download Demo File</a>
                        </div>
                        <input type="file" class="form-control" name="panellist_csv" placeholder="Enter Panelist id" value="">
                        <span>OR</span>
                        <input type="text" class="form-control" name="panellist_id" placeholder="Enter Panelist ids. Eg. panellist_id1,panellist_id2" value="{{ old('panellist_id') }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label">
                            <h6>Award Month:</h6>
                        </label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <input type="month" class="form-control" name="month" value="{{ old('month') }}" max="{{ now()->subMonth()->format('Y-m') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group d-flex">
                        {{-- <a href="{{route('admin.auth.reward.country_info.list')}}" class="btn btn-primary">Back</a> --}}
                        <input type="submit" class="btn btn-primary" id="create" value="Credit" name="submit"><br>
                    </div>
                    @if (session('points_success'))

                    <div class="alert alert-success" role="alert">
                        <h5 class="alert-heading">✅ Points Credited Successfully</h5>
                        <ul class="mb-0">
                            @foreach(session('points_success') as $panellist_id=>$point_err)
                            <li><strong>{{$panellist_id}}</strong>: {{$point_err}}</li>
                            @endforeach
                        </ul>
                    </div>

                    @endif

                    @if (session('points_error'))

                    <div class="alert alert-danger" role="alert">
                        <h5 class="alert-heading">❌ Failed to Credit Points</h5>
                        <ul class="mb-0">
                            @foreach(session('points_error') as $panellist_id=>$point_err)
                            <li><strong>{{$panellist_id}}</strong>: {{$point_err}}</li>
                            @endforeach
                        </ul>
                    </div>

                    @endif

                </div>
            </div>
        </div><!--card-footer-->
    </form>
</div><!--card-->
@endsection
@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">

<style>
    .error {
        border: 1px solid red;
    }
</style>

@endpush

@push('after-scripts')
{{-- For DataTables --}}
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

<script>

</script>

@endpush