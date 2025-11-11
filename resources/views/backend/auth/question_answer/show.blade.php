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
                    @lang('labels.backend.access.questions_answers.management')
                    <small class="text-muted">@lang('labels.backend.access.questions_answers.view')</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-7" style="text-align: right;">
                <div class="form-group">
                        <a style="margin-top: 24px;" href="{{ route('admin.auth.question.edit', ['id' => $question->id]) }}" class="btn btn-sm btn-info">Update</a>
                        <a style="margin-top: 24px;" href="{{ route('admin.auth.question') }}" class="btn btn-sm btn-secondary" id="back">Back</a>
                </div>
            </div>  
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <div class="tab-content">
                    <div class="tab-pane active" id="overview" role="tabpanel" aria-expanded="true">
                        @include('backend.auth.question_answer.show.tabs.overview')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>Created At:</strong> {{ timezone()->convertToLocal($question->created_at) }} ({{ $question->created_at->diffForHumans() }}),
                    <strong>Updated At:</strong> {{ timezone()->convertToLocal($question->updated_at) }} ({{ $question->updated_at->diffForHumans() }})
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
