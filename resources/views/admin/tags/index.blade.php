@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            {{-- Başlık ve Ekle Butonu --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Tags</h2>
                <button
                    onclick="openModal('addTagModal')"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition"
                >
                    + Add Tag
                </button>
            </div>

            {{-- Flash mesajlar --}}
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

            {{-- Tag List --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($tags as $tag)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">
                                <img src="{{ asset('storage/'.$tag->image) }}" alt="tag image"
                                     class="h-12 w-12 rounded-lg object-cover shadow">
                            </td>
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $tag->key }}</td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <button
                                    onclick="openModal('updateTagModal', {{ $tag->id }}, '{{ $tag->key }}')"
                                    class="px-4 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition"
                                >
                                    Update
                                </button>
                                <button
                                    onclick="openModal('deleteTagModal', {{ $tag->id }})"
                                    class="px-4 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No tags found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add Tag Modal --}}
    <div id="addTagModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Add Tag</h3>
            <form method="POST" action="{{ route('tags.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm mb-2">Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-indigo-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Image</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('addTagModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Update Tag Modal --}}
    <div id="updateTagModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4">Update Tag</h3>
            <form id="updateTagForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm mb-2">Name</label>
                    <input type="text" id="updateTagName" name="name" class="w-full border rounded px-3 py-2 focus:ring focus:ring-yellow-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-2">Image</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('updateTagModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Tag Modal --}}
    <div id="deleteTagModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4 text-red-600">Delete Tag</h3>
            <p class="mb-6 text-gray-700">Are you sure you want to delete this tag?</p>
            <form id="deleteTagForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('deleteTagModal')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function openModal(id, tagId = null, name = '') {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');

            if (id === 'updateTagModal') {
                document.getElementById('updateTagName').value = name;
                document.getElementById('updateTagForm').action = `/tags/${tagId}`;
            }

            if (id === 'deleteTagModal') {
                document.getElementById('deleteTagForm').action = `/tags/${tagId}`;
            }
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
@endsection
