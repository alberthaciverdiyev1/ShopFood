@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="#">
                @csrf
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Policy Content
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        rows="10"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >{{ $policy->content }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- CKEditor 5 Classic build --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            ClassicEditor
                .create(document.querySelector('#content'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'blockQuote', 'insertTable', 'undo', 'redo'
                    ]
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
