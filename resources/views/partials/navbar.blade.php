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
                    <i class="fa-brands fa-telegram text-xl mt-6"></i>
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
            <li>
                <select name="locale" class="form-select" onchange="document.getElementById('languageForm').submit()">
                    <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>En</option>
                    <option value="ru" {{app()->getLocale() == 'ru' ? 'selected' : '' }}>Ru</option>
                    <option value="az" {{app()->getLocale() == 'az' ? 'selected' : '' }}>Az</option>

                </select>
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
        <li><a href="{{route('basket.list')}}" class="hover:text-black relative"><i class="fas fa-shopping-cart"></i>
                <span id="basketCount"
                      class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                {{ Auth::check() ? Auth::user()->basket()->count() : 0 }}
            </span></a></li>
        <li><a href="{{route('profile')}}"><i class="fa-regular fa-user"></i></a></li>
        <li>1524</li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="hover:text-black cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </li>
        <li>
            @if(Auth::check())
                <a href="{{route('profile')}}" class="px-4 py-5 font-bold rounded-xl">
                    {{ Auth::user()->contact_name ?? Auth::user()->reg_number }}
                </a>
            @else
                <a href="/login" class="px-4 py-5 font-bold rounded-xl">
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
