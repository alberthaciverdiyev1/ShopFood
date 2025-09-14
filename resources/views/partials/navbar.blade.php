<nav class="flex bg-white opacity-90 w-full justify-between items-center px-6 py-3 shadow-md relative">
    <ul class="flex items-center space-x-2 ml-6">
        <!-- Logo -->
        <li>
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
            </a>
        </li>

        @php
            $settings = \App\Models\Setting::first();
        @endphp

        <li>
            @if(!empty($settings->telegram_link))
                <a href="{{ $settings->telegram_link }}" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-telegram text-xl mt-6 ml-8"></i>
                </a>
            @endif
        </li>
        <li>
            @if(!empty($settings->whatsapp_link))
                <a href="{{ $settings->whatsapp_link }}" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-whatsapp text-xl mt-6"></i>
                </a>
            @endif
        </li>

    </ul>


    <!-- <h1>@lang("Hello")</h1> -->

    <ul class="hidden md:flex items-center space-x-3 gap-4">
        <form id="languageForm" action="{{ route('change-locale') }}" method="POST">
            @csrf
            <li class="list-none">
                <div class="relative w-16">
                    <select name="locale"
                            class="appearance-none w-full bg-white border border-gray-300  px-3 pr-8 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-300 text-center"
                            onchange="document.getElementById('languageForm').submit()">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇺🇸</option>
                        <option value="cz" {{ app()->getLocale() == 'cz' ? 'selected' : '' }}>🇨🇿</option>
                    </select>
                    {{-- Ok simgesi --}}
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path d="M7 7l3-3 3 3H7z"/>
                        </svg>
                    </div>
                </div>
            </li>
        </form>

        <li>
            <a href="{{route('favorites.list')}}" class="hover:text-black relative">
                <i class="fa-regular fa-heart text-xl"></i>
                <span id="favoriteCount"
                      class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                {{ Auth::check() ? Auth::user()->favorites()->count() : 0 }}
            </span>
            </a>
        </li>
        <li><a href="{{route('basket.list')}}" class="hover:text-black relative">
                <svg width="24" height="24" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.83301 2.83337H5.29802C6.82802 2.83337 8.03218 4.15087 7.90468 5.66671L6.72884 19.7767C6.53051 22.0859 8.358 24.0692 10.6813 24.0692H25.7688C27.8088 24.0692 29.5938 22.3975 29.7497 20.3717L30.5147 9.74671C30.6847 7.39505 28.8997 5.48253 26.5338 5.48253H8.24468" stroke="#331111" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M23.0208 31.1667C23.9988 31.1667 24.7917 30.3738 24.7917 29.3958C24.7917 28.4178 23.9988 27.625 23.0208 27.625C22.0428 27.625 21.25 28.4178 21.25 29.3958C21.25 30.3738 22.0428 31.1667 23.0208 31.1667Z" stroke="#331111" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.6878 31.1667C12.6658 31.1667 13.4587 30.3738 13.4587 29.3958C13.4587 28.4178 12.6658 27.625 11.6878 27.625C10.7098 27.625 9.91699 28.4178 9.91699 29.3958C9.91699 30.3738 10.7098 31.1667 11.6878 31.1667Z" stroke="#331111" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.75 11.3334H29.75" stroke="#331111" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span id="basketCount"
                      class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                {{ Auth::check() ? Auth::user()->basket()->count() : 0 }}
            </span></a></li>
        <li><a href="{{route('profile')}}"><svg width="26" height="26" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.66699 25.4999C5.66699 23.997 6.26401 22.5557 7.32672 21.493C8.38943 20.4303 9.83077 19.8333 11.3337 19.8333H22.667C24.1699 19.8333 25.6112 20.4303 26.6739 21.493C27.7366 22.5557 28.3337 23.997 28.3337 25.4999C28.3337 26.2514 28.0351 26.972 27.5038 27.5034C26.9724 28.0347 26.2518 28.3333 25.5003 28.3333H8.50033C7.74888 28.3333 7.02821 28.0347 6.49686 27.5034C5.9655 26.972 5.66699 26.2514 5.66699 25.4999Z" stroke="black" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M17 14.1666C19.3472 14.1666 21.25 12.2638 21.25 9.91663C21.25 7.56942 19.3472 5.66663 17 5.66663C14.6528 5.66663 12.75 7.56942 12.75 9.91663C12.75 12.2638 14.6528 14.1666 17 14.1666Z" stroke="black" stroke-width="2"/>
                </svg>
            </a></li>
        <li>1524</li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-black cursor-pointer">
                    <svg width="26" height="22" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.0003 4.25C17.3614 4.2504 17.7087 4.38866 17.9713 4.63654C18.2338 4.88441 18.3918 5.22318 18.413 5.58364C18.4341 5.9441 18.3169 6.29904 18.0851 6.57593C17.8534 6.85282 17.5246 7.03077 17.1661 7.07342L17.0003 7.08333H9.91699C9.57 7.08338 9.2351 7.21077 8.9758 7.44135C8.7165 7.67192 8.55084 7.98964 8.51024 8.33425L8.50033 8.5V25.5C8.50037 25.847 8.62776 26.1819 8.85834 26.4412C9.08891 26.7005 9.40664 26.8662 9.75124 26.9067L9.91699 26.9167H16.292C16.6531 26.9171 17.0004 27.0553 17.2629 27.3032C17.5255 27.5511 17.6835 27.8898 17.7047 28.2503C17.7258 28.6108 17.6085 28.9657 17.3768 29.2426C17.145 29.5195 16.8163 29.6974 16.4577 29.7401L16.292 29.75H9.91699C8.83294 29.7501 7.78985 29.3359 7.00112 28.5922C6.2124 27.8485 5.73767 26.8315 5.67408 25.7493L5.66699 25.5V8.5C5.66693 7.41595 6.08112 6.37285 6.82481 5.58413C7.5685 4.79541 8.58548 4.32068 9.66766 4.25708L9.91699 4.25H17.0003ZM25.0852 11.9907L29.0916 15.9984C29.3572 16.2641 29.5064 16.6244 29.5064 17C29.5064 17.3756 29.3572 17.7359 29.0916 18.0016L25.0852 22.0093C24.8194 22.275 24.459 22.4241 24.0832 22.424C23.7074 22.4239 23.347 22.2744 23.0814 22.0086C22.8157 21.7428 22.6666 21.3823 22.6667 21.0065C22.6668 20.6307 22.8162 20.2704 23.0821 20.0048L24.6702 18.4167H17.0003C16.6246 18.4167 16.2643 18.2674 15.9986 18.0017C15.7329 17.7361 15.5837 17.3757 15.5837 17C15.5837 16.6243 15.7329 16.2639 15.9986 15.9983C16.2643 15.7326 16.6246 15.5833 17.0003 15.5833H24.6702L23.0821 13.9952C22.8162 13.7296 22.6668 13.3693 22.6667 12.9935C22.6666 12.6177 22.8157 12.2572 23.0814 11.9914C23.347 11.7256 23.7074 11.5761 24.0832 11.576C24.459 11.5759 24.8194 11.725 25.0852 11.9907Z" fill="black"/>
                    </svg>

                </button>
            </form>
        </li>
        <li>
            @if(!Auth::check())
                <a href="{{route('login')}}" class="px-4 py-5 font-bold rounded-xl">
                    Login/Register
                </a>
            @endif
        </li>

    </ul>

    <!-- Burger -->
    <div id="burger" class="block md:hidden cursor-pointer z-50">
        <i class="fa-solid fa-bars text-2xl"></i>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
         class="hidden absolute top-full right-0 bg-white shadow-md rounded-md p-4 space-y-4 md:hidden z-40">
        <ul class="flex flex-col space-y-4">
            <li><a href="{{route('home')}}" class="hover:text-black"><i class="fa-solid fa-house"></i> Home</a></li>
            <!-- <li><a href="#" class="hover:text-black"><i class="fa-solid fa-user"></i> Profile</a></li> -->

            <li><a href="{{route('basket.list')}}" class="hover:text-black"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
            <li><a href="#" class="hover:text-black"><i class="fa-solid fa-globe"></i> Language</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-black">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
