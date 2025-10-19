@extends('frontend.app')
@php
    $SeoSettings = \App\Models\SeoSetting::forPage('apply-now');
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

<section>
    <div class="bg-gray-100">
      <!-- Author: FormBold Team -->
      <!-- Learn More: https://formbold.com -->
      <div class="formbold-form-wrapper">
        <img src="https://t4.ftcdn.net/jpg/00/27/89/91/360_F_27899168_MFvJWGLtGlIJw2xBJO1jCHsbQJmr9qFM.jpg">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
                </ul>
            </div>
        @endif
        <form action="{{route('apply.form')}}" method="POST">
            @csrf
          <div class="formbold-input-group">
            <label for="name" class="font-bold formbold-form-label"> First Name </label>
            <input
              type="text"
              name="first_name"
              id="name"
              placeholder="Enter your name"
              class="formbold-form-input"
            />
          </div>
          <div class="formbold-input-group">
            <label for="name" class="font-bold  formbold-form-label"> Last Name </label>
            <input
              type="text"
              name="surname"
              id="name"
              placeholder="Enter your Surname"
              class="formbold-form-input"
            />
          </div>

          <div class="formbold-input-group font-bold">
            <label for="email" class="formbold-form-label"> Email </label>
            <input
              type="email"
              name="email"
              id="email"
              placeholder="Enter your email"
              class="formbold-form-input"
            />
          </div>

         <div class="mb-4">
    <label for="country_code" class="formbold-form-label block mb-2 text-sm font-medium text-gray-700">Country Code</label>
    <select name="country_code" id="country_code" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="+93">🇦🇫 Afghanistan (+93)</option>
    <option value="+355">🇦🇱 Albania (+355)</option>
    <option value="+213">🇩🇿 Algeria (+213)</option>
    <option value="+376">🇦🇩 Andorra (+376)</option>
    <option value="+244">🇦🇴 Angola (+244)</option>
    <option value="+54">🇦🇷 Argentina (+54)</option>
    <option value="+374">🇦🇲 Armenia (+374)</option>
    <option value="+61">🇦🇺 Australia (+61)</option>
    <option value="+43">🇦🇹 Austria (+43)</option>
    <option value="+994">🇦🇿 Azerbaijan (+994)</option>
    <option value="+973">🇧🇭 Bahrain (+973)</option>
    <option value="+880">🇧🇩 Bangladesh (+880)</option>
    <option value="+375">🇧🇾 Belarus (+375)</option>
    <option value="+32">🇧🇪 Belgium (+32)</option>
    <option value="+501">🇧🇿 Belize (+501)</option>
    <option value="+229">🇧🇯 Benin (+229)</option>
    <option value="+975">🇧🇹 Bhutan (+975)</option>
    <option value="+591">🇧🇴 Bolivia (+591)</option>
    <option value="+387">🇧🇦 Bosnia and Herzegovina (+387)</option>
    <option value="+267">🇧🇼 Botswana (+267)</option>
    <option value="+55">🇧🇷 Brazil (+55)</option>
    <option value="+673">🇧🇳 Brunei (+673)</option>
    <option value="+359">🇧🇬 Bulgaria (+359)</option>
    <option value="+226">🇧🇫 Burkina Faso (+226)</option>
    <option value="+257">🇧🇮 Burundi (+257)</option>
    <option value="+855">🇰🇭 Cambodia (+855)</option>
    <option value="+237">🇨🇲 Cameroon (+237)</option>
    <option value="+1">🇨🇦 Canada (+1)</option>
    <option value="+238">🇨🇻 Cape Verde (+238)</option>
    <option value="+236">🇨🇫 Central African Republic (+236)</option>
    <option value="+235">🇹🇩 Chad (+235)</option>
    <option value="+56">🇨🇱 Chile (+56)</option>
    <option value="+86">🇨🇳 China (+86)</option>
    <option value="+57">🇨🇴 Colombia (+57)</option>
    <option value="+269">🇰🇲 Comoros (+269)</option>
    <option value="+506">🇨🇷 Costa Rica (+506)</option>
    <option value="+385">🇭🇷 Croatia (+385)</option>
    <option value="+53">🇨🇺 Cuba (+53)</option>
    <option value="+357">🇨🇾 Cyprus (+357)</option>
    <option value="+420">🇨🇿 Czech Republic (+420)</option>
    <option value="+45">🇩🇰 Denmark (+45)</option>
    <option value="+253">🇩🇯 Djibouti (+253)</option>
    <option value="+593">🇪🇨 Ecuador (+593)</option>
    <option value="+20">🇪🇬 Egypt (+20)</option>
    <option value="+503">🇸🇻 El Salvador (+503)</option>
    <option value="+240">🇬🇶 Equatorial Guinea (+240)</option>
    <option value="+372">🇪🇪 Estonia (+372)</option>
    <option value="+251">🇪🇹 Ethiopia (+251)</option>
    <option value="+679">🇫🇯 Fiji (+679)</option>
    <option value="+358">🇫🇮 Finland (+358)</option>
    <option value="+33">🇫🇷 France (+33)</option>
    <option value="+241">🇬🇦 Gabon (+241)</option>
    <option value="+220">🇬🇲 Gambia (+220)</option>
    <option value="+995">🇬🇪 Georgia (+995)</option>
    <option value="+49">🇩🇪 Germany (+49)</option>
    <option value="+233">🇬🇭 Ghana (+233)</option>
    <option value="+30">🇬🇷 Greece (+30)</option>
    <option value="+502">🇬🇹 Guatemala (+502)</option>
    <option value="+224">🇬🇳 Guinea (+224)</option>
    <option value="+592">🇬🇾 Guyana (+592)</option>
    <option value="+509">🇭🇹 Haiti (+509)</option>
    <option value="+504">🇭🇳 Honduras (+504)</option>
    <option value="+852">🇭🇰 Hong Kong (+852)</option>
    <option value="+36">🇭🇺 Hungary (+36)</option>
    <option value="+354">🇮🇸 Iceland (+354)</option>
    <option value="+91">🇮🇳 India (+91)</option>
    <option value="+62">🇮🇩 Indonesia (+62)</option>
    <option value="+98">🇮🇷 Iran (+98)</option>
    <option value="+964">🇮🇶 Iraq (+964)</option>
    <option value="+353">🇮🇪 Ireland (+353)</option>
    <option value="+972">🇮🇱 Israel (+972)</option>
    <option value="+39">🇮🇹 Italy (+39)</option>
    <option value="+81">🇯🇵 Japan (+81)</option>
    <option value="+962">🇯🇴 Jordan (+962)</option>
    <option value="+254">🇰🇪 Kenya (+254)</option>
    <option value="+965">🇰🇼 Kuwait (+965)</option>
    <option value="+856">🇱🇦 Laos (+856)</option>
    <option value="+371">🇱🇻 Latvia (+371)</option>
    <option value="+961">🇱🇧 Lebanon (+961)</option>
    <option value="+231">🇱🇷 Liberia (+231)</option>
    <option value="+218">🇱🇾 Libya (+218)</option>
    <option value="+370">🇱🇹 Lithuania (+370)</option>
    <option value="+352">🇱🇺 Luxembourg (+352)</option>
    <option value="+261">🇲🇬 Madagascar (+261)</option>
    <option value="+60">🇲🇾 Malaysia (+60)</option>
    <option value="+960">🇲🇻 Maldives (+960)</option>
    <option value="+223">🇲🇱 Mali (+223)</option>
    <option value="+356">🇲🇹 Malta (+356)</option>
    <option value="+230">🇲🇺 Mauritius (+230)</option>
    <option value="+52">🇲🇽 Mexico (+52)</option>
    <option value="+373">🇲🇩 Moldova (+373)</option>
    <option value="+377">🇲🇨 Monaco (+377)</option>
    <option value="+976">🇲🇳 Mongolia (+976)</option>
    <option value="+212">🇲🇦 Morocco (+212)</option>
    <option value="+95">🇲🇲 Myanmar (+95)</option>
    <option value="+977">🇳🇵 Nepal (+977)</option>
    <option value="+31">🇳🇱 Netherlands (+31)</option>
    <option value="+64">🇳🇿 New Zealand (+64)</option>
    <option value="+234">🇳🇬 Nigeria (+234)</option>
    <option value="+47">🇳🇴 Norway (+47)</option>
    <option value="+92">🇵🇰 Pakistan (+92)</option>
    <option value="+507">🇵🇦 Panama (+507)</option>
    <option value="+595">🇵🇾 Paraguay (+595)</option>
    <option value="+51">🇵🇪 Peru (+51)</option>
    <option value="+63">🇵🇭 Philippines (+63)</option>
    <option value="+48">🇵🇱 Poland (+48)</option>
    <option value="+351">🇵🇹 Portugal (+351)</option>
    <option value="+974">🇶🇦 Qatar (+974)</option>
    <option value="+40">🇷🇴 Romania (+40)</option>
    <option value="+7">🇷🇺 Russia (+7)</option>
    <option value="+966">🇸🇦 Saudi Arabia (+966)</option>
    <option value="+65">🇸🇬 Singapore (+65)</option>
    <option value="+27">🇿🇦 South Africa (+27)</option>
    <option value="+82">🇰🇷 South Korea (+82)</option>
    <option value="+34">🇪🇸 Spain (+34)</option>
    <option value="+94">🇱🇰 Sri Lanka (+94)</option>
    <option value="+46">🇸🇪 Sweden (+46)</option>
    <option value="+41">🇨🇭 Switzerland (+41)</option>
    <option value="+886">🇹🇼 Taiwan (+886)</option>
    <option value="+66">🇹🇭 Thailand (+66)</option>
    <option value="+90">🇹🇷 Turkey (+90)</option>
    <option value="+971">🇦🇪 UAE (+971)</option>
    <option value="+44">🇬🇧 United Kingdom (+44)</option>
    <option value="+1">🇺🇸 United States (+1)</option>
    <option value="+998">🇺🇿 Uzbekistan (+998)</option>
    <option value="+84">🇻🇳 Vietnam (+84)</option>
    <option value="+967">🇾🇪 Yemen (+967)</option>
    <option value="+260">🇿🇲 Zambia (+260)</option>
    <option value="+263">🇿🇼 Zimbabwe (+263)</option>
    </select>
