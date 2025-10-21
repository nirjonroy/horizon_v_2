@extends('frontend.app')
@php
    $defaultSiteName = config('app.name', 'Horizons Unlimited');
    $metaTitle = $blog->meta_title ?: $blog->title;
    $rawDescription = $blog->meta_description ?: strip_tags($blog->description ?? '');
    $metaDescription = \Illuminate\Support\Str::limit($rawDescription, 160, '');
    if (mb_strlen($rawDescription) > 160) {
        $metaDescription = rtrim($metaDescription) . '...';
    }
    $imagePath = $blog->meta_image ?: $blog->image;
    $metaImage = $imagePath ? asset($imagePath) : '';
    $metaAuthor = $blog->author ?: $defaultSiteName;
    $metaPublisher = $blog->publisher ?: $defaultSiteName;
    $metaCopyright = $blog->copyright ?: 'Copyright ' . $defaultSiteName;
    $metaSiteName = $blog->site_name ?: $defaultSiteName;
    $metaKeywords = $blog->keywords;
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
    <meta property="og:image" content="{{ $metaImage }}">
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
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $metaImage }}">
    

    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta name="twitter:site" content="{{ $metaSiteName }}">
@endsection
@section('content')
 <!--Blog Details-->
<div class="max-w-7xl mx-auto">


    <main >

      <div class="mb-4 md:mb-0 w-full max-w-screen-md mx-auto relative" style="height: 24em;">
        <div class="absolute left-0 bottom-0 w-full h-full z-10"
          style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
        <img src="{{asset($blog->image)}}" class="absolute left-0 top-0 w-full rounded-lg h-full z-0 object-cover" />
        <div class="p-4 absolute bottom-0 left-0 z-20">

          <h2 class="text-4xl font-semibold text-gray-100 leading-tight">
            {{$blog->title}}
          </h2>
          <div class="flex mt-3">
            {{-- <img src="https://randomuser.me/api/portraits/men/97.jpg"
              class="h-10 w-10 rounded-full mr-2 object-cover" />
            <div> --}}
              {{-- <p class="font-semibold text-gray-200 text-sm"> Mike Sullivan </p> --}}
              <p class="font-semibold text-gray-400 text-xs"> {{$blog->created_at}} </p>
            </div>
          </div>
        </div>
      </div>

      <div class="px-4 lg:px-0 mt-12 text-gray-700 max-w-screen-md mx-auto text-lg leading-relaxed">
        <p class="pb-6">
            {!!$blog->description!!}
        </p>



      </div>
    </main>
    <!-- main ends here -->


  </div>
<!--End Blog Details-->
@endsection
