@extends('frontend.app')
@php
    $defaultSiteName = config('app.name', 'Horizons Unlimited');
    $metaTitle = $course->meta_title ?: $course->title;
    $rawDescription = $course->meta_description ?: strip_tags($course->short_description ?? '');
    $metaDescription = \Illuminate\Support\Str::limit($rawDescription, 160, '');
    if (mb_strlen($rawDescription) > 160) {
        $metaDescription = rtrim($metaDescription) . '...';
    }
    $imagePath = $course->meta_image ?: $course->image;
    $metaImage = $imagePath ? asset($imagePath) : '';
    $metaAuthor = $course->author ?: $defaultSiteName;
    $metaPublisher = $course->publisher ?: $defaultSiteName;
    $metaCopyright = $course->copyright ?: 'Copyright ' . $defaultSiteName;
    $metaSiteName = $course->site_name ?: $defaultSiteName;
    $metaKeywords = $course->keywords;
@endphp
@section('title', $metaTitle)
@section('seos')

    <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{ $metaTitle }}">

    <meta name="description" content="{{ $metaDescription }}">
    
    @if($metaKeywords)
        <meta name="keywords" content="{{ $metaKeywords }}" />
    @endif

    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $metaSiteName }}">
    @if($metaImage)
        <meta property="og:image" content="{{ $metaImage }}">
    @endif
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="{{ $metaAuthor }}">
    <meta name="publisher" content="{{ $metaPublisher }}">
    <meta name="copyright" content="{{ $metaCopyright }}">
    <meta name="language" content="english">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <link rel="canonical" href="{{ url()->current() }}">
    @if($metaImage)
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $metaImage }}">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if($metaImage)
        <meta name="twitter:image" content="{{ $metaImage }}">
    @endif
    <meta name="twitter:site" content="{{ $metaSiteName }}">
