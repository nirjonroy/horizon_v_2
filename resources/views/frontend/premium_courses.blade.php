@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('horizons-global-academy-courses-certificates-robust-deal');
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
    $firstCourseImage = null;
    if (isset($full_access)) {
        $fullAccessCollection = is_iterable($full_access) ? collect($full_access) : collect();
        $firstFullAccess = $fullAccessCollection->first();
        if ($firstFullAccess && isset($firstFullAccess->image)) {
            $firstCourseImage = $firstFullAccess->image;
        }
    }
    if (!$firstCourseImage && isset($all_courses)) {
        if (method_exists($all_courses, 'first')) {
            $firstCourse = $all_courses->first();
        } else {
            $firstCourse = is_iterable($all_courses) ? collect($all_courses)->first() : null;
        }
        if ($firstCourse && isset($firstCourse->image)) {
            $firstCourseImage = $firstCourse->image;
        }
    }
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
                    Horizons Global Academy Courses & Certificates Robust Deal
                </h1>
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                    Get Full Access
                </p>

                <form method="GET" action="{{ route('premium-courses') }}" class="max-w-2xl mx-auto mb-12">
                    <label for="course-search" class="sr-only">Search courses</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            type="search"
                            id="course-search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search courses by title or instructor"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 text-gray-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        <div class="flex gap-3 sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto rounded-md bg-blue-600 px-6 py-2 text-white transition-colors duration-200 hover:bg-blue-700">
                                Search
                            </button>
                            @if($search !== '')
                                <a href="{{ route('premium-courses') }}" class="w-full sm:w-auto rounded-md border border-gray-300 px-6 py-2 text-center text-gray-600 transition-colors duration-200 hover:bg-gray-100">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                @if($search !== '')
                    <p class="mb-8 text-center text-gray-600">
                        Showing results for "<span class="font-semibold">{{ $search }}</span>"
                    </p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($search === '')
                <!--corporate course-->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-full">
            <div class="bg-blue-600 h-2"></div>

            <!-- Thumbnail -->
           <a href="{{ route('consultation.step1') }}"> <img src="https://media.licdn.com/dms/image/v2/C4E0BAQENzzSB5T8UKg/company-logo_200_200/company-logo_200_200/0/1630568961937/corporate_access_logo?e=2147483647&v=beta&t=7RnsWvVMPsIWt25tIBpquCrat23vOMMwAEcI4VAjEig"
                 alt="Course Thumbnail" class="w-full h-48 object-cover rounded-md mb-4" /> </a>

            <div class="p-6 flex flex-col flex-grow">
               <a href="{{ route('consultation.step1') }}"> <h3 class="text-xl font-bold text-blue-800">Enterprise Package</h3> </a>
                <p class="text-gray-600 mb-2"></p>
                <p class="text-gray-700 mb-6 flex-grow">
                    <!-- IT & Business Courses Short Description - Styled -->
<a href="{{ route('consultation.step1') }}">
<div class="ibc-container">
  <h2 class="ibc-heading">Why Choose Our IT & Business Courses?</h2>
  
  <div class="ibc-item">
    <span class="ibc-icon">👨‍💻</span>
    <strong>Expert IT Training</strong> – Learn coding, networking, and the latest tech skills.
  </div>
  
  <div class="ibc-item">
    <span class="ibc-icon">📊</span>
    <strong>Business Growth Skills</strong> – Master marketing, management, and strategy.
  </div>
  
  <div class="ibc-item">
    <span class="ibc-icon">🌍</span>
    <strong>Global Opportunities</strong> – Gain skills that open doors worldwide.
  </div>
  
  <div class="ibc-item">
    <span class="ibc-icon">🤝</span>
    <strong>Trusted by Learners</strong> – 20+ people already contacted us to start learning.
  </div>
</div>
</a>
<style>
/* Container */
.ibc-container {
  max-width: 600px;
  margin: 20px auto;
  font-family: Arial, sans-serif;
  border: 2px solid #ddd;
  border-radius: 10px;
  padding: 20px;
  background: #fff;
}

/* Heading */
.ibc-heading {
  text-align: center;
  font-size: 1.5rem;
  margin-bottom: 20px;
  color: #222;
}

/* Each item */
.ibc-item {
  display: flex;
  align-items: center;
  background: #f7f7f7;
  margin-bottom: 12px;
  padding: 12px 15px;
  border-radius: 8px;
  font-size: 1rem;
  line-height: 1.4;
}

.ibc-item:last-child {
  margin-bottom: 0;
}

/* Icon */
.ibc-icon {
  font-size: 1.3rem;
  margin-right: 10px;
}
</style>

                </p>

                <div class="flex justify-between items-center mb-3">
                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        Unlimited
                    </span>
                    <div class="text-lg font-bold text-blue-800"></div>
                </div>

                <!-- Button stays at bottom -->
                <a href="{{ route('consultation.step1') }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-300 text-center mt-auto">
                    Book Consultation
                </a>
            </div>
        </div>
        @endif
    @forelse($full_access as $course)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-full">
            <div class="bg-blue-600 h-2"></div>

            <!-- Thumbnail -->
           <a href="{{ route('premium-course-details',  $course->slug) }}"> <img src="{{ asset($course->image) }}"
                 alt="Course Thumbnail" class="w-full h-48 object-cover rounded-md mb-4" /> </a>

            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-blue-800"><a href="{{ route('premium-course-details',  $course->slug) }}"> {{ $course->title }} </a> </h3>
                <p class="text-gray-600 mb-2">{{ $course->instructor }}</p>
                <p class="text-gray-700 mb-6 flex-grow">
                 <a href="{{ route('premium-course-details',  $course->slug) }}">   {!! $course->short_description !!} </a>
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

                <!-- Button stays at bottom -->
                <a href="{{ route('premium-course-details', $course->slug) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-300 text-center mt-auto">
                    Enroll Now
                </a>
            </div>
        </div>
    @empty
        @if($search !== '')
            <div class="col-span-full text-center text-gray-600">
                No premium packages match your search.
            </div>
        @endif
    @endforelse
</div>

            </div>
        </section>
    </section>
    <section class="bg-white">
        <section class="py-12 px-4 sm:px-6 lg:px-8" id="courses">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-center mb-2 text-blue-800">
                    Horizons Global Academy Courses & Certificates
                </h2>
                <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">
                    Enhance your skills with our industry-leading courses taught by experts
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($all_courses as $course)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-full">
            <div class="bg-blue-600 h-2"></div>

            <!-- Thumbnail -->
            <img src="{{ asset($course->image) }}"
                 alt="Course Thumbnail" class="w-full h-48 object-cover rounded-md mb-4" />

            <div class="p-6 flex flex-col flex-grow">
                <h3 class="text-xl font-bold text-blue-800">{{ $course->title }}</h3>
                <p class="text-gray-600 mb-2">{{ $course->instructor }}</p>
                <p class="text-gray-700 mb-6 flex-grow">
                    {{ \Illuminate\Support\Str::limit(strip_tags($course->short_description), 150) }}
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

                <!-- Button stays at bottom -->
                <a href="{{ route('premium-course-details', ['slug' => $course->slug, 'id' => $course->id]) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-300 text-center mt-auto">
                    Learn More
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center text-gray-600">
            No courses found. Try a different search term.
        </div>
    @endforelse
</div>

                <!-- Pagination Links -->
                <div class="mt-12 flex justify-center">
                    {{ $all_courses->links() }}
                </div>

            </div>
        </section>
    </section>
@endsection
