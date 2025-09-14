<section class="hero-gradient relative h-screen overflow-hidden">

    <div id="bannerWrapper" class="relative h-full w-full">
        @forelse($banners as $index => $banner)
            <div class="banner-slide absolute inset-0 flex flex-col md:flex-row justify-between items-center px-4 transition-all duration-500"
                 style="transform: translateX({{ $index * 100 }}%)">

                <img class="hidden md:block h-full absolute left-0 top-0 z-0 object-cover"
                     src="{{ asset('images/hero-left.png') }}" alt="">

                <div class="w-full md:w-[43%] flex flex-col gap-5 items-center md:items-start justify-center z-10 text-center md:text-left mt-10 md:mt-0 ml-12">
                    <h1 class="text-white"
                        style="font-family: 'Roboto', sans-serif; font-weight: 400; font-style: normal; font-size: 64px; line-height: 117%; letter-spacing: 0;">
                        {{ $banner->title }}
                    </h1>
                    @if(!empty($banner->subtitle))
                        <p class="text-white"
                           style="font-family: 'Roboto', sans-serif; font-weight: 400; font-style: normal; font-size: 24px; line-height: 117%; letter-spacing: 0;">
                            {{ $banner->subtitle }}
                        </p>
                    @endif
                    @if(!empty($banner->url))
                        <a href="{{ $banner->url }}" target="_blank"
                           class="mt-3 px-5 py-2 bg-[#F6A833] text-white rounded hover:bg-[#947D5B] transition">
                            Learn More
                        </a>
                    @endif
                </div>

                {{-- Banner Görsel --}}
                <img class="w-full sm:w-[400px] md:w-[600px] h-auto py-9 z-20 object-contain mr-12"
                     src="{{ asset('storage/'.$banner->image) }}" alt="">
            </div>
        @empty
            <div class="banner-slide absolute inset-0 flex flex-col md:flex-row justify-between items-center px-4">
                <h1 class="text-white">No banners found</h1>
            </div>
        @endforelse
    </div>

    <div class="dots absolute bottom-10 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
        @foreach($banners as $index => $banner)
            <div class="dot w-4 h-4 border rounded-full cursor-pointer" data-index="{{ $index }}"></div>
        @endforeach
    </div>

</section>

<script>
    const slides = document.querySelectorAll('.banner-slide');
    const dots = document.querySelectorAll('.dot');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.transform = `translateX(${(i - index) * 100}%)`;
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('border-white', i === index);
            dot.classList.toggle('bg-transparent', i !== index);
        });
    }

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            currentIndex = parseInt(dot.dataset.index);
            showSlide(currentIndex);
        });
    });

    let startX = 0;
    let endX = 0;
    const wrapper = document.getElementById('bannerWrapper');

    wrapper.addEventListener('touchstart', e => startX = e.touches[0].clientX);
    wrapper.addEventListener('touchmove', e => endX = e.touches[0].clientX);
    wrapper.addEventListener('touchend', () => {
        if (startX - endX > 50) {
            currentIndex = (currentIndex + 1) % slides.length;
        } else if (startX - endX < -50) {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        }
        showSlide(currentIndex);
    });

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 3000);

    showSlide(currentIndex);
</script>
