@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">User Details</h2>

            <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Name:</strong> {{ $user->name }}</div>
                <div><strong>Email:</strong> {{ $user->email }}</div>
                <div><strong>Registered:</strong> {{ $user->created_at->format('Y-m-d') }}</div>
                <div><strong>Status:</strong> {{ $user->is_active ? 'Active' : 'Inactive' }}</div>
            </div>

            <h3 class="text-xl font-semibold mb-4">Orders</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Order ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach($user->orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $order->id }}</td>
                            <td class="px-6 py-3">{{ $order->status ?? 'N/A' }}</td>
                            <td class="px-6 py-3">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
