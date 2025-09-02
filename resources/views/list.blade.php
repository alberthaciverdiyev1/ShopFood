@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">All products</h1>

    <div class="grid grid-cols-1 gap-6">
        @foreach ($products as $product)
        <div class="flex items-center bg-[#EFEFEF] rounded-lg p-4">

            {{-- Image --}}
            <div class="w-28 h-32 flex-shrink-0">
                <img src="{{ $product['image'] }}"
                    alt="{{ $product['title'] }}"
                    class="w-full h-full object-contain rounded-md">
            </div>

            {{-- Info --}}
            <div class="flex-1 ml-4 text-gray-800">
                <h2 class="font-semibold text-lg mb-2">{{ $product['title'] }}</h2>

                <div class="text-[14px] text-gray-600 leading-relaxed">
                    <p>Artikelnummer: 58709 ID: 37367</p>
                    <p>Warennummer: 090203000</p>
                    <p>Inhalt: 150 g</p>
                    <p>Im Karton: 9 Pack</p>
                    <p>Kartons auf Palette: 42</p>
                    <p>Karton/Lage: 7</p>
                </div>
            </div>

            {{-- Price & Buttons --}}
            <div class="text-right ml-4 min-w-[140px]">

                <div class="flex flex-wrap gap-2 justify-end mt-2">
                    <button class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">+1</button>
                    <button class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">+2</button>
                    <button class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">+3</button>
                    <button class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">+4</button>
                    <button class="w-8 h-8 flex items-center justify-center border border-[#FC9700] text-[#FC9700] bg-white rounded-md text-sm">+5</button>
                </div>


                <p class="text-2xl text-red-500 font-bold mt-3">
                    {{ number_format($product['price'], 2) }}
                </p>
                <div class="mt-2 text-sm text-gray-800">
                    <p><strong>Выбрано:</strong> 5</p>
                    <p><strong>Сумма:</strong> {{ number_format($product['price'] * 5, 2) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection