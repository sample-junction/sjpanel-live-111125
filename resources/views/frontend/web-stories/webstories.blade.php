@extends('frontend.layouts.app_blog')
@section('content')
<div class="container">
    <section class="container" style="margin-top: 15%">
        <!-- Wrapped listing inside a styled div -->
        <div class="status-container">
            <div class="status-grid">
                @foreach($storyArray as $storyKey => $statuses)
                    @php
                        // Remove 'thumbnail' key before passing to JavaScript
                        $filteredStatuses = array_diff_key($statuses, ['thumbnail' => '']);
                        $srcUrl = 'https://www.samplejunction.com/' . $statuses['thumbnail'];
                    @endphp
                    <div class="status-box text-center" onclick="openStoryStatus('{{ $statuses['slug'] }}')">
                        <img src="{{ $srcUrl }}" alt="Status" class="status-img">
                        <h4 class="status-title">{{ $storyKey }}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <div class="container">
        @include('frontend.includes.blog_footer')
    </div>
</div>

<!-- Styles -->
<!-- <style>

    /* Light background container */
    .status-container {
        background: #ffffff; /* White background */
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15); /* Strong shadow effect */
        max-width: 1200px; /* Limit width for a clean look */
        margin: 100px auto; /* Center the container */
    }

    /* Grid layout */
    .status-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    /* Story box with white background */
    .status-box {
        text-align: center;
        cursor: pointer;
        padding: 15px;
        background: white; /* Ensures the box is visible */
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    /* Hover effect */
    .status-box:hover {
        transform: scale(1.05);
    }

    /* Image styling */
    .status-img {
        width: 100%;
        aspect-ratio: 6 / 10; /* Ensures correct ratio */
        border-radius: 10px;
        object-fit: cover;
        background: white; /* Background behind images */
        padding: 5px; /* Adds spacing */
    }

    /* Story title */
    .status-title {
        font-size: 14px;
        margin-top: 10px;
        color: black;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .status-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .status-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .status-grid {
            grid-template-columns: repeat(1, 1fr);
        }
    }


</style> -->
@endsection
    
<!-- JavaScript -->
<script>
    function openStoryStatus(slug) {
        const url = `/web-stories/${encodeURIComponent(slug)}`;
        window.location.href = url;
    }
</script>
