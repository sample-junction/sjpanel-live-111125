@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | Edit Countries Info' )


@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-sm-10">
                <label>
                    <h4>
                        {{__('Edit Countries Info')}}
                    </h4>
                </label>
            </div>
        </div>
    </div>
    {{html()->form('POST',route('admin.auth.reward.country_info.postCreate'))->open()}}
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Country:</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select name="reward_country" id="reward_country" class="form-control" required>
                        @if(!empty($countries))
                        @foreach($countries as $country)
                        @if($countryInfo->country_code == $country->country_code)
                        <option value="{{$country->country_code}}" {{ ( old('reward_country', $countryInfo->country_code) == $country->country_code ? 'selected' : '') }}>{{$country->name}}</option>
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Zoom Link:</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="country_zoom_link" placeholder="Enter Zoom Link" value="{{ old('country_zoom_link', $countryInfo->zoom_link) }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Zoom Link Time:</h6>
                        <span> <strong>Note:</strong> Please enter the time in IST </span>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <div class="d-flex">
                        <input type="date" class="form-control me-2" name="zoom_link_date" placeholder="Enter Zoom Link Date" value="{{ old('zoom_link_date',$countryInfoDate) }}" required>
                        <input type="time" class="form-control" name="zoom_link_time" placeholder="Enter Zoom Link Time" value="{{ old('zoom_link_time', $countryInfoTime) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Status</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select name="reward_status" id="reward_status" class="form-control" required>
                        <option value="1" {{ old('reward_status',$countryInfo->status) != "0" ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('reward_status',$countryInfo->status) == "0" ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Mail Scheduler</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select name="active_cron_job" id="active_cron_job" class="form-control" required>
                        <option value="1" {{ old('active_cron_job',$countryInfo->active_cron_job) != "0" ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('active_cron_job',$countryInfo->active_cron_job) == "0" ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label">
                        <h6>Mail Template</h6>
                    </label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <select name="mail_template" id="mail_template" class="form-control">
                        <option value="">Select mail template </option>
                        @foreach($mail_templates as $id => $name)
                        <option value="{{ $id }}" {{ ($id==$countryInfo->award_mail_temp)?'selected':'' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <a href="{{route('admin.auth.reward.country_info.list')}}" class="btn btn-primary">Back</a>
                    <input type="submit" class="btn btn-primary" id="create" value="Update" name="submit"><br>
                </div>
            </div>
        </div>
    </div><!--card-footer-->
    {{html()->form()->close()}}
</div><!--card-->
@endsection
@push('after-styles')
<link rel="stylesheet" href="{{ asset('css/datatable.css') }}">

@endpush

@push('after-scripts')
{{-- For DataTables --}}
<script type="text/javascript" src="{{ asset('js/dataTable.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>

@endpush