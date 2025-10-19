@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('home');
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
    $sliderImage = isset($slider) && !empty($slider->image) ? $slider->image : null;
    $rawMetaImage = optional($SeoSettings)->image ?: $sliderImage ?: ($siteInfo->logo ?? null);
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
<!-- Hero -->
<div class="relative w-full">
  <img
    class="w-full h-[520px] lg:h-[640px] object-cover object-center"
    src="{{ asset($slider->image) }}"
    alt="Study Online with Top Universities - Horizons Unlimited"
    loading="lazy"
  />

  <!-- Overlay for contrast -->
  <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/70 to-slate-900/30"></div>

  <!-- Move content up: top-* positions keep text off faces -->
  <div class="absolute left-1/2 -translate-x-1/2 
              top-10 sm:top-16 lg:top-24
              z-10 w-full max-w-5xl px-4 text-center">

    <span class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-white drop-shadow">
      Study Online with
    </span>

    <h1 class="mt-1 block text-3xl sm:text-5xl lg:text-6xl font-extrabold text-[#EA5455] drop-shadow">
      Top Universities &amp; Premium Courses
    </h1>

    <p class="mt-4 max-w-2xl mx-auto text-sm sm:text-base lg:text-lg text-slate-200">
      Earn accredited degrees and premium online certifications, including MBA, BBA, and career-focused programs for learners across the world.
    </p>
  </div>
</div>

<section class="max-w-7xl mx-auto px-4 py-10 lg:py-20">
  <!-- Section Header -->
  <div class="text-center mb-10 lg:mb-16">
    <h2 class="text-4xl md:text-5xl xl:text-6xl font-extrabold text-[#213555] tracking-tight leading-none">
      Horizons Global Academy Courses
    </h2>
    <p class="mt-4 lg:mt-6 mx-auto max-w-3xl text-sm lg:text-lg text-[#4F709C] font-semibold text-gray-600">
      Enhance your skills with our industry-leading courses taught by experts.
    </p>
    <!-- <a href="{{ route('premium-courses') }}"
       class="inline-block mt-4 text-sm lg:text-base font-semibold text-[#EA5455] hover:text-[#213555] transition-colors duration-200">
      Learn more
    </a> -->
  </div>

  <!-- Study Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($premiumCourses as $course)
    
        <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 flex flex-col h-full">
            <div class="bg-blue-600 h-2"></div>

            <!-- Thumbnail -->
             <a href="{{ route('premium-course-details',$course->slug) }}">
            <img src="{{ asset($course->image) }}"
                 alt="Course Thumbnail" class="w-full h-48 object-cover rounded-md mb-4" />
              </a>

            <div class="p-6 flex flex-col flex-grow">
              <a href="{{ route('premium-course-details',$course->slug) }}">
                <h3 class="text-xl font-bold text-blue-800">{{ $course->title }}</h3>
                </a>
                <p class="text-gray-600 mb-2">{{ $course->instructor }}</p>
                <p class="text-gray-700 mb-6 flex-grow">
                    {{ \Illuminate\Support\Str::limit(strip_tags($course->short_description), 150) }}
                </p>

                <div class="flex justify-between items-center mb-3">
                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $course->duration }}
                    </span>
                    <div class="text-lg font-bold text-blue-800">${{ $course->price }}</div>
                </div>

                <!-- Button stays at bottom -->
                <!-- <a href="{{ route('premium-course-details',$course->slug) }}"
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors duration-300 text-center mt-auto">
                    Learn More
                </a> -->
            </div>
        </div>
    @endforeach
     </div>
  <div class="flex justify-center mt-8">
  <a href="{{ route('premium-courses') }}"
     class="bg-black hover:bg-gray-800 text-white font-semibold py-3 px-8 rounded-lg shadow transition-colors duration-300 text-lg">
    Explore All Courses
  </a>
