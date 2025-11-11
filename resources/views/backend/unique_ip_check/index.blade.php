@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('Unique IP Check'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('Unique IP Check')</strong>
                </div><!--card-header-->
                {{html()->form('POST',route('admin.auth.setting.unique_ip_check.post'))->open()}}
                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-lg-12">
                                <label class="control-label"><strong>Unique Ip Check:</strong></label>&nbsp;
                            </div>
                            <div class="col-lg-6">
                                <input type="checkbox" class="form-control" @if($unique_ip_check && $unique_ip_check==1) checked @endif name="unique_ip_check" value="1"><br>
                            </div>
                        </div>
                    </div>
                </div><!--card-body-->
                <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Submit" name="submit">
                </div>
                {{html()->form()->close()}}
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')

@endpush
