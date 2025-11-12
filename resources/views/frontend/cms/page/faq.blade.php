@extends('frontend.layouts.app_blog')
@section('link_url','pages/faq')
@section('meta_title','FAQ - SJ Panel')
@section('title','FAQ - SJ Panel')
@section('meta_description','Get answers to frequently asked questions about SJ Panel, a reliable and efficient platform for online surveys. Learn more today.')
 
@section('content')
<div class="container pb-3 mt-5 body_content">
    <section class="container">
        <div class="row mb-2">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1 class="h4 ms-2"  id="">{{__('cms.FAQ.faq')}}</h1>
            </div>
        </div>
        <div class="p-3 rounded">
            <div class="row rounded mt-1  p-3 bg-white" style="border-radius: 10px;" id="top_user_info">
                @php
                use Illuminate\Support\Arr;
                use Illuminate\Support\Str;
 
                    for($i = 1; $i <= 57;$i++){
                    $var = __('cms.FAQ.Que_'.$i);
                    $filter = Arr::where($var, function($val,$key){
                                return Str::contains($key, 'opt');
                            });
                @endphp
                    <h6 class="fw-bold pt-2">{{$var['question']}}<img src="/images/arrow-right.png" alt="earn by survey online" class="image_center" style="height: 12px;width: 12px;float: right;" /></h6>
                    <div class="faq_selected_div">
                        <p class="text-secondary fs-6">{{$var['answer']}}
                            @if(count($filter) > 0)
                            <br>  
                            <ul class="text-secondary">
                                @foreach ($filter as $option)
                                    <li>{{$option}}</li>
                                @endforeach
                            </ul>
                            @endif  
                        </p>
                    </div>
                    <hr>  
                @php    } @endphp
            </div>
        </div>
        
    </section>
    <div class="container">
        @include('frontend.includes.blog_footer')
    </div>
</div>
@endsection
 
@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('h6').click(function() {
        var $faq = $(this).next('.faq_selected_div');
        var $image = $(this).find('.image_center');
        $('.faq_selected_div').not($faq).hide();
        $faq.toggle();
        $('.image_center').not($image).attr('src', '/images/arrow-right.png').removeClass('arrow-down');
           
        if ($image.hasClass('arrow-down')) {
            $image.attr('src', '/images/arrow-right.png').removeClass('arrow-down');
        } else {
            $image.attr('src', '/images/arrow-bottom.png').addClass('arrow-down');
        }
    });
});
</script>
@endpush