<nav class="flex bg-white opacity-90 w-full justify-between items-center px-6 py-4 shadow-md relative">
  <ul class="flex items-center space-x-6 gap-5">
    <li>
      <a href="/" class="py-2 px-4 font-bold rounded">Logooo</a>
      <a href="/"><i class="fa-brands fa-telegram"></i></a>
      <a href=""><i class="fa-brands fa-whatsapp"></i></a>
    </li>
  </ul>

    <h1>@lang("Hello")</h1>

  <ul class="hidden md:flex items-center space-x-4 gap-4">
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

    <li><a href="#" class="hover:text-black"><i class="fas fa-shopping-cart"></i></a></li>
    <li><a href=""><i class="fa-regular fa-user"></i></a></li>
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
              <a href="#" class="px-4 py-5 font-bold rounded-xl">
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
  <div id="mobile-menu" class="hidden absolute top-full right-0 bg-white shadow-md rounded-md p-4 space-y-4 md:hidden z-40">
    <ul class="flex flex-col space-y-4">
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-house"></i> Home</a></li>
      <!-- <li><a href="#" class="hover:text-black"><i class="fa-solid fa-user"></i> Profile</a></li> -->

      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
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
