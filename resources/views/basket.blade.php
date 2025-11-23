@extends('layouts.app')
@section('content')

    <div class="container mx-auto px-4 py-8 ">
        <h2 class="text-2xl font-bold">@lang('Basket')</h2>
        <div class="flex gap-8 mt-4">

            <div class="w-[68%] border border-[#999999] p-4 rounded-2xl">
                @php($total_price = 0)
                @forelse ($basket as $index => $item['product'])
                    <div class="flex gap-4 justify-between items-center pb-4 mb-4"
                         data-product-id="{{ $item['product']['product']['code'] }}"
                         data-product-quantity="{{ $item['product']['quantity'] }}"
                         data-product-price="{{ $item['product']['product']['price_unit'] }}">

                        <div class="flex gap-4 items-center">
                            <label>{{$index+1}}</label>
                            <img src="{{ $item['product']['product']['media'][0]['url'] ?? '' }}"
                                 alt="{{ app()->getLocale() === 'en' ? ($item['product']['product']['name_alt_a'] ?? $item['product']['product']['name']) : $item['product']['product']['name'] }}"
                                 class="w-24 h-24 object-contain mt-4">

                            <div>
                                <h3 class="font-bold text-lg">{{ app()->getLocale() === 'en' ? ($item['product']['product']['name_alt_a'] ?? $item['product']['product']['name']) : $item['product']['product']['name'] }}</h3>
                                {{-- <p class="text-gray-600">Some description about the product. It is very good and useful.</p> --}}
                                <p class="font-bold mt-2">
                                    <span class="text-red-500">${{$item['product']['type'] === 'box' ? $item['product']['product']['price_box'] : $item['product']['product']['price_unit'] }} </span>
                                    /
                                    ${{ ($item['product']['type'] === 'box' ? $item['product']['product']['price_box'] : $item['product']['product']['price_unit']) * $item['product']['quantity'] }}

                                    <button class="rounded-lg px-2 py-1 ml-2 text-xs bg-[#fad399]">
                                        {{ $item['product']['type']  }}  {{ $item['product']['type'] === 'box' ? '('.$item['product']['box_items_count'] .')' :""  }}
                                    </button>
                                </p>
                                @php($total_price += $item['product']['product']['price_unit'] * $item['product']['quantity'])
                            </div>
                        </div>

                        <div class="flex gap-4 items-center">
                            <div
                                class="counter-wrapper border border-[#FAD399] px-2 py-2 bg-white rounded-xl flex items-center gap-4">
                                <button
                                    class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg minus-btn">
                                    −
                                </button>
                                <span class="counter-value font-bold">{{ $item['product']['quantity'] }}</span>
                                <button
                                    class="counter-btn bg-[#FAD399] text-white border border-[#FAD399] w-6 h-6 rounded-full flex items-center justify-center text-lg plus-btn">
                                    +
                                </button>
                            </div>

                            <div class="bg-white px-2 py-2 rounded-xl border border-red-500">
                                <img class="remove-btn w-6 h-6" src="{{ asset('/images/trash.png') }}" alt="">
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="flex justify-center items-center py-20 mt-16">
                        <img src="{{ asset('/images/Empty-Cart.png') }}" alt="Empty Basket"
                             class="w-52 h-52 opacity-50">
                    </div>
                @endforelse
            </div>


            <div class="w-[30%]">
                <div class="bg-white px-6 py-6 rounded-2xl border border-gray-50">
                        <h2 class="text-xl font-semibold text-[#4b1c0d] mb-4">@lang("Order amount")</h2>

                    <div class="space-y-2 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>@lang("Number of goods"):</span>
                            <span class="text-gray-500 basket-total-quantity">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>@lang("Total cost"):</span>
                            <span class="basket-total-price">0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>@lang("Discount on goods"):</span>
                            <span>0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>@lang("Taxes and fees"):</span>
                            <span>0.00</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" id="selfDelivery" class="form-checkbox h-5 w-5 text-gray-600">
                            <span class="text-gray-700">@lang('I will take')</span>
                        </label>
                    </div>

                    <div class="mt-4" id="addressSelect">
                        <select name="address"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
                            <option value="">@lang('Address')</option>
                            @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" {{ $addr->is_default ? 'selected' : '' }}>
                                    {{ $addr->title ?? '' }} - {{ $addr->street ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <select name="payment"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">
                            <option value="cash">@lang("Cash")</option>
                            <option value="card">@lang("Card")</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label>@lang("Note to admin")</label>
                        <textarea name="note_to_admin"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-gray-400">

                        </textarea>
                    </div>


                    <hr class="my-4 text-gray-100">

                    <div class="flex justify-between text-lg font-semibold">
                        <span>@lang("Total")</span>
                        <span class="basket-grand-total">{{number_format($total_price,2,'.')}}</span>
                    </div>

                    <button id="createOrder"
                            class="mt-5 w-full py-3 rounded-full border border-orange-400 text-[#331111] font-medium hover:bg-orange-50 transition">
                        @lang('Buy Now')
                    </button>
                </div>
            </div>

        </div>

        <x-suggestions :products="$products" :tags="$tags"/>
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
                    // const quantity = parseInt(item.querySelector('.counter-value').textContent);
                    const quantity = parseInt(item.dataset.productQuantity);
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
                    if (counterValue.textContent <= 1) return;
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
                    body: JSON.stringify({increment})
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
            const selfDelivery = document.getElementById('selfDelivery').checked;
            const items = [];

            document.querySelectorAll('.flex[data-product-id]').forEach(item => {
                const productId = item.dataset.productId;
                //  const quantity = parseInt(item.querySelector('.counter-value').textContent);
                const quantity = parseInt(item.dataset.productQuantity);


                items.push({
                    product_id: parseInt(productId),
                    quantity: quantity
                });
            });

            if (items.length === 0) {
                alert('@lang("Basket is empty")');
                return;
            }

            const addressSelect = document.querySelector('select[name="address"]');
            const paymentSelect = document.querySelector('select[name="payment"]');
            const noteToAdmin = document.querySelector('textarea[name="note_to_admin"]').value;

            const address = addressSelect ? addressSelect.value : null;
            const payment = paymentSelect ? paymentSelect.value : null;

            if ((!address || address === "Адрес") && !selfDelivery) {
                alert('@lang("Select address")');
                return;
            }

            if (!payment) {
                alert('@lang("Select payment method")');
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
                    noteToAdmin,
                    selfDelivery: selfDelivery
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success === 200) {
                        alert('@lang("Order created successfully!")');
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const selfDelivery = document.getElementById("selfDelivery");
            const addressSelect = document.getElementById("addressSelect");

            function toggleAddress() {
                if (selfDelivery.checked) {
                    addressSelect.style.display = "none";
                } else {
                    addressSelect.style.display = "block";
                }
            }

            toggleAddress();

            selfDelivery.addEventListener("change", toggleAddress);
        });
    </script>

@endsection

@section('scripts')
    @vite('resources/js/home.js')
@endsection
