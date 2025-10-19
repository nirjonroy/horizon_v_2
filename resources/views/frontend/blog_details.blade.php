@extends('frontend.app')
@section('seos')
   

    <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{$blog->title}}">

    <meta name="description" content="{{$blog->description}}">
    
    <!-- Populate the keywords meta tag -->
    <!--<meta name="keywords" content="" /> -->

    <meta property="og:title" content="{{$blog->title}}">
    <meta property="og:description" content="{{$blog->description}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{$blog->title}}">
    <meta property="og:image" content="{{asset($blog->image)}}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
     <meta name="author" content="Imad Haj">
    <meta name="publisher" content="Horizon Unlimited">
    <meta name="copyright" content="Horizon Unlimited">
    <meta name="language" content="english">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset($blog->image)}}">
    

    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$blog->title}}">
    <meta name="twitter:description" content="{{$blog->description}}">
    <meta name="twitter:image" content="{{asset($blog->image)}}">
    <meta name="twitter:site" content="{{ url()->current() }}">
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
