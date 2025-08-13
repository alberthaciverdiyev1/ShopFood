<nav class="flex bg-white opacity-90 w-full justify-between items-center px-6 py-4 shadow-md relative">
  <ul class="flex items-center space-x-6 gap-5">
    <li>
      <a href="/" class="py-2 px-4 font-bold rounded">Logo</a>
      <a href="/"><i class="fa-brands fa-telegram"></i></a>
      <a href=""><i class="fa-brands fa-whatsapp"></i></a>
    </li>
  </ul>

  <ul class="hidden md:flex items-center space-x-4 gap-4">
    <li><select name="language"><option value="">En</option></select></li>
    <li><a href="#" class="hover:text-black"><i class="fas fa-shopping-cart"></i></a></li>
    <li><a href=""><i class="fa-regular fa-user"></i></a></li>
    <li>1524</li>
    <li><a href=""><i class="fa-solid fa-arrow-right-from-bracket"></i></a></li>
  </ul>

  <!-- Burger -->
  <div id="burger" class="block md:hidden cursor-pointer z-50">
    <i class="fa-solid fa-bars text-2xl"></i>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden absolute top-full right-0 bg-white shadow-md rounded-md p-4 space-y-4 md:hidden z-40">
    <ul class="flex flex-col space-y-4">
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-house"></i> Home</a></li>
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-user"></i> Profile</a></li>
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-globe"></i> Language</a></li>
      <li><a href="#" class="hover:text-black"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
    </ul>
  </div>
</nav>
