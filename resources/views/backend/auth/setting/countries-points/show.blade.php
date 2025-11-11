@extends('backend.layouts.app')

@section('title', __('labels.backend.access.questions_answers.management') . ' | ' . __('labels.backend.access.questions_answers.view'))

@section('breadcrumb-links')
    @include('backend.auth.question_answer.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Country Points
                    <small class="text-muted">view detail</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-7" style="text-align: right;">
                <div class="form-group">
                        <a style="margin-top: 24px;" href="{{ route('admin.auth.setting.countries_edit', ['id' => $countryPoint->id]) }}" class="btn btn-sm btn-info">Update</a>
                        <a style="margin-top: 24px;" href="{{ route('admin.auth.setting.countries_points') }}" class="btn btn-sm btn-secondary" id="back">Back</a>
                </div>
            </div>  
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Country/language</th>
                                        <td>{{$countryPoint->country_language}}</td>
                                    </tr>

                                    <tr>
                                        <th>Currency</th>
                                        <td>{{$countryPoint->currency}}</td>
                                    </tr>

                                    <tr>
                                        <th>Points</th>
                                        <td>{{$countryPoint->points}}</td>
                                    </tr>


                                    <tr>
                                        <th>Created At</th>
                                        <td>@if(!is_null($countryPoint->created_at)){{ \Carbon\Carbon::parse($countryPoint->created_at)->format('d-m-Y h:i:s') }}@endif</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>@if(!is_null($countryPoint->updated_at)){{ \Carbon\Carbon::parse($countryPoint->updated_at)->format('d-m-Y h:i:s') }}@endif</td>
                                    </tr>
                                </table>
                            </div>
                        </div><!--table-responsive-->

                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>Created At:</strong> {{ timezone()->convertToLocal($countryPoint->created_at) }} ({{ $countryPoint->created_at->diffForHumans() }}),
                    <strong>Updated At:</strong> {{ timezone()->convertToLocal($countryPoint->updated_at) }} ({{ $countryPoint->updated_at->diffForHumans() }})
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
