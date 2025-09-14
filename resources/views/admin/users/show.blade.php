@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-full mx-auto py-10">
        <div class="bg-white shadow-lg rounded-xl p-6">

            {{-- User Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 border-b pb-4">
                <h2 class="text-3xl font-bold text-gray-800">User Details</h2>
                <span class="text-sm text-gray-500">ID: {{ $user->id }}</span>
            </div>

            {{-- User Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-sm">Name</p>
                    <p class="text-lg font-semibold">{{ $user->contact_name }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-sm">Email</p>
                    <p class="text-lg font-semibold">{{ $user->email }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-sm">Registered</p>
                    <p class="text-lg font-semibold">{{ $user->created_at->format('Y-m-d') }}</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-sm">Status</p>
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
                </div>
            </div>

            {{-- Orders --}}
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Orders</h3>
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Order ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Payment</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($user->orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-800">#{{ $order->order_number }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @switch($order->status)
                                        @case('pending') bg-orange-100 text-orange-700 @break
                                        @case('processing') bg-blue-100 text-blue-700 @break
                                        @case('shipped') bg-yellow-100 text-yellow-700 @break
                                        @case('delivered') bg-green-100 text-green-700 @break
                                        @case('cancelled') bg-red-100 text-red-700 @break
                                        @default bg-gray-100 text-gray-700
                                    @endswitch">
                                    {{ ucfirst($order->status ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded-md bg-gray-100 text-gray-700 text-sm">
                                    {{ ucfirst($order->payment_method ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
