@extends('backend.layouts.app')

@section('title', __('labels.backend.access.setting.management') . ' | ' . __('labels.backend.access.setting.titles.active_fraud_title'))

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-6 pull-left">
                    <label>
                        <h4>
                            {{__('Active/Fraud')}}
                        </h4>
                    </label>
                </div>
            </div>
        </div>
        {{html()->form('POST',route('admin.auth.setting.post.active_fraud_setting'))->open()}}
        <div class="card-body">
            <div class="row">
                <div class="form-group col-lg-6">
                    <div class="col-lg-8">
                        <label class="control-label"><strong>{{__('Active Panelist Rule')}}:</strong></label>&nbsp;
                        <p>Who have attempted survey or logged in mentioned period</p>
                        <!-- <input type="text" class="form-control" name="month_limit" value="{{$activeSetting->value}}"> -->
                        {{ Form::select ('month_limit', ['1' => '1 Month', '2' => '2 Months', '3' => '3 Months', '4' => '4 Months', '5' => '5 Months', '6' => '6 Months', '7' => '7 Months', '8' => '8 Months', '9' => '9 Months', '10' => '10 Months','11' => '11 Months','12' => '12 Months'], $activeSetting->value , ['id' =>'month_limit','class' =>'form-control','required']) }}
                    </div>
                </div>
                    <div class="form-group col-lg-6">
                        <div class="col-lg-8">
                            <label class="control-label"><strong>{{__('Blacklist Panelist Rule')}}:</strong></label>&nbsp;
                            <p>Who have marked fraud in the below mentioned count</p>
                            <!-- <input type="text" class="form-control" name="fraud_limit" value="{{ $fraudSetting->value }}"> -->
                            {{ Form::select ('fraud_limit', ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9'], $fraudSetting->value , ['id' =>'fraud_limit','class' =>'form-control','required']) }}
                        </div>
                </div>
                <div class="form-group col-lg-6">
                    <div class="col-lg-8">
                        <label class="control-label"><strong>{{__('Dashboard Popup Rule')}}:</strong></label>&nbsp;
                        <!-- <p>Who have attempted survey or logged in mentioned period</p> -->
                        <!-- <input type="text" class="form-control" name="month_limit" value="{{$activeSetting->value}}"> -->
                        {{ Form::select ('popup_month_limit', ['1' => '1 Month', '2' => '2 Months', '3' => '3 Months', '4' => '4 Months', '5' => '5 Months', '6' => '6 Months'], $popupMonthSetting->value , ['id' =>'popup_month_limit','class' =>'form-control','required']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" class="btn btn-primary" value="Update" name="submit">
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
        $(".dataTables_wrapper").css("width","100%");
    </script>
@endpush
