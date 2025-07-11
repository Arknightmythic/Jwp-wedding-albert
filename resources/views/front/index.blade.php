<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="{{asset('output.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <!-- CSS -->
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
</head>
<body class="font-poppins text-black">
    <section id="content" class="max-w-[800px] w-full mx-auto bg-[#F9F2EF] min-h-screen flex flex-col gap-8 pb-[120px]">

        <div class="visphone navigation-bar fixed z-50 max-w-[800px] w-full h-[85px] bg-white rounded-b-[25px] flex items-center justify-evenly py-[45px]">
          <a href="" class="menu">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/home.svg" alt="icon">             
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Home</p>
            </div>
          </a>
          <a href="" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/search.svg" alt="icon">            
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Search</p>
            </div>
          </a>
          <a href="{{route('dashboard.bookings')}}" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/calendar-blue.svg" alt="icon">              
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Schedule</p>
            </div>
          </a>
          <a href="{{route('profile.edit')}}" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/user-flat.svg" alt="icon">               
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Profile</p>
            </div>
          </a>
        </div>
        <div class="blnk"></div>
        <nav class="mt-8 px-4 w-full flex items-center justify-between">
          <div class="flex items-center gap-3">
            @auth
            <div class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008]">
              <img src="{{Storage::url(Auth::user()->avatar)}}" class="w-full h-full object-cover object-center" alt="photo">
            </div>
            <div class="flex flex-col gap-1">
              <p class="text-xs tracking-035">Welcome!</p>
              <p class="font-semibold">{{Auth::user()->name}}</p>
            </div>
            @endauth
            @guest
            <div class="w-12 h-12 border-4 border-white rounded-full overflow-hidden flex shrink-0 shadow-[6px_8px_20px_0_#00000008]">
                <img src="assets/photos/pfp.png" class="w-full h-full object-cover object-center" alt="photo">
              </div>
              <a href="{{route('login')}}">
                <div class="flex flex-col gap-1">
                  <p class="text-xs tracking-035">Welcome!</p>
                  <p class="font-semibold">to JWP Wedding</p>
                </div>
              </a>
            @endguest
          </div>
          <a href="">
            <div class="w-12 h-12 rounded-full bg-white overflow-hidden flex shrink-0 items-center justify-center shadow-[6px_8px_20px_0_#00000008]">
              <img src="assets/icons/bell.svg" alt="icon">
            </div>
          </a>
        </nav>
        <h1 class="font-semibold text-2xl leading-[36px] text-center"> Pernikahan Impian <br>dengan Keindahan dan Kesempurnaan</h1>
        <div id="categories" class="flex flex-col gap-3">
          <h2 class="font-semibold px-4">Categories</h2>
          <div class="main-carousel buttons-container">
            @forelse($categories as $category)
            <a href="{{route('front.category', $category->slug)}}" class="group px-2 first-of-type:pl-4 last-of-type:pr-4">
              <div class="p-3 flex items-center gap-2 rounded-[10px] border border-[#4D73FF] group-hover:bg-[#4D73FF] transition-all duration-300">
                <div class="w-6 h-6 flex shrink-0">
                  <img src="{{Storage::url($category->icon)}}" alt="icon">
                </div>
                <span class="text-sm tracking-[0.35px] text-[#4D73FF] group-hover:text-white transition-all duration-300">{{$category->name}}</span>
              </div>
            </a>
            @empty
            <p>belum ada data kategori terbaru</p>
            @endforelse
          </div>
        </div>
        <div id="recommendations" class="flex flex-col gap-3  pb-8">
          <h2 class="font-semibold px-4">Trip Recommendation</h2>
          <div class="main-carousel card-container">
            @forelse($package_weddings as $wedding)
            <a href="{{route('front.details', $wedding->slug)}}" class="group px-2 first-of-type:pl-4 last-of-type:pr-4">
              <div class="w-[288px] p-4 flex flex-col gap-3 rounded-[26px] bg-white shadow-[6px_8px_20px_0_#00000008]">
                <div class="w-full h-[330px] rounded-xl flex shrink-0 overflow-hidden">
                  <img src="{{Storage::url($wedding->thumbnail)}}" class="w-full h-full object-cover" alt="thumbnails">
                </div>
                <div class="flex justify-between gap-2">
                  <div class="flex flex-col gap-1">
                    <p class="font-semibold two-lines">{{$wedding->name}}</p>
                    <div class="flex items-center gap-1">
                      <div class="w-4 h-4 flex shrink-0">
                        <img src="assets/icons/location-map.svg" alt="icon">
                      </div>
                      <span class="text-sm text-darkGrey tracking-035">{{$wedding->location}}</span>
                    </div>
                  </div>
                  <div class="flex flex-col gap-1 text-right">
                    <p class="text-sm leading-[21px]">
                      <span class="font-semibold text-[#4D73FF] text-nowrap">Rp {{number_format($wedding->price,0,',','.')}}</span><br>
                      <span class="text-darkGrey">/{{$wedding->pax}}pax</span>
                    </p>
                    <div class="flex items-center gap-1 justify-end">
                      <div class="w-4 h-4 flex shrink-0">
                        <img src="assets/icons/Star.svg" alt="icon">
                      </div>
                      <span class="font-semibold text-sm leading-[21px]">4.8</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            @empty
             <p>belum ada paket tersedia</p>   
            @endforelse
          </div>
        </div>
        <div id="discover" class="px-4  pb-8">
          <div class="w-full h-[130px] flex flex-col gap-[10px] rounded-[22px] items-center overflow-hidden relative">
            <img src="assets/backgrounds/Banner.png" class="w-full h-full object-cover object-center" alt="background">
            <div class="absolute z-10 flex flex-col gap-[10px] transform -translate-y-1/2 top-1/2 left-4">
              <p class="text-white font-semibold">Discover the<br>our new international package</p>
              <a href="" class="bg-[#4D73FF] p-[8px_24px] rounded-[10px] text-white font-semibold text-xs w-fit">Soon</a>
            </div>
          </div>
        </div>
        <div id="explore" class="flex flex-col items-center justify-center px-4 gap-3">
          <h2 class="font-semibold">More to Explore</h2>
          <div class="disHome px-4 gap-3">
            @forelse($package_weddings as $wedding)
            <a href="{{route('front.details', $wedding->slug)}}" class="card">
              <div class="bg-white p-4 flex flex-col gap-3 rounded-[26px] shadow-[6px_8px_20px_0_#00000008]">
                <div class="w-full h-full aspect-[311/150] rounded-xl overflow-hidden">
                  <img src="{{Storage::url($wedding->thumbnail)}}" class="w-full h-full object-cover object-center" alt="thumbnail">
                </div>
                <div class="flex justify-between gap-2">
                  <div class="flex flex-col gap-1">
                    <p class="font-semibold two-lines">{{$wedding->name}}</p>
                    <div class="flex items-center gap-1">
                      <div class="w-4 h-4 flex shrink-0">
                        <img src="assets/icons/location-map.svg" alt="icon">
                      </div>
                      <span class="text-sm text-darkGrey tracking-035">{{$wedding->location}}</span>
                    </div>
                  </div>
                  <div class="flex flex-col gap-1 text-right">
                    <p class="text-sm leading-[21px]">
                      <span class="font-semibold text-[#4D73FF] text-nowrap">Rp {{number_format($wedding->price,0,',','.')}}</span><br>
                      <span class="text-darkGrey">/{{$wedding->pax}}pax</span>
                    </p>
                    <div class="flex items-center gap-1 justify-end">
                      <div class="w-4 h-4 flex shrink-0">
                        <img src="assets/icons/Star.svg" alt="icon">
                      </div>
                      <span class="font-semibold text-sm leading-[21px]">4.8</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            @empty
            <p>Belum ada paket terbaru</p>
            @endforelse
        </div>
        </div>
        <div class="visdesk navigation-bar fixed bottom-0 z-50 max-w-[640px] w-full h-[85px] bg-white rounded-t-[25px] flex items-center justify-evenly py-[45px]">
          <a href="" class="menu">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/home.svg" alt="icon">             
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Home</p>
            </div>
          </a>
          <a href="" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/search.svg" alt="icon">            
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Search</p>
            </div>
          </a>
          <a href="{{route('dashboard.bookings')}}" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/calendar-blue.svg" alt="icon">              
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Schedule</p>
            </div>
          </a>
          <a href="{{route('profile.edit')}}" class="menu opacity-25">
            <div class="flex flex-col justify-center w-fit gap-1">
              <div class="w-4 h-4 flex shrink-0 overflow-hidden mx-auto text-[#4D73FF]">
                <img src="assets/icons/user-flat.svg" alt="icon">               
              </div>
              <p class="font-semibold text-xs leading-[20px] tracking-[0.35px]">Profile</p>
            </div>
          </a>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- JavaScript -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
    <script src="{{asset('js/flickity-slider.js')}}"></script>
    <script src="{{asset('js/two-lines-text.js')}}"></script>

</body>
</html>