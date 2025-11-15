@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-full mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Settings</h2>

            {{-- Flash mesajlar --}}
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

            <form action="{{ route('setting.update') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- Whatsapp Link --}}
                    <div>
                        <label for="whatsapp_link" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Link</label>
                        <input type="url" id="whatsapp_link" name="whatsapp_link"
                               value="{{ old('whatsapp_link', $setting->whatsapp_link ?? '') }}"
                               class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                    </div>

                    {{-- Telegram Link --}}
                    <div>
                        <label for="telegram_link" class="block text-sm font-medium text-gray-700 mb-2">Telegram Link</label>
                        <input type="url" id="telegram_link" name="telegram_link"
                               value="{{ old('telegram_link', $setting->telegram_link ?? '') }}"
                               class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>

            <div class="flex flex-wrap gap-6 justify-start items-center mt-10">

                <div class="flex flex-col items-start">
                    <button id="refreshAllBtn"
                            data-url="{{ route('start-queue') }}"
                            class="px-6 py-3 bg-gradient-to-r from-orange-400 to-orange-500 text-white font-semibold rounded-xl shadow-md hover:from-orange-500 hover:to-orange-600 transition-all duration-300 flex items-center gap-2">
                        <i class="fa fa-sync-alt"></i>
                        Refresh All Products
                    </button>
                    <div id="queueResponse" class="mt-2 text-sm font-medium text-gray-700"></div>
                </div>

                {{-- Refresh Product Stocks --}}
                <div class="flex flex-col items-start">
                    <button id="refreshStocksBtn"
                            data-url="{{ route('start-stock-queue') }}"
                            class="px-6 py-3 bg-gradient-to-r from-blue-400 to-blue-500 text-white font-semibold rounded-xl shadow-md hover:from-blue-500 hover:to-blue-600 transition-all duration-300 flex items-center gap-2">
                        <i class="fa fa-boxes"></i>
                        Refresh Product Stocks
                    </button>
                    <div id="stockResponse" class="mt-2 text-sm font-medium text-gray-700"></div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const setupButton = (btnId, responseId) => {
                const btn = document.getElementById(btnId);
                const responseEl = document.getElementById(responseId);

                btn.addEventListener('click', async () => {
                    const url = btn.getAttribute('data-url');
                    btn.disabled = true;
                    const originalText = btn.innerHTML;
                    btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Processing...`;
                    responseEl.textContent = '';

                    try {
                        const response = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (data.success) {
                            responseEl.textContent = data.message;
                            responseEl.classList.remove('text-red-600');
                            responseEl.classList.add('text-green-600');
                        } else {
                            responseEl.textContent = data.message || 'Bir hata oluştu.';
                            responseEl.classList.remove('text-green-600');
                            responseEl.classList.add('text-red-600');
                        }

                        setTimeout(() => {
                            responseEl.textContent = '';
                        }, 2000);

                    } catch (err) {
                        responseEl.textContent = 'Sunucu hatası: ' + err.message;
                        responseEl.classList.remove('text-green-600');
                        responseEl.classList.add('text-red-600');

                        setTimeout(() => {
                            responseEl.textContent = '';
                        }, 2000);

                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                });
            };

            setupButton('refreshAllBtn', 'queueResponse');
            setupButton('refreshStocksBtn', 'stockResponse');
        });
    </script>
@endsection
