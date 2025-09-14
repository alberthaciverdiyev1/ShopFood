<div class="mx-auto px-24 py-6">
    <a href="/list" class="flex justify-between items-center ">
        <h3 class="mt-5 text-2xl font-bold">Предложения</h3>
        <div class="text-md font-bold text-gray-400 hover:underline">See more</div>
    </a>

    <div class="cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-6">
        @foreach($products as $product)
            <div
                class="card openModal relative bg-white rounded-3xl p-4 flex flex-col items-center text-center shadow-md hover:shadow-lg transition duration-300"
                data-id="{{ $product['id'] }}"
                data-title="{{ $product['nazev'] }}"
                data-price="{{ $product['cenaZaklVcDph'] }}"
                data-image="{{ $product['images'][0]}}"
                data-description="{{ $product['description'] }}"
                data-basket="{{Auth::user()->basket->where('product_id', $product['id'])->first() ? 1 : 0 }}"
            >

                <img src="{{ $product['images'][0]}}"
                     alt="{{ $product['nazev'] }}"
                     class="w-25 h-25 object-contain mt-4">

                <div
                    class="absolute top-0 right-0 bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('/images/plusbg.png') }}" alt="">
                    <span
                        class="favorite-btn cursor-pointer absolute top-1 right-3 text-orange-500 z-3 text-xl font-bold"
                        data-product-id="{{ $product['id'] }}">+</span>
                </div>
                <div class="absolute top-0 left-0 w-12 h-12 flex items-center justify-center">
                    <div class="relative w-full h-full">
                        <img src="{{ asset('/images/procentred.png') }}" alt="" class="w-full h-full">
                        <img src="{{ asset('/images/percent.png')}}" alt="" class="absolute inset-0 w-1/2 h-1/2 m-auto">
                    </div>
                </div>
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
                    <div class="desc font-bold text-sm mt-1">
                        {{ $product['nazev'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <x-modal-product-details  :product="$product"/>
</div>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const buttons = document.querySelectorAll('.favorite-btn');
        const favCountEl = document.getElementById('favoriteCount');

        try {
            const favResponse = await fetch('/favorites/list/ajax', {headers: {'Accept': 'application/json'}});
            const favData = await favResponse.json();
            const favoriteIds = favData.map(item => item.product_id);

            buttons.forEach(btn => {
                const productId = parseInt(btn.dataset.productId);
                if (favoriteIds.includes(productId)) {
                    btn.textContent = '-';
                }
            });

            favCountEl.textContent = favoriteIds.length;
        } catch (err) {
            console.error('Favorileri yüklerken hata:', err);
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', async function (e) {
                e.stopPropagation();
                const productId = this.dataset.productId;
                const isAdding = this.textContent === '+';
                let favCount = parseInt(favCountEl.textContent);

                try {
                    const response = await fetch(isAdding ? `/favorites/add/${productId}` : `/favorites/delete/${productId}`, {
                        method: isAdding ? 'POST' : 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    });

                    const data = await response.json();

                    if (response.ok) {
                        this.textContent = isAdding ? '-' : '+';
                        favCount = isAdding ? favCount + 1 : favCount - 1;
                        favCountEl.textContent = favCount;
                    } else {
                        console.error(data.message || 'Error');
                    }
                } catch (error) {
                    console.error('Request failed:', error);
                }
            });
        });
    });

</script>
