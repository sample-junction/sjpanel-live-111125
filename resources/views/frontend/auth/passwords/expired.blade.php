@extends('frontend.layouts.app_blog')

@section('title', app_name() . ' | ' . __('labels.frontend.passwords.expired_password_box_title'))
<!-- Latest Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .toast-error {
    background-color: #D9534F !important; /* Default red */
    color: white !important;
}
</style>
@section('content')
<div class="container pb-3 mt-5 body_content">
    <div class="row justify-content-center">
        <div class=" col-lg-8">
            <div class="form-wrapper-content">
                <div class="form-main-div">
                    <div class="pass-expired-heading">
                        <strong>
                            @lang('labels.frontend.passwords.expired_password_box_title')
                        </strong>
                    </div><!--card-header-->

                    <div class="form-div">
                        {{ html()->form('PATCH', route('frontend.auth.password.expired.update'))->class('form-horizontal')->open() }}

                        <div class="row form-input-divs">
                            <div class="col">
                                <div class="form-group">
                                    <strong>{{ html()->label(__('validation.attributes.frontend.old_password'))->for('old_password') }}</strong>

                                    {{ html()->password('old_password')
                                        ->class('form-control p-3')
                                        ->placeholder(__('validation.attributes.frontend.old_password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row form-input-divs">
                            <div class="col">
                                <div class="form-group">
                                    <strong>{{ html()->label(__('validation.attributes.frontend.password'))->for('password') }}</strong>

                                    {{ html()->password('password')
                                        ->class('form-control p-3')
                                        ->placeholder(__('validation.attributes.frontend.password'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row form-input-divs">
                            <div class="col">
                                <div class="form-group">
                                  <strong>{{ html()->label(__('validation.attributes.frontend.password_confirmation'))->for('password_confirmation') }}</strong>

                                    {{ html()->password('password_confirmation')
                                        ->class('form-control p-3')
                                        ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                                        ->required() }}
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        <div class="row">
                            <div class="col">
                                <div class="form-group mb-0 clearfix">
                                    <button type="submit" class="btn btn-primary px-5 py-3 expire-submit-btn">
                                        {{ __('labels.frontend.passwords.update_password_button') }}
                                    </button>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->

                        {{ html()->form()->close() }}
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>

    </div><!-- col-6 -->
    <div class="container">
        @include('frontend.includes.blog_footer')
    </div>
</div><!-- row -->
@endsection