</div>

  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-10 lg:py-20">
  <!-- Section Header -->
  <div class="text-center mb-10 lg:mb-16">
    <h2 class="text-4xl md:text-5xl xl:text-6xl font-extrabold text-[#213555] tracking-tight leading-none">
      Where to study
    </h2>
    <p class="mt-4 lg:mt-6 mx-auto max-w-3xl text-sm lg:text-lg text-[#4F709C] font-semibold text-gray-600">
      Prepare for your future at one of our impressive university partners, in
      exciting destinations around the world.
    </p>
  </div>

  <!-- Study Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($whereToStudies as $study)
      <a href="{{ route('where.to.study', $study->slug) }}" class="group">
        <div class="h-full flex flex-col rounded-lg overflow-hidden shadow-lg transition-transform duration-300 group-hover:shadow-xl group-hover:-translate-y-1">
          <!-- Card Image -->
          <div class="h-48 overflow-hidden">
            <img 
              class="w-full h-full object-cover"
              src="{{ asset($study->slider1) }}"
              alt="{{ $study->name }}"
              loading="lazy"
            />
          </div>
          
          <!-- Card Content -->
          <div class="flex-1 p-6 flex flex-col">
            <h3 class="text-xl font-bold mb-3 text-gray-800">{{ $study->name }}</h3>
            <p class="text-gray-600 mb-6 line-clamp-3">
              {!! Str::limit(strip_tags($study->short_description), 150) !!}
            </p>
            
            <!-- Button -->
            <div class="mt-auto">
              <!-- <button class="bg-[#213555] hover:bg-[#213555]-dark text-white font-bold py-3 px-6 rounded-md transition-colors duration-300 text-sm">
                View More
              </button> -->
            </div>
          </div>
        </div>
      </a>
    @endforeach
  </div>
</section>
 <div class="bg-[#213555] py-20 md:px-4">
  <div class="max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between px-4">
    <div class="text-center md:text-left mb-10 md:mb-0 md:max-w-[50%]">
      <h2 class="text-white text-start text-4xl md:text-5xl xl:text-6xl font-extrabold mb-4 leading-none">
        We Offer
      </h2>
      <div class="w-20 h-1 bg-white mb-10 md:mb-0 md:w-32"></div>
      <div class="flex mt-10 flex-col gap-5">
        <!-- First item -->
        <div class="flex items-center gap-5">
          <img 
            class="w-14 h-14" 
            src="{{ asset('frontend/images/icons/arrow-right.png') }}" 
            alt="arrow-icon"
            width="56" 
            height="56"
            loading="lazy"
          />
          <p class="text-2xl md:text-3xl font-semibold text-white">
            Degree Preparation
          </p>
        </div>
        
        <!-- Second item -->
        <div class="flex items-center gap-5">
          <img 
            class="w-14 h-14" 
            src="{{ asset('frontend/images/icons/arrow-right.png') }}" 
            alt="arrow-icon"
            width="56" 
            height="56"
            loading="lazy"
          />
          <p class="text-2xl md:text-3xl font-semibold text-white">
            Degree Admission
          </p>
        </div>
        
        <!-- Third item -->
        <div class="flex items-center gap-5">
          <img 
            class="w-14 h-14" 
            src="{{ asset('frontend/images/icons/arrow-right.png') }}" 
            alt="arrow-icon"
            width="56" 
            height="56"
            loading="lazy"
          />
          <p class="text-2xl md:text-3xl font-semibold text-white">
            Support at every step
          </p>
        </div>
      </div>
    </div>
    
    <!-- Student image -->
    <img
      class="w-full md:max-w-[50%] h-auto rounded md:block hidden"
      src="{{ asset('frontend/images/student1.png') }}"
      alt="student-image"
      width="600"
      height="600"
      loading="lazy"
    />
  </div>
</div>
<!-- Testimonials Slider Section -->
<section class="relative max-w-7xl mx-auto bg-gray-50 py-12 lg:py-20 overflow-hidden">
  <!-- Background shapes -->
  <div class="absolute inset-0 z-0 flex">
    <div class="w-1/3 bg-white"></div>
    <div class="w-2/3 ml-16 bg-gray-100"></div>
  </div>

  <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <h3 class="text-4xl md:text-5xl xl:text-6xl font-extrabold tracking-tight mb-8 lg:mb-12">
      <span class="hidden xl:inline-block">What our Students<br>saying</span>
      <span class="xl:hidden">What our Students are saying</span>
    </h3>

    <!-- Swiper Container -->
    <div class="swiper testimonial-swiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide">
          <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            <div class="relative lg:w-1/2">
              <img
                src="https://img.freepik.com/premium-photo/smiling-muslim-young-female-student-holding-books-standing-near-college-happy-arabian-girl-hijab-asian-woman-training_8119-2351.jpg"
                alt="Natalie from Malaysia"
                class="w-full h-80 lg:h-96 object-cover rounded-lg shadow-lg"
                loading="lazy"
                width="400"
                height="500"
              >-r
              
            </div>
            <div class="lg:w-1/2 flex flex-col justify-between">
              <blockquote class="text-2xl md:text-3xl lg:text-4xl font-bold italic text-gray-800 mb-6">
                "Studying abroad was a life-changing experience for me — it made me who I am today"
              </blockquote>
              <div>
                <p class="text-lg font-semibold text-gray-800">Natalie from Malaysia, University of Brighton graduate</p>
                <p class="text-gray-600">Now working as a Biomedical Scientist</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="swiper-slide">
          <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
            <div class="relative lg:w-1/2">
              <img
                src="https://t3.ftcdn.net/jpg/04/31/07/04/360_F_431070449_IQITpySvnxJenE8QVkuUIiEyTdFqPkYY.jpg"
                alt="Student from abroad"
                class="w-full h-80 lg:h-96 object-cover rounded-lg shadow-lg"
                loading="lazy"
                width="400"
                height="500"
              >
             
            </div>
            <div class="lg:w-1/2 flex flex-col justify-between">
              <blockquote class="text-2xl md:text-3xl lg:text-4xl font-bold italic text-gray-800 mb-6">
                "Living in a foreign country transformed me in ways I never imagined — it shaped the person I've become"
              </blockquote>
              <div>
                <p class="text-lg font-semibold text-gray-800">Natalie from Malaysia, University of Brighton graduate</p>
                <p class="text-gray-600">Now working as a Biomedical Scientist</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-center mt-8 lg:mt-12">
        <button class="testimonial-swiper-prev p-3 rounded-full hover:bg-gray-200 transition-colors mr-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
        <button class="testimonial-swiper-next p-3 rounded-full hover:bg-gray-200 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>

