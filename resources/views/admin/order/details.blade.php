@extends('admin.dashboard.dashboard')

@section('content')
    <div class="p-6 space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Order {{ $order->order_number }}</h2>
            <span class="text-gray-500 text-sm">Created at: {{ $order->created_at->format('Y-m-d H:i') }}</span>
        </div>

        {{-- User Info --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold text-lg mb-3 border-b pb-2"> User Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <p><strong>Name:</strong> {{ $order->user->name ?? $order->user->contact_name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Phone:</strong> {{ $order->user->contact_phone ?? '-' }}</p>
            </div>
        </div>

        {{-- Address --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold text-lg mb-3 border-b pb-2">Shipping Address</h3>
            @if(!$order->self_delivery)
            <p class="text-gray-700">{{ $order->address->street }}, {{ $order->address->city }}</p>
            <p class="text-gray-700">{{ $order->address->zip }}</p>
            <p class="text-gray-500 text-sm">Working Hours: {{ $order->address->working_hours }}</p>
            @else
            <p class="text-gray-700">User take it</p>
            @endif
        </div>

        {{-- Warehousea --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold text-lg mb-3 border-b pb-2">Warehouse Code</h3>
                <p class="text-gray-700">{{ $order->warehouse_code }}</p>
        </div>

        {{-- Items --}}
        <div class="bg-white shadow rounded-xl p-5">
            <h3 class="font-semibold text-lg mb-3 border-b pb-2">Order Items</h3>
            <div class="divide-y">
                @foreach($order->items as $item)
                    @php $product = $item->product; @endphp
                    @if($product)
                        <div class="flex items-center gap-4 py-4">
                            <img src="{{ $product['media'][0]['url'] ?? '' }}"
                                 alt="{{ $product['name'] ?? $product['name_alt_a'] }}"
                                 class="w-20 h-20 object-cover rounded-lg border">
                            <div class="flex-1">
                                <p class="font-semibold text-md">{{ $product['name'] ?? $product['name_alt_a'] }}</p>
                                <p class="text-gray-500 text-sm">Quantity: x{{ $item->quantity }}</p>
                                <p class="text-gray-500 text-sm">Price: {{ $item->price }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold">{{ $item['total'] ?? '-' }} $</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Notes --}}
        @if(!empty($order->note_to_admin))
            <div class="bg-white shadow rounded-xl p-5">
                <h3 class="font-semibold text-lg mb-3 border-b pb-2">Note to Admin</h3>
                <p class="text-gray-700">{{ $order->note_to_admin }}</p>
            </div>
        @endif

        {{-- Total & Status --}}
        <div class="bg-white shadow rounded-xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div>
                <h3 class="font-semibold text-lg">Total Price</h3>
                <p class="text-2xl font-bold mt-1">{{ $order->total_price ?? '-' }} $</p>
            </div>

            <div>
                <h3 class="font-semibold text-lg">Status</h3>
                <select id="orderStatus" class="status-select border rounded px-3 py-2 mt-1" data-order-id="{{ $order->id }}">
                    @php
                        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'];
                    @endphp
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const statusSelect = document.getElementById('orderStatus');

            function applyStatusColor(select) {
                select.classList.remove("bg-orange-500","bg-blue-500","bg-yellow-500","bg-green-500","bg-red-500","bg-purple-500","text-white");
                switch(select.value) {
                    case "pending": select.classList.add("bg-orange-500","text-white"); break;
                    case "processing": select.classList.add("bg-blue-500","text-white"); break;
                    case "shipped": select.classList.add("bg-yellow-500","text-white"); break;
                    case "delivered": select.classList.add("bg-green-500","text-white"); break;
                    case "cancelled": select.classList.add("bg-red-500","text-white"); break;
                    case "returned": select.classList.add("bg-purple-500","text-white"); break;
                }
            }

            applyStatusColor(statusSelect);

            statusSelect.addEventListener("change", function() {
                const orderId = this.dataset.orderId;
                const status = this.value;

                applyStatusColor(this);

                fetch(`/admin/order/${orderId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ status })
                })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success === 200) {
                            alert("✅ Order status updated: " + status);
                        } else {
                            alert("❌ Error updating order.");
                        }
                    })
                    .catch(() => alert("❌ Network error."));
            });
        });
    </script>
@endsection
