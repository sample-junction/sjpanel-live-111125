@extends('frontend.layouts.app_blog')
@section('link_url','blog')

@section('title','Blog - SJ Panel') 
@section('meta_description','Discover insightful articles and expert opinions on various topics related to SJ Panel on our informative blog.')

@section('content')

<div class="container pb-3 mt-5">
    <div class="row mt-5 pt-5">

        <div class="col text-center mt-5">

            <h1 class="h1 fw-bold mt-5 fs-2" style="font-size:36px!important;color:black;">{{__('frontend.index.footer.links.latest')}} <span class="pe-4 pb-2" style="background: #e9f6f1;">{{__('frontend.index.footer.links.blog')}}</span></h1>

            <p class="lead mt-3 fs-3" style="color:#858B91"></p>

        </div>

    </div>


    <div class="row mt-4 gx-5 ms-2 me-2 ms-lg-0 me-lg-0">
        @php
            $i=0;
        @endphp
        @if( count($data['posts']) > 0 )
            @foreach($data['posts'] as $index => $post)  
        
                <div class="col-12 col-lg-4 mb-4">
                    <div class="row pt-2 pb-3 border h-100" style="border-radius: 12px;">
                        <div class="col-12 text-center">
                            <a href="{{ route('frontend.blog.post', $post->slug) }}">
                                <img src="{{ ($post->thumbnail_image) ? asset($post->thumbnail_image) : asset('images/no-img.jpeg')}}" 
                            alt="" class="img-fluid w-100" style="max-height:auto; object-fit: cover; border-radius: 12px;">
                            </a>
                        </div>
                        <div class="col-12 text-start mt-3 px-3">
                            <span class="fw-bold d-block" style="font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $post->title }}
                            </span>
                        </div>
                        <div class="col-12 text-start mt-2 px-3">
                            <span style="color: #858B91; font-size: 13px;">
                                <img src="{{ url('img/jpblog/img/Vector.png') }}" alt="" class="mb-1"> {{ $read_time[$i] }}
                            </span>
                        </div>
                        <div class="col-12 text-start mt-3 px-3">
                            <a 
                                href="{{ route('frontend.blog.post', $post->slug) }}" 
                                class="text-black fw-bold" 
                                style="font-size: 15px; text-decoration: none;">
                                {{ __('frontend.index.footer.links.Continue_Reading') }}
                            </a>
                        </div>
                    </div>
                </div>
                @php
                    $i++;
                @endphp
            @endforeach

            {{ $data['posts']->links() }}
        @else
            <p class="mt-4">
                {{ __('No posts were found') }}b
            </p>
        @endif
    </div>

    <div class="row mt-5 pb-3 ms-3 me-3">
        <div class="col p-0">
            <img src="{{url('img/jpblog/img/Group 1000001784.png')}}" alt="surveys that pay immediately" style="width:103%">
        </div>
    </div>

    @include('frontend.includes.blog_footer')
</div>

@endsection


