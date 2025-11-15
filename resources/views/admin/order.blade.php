@extends('admin.dashboard.dashboard')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Orders</h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Order #</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Total Price</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Items</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold text-gray-800">
                            {{ $order['order_number'] }}
                        </td>
                        <td class="px-4 py-3">
                            <select class="status-select border rounded px-2 py-1 text-sm"
                                    data-order-id="{{ $order['order_id'] }}">
                                @php
                                    $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'];
                                @endphp
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}"
                                        {{ $order['status'] === $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-4 py-3">
                            {{ $order['total_price'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-3">
                                @foreach($order['items'] as $item)
                                    <div class="flex items-center gap-2 bg-gray-100 px-2 py-1 rounded-lg">
                                        <img src="{{ $item['product']['media'][0]['url'] ?? '' }}"
                                             alt="{{ $item['product']['name'] ?? '' }}"
                                             class="w-10 h-10 object-cover rounded">
                                        <span class="text-sm">
                                            {{ $item['product']['name'] ?? '' }}
                                            <span class="text-gray-500">(x{{ $item['quantity'] }})</span>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order['order_id']) }}"
                               class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
                                Details
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function applyStatusColor(select) {
                select.classList.remove(
                    "bg-orange-500", "bg-blue-500", "bg-yellow-500",
                    "bg-green-500", "bg-red-500", "bg-purple-500",
                    "text-white"
                );

                switch (select.value) {
                    case "pending":
                        select.classList.add("bg-orange-500", "text-white");
                        break;
                    case "processing":
                        select.classList.add("bg-blue-500", "text-white");
                        break;
                    case "shipped":
                        select.classList.add("bg-yellow-500", "text-white");
                        break;
                    case "delivered":
                        select.classList.add("bg-green-500", "text-white");
                        break;
                    case "cancelled":
                        select.classList.add("bg-red-500", "text-white");
                        break;
                    case "returned":
                        select.classList.add("bg-purple-500", "text-white");
                        break;
                }
            }

            document.querySelectorAll(".status-select").forEach(select => {
                applyStatusColor(select);

                select.addEventListener("change", function () {
                    const orderId = this.dataset.orderId;
                    const status = this.value;

                    applyStatusColor(this);

                    fetch(`/admin/order/${orderId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({ status }),
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success === 200) {
                                alert("✅ Order status updated: " + status);
                            } else {
                                alert("❌ Error updating order.");
                            }
                        })
                        .catch(() => alert("❌ Network error."));
                });
            });
        });
    </script>
@endsection