</div>

<div class="mb-4">
    <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
    <input type="text" name="phone" id="phone" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
</div>
    

          <div class="formbold-input-group">
            <label class="font-bold formbold-form-label">Nationality</label>
            <input type="text" name="nationality" id="nationality" class="formbold-form-input">
            <!--<select class="form-select country" id="primaryNationality" aria-label="Default select example" onchange="updateNationality()">-->
            <!--    <option selected>Select Nationality</option>-->
            <!--</select>-->
        </div>

          <div class="formbold-input-radio-wrapper">
            <label for="ans" class="font-bold formbold-form-label">
              Do you hold any other nationalities?
            </label>

            <div class="formbold-radio-flex">
              <div class="formbold-radio-group">
                <label class="formbold-radio-label">
                  <input
                    class="formbold-input-radio"
                    type="radio"
                    name="ans"
                    id="ans"
                  />
                  Yes
                  <span class="formbold-radio-checkmark"></span>
                </label>
              </div>

              <div class="formbold-radio-group">
                <label class="formbold-radio-label">
                  <input
                    class="formbold-input-radio"
                    type="radio"
                    name="ans"
                    id="ans"
                  />
                  No
                  <span class="formbold-radio-checkmark"></span>
                </label>
              </div>

              <div class="formbold-input-group">
                <label class="font-bold formbold-form-label">
                    Nationality
                </label>
                <input type="text" name="nationality" id="nationality" class="formbold-form-input">
                <input type="hidden" name="nationality_other" id="nationality_other" placeholder="Other Nationality">
            </div>
              
            <div class="formbold-input-group">
                <label class="font-bold formbold-form-label">
                    Country Of Residence
                </label>
                <input type="text" name="country_of_residence" id="nationality" class="formbold-form-input">
                <!--<input type="text" name="nationality_other" id="nationality_other" placeholder="Other Nationality">-->
            </div>

            </div>
          </div>

          <h1 class="text-2xl font-bold my-10">Course and Degree</h1>

          <div class="formbold-input-radio-wrapper">
            <label for="ans" class="font-bold formbold-form-label">
              Level of study
            </label>

            <div class="formbold-radio-flex">
              <div class="formbold-radio-group">
                <label class="formbold-radio-label">
                  <input
                    class="formbold-input-radio"
                    type="radio"
                    name="course_and_degree"
                    id="ans"
                    value="Undergraduate"
                  />
                  Undergraduate (pathway to a bachelor’s degree)
                  <span class="formbold-radio-checkmark"></span>
                </label>
              </div>

              <div class="formbold-radio-group">
                <label class="formbold-radio-label">
                  <input
                    class="formbold-input-radio"
                    type="radio"
                    name="course_and_degree"
                    id="ans"
                    value="Postgraduate"

                  />
                  Postgraduate (pathway to a master’s degree)
                  <span class="formbold-radio-checkmark"></span>
                </label>
              </div>
              <div class="formbold-input-group">
                <label class="formbold-form-label font-bold">
                  Subject of Interest
                </label>

                <select class="formbold-form-select" name="subject_of_interest" id="occupation">
                  <option >Please Select</option>
                  <option value="Arts and Design">Arts and Design</option>
                  <option value="Engineering">Engineering</option>
                  <option value="Medical">Medical</option>
                  <option value="Business/Commerce">Business</option>

                </select>
              </div>
              <div class="formbold-input-group">
                <label class="formbold-form-label font-bold">
                  Select University
                </label>
                @php
                    $universities = DB::table('where_to_studies')->where('is_done', 1)->get();
                @endphp
                <select class="formbold-form-select" name="course_name" id="occupation">
                  <option >Please Select</option>
                  @foreach ($universities as $item)
                  <option value="{{$item->name}}">{{$item->name}}</option>
                  @endforeach

                  

                </select>
              </div>
              <div class="formbold-input-group">
                <label class="formbold-form-label font-bold">
                  Pathway course preferred start date
                </label>

                <select class="formbold-form-select" name="preferred_session" id="occupation">
                  <option >Please Select</option>
                  <option value="Autumn ( September - November )">Autumn ( September - November ) </option>
                  <option value="Spring ( January - April )">Spring ( January - April ) </option>
                  <option value="Summer ( May - July )">Summer ( May - July ) </option>

                </select>
              </div>
          <div>
            <label for="message" class="formbold-form-label">
              Any comments or suggestions
            </label>
            <textarea
              rows="6"
              name="comments"
              id="message"
              placeholder="Type here..."
              class="formbold-form-input"
            ></textarea>
          </div>

          <button class="formbold-btn">Submit</button>
        </form>
      </div>
    </div>
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#country_code').select2({
                placeholder: "Select Country Code"
            });
        });
    </script>


    <style>
      @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: 'Inter', sans-serif;
      }
      .formbold-main-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 48px;
      }

      .formbold-form-wrapper {
        margin: 0 auto;
        max-width: 570px;
        width: 100%;
        background: white;
        padding: 40px;
      }

      .formbold-form-img {
        margin-bottom: 45px;
      }

      .formbold-input-group {
        margin-bottom: 18px;
      }

      .formbold-form-select {
        width: 100%;
        padding: 12px 22px;
        border-radius: 5px;
        border: 1px solid #dde3ec;
        background: #ffffff;
        font-size: 16px;
        color: #536387;
        outline: none;
        resize: none;
      }

      .formbold-input-radio-wrapper {
        margin-bottom: 25px;
      }
      .formbold-radio-flex {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }
      .formbold-radio-label {
        font-size: 14px;
        line-height: 24px;
        color: #07074d;
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .formbold-input-radio {
        position: absolute;
        opacity: 0;
        cursor: pointer;
      }
      .formbold-radio-checkmark {
        position: absolute;
        top: -1px;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #ffffff;
        border: 1px solid #dde3ec;
        border-radius: 50%;
      }
      .formbold-radio-label
        .formbold-input-radio:checked
        ~ .formbold-radio-checkmark {
        background-color: #6a64f1;
      }
      .formbold-radio-checkmark:after {
        content: '';
        position: absolute;
        display: none;
      }

      .formbold-radio-label
        .formbold-input-radio:checked
        ~ .formbold-radio-checkmark:after {
        display: block;
      }

      .formbold-radio-label .formbold-radio-checkmark:after {
        top: 50%;
        left: 50%;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ffffff;
        transform: translate(-50%, -50%);
      }

      .formbold-form-input {
        width: 100%;
        padding: 13px 22px;
        border-radius: 5px;
        border: 1px solid #dde3ec;
        background: #ffffff;
        font-weight: 500;
        font-size: 16px;
        color: #07074d;
        outline: none;
        resize: none;
      }
      .formbold-form-input::placeholder {
        color: #536387;
      }
      .formbold-form-input:focus {
        border-color: #6a64f1;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
      }
      .formbold-form-label {
        color: #07074d;
        font-size: 14px;
        line-height: 24px;
        display: block;
        margin-bottom: 10px;
      }

      .formbold-btn {
        text-align: center;
        width: 100%;
        font-size: 16px;
        border-radius: 5px;
        padding: 14px 25px;
        border: none;
        font-weight: 500;
        background-color: #07074d;
        color: white;
        cursor: pointer;
        margin-top: 25px;
      }
      .formbold-btn:hover {
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
      }
    </style>
   </section>


   <script>
    var config = {
        cUrl: 'https://api.countrystatecity.in/v1/countries',
        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
    };

    function loadCountries(selectElementId) {
        let apiEndPoint = config.cUrl;
        let countrySelect = document.getElementById(selectElementId);

        console.log('Loading countries for:', selectElementId); // Debugging line

        fetch(apiEndPoint, { headers: { "X-CSCAPI-KEY": config.ckey } })
            .then(response => response.json())
            .then(data => {
                console.log('Data received:', data); // Debugging line
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.iso2;
                    option.textContent = country.name;
                    countrySelect.appendChild(option);
                });
                console.log('Countries loaded for:', selectElementId); // Debugging line
            })
            .catch(error => console.error('Error loading countries:', error));
    }

    window.onload = function() {
        loadCountries('primaryNationality');
        loadCountries('secondaryNationality');
    };

    function updateNationality() {
        var primarySelect = document.getElementById('primaryNationality');
        var secondarySelect = document.getElementById('secondaryNationality');
        var nationalityInput = document.getElementById('nationality');
        var otherNationalityInput = document.getElementById('nationality_other');

        var primarySelectedOption = primarySelect.options[primarySelect.selectedIndex].text;
        var secondarySelectedOption = secondarySelect.options[secondarySelect.selectedIndex].text;

        nationalityInput.value = primarySelectedOption;

        if (secondarySelectedOption === "Other Nationality") {
            nationalityInput.value = otherNationalityInput.value;
        } else {
            otherNationalityInput.value = secondarySelectedOption;
        }

        console.log('Primary Nationality Updated:', primarySelectedOption); // Debugging line
        console.log('Secondary Nationality Updated:', secondarySelectedOption); // Debugging line
    }
</script>



@endsection
