<button id="openModal" class="px-4 py-2 bg-blue-500 text-white rounded">
  Open Modal
</button>

<!-- Overlay və modal -->
<div id="overlay" class="fixed inset-0 bg-black/50 z-20 flex items-center justify-center hidden">
 <div id="modal" class=" bg-[#EFEFEF] fixed w-[900px] mx-auto 
            top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
            rounded-3xl shadow-2xl flex gap-10 p-8 z-30">

    <!-- Left side - Image -->
    <div class="w-[45%] flex flex-col items-center">
        <div class="relative">
            <img class="rounded-xl w-150 h-100" src="{{ asset('/images/product.png') }}" alt="">
            <!-- Arrows -->
            <button class="absolute left-[10px] top-1/2 -translate-y-1/2 bg-gray-300 rounded-full shadow px-2 py-0.5">&lt;</button>
            <button class="absolute right-[10px] top-1/2 -translate-y-1/2 bg-gray-300 rounded-full shadow px-2 py-0.5">&gt;</button>
        </div>
        <!-- Thumbnails -->
        <div class="flex gap-3 mt-4">
            <img class="w-20 h-20 rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
            <img class="w-20 h-20  rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
            <img class="w-20 h-20  rounded-xl cursor-pointer" src="{{ asset('/images/product.png') }}" alt="">
        </div>
    </div>

    <!-- Right side - Info -->
    <div class="w-[55%] flex flex-col gap-4">
        <!-- Title -->
        <h3 class="text-lg font-semibold">Zelený čaj s příchutí jahod a broskev "Tess Flirt" 25 x 1,5 g</h3>

        <!-- Price -->
        <p class="text-red-500 text-3xl font-bold">29,87</p>

        <!-- Description -->
        <p class="text-sm text-gray-700 leading-6">
            Тесс форест дрим. Чай черный байховый с ежевикой, малиной и ароматом лесных ягод в пакетиках разовой заварки.
            Чудесная композиция благородного цейлонского чая с кусочками ежевики и малины открывает новый великолепный вкус,
            в котором слышится благоухание ягодной опушки согретой июльским солнцем.
            Состав: Чай черный байховый цейлонский, натуральный ароматизатор лесные ягоды,
            шиповник, лист черной смородины, гибискус, ежевика, малина
        </p>

        <!-- Count buttons -->
        <div class="flex gap-3 mt-3">
            <button class="px-3 py-1 bg-white border-[#FC9700] border rounded-lg hover:bg-gray- text-[#FC9700]">+1</button>
            <button class="px-3 bg-white py-1 border border-[#FC9700] rounded-lg hover:bg-gray-200 text-[#FC9700]">+2</button>
            <button class="px-3 bg-white py-1 border border-[#FC9700] rounded-lg hover:bg-gray-200 text-[#FC9700]">+3</button>
            <button class="px-3 bg-white py-1 border border-[#FC9700] rounded-lg hover:bg-gray-200 text-[#FC9700]">+4</button>
            <button class="px-3 bg-white py-1 border border-[#FC9700] rounded-lg hover:bg-gray-200 text-[#FC9700]">+5</button>
        </div>

        <!-- Selected and Total -->
        <div class="flex gap-8 text-lg font-semibold mt-2">
            <p>Выбрано: <span class="font-bold">5</span></p>
            <p>Сумма: <span class="font-bold">149,35</span></p>
        </div>

        <!-- Add to cart + favorite -->
        <div class="flex items-center gap-4 mt-4">
            <button class="flex-1 py-3 border rounded-2xl bg-white hover:bg-gray-100 text-center">
                Добавить в корзину
            </button>
            <button class="p-3 border text-[#FC9700] rounded-2xl bg-white hover:bg-gray-100">
                <i class="fa fa-heart text-[#FC9700] "></i>
            </button>
        </div>
    </div>
</div>
</div>