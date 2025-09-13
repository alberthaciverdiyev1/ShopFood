@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-5xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Exchange Rates</h2>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Currency</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Rate</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($rates as $rate)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $rate->currency }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ number_format($rate->rate, 2) }}</td>
                            <td class="px-6 py-3 text-center">
                                <button onclick="openUpdateModal({{ $rate->id }}, '{{ $rate->currency }}', '{{ $rate->rate }}')"
                                        class="px-4 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                    Update
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No exchange rates found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Update Modal --}}
    <div id="updateRateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Update Exchange Rate</h3>
            <form id="updateRateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm mb-2">Currency</label>
                    <input type="text" id="updateCurrency" name="currency" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Rate</label>
                    <input type="number" step="0.01" id="updateRate" name="rate" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUpdateModal(id, currency, rate) {
            const modal = document.getElementById('updateRateModal');
            modal.classList.remove('hidden');

            document.getElementById('updateCurrency').value = currency;
            document.getElementById('updateRate').value = rate;
            document.getElementById('updateRateForm').action = `/exchange-rates/${id}`;
        }

        function closeUpdateModal() {
            document.getElementById('updateRateModal').classList.add('hidden');
        }
    </script>
@endsection
