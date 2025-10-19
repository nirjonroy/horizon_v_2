@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('horizons-global-academy-free-courses-deal');
    $siteInfo = DB::table('site_information')->first();
    $keywordsArray = $SeoSettings && $SeoSettings->keywords ? json_decode($SeoSettings->keywords, true) : [];
    if (!is_array($keywordsArray)) {
        $keywordsArray = [];
    }
    $normalizeUrl = function ($path) {
        if (!$path) {
            return null;
        }
        return filter_var($path, FILTER_VALIDATE_URL) ? $path : asset($path);
    };
    $firstCourse = isset($full_access) ? (is_iterable($full_access) ? collect($full_access)->first() : null) : null;
    $firstCourseImage = $firstCourse && isset($firstCourse->image) ? $firstCourse->image : null;
    $rawMetaImage = optional($SeoSettings)->image ?: $firstCourseImage ?: ($siteInfo->logo ?? null);
    $metaImage = $normalizeUrl($rawMetaImage);
    $seoTitle = optional($SeoSettings)->seo_title ?? config('app.name');
    $seoDescription = optional($SeoSettings)->seo_description ?? '';
    $siteName = optional($SeoSettings)->site_name ?? $seoTitle;
    $author = optional($SeoSettings)->author ?? ($siteInfo->title ?? config('app.name'));
    $publisher = optional($SeoSettings)->publisher ?? $author;
    $copyright = optional($SeoSettings)->copyright ?? ($siteInfo->title ?? config('app.name'));
    $favicon = $normalizeUrl($siteInfo->logo ?? null);
    $keywordsContent = !empty($keywordsArray) ? implode(', ', $keywordsArray) : '';
@endphp
@section('title', $seoTitle)
@section('seos')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{ $seoTitle }}">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $keywordsContent }}">

    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    @if($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
    @endif
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <!--<meta property="og:image:width" content="1200">-->
    <!--<meta property="og:image:height" content="628">-->

    <meta name="author" content="{{ $author }}">
    <meta name="publisher" content="{{ $publisher }}">
    <meta name="copyright" content="{{ $copyright }}">
    <meta name="language" content="english">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <link rel="canonical" href="{{ url()->current() }}">
    @if($favicon)
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $favicon }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    @if($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif
    <meta name="twitter:site" content="{{ url()->current() }}">
@endsection
@section('content')
    <section class="bg-white">
        <section class="py-12 px-4 sm:px-6 lg:px-8" id="courses">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold text-center mb-2 text-blue-800">
                    Horizons Global Academy Free Courses  Deal
                </h1>
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                    Get Full Access
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($full_access as $course)
    <a href="{{ route('premium-course-details', ['slug' => $course->slug, 'id' => $course->id]) }}"
       class="block bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-full cursor-pointer">
        <div class="bg-blue-600 h-2"></div>
        <!-- Thumbnail -->
        <img src="{{ asset($course->image) }}"
             alt="Course Thumbnail" class="w-full h-48 object-cover rounded-md mb-4" />
        <div class="p-6 flex flex-col flex-grow">
            <h3 class="text-xl font-bold text-blue-800">{{ $course->title }}</h3>
            <p class="text-gray-600 mb-2">{{ $course->instructor }}</p>
            <p class="text-gray-700 mb-6 flex-grow">
                {{ \Illuminate\Support\Str::limit(strip_tags($course->short_description), 120, '...') }}
            </p>
            <div class="flex justify-between items-center mb-3">
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $course->duration }}
                </span>
                <div class="text-lg font-bold text-blue-800">${{ $course->price }}</div>
                    
                    @if($course->old_price)
                     
                    <del class="text-sm font-bold text-red-100" style="color:red">${{ $course->old_price }}</del>
                    @endif

            </div>
            <!-- Optional: You can remove this button or leave it for visual hint -->
            <span class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-300 text-center mt-auto">
                Enroll Now
            </span>
        </div>
    </a>
@endforeach

</div>

            </div>
        </section>
    </section>
   
@endsection