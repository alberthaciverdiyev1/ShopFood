<div class="mx-auto px-4 py-6">
    <h3 class="mt-5 text-2xl font-bold">Предложения</h3>
    <div class="cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-6">
        @foreach($products as $product)
        <div class="card relative bg-white rounded-3xl p-4 flex flex-col items-center text-center shadow-md hover:shadow-lg transition duration-300">
            <div class="absolute top-3 right-3 bg-orange-100 rounded-full w-8 h-8 flex items-center justify-center">
                <span class="text-orange-500 text-xl font-bold">+</span>
            </div>

            <img src="{{ $product['images'][0] ?? $product['image'] }}" alt="{{ $product['title'] }}" class="w-24 h-24 object-contain mt-4">

            <p class="price font-bold text-red-600 text-lg mt-2">
                ${{ $product['price'] }}
            </p>

            <div class="desc text-sm mt-1">
                {{ $product['title'] }}
            </div>
        </div>
        @endforeach
    </div>
</div>

