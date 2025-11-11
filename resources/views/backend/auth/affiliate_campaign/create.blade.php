@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.change_password'))


@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <label>
                        <h4>
                            {{__('Create Affiliate')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.campaign.create.post'))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Camapaign Name:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Campaign's Name" value="" name="name"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Campaign Code:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Campaign's Code" value="" name="code"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Type:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Type" value="" name="type"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Campaign C-Type:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Campaign's C-Type" id="c_type" value="" name="c_type"><br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label"><h6>Campaign Payout:</h6></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Campaign's Variables" value="" name="payout"><br>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" id="create" value="Create" name="submit"><br>
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
    {{--<script>
        $(document).ready(function () {
            $('#create').on('click',function (e) {
                var vars = $('#aff_vars').val();
                var variables = vars.split(',');
                console.log(variables);
                console.log(Array.isArray(variables));
                return false;
            })
        })
    </script>--}}
@endpush