<!-- Swiper JS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
      loop: true,
      speed: 600,
      effect: 'slide',
      grabCursor: true,
      navigation: {
        nextEl: '.testimonial-swiper-next',
        prevEl: '.testimonial-swiper-prev',
      },
    });
  });
</script>

<!-- Optional: Add some basic Swiper styles -->
<style>
  .testimonial-swiper {
    width: 100%;
    padding-bottom: 40px;
  }
  .swiper-slide {
    opacity: 0 !important;
    transition: opacity 0.3s ease;
  }
  .swiper-slide-active,
  .swiper-slide-duplicate-active {
    opacity: 1 !important;
  }
</style>
<!-- News Section -->
<section class="py-16 bg-[#213555]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Section Header -->
    <div class="text-center mb-12 lg:mb-16">
      <h2 class="text-4xl md:text-5xl xl:text-6xl font-bold text-white leading-tight">
        New at Horizons Unlimited
      </h2>
      <div class="mt-4 h-1 w-20 bg-white mx-auto"></div>
    </div>

    <!-- Blog Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($blogs as $blog)
        @continue(empty($blog->id))
        
        <article class="group transition-all duration-300 hover:-translate-y-2">
          <a href="{{ route('blog.details', $blog->slug) }}" class="block h-full">
            <!-- Card Container -->
            <div class="h-full bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col">
              <!-- Image -->
              @if(!empty($blog->image))
                <div class="relative overflow-hidden h-52">
                  <img
                    src="{{ asset($blog->image) }}"
                    alt="{{ $blog->title ?? 'Blog post image' }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    loading="lazy"
                  />
                  <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
              @endif

              <!-- Content -->
              <div class="p-6 flex-1 flex flex-col">
                <!-- Date -->
                @isset($blog->created_at)
                  <span class="text-sm text-gray-500 mb-2">
                    {{ $blog->created_at->format('F j, Y') }}
                  </span>
                @endisset

                <!-- Title -->
                @isset($blog->title)
                  <h3 class="text-lg lg:text-xl font-bold text-gray-800 mb-3 group-hover:text-[#213555] transition-colors">
                    {{ $blog->title }}
                  </h3>
                @endisset

                <!-- Excerpt -->
                @isset($blog->description)
                  <p class="text-gray-600 text-base mb-4 line-clamp-3">
                    {!! Str::limit(strip_tags($blog->description), 150) !!}
                  </p>
                @endisset

                <!-- Read More -->
                <div class="mt-auto pt-4 border-t border-gray-100">
                  <span class="text-[#213555] font-semibold flex items-center">
                    Read more
                    <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
              </div>
            </div>
          </a>
        </article>
      @endforeach
    </div>
  </div>
