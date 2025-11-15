@extends('admin.dashboard.dashboard')

@section('content')
    <div class="flex justify-center py-10">
        <div class="w-full max-w-3xl bg-white shadow-2xl rounded-2xl p-8 border border-gray-100">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-extrabold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-indigo-600"></i>
                    Add New Category
                </h2>
                <a href="{{ route('category.list') }}"
                   class="text-sm text-gray-500 hover:text-indigo-600 transition">
                    ← Back to List
                </a>
            </div>

            {{-- Flash messages --}}
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

            {{-- Form --}}
            <form action="{{ route('category.add') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Parent --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Parent Category <span class="text-gray-400">(optional)</span>
                    </label>
                    <select name="parent_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                    <input type="text" name="name"
                           placeholder="e.g. Electronics"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                </div>

                {{-- Key --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Key</label>
                    <input type="text" name="key"
                           placeholder="e.g. electronics"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition">
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Image</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition">
                        <input type="file" name="image" id="imageInput"
                               class="hidden"
                               onchange="previewImage(event)">
                        <label for="imageInput" class="cursor-pointer text-indigo-600 font-medium hover:underline">
                            Click to upload image
                        </label>
                        <p class="text-xs text-gray-500 mt-2">Accepted formats: JPG, PNG, WEBP (max 2MB)</p>

                        {{-- Image preview --}}
                        <div id="imagePreview" class="mt-4 hidden">
                            <img src="#" alt="Preview" class="mx-auto h-32 rounded-lg shadow-md object-cover">
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end items-center space-x-4 pt-4">
                    <a href="{{ route('category.list') }}"
                       class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition shadow-md">
                        <i class="fa-solid fa-save mr-1"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Image Preview Script --}}
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.classList.remove('hidden');
                preview.querySelector('img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>
@endsection
