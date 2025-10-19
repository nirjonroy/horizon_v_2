@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('blog');
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
    $firstBlog = method_exists($blogs, 'first') ? $blogs->first() : null;
    $firstBlogImage = $firstBlog && isset($firstBlog->image) ? $firstBlog->image : null;
    $rawMetaImage = optional($SeoSettings)->image ?: $firstBlogImage ?: ($siteInfo->logo ?? null);
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
<section
class="max-w-7xl mx-4 pt-8 lg:mx-auto overflow-hidden lg:pb-[90px] bg-white"
>
<div >
    
  <h1
  class="text-3xl lg:text-4xl font-bold text-center text-white bg-blue-950 py-3 mb-8 rounded-md"
>
Horizons of Insight: Explore Our Latest Blogs
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    @foreach($blogs as $blog)
  <!-- CARD 1 -->
  <div
    class="bg-white rounded mx-4 overflow-hidden shadow-lg flex flex-col"
  >
    <a href="{{route('blog.details', $blog->slug)}}"></a>
    <div class="relative">
      <a href="{{route('blog.details', $blog->slug)}}">
        <img
          class="w-full h-60"
          src="{{asset($blog->image)}}"
          alt="Sunset in the mountains"
        />
        <div
          class="hover:bg-transparent transition duration-300 absolute bottom-0 top-0 right-0 left-0 bg-gray-300 opacity-25"
        ></div>
      </a>
    </div>
    <div class="px-6 py-4 mb-auto">
      <a
        href="{{route('blog.details', $blog->slug)}}"
        class="font-medium text-2xl inline-block hover:text-blue-900 transition duration-500 ease-in-out inline-block mb-2"
        >{{$blog->title}}</a
      >
      <p class="text-gray-500 text-sm">
        {!! Str::limit(strip_tags($blog->description), 200) !!}
      </p>
    </div>
    <div
      class="px-6 py-3 flex flex-row items-center justify-between bg-gray-100"
    >
      <span
        href="#"
        class="py-1 text-xs font-regular text-gray-900 mr-1 flex flex-row items-center"
      >
        <svg
          height="13px"
          width="13px"
          version="1.1"
          id="Layer_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          x="0px"
          y="0px"
          viewBox="0 0 512 512"
          style="enable-background: new 0 0 512 512"
          xml:space="preserve"
        >
          <g>
            <g>
              <path
                d="M256,0C114.837,0,0,114.837,0,256s114.837,256,256,256s256-114.837,256-256S397.163,0,256,0z M277.333,256 c0,11.797-9.536,21.333-21.333,21.333h-85.333c-11.797,0-21.333-9.536-21.333-21.333s9.536-21.333,21.333-21.333h64v-128 c0-11.797,9.536-21.333,21.333-21.333s21.333,9.536,21.333,21.333V256z"
              ></path>
            </g>
          </g>
        </svg>
        <span class="ml-1">{{$blog->created_at}}{{$blog->created_at}}</span>
      </span>
      <span
        href="#"
        class="py-1 text-xs font-regular text-gray-900 mr-1 flex flex-row items-center"
      >
        <svg
          class="h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
          ></path>
        </svg>
        <span class="ml-1">39 Comments</span>
      </span>
    </div>
  </div>
  
 @endforeach




</div>
<div class="d-felx justify-content-center">

    {{ $blogs->links() }}

</div>
</div>


</section>
@endsection