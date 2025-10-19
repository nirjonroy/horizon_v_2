@extends('frontend.app')

@php
    $SeoSettings = \App\Models\SeoSetting::forPage('appointment-for-consultation');
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
@section('seos')
    @php
        $SeoSettings = DB::table('seo_settings')->where('id', 3)->first();
        // Decode the keywords JSON string into an array
        $keywordsArray = json_decode($SeoSettings->keywords, true);
    @endphp

    @php
    $siteInfo = DB::table('site_information')->first();
    @endphp

    <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{$SeoSettings->seo_title}}">

    <meta name="description" content="{{$SeoSettings->seo_description}}">
    
    <!-- Populate the keywords meta tag -->
    <meta name="keywords" content="{{ isset($keywordsArray) ? implode(', ', $keywordsArray) : '' }}" /> 

    <meta property="og:title" content="{{$SeoSettings->seo_title}}">
    <meta property="og:description" content="{{$SeoSettings->seo_description}}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{$SeoSettings->seo_title}}">
    <meta property="og:image" content="{{asset($siteInfo->logo)}}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">


@endsection

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: "#001D42",
              red: "#ff0000",
            },
          },
        },
      };
    </script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    
    

<section class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-lg w-full max-w-4xl p-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Left Side Card -->
          <div class="bg-blue-900 text-white p-6 mt-16 lg:mt-0 rounded-lg flex flex-col items-start">
              <h2 class="text-2xl font-semibold mb-4">Appointment for Consultation</h2>
              <div class="flex items-center justify-center gap-2 mb-2">
                  <i class="fa-solid fa-clock"></i>
                  <p class="text-lg">20 Mins</p>
              </div>
              <div class="flex items-center justify-center gap-2">
                  <i class="fa-solid fa-calendar-days"></i>
                  <p class="text-lg font-medium ">{{ \Carbon\Carbon::now()->format('D, M d, Y') }}</p>
              </div>
          </div>

          <!-- Right Side -->
          <div>
              <h2 class="text-xl font-semibold mb-4 underline">Select Date & Time</h2>
              <form method="GET" action="{{ route('consultation.step2') }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                   <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Pick a Date</label>
                        <input
                            type="date"
                            id="date"
                            name="date"
                            class="mt-2 w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500"
                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            required
                        />
                    </div>
                    @php
    // Convert string times to timestamps
    $start = strtotime($startTime ?? '06:00'); // Default to 08:00 if not set
    $end = strtotime($endTime ?? '19:00');     // Default to 20:00 if not set

    $timeSlots = [];
    
    while ($start <= $end) {
        $timeSlots[] = date('h:i A', $start);
        $start = strtotime('+20 minutes', $start);
    }
@endphp
              <div class="h-80 overflow-y-auto">
    <p class="text-sm font-medium text-gray-700 mb-2">Available Times</p>
    <div class="space-y-2">
        @foreach($timeSlots as $time)
            <button
                type="button"
                onclick="selectTime('{{ $time }}')"
                data-time="{{ $time }}"
                class="time-button w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-600"
            >
                {{ $time }}
            </button>
        @endforeach
        <input type="hidden" id="selectedTime" name="time" required />
    </div>
