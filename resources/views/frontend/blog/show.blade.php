@extends('frontend.layouts.app_blog')
@section('link_url','blog/'.$data['post']->slug)

@php
    $meta = json_decode($data['meta'], true);
@endphp

@section('meta_title', $meta['meta_title'] ?? '')
@section('meta_description', $meta['meta_description'] ?? '')
@section('meta_keyword', $meta['meta_keywords'] ?? '')
@section('title', $meta['meta_title'] ?? '')

@section('content')
@push('after-styles')
<style>
	.body_content h1 {
		display: none!important;
	}    
	h2 {
		font-size: 14px;
		font-weight: bolder;
	}
	h3 {
		font-size: 13px;
	}
	tbody, td, tfoot, th, thead, tr {
		border: 1px solid #ddd;
		padding: 8px;
	}
</style>
@endpush

<div class="container pb-3">
<!--
<div class="row mt-5 pt-5 ps-2 pe-2">

        <div class="col-12 col-md-12 col-sm-12 col-lg-12 mt-4 " id="first_p">    
        </div>

        <div class="col-12 col-md-12 col-sm-12 col-lg-12 text-start mt-3 border-bottom pb-3">
            <span style="color:#858B91;font-size:13px;" ><img src="{{url('img/jpblog/img/Vector.png')}}" alt="Vector" class="mb-1">&nbsp;<span id="readtime"></span></span> 
        </div>

        <div class="col-12 col-md-12 col-sm-12 col-lg-12 text-start mt-4" id="second_p">    
        </div>
        <div class="col-12 col-md-12 col-sm-12 col-lg-12 text-start mt-4" id="content-blog" style="text-align:justify;">
        </div>

</div>
-->
<div class="row mt-5 pt-5 ps-2 pe-2">

		<div class="col-12 col-md-12 col-sm-12 col-lg-12 mt-4 " id="first_p">   
			<h1 class="blog-post-title subpage-title" data-ix="fade-in-on-load">
				{{ $data['post']->title }}
			</h1>		
		</div>

        <div class="col-12 col-md-12 col-sm-12 col-lg-12 text-start mt-3 border-bottom pb-3">
            <span style="color:#858B91;font-size:13px;" ><img src="{{url('img/jpblog/img/Vector.png')}}" alt="{{ $data['post']->title }}" class="mb-1">&nbsp;<span id="readtime">{{$data['read_time']}}</span></span> 
        </div>
		<div class="body_content">
		{!! $data['post']->body !!}
		</div>
		
</div>



<!-- footer -->

@include('frontend.includes.blog_footer')

</div>


<!--
<script>
        // Get the HTML content from the PHP variable
        var htmlContent = `{!! $data['post']->body !!}`;
        
        // Create a temporary element to hold the content
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = htmlContent;

        // Get the first, second, and remaining p tags
        var firstPTag = tempDiv.querySelector('h1');
        var secondPTag = tempDiv.querySelector('p:nth-child(2)');
        var remainingPTags = tempDiv.querySelectorAll('p:nth-child(n+3)');

        // Append the content of the first p tag to the first container
        var firstContainer = document.getElementById('first_p');
        var newPTag1 = document.createElement('h1');
        newPTag1.innerHTML = firstPTag.innerHTML;
        newPTag1.style.textAlign = 'left';
        // newPTag1.style.marginTop = '20px'; 
        newPTag1.style.fontSize = '30px';
        newPTag1.classList.add("fw-bold");
        firstContainer.appendChild(newPTag1);

    
        

        // Append the content of the second p tag to the second container
        var secondContainer = document.getElementById('second_p');
        var newPTag2 = document.createElement('p');
        newPTag2.innerHTML = secondPTag.innerHTML;
        newPTag2.style.textAlign = 'justify';
        var br1 = document.createElement('br');
        secondContainer.appendChild(newPTag2);
        secondContainer.appendChild(br1);
        

        // Append the content of the remaining p tags to the third container
        var contentBlogContainer = document.getElementById('content-blog');
        remainingPTags.forEach(function(pTag, index) {
            var newPTag = document.createElement('p');
            newPTag.innerHTML = pTag.innerHTML;
            contentBlogContainer.appendChild(newPTag);

            // Add style to every 2nd and subsequent p tags
            if ((index + 1) % 2 === 0) {
                newPTag.style.textAlign = 'justify';
                
                // Add one <br> tags after every 2nd p tag
                var br1 = document.createElement('br');
                contentBlogContainer.appendChild(br1);

            }
        });


        // Assuming you have an element with id "readtime"
        var readtime = document.getElementById('readtime');

        if (readtime) {
            // Extract the date difference using Carbon and format it
            var dateDifference = `{{$data['read_time']}}`;

            // Create a temporary element (span) to hold the content
            var tempDiv = document.createElement('span');
            tempDiv.innerHTML = dateDifference;

            // Clear existing content in the readtime element
            readtime.innerHTML = '';

            // Append the content (span) to the readtime element
            readtime.appendChild(tempDiv);
        }


    </script>
-->    

@endsection