</section>

  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li style="color: red">{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <div class="max-w-7xl mx-auto p-5">
    <div class="grid grid-cols-1 md:grid-cols-12 border">
      <div class="bg-[#213555] rounded-md md:col-span-4 p-10 text-white">
        <p class="mt-4 text-sm leading-7 font-regular uppercase">Contact</p>
        <h3
          class="text-3xl sm:text-4xl leading-normal font-extrabold tracking-tight"
        >
          Get In <span class="text-yellow-400">Touch</span>
        </h3>
        <p class="mt-4 leading-7 text-gray-200">
          {!!$info->description!!}
        </p>

        <div class="flex items-center mt-5">
          <svg
            class="h-6 mr-2 text-yellow-400"
            fill="currentColor"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 489.536 489.536"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            enable-background="new 0 0 489.536 489.536"
          >
            <g>
              <g>
                <path
                  d="m488.554,476l-99-280.2c-1-4.2-5.2-7.3-9.4-7.3h-45.6c12.9-31.1 19.6-54.9 19.6-70.8 0-64.6-50-117.7-112.5-117.7-61.5,0-112.5,52.1-112.5,117.7 0,17.6 8.2,43.1 19.9,70.8h-39.7c-4.2,0-8.3,3.1-9.4,7.3l-99,280.2c-3.2,10.3 6.3,13.5 9.4,13.5h468.8c4.2,0.5 12.5-4.2 9.4-13.5zm-246.9-455.3c51,1.06581e-14 91.7,43.7 91.7,96.9 0,56.5-79.2,182.3-91.7,203.1-31.3-53.1-91.7-161.5-91.7-203.1 0-53.1 40.6-96.9 91.7-96.9zm-216.7,448l91.7-259.4h41.7c29.9,64.1 83.3,151 83.3,151s81.4-145.7 83.8-151h47.4l91.7,259.4h-439.6z"
                ></path>
                <rect
                  width="136.5"
                  x="177.054"
                  y="379.1"
                  height="20.8"
                ></rect>
                <path
                  d="m289.554,108.2c0-26-21.9-47.9-47.9-47.9s-47.9,21.9-47.9,47.9 20.8,47.9 47.9,47.9c27.1,0 47.9-21.8 47.9-47.9zm-75-1c0-14.6 11.5-27.1 27.1-27.1s27.1,12.5 27.1,27.1-11.5,27.1-27.1,27.1c-14.6,2.84217e-14-27.1-12.5-27.1-27.1z"
                ></path>
              </g>
            </g>
          </svg>
          <span class="text-sm"
            >{{$info->address}}</span
          >
        </div>
        <div class="flex items-center mt-5">
          <svg
            class="h-6 mr-2 text-yellow-400"
            fill="currentColor"
            version="1.1"
            id="Capa_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 60.002 60.002"
            style="enable-background: new 0 0 60.002 60.002"
            xml:space="preserve"
          >
            <g>
              <path
                d="M59.002,37.992c-3.69,0-6.693-3.003-6.693-6.693c0-0.553-0.447-1-1-1s-1,0.447-1,1c0,4.794,3.899,8.693,8.693,8.693
    c0.553,0,1-0.447,1-1S59.554,37.992,59.002,37.992z"
              ></path>
              <path
                d="M58.256,35.65c0.553,0,1-0.447,1-1s-0.447-1-1-1c-0.886,0-1.605-0.72-1.605-1.605c0-0.553-0.447-1-1-1s-1,0.447-1,1
    C54.65,34.033,56.267,35.65,58.256,35.65z"
              ></path>
              <path
                d="M20.002,2.992c3.691,0,6.693,3.003,6.693,6.693c0,0.553,0.448,1,1,1s1-0.447,1-1c0-4.794-3.9-8.693-8.693-8.693
    c-0.552,0-1,0.447-1,1S19.449,2.992,20.002,2.992z"
              ></path>
              <path
                d="M19.748,6.334c0,0.553,0.448,1,1,1c0.885,0,1.604,0.72,1.604,1.605c0,0.553,0.448,1,1,1s1-0.447,1-1
    c0-1.988-1.617-3.605-3.604-3.605C20.196,5.334,19.748,5.781,19.748,6.334z"
              ></path>
              <path
                d="M44.076,37.889c-1.276-0.728-2.597-0.958-3.721-0.646c-0.844,0.234-1.532,0.768-1.996,1.546
    c-1.02,1.22-2.286,2.646-2.592,2.867c-2.367,1.604-4.25,1.415-6.294-0.629L17.987,29.542c-2.045-2.045-2.233-3.928-0.631-6.291
    c0.224-0.31,1.65-1.575,2.87-2.596c0.778-0.464,1.312-1.152,1.546-1.996c0.311-1.123,0.082-2.444-0.652-3.731
    c-0.173-0.296-4.291-7.27-8.085-9.277c-1.926-1.019-4.255-0.669-5.796,0.872L4.7,9.059c-4.014,4.014-5.467,8.563-4.321,13.52
    c0.956,4.132,3.742,8.529,8.282,13.068l14.705,14.706c5.762,5.762,11.258,8.656,16.298,8.656c3.701,0,7.157-1.562,10.291-4.695
    l2.537-2.537c1.541-1.541,1.892-3.87,0.872-5.796C51.356,42.186,44.383,38.069,44.076,37.889z M51.078,50.363L48.541,52.9
    c-6.569,6.567-14.563,5.235-23.76-3.961L10.075,34.233c-4.271-4.271-6.877-8.344-7.747-12.104
    c-0.995-4.301,0.244-8.112,3.786-11.655l2.537-2.537c0.567-0.566,1.313-0.862,2.07-0.862c0.467,0,0.939,0.112,1.376,0.344
    c3.293,1.743,7.256,8.454,7.29,8.511c0.449,0.787,0.62,1.608,0.457,2.196c-0.1,0.36-0.324,0.634-0.684,0.836l-0.15,0.104
    c-0.853,0.712-2.883,2.434-3.308,3.061c-0.612,0.904-1.018,1.792-1.231,2.665c-0.711-1.418-1.286-3.06-1.475-4.881
    c-0.057-0.548-0.549-0.935-1.098-0.892c-0.549,0.058-0.949,0.549-0.892,1.099c0.722,6.953,6.129,11.479,6.359,11.668
    c0.025,0.02,0.054,0.028,0.08,0.045l10.613,10.613c0.045,0.045,0.092,0.085,0.137,0.129c0.035,0.051,0.058,0.108,0.104,0.154
    c0.189,0.187,4.704,4.567,11.599,5.283c0.035,0.003,0.07,0.005,0.104,0.005c0.506,0,0.94-0.383,0.994-0.896
    c0.057-0.55-0.342-1.041-0.892-1.099c-2.114-0.219-3.987-0.839-5.548-1.558c0.765-0.23,1.543-0.612,2.332-1.146
    c0.628-0.426,2.35-2.455,3.061-3.308l0.104-0.151c0.202-0.359,0.476-0.583,0.836-0.684c0.588-0.159,1.409,0.008,2.186,0.45
    c0.067,0.04,6.778,4.003,8.521,7.296C52.202,48.062,51.994,49.447,51.078,50.363z"
              ></path>
            </g>
          </svg>
          <span class="text-sm">{{$info->mobile1}}</span>
        </div>
        <div class="flex items-center mt-5">
          <svg
            class="h-6 mr-2 text-yellow-400"
            fill="currentColor"
            version="1.1"
            id="Capa_1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            x="0px"
            y="0px"
            viewBox="0 0 300.988 300.988"
            style="enable-background: new 0 0 300.988 300.988"
            xml:space="preserve"
          >
            <g>
              <g>
                <path
                  d="M150.494,0.001C67.511,0.001,0,67.512,0,150.495s67.511,150.493,150.494,150.493s150.494-67.511,150.494-150.493
                S233.476,0.001,150.494,0.001z M150.494,285.987C75.782,285.987,15,225.206,15,150.495S75.782,15.001,150.494,15.001
                s135.494,60.782,135.494,135.493S225.205,285.987,150.494,285.987z"
                ></path>
                <polygon
                  points="142.994,142.995 83.148,142.995 83.148,157.995 157.994,157.995 157.994,43.883 142.994,43.883 		"
                ></polygon>
              </g>
            </g>
          </svg>
          <span class="text-sm">24/7</span>
        </div>
      </div>



        <form action="{{route('contact.form')}}" method="POST" class="md:col-span-8 p-4 lg:p-10">
            @CSRF
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-first-name"
            >
              First Name
            </label>
            <input
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
              id="grid-first-name"
              type="text"
              placeholder="Jane"
              name="first_name"
            />
            <p class="text-red-500 text-xs italic">
              Please fill out this field.
            </p>
          </div>
          <div class="w-full md:w-1/2 px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-last-name"
            >
              Last Name
            </label>
            <input
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-last-name"
              type="text"
              placeholder="Doe"
              name="last_name"
            />
          </div>
        </div>
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-password"
            >
              Email Address
            </label>
            <input
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              id="grid-email"
              type="email"
              placeholder="********@*****.**"
              name="email"
            />
          </div>
        </div>

        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full px-3">
            <label
              class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
              for="grid-password"
            >
              Your Message
            </label>
            <textarea
              rows="10"
              class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
              name="message"
            ></textarea>
          </div>
          <div class="flex justify-between w-full px-3">
            <div class="md:flex md:items-center">
              <label class="block text-gray-500 font-bold">
                <input class="mr-2 leading-tight" type="checkbox" />
                <span class="text-sm"> Send me your newsletter! </span>
              </label>
            </div>
            <button
              class="shadow bg-[#213555] hover:bg-white-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-6 rounded"
              type="submit"
            >
              Send Message
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--End Contact Us-->
@endsection
