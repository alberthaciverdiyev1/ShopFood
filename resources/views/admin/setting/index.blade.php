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
        </div>
    </div>
@endsection
