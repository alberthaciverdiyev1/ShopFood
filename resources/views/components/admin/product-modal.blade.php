@props(['id' => 'modal', 'title' => 'Product Details'])

<div id="{{ $id }}" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div
        class="bg-white w-full max-w-lg p-6 rounded-3xl shadow-2xl relative transform transition-all scale-95 opacity-0"
        x-data
        x-show="$el.classList.remove('hidden')"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
    >
        <button id="{{ $id }}Close" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-3xl font-bold transition-transform hover:scale-110">&times;</button>

        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 tracking-wide">{{ $title }}</h2>

        <div class="space-y-4 text-gray-700" id="{{ $id }}Content">
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button id="{{ $id }}Ok" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl shadow-md hover:shadow-lg transition-all">
                Close
            </button>
        </div>
    </div>
</div>
