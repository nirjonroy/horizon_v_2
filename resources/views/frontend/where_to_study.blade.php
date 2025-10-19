@extends('frontend.app')

@section('title', $studies->name)
@section('seos')
    @php
        $SeoSettings = DB::table('seo_settings')->where('id', 1)->first();
        // Decode the keywords JSON string into an array
        $keywordsArray = json_decode($studies->keywords, true);
    @endphp

    <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{$studies->meta_title}}">

    <meta name="description" content="{{$studies->meta_description}}">
    
    <!-- Populate the keywords meta tag -->
    <meta name="keywords" content="{{ isset($keywordsArray) ? implode(', ', $keywordsArray) : '' }}" /> 

    <meta property="og:title" content="{{$studies->meta_title}}">
    <meta property="og:description" content="{{$studies->meta_description}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{$studies->meta_title}}">
    <meta property="og:image" content="{{asset($studies->slider1)}}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection

@section('content')
<!--University Slider-->
<section class="bg-white">
  <!-- Hero Section -->
  <div class="max-w-7xl mx-auto px-4 py-8  lg:py-12">
    <div class="flex flex-col md:flex-row items-center gap-8">
      <div class="md:w-1/2">
        <h1 class="text-4xl md:text-5xl font-bold text-blue-900 mb-6">{{ $studies->name }}</h1>
        <p class="text-lg text-gray-600 mb-6">
          {!! $studies->short_description !!}
        </p>
         <div class="flex gap-4 mt-4">
          <a style="background:red" href="{{route('consultation.step1')}}" class="bg-red-800 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300 font-medium shadow-md">
          Book Consultaion
        </a>
        <a href="{{route('apply.now')}}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-300 font-medium shadow-md">
          Apply Now
        </a>
        </div>
      </div>
      <div class="md:w-1/2">
        <img src="{{asset($studies->slider1)}}">
      </div>
    </div>
  </div>

  <!-- Popular Courses Section -->

<div class="bg-blue-50 py-16">
  <div class="max-w-7xl mx-auto px-4">
    <h2 class="text-3xl font-bold text-center text-blue-800 mb-12">Our Popular Courses</h2>
    
    <div class="grid md:grid-cols-3 gap-8">
      <!-- Course 1 -->
      @foreach ($latest_course as $item)
      
     
      <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 border-t-4 border-blue-500 relative">
        <!-- Discount Badge -->
        @if($item->yearly != 0)
        <div class="absolute -top-2 -right-2 bg-red text-white font-bold px-3 py-1 rounded-full text-sm">
            
          <!--SAVE {{ number_format(((float)$item->yearly / (float)$item->total_fee) * 100, 2) }}%-->
          SAVE ({{ (int)(((float)$item->total_fee - (float)$item->yearly) / (float)$item->total_fee * 100) }}% OFF)
           

        </div>
         @endif
        <h3 class="text-xl font-semibold text-blue-900 mb-3">{{$item->short_name}}</h3>
        <p class="text-gray-600 mb-4">{!! $item->short_description !!}</p>
        <div class="flex justify-between items-center">
          <div class="flex flex-col">
              @if($item->yearly != 0)
            <span class="font-bold text-red text-xl">${{number_format($item->yearly, 2)}}</span>
            <span class="font-medium text-gray-400 line-through text-sm">${{number_format($item->total_fee, 2)}}</span>
            @else
            <span class="font-bold text-red text-xl">${{number_format($item->total_fee, 2)}}</span>
            @endif
          </div>
          @if($item->link != null)
          <a href="{{$item->link}}" class="bg-blue-800 hover:bg-blue-800 text-white px-3 py-1 rounded-lg font-medium transition duration-300" target="_blank">
            Apply Now →
          </a>
          @else
          <a href="{{route('apply.now')}}" class="bg-blue-800 hover:bg-blue-800 text-white px-3 py-1 rounded-lg font-medium transition duration-300">
            Apply Now →
          </a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- All Programs Section -->
<div class="max-w-7xl mx-auto px-4 py-16">
  @foreach($categories as $category)
  <!-- Online Bachelor's -->
  <div class="mb-16">
    <h3 class="text-2xl font-semibold text-blue-800 mb-6 border-b pb-2">{{$studies->name}} {{ $category->name }}'s Programs</h3>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-blue-100">
          <tr>
            <th class="py-3 px-4 text-left font-semibold text-blue-700">Programs</th>
            <th class="py-3 px-4 text-left font-semibold text-blue-700">Total Tuition Fees</th>
            <th class="py-3 px-4 text-left font-semibold text-blue-700">Discount Price</th>
            <th class="py-3 px-4 text-left font-semibold text-blue-700">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-blue-200">
          @foreach($category->onlineFees as $fee)
         
          <tr class="hover:bg-blue-50">
            <td class="py-4 px-4">{{ $fee->program }}</td>
            <td class="py-4 px-4">
              <span class="text-gray-500">${{number_format( $fee->total_fee, 2) }}</span>
            </td>
            <td class="py-4 px-4">
                @if($fee->yearly != 0)
              <span class="font-semibold text-red-600">${{number_format( $fee->yearly, 2) }}</span>
              @else
              <span class="text-gray-500">${{number_format( $fee->total_fee, 2) }}</span>
              @endif
              
              
              @if($fee->yearly != 0)
              <span class="block text-xs text-green-600">
                SAVE ({{ (int)((($fee->total_fee - $fee->yearly) / $fee->total_fee) * 100) }}% OFF)


             </span>

              @endif
            </td>
            <td class="py-4 px-4">
                @if($fee->link != null)
               <a href="{{ $fee->link }}" 
                 class="bg-red/70 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium text-sm transition duration-300 whitespace-nowrap" target="_blank">
                Apply Now
              </a>
              @else
             
              <a href="{{ route('apply.now', ['program' => $fee->program]) }}" 
                 class="bg-red/70 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-medium text-sm transition duration-300 whitespace-nowrap">
                Apply Now
              </a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @endforeach
</div>
  <!-- CTA Section -->
  <div class="bg-gradient-to-r from-blue-600 to-red py-16">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <h2 class="text-3xl font-bold text-white mb-6">Ready to Join {{ $studies->name }}?</h2>
      <p class="text-xl text-white mb-8 max-w-3xl mx-auto">Take the next step in your academic and professional journey with our world-class programs.</p>
      <div class="flex flex-col sm:flex-row justify-center gap-4">
        <a href="{{route('apply.now')}}" class="bg-white text-blue-600 px-8 py-3 rounded-lg hover:bg-blue-100 transition duration-300 font-medium shadow-lg">
          Apply Now
        </a>
        <a href="{{route('consultation.step1')}}" class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg hover:bg-white hover:text-blue-600 transition duration-300 font-medium shadow-lg">
         Book Consultancy
        </a>
      </div>
    </div>
  </div>
</section>




@endsection
