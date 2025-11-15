<div class="mx-auto px-24 py-6">
    <a href="/list" class="flex justify-between items-center ">
        <h3 class="mt-5 text-2xl font-bold">Предложения</h3>
        <div class="text-md font-bold text-gray-400 hover:underline">See more</div>
    </a>

    <div class="cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mt-6">
        @foreach($products as $product)
            <div
                class="card openModal relative bg-white rounded-3xl p-4 flex flex-col items-center text-center shadow-md hover:shadow-lg transition duration-300 hover:cursor-pointer hover:bg-orange-100 "
                data-id="{{ $product['code'] }}"
                data-title="{{ $product['name'] ?? $product['name_alt_a'] }}"
                data-price="{{ $product['price_unit'] }}"
                data-price-box="{{ $product['price_box'] }}"

                data-min-quantity="{{ $product['type_1_count'] }}"
                data-per-box="{{ $product['type_2_count'] }}"
                data-per-crate="{{ $product['type_3_count'] }}"
                data-per-pallet="{{ $product['type_4_count'] }}"

                data-image="{{ $product['media'][0]['url'] ?? ''}}"
                data-images='@json($product['media'] ?? [])'
                data-description="{{ $product['description'] }}"
                data-basket="{{ Auth::user()->basket->where('product_id', $product['code'])->first() ? 1 : 0 }}"
                data-sku="{{ $product['barcode'] ?? '-' }}"
                data-content="{{ $product['weight_unit'] ?? '-' }}"
                data-unit="{{ $product['unit'] ?? '-' }}"
                data-stock-total="{{ $product['stock_total'] ?? 0 }}"
                data-stock-reserved="{{ $product['stock_reserved'] ?? 0 }}"
                data-tags='@json($product['tags'] ?? [])'
            >

                <img
                    src="{{ $product['media'][0]['url'] ?? '' }}"
                    alt="{{ $product['name'] ?? $product['name_alt_a'] }}"
                    loading="lazy"
                    class="w-25 h-25 object-contain mt-4">


                <div
                    class="absolute top-0 right-0 bg-orange-100 rounded-full w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('/images/plusbg.png') }}" alt="">
                    <span
                        class="favorite-btn cursor-pointer absolute top-1 right-3 text-orange-500 z-3 text-xl font-bold"
                        data-product-id="{{ $product['code'] }}">+</span>
                </div>
                <div class="absolute top-0 left-0 w-12 h-12 flex items-center justify-center">
                    <div class="relative w-full h-full">
                        @php
                            $matchedTag = collect($tags)->firstWhere('key', $product['sticker']);
                        @endphp
                        @if( $matchedTag && !empty($matchedTag['image']))

                            <img src="{{ asset('storage/' . $matchedTag['image']) }}"
                                 alt="{{ $matchedTag['key'] ?? 'Sticker' }}"
                                 class="w-full h-full object-contain"
                            >
                        @endif
                    </div>
                </div>

                <div class="text-start gap-3 pt-3 flex flex-col">
                    <p class="mt-2">
                        <span class="font-bold text-[#E00034] text-2xl">
                            ${{ $product['price_unit'] ?? $product['price_box'] }}
                        </span>
                        @if(false)
                            <span class="font-bold text-gray-500 text-xl ml-2 line-through">
                        ${{ $product['price_with_vat'] }}
                    </span>
                        @endif
                    </p>
                    <div class="desc font-bold text-sm mt-1">
                        {{  $product['name'] ?? $product['name_alt_a']   }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <x-modal-product-details :product="$product"/>

</div>
{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', async function () {--}}
{{--        const buttons = document.querySelectorAll('.favorite-btn');--}}
{{--        const favCountEl = document.getElementById('favoriteCount');--}}

{{--        try {--}}
{{--            const favResponse = await fetch('/favorites/list/ajax', {headers: {'Accept': 'application/json'}});--}}
{{--            const favData = await favResponse.json();--}}
{{--            const favoriteIds = favData.map(item => item.product_id);--}}

{{--            buttons.forEach(btn => {--}}
{{--                const productId = parseInt(btn.dataset.productId);--}}
{{--                if (favoriteIds.includes(productId)) {--}}
{{--                    btn.textContent = '-';--}}
{{--                }--}}
{{--            });--}}

{{--            favCountEl.textContent = favoriteIds.length;--}}
{{--        } catch (err) {--}}
{{--            console.error('Favorileri yüklerken hata:', err);--}}
{{--        }--}}

{{--        buttons.forEach(btn => {--}}
{{--            btn.addEventListener('click', async function (e) {--}}
{{--                e.stopPropagation();--}}
{{--                const productId = this.dataset.productId;--}}
{{--                const isAdding = this.textContent === '+';--}}
{{--                let favCount = parseInt(favCountEl.textContent);--}}

{{--                try {--}}
{{--                    const response = await fetch(isAdding ? `/favorites/add/${productId}` : `/favorites/delete/${productId}`, {--}}
{{--                        method: isAdding ? 'POST' : 'DELETE',--}}
{{--                        headers: {--}}
{{--                            'X-CSRF-TOKEN': '{{ csrf_token() }}',--}}
{{--                            'Accept': 'application/json',--}}
{{--                        }--}}
{{--                    });--}}

{{--                    const data = await response.json();--}}

{{--                    if (response.ok) {--}}
{{--                        this.textContent = isAdding ? '-' : '+';--}}
{{--                        favCount = isAdding ? favCount + 1 : favCount - 1;--}}
{{--                        favCountEl.textContent = favCount;--}}
{{--                    } else {--}}
{{--                        console.error(data.message || 'Error');--}}
{{--                    }--}}
{{--                } catch (error) {--}}
{{--                    console.error('Request failed:', error);--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    });--}}

{{--</script>--}}
