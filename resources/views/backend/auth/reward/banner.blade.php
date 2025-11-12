@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Award Banner Upload' )


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Award Banner Upload')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.auth.reward.banner.post') }}" method="POST" enctype="multipart/form-data">
            @csrf


        <div class="card-body">
            

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Upload Award Banner:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="file" class="form-control" name="reward_banner" required>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Banner preview:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="d-flex">
                            <img src="{{ $bannerImg }}" alt="" style="max-width: 100%; height: auto;">
                            
                        </div>
                    </div>
                </div>
            </div>
            
    
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="create" value="Upload" name="submit"><br>
                    </div>
                </div>
            </div>
        </div><!--card-footer-->
    </form>
    </div><!--card-->
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >

@endpush

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

@endpush
