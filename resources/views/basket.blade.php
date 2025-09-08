@extends('layouts.app')
@section('content')

    <div class="container mx-auto px-4 py-8 ">
        <h2 class="text-2xl font-bold">Basket</h2>
        <div class="flex gap-8 mt-4">

            <!-- Ürün Listesi -->
            <div class="w-[68%] border border-[#999999] p-4 rounded-2xl">
                <h3 class="text-[#331111] font-semibold text-xl">Your products</h3>
                @foreach ($basket as $index => $item['product'])
                    <div class="flex gap-4 justify-between items-center pb-4 mb-4"
                         data-product-id="{{ $item['product']['product']['id'] }}"
                         data-product-price="{{ $item['product']['product']['cenaZaklVcDph'] }}">

                        <div class="flex gap-4 items-center">
                            <label>{{$index+1}}</label>
{{--                            <div class="checkbox-wrapper-23">--}}
{{--                                <input type="checkbox" id="check-23-{{ $index }}" />--}}
{{--                                <label for="check-23-{{ $index }}" style="--size: 30px">--}}
{{--                                    <svg viewBox="0,0,50,50"><path d="M5 30 L 20 45 L 45 5"></path></svg>--}}
{{--                                </label>--}}
{{--                            </div>--}}

                            <img src="{{ $item['product']['product']['images'][0] }}"
                                 alt="{{ $item['product']['product']['nazev'] }}"
                                 class="w-24 h-24 object-contain mt-4">

                            <div>
                                <h3 class="font-bold text-lg">{{ $item['product']['product']['nazev'] }}</h3>
                                <p class="text-gray-600">Some description about the product. It is very good and useful.</p>
                                <p class="text-red-500 font-bold mt-2">${{ $item['product']['product']['cenaZaklVcDph'] }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-center">
                            <div class="counter-wrapper border border-[#FAD399] px-2 py-2 bg-white rounded-xl flex items-center gap-4">
                                <button class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg minus-btn">−</button>
                                <span class="counter-value font-bold">{{ $item['product']['quantity'] }}</span>
                                <button class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg plus-btn">+</button>
                            </div>

                            <div class="bg-white px-2 py-2 rounded-xl border border-[#FAD399]">
                                <img class="remove-btn w-6 h-6" src="{{ asset('/images/trash.png') }}" alt="">
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Sepet Özeti -->
            <div class="w-[30%]">
                <div class="bg-white px-6 py-6 rounded-2xl border border-gray-50">
                    <h2 class="text-xl font-semibold text-[#4b1c0d] mb-4">Сумма заказа</h2>

                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Число товаров:</span>
                            <span class="text-gray-500 basket-total-quantity">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Общая стоимость:</span>
                            <span class="basket-total-price">0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Скидка на товары:</span>
                            <span>0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Налоги и сборы:</span>
                            <span>0.00</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <select name="address" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
                            <option>Адрес</option>
                            <option value="Baku - Nizami 12">Baku - Nizami 12</option>
                            <option value="Baku - 28 May">Baku - 28 May</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <select name="payment" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label>Note to admin</label>
                        <textarea name="note_to_admin" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">

                        </textarea>
                    </div>


                    <hr class="my-4 text-gray-100">

                    <div class="flex justify-between text-lg font-semibold">
                        <span>Всего</span>
                        <span class="basket-grand-total">0.00</span>
                    </div>

                    <button id="createOrder" class="mt-5 w-full py-3 rounded-full border border-orange-400 text-[#331111] font-medium hover:bg-orange-50 transition">
                        Оформить заказ
                    </button>
                </div>
            </div>

        </div>

        <x-suggestions :products="$products" />
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const totalQuantityEl = document.querySelector('.basket-total-quantity');
            const totalPriceEl = document.querySelector('.basket-total-price');
            const grandTotalEl = document.querySelector('.basket-grand-total');

            function recalcBasket() {
                let totalQuantity = 0;
                let totalPrice = 0;

                document.querySelectorAll('.flex[data-product-id]').forEach(item => {
                    const quantity = parseInt(item.querySelector('.counter-value').textContent);
                    const price = parseFloat(item.dataset.productPrice);
                    totalQuantity += quantity;
                    totalPrice += quantity * price;
                });

                const discount = 0;
                const taxes = 0;
                const grandTotal = totalPrice - discount + taxes;

                totalQuantityEl.textContent = totalQuantity;
                totalPriceEl.textContent = totalPrice.toFixed(2);
                grandTotalEl.textContent = grandTotal.toFixed(2);
            }

            document.querySelectorAll('.flex[data-product-id]').forEach(item => {
                const productId = item.dataset.productId;
                const minusBtn = item.querySelector('.minus-btn');
                const plusBtn = item.querySelector('.plus-btn');
                const counterValue = item.querySelector('.counter-value');
                const removeBtn = item.querySelector('.remove-btn');

                plusBtn.addEventListener('click', function () {
                    updateQuantity(productId, 1, counterValue, item);
                });

                minusBtn.addEventListener('click', function () {
                    if(counterValue.textContent <= 1) return;
                    updateQuantity(productId, -1, counterValue, item);
                });

                removeBtn.addEventListener('click', function () {
                    fetch(`/basket/remove/${productId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                item.remove();
                                recalcBasket();
                            }
                        });
                });
            });

            function updateQuantity(productId, increment, counterValue, item) {
                fetch(`/basket/update/${productId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ increment })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.deleted) {
                                item.remove();
                            } else {
                                counterValue.textContent = data.quantity;
                            }
                            recalcBasket();
                        }
                    });
            }

            recalcBasket();
        });


        document.getElementById('createOrder').addEventListener('click', function () {
            const items = [];

            document.querySelectorAll('.flex[data-product-id]').forEach(item => {
                const productId = item.dataset.productId;
                const quantity = parseInt(item.querySelector('.counter-value').textContent);

                items.push({
                    product_id: parseInt(productId),
                    quantity: quantity
                });
            });

            if (items.length === 0) {
                alert('Basket is empty!');
                return;
            }

            // Address və payment seçimini götür
            const addressSelect = document.querySelector('select[name="address"]');
            const paymentSelect = document.querySelector('select[name="payment"]');
            const noteToAdmin = document.querySelector('textarea[name="note_to_admin"]').value;

            const address = addressSelect ? addressSelect.value : null;
            const payment = paymentSelect ? paymentSelect.value : null;


            if (!address || address === "Адрес") {
                alert("Lütfən, address seçin!");
                return;
            }

            if (!payment) {
                alert("Lütfən, ödəniş üsulu seçin!");
                return;
            }

            fetch('/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    items,
                    address,
                    payment,
                    noteToAdmin
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success === 200) {
                        alert('Order created successfully!');
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error creating order.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Request failed.');
                });
        });


    </script>

@endsection
