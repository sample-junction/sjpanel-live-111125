@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">

                <form action="{{route('admin.dashboard')}}" method="get" id="filterdata">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <span>From Date</span>
                                <input type="date" name="fromDate" id="" value="{{(isset($_GET['fromDate']))?$_GET['fromDate']:0}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <span>To Date</span>
                                <input type="date" name="toDate" id="" value="{{(isset($_GET['toDate']))?$_GET['toDate']:0}}" max="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-info" style="margin-top: 24px;">Filter</button>
                            </div>
                        </div>
                    </div><!--row-->
                </form>
                <p><b>{{__('strings.backend.dashboard.default_heading',['dashboard_days' =>$fromLastDays])}}</b></p>
                <hr>

                    <!-- {!! __('strings.backend.welcome') !!} -->


                    <div class="container-lg">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-primary" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ $totalActiveUsers }} 
                                                <!-- <span class="fs-6 fw-normal">(-12.4%)</span> -->
                                            </div> 
                                            <div style="margin-top:10px;">Total Active Users</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-info" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{count($surveyCompleteReport)}}
                                                <!-- <span class="fs-6 fw-normal">(40.9%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Survey Completes</div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-warning" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{$totalResponseRate}}%
                                                <!-- <span class="fs-6 fw-normal">(84.7%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Response Rate</div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-danger" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">{{ $totalActiveUsers }}/{{ $totalInactive }}
                                                <!-- <span class="fs-6 fw-normal">(-23.6%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Active/Inactive User </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-success" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($totalIncentivePaid)) {{ ($totalIncentivePaid->total_Points)?$totalIncentivePaid->total_Points:0 }}@endif
                                                <!-- <span class="fs-6 fw-normal">(-12.4%)</span> -->
                                            </div> 
                                            <div style="margin-top:10px;">Total Incentive Paid </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-success" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastSignupDate)) {{ date('d M Y H:i:s',strtotime($lastSignupDate->created_at)) }} @endif
                                                <!-- <span class="fs-6 fw-normal">(40.9%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last SOI Received on</div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-dark" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastCofirmDate)) {{ ($lastCofirmDate->confirm_at)?date('d M Y H:i:s',strtotime($lastCofirmDate->confirm_at)):'---' }} @endif
                                                <!-- <span class="fs-6 fw-normal">(84.7%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last DOI Received on</div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-info" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastDeactiveDate)) {{ ($lastDeactiveDate->deactivate_at)?date('d M Y H:i:s',strtotime($lastDeactiveDate->deactivate_at)):'---' }} @endif
                                                <!-- <span class="fs-6 fw-normal">(-23.6%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last OO Received on</div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-warning" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastRedeemRequestDate)) {{ ($lastRedeemRequestDate['created_at'])?date('d M Y H:i:s',strtotime($lastRedeemRequestDate['created_at'])):'---' }} @endif 
                                                <!-- <span class="fs-6 fw-normal">(-12.4%)</span> -->
                                            </div> 
                                            <div style="margin-top:10px;">Last Redemption Request Received on </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-danger" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastSurveyAttemptDate))  {{ ($lastSurveyAttemptDate->updated_at)?date('d M Y H:i:s',strtotime($lastSurveyAttemptDate->updated_at)):'---' }} @endif
                                                <!-- <span class="fs-6 fw-normal">(40.9%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last Survey Attempted on</div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-primary" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastSurveyCompleteDate)) {{ ($lastSurveyCompleteDate['updated_at'])?date('d M Y H:i:s',strtotime($lastSurveyCompleteDate['updated_at'])):'---' }} @endif
                                                <!-- <span class="fs-6 fw-normal">(84.7%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last Survey Complete Received on</div>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <div class="card mb-4 text-white bg-success" style="min-height: 131px;">
                                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="fs-4 fw-semibold">@if(!empty($lastRedeemRequestProcesseDate)) {{ ($lastRedeemRequestProcesseDate['approve'])?date('d M Y H:i:s',strtotime($lastRedeemRequestProcesseDate['approve'])):'---' }} @endif
                                                <!-- <span class="fs-6 fw-normal">(-23.6%)</span> -->
                                            </div>
                                            <div style="margin-top:10px;">Last Redemption Request Processed on</div>
                                       </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@push('after-scripts')

@endpush
