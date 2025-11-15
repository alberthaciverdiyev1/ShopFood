@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-full mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Banners</h2>
                <button onclick="openModal('addBannerModal')" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    + Add Banner
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Banner List --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title EN</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Subtitle EN</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title CZ</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Subtitle CZ</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">URL</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Active</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($banners as $banner)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">
                                <img src="{{ asset('storage/'.$banner->image) }}" alt="banner image" class="h-12 w-24 rounded-lg object-cover shadow">
                            </td>
                            <td class="px-6 py-3">{{ $banner->title_en }}</td>
                            <td class="px-6 py-3">{{ $banner->subtitle_en }}</td>
                            <td class="px-6 py-3">{{ $banner->title_cz }}</td>
                            <td class="px-6 py-3">{{ $banner->subtitle_cz }}</td>
                            <td class="px-6 py-3">
                                @if($banner->url)
                                    <a href="{{ $banner->url }}" target="_blank" class="text-blue-600 underline">{{ $banner->url }}</a>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center">
                                @if($banner->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <button onclick="openModal('updateBannerModal', {{ $banner->id }}, '{{ $banner->title_en }}', '{{ $banner->subtitle_en }}', '{{ $banner->url }}', {{ $banner->is_active ? 1 : 0 }})"
                                        class="px-4 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">Update</button>
                                <button onclick="openModal('deleteBannerModal', {{ $banner->id }})"
                                        class="px-4 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No banners found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Banner Modal --}}
    <div id="addBannerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Add Banner</h3>
            <form method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-2">Title (EN)</label>
                    <input type="text" name="title_en" class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Subtitle (EN)</label>
                    <input type="text" name="subtitle_en" class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Title (CZ)</label>
                    <input type="text" name="title_cz" class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Subtitle (CZ)</label>
                    <input type="text" name="subtitle_cz" class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">URL</label>
                    <input type="text" name="url" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Image</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addBannerModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Update Banner Modal --}}
    <div id="updateBannerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Update Banner</h3>
            <form id="updateBannerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm mb-2">Title (EN)</label>
                    <input type="text" id="updateTitle" name="title_en" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Subtitle (EN)</label>
                    <input type="text" id="updateSubtitle" name="subtitle_en" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Title (CZ)</label>
                    <input type="text" id="updateTitle" name="title_cz" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Subtitle (CZ)</label>
                    <input type="text" id="updateSubtitle" name="subtitle_cz" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">URL</label>
                    <input type="text" id="updateURL" name="url" class="w-full border rounded px-3 py-2">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Image</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('updateBannerModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Banner Modal --}}
    <div id="deleteBannerModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4 text-red-600">Delete Banner</h3>
            <p class="mb-6 text-gray-700">Are you sure you want to delete this banner?</p>
            <form id="deleteBannerForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('deleteBannerModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, bannerId = null, title = '', subtitle = '', url = '', isActive = 1) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');

            if(id === 'updateBannerModal') {
                document.getElementById('updateTitle').value = title;
                document.getElementById('updateSubtitle').value = subtitle;
                document.getElementById('updateURL').value = url;
                document.getElementById('updateBannerForm').action = `/banners/${bannerId}`;
            }

            if(id === 'deleteBannerModal' && bannerId) {
                document.getElementById('deleteBannerForm').action = `/banners/${bannerId}`;
            }
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
@endsection
