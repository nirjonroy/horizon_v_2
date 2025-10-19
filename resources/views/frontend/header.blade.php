<!-- Professional Single Row Navigation Bar -->
<header class="sticky top-0 border-b border-[#F9F5EB] z-50 shadow-md bg-[#213555]">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20 lg:h-28">

      <!-- Logo -->
      <div class="flex-shrink-0 w-1/4">
        <a href="{{ route('home.index') }}">
          @php
            $siteInfo = DB::table('site_information')->first();
          @endphp
          <img class="h-20 lg:h-28 w-auto" src="{{ asset($siteInfo->logo) }}" alt="{{ $siteInfo->name }}" loading="lazy">
        </a>
      </div>

      <!-- Navigation Links -->
      <nav class="hidden lg:flex justify-center w-2/4">
        <ul class="flex space-x-6 items-center text-[12px] font-medium uppercase tracking-wider text-white">
          <!-- Where to Study Dropdown -->
          <li class="relative group">
            <button class="flex items-center hover:text-gray-200 transition">
              WHERE TO STUDY
              <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-64 bg-[#E5D283] rounded-md shadow-lg ring-1 ring-[#213555] ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
              <div>
                @php
                  $wheretoStudies = DB::table('where_to_studies')->where('is_done', 1)->get();
                @endphp
                <a href="{{ route('premium-courses') }}" class="block px-4 py-3 text-sm text-gray-900 hover:bg-gray-100 border-b border-gray-100">
                    Horizons Global Academy Courses & Certificates
                  </a>
                <a href="{{ route('free-courses') }}" class="block px-4 py-3 text-sm text-gray-900 hover:bg-gray-100 border-b border-gray-100">
                    Horizons Global Academy Free Courses 
                  </a>
                @foreach ($wheretoStudies as $study)
                  <a href="{{ route('where.to.study', $study->slug) }}" class="block px-4 py-3 text-sm text-gray-900 hover:bg-gray-100 border-b border-gray-100">
                    {{ $study->name }}
                  </a>
                @endforeach
              </div>
            </div>
          </li>

          <!--<li><a href="{{ route('premium-courses') }}" class="hover:text-gray-200 transition">Horizons Courses</a></li>-->
          <li><a href="{{ route('who_we_are') }}" class="hover:text-gray-200 transition">Who We Are</a></li>
          <li><a href="{{ route('contact.us') }}" class="hover:text-gray-200 transition">Contact Us</a></li>
          <li><a href="{{ route('all.blogs') }}" class="hover:text-gray-200 transition">Blogs</a></li>
          <!--<li><a href="{{ route('webinner.view') }}" class="hover:text-gray-200 transition">Webinars</a></li> -->
        </ul>
      </nav>

      <!-- Action Buttons -->
      <div class="hidden lg:flex justify-end w-1/4 space-x-4 items-center">
        <a href="{{ route('consultation.step1') }}" class="border border-[#F9F5EB] px-2 py-1 rounded-md text-sm font-medium text-[#F9F5EB] hover:bg-[#F9F5EB] hover:text-[#213555] transition">
          Book Consultation
        </a>
        <a href="{{ route('apply.now') }}" class="px-2 py-1 text-sm bg-[#EA5455] hover:bg-red-700 text-[#F9F5EB] font-medium rounded-md transition">
          Apply Now
        </a>

        <!-- Authenticated User: Logout / Guest: Login -->
        <div class="relative group">
          <button type="button" class="flex items-center text-[12px] font-medium uppercase tracking-wider text-white hover:text-gray-200 transition">
            Account
            <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="absolute right-0 mt-2 w-48 bg-[#E5D283] rounded-md shadow-lg ring-1 ring-[#213555] ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-focus-within:opacity-100 group-focus-within:visible transition-all duration-200 z-10">
            <div class="py-1">
              @guest
                <a href="{{ route('login') }}" class="block px-4 py-2 text-sm text-[#213555] hover:bg-gray-100">
                  Login
                </a>
              @else
                <a href="{{ url('/user-dashboard') }}" class="block px-4 py-2 text-sm text-[#213555] hover:bg-gray-100 border-b border-gray-200">
                  Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                  <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-100">
                    Logout
                  </button>
                </form>
              @endguest
            </div>
          </div>
        </div>
        <!-- Cart Icon -->
        @php
          $cartCount = session('cart') ? count(session('cart')) : 0;
        @endphp
        <a href="{{ url('/cart') }}" class="relative inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke="red" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-2 9h14l-2-9M10 21a1 1 0 11-2 0 
                     1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z" />
          </svg>
          @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
              {{ $cartCount }}
            </span>
          @endif
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="lg:hidden flex items-center space-x-4">
        <a href="{{ route('consultation.step1') }}" class="border border-[#F9F5EB] px-2 py-2 rounded-md text-[10px] font-medium text-[#F9F5EB] hover:bg-[#F9F5EB] hover:text-[#213555] transition">
          Book Consultation
        </a>
        <a href="{{ route('apply.now') }}" class="px-2 py-2 bg-[#EA5455] hover:bg-red-700 text-[#F9F5EB] text-[10px] font-bold rounded-md transition">
          Apply Now
        </a>
        <button class="bg-[#E5D283] p-1 text-[#213555] rounded-md focus:outline-none" aria-label="Toggle menu" id="mobile-menu-button">
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div class="lg:hidden hidden bg-[#213555]" id="mobile-menu">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
      <div class="relative">
        <button class="w-full text-left text-[#F9F5EB] px-3 py-2 rounded-md text-base font-medium flex items-center justify-between" id="mobile-dropdown-button">
          Where to Study
          <svg class="ml-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div class="hidden ml-4 bg-[#E5D283] rounded-md text-[#213555]" id="mobile-dropdown">
          @foreach ($wheretoStudies as $study)
            <a href="{{ route('where.to.study', $study->id) }}" class="block px-4 py-3 font-semibold text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100">
              {{ $study->name }}
            </a>
          @endforeach
        </div>
      </div>

      <a href="{{ route('premium-courses') }}" class="block px-3 py-2 text-[#F9F5EB] hover:bg-gray-200 rounded-md text-base font-medium">
        Horizon Courses
      </a>
      <a href="{{ route('who_we_are') }}" class="block px-3 py-2 text-[#F9F5EB] hover:bg-gray-200 rounded-md text-base font-medium">
        Who We Are
      </a>
      <a href="{{ route('all.blogs') }}" class="block px-3 py-2 text-[#F9F5EB] hover:bg-gray-200 rounded-md text-base font-medium">
        Blogs
      </a>
      <a href="{{ route('webinner.view') }}" class="block px-3 py-2 text-[#F9F5EB] hover:bg-gray-200 rounded-md text-base font-medium">
        Webinars
      </a>
    </div>
  </div>
</header>

<script>
  // Mobile menu toggle
  document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
  });

  // Mobile dropdown toggle
  document.getElementById('mobile-dropdown-button').addEventListener('click', function() {
    const dropdown = document.getElementById('mobile-dropdown');
    dropdown.classList.toggle('hidden');
  });
</script>
