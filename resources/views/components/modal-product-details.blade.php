<!-- Overlay və modal -->
<div id="overlay" class="fixed inset-0 bg-black/50 z-20 flex items-center justify-center hidden">
    <div id="modal" class=" bg-[#EFEFEF] fixed w-[900px] mx-auto
            top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
            rounded-3xl shadow-2xl flex gap-10 p-8 z-30">

        <!-- Left side - Image -->
        <div class="w-[45%] flex flex-col items-center">
            <div class="relative">
                <img id="modalImage" class=" bg-white px-5 py-8 rounded-xl w-130 h-90"
                     src="{{ asset('/images/product.png') }}" alt="">
                <!-- Arrows -->
                <button
                    class="absolute left-[10px] top-1/2 -translate-y-1/2 bg-gray-300 rounded-full shadow px-2 py-0.5">
                    &lt;
                </button>
                <button
                    class="absolute right-[10px] top-1/2 -translate-y-1/2 bg-gray-300 rounded-full shadow px-2 py-0.5">
                    &gt;
                </button>
            </div>
            <!-- Thumbnails -->
            <div id="modalThumbs" class="flex gap-3 mt-4">
                <img class="w-20 h-20 rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
                <img class="w-20 h-20  rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
                <img class="w-20 h-20  rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
            </div>
        </div>

        <!-- Right side - Info -->
        <div class="w-[55%] flex flex-col gap-6">
            <!-- Title -->
            <h3 id="modalTitle" class="text-lg font-semibold">Zelený čaj s příchutí jahod a broskev "Tess Flirt" 25 x
                1,5 g</h3>
            <input type="hidden" id="modalProductId" value="">
            <!-- Price -->
            <p id="modalPrice" class="text-red-500 text-3xl font-bold">29,87</p>

            <!-- Description -->
            <p id="modalDescription" data-in-basket="{{Auth::user()->basket->where('product_id', $product['id'])->first() ? 1 : 0 }}" class="text-sm text-gray-700 leading-6">
                Тесс форест дрим. Чай черный байховый с ежевикой, малиной и ароматом лесных ягод...
            </p>

            <!-- Count buttons -->
            <div class="flex gap-3 mt-3">
                <button
                    class="countBtn px-3 py-1 bg-white border-[#FC9700] border rounded-md hover:bg-gray- text-[#FC9700]"
                    data-count="1">+1
                </button>
                <button
                    class="countBtn px-3 bg-white py-1 border border-[#FC9700] rounded-md hover:bg-gray-200 text-[#FC9700]"
                    data-count="2">+2
                </button>
                <button
                    class="countBtn px-3 bg-white py-1 border border-[#FC9700] rounded-md hover:bg-gray-200 text-[#FC9700]"
                    data-count="3">+3
                </button>
                <button
                    class="countBtn px-3 bg-white py-1 border border-[#FC9700] rounded-md hover:bg-gray-200 text-[#FC9700]"
                    data-count="4">+4
                </button>
                <button
                    class="countBtn px-3 bg-white py-1 border border-[#FC9700] rounded-md hover:bg-gray-200 text-[#FC9700]"
                    data-count="5">+5
                </button>
            </div>

            <!-- Selected and Total -->
            <div class="flex gap-8 text-lg font-semibold mt-2">
                <p>Выбрано: <span id="modalSelected" class="font-bold">5</span></p>
                <p>Сумма: <span id="modalTotal" class="font-bold">149,35</span></p>
            </div>

            <!-- Add to cart + favorite -->
            <div class="flex items-center gap-4 mt-4">
                <button id="addBasket" class="flex-1 py-3 border rounded-2xl bg-white hover:bg-gray-100 text-center">
                    Добавить в корзину
                </button>
                <button class="p-3 border text-[#FC9700] rounded-2xl bg-white hover:bg-gray-100">
                    <i class="fa fa-heart text-[#FC9700] "></i>
                </button>
            </div>
        </div>
    </div>
</div>
