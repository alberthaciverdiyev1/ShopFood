@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-full mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Categories & Subcategories</h2>
                <a href="{{ route('category.create') }}"
                   class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    + Add Category
                </a>
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

            {{-- Category List --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Key</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Parent</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">
                                <img src="{{ asset('storage/'.$category->image) }}" alt="category image"
                                     class="h-12 w-12 rounded-lg object-cover shadow">
                            </td>
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $category->name }}</td>
                            <td class="px-6 py-3 text-gray-800 font-medium">{{ $category->key }}</td>
                            <td class="px-6 py-3 text-gray-600">
                                {{ $category->parent ? $category->parent->name : '-' }}
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="{{ route('category.edit', $category->id) }}"
                                   class="px-4 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <button
                                    onclick="openDeleteModal({{ $category->id }})"
                                    class="px-4 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        {{-- Alt Kategoriler --}}
                        @foreach($category->children as $child)
                            <tr class="bg-gray-50">
                                <td class="px-6 py-3 pl-10">
                                    <img src="{{ asset('storage/'.$child->image) }}" alt="subcategory image"
                                         class="h-10 w-10 rounded-lg object-cover shadow">
                                </td>
                                <td class="px-6 py-3 text-gray-700 font-medium">↳ {{ $child->name }}</td>
                                <td class="px-6 py-3 text-gray-700 font-medium">{{ $child->key }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $category->name }}</td>
                                <td class="px-6 py-3 text-center space-x-2">
                                    <a href="{{ route('category.edit', $child->id) }}"
                                       class="px-4 py-1.5 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <button
                                        onclick="openDeleteModal({{ $child->id }})"
                                        class="px-4 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No categories found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-lg rounded-xl shadow-2xl p-8 text-center">
            <div class="text-4xl mb-4 text-red-600">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-2xl font-bold mb-3 text-gray-800">Delete Category</h3>
            <p class="mb-6 text-gray-600">
                Are you sure you want to delete this category?
                <br><span class="text-sm text-gray-500">(All its subcategories will be deleted too.)</span>
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-4">
                    <button type="button"
                            onclick="closeDeleteModal()"
                            class="px-6 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Yes, Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(id) {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            document.getElementById('deleteForm').action = "{{ url('admin/category') }}/" + id;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
