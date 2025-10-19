@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('who-we-are');
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
    $rawMetaImage = optional($SeoSettings)->image ?: ($siteInfo->logo ?? null);
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

<!-- ====== About Section Start -->
<!-- Hero Section -->
<section class="bg-gradient-to-r from-primary to-red text-white pt-12 lg:pt-28 py-12 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-6">About Horizons Unlimited</h1>
        <p class="text-xl max-w-3xl mx-auto">Connecting the Middle East with globally accredited online education from top universities worldwide.</p>
    </div>
</section>

<!-- Mission Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Mission</h2>
            <p class="text-xl text-gray-600">To empower students and professionals worldwide by providing personalized, innovative, and accessible educational consulting and elite courses that foster academic excellence, career growth, and lifelong learning.</p>
        </div>
        
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Vision</h2>
            <p class="text-xl text-gray-600">To be the global leader in online educational consulting and elite course provision, transforming lives through exceptional guidance, innovative learning solutions, and a commitment to educational equity.</p>
        </div>
        
       <div class="max-w-4xl mx-auto text-center mb-12">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Core Values:</h2>
    
    @php $abouts = DB::table('abouts')->first(); @endphp
    
    <div class="text-xl text-gray-600 leading-relaxed text-justify space-y-4">
        {!! $abouts->about_us !!}
    </div>
</div>


        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Excellence</h3>
                <p class="text-gray-600">Striving for the highest standards in education, guidance, and service delivery.</p>
            </div>
            
            <div class="bg-blue-100 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-red">
                <div class="text-blue-500 mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Integrity</h3>
                <p class="text-gray-600">Maintaining transparency, honesty, and ethical practices in all interactions.</p>
            </div>
            
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Innovation</h3>
                <p class="text-gray-600">Continuously evolving with cutting-edge technology and teaching methodologies.</p>
            </div>
        </div>

        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Accessibility</h3>
                <p class="text-gray-600">Making quality education and consulting services available to learners everywhere.</p>
            </div>
            
            <div class="bg-blue-100 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-red">
                <div class="text-blue-500 mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Inclusivity</h3>
                <p class="text-gray-600">Embracing diversity and fostering an inclusive environment for all learners.</p>
            </div>
            
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Student-Centricity</h3>
                <p class="text-gray-600">Prioritizing the individual needs, goals, and success of our students and clients.</p>
            </div>
        </div>

        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Career-Driven Skill Development</h3>
                <p class="text-gray-600">Our online programs are designed to enhance employability and career growth across diverse industries.</p>
            </div>
            
            <div class="bg-blue-100 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-red">
                <div class="text-blue-500 mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Accredited Global Partnerships</h3>
                <p class="text-gray-600">Study with top universities in the UK and Europe while living in the Middle East—100% online.</p>
            </div>
            
            <div class="bg-blue-50 p-8 rounded-lg shadow-sm hover:shadow-md transition duration-300 border-t-4 border-blue-500">
                <div class="text-red mb-4">
                    <!-- Icon -->
                </div>
                <h3 class="text-xl font-semibold mb-3 text-gray-800">Flexible & Affordable Learning</h3>
                <p class="text-gray-600">Choose self-paced programs and monthly payment plans with a 30-day money-back guarantee.</p>
            </div>
        </div>
    </div>
</section>
<!-- University Partners -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Our University Partners</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">We collaborate with prestigious institutions to bring you world-class education</p>
        </div>
        @php 
            $universites = DB::table('where_to_studies')->where('status', 1)->get()
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($universites as $uni)
                <div class="bg-white p-6 rounded-lg shadow-sm flex items-center justify-center border-l-4 border-blue-500 hover:border-red transition duration-300">
                <span class="font-semibold text-gray-700">{{$uni->name}}</span>
            </div>
            @endforeach
            
            
            
        </div>
    </div>
</section>
<!-- Premium Courses -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0 md:pr-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Premium Courses</h2>
                <p class="text-gray-600 mb-6">Advance your skills with our premium plans, offering exclusive content, personalized coaching, and a flexible learning experience.</p>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red mr-2 mt-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Monthly subscription plans</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 mt-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">30-day money-back guarantee</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red mr-2 mt-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Exclusive content and resources</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2 mt-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-700">Personalized learning paths</span>
                    </li>
                </ul>
                <button class="bg-gradient-to-r from-primary to-red text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-red-700 transition duration-300 font-medium shadow-md">Explore Premium Plans</button>
            </div>
            <div class="md:w-1/2">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Premium Courses" class="rounded-lg shadow-md w-full border-4 border-blue-500 hover:border-red transition duration-300">
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary to-red text-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6">Start Your Online Learning Journey</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Join learners from UAE, Saudi Arabia, Qatar, Oman, and across the Middle East who are earning accredited UK, US, French and Swiss degrees online.</p>
        <a href="{{ route('apply.now') }}">
            <button
              class="text-[10px] sm:text-base lg:text-lg bg-blue-900 hover:bg-black text-white px-3 py-2 sm:px-5 sm:py-2 rounded-md font-bold transition-colors duration-200"
            >
              Apply Now
            </button>
          </a>
    </div>
</section>

<!-- ====== About Section End -->
@endsection
