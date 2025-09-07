@extends('layouts.app')
@section('content')

<div class="container mx-auto px-4 py-8 ">
  <h2 class="text-2xl font-bold">Basket</h2>
  <div class="flex gap-8 mt-4">
    <div class="w-[68%] border border-[#999999] p-4 rounded-2xl">
      <h3 class="text-[#331111] font-semibold  text-xl ">Your products</h3>

     @foreach ($products as $index => $product)

      <div class="flex gap-4 justify-between items-center  pb-4 mb-4">

        <div class="flex gap-4 items-center">
          <!-- <input class="custom-checkbox" type="checkbox" name="" id=""> -->

          <div class="checkbox-wrapper-23">
            <input type="checkbox" id="check-23-{{ $index }}" />
            <label for="check-23-{{ $index }}" style="--size: 30px">
              <svg viewBox="0,0,50,50">
                <path d="M5 30 L 20 45 L 45 5"></path>
              </svg>
            </label>
          </div>
          <img src="{{ $product['images'][0] ?? $product['image'] }}" alt="{{ $product['nazev'] }}" class="w-24 h-24 object-contain mt-4">
          <div class="">
            <h3 class="font-bold text-lg">{{ $product['nazev'] }}</h3>
            <p class="text-gray-600">Some description about the product. It is very good and useful.</p>
            <p class="text-red-500  font-bold mt-2">${{ $product['cenaZaklVcDph'] }}</p>
          </div>
        </div>
        <div class="flex gap-4 items-center">
          <div class="counter-wrapper border border-[#FAD399] px-2 py-2 bg-white rounded-xl flex items-center gap-4  ">
            <button class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg">−</button>



            <span class="counter-value font-bold">2</span>
            <button class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg">+</button>

          </div>

          <div class="bg-white px-2 py-2 rounded-xl border border-[#FAD399] ">
            <img class="w-6 h-6 " src="{{ asset('/images/trash.png') }}" alt="">
          </div>

        </div>


      </div>



      @endforeach

    </div>
    <div class="w-[30%]">
      <div class="bg-white px-6 py-6 rounded-2xl border border-gray-50 ">
        <h2 class="text-xl font-semibold text-[#4b1c0d] mb-4">Сумма заказа</h2>

        <div class="space-y-2 text-sm text-gray-700">
          <div class="flex justify-between">
            <span>Число товаров:</span>
            <span class="text-gray-500">Товары не выбраны</span>
          </div>
          <div class="flex justify-between">
            <span>Общая стоимость:</span>
            <span>0</span>
          </div>
          <div class="flex justify-between">
            <span>Скидка на товары:</span>
            <span>0</span>
          </div>
          <div class="flex justify-between">
            <span>Налоги и сборы:</span>
            <span>0</span>
          </div>
        </div>

        <div class="mt-4">
          <select class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
            <option>Адрес</option>
          </select>
        </div>

        <hr class="my-4 text-gray-100">

        <div class="flex justify-between text-lg font-semibold">
          <span>Всего</span>
          <span>0</span>
        </div>

        <button
          class="mt-5 w-full py-3 rounded-full border border-orange-400 text-[#331111] font-medium hover:bg-orange-50 transition">
          Оформить заказ
        </button>
      </div>
    </div>

  </div>
  <x-suggestions :products="$products" />

</div>

@endsection
