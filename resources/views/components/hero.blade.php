<section class="hero-gradient relative h-screen">
  <div class="slide px-4  flex flex-col md:flex-row justify-between items-center h-full relative">

    <img class="hidden md:block h-full absolute left-0 top-0 z-0 object-cover" src="{{ asset('images/hero-left.png') }}" alt="">

    <div class="w-full md:w-[43%] flex flex-col gap-5 items-center md:items-start justify-center z-10 text-center md:text-left mt-10 md:mt-0">
      <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white">
        Сливочное масло теперь по выгодной цене
      </h1>
      <p class="text-lg sm:text-xl md:text-2xl text-white">
        Закажите сейчас и получите скидку! Торопитесь предложение ограничено!
      </p>
    </div>

    <img class="w-full sm:w-[400px] md:w-[600px] h-auto py-9 z-20 object-contain" src="{{ asset('images/hero-right.png') }}" alt="">


  </div>
  <div class="slide hidden px-4 flex flex-col md:flex-row justify-between items-center h-full relative">

    <img class="hidden md:block h-full absolute left-0 top-0 z-0 object-cover" src="{{ asset('images/hero-left.png') }}" alt="">

    <div class="w-full md:w-[43%] flex flex-col gap-5 items-center md:items-start justify-center z-10 text-center md:text-left mt-10 md:mt-0">
      <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold text-white">
        Сливочное масло теперь по выгодной цене
      </h1>
      <p class="text-lg sm:text-xl md:text-2xl text-white">
        Закажите сейчас и получите скидку! Торопитесь предложение ограничено!
      </p>
    </div>

    <img class="w-full sm:w-[400px] md:w-[600px] h-auto py-9 z-20 object-contain" src="{{ asset('images/burger.jpeg') }}" alt="">


  </div>

  <div class="dots mt-8 absolute top-6/7 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20 flex gap-2">
    <div class="dot  w-4 h-4 bg-transparent border active rounded-full"></div>
    <div class="dot w-4 h-4 bg-transparent border rounded-full"></div>
  </div>


  </div>
  </div>






</section>

<script>
  const slides = document.querySelectorAll(".slide")
  const dots = document.querySelectorAll(".dot")
  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("hidden", i !== index)
      dots[i].classList.toggle("active", i === index)
    });
  }

 function nextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  showSlide(currentIndex);
}

  setInterval(nextSlide, 2000)
  dots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
      currentIndex = index
      showSlide(currentIndex)

    })


  });
  showSlide(currentIndex);

</script>