@endsection
@section('content')
<section class="bg-white ">
 <section class="py-12 px-4 sm:px-6 lg:px-8 bg-gray-100">
    <div class="max-w-7xl mx-auto">
        <!-- Master in Business Details -->
        <div id="master-in-business" class="course-details">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="md:w-2/3">
                            <h2 class="text-3xl font-bold text-blue-800 mb-4">{{ $course->title }}</h2>
                            <div class="flex items-center mb-6">
                                <img src="{{ asset($course->image) }}" alt="Instructor" 
                                     class="w-16 h-16 rounded-full border-2 border-red-500"/>
                                <div class="ml-4">
                                    <p class="text-gray-600 font-medium">Instructor</p>
                                    <p class="text-xl">{{ $course->instructor }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-6">
                                {!! $course->short_description !!}
                            </p>
                            <div class="mb-6">
                                <h3 class="text-xl font-semibold text-blue-800 mb-3">What You'll Learn</h3>
                               {!! $course->long_description !!}
                            </div>
                        </div>
                        <div class="md:w-1/3 md:pl-8 mt-6 md:mt-0">
                            <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                                <h3 class="text-xl font-semibold text-blue-800 mb-4">Course Details</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Duration</p>
                                        <p class="font-medium">{{ $course->duration }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Effort</p>
                                        <p class="font-medium">{{ $course->effort }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Question</p>
                                        <p class="font-medium">{{ $course->questions }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Format</p>
                                        <p class="font-medium">{{ $course->format }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Price</p>
                                        <p class="font-medium">${{ $course->price }}</p>
                                    </div>
                                    <div>
                                         @auth
                                         @if($course->type == "free")
                                         <a href="{{$course->link}}" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Download Courses
                                </a>
                                         @else
                                         
                                    <form action="{{ route('cart.add', $course->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="name" value="{{ $course->title }}">
                                <input type="hidden" name="price" value="{{ $course->price }}">
                                <input type="hidden" name="price" value="{{ $course->image }}">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                                    Add to Cart
                                </button>
                            </form>
                            @endif
                                    @else
                                    @if($course->type == "free")
                                    <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 mt-5 rounded" style="margin-top:5px">
                                        Login to Get Link
                                    </a>
                                    @else
                                    <a href="{{ route('login') }}" class="bg-gray-500 text-white px-4 py-2 mt-5 rounded" style="margin-top:5px">
                                        Login to Add to Cart
                                    </a>
                                    @endif
                                    @endauth
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(isset($mostPopularCourses) && $mostPopularCourses->count())
                    <div class="mt-12 bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-2xl font-bold mb-4 text-blue-800">Most Popular Courses</h3>
                        <div class="flex flex-wrap gap-6">
                            @foreach($mostPopularCourses as $popCourse)
                                <a href="{{ route('premium-course-details', [$popCourse->slug, $popCourse->id]) }}"
                                   class="w-full sm:w-1/2 md:w-1/3 flex-shrink-0 hover:shadow-lg rounded-lg overflow-hidden bg-gray-50 transition-transform duration-150 hover:-translate-y-1">
                                    <img src="{{ asset($popCourse->image) }}"
                                         alt="{{ $popCourse->title }}"
                                         class="w-full h-40 object-cover"/>
                                    <div class="p-4">
                                        <h4 class="text-lg font-semibold text-blue-700 mb-1">{{ $popCourse->title }}</h4>
                                        <p class="text-gray-600 mt-1 text-sm">{!! \Illuminate\Support\Str::limit(strip_tags($popCourse->short_description), 80) !!}</p>
                                        <span class="block mt-2 font-bold text-green-600">${{ $popCourse->price }}</span>
                                        @if(isset($popCourse->order_count))
                                            <span class="block mt-1 text-xs text-gray-400">
                                                Purchased {{ $popCourse->order_count }} {{ $popCourse->order_count == 1 ? 'time' : 'times' }}
                                            </span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif



                    <!--<div class="mt-12">-->
                    <!--    <h3 class="text-xl font-semibold text-blue-800 mb-6">Course Timeline</h3>-->
                    <!--    <div class="space-y-8">-->
                    <!--        <div class="flex">-->
                    <!--            <div class="flex flex-col items-center mr-4">-->
                    <!--                <div class="w-8 h-8 bg-red rounded-full flex items-center justify-center text-white font-bold">1</div>-->
                    <!--                <div class="w-px h-full bg-gray-300"></div>-->
                    <!--            </div>-->
                    <!--            <div class="pb-8">-->
                    <!--                <h4 class="text-lg font-semibold text-gray-800">Week 1-2: Business Foundations</h4>-->
                    <!--                <p class="text-gray-600 mt-2">-->
                    <!--                    Understanding business models, market analysis, and competitive positioning.-->
                    <!--                </p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--        <div class="flex">-->
                    <!--            <div class="flex flex-col items-center mr-4">-->
                    <!--                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">2</div>-->
                    <!--                <div class="w-px h-full bg-gray-300"></div>-->
                    <!--            </div>-->
                    <!--            <div class="pb-8">-->
                    <!--                <h4 class="text-lg font-semibold text-gray-800">Week 3-4: Financial Mastery</h4>-->
                    <!--                <p class="text-gray-600 mt-2">-->
                    <!--                    Financial statements analysis, budgeting, and investment decision making.-->
                    <!--                </p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--        <div class="flex">-->
                    <!--            <div class="flex flex-col items-center mr-4">-->
                    <!--                <div class="w-8 h-8 bg-red rounded-full flex items-center justify-center text-white font-bold">3</div>-->
                    <!--                <div class="w-px h-full bg-gray-300"></div>-->
                    <!--            </div>-->
                    <!--            <div class="pb-8">-->
                    <!--                <h4 class="text-lg font-semibold text-gray-800">Week 5-6: Leadership & Strategy</h4>-->
                    <!--                <p class="text-gray-600 mt-2">-->
                    <!--                    Developing leadership skills and creating winning business strategies.-->
                    <!--                </p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--        <div class="flex">-->
                    <!--            <div class="flex flex-col items-center mr-4">-->
                    <!--                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">4</div>-->
                    <!--            </div>-->
                    <!--            <div>-->
                    <!--                <h4 class="text-lg font-semibold text-gray-800">Week 7-8: Capstone Project</h4>-->
                    <!--                <p class="text-gray-600 mt-2">-->
                    <!--                    Apply all learned concepts to a real-world business challenge.-->
                    <!--                </p>-->
                    <!--            </div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </div>
            <div class="text-center mt-8">
                <a href="{{route('premium-courses')}}" class="text-blue-600 hover:text-blue-800 font-medium">← Back to all courses</a>
            </div>
        </div>

        

       
    </div>
</section>
  </section>
@endsection
