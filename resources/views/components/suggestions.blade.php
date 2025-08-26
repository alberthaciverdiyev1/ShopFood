<div class="mx-auto px-4 py-6">
    <a href="/list" class="flex justify-between items-center ">
        <h3 class="mt-5 text-2xl font-bold">Предложения</h3>
        <div class="text-md font-bold text-gray-400 hover:underline
    ">See more </div>
    </a>
    <div id="" class="cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-6">
        @foreach(array_slice($products,0,6) as $product)



        <div
            class="card openModal relative bg-white rounded-3xl p-4 flex flex-col items-center text-center shadow-md hover:shadow-lg transition duration-300"
            data-id="{{ $product['id'] }}"
            data-title="{{ $product['title'] }}"
            data-price="{{ $product['price'] }}"
            data-image="{{ $product['images'][0] ?? $product['image'] }}"
            data-description="{{ $product['description'] }}">


            <img src="{{ $product['images'][0] ?? $product['image'] }}" alt="{{ $product['title'] }}" class="w-25 h-25 object-contain mt-4">

            <div class="absolute top-0 right-0 bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center">
                <img src="{{ asset('/images/plusbg.png') }}" alt="">
                <span class=" absolute top-1 right-3 text-orange-500 z-3 text-xl font-bold">+</span>
            </div>
            <div class="text-start gap-3 pt-3 flex flex-col">
                <p class="price font-bold text-[#E00034] text-2xl mt-2">
                    ${{ $product['price'] }}
                </p>
                <div class="desc font-bold text-sm mt-1">
                    {{ $product['title'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>



    <x-modal-product-details />
</div>