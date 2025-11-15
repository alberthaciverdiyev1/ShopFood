@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-2xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-bold mb-6">Edit Category</h2>
            <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Parent Category (optional)</label>
                    <select name="parent_id" class="w-full border rounded px-3 py-2">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $cat->id == $category->parent_id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ $category->name }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Key</label>
                    <input type="text" name="key" value="{{ $category->key }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2">
                    @if($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" class="w-24 h-24 mt-2 rounded object-cover">
                    @endif
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('category.list') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