</div>
                </div>
                
                <div class="form-group mb-4">
    <label for="time_zone" class="block text-gray-700 font-bold mb-2">Select Time Zone:</label>
    <div class="relative">
        <select name="time_zone" id="time_zone" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
            <!-- UTC & America -->
            <!--<option value="UTC">UTC (GMT+0)</option>-->
            <option value="America/New_York">America/New York (GMT-5)</option>
            <!--<option value="America/Los_Angeles">America/Los Angeles (GMT-8)</option>-->
            <!--<option value="America/Chicago">America/Chicago (GMT-6)</option>-->
            <!--<option value="America/Toronto">America/Toronto (GMT-5)</option>-->
            <!--<option value="America/Mexico_City">America/Mexico City (GMT-6)</option>-->
            <!--<option value="America/Sao_Paulo">America/São Paulo (GMT-3)</option>-->
            <!--<option value="America/Argentina/Buenos_Aires">America/Buenos Aires (GMT-3)</option>-->
            <!--<option value="America/Lima">America/Lima (GMT-5)</option>-->
            <!--<option value="America/Bogota">America/Bogotá (GMT-5)</option>-->

            <!-- Europe -->
            <!--<option value="Europe/London">Europe/London (GMT+0)</option>-->
            <!--<option value="Europe/Berlin">Europe/Berlin (GMT+1)</option>-->
            <!--<option value="Europe/Paris">Europe/Paris (GMT+1)</option>-->
            <!--<option value="Europe/Madrid">Europe/Madrid (GMT+1)</option>-->
            <!--<option value="Europe/Moscow">Europe/Moscow (GMT+3)</option>-->
            <!--<option value="Europe/Istanbul">Europe/Istanbul (GMT+3)</option>-->
            <!--<option value="Europe/Rome">Europe/Rome (GMT+1)</option>-->
            <!--<option value="Europe/Amsterdam">Europe/Amsterdam (GMT+1)</option>-->

            <!-- Africa -->
            <!--<option value="Africa/Cairo">Africa/Cairo (GMT+2)</option>-->
            <!--<option value="Africa/Lagos">Africa/Lagos (GMT+1)</option>-->
            <!--<option value="Africa/Johannesburg">Africa/Johannesburg (GMT+2)</option>-->
            <!--<option value="Africa/Nairobi">Africa/Nairobi (GMT+3)</option>-->
            <!--<option value="Africa/Algiers">Africa/Algiers (GMT+1)</option>-->
            <!--<option value="Africa/Accra">Africa/Accra (GMT+0)</option>-->
            <!--<option value="Africa/Casablanca">Africa/Casablanca (GMT+0)</option>-->
            <!--<option value="Africa/Addis_Ababa">Africa/Addis Ababa (GMT+3)</option>-->
            <!--<option value="Africa/Kampala">Africa/Kampala (GMT+3)</option>-->
            <!--<option value="Africa/Dakar">Africa/Dakar (GMT+0)</option>-->

            <!-- Asia -->
            <!--<option value="Asia/Dubai">Asia/Dubai (GMT+4)</option>-->
            <!--<option value="Asia/Kolkata">Asia/Kolkata (GMT+5:30)</option>-->
            <!--<option value="Asia/Dhaka">Asia/Dhaka (GMT+6)</option>-->
            <!--<option value="Asia/Jakarta">Asia/Jakarta (GMT+7)</option>-->
            <!--<option value="Asia/Bangkok">Asia/Bangkok (GMT+7)</option>-->
            <!--<option value="Asia/Shanghai">Asia/Shanghai (GMT+8)</option>-->
            <!--<option value="Asia/Singapore">Asia/Singapore (GMT+8)</option>-->
            <!--<option value="Asia/Tokyo">Asia/Tokyo (GMT+9)</option>-->
            <!--<option value="Asia/Seoul">Asia/Seoul (GMT+9)</option>-->

            <!-- Australia & Pacific -->
            <!--<option value="Australia/Sydney">Australia/Sydney (GMT+10)</option>-->
            <!--<option value="Australia/Melbourne">Australia/Melbourne (GMT+10)</option>-->
            <!--<option value="Pacific/Auckland">Pacific/Auckland (GMT+12)</option>-->
            <!--<option value="Pacific/Honolulu">Pacific/Honolulu (GMT-10)</option>-->
            <!--<option value="Pacific/Fiji">Pacific/Fiji (GMT+12)</option>-->
        </select>
        <p class="text-red-500 mt-1 hidden" id="error_message">Error loading time zones.</p>
    </div>
</div>

                
                
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="lg:text-base text-sm bg-[#FF0000] text-white mt-4 px-3 py-2 rounded-md font-bold"
                    >
                        Continue
                    </button>
                </div>
            </form>
            
          </div>
      </div>
  </div>
</section>


<script>
    function selectTime(time) {
        document.getElementById('selectedTime').value = time;

        // Remove highlight from all
        document.querySelectorAll('.time-button').forEach(btn => btn.classList.remove('bg-blue-600'));

        // Highlight selected
        const selectedBtn = document.querySelector(`[data-time="${time}"]`);
        if (selectedBtn) {
            selectedBtn.classList.add('bg-blue-600');
        }
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let dateInput = document.getElementById("date");

    dateInput.addEventListener("input", function () {
        let selectedDate = new Date(this.value);
        let day = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday

        if (day === 0 || day === 6) {
            alert("Weekends (Saturday & Sunday) are not available. Please select a weekday.");
            this.value = ""; // Clear the selected value
        }
    });
});
</script>
@endsection