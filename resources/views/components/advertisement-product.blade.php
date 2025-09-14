<div class="mx-auto px-24 py-6">
    <h3 class="mt-5 text-2xl font-bold">Advertisement Products</h3>
    <div class="cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-6">
        @foreach(array_slice($products, 0, 6) as $product)
            <div
                class="card relative bg-white rounded-xl p-4 flex flex-col items-center text-center shadow-md hover:shadow-lg transition duration-300">
                <div
                    class="absolute top-0 right-0 bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('/images/plusbg.png') }}" alt="">
                    <span class=" absolute top-1 right-3 text-orange-500 z-3 text-xl font-bold">+</span>
                </div>
                <div class="absolute top-0 left-0 w-12 h-12 flex items-center justify-center">
                    <div class="relative w-full h-full">
                        <img src="{{ asset('/images/procentred.png') }}" alt="" class="w-full h-full">
                        <img src="{{ asset('/images/percent.png')}}" alt="" class="absolute inset-0 w-1/2 h-1/2 m-auto">
                    </div>
                </div>

                <img src="{{ $product['images'][0] ?? $product['image'] }}" alt="{{ $product['nazev'] }}"
                     class="w-24 h-24 object-contain mt-4">

                <div class="text-start gap-3 pt-3 flex flex-col">
                    <p class="mt-2">
                        <span class="font-bold text-[#E00034] text-2xl">
                            ${{ $product['discounted_price'] ?? $product['cenaZaklVcDph'] }}
                        </span>
                        @if(!empty($product['discounted_price']) || true)
                            <span class="font-bold text-gray-500 text-xl ml-2 line-through">
                        ${{ $product['cenaZaklVcDph'] }}
                    </span>
                        @endif
                    </p>


                    <div class="desc font-bold  text-sm mt-1">
                        {{ $product['nazev'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
