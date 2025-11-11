@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Edit Affiliate')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.affiliate.edit.post',$affiliate_id))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Affiliate Name:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$affiliate_detail->name}}" name="name"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Affiliate Code:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$affiliate_detail->code}}" name="code"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>C-Link:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$affiliate_detail->c_link}}" name="c_link"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Affiliate Variables:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$affiliate_detail->aff_vars}}" name="aff_vars"><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update" name="submit"><br>
                    </div>
                </div>
            </div>
        </div><!--card-footer-->
        {{html()->form()->close()}}
    </div><!--card-->
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('css/datatable.css') }}" >

@endpush

@push('after-scripts')
    {{-- For DataTables --}}
    <script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
    </script>
@endpush
